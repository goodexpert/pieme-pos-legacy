'use strict';

/**
 * @ngdoc function
 * @name OnzsaApp.controller:RecallController
 *
 * @description
 * Controller of the OnzsaApp
 */
angular.module('OnzsaApp', [])

.controller('RecallController', function($rootScope, $scope, $state, $http, $modal, $q, locale, DTOptionsBuilder, DTColumnBuilder, DTInstances) {

  $scope.$on('$viewContentLoaded', function() {   
    // initialize core components
    Metronic.initAjax();
    /*
    TableAdvanced.init();

    // define alias for local Datastore
    $scope.ds = Datastore_sqlite;

    var data = [];

    $scope.ds.getRegisterSales("all", function(data){

      for(var i=0; i< data.length; i++){
        data[i]["status"] = data[i]["status"].replace("sale_status_", "");
      }

      $scope.register_sales = data;
      $scope.$apply();
      console.log($scope.register_sales);
    });
    */
  });

  var vm = this;
  vm.dtOptions = DTOptionsBuilder
    .fromFnPromise(function() {
      return reloadData();
    })
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
    DTColumnBuilder.newColumn('sale_date').withTitle('Date').renderWith(function(data, type, full) {
      var current_date = new Date(data * 1000);
      var strDate = current_date.getDate() + "-" + (current_date.getMonth()+1) + "-" + current_date.getFullYear() + " " + current_date.getHours() + ":" + current_date.getMinutes();

      return strDate;
    }),
    DTColumnBuilder.newColumn('status').withTitle('Status'),
    DTColumnBuilder.newColumn('user_name').withTitle('User'),
    DTColumnBuilder.newColumn('customer_name').withTitle('Customer'),
    DTColumnBuilder.newColumn('total_price_incl_tax').withTitle('Total'),
    DTColumnBuilder.newColumn('note').withTitle('Note'),
    DTColumnBuilder.newColumn('').renderWith(function(data, type, full) {
      return '<a href="#sale/' + full.id + '">Open</a>';
    })
  ];

  DTInstances.getLast().then(function (dtInstance) {
    $scope.dtInstance = dtInstance;
  });

  $scope.reload = function(event, loadedDT) {
    $scope.dtInstance.reloadData();
  };

  // define alias for local Datastore
  $scope.ds = Datastore_sqlite;

  function reloadData() {
    var defer = $q.defer();
    var data = [];
    var status = "";

    if($scope.saleStatus != null || $scope.saleStatus != undefined)status = $scope.saleStatus;
    else status = 'all';

    $scope.ds.getRegisterSales(status, function(data) {

      //console.log($scope.filter);

      for (var i=0; i< data.length; i++){
        data[i]["status"] = data[i]["status"].replace("sale_status_", "");
      }

      $scope.register_sales = data;
      defer.resolve(data);
    });

    return defer.promise;
  }
});
