'use strict';

/**
 * @ngdoc function
 * @name OnzsaApp.controller:CloseController
 * @description
 * # CloseController
 * Controller of the OnzsaApp
 */
angular.module('OnzsaApp')
  .controller('CloseController', function($scope, $http) {
    $scope.register = {};
    $scope.register.id = '55b99424-e7e4-44c4-b461-25e04cf3b98e';
    $scope.register.name = 'Register #1';
    $scope.register.outlet_name = 'Auckland #1';
    $scope.register.open_time = '2015-08-07 13:30:00';
    $scope.register.close_time = '2015-08-07 13:30:00';
    $scope.register.total_sales = '50.0';
    $scope.register.total_taxes = '7.5';
    $scope.register.total_discounts = '0.0';
    $scope.register.total_transactions = '5';
    $scope.register.total_payments = '50.0';

    $scope.register.sales = [];
    $scope.register.sales.payments = [];
    $scope.register.payments = [];
    $scope.register.account_sales = [];

    var sale = {};
    sale.name = 'New';
    sale.total_sales = '10.0';
    sale.total_taxes = '1.5';
    $scope.register.sales[0] = sale;
    $scope.register.sales.payments[0] = sale;

    sale = {};
    sale.name = 'On account';
    sale.total_sales = '20.0';
    sale.total_taxes = '3.0';
    $scope.register.sales[1] = sale;
    $scope.register.sales.payments[1] = sale;

    sale = {};
    sale.name = 'Layby';
    sale.total_sales = '20.0';
    sale.total_taxes = '3.0';
    $scope.register.sales[2] = sale;
    $scope.register.sales.payments[2] = sale;

    var payment = {};
    payment.name = 'Credit card';
    payment.amount = '20.0';
    $scope.register.payments[0] = payment;

    var account_sale = {};

    sale = {};
    sale.sale_date = '2015-08-16 11:42:47';
    sale.reciept_number = 27;
    sale.user = {
      'id': '1',
      'name': 'Seongwuk Park'
    };
    sale.customer = {
      'id': '1',
      'name': 'Steve Park'
    };
    sale.note = '';
    sale.amount = '10.0';

    account_sale.total_sales = '10.0';
    account_sale.sales = [];
    account_sale.sales[0] = sale;

    $scope.register.account_sales[0] = account_sale;

    $scope.closeRegister = function(register_id) {
      alert('close');
    };
  });
