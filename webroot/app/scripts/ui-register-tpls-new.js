/*
 * ui-register
 * http://www.onzsa.com
 *
 * Version: 0.0.1 - 2015-08-21
 * LICENCE: MIT
 */
angular.module("ui.register", ["ui.register.tpls", "ui.register.numpad", "ui.bootstrap.position", "ui.bootstrap.tooltip"]);
angular.module("ui.register.tpls", ["template/numpad/numpad.html", "template/numpad/popup.html"]);

/**
 * @ngdoc overview
 * @name ui.register.numpad
 *
 * @description
 * AngularJS version of the numpad directive.
 */
angular.module('ui.register.numpad', ['ui.bootstrap.position'])

.value('$numpadSuppressError', false)

.constant('numpadConfig', {
  numpadMode: 'currency',
  randomKey: false,
  shortcutPropagation: false
})

.controller('NumpadController', ['$scope', '$attrs', '$interpolate', '$log', 'numpadConfig', '$numpadSuppressError', function($scope, $attrs, $interpolate, $log, numpadConfig, $numpadSuppressError) {
  var self = this,
      ngModelCtrl = { $setViewValue: angular.noop }; // nullModelCtrl;

  // Modes chain
  this.modes = ['currency', 'quantity'];

  // Configuration attributes
  angular.forEach(['numpadMode', 'randomKey', 'shortcutPropagation'], function( key, index ) {
    self[key] = angular.isDefined($attrs[key]) ? (index < 3 ? $interpolate($attrs[key])($scope.$parent) : $scope.$parent.$eval($attrs[key])) : numpadConfig[key];
  });

  // Watchable date attributes
  angular.forEach(this.modes, function( key ) {
    if ( $attrs[key] ) {
      $scope.$parent.$watch($parse($attrs[key]), function(value) {
        self[key] = angular.isDefined(value) ? value : $attrs[key];
        $scope[key] = self[key];
        /*
        if ((key == 'minMode' && self.modes.indexOf( $scope.datepickerMode ) < self.modes.indexOf( self[key] )) || (key == 'maxMode' && self.modes.indexOf( $scope.datepickerMode ) > self.modes.indexOf( self[key] ))) {
          $scope.datepickerMode = self[key];
        }
        */
      });
    } else {
      self[key] = numpadConfig[key] || null;
      $scope[key] = self[key];
    }
  });

  $scope.numpadMode = $scope.numpadMode || numpadConfig.numpadMode;
  $scope.uniqueId = 'numpad-' + $scope.$id + '-' + Math.floor(Math.random() * 10000);

  this.init = function( ngModelCtrl_ ) {
    ngModelCtrl = ngModelCtrl_;

    ngModelCtrl.$render = function() {
      self.render();
    };
  };

  this.render = function() {
    if (ngModelCtrl.$viewValue) {
      $scope.number = ngModelCtrl.$viewValue;
    }
  };

  this.refreshView = function() {
  };

  // Key event mapper
  $scope.keys = { 13:'enter', 32:'space', 33:'pageup', 34:'pagedown', 35:'end', 36:'home', 37:'left', 38:'up', 39:'right', 40:'down' };

  var focusElement = function() {
    self.element[0].focus();
  };

  // Listen for focus requests from popup directive
  $scope.$on('numpad.focus', focusElement);

  $scope.keydown = function( evt ) {

    var key = $scope.keys[evt.which];

    if ( !key || evt.shiftKey || evt.altKey ) {
      return;
    }

    evt.preventDefault();
    if(!self.shortcutPropagation){
      evt.stopPropagation();
    }

    if (key === 'enter' || key === 'space') {
      if ( self.isDisabled(self.activeDate)) {
        return; // do nothing
      }
      $scope.select(self.activeDate);
      focusElement();
    } else if (evt.ctrlKey && (key === 'up' || key === 'down')) {
      $scope.toggleMode(key === 'up' ? 1 : -1);
      focusElement();
    } else {
      self.handleKeyDown(key, evt);
      self.refreshView();
    }
  };

  $scope.onChangeNumber = function() {
    console.log('scope.onChangeNumber > this: ' + this.number);
    console.log('scope.onChangeNumber > scope: ' + $scope.number);
    //$scope.number = this.number;
    ngModelCtrl.$setViewValue(this.number);
    ngModelCtrl.$render();
  };

  $scope.onBackspace = function() {
    this.number = ('undefined' == typeof this.number ? '' : this.number);
    this.number = this.number.slice(0, -1);

    console.log('scope.onBackspace > this: ' + this.number);
    console.log('scope.Backspace > scope: ' + $scope.number);

    ngModelCtrl.$setViewValue(this.number);
    ngModelCtrl.$render();
  };

  $scope.onPercentage = function() {
  };

  $scope.onReturn = function() {
    console.log(this.number);
  };

  $scope.onSign = function() {
    var number = parseFloat('undefined' == typeof this.number ? '' : this.number);
    number *= -1;

    ngModelCtrl.$setViewValue(number.toString());
    ngModelCtrl.$render();
  };

  $scope.onNumber = function(string) {
    var number = ('undefined' == typeof this.number ? '' : this.number.toString());
    var regexp = /^\d+?$/;
    console.log(number + ':' + regexp.test(number));

    if ('.' == string) {
      if (regexp.test(number)) {
        number += string;
      } else if (number.length == 0) {
        number = '0';
        number += string;
      }
    } else if ('0' == string || '00' == string) {
      if (!regexp.test(number) || parseFloat(number) > 0) {
        number += string;
      } else if (number.length == 0) {
        number = '0';
      }
    } else {
      number += string;
    }

    if (regexp.test(number)) {
    } else {
    }

    /*
    regexp = /^\d+?$/;
    if (number.length == 0 && '.' == string) {
      number = '0.';
    } else if (number.length == 0 && '0' == string || '00' == string) {
      var regexp = /^
      number = '0';
    } else {
    }
    */

    regexp = /^\d{0,9}(\.\d{0,5})?$/;
    if (regexp.test(number)) {
      ngModelCtrl.$setViewValue(number);
      ngModelCtrl.$render();
    }
  };
}])

