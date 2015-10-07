'use strict';

/**
 * @ngdoc function
 * @name OnzsaApp.controller:HistoryController
 *
 * @description
 * Controller of the OnzsaApp
 */
angular.module('OnzsaApp', [])

.controller('HistoryController', function($rootScope, $scope, $state, $http, $modal, $q, $filter, locale, DTOptionsBuilder, DTColumnBuilder, DTColumnDefBuilder) {

  $scope.$on('$viewContentLoaded', function() {   
    // initialize core components
    Metronic.initAjax();
  });

  // initialize the history sales table
  var vm = this;
  vm.dtOptions = DTOptionsBuilder
    .fromFnPromise(function() {
      return reloadData();
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

  function reloadData() {
    var defer = $q.defer();
    var data = [];
    var today = (new Date()).format("yyyy-MM-dd") + " 00:00:00";
    var todayTime = Math.floor(new Date(today).getTime() / 1000);
    var condition = {
      'id' : null,
      'status' : "history",
      'sale_date' : todayTime
    };

    $scope.ds.getRegisterSales(condition, function(data) {
      $scope.register_sales = data;
      defer.resolve(data);
    }, function(error) {
      defer.resolve([]);
    });

    return defer.promise;
  }

});
