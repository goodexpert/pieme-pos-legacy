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
angular.module('OnzsaApp', [
/*
  'ngAnimate',
  'ngAria',
  'ngMessages',
*/
  'ngSanitize',
  'ngTouch',
  'ngResource',
  'ngRoute',
  'ngCookies',
  'ui.bootstrap',
  'ui.router',
  'ngLocalize',
  'ngLocalize.Config',
  'ngLocalize.Events',
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
  defaultLocale: 'en-NZ',
  sharedDictionary: 'common',
  fileExtension: '.lang.json',
  persistSelection: true,
  cookieName: 'COOKIE_LOCALE_LANG',
  observableAttrs: new RegExp('^data-(?!ng-|i18n)'),
  delimiter: '::'
})

.value('localeSupported', [
  'en-NZ',
  'ko-KR',
  'pt-BR'
])

//AngularJS v1.3.x workaround for old style controller declarition in HTML]);
.config(['$controllerProvider', function($controllerProvider) {
  // this option might be handy for migrating old apps, but please don't use it
  // in new ones!
  $controllerProvider.allowGlobals();
}])

// Configure localStorageService
.config(['localStorageServiceProvider', function(localStorageServiceProvider) {
  localStorageServiceProvider
    .setPrefix('onzsa')
    .setStorageType('localStorage');
}])

/* Configure ocLazyLoader(refer: https://github.com/ocombe/ocLazyLoad) */
.config(['$ocLazyLoadProvider', function($ocLazyLoadProvider) {
  $ocLazyLoadProvider.config({
    // global configs go here
  });
}])

.config(['$tooltipProvider', function($tooltipProvider){
  // Default hide triggers for each show trigger
  $tooltipProvider.setTriggers({
    'mouseenter': 'mouseleave',
    'click': 'click',
    'focus': 'blur',
    'open': 'close'
  });
}])

/* Setup global settings */
.factory('settings', ['$rootScope', function($rootScope) {
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
}])

/* Setup App Main Controller */
.controller('AppController', ['$scope', '$rootScope', 'hotkeys','$state', function($scope, $rootScope, hotkeys ,$state) {
  $scope.$on('$viewContentLoaded', function() {
    Metronic.initComponents(); // init core components
    //Layout.init(); //  Init entire layout(header, footer, sidebar, etc) on page load if the partials included in server side instead of loading with ng-include directive 
  });

  $scope.home = function() {
    debug('go home');
    if (window.location.pathname == '/dashboard') {
      window.location.href = "/#/sales";
    } else {
      $state.go('sales');
    }
  };

  $scope.close = function() {
    debug('go close');
    if (window.location.pathname == '/dashboard') {
      window.location.href = "";
      $state.go('close-register');
    } else {
      $state.go('close-register');
    }
  };
  $scope.recall = function() {
    debug('go recall');
    if (window.location.pathname == '/dashboard') {
      window.location.href = "/#/recall";
    } else {
      $state.go('recall');
    }
  };

  $scope.dashboard = function() {
    debug('go dashboard');
    window.location.href = "/dashboard";
    $state.go('');
  };



  hotkeys.add({
    combo: 'f3',
    description: 'Go to dashboard',
    callback: function() {
      $scope.dashboard();
    }
  });


  hotkeys.add({
    combo: 'f4',
    description: 'Go to home',
    callback: function() {
      $scope.home();
    }
  });

  hotkeys.add({
    combo:'f7',
    description: 'Go to Recall',
    callback: function() {
      $scope.recall();
    }
  });

  hotkeys.add({
    combo:'f8',
    description: 'Go to Close-register',
    callback: function() {
      $scope.close();
    }
  });
}])

/* Setup Layout Part - Header */
.controller('HeaderController', ['$scope', function($scope) {
  $scope.$on('$includeContentLoaded', function() {
    Layout.initHeader(); // init header
  });
}])

/* Setup Layout Part - Sidebar */
.controller('SidebarController', ['$scope','$state', function($scope, $state, $stateParams) {
  $scope.$on('$includeContentLoaded', function() {
    Layout.initSidebar(); // init sidebar
  });

      $scope.home = function() {
        debug('openCashDrawer');
        $state.go('sales');
      };
}])

