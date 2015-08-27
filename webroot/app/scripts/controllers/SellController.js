'use strict';

/**
 * @ngdoc function
 * @name OnzsaApp.controller:SellController
 *
 * @description
 * Controller of the OnzsaApp
 */
angular.module('OnzsaApp', [])

.controller('SellController', function($rootScope, $scope, $state, $stateParams, $location, $http, $modal, locale, LocalStorage) {

  $scope.$on('$viewContentLoaded', function() {
    // initialize core components
    Metronic.initAjax();
    TableAdvanced.init();

    // define alias for local Datastore
    $scope.ds = Datastore_sqlite;

    // start checking for online status
    $rootScope.online = false;
    debug("INIT: [ONLINE] Checking Start >>>>>>>>>>>>>>>>>>>>>");
    isOnline();

    // Online status
    //if ($rootScope.online == true) {
    //  debug("INIT: Bootstrapping >>>>>>>>>>>>>>>>>>>>>");
    //  bootstrapSystem();
    //}
    //// Offline status
    //else {
    //  // has Local data
    //  if(validateDataStore() == true) {
    //    debug("INIT: Pass checking >>>>>>>>>>>>>>>>>>>>>");
    //  }
    //  // Local data nothing
    //  else {
    //    debug("INIT: Back to Singin Screen >>>>>>>>>>>>>>>>>>>>>");
    //    alert("You must connect to server at first time.");
    //    window.location = "/users/logout";
    //  }
    //}
    $.ajax({
      url: '//localhost/',
      complete: function (jqXHR, statusText) {

        // Online status
        if (statusText === 'success' && window.navigator.onLine == true) {
          $rootScope.online = true;
          console.log("[ONLINE] status : %s", $rootScope.online);
          debug("INIT: Bootstrapping >>>>>>>>>>>>>>>>>>>>>");
          bootstrapSystem();
        }
        // Offline status
        else {
          $rootScope.online = false;
          console.log("[ONLINE] status : %s", $rootScope.online);
          // has Local data
          debug("INIT: Checking DataStore Validate >>>>>>>>>>>>>>>>>>>>>");
          if(validateDataStore() == true) {
            debug("INIT: Pass checking >>>>>>>>>>>>>>>>>>>>>");
          }
          // Local data nothing
          else {
            debug("INIT: Back to Singin Screen >>>>>>>>>>>>>>>>>>>>>");
            alert("You must connect to server at first time.");
            window.location = "/users/logout";
          }
        }

        setTimeout(function () {
          isOnline();
        }, 5000); // 5sec
      }
    });

    debug("CHECK: Opend Sale Recover >>>>>>>>>>>>>>>>>>>>>");
    recoverOpenedSale();
  });

  // set sidebar closed and body solid layout mode
  $rootScope.settings.layout.pageSidebarClosed = false;

  $scope.doLogout = function() {
    console.log('doLogout');
  };

  $scope.doSetup = function() {
    console.log('doSetup');
  };

  $scope.voidSale = function() {
    console.log('voidSale');
    endRegisterSale("sale_status_voided")
  };

  $scope.doParking = function() {
    console.log('doParking');
    endRegisterSale("sale_status_saved");
  };

  $scope.doPayment = function() {
    console.log('doPayment');
    openPayment();
  };

  $scope.openCashDrawer = function() {
    console.log('openCashDrawer');
  };

  $scope.printReceipt = function() {
    $scope.printDiv = function(divName) {
      var printContents = document.getElementById(divName).innerHTML;
      var popupWin = window.open('', '_blank', 'width=1200,height=1200');
      popupWin.document.open()
      popupWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="style.css" /></head><body onload="window.print()">' + printContents + '</html>');
      popupWin.document.close();
    }
    $scope.printDiv('receipt');
    console.log('printReceipt');
  };

  $scope.doRefund = function() {
    console.log('doRefund');
  };

  $scope.doDiscount = function() {
    console.log('doDiscount');
  };

  $scope.doLinePrice = function() {
    console.log('doLinePrice');
  };

  $scope.viewRecall = function() {
    console.log('viewRecall');
    $state.go("recall-sale");
  };

  $scope.viewHistory = function() {
    console.log('viewHistory');
    window.location = "/history";
  };

  $scope.viewDailyReport = function() {
    console.log('viewDailyReport');
    $state.go("daily-snapshot");
  };

  $scope.closeRegister = function() {
    console.log('closeRegister');
    $state.go("close-register");
  };

  $scope.functions = {
    'fn_void_sale' : {
      id      : 'fn_void_sale',
      name    : 'Void',
      callback: $scope.voidSale
    },
    'fn_do_discount' : {
      id      : 'fn_do_discount',
      name    : 'Discount',
      callback: $scope.doDiscount
    },
    'fn_do_line_price' : {
      id      : 'fn_do_line_price',
      name    : 'Line Price',
      callback: $scope.doLinePrice
    },
    'fn_do_parking' : {
      id      : 'fn_do_parking',
      name    : 'Save',
      callback: $scope.doParking
    },
    'fn_do_payment' : {
      id      : 'fn_do_payment',
      name    : 'Payment',
      callback: $scope.doPayment
    },
    'fn_do_refund' : {
      id      : 'fn_do_refund',
      name    : 'Refund',
      callback: $scope.doRefund
    },
    'fn_do_recall' : {
      id      : 'fn_do_recall',
      name    : 'Recall Sales',
      callback: $scope.viewRecall
    },
    'fn_view_history' : {
      id      : 'fn_view_history',
      name    : 'Sales History',
      callback: $scope.viewHistory
    },
    'fn_view_daily_report' : {
      id      : 'fn_view_daily_report',
      name    : 'Daily Snapshot',
      callback: $scope.viewDailyReport
    },
    'fn_close_register' : {
      id      : 'fn_close_register',
      name    : 'End of Day',
      callback: $scope.closeRegister
    },
    'fn_print_receipt' : {
      id      : 'fn_print_receipt',
      name    : 'Print Receipt',
      callback: $scope.printReceipt
    },
    'fn_open_cash_drawer' : {
      id      : 'fn_open_cash_drawer',
      name    : 'No Sale',
      callback: $scope.openCashDrawer
    },
    'fn_do_setup' : {
      id      : 'fn_do_setup',
      name    : 'Setup',
      callback: $scope.doSetup
    },
    'fn_do_logout' : {
      id      : 'fn_do_logout',
      name    : 'Logout',
      callback: $scope.doLogout
    },
    'fn_do_nothing' : {
      id      : 'fn_do_nothing',
      name    : '',
      callback: function() {}
    }
  };

  $scope.function_keys = [
    angular.extend({position: 0}, $scope.functions['fn_void_sale']),
    angular.extend({position: 1}, $scope.functions['fn_do_discount']),
    angular.extend({position: 2}, $scope.functions['fn_do_line_price']),
    angular.extend({position: 3}, $scope.functions['fn_do_payment']),
    angular.extend({position: 4}, $scope.functions['fn_do_refund']),
    angular.extend({position: 5}, $scope.functions['fn_do_parking']),
    angular.extend({position: 6}, $scope.functions['fn_do_recall']),
    angular.extend({position: 7}, $scope.functions['fn_view_history']),
    angular.extend({position: 8}, $scope.functions['fn_view_daily_report']),
    angular.extend({position: 9}, $scope.functions['fn_close_register']),
    angular.extend({position: 10}, $scope.functions['fn_open_cash_drawer']),
    angular.extend({position: 11}, $scope.functions['fn_do_setup']),
    angular.extend({position: 12}, $scope.functions['fn_do_logout']),
    angular.extend({position: 13}, $scope.functions['fn_do_nothing']),
    angular.extend({position: 14}, $scope.functions['fn_do_nothing'])
  ];

  $scope.priceBooks = [];
  $scope.modified = false;

  $rootScope.registerSale = {
    'receipt_number': 1,
    'total_cost': 0.0,            //supply_price
    'total_price': 0.0,           //price_exclude_tax(supply_price * markup)
    'total_price_incl_tax': 0.0,  //retail_price(price + tax)
    'total_discount': 0.0,
    'total_tax': 0.0,             //price * tax_rate
    'total_payment': 0.0,         //Paid
    'sequence': 0
  };

  // If recovery, already exsit
  if ($scope.saleItems == null) $scope.saleItems = [];

  $scope.viewMode = 'small';
  $scope.onChangeViewMode = function(e) {
  };

  $scope.getKeyStyle = function(quickKey) {
    if ($scope.viewMode == 'small') {
      return {
        'background': quickKey.background,
        'background-image': ''
      }
    } else {
      return {
        'background-image': 'url(' + quickKey.image + ')'
      }
    }
  };

  /**
   * Add Sell Item to List from Quick Key Click event
   * @param quickKey
   */
  $scope.addSellItem = function(quickKey) {
    var priceBook = null;
    var saleProduct = null;
    var lastestSaleItem = null;
    var saleItem = null;
    var productQty = 1;

    // If first addition for sale, make RegisterSaleID
    var saleID = LocalStorage.getSaleID();
    if(saleID == null) {
      saleID = getUUID();
      LocalStorage.saveSaleID(saleID);
      $rootScope.registerSale.sequence = 0;
      $rootScope.registerSale.receipt_number++;
      saveRegisterSales(saleID, "sale_status_open");
    }

    //STEP 0. Get Product by ProductId
    getProduct(function (rs) {
      if (rs.length > 0) {
        saleProduct = rs[0];

        //STEP 1. Get lastest sellItem from saleItem
        lastestSaleItem = getLastestSaleItem();

        //STEP 2. If same item, increase sellItem's quantity
        if (lastestSaleItem && lastestSaleItem.product_id == quickKey.product_id) {
          productQty = lastestSaleItem.qty + 1;
        }

        //STEP 3. Get PriceBook by ProductID and quantity
        getPriceBook(function (rs) {
          if (rs.length > 0) {
            priceBook = rs[0];

            //STEP 3.1. Set data to sellItem structure
            if (productQty == 1) {
              saleItem = addSellItem(quickKey, saleProduct, priceBook);

              //STEP 3.3. Recalcurate to registerSale structure
              additionRegisterSaleTotal(saleItem);

              // Save to RegisterSaleItems : status_open
              saveRegisterSaleItem([saleItem], saleID, "sale_items_status_open");
            }
            //STEP 3.2.
            else {
              //STEP 3.3. Recalcurate to registerSale structure
              subtractionRegisterSaleTotal(lastestSaleItem);
              saleItem = additionSellItemQty(lastestSaleItem, quickKey, saleProduct, priceBook, productQty);
              additionRegisterSaleTotal(saleItem);

              // Save to RegisterSaleItems : status_open
              updateRegisterSaleItems(saleItem, saleID, "sale_items_status_open");
            }

            // Change(Update) RegisterSale
            updateRegisterSale(saleID);

            // Update View
            $scope.$apply();
          } else {
            console.log("Not found PriceBook : " + quickKey.product_id);
          }
        }, quickKey.product_id, null, productQty, null);  //Get PriceBook
      } else {
        console.log("Not found Product : " + quickKey.product_id);
      }
    }, quickKey.product_id); //Get Product
  };

  /**
   * Remove Sale Item in List from delete icon click event
   * @param saleItem
   */
  $scope.removeSellItem = function(saleItem) {

    // Delete Sale Item from List
    deleteSaleItemBySequence(saleItem.sequence);

    // Recalcurate Total
    subtractionRegisterSaleTotal(saleItem);

    // If list to be empty, Delete RegisterSale
    if($scope.saleItems.length == 0) {
      endRegisterSale("sale_status_voided");
    } else {
      var saleID = LocalStorage.getSaleID();
      updateRegisterSale(saleID);
    }
  };

  $scope.customer = {
    'name': 'Tester (1234567890)',
    'balance': '100.00',
    'loyalty': '200.00',
  };

  $scope.popOver = function($event, placement) {
    var height = $("#popup_sample").outerHeight();
    var width = $("#popup_sample").outerWidth();
    var pixelRatio = window.devicePixelRatio;
    var target = $($event.target);
    var position = target.position();
    var top = 0;
    var left = 0;

    console.log("Left: " + position.left);
    console.log("Top: " + position.top);
    console.log("Right: " + (position.left + target.outerWidth()));
    console.log("Bottom: " + (position.top + target.outerHeight()));
    console.log("Width: " + width);
    console.log("Height: " + height);

    if (placement == "top") {
      top = position.top - height - 2;
      left = position.left - (width - target.outerWidth()) / 2;
    } else if (placement == "right") {
      top = position.top - (height - target.outerHeight()) / 2;
      left = position.left + target.outerWidth() + 2;
    } else if (placement == "bottom") {
      top = position.top + target.outerHeight() + 2;
      left = position.left - (width - target.outerWidth()) / 2;
    } else if (placement == "left") {
      top = position.top - (height - target.outerHeight()) / 2;
      left = position.left - width - 2;
    }

    $("#popup_sample").css({"top" : top + 'px'});
    $("#popup_sample").css({"left" : left + 'px'});
    $("#popup_sample").css({"display": 'block'});
  };

  $scope.content = "test ok";
  $scope.title = "title ok";
  $scope.templateUrl = 'views/quantity-pad.html';
  $scope.templateUrl = 'myPopoverTemplate.html';

  // --------------------------
  // delete saleItem using sequence
  // --------------------------
  var deleteSaleItemBySequence = function(sequence) {
    for (var idx in $scope.saleItems) {
      var item = $scope.saleItems[idx];
      if (item.sequence == sequence) {
        $scope.saleItems.splice(idx, 1);
        break;
      }
    }
    return $scope.saleItems.length;
  }

  // --------------------------
  // get saleItem using sequence
  // --------------------------
  var getSaleItemBySequence = function(sequence) {
    for (var idx in $scope.saleItems) {
      var item = $scope.saleItems[idx];
      if (item.sequence == sequence) {
        return item;
      }
    }
    return null;
  }

  // --------------------------
  // get last saleItem
  // --------------------------
  var getLastestSaleItem = function() {
    var len = $scope.saleItems.length;
    if (len > 0) {
      var item = $scope.saleItems[0];
      return item;
    }
    return null;
  }

  // --------------------------
  // get sequence number from saleItem by productId
  // --------------------------
  var getSequenceNumberByProductId = function(productId) {
    for (var idx in $scope.saleItems) {
      var item = $scope.saleItems[idx];
      if (item.product_id == productId) {
        return item.sequence;
      }
    }
    return null;
  }

  // --------------------------
  // clear sellItem structure
  // --------------------------
  var clearSellItems = function() {
    //console.log("BEFORE saleItems.length : " + $scope.saleItems.length);
    $scope.saleItems.length = 0;
    //console.log("AFTER  saleItems.length : " + $scope.saleItems.length);
  }

  // --------------------------
  // get price book
  // --------------------------
  var getPriceBook = function(callback, productId, outletId, productQty, customerGroupId) {
    var searchInfo = {
      'productId': productId,
      'outletId': outletId,
      'pqty': productQty,
      'customergroupId': customerGroupId
    }
    $scope.ds.getPriceBook(callback, searchInfo);
  }

  // --------------------------
  // get Product
  // --------------------------
  var getProduct = function(callback, productId) {
    var searchInfo = {
      'id': productId
    };
    $scope.ds.getProduct(callback, searchInfo);
  }

  // --------------------------
  // add new sellItem structure using price book
  // --------------------------
  var addSellItem = function(quickKey, saleProduct, priceBook) {
    var saleItem = {};
    saleItem.product_id = priceBook.product_id;
    saleItem.name = saleProduct.name;
    saleItem.supply_price = saleProduct.supply_price;
    saleItem.price = priceBook.price;
    saleItem.price_include_tax = priceBook.price_include_tax;
    saleItem.tax = priceBook.tax;
    saleItem.tax_rate = saleProduct.tax_rate;
    saleItem.discount = priceBook.discount;
    saleItem.qty = 1;
    saleItem.loyalty_value = priceBook.loyalty_value;
    saleItem.sequence = $rootScope.registerSale.sequence++;
    saleItem.status = "sale_items_status_open";
    $scope.saleItems.unshift(saleItem);
    return saleItem;
  }

  // --------------------------
  // update sellItem structure using price book
  // --------------------------
  var additionSellItemQty = function(lastestSaleItem, quickKey, saleProduct, priceBook) {
    lastestSaleItem.qty = lastestSaleItem.qty + 1;
    lastestSaleItem.supply_price = saleProduct.supply_price;
    lastestSaleItem.price = priceBook.price;
    lastestSaleItem.price_include_tax = priceBook.price_include_tax;
    lastestSaleItem.tax = priceBook.tax;
    lastestSaleItem.discount = priceBook.discount;
    return lastestSaleItem;
  }

  // --------------------------
  // addition to registerSale structure using saleItem
  // --------------------------
  var additionRegisterSaleTotal = function(saleItem) {
    $rootScope.registerSale.total_cost += saleItem.supply_price * saleItem.qty;
    $rootScope.registerSale.total_price += saleItem.price * saleItem.qty;
    $rootScope.registerSale.total_price_incl_tax += saleItem.price_include_tax * saleItem.qty;
    $rootScope.registerSale.total_discount += saleItem.discount * saleItem.qty;
    $rootScope.registerSale.total_tax += saleItem.tax * saleItem.qty;
  }

  // --------------------------
  // subtraction to registerSale structure using saleItem
  // --------------------------
  var subtractionRegisterSaleTotal = function(saleItem) {
    $rootScope.registerSale.total_cost -= saleItem.supply_price * saleItem.qty;
    $rootScope.registerSale.total_price -= saleItem.price * saleItem.qty;
    $rootScope.registerSale.total_price_incl_tax -= saleItem.price_include_tax * saleItem.qty;
    $rootScope.registerSale.total_discount -= saleItem.discount * saleItem.qty;
    $rootScope.registerSale.total_tax -= saleItem.tax * saleItem.qty;
  }

  // --------------------------
  // clear registerSale structure
  // --------------------------
  var clearRegisterSaleTotal = function() {
    $rootScope.registerSale.total_cost = 0;
    $rootScope.registerSale.total_price = 0;
    $rootScope.registerSale.total_price_incl_tax = 0;
    $rootScope.registerSale.total_discount = 0;
    $rootScope.registerSale.total_tax = 0;
    $rootScope.registerSale.total_payment = 0;
  }

  //TODO: Get Outlet ID

  //TODO: Get User Group ID

  //TODO: Get UUID for RegisterSaleItem
  function getUUID() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
      var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8);
      return v.toString(16);
    });
  }

  function getTimeString() {
    var now = new Date();
    return $filter('date')(now, 'yyyy-MM-dd HH:mm:ss', '+1200'); //TODO: timezone
  }

  function getUnixTimestamp() {
    return Math.floor(new Date().getTime() / 1000);
  }

  // --------------------------
  // Logic for Payment
  // --------------------------
  var payRegisterSale = function(saleID, status) {
    var inputRegisterSalesItems = [];
    var saleUUID = getUUID();
    var now = getUnixTimestamp();

    var config = LocalStorage.getConfig();
    var inputRegisterSales = {
      'id': saleUUID,
      'status': status,
      'total_cost': $rootScope.registerSale.total_cost,
      'total_price': $rootScope.registerSale.total_price,
      'total_price_incl_tax': $rootScope.registerSale.total_price_incl_tax,
      'total_discount': $rootScope.registerSale.total_discount,
      'total_tax': $rootScope.registerSale.total_tax,
    }
    var data = [];
    data.push(inputRegisterSales);

    //$scope.ds.saveRegisterSales(function(rs) {
    //  console.log(rs);
    //}, data);
  }

  // --------------------------
  // Save RegisterSales
  // --------------------------
  var saveRegisterSales = function(saleID, status) {
    var config = LocalStorage.getConfig();
    var data = {
      'id': saleID,
      'register_id': config.register_id,
      'user_id': config.user_id,
      'user_name': config.user_name,
      'customer_id': config.default_customer_id,
      'customer_code': "12345678",      //TODO: customer_code
      'customer_name': "New Customer",  //TODO: customer_name
      'xero_invoice_id': null,
      'receipt_number': $rootScope.registerSale.receipt_number,
      'status': status,
      'total_cost': $rootScope.registerSale.total_cost,
      'total_price': $rootScope.registerSale.total_price,
      'total_price_incl_tax': $rootScope.registerSale.total_price_incl_tax,
      'total_discount': $rootScope.registerSale.total_discount,
      'total_tax': $rootScope.registerSale.total_tax,
      'note': null,
      'sale_date': null,
    }
    var inputData = [];
    inputData.push(data);
    $scope.ds.saveRegisterSales(null, inputData);
  }

  // --------------------------
  // Delete RegisterSales
  // --------------------------
  var deleteRegisterSales = function(saleID) {
    var data = {
      'id': saleID
    }
    //TODO: change to status $scope.ds.deleteRegisterSalePayments(data);
  }

  // --------------------------
  // End RegisterSale
  // --------------------------
  var endRegisterSale = function(status) {
    var saleID = LocalStorage.getSaleID();
    var suc = function() {
      // Clear Register Sale Item in UI
      clearSellItems();

      // Clear Register Sale Total Section
      clearRegisterSaleTotal();

      // clear RegisterSaleID
      LocalStorage.clearSaleID();

      // Update View
      $scope.$apply();
    }
    updateRegisterSale(saleID, status, suc);  //TODO: layby closed / onaccount_closed
  }

  // --------------------------
  // Update RegisterSale
  // --------------------------
  var updateRegisterSale = function(saleID, status, suc) {
    var now = getUnixTimestamp();
    var config = LocalStorage.getConfig();
    var data =[];
    if(status != null) {
      data = {
        'id': saleID,
        'status': status,
        'sale_date': now,
        'total_cost': $rootScope.registerSale.total_cost,
        'total_price': $rootScope.registerSale.total_price,
        'total_price_incl_tax': $rootScope.registerSale.total_price_incl_tax,
        'total_discount': $rootScope.registerSale.total_discount,
        'total_tax': $rootScope.registerSale.total_tax,
      }
    } else {
      data = {
        'id': saleID,
        'total_cost': $rootScope.registerSale.total_cost,
        'total_price': $rootScope.registerSale.total_price,
        'total_price_incl_tax': $rootScope.registerSale.total_price_incl_tax,
        'total_discount': $rootScope.registerSale.total_discount,
        'total_tax': $rootScope.registerSale.total_tax,
      }
    }
    $scope.ds.changeRegisterSales(data, suc);
  }

  // --------------------------
  // Save SaleItem to RegisterSaleItems
  // --------------------------
  var saveRegisterSaleItem = function(saleItems, saleID, status) {
    var inputValue = [];
    for(var idx in saleItems) {
      var item = saleItems[idx];
      var uuid = getUUID();
      var input = {
        'id': uuid,
        'sale_id': saleID,
        'product_id': item.product_id,
        'name': item.name,
        'quantity': item.qty,
        'supply_price': item.supply_price,
        'price': item.price,
        'price_include_tax': item.price_include_tax,
        'tax': item.tax,
        'tax_rate': item.tax_rate,
        'discount': item.discount,
        'loyalty_value': item.loyalty_value,
        'sequence': item.sequence,
        'status': status,
      };
      inputValue.push(input);
    }
    $scope.ds.saveRegisterSaleItems(null, inputValue);
  }

  // --------------------------
  // Update RegisterSaleItems
  // --------------------------
  var updateRegisterSaleItems = function(saleItem, saleID, status) {
    var data = {
      'sale_id': saleID,
      'product_id': saleItem.product_id,
      'name': saleItem.name,
      'quantity': saleItem.qty,
      'supply_price': saleItem.supply_price,
      'price': saleItem.price,
      'price_include_tax': saleItem.price_include_tax,
      'tax': saleItem.tax,
      'tax_rate': saleItem.tax_rate,
      'discount': saleItem.discount,
      'loyalty_value': saleItem.loyalty_value,
      'sequence': saleItem.sequence,
      'status': status,
    };
    $scope.ds.updateRegisterSaleItems(data);
  }

  // --------------------------
  // Get SaleItems to RegisterSaleItems
  // --------------------------
  var getRegisterSaleItems = function(saleID, status, suc, err) {
    var data = {
      'sale_id': saleID,
      'status': status,
    };
    $scope.ds.getRegisterSaleItems(data, suc, err);
  }

  // --------------------------
  // Delete SaleItem from RegisterSaleItems
  // --------------------------
  var deleteRegisterSaleItem = function(saleItem, saleID) {
    var delInfo = {
      'sale_id': saleID,
      'sequence': saleItem.sequence
    };
    //TODO: change to status $scope.ds.deleteRegisterSaleItems(delInfo);
  }

  var bootstrapSystem = function() {
    debug("INIT: checking for the init of the config table");
    var config = LocalStorage.getConfig();
    var register_id = config.register_id;

    debug("INIT: checking for the init of the Web SQL Database");
    //$scope.ds.dropAllLocalDataStore();  //TODO: Drop Table
    $scope.ds.initLocalDataStore();

    debug("REFRESH config");
    debug("REQUEST: config >>>>>>>>>>>>>>>>>>>>>");

    $http.get('/api/config.json')
      .then(function(response) {
        debug("REQUEST: config, success handler");

        if (response.data == null) {
          debug("REQUEST: config, [WARNING] empty data]");
        } else {
          LocalStorage.saveConfig(response.data);
          console.log("REQUEST: config : %o", response.data);
        }

        debug("REFRESH taxes");
        debug("REQUEST: taxes >>>>>>>>>>>>>>>>>>>>>");
        return $http.get('/api/taxes.json');
      }).then(function(response) {
        debug("REQUEST: taxes, success handler");

        if (response.data == null) {
          debug("REQUEST: taxes, [WARNING] empty data]");
        } else {
          debug(response.data);
          console.log("REQUEST: taxes : %o", response.data);
        }

        debug("REFRESH payment types");
        debug("REQUEST: payment types >>>>>>>>>>>>>>>>>>>");
        return $http.get('/api/payment_types.json');
      }).then(function(response) {
        debug("REQUEST: payment types, success handler");

        //TODO: saveRegisterPaymentTypes log
        if (response.data == null) {
          debug("REQUEST: payment types, [WARNING] empty data]");
        } else {
          $scope.ds.saveRegisterPaymentTypes(response.data);
          console.log("REQUEST: payment types : %o", response.data);
        }

        debug("REFRESH products");
        debug("REQUEST: products >>>>>>>>>>>>>>>>>>>>>");
        return $http.get('/api/products.json');
      }).then(function(response) {
        debug("REQUEST: products, success handler");

        //TODO: saveProducts log
        if (response.data == null) {
          debug("REQUEST: product, [WARNING] empty data]");
        } else {
          $scope.ds.saveProducts(null, response.data);
          console.log("REQUEST: product : %o", response.data);
        }

        debug("REFRESH registers");
        debug("REQUEST: registers >>>>>>>>>>>>>>>>>>>>>");
        return $http.get('/api/registers.json');
      }).then(function(response) {
        debug("REQUEST: registers, success handler");

        if (response.data == null) {
          debug("REQUEST: registers, [WARNING] empty data]");
        } else {
          console.log("REQUEST: registers : %o", response.data);

          debug("current register_id: " + register_id);
          var registers = response.data;
          if (registers.length > 1) {
            openRegisterSelector(response.data);
          } else {
            LocalStorage.saveRegister(registers[0]);
            switchRegister(registers[0]);
          }
        }
      }, function(response) {
        debug("REQUEST: data, error handler");
        if (401 == response.status) {
          window.location = "/signin";
        }

        debug("ERROR: There was a problem with the offline access.  Please try refreshing the page.");
        debug(response);
      });
  }

  var checkLocalSystem = function(param) {
    var test = window.localStorage.getItem("ONZSAPOS_REGISTER");
    return "undefined" != test && null != test;
  }

  var refreshConfig = function(callback) {
    debug("REFRESH config");
    debug("REQUEST: config >>>>>>>>>>>>>>>>>>>>>");

    $http.get('/api/config.json')
      .then(function(response) {
        debug("REQUEST: config, success handler");
        debug(response.data);

        callback();
      }, function (response) {
        debug("REQUEST: config, error handler");
        if (401 == response.status) {
          window.location = "/signin";
        }

        debug("ERROR: There was a problem with the offline access (config).  Please try refreshing the page.");
        debug(response);

        callback();
      });
  }

  var refreshRegisters = function(callback) {
    debug("REFRESH registers");
    debug("REQUEST: registers >>>>>>>>>>>>>>>>>>>>>");

    $http.get('/api/registers.json')
      .then(function(response) {
        debug("REQUEST: registers, success handler");
        debug(response.data);

        callback();
      }, function (response) {
        debug("REQUEST: registers, error handler");
        if (401 == response.status) {
          window.location = "/signin";
        }

        debug("ERROR: There was a problem with the offline access (registers).  Please try refreshing the page.");
        debug(response);

        callback();
      });
  }

  var refreshPaymentTypes = function(callback) {
    debug("REFRESH: payment types");
    debug("REQUEST: payment types >>>>>>>>>>>>>>>>>>>>>");

    $http.get('/api/payment_types.json')
      .then(function(response) {
        debug("REQUEST: payment types, success handler");

        callback();
      }, function (response) {
        debug("REQUEST: payment types, error handler");
        if (401 == response.status) {
          window.location = "/signin";
        }

        debug("ERROR: There was a problem with the offline access (payment types).  Please try refreshing the page.");
        debug(response);

        callback();
      });
  }

  var refreshTaxes = function(callback) {
    debug("REFRESH: taxes");
    debug("REQUEST: taxes >>>>>>>>>>>>>>>>>>>>>");

    $http.get('/api/taxes.json')
      .then(function(response) {
        debug("REQUEST: taxes, success handler");
        debug(response.data);

        callback();
      }, function (response) {
        debug("REQUEST: taxes, error handler");
        if (401 == response.status) {
          window.location = "/signin";
        }

        debug("ERROR: There was a problem with the offline access (taxes).  Please try refreshing the page.");
        debug(response);

        callback();
      });
  }

  var refreshProducts = function(callback) {
    debug("REFRESH: products");
    debug("REQUEST: products >>>>>>>>>>>>>>>>>>>>>");

    $http.get('/api/products.json')
      .then(function(response) {
        debug("REQUEST: products, success handler");
        debug(response.data);

        callback();
      }, function (response) {
        debug("REQUEST: products, error handler");
        if (401 == response.status) {
          window.location = "/signin";
        }

        debug("ERROR: There was a problem with the offline access (products).  Please try refreshing the page.");
        debug(response);

        callback();
      });
  }

  var refreshQuickKeys = function(register_id) {

    $http.get('/api/get_quick_keys.json?register_id=' + register_id)
      .then(function(response) {
        debug("REQUEST: quick keys, success handler");
        debug(response.data);
      }, function (response) {
        debug("REQUEST: quick keys, error handler");
        if (401 == response.status) {
          window.location = "/signin";
        }

        debug("ERROR: There was a problem with the offline access (quick keys).  Please try refreshing the page.");
        debug(response);
      });
  }

  var initOpenRegister = function() {
  }

  var openExistingOrNewRegister = function() {
  }

  var switchRegister = function(register) {
    debug("*** Switching register");
    debug("LOOKUP: Existing register from datastore – " + register);
    //debug("SAVE: Prepare register " + t.id);
    //debug("OPEN: register – " + r);

    //TODO: Check and change for Reopen register
    checkRegisterReopen(register);

    debug("register selected: " + register.id);
    LocalStorage.saveRegister(register);

    debug("REFRESH: quick keys");
    debug("REQUEST: quick keys >>>>>>>>>>>>>>>>>>>>>");

    $http.get('/api/get_quick_keys.json?register_id=' + register.id)
      .then(function(response) {
        debug("REQUEST: quick keys, success handler");

        if (response.data == null) {
          debug("REQUEST: quick keys, [WARNING] empty data]");
        } else {
          $scope.keyLayout = response.data.quick_keys;
          console.log("REQUEST: quick keys : ", response.data);
        }

        debug("REFRESH price books");
        debug("REQUEST: price books >>>>>>>>>>>>>>>>>>>>>");
        return $http.get('/api/get_price_books.json?register_id=' + register.id);
      }).then(function(response) {
        debug("REQUEST: price books, success handler");

        //TODO: Loop savePriceBook
        if (response.data == null) {
          debug("REQUEST: price books, [WARNING] empty data]");
        } else {
          for(var i=0; i<response.data.length; i++) {
            $scope.ds.savePriceBook(null, response.data[i]);
          }
          console.log("REQUEST: price books : ", response.data);
        }

      }, function(response) {
        debug("REQUEST: data, error handler");
        if (401 == response.status) {
          window.location = "/signin";
        }

        debug("ERROR: There was a problem with the offline access.  Please try refreshing the page.");
        debug(response);
      });
  }

  var openDialog = function() {
    var modalInstance = $modal.open({
      animation: true,
      templateUrl: '/app/tpl/dopayment.html',
    });
    console.log($modal);
    console.log(modalInstance);
  };

  $scope.openKeypad = function(evt) {
    evt.preventDefault();
    evt.stopPropagation();

    $scope.opened = true;
    console.log('clicked');
  };

  $scope.open = function(evt) {
    evt.preventDefault();
    evt.stopPropagation();

    $scope.opened = true;
  };

  var openPayment = function(data) {
    var modalPaymentInstance = $modal.open({
      templateUrl: '/app/tpl/payment.html',
      controller: 'PaymentController',
      backdrop: 'static',
      keyboard: false,
      size: 'lg',
      resolve: {
        items: function() {
          return data;
        }
      }
    });

    /**
     * callback logic from payment
     */
    modalPaymentInstance.result.then(function (payinfo) {
      console.table(payinfo);

      switch (payinfo.status) {
        case 'done' :
          console.log("SELL-C : done");
          endRegisterSale("sale_status_closed")
          break;
        case 'layby' :
          console.log("SELL-C : layby");
          endRegisterSale("sale_status_layby")
          break;
        case 'onaccount' :
          console.log("SELL-C : onaccount");
          endRegisterSale("sale_status_onaccount")
          break;
        default:
          //cancel
          console.log("SELL-C : cancel");
      }
    });
  };

  var openRegisterSelector = function(registers) {
    var modalInstance = $modal.open({
      templateUrl: 'template/popup/register.html',
      controller: 'RegisterSelectorController',
      backdrop: 'static',
      keyboard: false,
      size: 'sm',
      resolve: {
        items: function() {
          return registers;
        }
      }
    });

    modalInstance.result.then(function (selectedItem) {
      switchRegister(selectedItem);
    });
  };

  /**
   *  Recover Opened Sale Items
   */
  var recoverOpenedSale = function(){

    // Get Sale ID
    var sale_id = LocalStorage.getSaleID();
    if (sale_id != null) {
      var suc = function(rs) {
        for (var idx=0; idx<rs.length; idx++) {
          var item = rs[idx];
          var saleItem = {};
          saleItem.product_id = item.product_id;
          saleItem.name = item.name;
          saleItem.supply_price = item.supply_price;
          saleItem.price = item.price;
          saleItem.price_include_tax = item.price_include_tax;
          saleItem.tax = item.tax;
          saleItem.tax_rate = item.tax_rate;
          saleItem.discount = item.discount;
          saleItem.qty = item.quantity;
          saleItem.loyalty_value = item.loyalty_value;
          saleItem.sequence = item.sequence;
          saleItem.status = item.status;
          $scope.saleItems.unshift(saleItem);

          additionRegisterSaleTotal(saleItem);
        }
        $scope.$apply();
      }
      var err = function(e) {
          LocalStorage.clearSaleID();
      }

      // Get Opened Register sale Itmes
      getRegisterSaleItems(sale_id, "sale_items_status_open", suc, err);
    }
  };



  /**
   * Check for online status
   *    set to $rootScope.online = [true | false]
   */
  var isOnline = function () {
    $.ajax({
      url: '//localhost/',
      complete: function (jqXHR, statusText) {

        // check status
        if (statusText === 'success' && window.navigator.onLine == true) {
          $rootScope.online = true;
        } else {
          $rootScope.online = false;
        }
        console.log("[ONLINE] status : %s", $rootScope.online);

        setTimeout(function () {
          isOnline();
        }, 5000); // 5초
      }
    });
  };

  /**
   * Check for Local Storage Information
   *  @return [true | false]
   */
  var validateDataStore = function() {
    if ((LocalStorage.getRegister() == null) ||
        (LocalStorage.getRegisterID() == null) ||
        (LocalStorage.getConfig(true) == null))  {  //true : notUseDefault
      return false;
    }
    return true;
  }

  /**
   * Check and change for Reopen register
   */
  var checkRegisterReopen = function(register) {
    var savedRegister = LocalStorage.getRegister();
    if (register.register_open_count_sequence != savedRegister.register_open_count_sequence) {
      $rootScope.registerOpenCountSequence = register.register_open_count_sequence;
      $rootScope.registerSale.receipt_number = 1;
    }
  }

});

