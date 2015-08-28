'use strict';

/**
 * @ngdoc overview
 * @name OnzsaApp
 * @description
 * # OnzsaApp
 *
 * Onzsa AngularJS App Main Script
 */

// Declare app level module which depends on filters, and services
var OnzsaApp = angular.module('OnzsaApp', [
/*
  'ngAnimate',
  'ngAria',
  'ngCookies',
  'ngMessages',
  'ngRoute',
*/
  'ngSanitize',
  'ngTouch',
  'ngResource',
  'ui.bootstrap',
  'ui.router',
  'ngLocalize',
  'ngLocalize.Config',
  'ngLocalize.InstalledLanguages',
  'LocalStorageModule',
  'cfp.hotkeys',
  'datatables',
  'datatables.tabletools',
  'oc.lazyLoad'
])

/* Setup locale configurations */
.value('localeConf', {
  basePath: 'languages',
  defaultLocale: 'ko-KR',
  sharedDictionary: 'common',
  fileExtension: '.lang.json',
  cookieName: 'COOKIE_LOCALE_LANG',
  observableAttrs: new RegExp('^data-(?!ng-|i18n)'),
  delimiter: '::'
})

.value('localeSupported', [
  'en-NZ',
  /*
  'en-AU',
  'en-EB',
  'en-US',
  */
  'ko-KR',
  'pt-BR'
]);

//AngularJS v1.3.x workaround for old style controller declarition in HTML]);
OnzsaApp.config(['$controllerProvider', function($controllerProvider) {
  // this option might be handy for migrating old apps, but please don't use it
  // in new ones!
  $controllerProvider.allowGlobals();
}]);

/* Configure ocLazyLoader(refer: https://github.com/ocombe/ocLazyLoad) */
OnzsaApp.config(['$ocLazyLoadProvider', function($ocLazyLoadProvider) {
  $ocLazyLoadProvider.config({
    // global configs go here
  });
}]);

