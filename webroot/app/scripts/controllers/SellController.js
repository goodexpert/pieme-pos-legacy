'use strict';

/**
 * @ngdoc function
 * @name OnzsaApp.controller:SellController
 * @description
 * # SellController
 * Controller of the OnzsaApp
 */
angular.module('OnzsaApp')
  .controller('SellController', function($rootScope, $scope, $ocLazyLoad) {
    $scope.$on('$viewContentLoaded', function() {   
      // initialize core components
      Metronic.initAjax();
      TableAdvanced.init();
    });

    // set sidebar closed and body solid layout mode
    $rootScope.settings.layout.pageSidebarClosed = false;

    $rootScope.register.user = {
      name: 'Goodexpert'
    };

    var functions = [
      { name: 'Void', callback: $scope.voidSale },
      { name: 'Payment', callback: $scope.doPayment },
      { name: 'No Sale', callback: $scope.openCashDrawer },
      { name: 'Print Receipt', callback: $scope.printReceipt },
      { name: 'Refund', callback: $scope.doRefund },
      { name: 'Discount', callback: $scope.doDiscount },
      { name: 'Setup', callback: $scope.doSetup },
      { name: 'Logout', callback: $scope.doLogout },
      { name: 'Sales History', callback: $scope.viewHistory },
      { name: 'Daily Snapshot', callback: $scope.viewDailyReport },
      { name: 'End of Day', callback: $scope.closeRegister },
      { name: 'Line Price', callback: $scope.doLinePrice },
      { name: 'Recall Sales', callback: $scope.doRecall},
      { name: 'Payment', callback: $scope.doPayment },
      { name: 'Payment', callback: $scope.doPayment },
      /*
      { name: 'Payment', callback: $scope.doPayment },
      { name: 'Payment', callback: $scope.doPayment },
      { name: 'Payment', callback: $scope.doPayment },
      */
    ];
    $scope.functions = functions;

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
    quickKey.product_id = '5f0f16c2-ea26-11e4-a12b-6e9bc1f483b5';
    quickKey.name = 'Item Long title item';
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
    };

    $scope.removeSellItem = function(saleItem) {
      for (var idx in $scope.saleItems) {
        var item = $scope.saleItems[idx];
        if (item.sequence == saleItem.sequence) {
          $scope.saleItems.splice(idx, 1);
          break;
        }
      }

      $scope.registerSale.total_cost -= saleItem.supply_price * saleItem.qty;
      $scope.registerSale.total_price -= saleItem.price * saleItem.qty;
      $scope.registerSale.total_price_incl_tax -= saleItem.price * saleItem.qty;
      $scope.registerSale.total_discount -= saleItem.discount * saleItem.qty;
      $scope.registerSale.total_tax -= saleItem.tax * saleItem.qty;
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
      console.log('printReceipt');
    };

    $scope.doSetup = function() {
      console.log('doSetup');
    };

    $scope.doLogout = function() {
      console.log('doLogout');
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
  });
