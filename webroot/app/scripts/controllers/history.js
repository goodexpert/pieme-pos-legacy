'use strict';

/**
 * @ngdoc function
 * @name OnzsaApp.controller:HistoryController
 *
 * @description
 * Controller of the OnzsaApp
 */
angular.module('OnzsaApp', [])

.controller('HistoryController', function($rootScope, $scope, $state, $http, $modal, $q, $filter, locale, LocalStorage, Register, DTOptionsBuilder, DTColumnDefBuilder, DTColumnBuilder, DTInstances) {

  $scope.$on('$viewContentLoaded', function() {   
    // initialize core components
    Metronic.initAjax();
  });

  $scope.period = 0;
  $scope.limit = 5;
  $scope.page = 1;
  Register.getRegisterOpenPeriod($scope.limit, $scope.page)
  .then(function(response) {
    if (response['data']['success'] == true) {
      $scope.opens = response['data']['opens'];
      $scope.changePeriod();
    }
  });

  // initialize the history sales table
  var vm = this;
  vm.dtInstance = null;
  vm.dtOptions = DTOptionsBuilder
    .fromFnPromise(function() {
      return reloadHistory();
    })
    .withOption('deferRender', true)
    .withOption('scrollY', 480)
    .withOption('autoWidth', false)
    .withPaginationType('full_numbers')
    .withTableTools('/lib/datatables/vendor/datatables-tabletools/swf/copy_csv_xls_pdf.swf')
    .withTableToolsButtons([
      'copy',
      'print', {
        'sExtends': 'collection',
        'sButtonText': 'Save',
        'aButtons':['csv', 'xls', 'pdf']
      }
    ]);

  vm.dtColumns = [
    DTColumnBuilder
      .newColumn('sale_date')
      .withTitle('Date')
      .withClass('dt-left')
      .withOption('width', '120px')
      .renderWith(function(data, type, full) {
        return $filter('date')(data * 1000, 'MMM dd yyyy, hh:mm:ss');
      }),
    DTColumnBuilder
      .newColumn('status')
      .withTitle('Status')
      .withClass('dt-left')
      .withOption('width', '60px')
      .renderWith(function(data, type, full) {
        return data.replace('sale_status_', '').toUpperCase();
      }),
    DTColumnBuilder
      .newColumn('user_name')
      .withTitle('User')
      .withClass('dt-left')
      .withOption('width', '180px')
      .renderWith(function(data, type, full) {
        return '<a href="javascript:;">' + data + '</a>';
      }),
    DTColumnBuilder
      .newColumn('customer_name')
      .withTitle('Customer')
      .withClass('dt-left')
      .withOption('width', '100px')
      .renderWith(function(data, type, full) {
        return '<a href="javascript:;">' + data + '</a>';
      }),
    DTColumnBuilder
      .newColumn('total_price_incl_tax')
      .withTitle('Total')
      .withClass('dt-head-center dt-body-right')
      .withOption('width', '50px')
      .renderWith(function(data, type, full) {
        return $filter('currency')(full.total_price_incl_tax, '$', 2);
      }),
    DTColumnBuilder
      .newColumn('note')
      .withTitle('Note')
      .notSortable()
      .withClass('dt-left dt-text-eclipse')
      .withOption('width', '91px')
      .renderWith(function(data, type, full) {
        if (data != null) {
          return '<div class="test" style="width:90px; text-overflow:ellipsis; overflow:hidden; white-space:nowrap;">' + data + '</div>';
        } else {
          return '';
        }
      }),
    DTColumnBuilder
      .newColumn('')
      .notSortable()
      .withClass('dt-center')
      .withOption('width', '40px')
      .renderWith(function(data, type, full) {
        return '<a href="#/sales/' + full.id
            + '" ui-sref="sales.edit({itemId:' + full.id + '})" class="btn btn-sm btn-link">Open</a>';
      })
  ];

  // define alias for local Datastore
  $scope.ds = Datastore_sqlite;

  $scope.changePeriod = function() {
    debug("do changePeriod");
    if ($scope.period == "more") {
      $scope.page += 1;
      Register.getRegisterOpenPeriod($scope.limit, $scope.page)
      .then(function(response) {
        if (response['data']['success'] == true) {
          $.merge($scope.opens, response['data']['opens']);
          $scope.period = $scope.limit * ($scope.page - 1) + 1;
          $scope.changePeriod();
        } else {
          if (response['data']['count'] == 0) {
            debug("no more register open period data");
          }
        }
      }, function(response){
        debug("error : get more register open period");
      });
    } else {
      if (vm.dtInstance == null) {
        DTInstances.getLast().then(function (instance) {
          vm.dtInstance = instance;
        });
      }
      vm.dtInstance.reloadData();
    }
  }

  function reloadHistory() {
    var defer = $q.defer();
    var data = [];

    if (vm.dtInstance == null) {
      DTInstances.getLast().then(function (instance) {
        vm.dtInstance = instance;
      });
    }

    var idx = $scope.period;
    if ($scope.opens == null) {
      defer.resolve([]);
      return defer.promise;
    }

    var open = $scope.opens[idx];

    var openTime = Math.floor(new Date(open.register_open_time).getTime() / 1000);
    var closeTime = Math.floor(new Date(open.register_close_time).getTime() / 1000);

    var condition = {
      'id' : null,
      'status' : "history",
      'sale_period_from' : openTime,
      'sale_period_to' : closeTime
    };

    $scope.ds.getRegisterSales(condition, function(data) {
      $scope.register_sales = data;
      defer.resolve(data);
      debug("register sales data : %o", data);
    }, function(error) {
      defer.resolve([]);
      debug("register sales data nothing");
    });

    return defer.promise;
  }

});
