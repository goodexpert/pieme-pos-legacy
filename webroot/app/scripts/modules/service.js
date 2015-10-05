'use strict';

/**
 * @ngdoc function
 * @name OnzsaApp.module:LocalStorage
 *
 * @description
 * Register sharedService module of the OnzsaApp
 */
angular.module('OnzsaApp.register', [])

.constant('registerConfig', {
  debug: true,
  statusCheckInterval:       5000,   // 5sec
  syncSaleDataInterval:     60000,   // 1min
  syncUpdateDataInterval:  300000,   // 5min
})

.factory('Register', [
           '$rootScope', '$cookies', '$q',
           '$http', '$interval', '$timeout',
           'LocalStorage', 'registerConfig',
  function ($rootScope, $cookies, $q,
            $http, $interval, $timeout,
            LocalStorage, registerConfig) {

    // AngularJS will instantiate a singleton by calling "new" on this function
    var sharedService = {};

  // The variables specified to the service globally.
  var ds = Datastore_sqlite;
  var quickKeyLayout = [];
  var onlineStatus = 'offline';
  var statusCheckInterval = registerConfig.statusCheckInterval;
  var syncSaleDataInterval = registerConfig.syncSaleDataInterval;
  var syncUpdateDataInterval = registerConfig.syncUpdateDataInterval;
  var saleItems = [];
  var registerSale = {
    'note': '',
    'receipt_number': 1,
    'line_discount_type': 0,      // line discount type (0: percent, 1: currency)
    'line_discount': 0.0,         // line discount number
    'total_cost': 0.0,            // supply_price
    'total_price': 0.0,           // price_exclude_tax(supply_price * markup)
    'total_price_incl_tax': 0.0,  // retail_price(price + tax)
    'total_discount': 0.0,
    'total_tax': 0.0,             // price * tax_rate
    'total_payment': 0.0,         // Paid amount
    'sequence': 0
  };
  var customerInfo = {
    'id': null,
    'customer_group_id': null,
    'customer_code': null,
    'name': null,
    'balance': 0.0,
    'loyalty_balance': 0.0
  };

  // Defines sharedService
  sharedService.init = function() {
    debug('Register: init register');

    return _bootstrapSystem();
  };

  sharedService.inOnline = function() {
    debug('Register: check the network connectivity');

    return _isOnline();
  }

  sharedService.openRegister = function(register) {
    debug('Register: open existing or new register');
    return _openRegister(register);
  };

  sharedService.closeRegister = function() {
    debug('Register: close register');
    return _closeRegister(LocalStorage.getRegister());
  };

  sharedService.openSale = function() {
    debug('Register: open new or existing sale');
  };

  sharedService.closeSale = function() {
    debug('Register: close sale');
  };

  sharedService.donePaymentSale = function(registerSaleTotal, payments) {
    debug('Register: payment done sale');
    _updateRegisterSaleTotal(registerSaleTotal);
    _saveRegisterSalePayment(payments);

    // get RegisterSales
    var saleID = LocalStorage.getSaleID();
    var condition = { 'id' : saleID }
    var suc = function(rs) {
      if (rs.length > 0) {
        var status = rs[0]["status"];

        switch (status) {
          case 'sale_status_layby':
            _endRegisterSale("sale_status_layby_closed")
            break;
          case 'sale_status_onaccount':
            _endRegisterSale("sale_status_onaccount_closed")
            break;
          case 'sale_status_open':
            _endRegisterSale("sale_status_closed")
            break;
        }
      }
    }
    ds.getRegisterSales(condition, suc);
  };

  sharedService.onAccountSale = function(registerSaleTotal, payments) {
    debug('Register: on account sale');
    _updateRegisterSaleTotal(registerSaleTotal);
    _saveRegisterSalePayment(payments);
    _endRegisterSale("sale_status_onaccount");
  };

  sharedService.laybySale = function(registerSaleTotal, payments) {
    debug('Register: layby sale');
    _updateRegisterSaleTotal(registerSaleTotal);
    _saveRegisterSalePayment(payments);
    _endRegisterSale("sale_status_layby");
  };

  sharedService.parkSale = function(note) {
    debug('Register: park sale');
    _endRegisterSale("sale_status_saved", note);
  };

  sharedService.refundSale = function() {
    debug('Register: refund sale');
  };

  sharedService.voidSale = function() {
    debug('Register: void sale');
    _endRegisterSale("sale_status_voided")
  };

  sharedService.getRegisterSaleTotal = function() {
    debug('Register: retrieve register sale total');
    return angular.copy(registerSale);
  };

  sharedService.getCurrentSaleItems = function() {
    debug('Register: retrieve current sale items');
    return angular.copy(saleItems);
  };

  sharedService.getQuickKeyLayout = function() {
    debug('Register: retrieve quick key layout');
    return quickKeyLayout;
  };

  sharedService.getRegisterPaymentTypes = function() {
    debug('Register: retrieve register payment types');
    return _getRegisterPaymentTypes();
  };

  sharedService.addLineItem = function(saleItem) {
    debug('Register: add line item');

    var saleID = _newRegisterSale();
    saleItem.sequence = registerSale.sequence++;
    saleItems.unshift(saleItem);
    _recalcurateRegisterSaleTotal();

    _saveRegisterSaleItems([saleItem], saleID);
    _updateRegisterSale(saleID);

    $rootScope.$broadcast('saleItems.added');
  };

  sharedService.createLineItem = function() {
    debug('Register: create line item');

    var defer = $q.defer();
    var config = LocalStorage.getConfig();
    var defDiscItemID = config.discount_product_id;
    if (defDiscItemID == null) {
      defer.reject('discount_product_id is null');
      return defer.promise
    }
    _getProduct(function(rs) {
      if (rs.length == 0) {
        defer.reject('product not found');
        return defer.promise
      }
      var product = rs[0];
      var uuid = _getUUID();
      var saleItem = {};
      saleItem.id = uuid;
      saleItem.product_id = defDiscItemID;
      saleItem.name = product.name;
      saleItem.supply_price = product.supply_price;
      saleItem.price = product.price;
      saleItem.sale_price = product.price;
      saleItem.tax = product.tax;
      saleItem.tax_rate = product.tax_rate;
      saleItem.discount = 0;
      saleItem.quantity = 1;
      saleItem.loyalty_value = 0;
      saleItem.sequence = -1;
      saleItem.status = "sale_item_status_valid";

      defer.resolve(saleItem);
    },  defDiscItemID); //Get Product

    return defer.promise;
  };

  sharedService.addSaleItem = function(product_id) {
    debug('Register: add sale item');
    return _addSaleItem(product_id);
  };

  sharedService.removeSaleItem = function(sequence) {
    debug('Register: remove sale item : ' + sequence);

    // Get Sale Item
    var saleItem = _getSaleItemBySequence(sequence);

    // Delete Sale Item from List
    _deleteSaleItemBySequence(sequence);

    // Delete from RegisterSaleItems
    var saleID = LocalStorage.getSaleID();
    _deleteRegisterSaleItem(saleItem, saleID);

    // Recalcurate Total
    _recalcurateRegisterSaleTotal();

    // If list to be empty, Delete RegisterSale
    if (saleItems.length == 0) {
      _endRegisterSale("sale_status_voided");
    } else {
      _updateRegisterSale(saleID);

      $rootScope.$broadcast('saleItems.removed');
    }
  };

  sharedService.updateSaleItem = function(newItem) {
    debug('Register: update sale item');
    _updateSaleItem(newItem)
        .then(function(){
          // Finished add process
          $rootScope.$broadcast('saleItems.updated');
        });
  };

  sharedService.reloadRegisterSale = function(saleId) {
    debug('Register: reload register sale');
    return angular.copy(_reloadSale(saleId));
  };

  sharedService.getRegisterSaleItems = function(saleID, status, suc, err) {
    debug('Register: retrieve sale items');
    return angular.copy(_getRegisterSaleItems(saleID, status, suc, err));
  };

  sharedService.getRegisterSaleItemBySequence = function(sequence) {
    return angular.copy(_getSaleItemBySequence(sequence));
  };

  sharedService.openDrawer = function() {
    debug('Register: open cash drawer');
  };

  sharedService.switchRegister = function(register) {
    debug('Register: switchRegister');
    return _checkOpenedRegister(register);
  };

  sharedService.updateLineDiscount = function(discount, type) {
    debug('Register: updateLineDiscount');
    _updateLineDiscount(discount, type);
  }

  sharedService.setCustomerInfo = function(info) {
    debug('Register: setCustomerInfo');
    _setCustomerInfo(info);
  }

  sharedService.clearCustomerInfo = function() {
    debug('Register: clearCustomerInfo');
    _setCustomerInfo(null);
  }

  sharedService.getCustomerInfo = function() {
    debug('Register: getCustomerInfo');
    var info = {};
    info.id                = customerInfo.id;
    info.customer_group_id = customerInfo.customer_group_id;
    info.customer_code     = customerInfo.customer_code;
    info.name              = customerInfo.name;
    info.balance           = customerInfo.balance;
    info.loyalty_balance   = customerInfo.loyalty_balance;
    return info;
  }

  sharedService.isSelectedCustomer = function() {
    return _isSelectedCustomer();
  }

  sharedService.createNewPayment = function(paymentId, paymentTypeId, paymentName, amount) {
    var saleID = LocalStorage.getSaleID();
    var registerId = LocalStorage.getRegisterID();
    var payment = [];
    payment.id = _getUUID();
    payment.sale_id = saleID;
    payment.register_id = registerId;
    payment.name = paymentName;
    payment.payment_type_id = paymentTypeId;
    payment.merchant_payment_type_id = paymentId;
    payment.amount = amount;
    payment.payment_date = _getUnixTimestamp();
    return payment;
  }


  sharedService.getRegisterSalesByRegisterID = function(register_id, sale_date) {
    debug('Register: retrieve Register sales by Register ID');
    return _getRegisterSalesByRegisterID(register_id, _getUnixTimestamp(new Date(sale_date)));
  };

  sharedService.getRegisterSalePayments = function(saleID, index) {
    debug('Register: retrieve Register sales by Register ID');
    return _getRegisterSalePayments(saleID, index);
  };

  // --------------------------
  // _addSaleItemUomEa
  // --------------------------
  function _addSaleItemPriceBook(saleID, saleProduct) {
    debug('Register: _addSaleItemUomEa');

    var priceBook = null;
    var lastestSaleItem = null;
    var saleItem = null;
    var productQty = 1;

    if (saleProduct.product_uom == 'product_uom_ea' || saleProduct.product_uom == null) {
      lastestSaleItem = _getLastestSaleItem();
      if (lastestSaleItem && lastestSaleItem.product_id == saleProduct.id) {
        productQty = lastestSaleItem.quantity + 1;
      }
    }

    // Get PriceBook by ProductID and quantity
    var config = LocalStorage.getConfig();
    var outlet_id = config.outlet_id;
    var customer_group_id = config.default_customer_group_id;
    if (_isSelectedCustomer()) {
      customer_group_id = customerInfo.customer_group_id;
    }

    _getPriceBook(function (rs) {
      if (rs.length > 0) {
        priceBook = rs[0];
        if (saleProduct.product_uom == 'product_uom_ea' || saleProduct.product_uom == null) {
          if (productQty == 1) {
            _addRegisterSaleItem(saleID, saleProduct, priceBook);
          } else {
            _additionSellItemQty(saleID, lastestSaleItem, saleProduct, priceBook, productQty);
          }
        } else {
          _addRegisterSaleItem(saleID, saleProduct, priceBook);
        }
      } else {
        debug("Not found PriceBook : " + saleProduct.id);
      }
    }, saleProduct.id, outlet_id, productQty, customer_group_id);  //Get PriceBook
  };

  // --------------------------
  // _addSaleItemSub
  // --------------------------
  function _addSaleItemSub(saleID, saleItem) {
    debug('Register: _addSaleItemSub');

    if (saleItem. productQty > 1 &&
        (saleItem.product_uom == 'product_uom_ea' || saleItem.product_uom == null)) {
      _recalcurateRegisterSaleTotal();
      _updateRegisterSaleItems(saleItem, saleID, "sale_item_status_valid");
    } else  {
      _recalcurateRegisterSaleTotal();
      _saveRegisterSaleItems([saleItem], saleID);
    }

    _updateRegisterSale(saleID);
    $rootScope.$broadcast('saleItems.added');
  };

  // --------------------------
  // _addSaleItem
  // --------------------------
  function _addSaleItem(product_id) {
    debug('Register: _addSaleItem');
    var saleProduct = null;

    // If first addition for sale, make RegisterSaleID
    var saleID = _newRegisterSale();

    // Get Product by ProductId
    _getProduct(function (rs) {
      if (rs.length > 0) {
        saleProduct = rs[0];
        _addSaleItemPriceBook(saleID, saleProduct);
      } else {
        debug("Not found Product : " + product_id);
      }
    }, product_id); //Get Product

  };

  function _updateLineDiscount(discount, type) {
    debug('Register: updateLineDiscount');
    var discountValue = 0;
    var saleID = LocalStorage.getSaleID();

    //TODO: del end of debug
    console.groupCollapsed("@ Line Discount");
    console.group("@ old value");
    console.debug("@ total_price_incl_tax : %f", registerSale.total_price_incl_tax);
    console.debug("@ total_discount       : %f", registerSale.total_discount);
    console.debug("@ line_discount        : %f", registerSale.line_discount);
    console.debug("@ line_discount_type   : %d", registerSale.line_discount_type);
    console.groupEnd("");

    // save value
    registerSale.line_discount = discount;
    registerSale.line_discount_type = type;
    _recalcurateRegisterSaleTotal();

    // saver register sales
    _saveRegisterSales(saleID, "sale_status_open");

    //TODO: del end of debug
    console.group("@ New value");
    console.debug("@ total_price_incl_tax : %f", registerSale.total_price_incl_tax);
    console.debug("@ total_discount       : %f", registerSale.total_discount);
    console.debug("@ line_discount        : %f", registerSale.line_discount);
    console.debug("@ line_discount_type   : %d", registerSale.line_discount_type);
    console.groupEnd();
    console.groupEnd();

    $rootScope.$broadcast('saleItems.updated');
  };

  // --------------------------
  // bootstrapSystem
  // --------------------------
  function _bootstrapSystem() {
    debug("Register: do bootstrapSystem");
    $interval(_updateNetworkConnectivity, statusCheckInterval);
    $interval(_syncSaleData, syncSaleDataInterval);
    $interval(_syncUpdateData, syncUpdateDataInterval);

    return _checkNetworkConnectivity()
        .then(function(response) {
          onlineStatus = 'online';
          return _receiveSessionUser()
        })
        .then(function(userInfo){
          return _checkInitDatastore(userInfo);
        })
        .then(function(){
          return _receiveProducts();
        })
        .then(function(){
          return _receivePaymentTypes();
        })
        .then(function(){
          return _receiveTaxes();
        })
        .then(function(){
          return _checkRegisterID();
        })

        .then(function(result){
              if (result.status == "selected") {
                return _checkOpenedRegister(result.register);
              } else if (result.status == "waitRegister") {
                var deferred = $q.defer();
                deferred.resolve(result);
                return deferred.promise;
              }
            }
            , function(response) {
              onlineStatus = 'offline';
              return _instantBootstrapSystem();
            });
  }

  // --------------------------
  // bootstrapSystem - Register open check routine
  // --------------------------
  function _checkOpenedRegister(register) {
    //console.debug("Register: do checking register open");
    //$rootScope.loadingMessage = "Check open status for register.";
    $rootScope.$broadcast('loading.progress', {msg:'Check open status for register.'});

    return _isOpenedRegister(register)
        .then(function(result){
              if (result.opened == true) {
                return _subBootstrapSystem(result.data);
              } else {
                var deferred = $q.defer();
                deferred.resolve(result);
                return deferred.promise;
              }
            }
            , function(response) {
              debug(response);
              onlineStatus = 'offline';
              return _instantBootstrapSystem();
            });

  }

  // --------------------------
  // bootstrapSystem - 2nd routine
  // --------------------------
  function _subBootstrapSystem(register) {
    debug("Register: do sub BootstrapSystem");

    return _switchRegister(register)
        .then(function(regsterId){
          return _receivePriceBooks(regsterId);
        })
        .then(function(){
          return _receiveConfig();
        })
        .then(function() {
              var deferred = $q.defer();
              var result = [];

              _newRegisterSale();
              _reloadSale();

              result["status"] = "initialized";
              deferred.resolve(result);
              $rootScope.$broadcast('register.ready');
              return deferred.promise;
            }
            , function(response) {
              onlineStatus = 'offline';
              return _instantBootstrapSystem();
            });
  }

  // --------------------------
  // bootstrapSystem - offline routine
  // --------------------------
  function _instantBootstrapSystem() {
    debug("Register: do instant BootstrapSystem");
    //$rootScope.loadingMessage = "Setup offline mode.";
    $rootScope.$broadcast('loading.progress', {msg:'Setup offline mode.'});

    var deferred = $q.defer();
    var result = [];

    var register = LocalStorage.getRegister();
    if (register == null) {
      result["status"] = "noneRegister";
      deferred.reject(result);
      $rootScope.$broadcast('register.failed');
      return deferred.promise;
    }
    quickKeyLayout = JSON.parse(register["quick_keys_template"]["key_layouts"]);
    quickKeyLayout = quickKeyLayout["quick_keys"];
    $rootScope.$broadcast('quickkey.ready');

    if (_isValidateDataStore() != true) {
      result["status"] = "unvaliedDataStore";
      deferred.reject(result);
      $rootScope.$broadcast('register.failed');
      return deferred.promise;
    }
    _newRegisterSale();
    _reloadSale();

    result["status"] = "initialized";
    deferred.resolve(result);
    $rootScope.$broadcast('register.ready');
    return deferred.promise;
  }

  //TODO: check Local Data store
  function _isValidateDataStore() {
    return true;
  }

  function _isOnline() {
    return onlineStatus;
  }

  function _checkNetworkConnectivity() {
    //debug("REQUEST: ping...");
    if (window.navigator.onLine == true) {  //TODO: check for mobile
      return $http.get('/api/ping.json');
    } else {
      var defer = $q.defer();
      defer.reject();
      return defer.promise;
    }
  }

  function _updateNetworkConnectivity() {
    _checkNetworkConnectivity()
        .then(function(response) {
          onlineStatus = 'online';
          //debug('status : ' + onlineStatus);
        }, function(response) {
          onlineStatus = 'offline';
          //debug('status : ' + onlineStatus);
        });
  }

  //
  // Update PaymentTypes, Products, Taxes
  //
  function _syncUpdateData() {
    if (_isOnline() == 'offline') {
      debug("[SYNC DATA] Respite sync (offline)");
      return;
    }
    debug("[SYNC DATA] sync start ");
    _receiveProducts()
        .then(function () {
          return _receivePaymentTypes();
        })
        .then(function () {
          return _receiveTaxes();
        })
        .then(function () {
          debug("[SYNC DATA] sync completed");
        });
  }

  function _getSyncRS() {
    var defer = $q.defer();
    var sucRS;
    //TODO: get sync time
    var syncTime = 1441345000.0; // _getUnixTimestamp() - 1000; // "1441345831.0"
    var data = {
      'sync':'date',
      'sale_date': syncTime
    }
    sucRS = function(rsRS) {
      defer.resolve(rsRS);
    }
    ds.getRegisterSales(data, sucRS);
    return defer.promise;
  }

  function _getSyncRSI(saleID, index) {
    var defer = $q.defer();
    var sucRSI, data;
    var response = [];
    data = {
      'sale_id':saleID
    };
    sucRSI = function(rsRSI) {
      response.data = rsRSI;
      response.index = index;
      defer.resolve(response);
    }
    ds.getRegisterSaleItems(data, sucRSI);
    return defer.promise;
  }

  function _getSyncRSP(saleID, index) {
    var defer = $q.defer();
    var sucRSP, data;
    var response = [];
    data = {
      'sale_id':saleID
    };
    sucRSP = function(rsRSP) {
      response.data = rsRSP;
      response.index = index;
      defer.resolve(response);
    }
    ds.getRegisterSalePayments(data, sucRSP);
    return defer.promise;
  }

  //
  // Sync local data to server
  //
  function _syncSaleData() {
    var data = {};
    if (_isOnline() == 'offline') {
      debug("[SYNC SALE] Respite sync (offline)");
      return;
    }

    _getSyncRS()
        .then(function(RS) {
          //console.debug("[SYNC SALE] RS count : %d", RS.length);
          var defer = $q.defer();
          var promise = [];
          data = (RS);
          for (var i=0; i<RS.length; i++) {
            var rsID = RS[i].id;

            promise.push( _getSyncRSI(rsID, i)
                    .then(function(response) {
                      //console.debug("[SYNC SALE] RSI count : %d", response.length);
                      if (response.data.length > 0) {
                        data[response.index]['items'] = (response.data);
                      }
                    })
            );

            promise.push( _getSyncRSP(rsID, i)
                    .then(function(response) {
                      //console.debug("[SYNC SALE] RSP count : %d", response.length);
                      if (response.data.length > 0) {
                        data[response.index]['payments'] = (response.data);
                      }
                    })
            );
          }
          $q.all(promise).then(function() { defer.resolve(data)} );
          return defer.promise;
        })
        .then(function(RS) {
          if (RS.length > 0) {
            debug("[SYNC SALE] sync request >>>>>>>>>>");
            debug(RS);

            $.ajax({
              url: "/api/upload_register_sales.json",
              type: "POST",
              data: {
                syncData: RS,
              },
              success: function (result) {
                debug("[SYNC SALE] sync success response <<<<<<<<<<");
                debug(result);
                var now = _getUnixTimestamp();
                for (var idx in result.ids) {
                  var syncData = {
                    'id': result.ids[idx],
                    'sync_status': 'sync_success',
                    'sync_date': now
                  }
                  ds.changeRegisterSales(syncData);
                }
              }
            });
          } else {
            debug("[SYNC SALE] already done.");
          }
        });
  }

  // --------------------------
  // Update register sale item price
  // --------------------------
  function _updateSaleItem(newItem) {
    var defer = $q.defer();
    var config = LocalStorage.getConfig();
    var outlet_id = config.outlet_id;
    var customer_group_id = config.default_customer_group_id;
    if (_isSelectedCustomer()) {
      customer_group_id = customerInfo.customer_group_id;
    }

    var saleID = LocalStorage.getSaleID();
    var discProcId = config.discount_product_id;

    var idx = _getSaleItemIndexBySequence(newItem.sequence);
    var oldItem = saleItems[idx];
    var suc = function (rs) {
      if (rs.length > 0) {
        var priceBook = rs[0];

        if (discProcId != oldItem.product_id) {
          _recalcSellItem(oldItem, newItem, priceBook);
        }
        saleItems[idx] = newItem;
        _recalcurateRegisterSaleTotal();
        _updateRegisterSaleItems(newItem, saleID, newItem.status);
      }
      defer.resolve(saleItems[idx]);
    }
    _getPriceBook(suc, newItem.product_id, outlet_id, newItem.quantity, customer_group_id);  //Get PriceBook
    return defer.promise;
  }

  // --------------------------
  // Reflection customer information to saleItems
  // --------------------------
  function _reflectionCustomerInfo() {
    var defer = $q.defer();
    var promise = [];

    for (var idx in saleItems) {
      var saleItem = angular.copy(saleItems[idx]);
      promise.push(_updateSaleItem(saleItem));
    }

    $q.all(promise).then(function() {
      defer.resolve();
    });

    return defer.promise;
  }

  // --------------------------
  // Set or Clear customer information
  // --------------------------
  function _setCustomerInfo(info) {
    if (info != null) {
      if (info.id != null)                 customerInfo.id = info.id;
      if (info.customer_group_id != null)  customerInfo.customer_group_id = info.customer_group_id;
      if (info.customer_code != null)      customerInfo.customer_code = info.customer_code;
      if (info.name != null)               customerInfo.name = info.name;
      if (info.balance != null)            customerInfo.balance = info.balance;
      if (info.loyalty_balance != null)    customerInfo.loyalty_balance = info.loyalty_balance;

      _reflectionCustomerInfo()
          .then(function() {
            $rootScope.$broadcast('saleItems.updated');
          });
    } else {
      customerInfo.id = null;
      customerInfo.customer_group_id = null;
      customerInfo.customer_code = null;
      customerInfo.name = null;
      customerInfo.balance = 0;
      customerInfo.loyalty_balance = 0;
    }
  }

  // --------------------------
  // Get Payment Types
  // --------------------------
  function _getRegisterPaymentTypes() {
    var defer = $q.defer();
    var suc = function(resultArray) {
      defer.resolve(resultArray);
    }
    ds.getRegisterPaymentTypes(suc);
    return defer.promise;
  }

  // --------------------------
  // Check merchant and user ID
  // --------------------------
  function _checkInitDatastore(userInfo) {
    debug("INIT: check merchant id or user id");
    //$rootScope.loadingMessage = "Check Datastore.";
    $rootScope.$broadcast('loading.progress', {msg:'Check Datastore'});

    var deferred = $q.defer();
    if (userInfo == null) {
      debug("INIT: userInfo is null");
      deferred.reject('userInfo is null');
      return deferred.promise;
    }

    // Get saved ID from Cookie
    var savedMerchantID = $cookies.get('onzsa.merchant_id');
    var savedUserID = $cookies.get('onzsa.user_id');

    console.groupCollapsed("@ Merchant & User ID CHECK");
    console.debug(" save merchantID : %s", savedMerchantID);
    console.debug(" get  merchantID : %s", userInfo["merchant_id"]);
    console.debug(" save userID     : %s", savedUserID);
    console.debug(" get  userID     : %s", userInfo["id"]);
    console.groupEnd();

    // Check merchant and user ID
    if (savedMerchantID != userInfo["merchant_id"] || savedUserID != userInfo["id"]) {
      console.debug("INIT: diffrent merchant id or user id");
      // Save ID to cookie
      var now = new Date();
      var expireDate = new Date(now.getFullYear(), now.getMonth()+1, now.getDate());
      $cookies.put('onzsa.merchant_id', userInfo["merchant_id"], {expires:expireDate});
      $cookies.put('onzsa.user_id', userInfo["id"], {expires:expireDate});

      debug("INIT: checking for the init of the Web SQL Database");
      ds.dropAllLocalDataStore();
      ds.initLocalDataStore();
    } else {
      console.debug("INIT: both id same");
    }
    deferred.resolve();
    return deferred.promise;
  }

  // --------------------------
  // Check Register ID
  // --------------------------
  function _findSameRegisterID(id, registers) {
    if (id != null) {
      for (var idx = 0; idx < registers.length; idx++) {
        if (registers[idx].id == id) {
          debug("INIT: found same register_id index : (%d) ", idx);
          return idx;
        }
      }
    }
    return -1;
  }

  // --------------------------
  // Check Register ID
  // --------------------------
  function _checkRegisterID() {
    var deferred = $q.defer();

    debug("REFRESH: registers");
    debug("REQUEST: registers >>>>>>>>>>>>>>>>>>>>>");
    //$rootScope.loadingMessage = "Check register ID.";
    $rootScope.$broadcast('loading.progress', {msg:'Check register ID.'});

    $http.get('/api/registers.json')
        .then(function (response) {
          debug("REQUEST: registers, success handler");

          var config = LocalStorage.getConfig();
          var register_id = config.register_id;
          var result = [];

          if (response.data == null) {
            debug("REQUEST: registers, [WARNING] empty data]");
            deferred.reject(response);
          } else {
            debug("REQUEST: registers : %o", response.data);
            var registers = response.data;
            debug("INIT: current register_id: " + register_id);

            // find same register id
            var idx = _findSameRegisterID(register_id, registers);

            if (idx >= 0) {
              result["status"] = "selected";
              result["register"] = registers[idx];
              result["data"] = registers;
              deferred.resolve(result);
            } else {
              if (registers.length > 1) {
                result["status"] = "waitRegister";
                result["register"] = null;
                result["data"] = registers;
                deferred.resolve(result);
              } else {
                result["status"] = "selected";
                result["register"] = registers[0];
                result["data"] = registers;
                deferred.resolve(result);
              }
            }
          }
        }, function (response) {
          debug("REQUEST: registers, error handler");
          deferred.reject(response);
        });

    return deferred.promise;
  }

  // --------------------------
  // Receive Products from server
  // --------------------------
  function _receiveProducts() {
    debug("REFRESH: products");
    debug("REQUEST: products >>>>>>>>>>>>>>>>>>>>>");
    $rootScope.$broadcast('loading.progress', {msg:'Receive products information.'});

    var lastSyncTime = LocalStorage.getDataSyncTime("products");
    var deferred = $q.defer();
    $http.get('/api/products.json?st='+lastSyncTime)
        .then(function (response) {
          debug("REQUEST: products, success handler");

          if (response.data == null) {
            debug("REQUEST: products, [WARNING] empty data]");
          } else {
            ds.saveProducts(null, response.data);
            debug("REQUEST: products : %o", response.data);
          }
          var now = _getUnixTimestamp();
          LocalStorage.saveDataSyncTime("products", now);

          deferred.resolve();
        }, function (response) {
          debug("REQUEST: products, error handler");
          deferred.reject(response);
        });
    return deferred.promise;
  }

  // --------------------------
  // Receive payment_types from server
  // --------------------------
  function _receivePaymentTypes() {
    debug("REFRESH: payment_types");
    debug("REQUEST: payment_types >>>>>>>>>>>>>>>>>>>>>");
    $rootScope.$broadcast('loading.progress', {msg:'Receive payment types information.'});

    var lastSyncTime = LocalStorage.getDataSyncTime("payment_types");
    var deferred = $q.defer();
    $http.get('/api/payment_types.json?st='+lastSyncTime)
        .then(function (response) {
          debug("REQUEST: payment_types, success handler");

          if (response.data == null) {
            debug("REQUEST: payment_types, [WARNING] empty data]");
          } else {
            ds.saveRegisterPaymentTypes(response.data);
            debug("REQUEST: payment_types : %o", response.data);
          }
          var now = _getUnixTimestamp();
          LocalStorage.saveDataSyncTime("payment_types", now);

          deferred.resolve();
        }, function (response) {
          debug("REQUEST: payment_types, error handler");
          deferred.reject(response);
        });
    return deferred.promise;
  }

  // --------------------------
  // Receive Taxes from server
  // --------------------------
  function _receiveTaxes() {
    debug("REFRESH: taxes");
    debug("REQUEST: taxes >>>>>>>>>>>>>>>>>>>>>");
    $rootScope.$broadcast('loading.progress', {msg:'Receive taxes information.'});


    var lastSyncTime = LocalStorage.getDataSyncTime("taxes");
    var deferred = $q.defer();
    $http.get('/api/taxes.json?st='+lastSyncTime)
        .then(function (response) {
          debug("REQUEST: taxes, success handler");

          if (response.data == null) {
            debug("REQUEST: taxes, [WARNING] empty data]");
          } else {
            debug("REQUEST: taxes : %o", response.data);
            ds.saveTaxes(response.data);
          }
          var now = _getUnixTimestamp();
          LocalStorage.saveDataSyncTime("taxes", now);

          deferred.resolve();
        }, function (response) {
          debug("REQUEST: taxes, error handler");
          deferred.reject(response);
        });
    return deferred.promise;
  }

  // --------------------------
  // Receive PriceBooks from server
  // --------------------------
  function _receivePriceBooks(register_id) {
    debug("REFRESH: price books");
    debug("REQUEST: price books >>>>>>>>>>>>>>>>>>>>>");
    $rootScope.$broadcast('loading.progress', {msg:'Receive price books information.'});

    var deferred = $q.defer();
    $http.get('/api/get_price_books.json?register_id=' + register_id)
        .then(function (response) {
          debug("REQUEST: price books, success handler");

          if (response.data == null) {
            debug("REQUEST: price books, [WARNING] empty data");
          } else {
            for(var i=0; i<response.data.length; i++) {
              ds.savePriceBook(null, response.data[i]);
            }
            debug("REQUEST: price books : ", response.data);
          }
          deferred.resolve();
        }, function (response) {
          debug("REQUEST: price books, error handler");
          deferred.reject(response);
        });
    return deferred.promise;
  }

  // --------------------------
  // Receive Config from server
  // --------------------------
  function _receiveConfig() {
    debug("REFRESH: config");
    debug("REQUEST: config >>>>>>>>>>>>>>>>>>>>>");
    $rootScope.$broadcast('loading.progress', {msg:'Receive register config information.'});

    var deferred = $q.defer();
    $http.get('/api/config.json')
        .then(function (response) {
          debug("REQUEST: config, success handler");

          if (response.data == null) {
            debug("REQUEST: config, [WARNING] empty data]");
            deferred.reject(response);
          } else {
            LocalStorage.saveConfig(response.data);
            debug("REQUEST: config : %o", response.data);
          }
          deferred.resolve();
        }, function (response) {
          debug("REQUEST: config, error handler");
          deferred.reject(response);
        });
    return deferred.promise;
  }

  // --------------------------
  // Switching Register
  // --------------------------
  function _switchRegister(register) {
    debug("*** Switching register");
    debug("LOOKUP: Existing register from datastore – %o", register);
    $rootScope.$broadcast('loading.progress', {msg:'Save register information.'});

    var deferred = $q.defer();

    //TODO: Check and change for Reopen register
    //_checkRegisterReopen(register);

    // Save register information to Local Storage
    debug("register selected: " + register.id);
    LocalStorage.saveRegister(register);

    // Save Quick Key Layout
    quickKeyLayout = JSON.parse(register["quick_keys_template"]["key_layouts"]);
    quickKeyLayout = quickKeyLayout["quick_keys"];
    $rootScope.$broadcast('quickkey.ready');

    deferred.resolve(register.id);
    return deferred.promise;
  }

  // --------------------------
  // Open Register
  // --------------------------
  function _openRegister(register) {
    //debug("REQUEST:  open register  >>>>>>>>>>>>>>>>>>>>>");
    $rootScope.$broadcast('loading.progress', {msg:'Change status to open for sale.'});

    return $http.post('/api/open_register.json', {'register_id':register.id})
        .then(function (response) {
              debug("REQUEST: open register, success handler");

              if (response.data.success == true) {
                // update new register open
                var opened = response.data.opened;
                register.register_open_sequence_id = opened.id;
                register.register_open_time = opened.register_open_time;
                register.register_close_time = '';
                register.register_open_count_sequence = opened.register_open_count_sequence;

                return _subBootstrapSystem(register);
              } else {
                onlineStatus = 'offline';
                return _instantBootstrapSystem();
              }
            }
            , function(response) {
              onlineStatus = 'offline';
              return _instantBootstrapSystem();
            });
  }


  // --------------------------
  // Close Register
  // --------------------------
  function _closeRegister(register) {
    //console.debug("Do close register (id): %s (%s)", register.id, register.register_open_sequence_id);
    var defer = $q.defer();
    $http.post('/api/close_register.json', {'openId': register.register_open_sequence_id})
    .then(function (response) {
      if (response.data.success == true) {
        defer.resolve(response.data.close_time);
        //window.location.href = "/dashboard";
      } else {
        defer.reject();
      }
    }, function() {
      defer.reject()
    });;
    return defer.promise;
  }

  // --------------------------
  // Check opened Register
  // --------------------------
  function _isOpenedRegister(register) {
    //debug("REQUEST: check opened register  >>>>>>>>>>>>>>>>>>>>>");
    //console.debug("is open register : %s", register.id);

    var deferred = $q.defer();
    var result = [];
    $http.get('/api/is_opened_register.json?register_id=' + register.id)
        .then(function (response) {
          debug("REQUEST: check opened register, success handler");

          if (response.data.success == true) {
            debug(" Status opne register : %s", response.data.opened);
            result['status'] = "openRegister";
            result['data'] = register;
            result['opened'] = response.data.opened;
            deferred.resolve(result);
          } else {
            deferred.reject(response);
          }
        }, function (response) {
          debug("REQUEST: signed user information, error handler");
          deferred.reject(response);
        });
    return deferred.promise;
  }

  // --------------------------
  // Receive Session User Information
  // --------------------------
  function _receiveSessionUser() {
    //debug("REFRESH: signed user information");
    //debug("REQUEST: signed user information  >>>>>>>>>>>>>>>>>>>>>");
    $rootScope.$broadcast('loading.progress', {msg:'Receive Session User Information.'});

    var deferred = $q.defer();
    $http.get('/api/check_user_session.json')
        .then(function (response) {
          debug("REQUEST: signed user information, success handler");

          if (response.data == null) {
            debug("REQUEST: signed user information, [WARNING] empty data]");
          } else {
            debug("REQUEST: signed user information : ", response.data);
          }
          deferred.resolve(response.data.user);
        }, function (response) {
          debug("REQUEST: signed user information, error handler");
          deferred.reject(response);
        });
    return deferred.promise;
  }

  // --------------------------
  // get last saleItem
  // --------------------------
  function _getLastestSaleItem() {
    var len = saleItems.length;
    if (len > 0) {
      var item = saleItems[0];
      return item;
    }
    return null;
  }

  // --------------------------
  // add new Register sale item structure using price book
  // --------------------------
  function _addRegisterSaleItem(saleID, saleProduct, priceBook) {
    var uuid = _getUUID();
    var item = {};
    item.id = uuid;
    item.product_id = saleProduct.id;
    item.name = saleProduct.name;
    item.supply_price = saleProduct.supply_price;
    item.discount = priceBook.discount;
    item.price = priceBook.price;
    item.tax_rate = saleProduct.tax_rate;
    item.product_uom = saleProduct.product_uom;

    var excPrice       = _roundEx(priceBook.price + (priceBook.price * saleProduct.tax_rate) - priceBook.discount, 5);
    item.sale_price    = _roundEx(excPrice                        / (1 + saleProduct.tax_rate), 5);
    item.tax           = _roundEx(excPrice * saleProduct.tax_rate / (1 + saleProduct.tax_rate), 5);
    item.loyalty_value = _roundEx(priceBook.loyalty_value, 5);
    item.sequence = registerSale.sequence++;
    item.status = "sale_item_status_valid";

    if (item.product_uom == 'product_uom_ea' || item.product_uom == null) { //TODO: product_uom default value setting
      item.quantity = 1;
      saleItems.unshift(item);
      debug("Add Sell Item : %o", item);

      _addSaleItemSub(saleID, item)

    } else if (item.product_uom == 'product_uom_kg') {
      var scaleClient = new ScaleClient();
      scaleClient.connect(function (connected, error) {
        if (connected) {
          scaleClient.doEnquiry(function (datas, error) {
            if (datas) {
              console.debug("@@@ scale data : %o" , datas);
              var jsonData = JSON.parse(datas.data);
              var weights = parseFloat(jsonData.weight);
              item.quantity = _roundEx(weights, 5);

              saleItems.unshift(item);
              debug("Add Sell Item : %o", item);
              scaleClient.close();

              _addSaleItemSub(saleID, item)
            } else {
              debug("fail scaleClient.doEnquiry()");
              scaleClient.close();
            }
          });
        } else {
          debug("fail scaleClient.doEnquiry()");
        }
      });
    }
  }


  // --------------------------
  // re-calcurate for sellItem
  // --------------------------
  function _recalcSellItem(oldItem, newItem, priceBook) {
    var discount = priceBook.discount;
    if (oldItem.discount != newItem.discount) {
      discount = newItem.discount;
    }
    var price = priceBook.price;
    if (oldItem.price != newItem.price) {
      price = newItem.price;
    }
    var excPrice       = _roundEx(price + (price * newItem.tax_rate) - discount, 5);
    newItem.sale_price = _roundEx(excPrice                    / (1 + newItem.tax_rate), 5);
    newItem.tax        = _roundEx(excPrice * newItem.tax_rate / (1 + newItem.tax_rate), 5);

    //TODO: delete debug
    console.groupCollapsed("@ Price Calcuration");
    console.debug("@ supply_price   : %f  ", newItem.supply_price);
    console.debug("@ mark           : %f%", (price - newItem.supply_price) * 100 / newItem.supply_price);
    console.debug("@ price(old)     : %f  ", oldItem.price);
    console.debug("@ price(new)     : %f  ", newItem.price);
    console.debug("@ discount(old)  : %f  ", oldItem.discount);
    console.debug("@ discount(new)  : %f  ", newItem.discount);
    console.debug("@ price_incl_tax : %f  ", excPrice);
    console.debug("@ tax_rate       : %f(%f%)", newItem.tax_rate, (newItem.tax_rate * 100));
    console.debug("@ sale_price     : %f  ", newItem.sale_price);
    console.debug("@ tax            : %f  ", newItem.tax);
    console.groupEnd();
    return newItem;
  }

  // --------------------------
  // update sellItem structure using price book
  // --------------------------
  function _additionSellItemQty(saleID, lastestSaleItem, saleProduct, priceBook) {
    debug("Add Quantity for Same Sell Item from : %o", lastestSaleItem);
    lastestSaleItem.quantity = lastestSaleItem.quantity + 1;
    lastestSaleItem.supply_price = saleProduct.supply_price;
    lastestSaleItem.discount = priceBook.discount;
    lastestSaleItem.price = priceBook.price;
    lastestSaleItem.tax_rate = saleProduct.tax_rate;
    var excPrice               = _roundEx(priceBook.price + (priceBook.price * saleProduct.tax_rate) - priceBook.discount, 5);
    lastestSaleItem.sale_price = _roundEx(excPrice                        / (1 + saleProduct.tax_rate), 5);
    lastestSaleItem.tax        = _roundEx(excPrice * saleProduct.tax_rate / (1 + saleProduct.tax_rate), 5);
    debug("Add Quantity for Same Sell Item  to : %o", lastestSaleItem);

    //TODO: delete debug
    console.groupCollapsed("@ Price Calcuration");
    console.debug("@ supply_price   : %f  ", lastestSaleItem.supply_price);
    console.debug("@ mark           : %f%", (lastestSaleItem.price - lastestSaleItem.supply_price) * 100 / lastestSaleItem.supply_price);
    console.debug("@ price          : %f  ", lastestSaleItem.price);
    console.debug("@ discount       : %f  ", lastestSaleItem.discount);
    console.debug("@ price_incl_tax : %f  ", excPrice);
    console.debug("@ tax_rate       : %f(%f%)", saleProduct.tax_rate, (lastestSaleItem.tax_rate * 100));
    console.debug("@ sale_price     : %f  ", lastestSaleItem.sale_price);
    console.debug("@ tax            : %f  ", lastestSaleItem.tax);
    console.groupEnd();

    _addSaleItemSub(saleID, lastestSaleItem)
  }

  // --------------------------
  // clear registerSale structure
  // --------------------------
  function _clearRegisterSaleTotal() {
    registerSale.total_cost = 0;
    registerSale.total_price = 0;
    registerSale.total_price_incl_tax = 0;
    registerSale.total_discount = 0;
    registerSale.total_tax = 0;
    registerSale.total_payment = 0;
    registerSale.line_discount = 0;
    registerSale.line_discount_type = 0;
  }

  // --------------------------
  // recalcurate registerSale structure
  // --------------------------
  function _recalcurateRegisterSaleTotal() {

    registerSale.total_cost = 0;
    registerSale.total_price = 0;
    registerSale.total_price_incl_tax = 0;
    registerSale.total_discount = 0;
    registerSale.total_tax = 0;

    for (var idx in saleItems) {
      var saleItem = saleItems[idx];

      registerSale.total_cost           = _roundEx(registerSale.total_cost + saleItem.supply_price * saleItem.quantity, 5);
      registerSale.total_price          = _roundEx(registerSale.total_price + saleItem.price * saleItem.quantity, 5);
      registerSale.total_price_incl_tax = _roundEx(registerSale.total_price_incl_tax + (saleItem.sale_price + saleItem.tax) * saleItem.quantity, 5);
      registerSale.total_discount       = _roundEx(registerSale.total_discount + saleItem.discount * saleItem.quantity, 5);
      registerSale.total_tax            = _roundEx(registerSale.total_tax + saleItem.tax * saleItem.quantity, 5);
    }

    if (registerSale.line_discount != 0) {
      var discountValue = registerSale.line_discount;
      if (registerSale.line_discount_type == 0) { // percent
        discountValue = _roundEx(registerSale.total_price_incl_tax * (discountValue / 100), 5);
      }
      registerSale.total_discount       = _roundEx(registerSale.total_discount + discountValue, 5);
      registerSale.total_price_incl_tax = _roundEx(registerSale.total_price_incl_tax - discountValue, 5);
    }
  }

  // --------------------------
  // get price book
  // --------------------------
  function _getPriceBook(callback, productId, outletId, productQty, customerGroupId) {
    var config = LocalStorage.getConfig();
    var searchInfo = {
      'productId': productId,
      'outletId': outletId,
      'pqty': productQty,
      'customerGroupId': customerGroupId,
      'defCustomerGroupId': config.default_customer_group_id
    }
    ds.getPriceBook(callback, searchInfo);
  };

  // --------------------------
  // get Product
  // --------------------------
  function _getProduct(callback, productId) {
    var searchInfo = {
      'id': productId
    };
    ds.getProduct(callback, searchInfo);
  };

  // --------------------------
  // Update RegisterSales
  // --------------------------
  function _updateRegisterSaleTotal(registerSaleTotal) {
    // not apply receipt_number & sequence , it's controlled in service
    registerSale.line_discount_type   = registerSaleTotal.line_discount_type;
    registerSale.line_discount        = registerSaleTotal.line_discount;
    registerSale.total_cost           = registerSaleTotal.total_cost;
    registerSale.total_price          = registerSaleTotal.total_price;
    registerSale.total_price_incl_tax = registerSaleTotal.total_price_incl_tax;
    registerSale.total_discount       = registerSaleTotal.total_discount;
    registerSale.total_tax            = registerSaleTotal.total_tax;
    registerSale.total_payment        = registerSaleTotal.total_payment;
  };


  // --------------------------
  // Check for selected customer information
  // --------------------------
  function _isSelectedCustomer() {
    return (customerInfo.id != null && customerInfo.name != null && customerInfo.customer_code != null);
  }


  // --------------------------
  // Get RegisterSales by Register ID
  // --------------------------
  function _getRegisterSalesByRegisterID(register_id, sale_date) {
    var defer = $q.defer();
    var sucRS;

    var data = {
      'register_id':register_id,
      'sale_date': sale_date
    }
    sucRS = function(rsRS) {
      defer.resolve(rsRS);
    }
    ds.getRegisterSales(data, sucRS);
    return defer.promise;
  }


  // --------------------------
  // Save RegisterSales
  // --------------------------
  function _saveRegisterSales(saleID, status) {
    var config = LocalStorage.getConfig();
    var customer_id = config.default_customer_id;
    var customer_code = "walkin";
    var customer_name = "Walkin";

    if (_isSelectedCustomer()) {
      customer_id = customerInfo.id;
      customer_code = customerInfo.customer_code;
      customer_name = customerInfo.name;
    }

    var data = {
      'id': saleID,
      'register_id': config.register_id,
      'user_id': config.user_id,
      'user_name': config.user_name,
      'customer_id': customer_id,
      'customer_code': customer_code,
      'customer_name': customer_name,
      'xero_invoice_id': null,
      'receipt_number': registerSale.receipt_number,
      'status': status,
      'total_cost': registerSale.total_cost,
      'total_price': registerSale.total_price,
      'total_price_incl_tax': registerSale.total_price_incl_tax,
      'total_discount': registerSale.total_discount,
      'total_tax': registerSale.total_tax,
      'total_payment': registerSale.total_payment,
      'line_discount': registerSale.line_discount,
      'line_discount_type': registerSale.line_discount_type,
      'note': '',
      'sale_date': null,
      'sync_status': "sync_wait",
      'sync_date': null
    }

    var inputData = [];
    inputData.push(data);
    ds.saveRegisterSales(null, inputData);
  };

  // --------------------------
  // Update RegisterSale
  // --------------------------
  function _updateRegisterSale(saleID, status, note, suc) {
    var data = {
      'id': saleID,
      'customer_id': customerInfo.id,
      'customer_code': customerInfo.customer_code,
      'customer_name': customerInfo.name,
      'total_cost': registerSale.total_cost,
      'total_price': registerSale.total_price,
      'total_price_incl_tax': registerSale.total_price_incl_tax,
      'total_discount': registerSale.total_discount,
      'total_tax': registerSale.total_tax,
      'total_payment': registerSale.total_payment,
      'line_discount': registerSale.line_discount,
      'line_discount_type': registerSale.line_discount_type,
    };
    if(status != null) {
      data['status'] = status;
      data['sale_date'] = _getUnixTimestamp();
    }
    if(note != null) {
      data['note'] = note;
    }
    ds.changeRegisterSales(data, suc);
  };

  // --------------------------
  // Get Register Sale Payments
  // --------------------------
  function _getRegisterSalePayments(saleID, index) {
    var defer = $q.defer();
    var sucRSP, data;
    var response = [];
    data = {
      'sale_id':saleID
    };
    sucRSP = function(rsRSP) {
      response.data = rsRSP;
      response.index = index;
      defer.resolve(response);
    }
    ds.getRegisterSalePayments(data, sucRSP);
    return defer.promise;
  };

  // --------------------------
  // Save Register Sale Payments
  // --------------------------
  function _saveRegisterSalePayment(payments) {
    for (var idx in payments) {
      var payment = payments[idx];
      ds.saveRegisterSalePayments(payment);
    }
  };

  // --------------------------
  // Save SaleItem to RegisterSaleItems
  // --------------------------
  function _saveRegisterSaleItems(saleItems, saleID) {
    var inputValue = [];
    for(var idx in saleItems) {
      var item = saleItems[idx];
      var input = {
        'id': item.id,
        'sale_id': saleID,
        'product_id': item.product_id,
        'name': item.name,
        'quantity': item.quantity,
        'product_uom': item.product_uom,
        'supply_price': item.supply_price,
        'price': item.price,
        'sale_price': item.sale_price,
        'tax': item.tax,
        'tax_rate': item.tax_rate,
        'discount': item.discount,
        'loyalty_value': item.loyalty_value,
        'sequence': item.sequence,
        'status': item.status,
      };
      inputValue.push(input);
    }
    ds.saveRegisterSaleItems(null, inputValue);
  };

  // --------------------------
  // Update RegisterSaleItems
  // --------------------------
  function _updateRegisterSaleItems(saleItem, saleID, status) {
    var data = {
      'id': saleItem.id,
      'sale_id': saleID,
      'product_id': saleItem.product_id,
      'name': saleItem.name,
      'quantity': saleItem.quantity,
      'supply_price': saleItem.supply_price,
      'price': saleItem.price,
      'sale_price': saleItem.sale_price,
      'tax': saleItem.tax,
      'tax_rate': saleItem.tax_rate,
      'discount': saleItem.discount,
      'loyalty_value': saleItem.loyalty_value,
      'sequence': saleItem.sequence,
      'status': status,
    };
    ds.updateRegisterSaleItems(data);
  };

  // --------------------------
  // Get SaleItems to RegisterSaleItems
  // --------------------------
  function _getRegisterSaleItems(saleID, status, suc, err) {
    var data = {
      'sale_id': saleID,
      'status': status,
    };
    ds.getRegisterSaleItems(data, suc, err);
  };

  // --------------------------
  // Delete SaleItem from RegisterSaleItems
  // --------------------------
  function _deleteRegisterSaleItem(saleItem, saleID) {
    var delInfo = {
      'sale_id': saleID,
      'sequence': saleItem.sequence
    };
    ds.deleteRegisterSaleItems(delInfo);
  };

  // --------------------------
  // delete saleItem using sequence
  // --------------------------
  function _deleteSaleItemBySequence(sequence) {
    for (var idx in saleItems) {
      var item = saleItems[idx];
      if (item.sequence == sequence) {
        saleItems.splice(idx, 1);
        break;
      }
    }
    return saleItems.length;
  }

  // --------------------------
  // get saleItem using sequence
  // --------------------------
  function _getSaleItemBySequence(sequence) {
    for (var idx in saleItems) {
      var item = saleItems[idx];
      if (item.sequence == sequence) {
        return item;
      }
    }
    return null;
  }

  // --------------------------
  // get saleItem index using sequence
  // --------------------------
  function _getSaleItemIndexBySequence(sequence) {
    for (var idx in saleItems) {
      var item = saleItems[idx];
      if (item.sequence == sequence) {
        return idx;
      }
    }
    return null;
  }

  // --------------------------
  // get sequence number from saleItem by productId
  // --------------------------
  function _getSequenceNumberByProductId(productId) {
    for (var idx in saleItems) {
      var item = saleItems[idx];
      if (item.product_id == productId) {
        return item.sequence;
      }
    }
    return null;
  }

  // --------------------------
  // clear sellItem structure
  // --------------------------
  function _clearSellItems() {
    saleItems.length = 0;
  }

  // --------------------------
  // End RegisterSale
  // --------------------------
  var _endRegisterSale = function(status, note) {
    var saleID = LocalStorage.getSaleID();
    var suc = function() {
      // Clear Register Sale Item in UI
      _clearSellItems();

      // Clear Register Sale Total Section
      _clearRegisterSaleTotal();

      // clear RegisterSaleID
      LocalStorage.clearSaleID();

      // clear customer info
      _setCustomerInfo(null);

      debug("Register: end register sale");
      $rootScope.$broadcast('sale.ended');

      // make new register saleID
      _newRegisterSale();
    }
    // change RegisterSales status
    _updateRegisterSale(saleID, status, note, suc);
  }

  // --------------------------
  // reload Customer Information from server
  // --------------------------
  function _reloadCustomerInfo(customerID) {
    debug("Register: reload Customer Information : " + customerID);

    var defer = $q.defer();
    if (customerID == null || customerID == '') {
      defer.resolve();
      return defer.promise;
    }
    var config = LocalStorage.getConfig();
    if (config.default_customer_id != customerID) {
      $http.get('/api/search_customer.json?query=' + customerID)
          .then(function (response) {
            if (response.data != null) {
              var info = response.data[0];
              customerInfo.id = info.id;
              customerInfo.customer_group_id = info.customer_group_id;
              customerInfo.customer_code = info.customer_code;
              customerInfo.name = info.name;
              customerInfo.balance = info.balance;
              customerInfo.loyalty_balance = info.loyalty_balance;
            }
            defer.resolve();
          }, function (response) {
            defer.reject(response);
          });
    } else {
      defer.resolve();
    }
    return defer.promise;
  }

  // --------------------------
  // reload register sale items from local DB
  // --------------------------
  function _reloadRegisterSaleItmes(saleID) {
    var deferred = $q.defer();
    var sucItems = function(rs) {
      debug("Register: reload find registerSaleItems count : " + rs.length);
      if (rs.length > 0) {
        _clearSellItems();

        for (var idx=0; idx<rs.length; idx++) {
          var item = rs[idx];
          var saleItem = {};
          saleItem.id = item.id;
          saleItem.product_id = item.product_id;
          saleItem.name = item.name;
          saleItem.supply_price = item.supply_price;
          saleItem.price = item.price;
          saleItem.sale_price = item.sale_price;
          saleItem.tax = item.tax;
          saleItem.tax_rate = item.tax_rate;
          saleItem.discount = item.discount;
          saleItem.quantity = item.quantity;
          saleItem.loyalty_value = item.loyalty_value;
          saleItem.sequence = item.sequence;
          saleItem.status = item.status;
          saleItems.unshift(saleItem);

          //get max sequence number
          if (registerSale.sequence <= saleItem.sequence) {
            registerSale.sequence = saleItem.sequence + 1;
          }
        }
        debug("Register: reloaded registerSaleItems : " + saleItems);
      }
      deferred.resolve();
    }
    ds.getRegisterSaleItems({'sale_id':saleID}, sucItems);
    return deferred.promise;
  }

  // --------------------------
  // reload register sale from local DB
  // --------------------------
  function _reloadRegisterSale(saleID) {
    var defer = $q.defer();
    var sucSales = function(rs) {
      debug("Register: reload find registerSale count : " + rs.length);
      var sale = null;
      if (rs.length > 0) {
        sale = rs[0];
        registerSale.note = sale['note'];
        registerSale.receipt_number = sale['receipt_number'];
        registerSale.total_cost = sale['total_cost'];
        registerSale.total_price = sale['total_price'];
        registerSale.total_price_incl_tax = sale['total_price_incl_tax'];
        registerSale.total_discount = sale['total_discount'];
        registerSale.total_tax = sale['total_tax'];
        registerSale.total_payment = sale['total_payment'];
        registerSale.line_discount = sale['line_discount'];
        registerSale.line_discount_type = sale['line_discount_type'];
        debug("Register: reloaded registerSale : " + registerSale);
      }
      if (sale != null && typeof sale['customer_id'] != 'undefined') {
        defer.resolve(sale['customer_id']);
      } else {
        defer.resolve();
      }
    }
    ds.getRegisterSales({'id':saleID}, sucSales);
    return defer.promise;
  }

  // --------------------------
  // Make new Register Sale
  // --------------------------
  function _newRegisterSale() {
    var saleID = LocalStorage.getSaleID();
    if(saleID == null) {
      saleID = _getUUID();
      LocalStorage.saveSaleID(saleID);
      registerSale.sequence = 0;
      registerSale.receipt_number++;
      _saveRegisterSales(saleID, "sale_status_open");
    }
    return saleID;
  }

  // --------------------------
  // reload Register Sale
  // --------------------------
  function _reloadSale(receivedSaleID) {
    //$rootScope.loadingMessage = "Reloading sales information.";
    $rootScope.$broadcast('loading.progress', {msg:'Reloading sales information.'});

    var saleID = receivedSaleID;
    if (saleID == null) {
      saleID = LocalStorage.getSaleID();
      if (saleID == null) {
        return;
      }
    } else {
      LocalStorage.saveSaleID(receivedSaleID);
    }

    _reloadRegisterSale(saleID)
        .then(function(customerID){
          return _reloadCustomerInfo(customerID);
        })
        .then(function() {
          return _reloadRegisterSaleItmes(saleID)
        })
        .then(function(){
          $rootScope.$broadcast('sale.reloaded');
        });
  }

  //TODO: Get UUID for RegisterSaleItem
  function _getUUID() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
      var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8);
      return v.toString(16);
    });
  }

  function _getUnixTimestamp(date) {
    if (date == null) {
      return Math.floor(new Date().getTime() / 1000);
    } else {
      return Math.floor(date.getTime() / 1000);
    }
  }

  function _sleep(num) {
    var now = new Date();
    var stop = now.getTime() + num;
    while (true) {
      now = new Date();
      if (now.getTime() > stop) {
        return;
      }
    }
  }

  function _roundEx(value, bits) {

    // Method 1
    var position = Math.pow(10, bits);
    return Math.round(value * position) / position;

    // Method 2
    //return Number(parseFloat(value).toFixed(bits));

    //NOTES: Method 1 was faster then Method 2 (68%)
    // (http://jsperf.com/roundex)
  };

  return sharedService;
}]);
