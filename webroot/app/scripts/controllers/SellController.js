'use strict';

/**
 * @ngdoc function
 * @name OnzsaApp.controller:SellController
 * @description
 * # SellController
 * Controller of the OnzsaApp
 */
angular.module('OnzsaApp')
  .controller('SellController', function($rootScope, $scope, $http, locale) {
    $scope.$on('$viewContentLoaded', function() {   
      // initialize core components
      Metronic.initAjax();
      TableAdvanced.init();

      locale.setLocale("ko-KR");
      getQuickKeys();
    });

    var ds = Datastore_sqlite; // define alias for local Datastore

    // set sidebar closed and body solid layout mode
    $rootScope.settings.layout.pageSidebarClosed = false;

    $rootScope.register.user = {
      name: 'Goodexpert'
    };

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
    };

    $scope.viewHistory = function() {
      console.log('viewHistory');
    };

    $scope.viewDailyReport = function() {
      console.log('viewDailyReport');
    };

    $scope.closeRegister = function() {
      console.log('closeRegister');
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
        callback: $scope.doRecall
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
        name    : 'No Sale',
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

    $scope.priceBooks = [];
    $scope.quickKeys = [];
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

    var quickKey = {};
    quickKey.product_id = '0f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #0';
    quickKey.image = '/img/sample_1.png';
    quickKey.supply_price = 0.8;
    quickKey.price = 1.0;
    quickKey.price_include_tax = 1.0;
    quickKey.tax = 0.0;
    quickKey.background = '';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '1f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #1';
    quickKey.image = '/img/sample_2.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 1.0;
    quickKey.price_include_tax = 1.0;
    quickKey.tax = 0.0;
    quickKey.background = '';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '2f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #2';
    quickKey.image = '/img/sample_3.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 1.0;
    quickKey.price_include_tax = 1.0;
    quickKey.tax = 0.0;
    quickKey.background = '#fff';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '3f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #3';
    quickKey.image = '/img/sample_4.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 3.0;
    quickKey.price_include_tax = 3.0;
    quickKey.tax = 0.0;
    quickKey.background = '#fff';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '55b99424-0a70-404c-8788-25e04cf3b98e';
    quickKey.name = 'Item #0';
    quickKey.image = '/img/sample_1.png';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '55cd3110-c5f4-4b59-828a-56c24cf3b98e';
    quickKey.name = 'Item #1';
    quickKey.image = '/img/sample_2.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

    quickKey = {};
    quickKey.product_id = '4f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item #5';
    quickKey.image = '/img/sample_5.jpg';
    quickKey.supply_price = 0.8;
    quickKey.price = 2.0;
    quickKey.price_include_tax = 2.0;
    quickKey.tax = 0.0;
    quickKey.background = 'red';
    $scope.quickKeys.push(quickKey);

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
      var priceBook = null;
      var saleProduct = null;
      var lastestSaleItem = null;
      var saleItem = null;
      var productQty = 1;

      console.log(quickKey.product_id);

      //STEP 0. Get SaleProduct by ProductId
      getSaleProduct(function (rs) {
        if (rs.length > 0) {
          saleProduct = rs[0];
          //console.log("Get SaleProduct");

          //STEP 1. Get lastest sellItem from saleItem
          lastestSaleItem = getLastestSaleItem();
          //console.log("Get Lastest SaleItem");

          //STEP 2. If same item, increase sellItem's quantity
          if (lastestSaleItem && lastestSaleItem.product_id == quickKey.product_id) {
            //console.log("Same SaleItem");
            productQty = lastestSaleItem.qty + 1;
            //console.log("productQty: " + productQty);
          }

          //STEP 3. Get PriceBook by ProductID and quantity
          getPriceBook(function (rs) {
            if (rs.length > 0) {
              priceBook = rs[0];
              //console.log("Get priceBook");

              //STEP 3.1. Set data to sellItem structure
              if (productQty == 1) {
                saleItem = addSellItem(quickKey, saleProduct, priceBook);
                //console.log("Add new SaleItem");

                //STEP 3.3. Recalcurate to registerSale structure
                additionRegisterSaleTotal(saleItem);
                //console.log("Recalcurate to Total");
              }
              //STEP 3.2.
              else {
                //STEP 3.3. Recalcurate to registerSale structure
                subtractionRegisterSaleTotal(lastestSaleItem);
                //console.log("subtraction from Total");

                saleItem = additionSellItem(lastestSaleItem, quickKey, saleProduct, priceBook, productQty);
                //console.log("Add Qty same SaleItem");

                //STEP 3.3. Recalcurate to registerSale structure
                additionRegisterSaleTotal(saleItem);
                //console.log("Recalcurate to Total");
              }

              // Update or Save to Register Sale Items


              // Update View
              $scope.$apply();
              //console.log($scope.saleItems);
              //console.log($scope.registerSale);
            }
          }, quickKey.product_id, null, productQty, null);
        }
      }, quickKey.product_id);
      /*
      var saleItem = {};
      saleItem.product_id = quickKey.product_id;
      saleItem.name = quickKey.name;
      saleItem.supply_price = quickKey.supply_price;
      saleItem.price = quickKey.price;
      saleItem.price_include_tax = quickKey.price_include_tax;
      saleItem.tax = quickKey.tax;
      saleItem.discount = 0;
      saleItem.qty = 1;
      saleItem.sequence = $scope.registerSale.sequence++;
      $scope.saleItems.push(saleItem);

      $scope.registerSale.total_cost += saleItem.supply_price * saleItem.qty;
      $scope.registerSale.total_price += saleItem.price * saleItem.qty;
      $scope.registerSale.total_price_incl_tax += saleItem.price * saleItem.qty;
      $scope.registerSale.total_discount += saleItem.discount * saleItem.qty;
      $scope.registerSale.total_tax += saleItem.tax * saleItem.qty;
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
      };
      ds.getPriceBook(function(rs) {
        callback(rs);
      }, searchInfo);
    }

    // --------------------------
    // get SaleProduct
    // --------------------------
    var getSaleProduct = function(callback, productId) {
      var searchInfo = {
        'id': productId
      };
      ds.getSaleProduct(function(rs) {
        callback(rs);
      }, searchInfo);
    }

    // --------------------------
    // add new sellItem structure using price book
    // --------------------------
    var addSellItem = function(quickKey, saleProduct, priceBook) {
      var saleItem = {};
      saleItem.product_id = priceBook.product_id;
      saleItem.name = quickKey.name;
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
        "status": "sale_item_status_open"
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


    var getPriceBooks = function() {
      $http.get('/api/get_price_books.json')
        .then(function(response) {
          console.log(response.data);
        }, function (response) {
          console.log(response);
        });
    }

    var getQuickKeys = function() {
      $http.get('/api/get_quick_keys.json')
        .then(function(response) {
          $scope.keyLayout = response.data.quick_keys;
          $scope.image = '/img/sample_1.png';
          console.log($scope.keyLayout);
        }, function (response) {
          console.log(response);
        });
    }
  });
