'use strict';

/**
 * @ngdoc function
 * @name OnzsaApp.controller:CloseRegisterController
 *
 * @description
 * Controller of the OnzsaApp
 */
angular.module('OnzsaApp', [])

.controller('CloseRegisterController', function($rootScope, $scope, $state, $http, $modal, locale, LocalStorage, Register) {

  $scope.$on('$viewContentLoaded', function() {   
    // initialize core components
    Metronic.initAjax();
  });

});
