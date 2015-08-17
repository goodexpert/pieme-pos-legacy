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

    console.log('payment loaded');
  });