/* Setup Rounting For All Pages */
.config(['$stateProvider', '$urlRouterProvider', '$ocLazyLoadProvider', function($stateProvider, $urlRouterProvider, $ocLazyLoadProvider) {
  // Redirects and Otherwise
  //
  // Use $urlRouterProvider to configure any redirects (when) and invalid urls (otherwise).
  $urlRouterProvider
    // If the url is ever invalid, e.g. '/asdf', then redirect to '/' aka the home stat
    .otherwise('/sales');

  // State Configurations
  //
  // Use $stateProvider to configure your states.
  $stateProvider
    .state('sales', {
      absolute: true,
      cache: false,
      url: "/sales",
      views: {
        "lazyLoadView": {
          templateUrl: '/app/views/register.html'
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
              '/theme/metronic/assets/global/plugins/typeahead/typeahead.css',
              '/app/styles/register.css',

              '/theme/metronic/assets/global/plugins/morris/morris.min.js',
              '/theme/metronic/assets/global/plugins/morris/raphael-min.js',
              '/theme/metronic/assets/global/plugins/jquery.sparkline.min.js',
              '/theme/metronic/assets/global/plugins/typeahead/handlebars.min.js',
              '/theme/metronic/assets/global/plugins/typeahead/typeahead.bundle.min.js',
              '/theme/metronic/assets/global/plugins/select2/select2.min.js',
              '/theme/metronic/assets/admin/pages/scripts/tasks.js',

              '/lib/angular-datatables/dist/plugins/colreorder/angular-datatables.colreorder.min.js',
              '/lib/angular-datatables/dist/plugins/columnfilter/angular-datatables.columnfilter.min.js',
              '/lib/angular-datatables/dist/plugins/fixedcolumns/angular-datatables.fixedcolumns.min.js',
              '/lib/angular-datatables/dist/plugins/fixedheader/angular-datatables.fixedheader.min.js',
              '/lib/angular-datatables/dist/plugins/scroller/angular-datatables.scroller.min.js',
              '/lib/angular-datatables/dist/plugins/tabletools/angular-datatables.tabletools.min.js',

              '/app/scripts/modules/scale-client.js',
              '/app/scripts/modules/cashdrawer-client.js',
              '/app/scripts/modules/onzsa_ds.js',
              '/app/scripts/modules/service.js',
              '/app/scripts/modules/storage.js',
              //'/app/scripts/modules/ui-register-tpls-new.js',
            ]
          },
          {
            name: 'RegisterController',
            insertBefore: '#ng_load_plugins_before', // load the above css files before a LINK element with this ID. Dynamic CSS files must be loaded between core and theme css files
            files: [
              '/app/scripts/controllers/register.js'
            ]
          }]);
        }]
      }
    })
    .state('sales.edit', {
      absolute: true,
      cache: false,
      url: "/:saleId",
      views: {
        "lazyLoadView": {
          templateUrl: '/app/views/register.html'
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
              '/theme/metronic/assets/global/plugins/typeahead/typeahead.css',
              '/theme/metronic/assets/admin/pages/css/tasks.css',
              '/app/styles/register.css',

              '/theme/metronic/assets/global/plugins/morris/morris.min.js',
              '/theme/metronic/assets/global/plugins/morris/raphael-min.js',
              '/theme/metronic/assets/global/plugins/jquery.sparkline.min.js',
              '/theme/metronic/assets/global/plugins/typeahead/handlebars.min.js',
              '/theme/metronic/assets/global/plugins/typeahead/typeahead.bundle.min.js',

              '/theme/metronic/assets/global/plugins/select2/select2.min.js',
              '/theme/metronic/assets/admin/pages/scripts/tasks.js',

              '/lib/angular-datatables/dist/plugins/colreorder/angular-datatables.colreorder.min.js',
              '/lib/angular-datatables/dist/plugins/columnfilter/angular-datatables.columnfilter.min.js',
              '/lib/angular-datatables/dist/plugins/fixedcolumns/angular-datatables.fixedcolumns.min.js',
              '/lib/angular-datatables/dist/plugins/fixedheader/angular-datatables.fixedheader.min.js',
              '/lib/angular-datatables/dist/plugins/scroller/angular-datatables.scroller.min.js',
              '/lib/angular-datatables/dist/plugins/tabletools/angular-datatables.tabletools.min.js',

              '/app/scripts/modules/onzsa_ds.js',
              '/app/scripts/modules/service.js',
              '/app/scripts/modules/storage.js',
              //'/app/scripts/modules/ui-register-tpls-new.js',
            ]
          },
          {
            name: 'RegisterController',
            insertBefore: '#ng_load_plugins_before', // load the above css files before a LINK element with this ID. Dynamic CSS files must be loaded between core and theme css files
            files: [
              '/app/scripts/controllers/register.js'
            ]
          }]);
        }]
      }
    })
    .state('recall', {
      absolute: true,
      cache: false,
      url: "/recall",
      views: {
        "lazyLoadView": {
          templateUrl: '/app/views/recall.html'
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

              '/app/scripts/modules/onzsa_ds.js',
              '/app/scripts/modules/service.js',
              '/app/scripts/modules/storage.js',
              //'/app/scripts/modules/ui-register-tpls-new.js',
            ]
          },
          {
            name: 'RecallController',
            insertBefore: '#ng_load_plugins_before', // load the above css files before a LINK element with this ID. Dynamic CSS files must be loaded between core and theme css files
            files: [
              '/app/scripts/controllers/recall.js'
            ]
          }]);
        }]
      }
    })
    .state('history', {
      absolute: true,
      cache: false,
      url: "/history",
      views: {
        "lazyLoadView": {
          templateUrl: '/app/views/history.html'
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

              '/app/scripts/modules/onzsa_ds.js',
              '/app/scripts/modules/service.js',
              '/app/scripts/modules/storage.js',
              //'/app/scripts/modules/ui-register-tpls-new.js',
            ]
          },
            {
              name: 'HistoryController',
              insertBefore: '#ng_load_plugins_before', // load the above css files before a LINK element with this ID. Dynamic CSS files must be loaded between core and theme css files
              files: [
                '/app/scripts/controllers/history.js'
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
          controller: 'CloseRegisterController', // This view will use CloseRegisterController loaded below in the resolve
          templateUrl: '/app/views/close-register.html'
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

              '/app/scripts/modules/onzsa_ds.js',
              '/app/scripts/modules/service.js',
              '/app/scripts/modules/storage.js',
              //'/app/scripts/modules/ui-register-tpls-new.js',
            ]
          },
          {
            name: 'CloseRegisterController',
            insertBefore: '#ng_load_plugins_before', // load the above css files before a LINK element with this ID. Dynamic CSS files must be loaded between core and theme css files
            files: [
              '/app/scripts/controllers/close-register.js'
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
          controller: 'DailySnapshotController', // This view will use DailySnapshotController loaded below in the resolve
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

              '/app/scripts/modules/onzsa_ds.js',
              '/app/scripts/modules/service.js',
              '/app/scripts/modules/storage.js',
              //'/app/scripts/modules/ui-register-tpls-new.js',
            ]
          },
          {
            name: 'DailySnapshotController',
            insertBefore: '#ng_load_plugins_before', // load the above css files before a LINK element with this ID. Dynamic CSS files must be loaded between core and theme css files
            files: [
              '/app/scripts/controllers/daily-snapshot.js'
            ]
          }]);
        }]
      }
    })
    .state('refund', {
      absolute: true,
      cache: false,
      url: "/refund",
      views: {
        "lazyLoadView": {
          controller: 'RefundController', // This view will use DailySnapshotController loaded below in the resolve
          templateUrl: '/app/views/refund.html'
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

              '/app/scripts/modules/onzsa_ds.js',
              '/app/scripts/modules/service.js',
              '/app/scripts/modules/storage.js',
              //'/app/scripts/modules/ui-register-tpls-new.js',
            ]
          },
            {
              name: 'RefundController',
              insertBefore: '#ng_load_plugins_before', // load the above css files before a LINK element with this ID. Dynamic CSS files must be loaded between core and theme css files
              files: [
                '/app/scripts/controllers/refund.js'
              ]
            }]);
        }]
      }
    })

    .state("test", {
      absolute: true,
      cache: false,
      url: "/test", // root route
      views: {
        "lazyLoadView": {
          controller: 'TestController', // This view will use TestController loaded below in the resolve
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

              '/app/scripts/modules/onzsa_ds.js',
              '/app/scripts/modules/service.js',
              '/app/scripts/modules/storage.js',
              //'/app/scripts/modules/ui-register-tpls-new.js',
            ]
          },
          {
            name: 'TestController',
            insertBefore: '#ng_load_plugins_before', // load the above css files before a LINK element with this ID. Dynamic CSS files must be loaded between core and theme css files
            files: [
              '/app/scripts/controllers/test.js'
            ]
          }]);
        }]
      }
    });
}])

/* Init global settings and run the app */
.run(["$rootScope", "$state", "$http", "settings", function($rootScope, $state, $http, settings) {
  $rootScope.$state = $state; // state to be accessed from view
}]);
