/*
 * ui-register
 * http://www.onzsa.com
 *
 * Version: 0.0.1 - 2015-08-21
 * LICENCE: MIT
 */
angular.module("ui.register", ["ui.register.tpls", "ui.register.keypad", "ui.bootstrap.position", "ui.bootstrap.tooltip"]);
angular.module("ui.register.tpls", ["template/keypad/keypad.html", "template/keypad/popup.html"]);

/**
 * @ngdoc overview
 * @name ui.register.keypad
 *
 * @description
 * AngularJS version of the keypad directive.
 */
angular.module('ui.register.keypad', ['ui.bootstrap.position'])

.constant('keypadConfig', {
  keypadMode: 'currency',
  randomKey: false
})

.controller('KeypadController', ['$scope', '$attrs', '$parse', '$interpolate', '$log', 'keypadConfig', function($scope, $attrs, $parse, $interpolate, $log, keypadConfig) {
  var self = this,
      ngModelCtrl = { $setViewValue: angular.noop }; // nullModelCtrl;

  $scope.keypadMode = $scope.keypadMode || keypadConfig.keypadMode;

  this.init = function(ngModelCtrl_) {
    ngModelCtrl = ngModelCtrl_;

    ngModelCtrl.$render = function() {
      self.render();
    }
    console.log(self);
  };

  this.render = function() {
    if (ngModelCtrl.$viewValue) {
    }
    this.refreshView();
  };

  this.refreshView = function() {
    if (this.element) {
      this._refreshView();
    }
  };

  $scope.keydown = function(key) {
  };
}])

.directive('keypad', function () {
  return {
    restrict: 'EA',
    replace: true,
    templateUrl: function(element, attrs) {
      return attrs.templateUrl || 'template/keypad/keypad.html';
    },
    scope: {
      keypadMode: '=?'
    },
    require: ['keypad', '^ngModel'],
    controller: 'KeypadController',
    controllerAs: 'keypad',
    link: function(scope, element, attrs, ctrls) {
      var keypadCtrl = ctrls[0], ngModelCtrl = ctrls[1];

      keypadCtrl.init(ngModelCtrl);
    }
  };
})

.directive('currency', function (dateFilter) {
  return {
    restrict: 'EA',
    replace: true,
    templateUrl: function(element, attrs) {
      return attrs.templateUrl || 'template/keypad/currency.html';
    },
    require: '^keypad',
    link: function(scope, element, attrs, ctrl) {
      ctrl._refreshView = function() {
      };

      ctrl.handleKeyDown = function( key, evt ) {
      };

      ctrl.refreshView();
    }
  }
})

.constant('keypadPopupConfig', {
  keypadPopupTemplateUrl: 'template/keypad/popup.html',
  keypadTemplateUrl: 'template/keypad/keypad.html',
  appendToBody: false,
  onOpenFocus: false
})

.directive('keypadPopup', ['$compile', '$parse', '$document', '$rootScope', '$position', 'keypadPopupConfig', '$timeout',
function ($compile, $parse, $document, $rootScope, $position, keypadPopupConfig, $timeout) {
  return {
    restrict: 'EA',
    require: 'ngModel',
    scope: {
      isOpen: '=?'
    },
    link: function(scope, element, attrs, ngModel) {
      var appendToBody = angular.isDefined(attrs.keypadAppendToBody) ? scope.$parent.$eval(attrs.keypadAppendToBody) : keypadPopupConfig.appendToBody,
          keypadPopupTemplateUrl = angular.isDefined(attrs.keypadPopupTemplateUrl) ? attrs.keypadPopupTemplateUrl : keypadPopupConfig.datepickerPopupTemplateUrl,
          keypadTemplateUrl = angular.isDefined(attrs.keypadTemplateUrl) ? attrs.keypadTemplateUrl : keypadPopupConfig.datepickerTemplateUrl;

      // popup element used to display keypad
      var popupEl = angular.element('<div keypad-popup-wrap><div keypad></div></div>');
      popupEl.attr({
        'ng-model': 'number',
        'template-url': keypadPopupTemplateUrl
      });

      // keypad element
      var keypadEl = angular.element(popupEl.children()[0]);
      keypadEl.attr('template-url', keypadTemplateUrl);

      var documentClickBind = function(event) {
        console.log(element);
        if (scope.isOpen && !element[0].contains(event.target)) {
          scope.$apply(function() {
            scope.isOpen = false;
          });
        }
      };

      scope.$watch('isOpen', function(value) {
        if (value) {
          scope.position = appendToBody ? $position.offset(element) : $position.position(element);
          scope.position.top = scope.position.top + element.prop('offsetHeight');
          console.log(scope);

          $timeout(function() {
            $document.bind('click', documentClickBind);
          }, 0, false);
        } else {
          $document.unbind('click', documentClickBind);
        }
      });

      var $popup = $compile(popupEl)(scope);
      // Prevent jQuery cache memory leak (template is now redundant after linking)
      popupEl.remove();

      if (appendToBody) {
        $document.find('body').append($popup);
      } else {
        element.after($popup);
      }

      scope.$on('$destroy', function() {
        $popup.remove();
      });
    }
  };
}])

