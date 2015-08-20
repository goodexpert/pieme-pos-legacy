'use strict';

/**
 * @ngdoc service
 * @name OnzsaApp.RegisterService
 * @description
 * # RegisterService
 * Service in the OnzsaApp.
 */
angular.module('RegisterService', [])
  .factory('Register', function() {
    // AngularJS will instantiate a singleton by calling "new" on this function
    var sharedService = {};
    return sharedService;
  });
