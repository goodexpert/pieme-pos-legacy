'use strict';

/**
 * @ngdoc function
 * @name OnzsaApp.controller:RecallController
 *
 * @description
 * Controller of the OnzsaApp
 */
angular.module('OnzsaApp', ['ngLocalize'])

.controller('RecallController', function($rootScope, $scope, $http, $modal, locale, LocalStorage) {

  $scope.$on('$viewContentLoaded', function() {   
    // initialize core components
    Metronic.initAjax();
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
