'use strict';

/**
 * @ngdoc function
 * @name OnzsaApp.controller:RecallController
 *
 * @description
 * Controller of the OnzsaApp
 */
angular.module('OnzsaApp', [])

.controller('RecallController', function($rootScope, $scope, $state, $http, $modal, $q, locale, DTOptionsBuilder, DTColumnBuilder, DTColumnDefBuilder) {

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
  vm.dtOptions = DTOptionsBuilder.fromFnPromise(function() {
    return reloadData();
  }).withPaginationType('full_numbers');

  vm.dtColumns = [
    DTColumnBuilder.newColumn('sale_date').withTitle('Date').renderWith(function(data, type, full) {
      return new Date(data * 1000);
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

  // define alias for local Datastore
  $scope.ds = Datastore_sqlite;

  function reloadData() {
    var defer = $q.defer();
    var data = [];

    $scope.ds.getRegisterSales("all", function(data) {

      for(var i=0; i< data.length; i++){
        data[i]["status"] = data[i]["status"].replace("sale_status_", "");
      }

      $scope.register_sales = data;
      defer.resolve(data);
    });

    return defer.promise;
  }
});