angular.module('OnzsaApp')

.controller('RegisterSelectorController', function($rootScope, $scope, $modalInstance, $window, locale, items) {
  $scope.items = items;

    console.log('loading here.....');

  $scope.cancel = function() {
    $modalInstance.dismiss('cancel');
    $window.location.href = '/dashboard';
  };

  $scope.selectItem = function(selectedItem) {
    $modalInstance.close(selectedItem);
  };

});

angular.module('OnzsaApp')

.factory('LocalStorage', ['$rootScope', 'localStorageService',  function($rootScope, localStorageService) {
  // The default config for register
  var defaultConfig = {
    version: null,
    user_hash: null,
    merchant_id: null,
    merchant_name: null,
    domain_prefix: null,
    business_type_id: null,
    default_customer_group_id: null,
    default_customer_id: null,
    default_no_tax_group_id: null,
    default_tax_id: null,
    discount_product_id: null,
    default_quick_key_id: null,
    default_currency: null,
    time_zone: null,
    display_price_tax_inclusive: null,
    allow_cashier_discount: null,
    allow_use_scale: null,
    retailer_id: null,
    outlet_id: null,
    outlet_name: null,
    enable_loyalty: null,
    loyalty_ratio: null,
    user_id: null,
    user_name: null,
    user_display_name: null,
    user_type: null,
  };

  // The config specified to the module globally.
  var globalConfig = {};

  var getConfigAll = function() {
    return JSON.parse(localStorageService.get('config'));
  };

  var getConfig = function(notUseDefault) {
    var config = getConfigAll();
    if (config == null || "object" != typeof config) {
      debug("GET CONFIG: local store config empty, setting up config defaults");
      if (notUseDefault == null || notUseDefault == false) {
        config = defaultConfig;
      }
    }
    return config;
  };

  var saveConfig = function(config) {
    angular.extend(globalConfig, config);
    localStorageService.set('config', JSON.stringify(globalConfig));
  };

  var saveRegister = function(register) {
    debug("saving register", + JSON.stringify(register));
    localStorageService.set('register', JSON.stringify(register));
    localStorageService.set('register_id', register.id);

    var config = { register_id: register.id };
    saveConfig(config);
  };

  var getRegister = function(saleID) {
    debug("get register");
    return JSON.parse(localStorageService.get('register'));
  };

  var getRegisterID = function(saleID) {
    debug("get register id");
    return localStorageService.get('register_id');
  };

  var saveSaleID = function(saleID) {
    debug("saving register sale id", + saleID);
    localStorageService.set('register_sale_id', saleID);
  };

  var getSaleID = function(saleID) {
    debug("get register sale id");
    return localStorageService.get('register_sale_id');
  };

  var clearSaleID = function() {
    debug("remove register sale id");
    localStorageService.remove('register_sale_id');
  };

  return {
    getConfig: getConfig,
    saveConfig: saveConfig,
    getRegister: getRegister,
    getRegisterID: getRegisterID,
    saveRegister: saveRegister,
    saveSaleID: saveSaleID,
    getSaleID: getSaleID,
    clearSaleID: clearSaleID,
  };
}]);

