'use strict';

/**
 * @ngdoc function
 * @name OnzsaApp.controller:DailySnapshotController
 *
 * @description
 * Controller of the OnzsaApp
 */
angular.module('OnzsaApp', [])

.controller('DailySnapshotController', function($rootScope, $scope, $state, $http, $modal, locale, LocalStorage) {

  $scope.$on('$viewContentLoaded', function() {   
    // initialize core components
    Metronic.initAjax();
  });

});
