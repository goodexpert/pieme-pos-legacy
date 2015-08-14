'use strict';

/**
 * @ngdoc function
 * @name OnzsaApp.controller:TableController
 * @description
 * # TableController
 * Controller of the OnzsaApp
 */
angular.module('OnzsaApp')
  .controller('TableController', function ($scope) {
    $scope.resources = [];

    var resource = {};
    resource.id = '1234';
    resource.name = 'Table #1';
    $scope.resources.push(resource);

    resource = {};
    resource.id = '1235';
    resource.name = 'Table #2';
    $scope.resources.push(resource);
  });
