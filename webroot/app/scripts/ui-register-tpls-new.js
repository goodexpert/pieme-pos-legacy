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

.controller('NumpadController', ['$scope', '$attrs', '$parse', '$interpolate', '$log', 'numpadConfig', '$numpadSuppressError', function($scope, $attrs, $parse, $interpolate, $log, numpadConfig, $numpadSuppressError) {
  var self = this,
      ngModelCtrl = { $setViewValue: angular.noop }; // nullModelCtrl;

  // Modes chain
  this.modes = ['discount', 'quantity'];

  // Configuration attributes
  angular.forEach(['discountType', 'discount', 'price', 'salePrice', 'tax', 'taxRate', 'quantity', 'numpadMode', 'randomKey', 'shortcutPropagation'], function( key, index ) {
    self[key] = angular.isDefined($attrs[key]) ? (index < 3 ? $interpolate($attrs[key])($scope.$parent) : $scope.$parent.$eval($attrs[key])) : numpadConfig[key];
  });

  // Watchable date attributes
  angular.forEach(['discountType', 'discount', 'price', 'salePrice', 'tax', 'taxRate', 'quantity', 'numpadMode', 'randomKey', 'shortcutPropagation'], function( key ) {
    if ($attrs[key]) {
      $scope.$parent.$watch($parse($attrs[key]), function(value) {
        self[key] = angular.isDefined(value) ? value : $attrs[key];
        $scope[key] = self[key];

        if (key == 'quantity') {
          ngModelCtrl.$setViewValue(self[key]);
          ngModelCtrl.$render();
        }

        if (key == 'price') {
          if ($scope.discountType == 0) {
            ngModelCtrl.$setViewValue($scope.discount * 100 / $scope.price);
          } else {
            ngModelCtrl.$setViewValue($scope.price - $scope.discount);
          }
          ngModelCtrl.$render();
        }
      });
    } else {
      self[key] = numpadConfig[key] || null;
      $scope[key] = self[key];
    }
  });

  /*
  angular.forEach(this.modes, function( key ) {
    if ($attrs[key]) {
      $scope.$parent.$watch($parse($attrs[key]), function(value) {
        self[key] = angular.isDefined(value) ? value : $attrs[key];
        $scope[key] = self[key];
        /*
        if ((key == 'minMode' && self.modes.indexOf( $scope.datepickerMode ) < self.modes.indexOf( self[key] )) || (key == 'maxMode' && self.modes.indexOf( $scope.datepickerMode ) > self.modes.indexOf( self[key] ))) {
          $scope.datepickerMode = self[key];
        }
        console.log(key + ':' +  value);
      });
    } else {
      self[key] = numpadConfig[key] || null;
      $scope[key] = self[key];
    }
  });
  */

  $scope.discount = $scope.discount || numpadConfig.discount;
  $scope.discountType = $scope.discountType || numpadConfig.discountType;
  $scope.price = $scope.price || numpadConfig.price;
  $scope.tax = $scope.tax || numpadConfig.tax;
  $scope.quantity = $scope.quantity || numpadConfig.quantity;
  $scope.numpadMode = $scope.numpadMode || numpadConfig.numpadMode;

  $scope.currency = {};
  $scope.currency.visible = 1;
  $scope.counting= {};
  $scope.counting.visible = 1;

  $scope.uniqueId = 'numpad-' + $scope.$id + '-' + Math.floor(Math.random() * 10000);

  this.init = function(ngModelCtrl_) {
    ngModelCtrl = ngModelCtrl_;

    ngModelCtrl.$render = function() {
      self.render();
    };
  }; 

  this.render = function() {
    setNumber(ngModelCtrl.$viewValue);
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

  function getNumber() {
    if ('discount' == $scope.numpadMode) {
      return $scope.currency.number;
    } else {
      return $scope.counting.number;
    }
  }

  function setNumber(value) {
    if ('discount' == $scope.numpadMode) {
      $scope.currency.number = value;
    } else {
      $scope.counting.number = value;
    }
  }

  $scope.onChangeUnit = function() {
    var number = getNumber();

    console.log('current number is ' + number);
    console.log('discount type is ' + this.discountType);
    if (this.discountType == 0) {
      //ngModelCtrl.$setViewValue($scope.discount * 100 / $scope.price);
    } else {
      //ngModelCtrl.$setViewValue($scope.price - $scope.discount);
    }
  }

  $scope.onChangeInput = function() {
    var number = getNumber();
    var regexp = /^\d{0,9}(\.\d{0,5})?$/;

    /*
    if (regexp.test(number)) {
      ngModelCtrl.$setViewValue(number);
    }
    ngModelCtrl.$render();
    */
    setNumber(number);
  }

  $scope.isNumpadVisible = function() {
    if ('discount' == $scope.numpadMode) {
      return $scope.currency.visible;
    } else {
      return $scope.counting.visible;
    }
  }

  $scope.onNumber = function(input) {
    var number = getNumber();
    number = ('undefined' == typeof number ? '' : number);

    var regexp = /^\d+?$/;

    if ('.' == input) {
      if (regexp.test(number)) {
        number += input;
      } else if (number.length == 0) {
        number = '0';
        number += input;
      }
    } else if ('0' == input || '00' == input) {
      if (!regexp.test(number) || parseFloat(number) > 0) {
        number += input;
      } else if (number.length == 0) {
        number = '0';
      }
    } else if (parseFloat(number) == 0) {
      number = input;
    } else {
      number += input;
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
    /*
      ngModelCtrl.$setViewValue(number);
      ngModelCtrl.$render();
    */
      setNumber(number);
    }
  };

  $scope.onBackspace = function() {
    var number = getNumber();
    number = ('undefined' == typeof number ? '' : number);
    number = number.slice(0, -1);

    /*
    ngModelCtrl.$setViewValue(number);
    ngModelCtrl.$render();
    */
    setNumber(number);
  };

  $scope.onPercentage = function() {
  };

  $scope.onReturn = function() {
    var number = getNumber();
    number = isNaN(parseFloat(number)) ? 0: number;

    ngModelCtrl.$setViewValue(number);
    ngModelCtrl.$render();
    $scope.$parent.close();
  };

  $scope.onSign = function() {
    var number = getNumber();
    number = parseFloat('undefined' == typeof number ? '' : number);
    number *= -1;

    /*
    ngModelCtrl.$setViewValue(number);
    ngModelCtrl.$render();
    */
    setNumber(number);
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
      angular.forEach(['discountType', 'discount', 'price', 'salePrice', 'tax', 'taxRate', 'quantity', 'numpadMode', 'randomKey', 'shortcutPropagation'], function( key ) {
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
    "<div ng-switch=\"numpadMode\" class=\"numpad-content-wrap\" role=\"application\">\n" +
    "  <div ng-switch-when=\"discount\">\n" +
    "    <div class=\"btn-group numpad-switch-btn-group\">\n" +
    "      <label class=\"btn btn-default\" ng-model=\"discountType\" btn-radio=\"0\" ng-change=\"onChangeUnit()\">Percentage</label>\n" +
    "      <label class=\"btn btn-default\" ng-model=\"discountType\" btn-radio=\"1\" ng-change=\"onChangeUnit()\">Unit Price</label>\n" +
    "    </div>\n" +
    "    <div ng-switch=\"discountType\" class=\"numpad-number-input-group\">\n" +
    "      <label ng-switch-when=\"0\" class=\"numpad-input-label\" for=\"change-item-currency-input\">Apply discount percentage</label>\n" +
    "      <label ng-switch-when=\"1\" class=\"numpad-input-label\" for=\"change-item-currency-input\">Edit unit price</label>\n" +
    "      <div class=\"input-group\">\n" +
    "        <span class=\"input-group-btn\">\n" +
    "          <button class=\"btn btn-default\" type=\"button\" ng-model=\"currency.visible\" btn-checkbox btn-checkbox-true=\"1\" btn-checkbox-false=\"0\">\n" +
    "            <i class=\"fa fa-keyboard-o\"></i>\n" +
    "          </button>\n" +
    "        </span>\n" +
    "        <input type=\"text\" class=\"form-control numpad-number-input\" id=\"change-item-currency-input\" placeholder=\"E.g. 20% or 20\" title=\"E.g. 20% or 20\" ng-model=\"currency.number\" ng-change=\"onChangeInput()\" autofocus>\n" +
    "        <span ng-switch-when=\"0\" class=\"input-group-addon\">%</span>\n" +
    "        <span ng-switch-when=\"1\" class=\"input-group-addon\"><i class=\"fa fa-usd\"></i></span>\n" +
    "      </div>\n" +
    "    </div>\n" +
    "  </div>\n" +
    "  <div ng-switch-when=\"quantity\">\n" +
    "    <div class=\"numpad-number-input-group\">\n" +
    "      <label class=\"numpad-input-label\" for=\"change-item-counting-input\">Quantity</label>\n" +
    "      <div class=\"input-group\">\n" +
    "        <span class=\"input-group-btn\">\n" +
    "          <button class=\"btn btn-default\" type=\"button\" ng-model=\"counting.visible\" btn-checkbox btn-checkbox-true=\"1\" btn-checkbox-false=\"0\">\n" +
    "            <i class=\"fa fa-keyboard-o\"></i>\n" +
    "          </button>\n" +
    "        </span>\n" +
    "        <input type=\"text\" class=\"form-control numpad-number-input\" id=\"change-item-counting-input\" placeholder=\"E.g. 20\" title=\"E.g. 20\" ng-model=\"counting.number\" ng-change=\"onChangeInput()\" autofocus>\n" +
    "      </div>\n" +
    "    </div>\n" +
    "  </div>\n" +
    "  <div ng-if=\"isNumpadVisible() == 1\" class=\"numpad-content\">\n" +
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
    "      <button ng-switch-when=\"discount\" type=\"button\" class=\"btn btn-default numpad-key numpad-key-perent\" ng-click=\"onPercentage()\" tabindex=\"-1\"><span>%</span></button>\n" +
    "      <button ng-switch-when=\"quantity\" type=\"button\" class=\"btn btn-default numpad-key numpad-key-sign\" ng-click=\"onSign()\" tabindex=\"-1\"><span>+/-</span></button>\n" +
    "      <button type=\"button\" class=\"btn btn-default numpad-key numpad-key-return\" ng-click=\"onReturn()\" tabindex=\"-1\"><span>return</span></button>\n" +
    "    </div>\n" +
    "  </div>\n" +
    "</div>");
}]);

angular.module("template/numpad/popup.html", []).run(["$templateCache", function($templateCache) {
  $templateCache.put("template/numpad/popup.html",
    "<div class=\"numpad-popup-content\" ng-if=\"isOpen\" style=\"position: absolute; z-index: 10000;\" ng-style=\"{top: position.top+'px', left: position.left+'px'}\" ng-keydown=\"keydown($event)\" ng-click=\"$event.stopPropagation()\">\n" +
    "  <div ng-transclude></div>\n" +
    "</div>");
}]);

