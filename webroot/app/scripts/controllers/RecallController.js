'use strict';

/**
 * @ngdoc function
 * @name OnzsaApp.controller:RecallController
 *
 * @description
 * Controller of the OnzsaApp
 */
angular.module('OnzsaApp', [])

.controller('RecallController', function($rootScope, $scope, $state, $http, $modal, locale, LocalStorage) {

  $scope.$on('$viewContentLoaded', function() {   
    // initialize core components
    Metronic.initAjax();
    TableAdvanced.init();

    // define alias for local strage
    $scope.localstorage = Database_localstorage;

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
  });

  /*
  $scope.register_sales = [];

  var register_sale = {};
  register_sale.id = '1234';
  register_sale.sale_date = '2015-08-06 15:49:00';
  register_sale.sale_status = 'ONACCOUNT';
  register_sale.amount = '20.0';
  register_sale.user = {
    'id': '1',
    'name': 'Steve Park'
  };
  register_sale.customer = {
    'id': '1',
    'name': 'Steve Park',
    'customer_code': 'N1K2'
  };

  $scope.register_sales.push(register_sale);
  */
});
