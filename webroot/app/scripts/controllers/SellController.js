'use strict';

/**
 * @ngdoc function
 * @name OnzsaApp.controller:SellController
 *
 * @description
 * Controller of the OnzsaApp
 */
angular.module('OnzsaApp', [])

.controller('SellController', function($rootScope, $scope, $state, $location, $http, $modal, locale, LocalStorage) {

  $scope.$on('$viewContentLoaded', function() {   
    // initialize core components
    Metronic.initAjax();
    TableAdvanced.init();

    // define alias for local strage
    $scope.localstorage = Database_localstorage;

    // define alias for local Datastore
    $scope.ds = Datastore_sqlite;

    debug("INIT: Bootstrapping >>>>>>>>>>>>>>>>>>>>>");
    bootstrapSystem();
  });

  // set sidebar closed and body solid layout mode
  $rootScope.settings.layout.pageSidebarClosed = false;

  /*
  $rootScope.register.id = '55cfd1ed-4594-4e0f-8f76-14d84cf3b98e'; //TODO:
  $rootScope.register.user = {
    name: 'Goodexpert',
    id: '55b99423-ab28-4a16-b477-25e04cf3b98e', //TODO:
  };
  */

  $scope.doLogout = function() {
    console.log('doLogout');
  };

  $scope.doSetup = function() {
    console.log('doSetup');
  };

  $scope.voidSale = function() {
    console.log('voidSale');
  };

  $scope.doPayment = function() {
    console.log('doPayment');
    paySaleItems();
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
    },
  };

  $scope.function_keys = [
    angular.extend({position: 0}, $scope.functions['fn_void_sale']),
    angular.extend({position: 1}, $scope.functions['fn_do_discount']),
    angular.extend({position: 2}, $scope.functions['fn_do_line_price']),
    angular.extend({position: 3}, $scope.functions['fn_do_payment']),
    angular.extend({position: 4}, $scope.functions['fn_do_refund']),
    angular.extend({position: 5}, $scope.functions['fn_do_recall']),
    angular.extend({position: 6}, $scope.functions['fn_view_history']),
    angular.extend({position: 7}, $scope.functions['fn_view_daily_report']),
    angular.extend({position: 8}, $scope.functions['fn_close_register']),
    angular.extend({position: 9}, $scope.functions['fn_print_receipt']),
    angular.extend({position: 10}, $scope.functions['fn_open_cash_drawer']),
    angular.extend({position: 11}, $scope.functions['fn_do_setup']),
    angular.extend({position: 12}, $scope.functions['fn_do_logout']),
    angular.extend({position: 13}, $scope.functions['fn_do_nothing']),
    angular.extend({position: 14}, $scope.functions['fn_do_nothing']),
  ];
  $scope.customer_id = '55b99423-300c-4dff-90a4-25e04cf3b98e';  //TODO:

  $scope.priceBooks = [];
  $scope.modified = false;

  $scope.registerSale = {
    'receipt_number': 0,
    'total_cost': 0.0,
    'total_price': 0.0,
    'total_price_incl_tax': 0.0,
    'total_discount': 0.0,
    'total_tax': 0.0,
    'sequence': 1
  };
  $scope.saleItems = [];

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

  $scope.addSellItem = function(quickKey) {
    console.log('ok');
    /*
    var priceBook = null;
    var saleProduct = null;
    var lastestSaleItem = null;
    var saleItem = null;
    var productQty = 1;

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
            }
            //STEP 3.2.
            else {
              //STEP 3.3. Recalcurate to registerSale structure
              subtractionRegisterSaleTotal(lastestSaleItem);
              saleItem = additionSellItem(lastestSaleItem, quickKey, saleProduct, priceBook, productQty);
              additionRegisterSaleTotal(saleItem);
            }
            // Update View
            $scope.$apply();

            // Save to RegisterSaleItems : status_open
            saveSaleItems([saleItem]);

          } else {
            console.log("Not found PriceBook : " + quickKey.product_id);
          }
        }, quickKey.product_id, null, productQty, null);  //Get PriceBook
      } else {
        console.log("Not found Product : " + quickKey.product_id);
      }
    }, quickKey.product_id); //Get Product
    */
  };

  $scope.removeSellItem = function(saleItem) {
    deleteSaleItemBySequence(saleItem.sequence);
    subtractionRegisterSaleTotal(saleItem);
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

  var updateData = function() {
    $scope.registerSale.total_cost = 0;
    $scope.registerSale.total_price = 0;
    $scope.registerSale.total_price_incl_tax = 0;
    $scope.registerSale.total_discount = 0;
    $scope.registerSale.total_tax = 0;

    for (var idx in $scope.saleItems) {
      var saleItem = $scope.saleItems[idx];
    }
  }

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
      //var item = $scope.saleItems[len - 1];
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
  // get price book
  // --------------------------
  var getPriceBook = function(callback, productId, outletId, productQty, customerGroupId) {
    var searchInfo = {
      'productId': productId,
      'outletId': outletId,
      'pqty': productQty,
      'customergroupId': customerGroupId
    }
    ds.getPriceBook(function(rs) {
      callback(rs);
    }, searchInfo);
  }

  // --------------------------
  // get Product
  // --------------------------
  var getProduct = function(callback, productId) {
    var searchInfo = {
      'id': productId
    };
    ds.getProduct(function(rs) {
      callback(rs);
    }, searchInfo);
  }

  // --------------------------
  // add new sellItem structure using price book
  // --------------------------
  var addSellItem = function(quickKey, saleProduct, priceBook) {
    var saleItem = {};
    saleItem.product_id = priceBook.product_id;
    saleItem.name = saleProduct.name;
    saleItem.supply_price = saleProduct.supplier_price;
    saleItem.price = priceBook.price;
    saleItem.price_include_tax = priceBook.price_include_tax;
    saleItem.tax = priceBook.tax;
    saleItem.discount = priceBook.discount;
    saleItem.qty = 1;
    saleItem.loyalty_value = priceBook.loyalty_value;
    saleItem.sequence = $scope.registerSale.sequence++;
    $scope.saleItems.unshift(saleItem);
    return saleItem;
  }

  // --------------------------
  // update sellItem structure using price book
  // --------------------------
  var additionSellItem = function(lastestSaleItem, quickKey, saleProduct, priceBook) {
    lastestSaleItem.qty = lastestSaleItem.qty + 1;
    lastestSaleItem.supply_price = saleProduct.supplier_price;
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
    $scope.registerSale.total_cost += saleItem.supply_price * saleItem.qty;
    $scope.registerSale.total_price += saleItem.price * saleItem.qty;
    $scope.registerSale.total_price_incl_tax += saleItem.price_include_tax * saleItem.qty;
    $scope.registerSale.total_discount += saleItem.discount * saleItem.qty;
    $scope.registerSale.total_tax += saleItem.tax * saleItem.qty;
  }

  // --------------------------
  // subtraction to registerSale structure using saleItem
  // --------------------------
  var subtractionRegisterSaleTotal = function(saleItem) {
    $scope.registerSale.total_cost -= saleItem.supply_price * saleItem.qty;
    $scope.registerSale.total_price -= saleItem.price * saleItem.qty;
    $scope.registerSale.total_price_incl_tax -= saleItem.price_include_tax * saleItem.qty;
    $scope.registerSale.total_discount -= saleItem.discount * saleItem.qty;
    $scope.registerSale.total_tax -= saleItem.tax * saleItem.qty;
  }

  // --------------------------
  // Update or Save to Register Sale Items
  // --------------------------
  var saveRegisterSaleItem = function(saleItem) {

    var saveData = [{
      "id": "55d15778-a8c0-4086-a120-10304cf3b981",
      "sale_id": "null",
      "product_id": saleItem.product_id,
      "name": saleItem.product_name,
      "quantity": saleItem.qty,
      "supply_price": saleItem.supply_price,
      "price": saleItem.price,
      "price_include_tax": saleItem.price_include_tax,
      "tax": saleItem.tax,
      "tax_rate": saleItem.tax_rate,
      "discount": saleItem.discount,
      "loyalty_value": saleItem.loyalty_value,
      "sequence": saleItem.sequence,
      "status": "item_status_valid"
  }]

    var i=0;
    var len=searchs.length;
    for(; i < len; i++){
      var search = searchs[i];
      //console.log(search);
      ds.saveRegisterSalesItems(
          function(data){
            console.log(data)
          },
          saveData
      );
    }
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
  var paySaleItems = function() {
    var inputRegisterSalesItems = [];
    var saleUUID = getUUID();
    var now = getUnixTimestamp();

    for(var item in $scope.saleItems) {
      var uuid = getUUID();
      var input = {
        'id': uuid,
        'sale_id': saleUUID,
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
        'status': "sale_items_status_closed",
      };
      inputRegisterSalesItems.push(input);
    }

    var inputRegisterSales = {
      'id': saleUUID,
      'register_id': $rootScope.register.id,
      'user_id': $rootScope.register.user.id,
      'customer_id': $scope.customer_id,
      'xero_invoice_id': null,
      'receipt_number': $scope.registerSale.receipt_number,
      'status': "sale_items_status_closed",
      'total_cost': $scope.registerSale.total_cost,
      'total_price': $scope.registerSale.total_price,
      'total_price_incl_tax': $scope.registerSale.total_price_incl_tax,
      'total_discount': $scope.registerSale.total_discount,
      'total_tax': $scope.registerSale.total_tax,
      'note': null,
      'sale_date': now,
    }

    ds.saveRegisterAll(function(rs) {
      console.log(rs);
    }, inputRegisterSales, inputRegisterSalesItems);

  }

  // --------------------------
  // Save SaleItem to RegisterSaleItems
  // --------------------------
  var saveSaleItems = function(saleItems) {
    var inputValue = [];
    for(var idx in saleItems) {
      var item = saleItems[idx];
      var uuid = getUUID();
      var input = {
        'id': uuid,
        'sale_id': null,
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
        'status': "sale_items_status_open",
      };
      inputValue.push(input);
    }
    ds.saveRegisterSalesItems(function(rs) {
      callback(rs);
    }, inputValue);
  }

  var bootstrapSystem = function() {
    debug("INIT: checking for the init of the config table");
    var config = LocalStorage.getConfig();
    var register_id = config.register_id;

    debug("REFRESH config");
    debug("REQUEST: config >>>>>>>>>>>>>>>>>>>>>");

    $http.get('/api/config.json')
      .then(function(response) {
        debug("REQUEST: config, success handler");
        debug(response.data);
        LocalStorage.saveConfig(response.data);

        debug("REFRESH taxes");
        debug("REQUEST: taxes >>>>>>>>>>>>>>>>>>>>>");
        return $http.get('/api/taxes.json');
      }).then(function(response) {
        debug("REQUEST: taxes, success handler");
        debug(response.data);

        debug("REFRESH payment types");
        debug("REQUEST: payment types >>>>>>>>>>>>>>>>>>>>>");
        return $http.get('/api/payment_types.json');
      }).then(function(response) {
        debug("REQUEST: payment types, success handler");
        debug(response.data);

        debug("REFRESH products");
        debug("REQUEST: products >>>>>>>>>>>>>>>>>>>>>");
        return $http.get('/api/products.json');
      }).then(function(response) {
        debug("REQUEST: products, success handler");
        debug(response.data);

        debug("REFRESH registers");
        debug("REQUEST: registers >>>>>>>>>>>>>>>>>>>>>");
        return $http.get('/api/registers.json');
      }).then(function(response) {
        debug("REQUEST: registers, success handler");
        debug(response.data);

        debug("current register_id: " + register_id);
        var registers = response.data;

        if (registers.length > 1) {
          openRegisterSelector(response.data);
        } else {
          LocalStorage.saveRegister(registers[0]);
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
    debug("REFRESH Registers");
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

        debug("ERROR: There was a problem with the offline access (Registers).  Please try refreshing the page.");
        debug(response);

        callback();
      });
  }

  var refreshPaymentTypes = function(callback) {
    debug("REFRESH: Payment types");
    debug("REQUEST: payment types >>>>>>>>>>>>>>>>>>>>>");

    $http.get('/api/payment_types.json')
      .then(function(response) {
        debug("REQUEST: payment types, success handler");
        debug(response.data);

        callback();
      }, function (response) {
        debug("REQUEST: payment types, error handler");
        if (401 == response.status) {
          window.location = "/signin";
        }

        debug("ERROR: There was a problem with the offline access (PaymentTypes).  Please try refreshing the page.");
        debug(response);

        callback();
      });
  }

  var refreshTaxes = function(callback) {
    debug("REFRESH: Taxes");
    debug("REQUEST: Taxes >>>>>>>>>>>>>>>>>>>>>");

    $http.get('/api/taxes.json')
      .then(function(response) {
        debug("REQUEST: Taxes, success handler");
        debug(response.data);

        callback();
      }, function (response) {
        debug("REQUEST: Taxes, error handler");
        if (401 == response.status) {
          window.location = "/signin";
        }

        debug("ERROR: There was a problem with the offline access (Taxes).  Please try refreshing the page.");
        debug(response);

        callback();
      });
  }

  var refreshProducts = function(callback) {
    debug("REFRESH: Products");
    debug("REQUEST: Products >>>>>>>>>>>>>>>>>>>>>");

    $http.get('/api/products.json')
      .then(function(response) {
        debug("REQUEST: Products, success handler");
        debug(response.data);

        callback();
      }, function (response) {
        debug("REQUEST: Products, error handler");
        if (401 == response.status) {
          window.location = "/signin";
        }

        debug("ERROR: There was a problem with the offline access (Products).  Please try refreshing the page.");
        debug(response);

        callback();
      });
  }

  var switchRegister = function() {
  }

  var getPriceBooks = function() {
    $http.get('/api/get_price_books.json')  //TODO: need to parameter setting with register_id
      .then(function(response) {
        console.log(response.data);
        for(var priceBook in response.data) {
          if(priceBook.product_id == "55d0fdef-d5f0-416e-a0e3-0c884cf3b98e") {
            console.log("GOT IT!!");
          }
        }
      }, function (response) {
        console.log(response);
      });
  }

  var getQuickKeys = function() {
    $http.get('/api/get_quick_keys.json')  //TODO: need to parameter setting with register_id
      .then(function(response) {
        console.log(response);
        $scope.keyLayout = response.data.quick_keys;
        $scope.image = '/img/sample_1.png';
        console.log($scope.keyLayout);
      }, function (response) {
        console.log(response);
      });
  }

  $scope.openDialog = function() {
    var modalInstance = $modal.open({
      animation: true,
      templateUrl: 'tpl/select_register.html',
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
      debug("register selected: " + selectedItem.id);
      LocalStorage.saveRegister(selectedItem);
    });
  };

});

angular.module('OnzsaApp')

.controller('RegisterSelectorController', function($rootScope, $scope, $modalInstance, $window, locale, items) {
  $scope.items = items;

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

  var getConfig = function() {
    var config = getConfigAll();
    if (config == null || "object" != typeof config) {
      debug("GET CONFIG: local store config empty, setting up config defaults");
      config = defaultConfig;
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

  return {
    getConfig: getConfig,
    saveConfig: saveConfig,
    saveRegister: saveRegister,
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

