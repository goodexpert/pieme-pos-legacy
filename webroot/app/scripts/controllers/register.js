'use strict';

/**
 * @ngdoc function
 * @name OnzsaApp.controller:RegisterController
 *
 * @description
 * Controller of the OnzsaApp
 */
angular.module('OnzsaApp', [])

.controller('RegisterController', function($rootScope, $scope, $state, $stateParams,hotkeys, $location, $http, $modal, $q, $timeout, $filter, $compile, locale, LocalStorage, Register, DTOptionsBuilder, DTColumnDefBuilder, DTColumnBuilder, DTInstances) {
  $scope.$on('$viewContentLoaded', function() {
    // initialize core components
    Metronic.initAjax();
  });

  // set sidebar closed and body solid layout mode
  //$rootScope.settings.layout.pageSidebarClosed = false;
  //openSplash();
  $rootScope.loadingInstance = null;
  $rootScope.registers_count = 1;

  // initialize the register service
  openLoading();
  Register.init()
    .then(function(response) {
      if (response.status == "waitRegister") {
        debug('register open selector');
        $rootScope.registers_count = response.data.length;
        openRegisterSelector(response.data);
      } else if (response.status == "openRegister") {
        debug('register open check');
        openRegister(response.data);
      } else if (response.status == "initialized") {
        debug('register initialized');
        preparedRegister({"name":"register.ready"});
      }
    }, function(response) {
      debug('register initialize failed');
      closeLoading();
      window.location.href = '/dashboard';
    });

  if ($stateParams["saleId"] != null) {
    debug("set state params[ saleId ] : %s", $stateParams["saleId"]);
    reload($stateParams["saleId"]);
  }

  // Broadcast
  $scope.$on('quickkey.ready', getQuickKeyLayout);
  $scope.$on('saleItems.added', refreshSaleItems);
  $scope.$on('saleItems.removed', refreshSaleItems);
  $scope.$on('saleItems.updated', refreshSaleItems);
  $scope.$on('sale.ended', refreshSale);
  $scope.$on('sale.reloaded', reloadedSale);
  $scope.$on('register.ready', preparedRegister);
  $scope.$on('register.failed', preparedRegister);
  $scope.$on('loading.open', openLoading);
  $scope.$on('loading.close', closeLoading);

  hotkeys.add({
    combo: 'f6',
    description: 'make a payment',
    callback: function() {
      $scope.doPayment();
    }
  });

  hotkeys.add({
    combo: 'esc',
    description: 'Void all sales',
    callback: function() {
      $scope.voidSale();
    }
  });

  // initialize the sale items table
  var vm = this;
  vm.dtInstance = {};
  vm.dtOptions = DTOptionsBuilder
    .fromFnPromise(function() {
      return getSaleItems();
    })
    .withDOM('t')
    .withScroller()
    .withOption('autoWidth', false)
    .withOption('deferRender', true)
    .withOption("orderFixed", [ 0, 'desc' ])
    .withOption('scrollY', 215)
    .withOption('createdRow', function(row, data, dataIndex) {
      // Recompiling so we can bind Angular directive to the DT
      $compile(angular.element(row).contents())($scope);
    });

  vm.dtColumns = [
    DTColumnBuilder
      .newColumn('sequence')
      .notVisible(),
    DTColumnBuilder
      .newColumn('name')
      .withTitle('Item')
      .notSortable()
      .withClass('dt-body-left sale-item-name')
      .renderWith(function(data, type, full) {
        return '<a href="javascript:;">' + data + '</a>';
      }),
    DTColumnBuilder
      .newColumn('quantity')
      .withTitle('Qty')
      .notSortable()
      .withClass('dt-head-center dt-body-right sale-item-qty')
      .renderWith(function(data, type, full) {
        return '<a href="javascript:;" data-ng-click="setQuantity(' + full.sequence + ')">' + data + '</a>';
      }),
    DTColumnBuilder
      .newColumn('sale_price')  //TODO: price_incl_tax
      .withTitle('Unit Price')
      .notSortable()
      .withClass('dt-head-center dt-body-right sale-item-discount')
      .renderWith(function(data, type, full) {
        var number = full.sale_price + full.tax;
        return '<a href="javascript:;" data-ng-click="setPrice(' + full.sequence + ')">' + $filter('currency')(number, '$', 2) + '</a>';
      }),
    DTColumnBuilder
      .newColumn('')
      .withTitle('Price')
      .withClass('dt-head-center dt-body-right sale-item-price')
      .notSortable()
      .renderWith(function(data, type, full) {
        //TODO: price_incl_tax   var number = full.quantity * full.price_incl_tax;
        var number = full.quantity * (full.sale_price + full.tax);
        return $filter('currency')(number, '$', 2);
      }),
    DTColumnBuilder
      .newColumn('')
      .withClass('dt-head-center dt-body-center sale-item-remove')
      .notSortable()
      .renderWith(function(data, type, full) {
        return '<button class="btn btn-xs btn-circle btn-danger" data-ng-click="removeItem('+ full.sequence +')">'
          + '<i class="glyphicon glyphicon-remove" aria-hidden="true"></i></button>';
      })
  ];

  // initialize a customer search
  var customer = new Bloodhound({
    datumTokenizer: function(d) { return d.tokens; },
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: '/api/search_customer.json?query=%QUERY'
  });
  customer.initialize();

  var customerTypeHead = $('#customer_code').typeahead(null, {
    name: 'customer_code',
    displayKey: 'name',
    source: customer.ttAdapter(),
    hint: (Metronic.isRTL() ? false : true),
    templates: {
      suggestion: Handlebars.compile([
        '<a class="customer">',
        '  <span class="name">{{name}}</span>',
        '  <span class="company_name">{{company_name}}</span>&nbsp;',
        '  <span class="code">({{customer_code}})</span><br>',
        '  <span class="email">{{email}}</span><br>',
        '  <span class="balance">{{balance}}</span>',
        '</a>',
      ].join(''))
    }
  });

  customerTypeHead.on('typeahead:selected', function(evt, data){
    Register.setCustomerInfo(data);
    $scope.$apply(function() {
      $scope.customer = Register.getCustomerInfo();
    });
  });

  $scope.clearCustomerInfo = function() {
    debug("do clearCustomerInfo()");
    Register.clearCustomerInfo();
    //$scope.$apply(function() {
      $scope.customer = null;
      $("#customer_code").val('');
    //});
  };

  // Defines customer search callback
  $scope.isSelectedCustomer = function() {
    return Register.isSelectedCustomer();
  };

  // Defines quick keys callback
  $scope.isTabActive = function(position) {
    return 0 == position ? "active" : "";
  };

  $scope.addSellItem = function(quickKey) {
    debug("do addSellItem %s", quickKey.product_id);
    var productId = quickKey.product_id;

    if (quickKey.parent) {
      openVariantSelector(quickKey);
    } else {
      Register.addSaleItem(productId);
    }
  };

  // Defines sale items callback
  $scope.removeItem = function(sequence) {
    debug("do removeItem %o", sequence);
    debug(vm.dtInstance);
    Register.removeSaleItem(sequence);
  };

  $scope.setPrice = function(sequence) {
    var params = {
      numpadMode : 'discount',
      saleItem   : Register.getRegisterSaleItemBySequence(sequence)
    };
    openNumpad(params);
  };

  $scope.setQuantity = function(sequence) {
    var params = {
      numpadMode : 'quantity',
      saleItem   : Register.getRegisterSaleItemBySequence(sequence)
    };
    openNumpad(params);
  };

  // Defines callback functions
  $scope.doLogout = function() {
    debug('doLogout');
    window.location.href = "/signin/logout";
  };

  $scope.doSetup = function() {
    debug('doSetup');
  };

  $scope.voidSale = function() {
    debug('voidSale');
    Register.voidSale();
  };

  $scope.doParking = function() {
    debug('doParking');
    openAddNote($scope.registerSale.note);
  };

  $scope.doPayment = function() {
    debug('doPayment');
    openPayment();
    $scope.template = LocalStorage.getRegister().receipt_template;
  };

  $scope.openCashDrawer = function() {
    debug('openCashDrawer');
    openCashDrawer();
	};

  $scope.printReceipt = function() {
    print();
  };

  $scope.doRefund = function() {
    debug('doRefund');
    $state.go('refund')
  };

  $scope.doDiscount = function() {
    debug('doDiscount');
    var params = {
      numpadMode : 'line_discount',
      lineDiscount : 0,
      lineDiscountType : 0
    };
    openNumpad(params);
  };

  $scope.specifiedDiscount20 = function() {
    debug('specifiedDiscount20');
    Register.updateLineDiscount(20, 0)
  };

  $scope.doLinePrice = function() {
    debug('doLinePrice');
    Register.createLineItem()
      .then(function(response) {
        var params = {
          numpadMode : 'line_price',
          saleItem   : response
        };
        openNumpad(params);
      }, function(response) {
        debug(response);
      });
  };

  $scope.viewRecall = function() {
    debug('viewRecall');
    $state.go('recall');
  };

  $scope.viewHistory = function() {
    debug('viewHistory');
    //window.location = "/history";
    $state.go('history');
  };

  $scope.viewDailyReport = function() {
    debug('viewDailyReport');
    $state.go('daily-snapshot');
  };

  $scope.closeRegister = function() {
    debug('closeRegister');
    $state.go('close-register');
  };

  $rootScope.changeRegister = function() {
    debug('changeRegister');
    changeRegister();
  };

  // If recovery, already exsit
  if ($scope.saleItems == null) $scope.saleItems = [];
  $scope.registerSale = {
    'receipt_number': 1,
    'line_discount_type': 0,      // line discount type (0: percent, 1: currency)
    'line_discount': 0.0,         // line discount number
    'total_cost': 0.0,            // supply_price
    'total_price': 0.0,           // price_exclude_tax(supply_price * markup)
    'total_price_incl_tax': 0.0,  // retail_price(price + tax)
    'total_discount': 0.0,
    'total_tax': 0.0,             // price * tax_rate
    'total_payment': 0.0,         // Paid
    'sequence': 0
  };
  $scope.keyLayout = Register.getQuickKeyLayout();
  $scope.viewMode = 'small';
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

  function preparedRegister(result) {
    closeLoading();
    $rootScope.config = LocalStorage.getConfig();
    $rootScope.register = LocalStorage.getRegister();

    if ('register.ready' == result.name) {
      var disabled = '';
      $scope.user_type = LocalStorage.getConfig().user_type;
      if ($scope.user_type == "user_type_cashier") {
        var disabled = ' disabled';
      }else{
        var disabled = 'enabled';
      }

      $scope.functions ={};

  $scope.functions = {
    'fn_void_sale' : {
      id      : 'fn_void_sale',
      class   : 'red-thunderbird',
      name    : 'Void',
      callback: $scope.voidSale
    },
    'fn_do_discount' : {
      id      : 'fn_do_discount',
      class   : 'blue-hoki',
      name    : 'Discount',
      callback: $scope.doDiscount
    },
    'fn_do_line_price' : {
      id      : 'fn_do_line_price',
      class   : 'green-haze',
      name    : 'Line Price',
      callback: $scope.doLinePrice
    },
    'fn_do_parking' : {
      id      : 'fn_do_parking',
      class   : '',
      name    : 'Save',
      callback: $scope.doParking
    },
    'fn_do_payment' : {
      id      : 'fn_do_payment',
      class   : 'blue',
      name    : 'Payment',
      callback: $scope.doPayment
    },
    'fn_do_refund' : {
      id      : 'fn_do_refund',
          class: 'yellow-gold ' + disabled,
      name    : 'Refund',
      callback: $scope.doRefund
    },
    'fn_do_recall' : {
      id      : 'fn_do_recall',
      class   : '',
      name    : 'Recall Sales',
      callback: $scope.viewRecall
    },
    'fn_view_history' : {
      id      : 'fn_view_history',
          class: '' + disabled,
      name    : 'Sales History',
      callback: $scope.viewHistory
    },
    'fn_view_daily_report' : {
      id      : 'fn_view_daily_report',
      class   : '',
      name    : 'Daily Snapshot',
      callback: $scope.viewDailyReport
    },
    'fn_close_register' : {
      id      : 'fn_close_register',
      class   : 'red',
      name    : 'End of Day',
      callback: $scope.closeRegister
    },
    'fn_print_receipt' : {
      id      : 'fn_print_receipt',
      class   : '',
      name    : 'Print Receipt',
      callback: $scope.printReceipt
    },
    'fn_open_cash_drawer' : {
      id      : 'fn_open_cash_drawer',
          class: '' + disabled,
      name    : 'No Sale',
      callback: $scope.openCashDrawer
    },
    'fn_do_discount_20' : {
      id      : 'fn_do_discount_20',
      class   : 'green',
      name    : '20% Discount',
      callback: $scope.specifiedDiscount20
    },
    'fn_do_setup' : {
      id      : 'fn_do_setup',
          class: '' + disabled,
      name    : 'Setup',
      callback: $scope.doSetup
    },
    'fn_do_logout' : {
      id      : 'fn_do_logout',
      class   : '',
      name    : 'Logout',
      callback: $scope.doLogout
    },
    'fn_do_nothing' : {
      id      : 'fn_do_nothing',
      class   : '',
      name    : '',
      callback: function() {}
    }
    //,
    //'fn_do_sync_now' : {
    //  id      : 'fn_do_sync_now',
    //  class   : '',
    //  name    : 'Sync Now',
    //  callback: function() {
    //    Register.doSyncNow();
    //  }
    //}   //TODO: for TEST
  };

      if ($scope.user_type == "user_type_cashier") {
        $scope.functions['fn_do_refund'] = {
          id: 'fn_do_refund',
          class: '',
          name: '',
          callback: function () {
          }
        }
        $scope.functions['fn_do_setup'] = {
          id: 'fn_do_setup',
          class: '',
          name: '',
          callback: function () {
          }
        }
        $scope.functions['fn_view_history'] = {
          id: 'fn_view_history',
          class: '',
          name: '',
          callback: function () {
          }
        }
        $scope.functions['fn_view_history'] = {
          id: 'fn_view_history',
          class: '',
          name: '',
          callback: function () {
          }
        }
        $scope.functions['fn_open_cash_drawer'] = {
          id: 'fn_open_cash_drawer',
          class: '',
          name: '',
          callback: function () {
          }
        }
      }

  $scope.function_keys = [
    angular.extend({position: 0}, $scope.functions['fn_void_sale']),
    angular.extend({position: 1}, $scope.functions['fn_do_discount']),
    angular.extend({position: 2}, $scope.functions['fn_do_line_price']),
    angular.extend({position: 3}, $scope.functions['fn_do_payment']),
    angular.extend({position: 4}, $scope.functions['fn_print_receipt']),
    angular.extend({position: 5}, $scope.functions['fn_do_refund']),
    angular.extend({position: 6}, $scope.functions['fn_do_parking']),
    angular.extend({position: 7}, $scope.functions['fn_do_recall']),
    angular.extend({position: 8}, $scope.functions['fn_view_history']),
    angular.extend({position: 9}, $scope.functions['fn_view_daily_report']),
    angular.extend({position: 10}, $scope.functions['fn_close_register']),
    angular.extend({position: 11}, $scope.functions['fn_open_cash_drawer']),
    angular.extend({position: 12}, $scope.functions['fn_do_discount_20']),
    angular.extend({position: 13}, $scope.functions['fn_do_setup']),
    angular.extend({position: 14}, $scope.functions['fn_do_logout'])
    //angular.extend({position: 14}, $scope.functions['fn_do_nothing'])
    //angular.extend({position: 14}, $scope.functions['fn_do_sync_now'])  //TODO: for TEST
  ];
      if ($scope.user_type == "user_type_cashier"){
        $scope.function_keys = [
          angular.extend({position: 0}, $scope.functions['fn_void_sale']),
          angular.extend({position: 1}, $scope.functions['fn_do_discount']),
          angular.extend({position: 2}, $scope.functions['fn_do_line_price']),
          angular.extend({position: 3}, $scope.functions['fn_do_payment']),
          angular.extend({position: 4}, $scope.functions['fn_print_receipt']),
          angular.extend({position: 5}, $scope.functions['fn_do_parking']),
          angular.extend({position: 6}, $scope.functions['fn_do_recall']),
          angular.extend({position: 7}, $scope.functions['fn_view_daily_report']),
          angular.extend({position: 8}, $scope.functions['fn_close_register']),
          angular.extend({position: 9}, $scope.functions['fn_do_discount_20']),
          angular.extend({position: 10}, $scope.functions['fn_do_logout']),
          angular.extend({position: 11}, $scope.functions['fn_do_nothing']),
          angular.extend({position: 12}, $scope.functions['fn_do_nothing']),
          angular.extend({position: 13}, $scope.functions['fn_do_nothing']),
          angular.extend({position: 14}, $scope.functions['fn_do_nothing'])
        ];
      }
    } else {
      }
    }

  function reload(saleId) {
    debug("do reload");
    return Register.reloadRegisterSale(saleId);
  }

  function getSaleItems() {
    debug("do getSaleItems");
    var defer = $q.defer();
    defer.resolve(Register.getCurrentSaleItems());
    return defer.promise;
  }

  function getRegisterSaleTotal() {
    debug("do getRegisterSaleTotal");
    $scope.registerSale = Register.getRegisterSaleTotal();
  }

  function getQuickKeyLayout() {
    debug("do getQuickKeyLayout");
    $scope.keyLayout = Register.getQuickKeyLayout();
  }

  function refreshSaleItems() {
    debug("do refreshSaleItems");
    getRegisterSaleTotal();
    vm.dtInstance.reloadData();
  }

  function reloadedSale() {
    debug("do reloadedSale");
    refreshSaleItems();
    if (Register.isSelectedCustomer()) {
      $scope.customer = Register.getCustomerInfo();
      console.debug("customer :%o", $scope.customer);
    }
  }

  function refreshSale() {
    debug("do refreshSale");
    if ($stateParams["saleId"] != null) {
      refreshSaleItems();
      $state.go('sales');
    } else {
      refreshSaleItems();
    }

    $scope.customer = null;
    $("#customer_code").val('');
  }

  function openCashDrawer(){
    var cashDrawerClient = new CashDrawerClient();
 
    cashDrawerClient.connect(function (connected, error) {
      if (connected) {
        cashDrawerClient.doEnquiry(function (datas, error) {
        });
      }
    });
  }

  function openPayment(data) {
    var modalPaymentInstance = $modal.open({
      templateUrl: '/app/tpl/payment.html',
      controller: 'PaymentCtrl',
      backdrop: 'static',
      keyboard: false,
      size: 'lg',
      resolve: {
        items: function() {
          return data;
        }
      }
    });

    //
    // callback logic from payment
    //
    modalPaymentInstance.result.then(function(result) {
      debug("Payment result : " + result.status);
      $scope.receipt = result.receipt;
      $scope.receipt.status = result.status;
      console.debug('payment %o', $scope.receipt);
      switch (result.status) {
        case 'done' :
          Register.donePaymentSale(result.registerTotal, result.payments);
          break;
        case 'layby' :
          Register.laybySale(result.registerTotal, result.payments);
          break;
        case 'onaccount' :
          Register.onAccountSale(result.registerTotal, result.payments);
          break;
      }
      var printStatus = LocalStorage.getRegister().print_receipt;
      if(result.status != 'cancel' && printStatus == 1){
        $timeout(function() {
          print();
        });
      }
    });
  };

  function changeRegister() {
    openLoading();
    Register.getRegisters()
    .then(function(respons) {
      $rootScope.registers_count = respons.data.length;
      openRegisterSelector(respons.data)
    });
  }

  function openRegisterSelector(registers) {
    var modalInstance = $modal.open({
      templateUrl: 'app/tpl/select-register.html',
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

    modalInstance.result.then(function(selectedItem) {
      Register.switchRegister(selectedItem)
      .then(function(result) {
        if (result.status == "openRegister") {
          openRegister(result.data);
        }
      });
    });
  }

  function openVariantSelector(quickKey) {
    var modalInstance = $modal.open({
      templateUrl: '/app/tpl/variants.html',
      controller: 'VariantSelectorController',
      backdrop: 'static',
      keyboard: false,
      resolve: {
        quickKey: function(){
          return quickKey;
        }
      }
    });

    modalInstance.result.then(function(product_id) {
      debug(product_id);
      if ('undefined' != typeof product_id || null != product_id) {
        Register.addSaleItem(product_id);
        debug('product add item : ' + product_id);
      }
    });
  }

  function openNumpad(params) {
    var modalInstance = $modal.open({
      templateUrl: '/app/tpl/numpad.html',
      controller: 'NumpadCtrl',
      windowClass: 'numpad-dialog',
      resolve: {
        params: function() {
          return params;
        }
      }
    });

    modalInstance.result.then(function(result) {
      debug(result);

      switch (result.numpadMode) {
        case 'quantity':
          Register.updateSaleItem(result.saleItem);
          break;
        case 'discount':
          Register.updateSaleItem(result.saleItem);
          break;
        case 'line_price':
          Register.addLineItem(result.saleItem);
          break;
        case 'line_discount':
          Register.updateLineDiscount(result.lineDiscount, result.lineDiscountType);
          break;
        case 'cash_change' :
          break;

      }
    });
  }

  function openAddNote(note) {
    var modalInstance = $modal.open({
      templateUrl: '/app/tpl/note.html',
      controller: 'AddNoteController',
      backdrop: 'static',
      keyboard: false,
      size: 'sm',
      resolve: {
        items: function() {
          return note;
        }
      }
    });

    modalInstance.result.then(function(result) {
      if (result.status == 'skip') {
        Register.parkSale();
      } else if (result.status == 'save') {
        Register.parkSale(result.note);
      }
    });
  }

  function openRegister(register) {
    var modalInstance = $modal.open({
      templateUrl: '/app/tpl/open-register.html',
      controller: 'OpenRegisterController',
      backdrop: 'static',
      keyboard: false,
      size: 'md',
      resolve: {
        items: function() {
          return register;
        }
      }
    });

    modalInstance.result.then(function(register) {
      return Register.openRegister(register);
    });
  }

  function openLoading() {
    if ($rootScope.loadingInstance != null) {
      return;
    }
    $rootScope.loadingCount += 1;
    $rootScope.loadingInstance = $modal.open({
      templateUrl: '/app/tpl/loading.html',
      controller: 'LoadingController',
      backdrop: 'static',
      keyboard: false,
      size: 'md',
      resolve: {
        items: function() {
          return null;
        }
      }
    });
  }

  function closeLoading() {
    if ($rootScope.loadingInstance != null) {
      $rootScope.loadingCount -= 1;
      $rootScope.loadingInstance.close();
      $rootScope.loadingInstance = null
    }
  }


  function openSplash() {
    var modalInstance = $modal.open({
      templateUrl: '/app/tpl/splash.html',
      controller: 'SplashController'
    });
  }
})

.controller('AddNoteController', function($rootScope, $scope, $modalInstance, $window, Register, locale, items) {
  $scope.result = {};
  $scope.result.note = items;
  $scope.result.status = '';

  $scope.skip = function() {
    $scope.result.status = 'skip';
    $modalInstance.close($scope.result);
  };

  $scope.confirm = function() {
    $scope.result.status = 'save';
    $scope.result.note = $('#note').val();
    $modalInstance.close($scope.result);
  };

  $scope.cancel = function() {
    $modalInstance.dismiss('cancel');
  };
})

.controller('OpenRegisterController', function($rootScope, $scope, $modalInstance, $window, Register, locale, items) {
  $scope.register = items;

  $scope.cancel = function() {
    $modalInstance.dismiss('cancel');
    $window.location.href = '/dashboard';
  };

  $scope.confirm = function() {
    $modalInstance.close($scope.register);
  };
})


.controller('LoadingController', function($rootScope, $scope, $modalInstance, $window, Register, locale, items) {
  $scope.discription = 'Loading Data...';

  $scope.$on('loading.progress', progressLoading);

  function progressLoading(event, args) {
    $scope.discription = args.msg;
  }

  function init() {

    var $layerPopupObj = $('.modal-dialog');
    var left = ( $(window).scrollLeft() + ($(window).width() - $layerPopupObj.width()) / 2 );
    var top = ( $(window).scrollTop() + ($(window).height() - $layerPopupObj.height()) / 2 );
    $layerPopupObj.css({'left': left, 'top': top, 'position': 'absolute'});
    $('body').css('position', 'relative').append($layerPopupObj);
  }
})

.controller('SplashController', function($rootScope, $scope, $modalInstance) {

})

.controller('NumpadCtrl', function($rootScope, $scope, $modalInstance, Register, params) {
  $scope.discountType = 0;
  $scope.number = '';
  $scope.numpad_visible = 1;
  $scope.numpadMode = params.numpadMode;
  $scope.params = params;

  if ('discount' == $scope.numpadMode) {
    var saleItem = params.saleItem;

    if (saleItem.price == 0) {
      $scope.price_incl_tax = parseFloat((saleItem.sale_price * (1 + saleItem.tax_rate)).toFixed(5));
    } else {
      $scope.price_incl_tax = parseFloat((saleItem.price * (1 + saleItem.tax_rate)).toFixed(5));
    }

    if (1 == $scope.discountType) {
      setNumber(($scope.price_incl_tax - saleItem.discount).toFixed(2).toString());
    } else if (0 != saleItem.discount) {
      setNumber((saleItem.discount * 100 / $scope.price_incl_tax).toFixed(2).toString());
    }
  } else if ('line_discount' == $scope.numpadMode) {
    $scope.discountType = params.lineDiscountType;
    setNumber(params.lineDiscount.toString());
  } else if ('line_price' == $scope.numpadMode) {
    var saleItem = params.saleItem;

    if (saleItem.price == 0) {
      $scope.price_incl_tax = parseFloat((saleItem.sale_price * (1 + saleItem.tax_rate)).toFixed(5));
    } else {
      $scope.price_incl_tax = parseFloat((saleItem.price * (1 + saleItem.tax_rate)).toFixed(5));
    }

    setNumber($scope.price_incl_tax.toString());
  } else if ('quantity' == $scope.numpadMode) {
    //setNumber(params.saleItem.quantity.toString());
  } else if ('cash_change' == $scope.numpadMode){
    console.debug(params.toPayment);
    setNumber(params.toPayment.toString());
  }
  angular.element('#change_number_input').select();

  $scope.isDiscountMode = function() {
    return $scope.numpadMode == 'discount';
  }

  $scope.isDiscountLabelPercent = function() {
    return $scope.numpadMode == 'discount'
        && $scope.discountType == 0;
  }

  $scope.isDiscountLabelPrice = function() {
    return $scope.numpadMode == 'discount'
        && $scope.discountType == 1;
  }

  $scope.isDiscountTypePercent = function() {
    return ($scope.numpadMode == 'discount'
        || $scope.numpadMode == 'line_discount')
        && $scope.discountType == 0;
  }

  $scope.isDiscountTypePrice = function() {
    return ($scope.numpadMode == 'discount'
        || $scope.numpadMode == 'line_discount')
        && $scope.discountType == 1;
  }

  $scope.isLineDiscountMode = function() {
    return $scope.numpadMode == 'line_discount';
  }

  $scope.isLinePriceMode = function() {
    return $scope.numpadMode == 'line_price';
  }

  $scope.isCashChangeMode = function() {
    return $scope.numpadMode == 'cash_change';
  }

  $scope.isQuantityMode = function() {
    return $scope.numpadMode == 'quantity';
  }

  $scope.isVisiblePercentage = function() {
    return $scope.numpadMode == 'discount'
        || $scope.numpadMode == 'line_discount';
  }

  $scope.isVisibleNumpad = function() {
    return $scope.numpad_visible;
  };

  $scope.isVisibleSign = function() {
    return $scope.numpadMode == 'quantity'
        || $scope.numpadMode == 'line_price';
  }

  $scope.onChangeUnit = function() {
    var saleItem = params.saleItem;

    if (1 == this.discountType) {
      setNumber(($scope.price_incl_tax - saleItem.discount).toFixed(2).toString());
    } else if (0 != saleItem.discount) {
      setNumber((saleItem.discount * 100 / $scope.price_incl_tax).toFixed(2).toString());
    } else {
      setNumber('');
    }
    $scope.discountType = this.discountType;
  };

  $scope.onNumber = function(input) {
    var number = getNumber();
    number = ('undefined' == typeof number ? '' : number);

    var regexp = /^\d+?$/;

    if ('.' == input) {
      if (regexp.test(number)) {
        number += input;
      } else if (number.length == 0) {
        number = '0';
        number += input;
      }
    } else if ('0' == input || '00' == input) {
      if (!regexp.test(number) || parseFloat(number) > 0) {
        number += input;
      } else if (number.length == 0) {
        number = '0';
      }
    } else if (parseFloat(number) == 0) {
      number = input;
    } else {
      number += input;
    }

    regexp = /^\d{0,9}(\.\d{0,5})?$/;
    if (regexp.test(number)) {
      setNumber(number);
    }
  };

  $scope.onBackspace = function() {
    var number = getNumber();
    number = ('undefined' == typeof number ? '' : number);
    number = number.slice(0, -1);

    setNumber(number);
  };

  $scope.onSign = function() {
    var number = getNumber();
    number = parseFloat('undefined' == typeof number ? '' : number);
    number *= -1;

    setNumber(number);
  };

  $scope.onPercentage = function() {
    $scope.discountType = (0 == $scope.discountType ? 1 : 0);
  };

  $scope.onReturn = function() {
    var number = getNumber();
    var result = $scope.params;

    if (isNaN(parseFloat(number))) {
      alert('Please use a valid format.');
      return;
    }

    if ('discount' == $scope.numpadMode) {
      var price_incl_tax = $scope.price_incl_tax;
      var saleItem = result.saleItem;

      if (0 == $scope.discountType) {
        saleItem.discount = parseFloat(($scope.price_incl_tax * parseFloat(number) / 100).toFixed(5));
        price_incl_tax = $scope.price_incl_tax - saleItem.discount;
      } else {
        price_incl_tax = parseFloat(number);
        saleItem.discount = parseFloat(($scope.price_incl_tax - price_incl_tax).toFixed(5));
      }

      saleItem.sale_price = parseFloat((price_incl_tax / (1 + saleItem.tax_rate)).toFixed(5));
      saleItem.tax = parseFloat((price_incl_tax * saleItem.tax_rate / (1 + saleItem.tax_rate)).toFixed(5));
      result.saleItem = saleItem;
    } else if ('line_discount' == $scope.numpadMode) {
      result.lineDiscountType = $scope.discountType;
      result.lineDiscount = parseFloat(number);
    } else if ('line_price' == $scope.numpadMode) {
      var price_incl_tax = parseFloat(number);
      var saleItem = result.saleItem;

      saleItem.sale_price = parseFloat((price_incl_tax / (1 + saleItem.tax_rate)).toFixed(5));
      saleItem.tax = parseFloat((price_incl_tax * saleItem.tax_rate / (1 + saleItem.tax_rate)).toFixed(5));
      result.saleItem = saleItem;
    } else if ('quantity' == $scope.numpadMode) {
      result.saleItem.quantity = parseFloat(number);
    } else if ('cash_change' == $scope.numpadMode){
      console.debug(result.toPayment);
      result.toPayment =parseFloat(number);
      console.debug(result.toPayment);
    }

    $modalInstance.close(result);
  };

  $(document).on("keyup", ".numpad-content-wrap", function(key){
    var code = key.keyCode || key.which;
    if(code == "13"){
      $scope.onReturn();
    }
  });

  function getNumber() {
    return $scope.number;
  }

  function setNumber(value) {
    console.log('value is ' + value + ', type is ' + typeof value);
    $scope.number = value;
  }
})

.controller('RegisterSelectorController', function($rootScope, $scope, $modalInstance, $window, Register, locale, items) {
  $scope.items = items;
  $scope.cancel = function() {
    $modalInstance.dismiss('cancel');
    $window.location.href = '/dashboard';
  };

  $scope.selectItem = function(selectedItem) {
    $modalInstance.close(selectedItem);
  };

  console.debug($scope.items);
})

.controller('ChangeCtrl', function($rootScope, $scope, $modalInstance, $window,locale, items, payments) {
  $scope.items = items;
  $scope.payments = payments;

  var result = {
    "status": "cancel",
    "amount": $scope.items,
    "payment": $scope.payments
  };

  $scope.cancel = function() {
    $modalInstance.close(result);
  };
  $scope.confirm = function() {
    result.status = "ok";
    $modalInstance.close(result);
  };

})

.controller('VariantSelectorController', function($rootScope, $scope, $modalInstance, quickKey) {
  // Initialize global variables
  $scope.variants = quickKey.variants;
  $scope.variantsOptions = quickKey.options;
  $scope.quickKey = quickKey;

  // Initialize a variant selector
  init();

  $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };

  $scope.selectItem = function(product_id) {
    debug('dismiss modal : ' + product_id);
    $modalInstance.close(product_id);
  };

  function init() {
    var variant_keys = [];

    for (var idx in quickKey.options){
      variant_keys.push(quickKey.options[idx].label);
    }

    for (var idx in quickKey.variants){
      var variant = quickKey.variants[idx];
      var label = '';

      for (var idx in variant_keys) {
        var key = variant_keys[idx];
        if (label.length > 0) {
          label += ' / ';
        }
        label += variant[key];
      }
      variant.label = label;
    }
  }
})

.controller('PaymentCtrl', function($rootScope, $scope, $http, $modalInstance, LocalStorage,$timeout, Register, $modal, items) {
  $modalInstance.opened.then(function() {
    // initialize core components
    Metronic.initAjax();
  });

  $scope.registerTotal = {};

  // initialize payment modal
  init();
  console.debug($scope);
  $scope.cancel = function() {
    if($scope.totalPaid == 0 ||$scope.totalPaid == null ) {
      endPayment('cancel');
    }else{
      paymentClose();
    }
  };


  $scope.toPayCashAmount= function(data) {
    var params = {
      numpadMode : 'cash_change',
      toPayment : $scope.toPayment
    };
    openNumpad(params);
    console.debug(data+'dd');
  };
      function openNumpad(params) {
        var modalNumpadInstance = $modal.open({
          templateUrl: '/app/tpl/numpad.html',
          controller: 'NumpadCtrl',
          windowClass: 'numpad-dialog',
          backdrop: 'static',
          size: 'sm',
          resolve: {
            params: function() {
              return params;
            }
          }
        });

        modalNumpadInstance.result.then(function(result) {
            console.debug(result);
            $scope.toPayment = result.toPayment;
            console.debug($scope.toPayment);
        });
      }
  $scope.layby = function() {
    if (!Register.isSelectedCustomer()) {
      alert("Customer not selected");
    } else {
      print_receipt()
      endPayment('layby');
    }
  };

  $scope.onaccount = function() {
    if (!Register.isSelectedCustomer()) {
      alert("Customer not selected");
    } else {
      print_receipt()
      endPayment('onaccount');
    }
  };

  $scope.isSelectedCustomer = function() {
    return Register.isSelectedCustomer();
  };

  $scope.isSplitMode = function() {
    return $scope.splitMode == 1;
  }

  $scope.toggleSplitMode = function() {
    $scope.splitMode = ($scope.splitMode == 0 ? 1 : 0);
    if (0 == $scope.splitMode) {
      $scope.toPayment = parseFloat($scope.remainPayment.toFixed(2));
    } else {
      $scope.toPayment = parseFloat(($scope.remainPayment / ($scope.totalPerson - $scope.paidPerson)).toFixed(2));
    }
  }

  $scope.onChangePerson = function() {
    $scope.toPayment = parseFloat(($scope.remainPayment / ($scope.totalPerson - $scope.paidPerson)).toFixed(2));
  }

  function init() {
    var registerSale = Register.getRegisterSaleTotal();
    $scope.registerTotal = registerSale;
    debug(registerSale);

    // initialize payment variables
    var saleID = LocalStorage.getSaleID();
    var config = LocalStorage.getConfig();
    $scope.sale_id = saleID;
    $scope.register_id = config.register_id;
    $scope.register = LocalStorage.getRegister();

    $scope.invoiceNumber = registerSale.receipt_number;
    if (null != $scope.register.invoice_prefix) {
      $scope.invoiceNumber = $scope.register.invoice_prefix + $scope.invoiceNumber;
    }

    if (null != $scope.register.invoice_suffix) {
      $scope.invoiceNumber += $scope.register.invoice_suffix;
    }
    $scope.receipt = [];
    $scope.payments = [];
    $scope.totalTax = $scope.registerTotal.total_tax;
    $scope.totalPaid = 0.0;
    $scope.totalPayment = registerSale.total_price_incl_tax;
    $scope.totalPerson  = 1;
    $scope.remainPayment = registerSale.total_price_incl_tax;
    $scope.paidPerson = 0;
    $scope.toPayment = parseFloat(($scope.remainPayment / ($scope.totalPerson - $scope.paidPerson)).toFixed(2));
    $scope.splitMode = 0;
    $scope.change = 0;
    $scope.customerInfo = Register.getCustomerInfo();
    // define alias for local Datastore
    $scope.ds = Datastore_sqlite;

    // Get Payment Type from Local DB
    $scope.paymentTypes = [];
    Register.getRegisterPaymentTypes()
      .then(function(paymentTypes) {
        $scope.paymentTypes = paymentTypes

        for (var idx in $scope.paymentTypes) {

          var paymentTypeId = $scope.paymentTypes[idx].payment_type_id;
          if (1 == paymentTypeId)          { $scope.paymentTypes[idx].image = "/app/images/payment/type-001.png";
          } else if (2 == paymentTypeId)   { $scope.paymentTypes[idx].image = "/app/images/payment/type-002.png";
          } else if (3 == paymentTypeId)   { $scope.paymentTypes[idx].image = "/app/images/payment/type-003.png";
          } else if (4 == paymentTypeId)   { $scope.paymentTypes[idx].image = "/app/images/payment/type-004.png";
          } else if (101 == paymentTypeId) { $scope.paymentTypes[idx].image = "/app/images/payment/type-004.png"; //type-101.png
          } else if (106 == paymentTypeId) { $scope.paymentTypes[idx].image = "/app/images/payment/type-106.png";
          } else if (107 == paymentTypeId) { $scope.paymentTypes[idx].image = "/app/images/payment/type-003.png"; //type-107.png
          }
        }
      });

    $scope.saleItems = [];
    if ($scope.sale_id != null) {
     $scope.saleItems = Register.getCurrentSaleItems();
    }
  }

  // Click Payment Resource Button
  $scope.doPayment = function(payment) {
    var paymentTypeId = payment.payment_type_id;
    var amount = $scope.toPayment;

    if (1 == paymentTypeId) {
      // TODO: cash payment
      amount = parseFloat(amount).toFixed(1);
      
      var cashDrawerClient = new CashDrawerClient();
      cashDrawerClient.connect(function (connected, error) {
        if (connected) {
          cashDrawerClient.doEnquiry(function (datas, error) {
          });
        }
      });

    } else if (2 == paymentTypeId) {
      // TODO: cheque payment
    } else if (3 == paymentTypeId) {
      // TODO: credit payment
    } else if (4 == paymentTypeId) {
      // TODO: ETP payment
    } else if (101 == paymentTypeId) {
      // TODO: DPS payment
      return doPaymentExpress(payment);
    } else if (106 == paymentTypeId) {
      // TODO: Loyalty payment
    } else if (107 == paymentTypeId) {
      // TODO: Xero payment
    } else {
      // TODO: others payment
    }

    // update payment display.
    updatePayment(payment, amount);
  }

  function doPaymentExpress(payment) {
    var dpsClient = new DpsClient();

    dpsClient.connect(function (connected, error) {
      if (connected && $scope.toPayment > 0) {
        dpsClient.payment($scope.invoiceNumber, $scope.toPayment, function (data, error) {
          if (data.responsetext == "ACCEPTED") {
            // update payment display.
            updatePayment(payment, $scope.toPayment);
            }else if(data.responsetext == "SIG ACCEPTED"){
            updatePayment(payment, $scope.toPayment);
          }
        });
      }/* else if (connected && $scope.toPayment > 0) {
        dpsClient.refund($scope.invoiceNumber, $scope.toPayment, function (data, error) {
              if (data.responsetext == "ACCEPTED" || data.responsetext == "SIG ACCEPTED") {
                // update payment display.
                updatePayment(payment, $scope.toPayment);
              }
            }
        );
      }*/
    });
  }
  function issueChange(amount, payment){
    var modalIssueInstance = $modal.open({
      templateUrl: '/app/tpl/change.html',
      controller: 'ChangeCtrl',
      backdrop: 'static',
      keyboard: false,
      size: 'sm',
      resolve: {
        items: function() {
          return amount;
        },
        payments: function(){
          return payment;
        }
      }

  });
    modalIssueInstance.result.then(function(result) {
      console.debug('result %o', result);
      if (result.status == "ok") {
        var newPayment = Register.createNewPayment(result.payment.id, result.payment.payment_type_id, result.payment.name, -result.amount);
        // TODO: payment save
        savePayment(newPayment);
        endPayment('done');
      } else {
        // change = 0
        $scope.change = 0 ;
      }
    });
  }

  function endPayment(status) {
    var result = {};
    result.status = status;
    result.payments = $scope.payments;
    result.registerTotal = $scope.registerTotal;
    result.receipt = $scope.receipt;
    $modalInstance.close(result);
  }
  function savePayment(payment) {
    $scope.payments.push(payment);
    //$scope.ds.saveRegisterSalePayments(payment);
  }

  function updatePayment(payment, amount) {
    // update payment display.
    var newPayment = Register.createNewPayment(payment.id, payment.payment_type_id, payment.name, amount);
    // TODO: payment save
    savePayment(newPayment);

    // update payment display.
    $scope.totalPaid += amount;
    $scope.remainPayment -= amount;
    $scope.registerTotal.total_payment = parseFloat($scope.totalPaid);

    if ($scope.splitMode == 1 && ($scope.totalPerson - $scope.paidPerson) > 0) {
      $scope.paidPerson++;
    }
    $scope.toPayment = parseFloat(($scope.remainPayment / ($scope.totalPerson - $scope.paidPerson)).toFixed(2));

    var remain = parseFloat($scope.remainPayment.toFixed(1));
    if (remain <= 0) {
      if (remain != 0) {
        $scope.change = -1 * ($scope.remainPayment);
      }
      print_receipt();
      if($scope.change > 0 ){
        issueChange($scope.change, payment);
        if($scope.change == 0){
          endPayment('done');
        }
      }
      else
      {
        endPayment('done');
      }

    }
  }

  function print_receipt() {
    $scope.receipt['change'] = parseFloat($scope.change).toFixed(2);
    $scope.receipt['tax'] = parseFloat($scope.totalTax).toFixed(2);
    $scope.receipt['paid'] = parseFloat($scope.totalPaid).toFixed(2);
    $scope.receipt['total'] = parseFloat($scope.totalPayment).toFixed(2);
        //TODO: ????? ?? ??
        $scope.receipt['sub_total'] = parseFloat($scope.registerTotal.total_price).toFixed(2);
        $scope.receipt['total_discount'] = parseFloat($scope.registerTotal.total_discount).toFixed(2);
        $scope.discountValue = $scope.registerTotal.line_discount;
        if ($scope.registerTotal.line_discount_type == 0) { // percent
          $scope.discountValue = $scope.registerTotal.total_price_incl_tax / (1 - $scope.discountValue / 100) - $scope.registerTotal.total_price_incl_tax;
        }
        for(var idx in $scope.saleItems) {
          $scope.saleItems[idx]['item_price_incl_tax'] = $scope.saleItems[idx].price + $scope.saleItems[idx].tax;
          $scope.saleItems[idx]['item_price'] = $scope.saleItems[idx].item_price_incl_tax * $scope.saleItems[idx].quantity;
        }
        for(var idx in $scope.saleItems) {
          $scope.saleItems[idx]['item_discount'] = $scope.saleItems[idx].discount * $scope.saleItems[idx].quantity;
        }
        $scope.receipt['sub_total1'] = $scope.registerTotal.line_discount;
        $scope.receipt['line_discount'] =$scope.discountValue;
    //$scope.receipt['sub_total'] = parseFloat($scope.totalPayment - $scope.totalTax).toFixed(2);
    $scope.receipt['change'] = $scope.change;
    $scope.receipt['date'] = (new Date().format('dd-MMM-yyyy HH:mm'));
    $scope.receipt['invoice_number'] = $scope.invoiceNumber;
    $scope.receipt['sale_items'] = $scope.saleItems;
    $scope.receipt['payments'] = $scope.payments;
    if(parseFloat($scope.remainPayment).toFixed(2) < 0.09 ) {
      $scope.receipt['to_pay'] =0
    }else{
      $scope.receipt['to_pay'] = parseFloat($scope.remainPayment).toFixed(2);
    }
    $scope.receipt['customer_name'] = $scope.customerInfo.name;
    console.debug('scope.receipt %o', $scope.receipt);
  }

  function paymentClose(data){
    var modalInstance = $modal.open({
      templateUrl: '/app/tpl/payment-close.html',
      controller: 'PaymentCtrl',
      backdrop: 'static',
      keyboard: false,
      size: 'sm',
      resolve: {
        items: function() {
          return data;
        }
      }
    });
  }
});
