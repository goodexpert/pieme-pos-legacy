'use strict';

/**
 * @ngdoc function
 * @name OnzsaApp.controller:TestController
 *
 * @description
 * Controller of the OnzsaApp
 */

angular.module('OnzsaApp', [])

/**
 * The $popup service creates popup-like directives as well as
 * houses global options for them.
 */
.provider('$popup2', function () {

  /**
   * Returns the actual instance of the $popup service.
   * TODO support multiple triggers
   */
  this.$get = [ '$window', '$compile', '$timeout', '$document', '$position', '$interpolate', '$rootScope', function ( $window, $compile, $timeout, $document, $position, $interpolate, $rootScope ) {
    return function $tooltip ( type, prefix, defaultTriggerShow, options ) {
      options = angular.extend( {}, defaultOptions, globalOptions, options );

      return {
        restrict: 'EA',
        compile: function (tElem, tAttrs) {
          var popupLinker = $compile( template );

          return function link ( scope, element, attrs, tooltipCtrl ) {
          };
        }
      };
    };
  }];
})

/*
.value('$numpadSuppressError', false)

.constant('numpadConfig', {
  discountType: 0,
  discount: 0,
  price: 0,
  salePrice: 0,
  tax: 0,
  taxRate: 0,
  quantity: 0,
  number: '',
  numpadMode: 'discount',
  randomKey: false,
  shortcutPropagation: false
})

.controller('KeypadController', ['$scope', '$attrs', '$parse', '$interpolate', '$log', 'numpadConfig', '$numpadSuppressError', function($scope, $attrs, $parse, $interpolate, $log, numpadConfig, $numpadSuppressError) {
  var self = this,
      ngModelCtrl = { $setViewValue: angular.noop }; // nullModelCtrl;

  this.init = function(ngModelCtrl_) {
    ngModelCtrl = ngModelCtrl_;

    ngModelCtrl.$render = function() {
      self.render();
    };
  } 

  this.render = function() {
  }

  $scope.numpadMode = 'discount';
  $scope.discountType = 0;

  $scope.onChangeUnit = function() {
    console.log('onChangeUnit(): ');
  }

  $scope.onChangeInput = function() {
    console.log('onChangeInput(): ');
  }

  $scope.isNumpadVisible = function() {
    return 1;
  }

  $scope.onNumber = function(input) {
    console.log('onNumber(): ');
  }

  $scope.onBackspace = function() {
    console.log('onBackspace(): ');
  }

  $scope.onPercentage = function() {
    console.log('onPercentage(): ');
  };

  $scope.onReturn = function() {
    console.log('onReturn(): ');
  };

  $scope.onSign = function() {
    console.log('onSign(): ');
  };
}])

.directive('keypad', function () {
  return {
    restrict: 'EA',
    replace: true,
    templateUrl: function(element, attrs) {
      return attrs.templateUrl || 'template/numpad/numpad.html';
    },
    scope: {
      numpadMode: '=?',
      shortcutPropagation: '&?'
    },
    require: ['keypad', '^ngModel'],
    controller: 'KeypadController',
    controllerAs: 'keypad',
    link: function(scope, element, attrs, ctrls) {
      var numpadCtrl = ctrls[0], ngModelCtrl = ctrls[1];

      numpadCtrl.init(ngModelCtrl);
      console.log(ngModelCtrl);
    }
  };
})

.constant('numpadPopupConfig', {
  numpadPopupTemplateUrl: 'template/numpad/popup.html',
  numpadTemplateUrl: 'template/numpad/numpad.html',
  appendToBody: false,
  onOpenFocus: false,
  placement: 'auto'
})

.directive('keypadPopup', ['$compile', '$parse', '$document', '$rootScope', '$position', 'numpadPopupConfig', '$timeout', '$q',
function ($compile, $parse, $document, $rootScope, $position, numpadPopupConfig, $timeout, $q) {
  return {
    restrict: 'EA',
    require: 'ngModel',
    scope: {
      isOpen: '=?'
    },
    link: function(scope, element, attrs, ngModel) {
      var appendToBody = angular.isDefined(attrs.numpadAppendToBody) ? scope.$parent.$eval(attrs.numpadAppendToBody) : numpadPopupConfig.appendToBody,
          onOpenFocus = angular.isDefined(attrs.onOpenFocus) ? scope.$parent.$eval(attrs.onOpenFocus) : numpadPopupConfig.onOpenFocus,
          placementPopup = angular.isDefined(attrs.placement) ? attrs.onOpenFocus : numpadPopupConfig.placement,
          numpadPopupTemplateUrl = angular.isDefined(attrs.numpadPopupTemplateUrl) ? attrs.numpadPopupTemplateUrl : numpadPopupConfig.numpadPopupTemplateUrl,
          numpadTemplateUrl = angular.isDefined(attrs.numpadTemplateUrl) ? attrs.numpadTemplateUrl : numpadPopupConfig.numpadTemplateUrl;

      // popup element used to display numpad
      var popupEl = angular.element('<div keypad-popup-wrap><div keypad></div></div>');
      popupEl.attr({
        'ng-model': 'number',
        'ng-change': 'numberChange(number)',
        'template-url': numpadPopupTemplateUrl
      });

      // numpad element
      var numpadEl = angular.element(popupEl.children()[0]);
      numpadEl.attr('template-url', numpadTemplateUrl);

      function addEventListener(element, event, callback, useCapture) {
        if (element.addEventListener) {
          element.addEventListener(event, callback, useCapture);
        } else if (element.attachEvent) {
          element.attachEvent('on' + event, callback);
        }
      };

      var documentClickBind = function(event) {
        if (scope.isOpen && !element[0].contains(event.target)) {
          scope.$apply(function() {
            scope.isOpen = false;
          });
        }
      };

      scope.show = function() {
        var placement = 'right';
        var position = $position.positionElements(element, numpadEl, placement, appendToBody);
        scope.position = position;
        scope.position.top -= 106;

        scope.closeOthers();
        scope.$apply(function() {
          scope.isOpen = true;
        });

        $timeout(function() {
          if (onOpenFocus) {
            scope.$broadcast('numpad.focus');
          }
          $document.bind('click', documentClickBind);
        }, 0, false);
      };
      addEventListener(element[0], 'click', scope.show);

      scope.close = function() {
        scope.isOpen = false;
        element[0].focus();
      };

      // For triggering close to non-focused numpad
      scope.closeOthers = function() {
        $document.click();
      };

      var $popup = $compile(popupEl)(scope);
      // Prevent jQuery cache memory leak (template is now redundant after linking)
      popupEl.remove();

      if (appendToBody) {
        $document.find('body').append($popup);
      } else {
        element.after($popup);
      }
    }
  };
}])

.directive('keypadPopupWrap', function() {
  return {
    restrict: 'EA',
    replace: true,
    transclude: true,
    templateUrl: function(element, attrs) {
      return attrs.templateUrl || 'template/numpad/popup.html';
    }
  };
})

.directive('popoverToggle', ['$document', '$timeout', function($document, $timeout) {
  return {
    restrict: 'EA',
    scope: true,
    link: function(scope, element, attrs) {
      scope.toggle = function() {
        console.log(scope);
        $timeout(function() {
          element.triggerHandler(scope.openned ? 'close' : 'open');
          scope.openned = !scope.openned;
        });
      }
      scope.remove = function(event) {
        var em = angular.element(event.target);
        console.log(event.target);
        console.log(em);
        if (scope.openned && !element[0].contains(event.target)) {
        console.log(scope.openned);
        console.log(element[0].contains(event.target));
          $timeout(function() {
            element.trigger('close');
            scope.openned = false;
          });
        }
      }
      $document.on('click', scope.remove);
      return element.on('click', scope.toggle);
    }
  };
}])
*/

.controller('TestController', function($rootScope, $scope, $state) {

  $scope.$on('$viewContentLoaded', function() {   
    // initialize core components
    Metronic.initAjax();
  });

  // option popup contants
  $scope.viewMode = 'small';
  $scope.click = function(event) {
    event.preventDefault();
  }

  // numpad test constants
  $scope.number = 55;
  $scope.saleItem = {
    'quantity': 5,
    'price': 4.00,
    'sale_price': 4.00,
    'discount': 0.20,
    'tax': 0.60,
    'tax_rate': 0.15,
  };
});