angular.module("template/popup/register.html", []).run(["$templateCache", function($templateCache) {
  $templateCache.put("template/popup/register.html",
    "<div class=\"modal-header\">\n" +
    "  <button class=\"pull-right confirm-close cancel\" type=\"button\" data-dismiss=\"modal\" aria-hidden=\"true\" data-ng-click=\"cancel()\">\n"+
    "    <i class=\"glyphicon glyphicon-remove\"></i>\n" +
    "  </button>\n" +
    "  <h4 class=\"modal-title\">Select a register</h4>\n" +
    "</div>\n" +
    "<div class=\"modal-body\">\n" +
    "  <div class=\"\" style=\"width: 246px; margin: auto;\" data-always-visible=\"1\" data-rail-visible=\"0\">\n" +
    "    <a class=\"btn icon-btn medium\" style=\"margin-left: 0px;\" data-ng-repeat=\"item in items\" data-ng-click=\"selectItem(item)\">\n" +
    "      <img class=\"img-responsive payment\" data-ng-src=\"/img/cheque.png\" alt=\"ETFPOS\" src=\"/img/cheque.png\">\n" +
    "      <div class=\"payment caption\">\n" +
    "        <span class=\"ng-binding\">{{item.name}}</span>\n" +
    "      </div>\n" +
    "    </a>\n" +
    "  </div>\n" +
    "</div>\n" +
    "<div class=\"modal-footer\">\n" +
    "  <button class=\"btn blue\" type=\"button\" data-dismiss=\"modal\" data-ng-click=\"cancel()\">Cancel</button>\n"+
    "</div>");
}]);