.directive('keypadPopupWrap', function() {
  return {
    restrict: 'EA',
    replace: true,
    transclude: true,
    templateUrl: function(element, attrs) {
      console.log('keypadPopupWrap');
      return attrs.templateUrl || 'template/keypad/popup.html';
    }
  };
});

angular.module("template/keypad/keypad.html", []).run(["$templateCache", function($templateCache) {
  $templateCache.put("template/keypad/keypad.html",
    "<div ng-switch=\"keypadMode\" role=\"application\">\n" +
    "  <div ng-switch-when=\"currency\">\n" +
    "    <button class=\"btn btn-default\" ng-click=\"changeUnit('percent')\">Percent</button>\n" +
    "    <button class=\"btn btn-default\" ng-click=\"changeUnit('price')\">Unit Price</button>\n" +
    "  </div>\n" +
    "  <div class=\"input-group\">\n" +
    "    <input type=\"text\" class=\"form-control\" placeholder=\"\" ng-model=\"number\">\n" +
    "    <span class=\"input-group-btn\">\n" +
    "      <button class=\"btn btn-default\" type=\"button\">\n" +
    "        <i class=\"glyphicon glyphicon-th\"></i>\n" +
    "      </button>\n" +
    "    </span>\n" +
    "  </div>\n" +
    "  <currency ng-switch-when=\"currency\" tabindex=\"0\"></currency>\n" +
    "  <quantity ng-switch-when=\"quantity\" tabindex=\"1\"></quantity>\n" +
    "</div>");
}]);

angular.module("template/keypad/currency.html", []).run(["$templateCache", function($templateCache) {
  $templateCache.put("template/keypad/currency.html",
    "<div>\n" +
    "  <button type=\"button\" class=\"btn btn-default btn-sm\" ng-click=\"keydown(64)\" tabindex=\"-1\"><span>A</span></button>\n" +
    "  <button type=\"button\" class=\"btn btn-default btn-sm\" ng-click=\"keydown(64)\" tabindex=\"-1\"><span>A</span></button>\n" +
    "  <button type=\"button\" class=\"btn btn-default btn-sm\" ng-click=\"keydown(64)\" tabindex=\"-1\"><span>A</span></button>\n" +
    "  <button type=\"button\" class=\"btn btn-default btn-sm\" ng-click=\"keydown(64)\" tabindex=\"-1\"><span>A</span></button>\n" +
    "  <button type=\"button\" class=\"btn btn-default btn-sm\" ng-click=\"keydown(64)\" tabindex=\"-1\"><span>A</span></button>\n" +
    "  <button type=\"button\" class=\"btn btn-default btn-sm\" ng-click=\"keydown(64)\" tabindex=\"-1\"><span>A</span></button>\n" +
    "  <button type=\"button\" class=\"btn btn-default btn-sm\" ng-click=\"keydown(64)\" tabindex=\"-1\"><span>A</span></button>\n" +
    "  <button type=\"button\" class=\"btn btn-default btn-sm\" ng-click=\"keydown(64)\" tabindex=\"-1\"><span>A</span></button>\n" +
    "  <button type=\"button\" class=\"btn btn-default btn-sm\" ng-click=\"keydown(64)\" tabindex=\"-1\"><span>A</span></button>\n" +
    "  <button type=\"button\" class=\"btn btn-default btn-sm\" ng-click=\"keydown(64)\" tabindex=\"-1\"><span>A</span></button>\n" +
    "  <button type=\"button\" class=\"btn btn-default btn-sm\" ng-click=\"keydown(64)\" tabindex=\"-1\"><span>A</span></button>\n" +
    "  <button type=\"button\" class=\"btn btn-default btn-sm\" ng-click=\"keydown(64)\" tabindex=\"-1\"><span>A</span></button>\n" +
    "</div>");
}]);

angular.module("template/keypad/popup.html", []).run(["$templateCache", function($templateCache) {
  $templateCache.put("template/keypad/popup.html",
    "<div ng-if=\"isOpen\" style=\"display: block\" ng-style=\"{top: position.top+'px', left: position.left+'px'}\">\n" +
    "  <div ng-transclude></div>\n" +
    "</div>");
}]);

