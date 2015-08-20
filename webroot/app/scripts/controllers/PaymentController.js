'use strict';

/**
 * @ngdoc function
 * @name OnzsaApp.controller:PaymentController
 * @description
 * # PaymentController
 * Controller of the OnzsaApp
 */
angular.module('OnzsaApp')
  .controller('PaymentController', function($rootScope, $scope, $ocLazyLoad, $http) {
    $scope.$on('$includeContentLoaded', function() {
    });

      $scope.payments = [];
      var payment = {};
      payment.name = 'Credit Card';
      payment.payment_type_id = 3;
      payment.id = '55b99423-f5d8-4140-b347-25e04cf3b98e';
      payment.image = '../img/cash.png';
      $scope.payments.push(payment);
      var payment = {};
      payment.name = 'Cash';
      payment.payment_type_id = 2;
      payment.id = '55b99423-f5d8-4140-b347-25e04cf3b98e';
      payment.image = '../img/card.png';
      $scope.payments.push(payment);
      var payment = {};
      payment.name = 'Cheque';
      payment.payment_type_id = 1;
      payment.id = '55b99423-f5d8-4140-b347-25e04cf3b98e';
      payment.image = '../img/cheque.png';
      $scope.payments.push(payment);
  });