// Configure localStorageService
OnzsaApp.config(['localStorageServiceProvider', function(localStorageServiceProvider) {
  localStorageServiceProvider
    .setPrefix('onzsa')
    .setStorageType('localStorage');
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
      absolute: true,
      cache: false,
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
            name: 'dependencies',
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

              '/app/scripts/onzsa_ds.js',
              '/app/scripts/table-advanced.js',
              '/app/scripts/ui-register-tpls-new.js',
              '/app/scripts/controllers/PaymentController.js',
            ]
          },
          {
            name: 'SellController',
            insertBefore: '#ng_load_plugins_before', // load the above css files before a LINK element with this ID. Dynamic CSS files must be loaded between core and theme css files
            files: [
              '/app/scripts/controllers/SellController.js'
            ]
          }]);
        }]
      }
    })
    .state('recall-sale', {
      absolute: true,
      cache: false,
      url: "/recall-sale",
      views: {
        "lazyLoadView": {
          controller: 'RecallController', // This view will use SellController loaded below in the resolve
          templateUrl: '/app/views/recall-sale.html'
        }
      },
      resolve: { // Any property in resolve should return a promise and is executed before the view is loaded
        deps: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load([{
            name: 'dependencies',
            insertBefore: '#ng_load_plugins_before', // load the above css files before a LINK element with this ID. Dynamic CSS files must be loaded between core and theme css files
            files: [
              '/theme/metronic/assets/global/plugins/morris/morris.css',
              '/theme/metronic/assets/global/plugins/select2/select2.css',
              '/theme/metronic/assets/admin/pages/css/tasks.css',
              '/app/styles/register.css',

              '/theme/metronic/assets/global/plugins/morris/morris.min.js',
              '/theme/metronic/assets/global/plugins/morris/raphael-min.js',
              '/theme/metronic/assets/global/plugins/jquery.sparkline.min.js',

              '/theme/metronic/assets/global/plugins/select2/select2.min.js',
              '/theme/metronic/assets/admin/pages/scripts/tasks.js',

              '/lib/angular-datatables/dist/plugins/colreorder/angular-datatables.colreorder.min.js',
              '/lib/angular-datatables/dist/plugins/columnfilter/angular-datatables.columnfilter.min.js',
              '/lib/angular-datatables/dist/plugins/fixedcolumns/angular-datatables.fixedcolumns.min.js',
              '/lib/angular-datatables/dist/plugins/fixedheader/angular-datatables.fixedheader.min.js',
              '/lib/angular-datatables/dist/plugins/scroller/angular-datatables.scroller.min.js',
              '/lib/angular-datatables/dist/plugins/tabletools/angular-datatables.tabletools.min.js',

              '/app/scripts/onzsa_ds.js',
              '/app/scripts/ui-register-tpls-new.js',
            ]
          },
          {
            name: 'RecallController',
            insertBefore: '#ng_load_plugins_before', // load the above css files before a LINK element with this ID. Dynamic CSS files must be loaded between core and theme css files
            files: [
              '/app/scripts/controllers/RecallController.js'
            ]
          }]);
        }]
      }
    })
    .state('daily-snapshot', {
      absolute: true,
      cache: false,
      url: "/daily-snapshot",
      views: {
        "lazyLoadView": {
          controller: 'DailySnapshotController', // This view will use SellController loaded below in the resolve
          templateUrl: '/app/views/daily-snapshot.html'
        }
      },
      resolve: { // Any property in resolve should return a promise and is executed before the view is loaded
        deps: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load([{
            name: 'dependencies',
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

              '/app/scripts/onzsa_ds.js',
              '/app/scripts/ui-register-tpls-new.js',
            ]
          },
          {
            name: 'DailySnapshotController',
            insertBefore: '#ng_load_plugins_before', // load the above css files before a LINK element with this ID. Dynamic CSS files must be loaded between core and theme css files
            files: [
              '/app/scripts/controllers/DailySnapshotController.js'
            ]
          }]);
        }]
      }
    })
    .state('close-register', {
      absolute: true,
      cache: false,
      url: "/close-register",
      views: {
        "lazyLoadView": {
          controller: 'CloseRegisterController', // This view will use SellController loaded below in the resolve
          templateUrl: '/app/views/daily-snapshot.html'
        }
      },
      resolve: { // Any property in resolve should return a promise and is executed before the view is loaded
        deps: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load([{
            name: 'dependencies',
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

              '/app/scripts/onzsa_ds.js',
              '/app/scripts/ui-register-tpls-new.js',
            ]
          },
          {
            name: 'CloseRegisterController',
            insertBefore: '#ng_load_plugins_before', // load the above css files before a LINK element with this ID. Dynamic CSS files must be loaded between core and theme css files
            files: [
              '/app/scripts/controllers/CloseRegisterController.js'
            ]
          }]);
        }]
      }
    })
    .state('test', {
      absolute: true,
      cache: false,
      url: "/test",
      views: {
        "lazyLoadView": {
          controller: 'TestController', // This view will use SellController loaded below in the resolve
          templateUrl: '/app/views/test.html'
        }
      },
      resolve: { // Any property in resolve should return a promise and is executed before the view is loaded
        deps: ['$ocLazyLoad', function($ocLazyLoad) {
          return $ocLazyLoad.load([{
            name: 'dependencies',
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

              '/app/scripts/onzsa_ds.js',
              '/app/scripts/ui-register-tpls-new.js',
            ]
          },
          {
            name: 'TestController',
            insertBefore: '#ng_load_plugins_before', // load the above css files before a LINK element with this ID. Dynamic CSS files must be loaded between core and theme css files
            files: [
              '/app/scripts/controllers/TestController.js'
            ]
          }]);
        }]
      }
    });

    // Without server side support html5 must be disabled.
    $locationProvider.html5Mode(false);
});

/* Init global settings and run the app */
OnzsaApp.run(["$rootScope", "$state", "$http", "settings", function($rootScope, $state, $http, settings) {
  $rootScope.$state = $state; // state to be accessed from view
}]);