.directive('numpad', function () {
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
    require: ['numpad', '^ngModel'],
    controller: 'NumpadController',
    controllerAs: 'numpad',
    link: function(scope, element, attrs, ctrls) {
      var numpadCtrl = ctrls[0], ngModelCtrl = ctrls[1];

      numpadCtrl.init(ngModelCtrl);
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

.directive('numpadPopup', ['$compile', '$parse', '$document', '$rootScope', '$position', 'numpadPopupConfig', '$timeout', '$q',
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
      var popupEl = angular.element('<div numpad-popup-wrap><div numpad></div></div>');
      popupEl.attr({
        'ng-model': 'number',
        'ng-change': 'numberChange(number)',
        'template-url': numpadPopupTemplateUrl
      });

      function cameltoDash( string ){
        return string.replace(/([A-Z])/g, function($1) { return '-' + $1.toLowerCase(); });
      }

      // numpad element
      var numpadEl = angular.element(popupEl.children()[0]);
      numpadEl.attr('template-url', numpadTemplateUrl);

      if (attrs.numpadOptions) {
        var options = scope.$parent.$eval(attrs.numpadOptions);

        angular.forEach(options, function(value, option) {
          numpadEl.attr(cameltoDash(option), value);
        });
      }

      scope.watchData = {};
      angular.forEach(['numpadMode', 'randomKey', 'shortcutPropagation'], function( key ) {
        if (attrs[key]) {
          var getAttribute = $parse(attrs[key]);
          scope.$parent.$watch(getAttribute, function(value){
            scope.watchData[key] = value;
          });
          numpadEl.attr(cameltoDash(key), 'watchData.' + key);

          // Propagate changes from numpad to outside
          if (key === 'numpadMode') {
            var setAttribute = getAttribute.assign;
            scope.$watch('watchData.' + key, function(value, oldvalue) {
              if ( angular.isFunction(setAttribute) && value !== oldvalue ) {
                setAttribute(scope.$parent, value);
              }
            });
          }
        }
      });

      function addEventListener(element, event, callback, useCapture) {
        if (element.addEventListener) {
          element.addEventListener(event, callback, useCapture);
        } else if (element.attachEvent) {
          element.attachEvent('on' + event, callback);
        }
      };

      // Inner change
      scope.numberChange = function(number) {
        if (angular.isDefined(number)) {
          scope.number = number;
        }
        element.val(number);
        ngModel.$setViewValue(number);
      };

      // Detect changes in the view from the text box
      ngModel.$viewChangeListeners.push(function () {
        scope.number = ngModel.$viewValue;
      });

      var documentClickBind = function(event) {
        if (scope.isOpen && !element[0].contains(event.target)) {
          scope.$apply(function() {
            scope.isOpen = false;
          });
        }
      };

      var inputKeydownBind = function(evt) {
        if (evt.which === 27 && scope.isOpen) {
          evt.preventDefault();
          evt.stopPropagation();
          scope.$apply(function() {
            scope.isOpen = false;
          });
          element[0].focus();
        } else if (evt.which === 40 && !scope.isOpen) {
          evt.preventDefault();
          evt.stopPropagation();
          scope.$apply(function() {
            scope.isOpen = true;
          });
        }
      };
      element.bind('keydown', inputKeydownBind);

      scope.keydown = function(evt) {
        if (evt.which === 27) {
          scope.isOpen = false;
          element[0].focus();
        }
      };

      scope.show = function() {
        var placement = 'right';
        var position = $position.positionElements(element, numpadEl, placement, appendToBody);
        scope.position = position;

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

      /*
      scope.$watch('isOpen', function(value) {
        if (value) {
          var placement = placementPopup;

          if ('auto' === placement) {
          }
          position = $position.positionElements(element, numpadEl, placement, appendToBody);

          //scope.position = appendToBody ? $position.offset(element) : $position.position(element);
          //scope.position.top = scope.position.top + element.prop('offsetHeight');
          scope.position = position;
          scope.position.top -= 92;

          $timeout(function() {
            if (onOpenFocus) {
              scope.$broadcast('numpad.focus');
            }
            $document.bind('click', documentClickBind);
          }, 0, false);
        } else {
          $document.unbind('click', documentClickBind);
        }
      });
      */

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

      scope.$on('$destroy', function() {
        if (scope.isOpen === true) {
          if (!$rootScope.$$phase) {
            scope.$apply(function() {
              scope.isOpen = false;
            });
          }
        }

        $popup.remove();
        element.unbind('keydown', inputKeydownBind);
        $document.unbind('click', documentClickBind);
      });
    }
  };
}])

.directive('numpadPopupWrap', function() {
  return {
    restrict: 'EA',
    replace: true,
    transclude: true,
    templateUrl: function(element, attrs) {
      return attrs.templateUrl || 'template/numpad/popup.html';
    }
  };
});

angular.module("template/numpad/numpad.html", []).run(["$templateCache", function($templateCache) {
  $templateCache.put("template/numpad/numpad.html",
    "<div class=\"numpad-content-wrap\" ng-switch=\"numpadMode\" role=\"application\">\n" +
    "  <div ng-switch-when=\"currency\" class=\"btn-group numpad-switch-btn-group\">\n" +
    "    <label class=\"btn btn-default\" ng-model=\"discountPercentage\" btn-radio=\"\'Left\'\">Percentage</label>\n" +
    "    <label class=\"btn btn-default\" ng-model=\"discountUnit\" btn-radio=\"\'Right\'\">Unit Price</label>\n" +
    "  </div>\n" +
    "  <div class=\"numpad-number-input-group\">\n" +
    "    <label ng-switch-when=\"currency\" class=\"numpad-input-label\" for=\"change-item-discount-input\">Apply discount percentage</label>\n" +
    "    <label ng-switch-when=\"quantity\" class=\"numpad-input-label\" for=\"change-item-quantity-input\">Quantity</label>\n" +
    "    <div class=\"input-group\">\n" +
    "      <span class=\"input-group-btn\">\n" +
    "        <button class=\"btn btn-default\" type=\"button\">\n" +
    "          <i class=\"glyphicon glyphicon-th\"></i>\n" +
    "        </button>\n" +
    "      </span>\n" +
    "      <input ng-switch-when=\"currency\" type=\"text\" class=\"form-control numpad-number-input\" id=\"change-item-discount-input\" placeholder=\"E.g. 20% or 20\" title=\"E.g. 20% or 20\" ng-model=\"number\" ng-change=\"onChangeNumber()\" autofocus>\n" +
    "      <input ng-switch-when=\"quantity\" type=\"text\" class=\"form-control numpad-number-input\" id=\"change-item-quantity-input\" placeholder=\"E.g. 20\" title=\"E.g. 20\" ng-model=\"number\" ng-change=\"onChangeNumber()\" autofocus>\n" +
    "    </div>\n" +
    "  </div>\n" +
    "  <div class=\"numpad-content\">\n" +
    "    <div class=\"numpad-section\">\n" +
    "      <button type=\"button\" class=\"btn btn-default numpad-key\" ng-click=\"onNumber(\'1\')\" tabindex=\"-1\"><span>1</span></button>\n" +
    "      <button type=\"button\" class=\"btn btn-default numpad-key\" ng-click=\"onNumber(\'2\')\" tabindex=\"-1\"><span>2</span></button>\n" +
    "      <button type=\"button\" class=\"btn btn-default numpad-key\" ng-click=\"onNumber(\'3\')\" tabindex=\"-1\"><span>3</span></button>\n" +
    "      <button type=\"button\" class=\"btn btn-default numpad-key\" ng-click=\"onNumber(\'4\')\" tabindex=\"-1\"><span>4</span></button>\n" +
    "      <button type=\"button\" class=\"btn btn-default numpad-key\" ng-click=\"onNumber(\'5\')\" tabindex=\"-1\"><span>5</span></button>\n" +
    "      <button type=\"button\" class=\"btn btn-default numpad-key\" ng-click=\"onNumber(\'6\')\" tabindex=\"-1\"><span>6</span></button>\n" +
    "      <button type=\"button\" class=\"btn btn-default numpad-key\" ng-click=\"onNumber(\'7\')\" tabindex=\"-1\"><span>7</span></button>\n" +
    "      <button type=\"button\" class=\"btn btn-default numpad-key\" ng-click=\"onNumber(\'8\')\" tabindex=\"-1\"><span>8</span></button>\n" +
    "      <button type=\"button\" class=\"btn btn-default numpad-key\" ng-click=\"onNumber(\'9\')\" tabindex=\"-1\"><span>9</span></button>\n" +
    "      <button type=\"button\" class=\"btn btn-default numpad-key\" ng-click=\"onNumber(\'0\')\" tabindex=\"-1\"><span>0</span></button>\n" +
    "      <button type=\"button\" class=\"btn btn-default numpad-key\" ng-click=\"onNumber(\'00\')\" tabindex=\"-1\"><span>00</span></button>\n" +
    "      <button type=\"button\" class=\"btn btn-default numpad-key\" ng-click=\"onNumber(\'.\')\" tabindex=\"-1\"><span>.</span></button>\n" +
    "    </div>\n" +
    "    <div class=\"numpad-section last\">\n" +
    "      <button type=\"button\" class=\"btn btn-default numpad-key numpad-key-delete\" ng-click=\"onBackspace()\" tabindex=\"-1\"><span><i class=\"fa fa-arrow-left\"></i></span></button>\n" +
    "      <button ng-switch-when=\"currency\" type=\"button\" class=\"btn btn-default numpad-key numpad-key-perent\" ng-click=\"onPercentage()\" tabindex=\"-1\"><span>%</span></button>\n" +
    "      <button ng-switch-when=\"quantity\" type=\"button\" class=\"btn btn-default numpad-key numpad-key-sign\" ng-click=\"onSign()\" tabindex=\"-1\"><span>+/-</span></button>\n" +
    "      <button type=\"button\" class=\"btn btn-default numpad-key numpad-key-return\" ng-click=\"onReturn()\" tabindex=\"-1\"><span>return</span></button>\n" +
    "    </div>\n" +
    "  </div>\n" +
    "</div>");
}]);

angular.module("template/numpad/popup.html", []).run(["$templateCache", function($templateCache) {
  $templateCache.put("template/numpad/popup.html",
    "<div class=\"numpad-popup-content\" ng-if=\"isOpen\" style=\"position: absolute; z-index: 1;\" ng-style=\"{top: position.top+'px', left: position.left+'px'}\" ng-keydown=\"keydown($event)\" ng-click=\"$event.stopPropagation()\">\n" +
    "  <div ng-transclude></div>\n" +
    "</div>");
}]);
