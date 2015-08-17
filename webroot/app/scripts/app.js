'use strict';

/**
 * @ngdoc overview
 * @name OnzsaApp
 * @description
 * # OnzsaApp
 *
 * Onzsa AngularJS App Main Script
 */

/* Onzsa App */
var OnzsaApp = angular.module('OnzsaApp', [
/*
  'ngAnimate',
  'ngAria',
  'ngCookies',
  'ngMessages',
  'ngResource',
  'ngRoute',
*/
  'cfp.hotkeys',
  'ngSanitize',
  'ngTouch',
  'ui.router',
  'ui.bootstrap',
  'oc.lazyLoad'
]);

/* Configure ocLazyLoader(refer: https://github.com/ocombe/ocLazyLoad) */
OnzsaApp.config(['$ocLazyLoadProvider', function($ocLazyLoadProvider) {
  $ocLazyLoadProvider.config({
    // global configs go here
  });
}]);

//AngularJS v1.3.x workaround for old style controller declarition in HTML]);
OnzsaApp.config(['$controllerProvider', function($controllerProvider) {
  // this option might be handy for migrating old apps, but please don't use it
  // in new ones!
  $controllerProvider.allowGlobals();
}]);

/* Setup global register */
OnzsaApp.factory('register', ['$rootScope', function($rootScope) {
  var register = {
  };

  $rootScope.register = register;

  return register;
}]);

/* Setup global settings */
OnzsaApp.factory('settings', ['$rootScope', function($rootScope) {
  // supported languages
  var settings = {
    layout: {
      pageSidebarClosed: false, // sidebar state
      pageAutoScrollOnLoad: 1000 // auto scroll to top on page load
    },
    layoutImgPath: Metronic.getAssetsPath() + 'admin/layout/img/',
    layoutCssPath: Metronic.getAssetsPath() + 'admin/layout/css/',
    theme: {
      btn_default: 'yellow-crusta'
    }
  };

  $rootScope.settings = settings;

  return settings;
}]);

/* Setup App Main Controller */
OnzsaApp.controller('AppController', ['$scope', '$rootScope', 'hotkeys', function($scope, $rootScope, hotkeys) {
  $scope.$on('$viewContentLoaded', function() {
    Metronic.initComponents(); // init core components
    //Layout.init(); //  Init entire layout(header, footer, sidebar, etc) on page load if the partials included in server side instead of loading with ng-include directive 
  });

  hotkeys.add({
    combo: 'ctrl+h',
    description: 'Display the highscores',
    callback: function() {
      alert('ok');
    }
  });
}]);

/* Setup Layout Part - Header */
OnzsaApp.controller('HeaderController', ['$scope', function($scope) {
  $scope.$on('$includeContentLoaded', function() {
    Layout.initHeader(); // init header
  });
}]);

/* Setup Layout Part - Sidebar */
OnzsaApp.controller('SidebarController', ['$scope', function($scope) {
  $scope.$on('$includeContentLoaded', function() {
    Layout.initSidebar(); // init sidebar
  });
}]);

/* Setup Rounting For All Pages */
OnzsaApp.config(function($stateProvider, $locationProvider, $urlRouterProvider, $ocLazyLoadProvider) {
  $urlRouterProvider.otherwise("/");
  $locationProvider.hashPrefix('!');

  // You can also load via resolve
  $stateProvider
    .state('index', {
      url: "/", // root route
      views: {
        "lazyLoadView": {
          controller: 'SellController', // This view will use SellController loaded below in the resolve
          templateUrl: '/app/views/sell-screen.html'
        }
      },
      resolve: { // Any property in resolve should return a promise and is executed before the view is loaded
        deps: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load([{
            name: 'OnzsaApp',
            insertBefore: '#ng_load_plugins_before', // load the above css files before a LINK element with this ID. Dynamic CSS files must be loaded between core and theme css files
            files: [
              '/theme/metronic/assets/global/plugins/morris/morris.css',
              '/theme/metronic/assets/global/plugins/select2/select2.css',
              '/theme/metronic/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css',
              '/theme/metronic/assets/global/plugins/datatables/extensions/Scroller/css/dataTables.scroller.min.css',
              '/theme/metronic/assets/global/plugins/datatables/extensions/ColReorder/css/dataTables.colReorder.min.css',
              '/theme/metronic/assets/admin/pages/css/tasks.css',
              '/app/styles/register.css',

              '/theme/metronic/assets/global/plugins/morris/morris.min.js',
              '/theme/metronic/assets/global/plugins/morris/raphael-min.js',
              '/theme/metronic/assets/global/plugins/jquery.sparkline.min.js',

              '/theme/metronic/assets/global/plugins/select2/select2.min.js',
              '/theme/metronic/assets/global/plugins/datatables/all.min.js',
              '/theme/metronic/assets/admin/pages/scripts/tasks.js',

              '/app/scripts/table-advanced.js',
              '/app/scripts/controllers/PaymentController.js',
              '/app/scripts/controllers/SellController.js'
            ]
          }]);
        }]
      }
    });
});

/* Init global settings and run the app */
OnzsaApp.run(["$rootScope", "$state", "settings", "register", function($rootScope, $state, settings, register) {
  $rootScope.$state = $state; // state to be accessed from view
}]);
