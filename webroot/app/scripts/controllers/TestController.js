'use strict';

/**
 * @ngdoc function
 * @name OnzsaApp.controller:TestController
 *
 * @description
 * Controller of the OnzsaApp
 */

angular.module('OnzsaApp', [])
/*
.controller('KeypadController', ['$scope', '$attrs', '$parse', '$interpolate', '$log', '$numpadSuppressError', function($scope, $attrs, $parse, $interpolate, $log, $numpadSuppressError) {
  var self = this,
      ngModelCtrl = { $setViewValue: angular.noop }; // nullModelCtrl;

  this.init = function(ngModelCtrl_) {
    ngModelCtrl = ngModelCtrl_;

    ngModelCtrl.$render = function() {
      self.render();
    };
  }

  this.render = function() {
    if (ngModelCtrl.$viewValue) {
    }
  }

  $scope.numpadMode = 'discount';
  $scope.discount = {};
  $scope.discount.unit = 'percentage';
  $scope.quantity = {};

  $scope.onChangeInput = function() {
    console.log('onChangeInput : ' + $scope.$id);
    ngModelCtrl.$setViewValue($scope.discount.number);
    ngModelCtrl.$render();
  }

  $scope.onNumber = function() {
    console.log('onNumber : ' + $scope.$id);
    var number = '10';
    ngModelCtrl.$setViewValue(number);
    ngModelCtrl.$render();
  }

  $scope.onBackspace = function() {
    console.log('onBackspace : ' + $scope.$id);
    var number = '20';
    $scope.discount.number = number;
    ngModelCtrl.$setViewValue(number);
    ngModelCtrl.$render();
  }

  $scope.onPercentage = function() {
    console.log('onPercentage : ' + $scope.$id);
    var number = '30';
    $scope.discount.number = number;
    ngModelCtrl.$setViewValue(number);
    ngModelCtrl.$render();
  }

  $scope.onReturn = function() {
    console.log('onReturn : ' + $scope.$id);
    var number = '40';
    $scope.discount.number = number;
    ngModelCtrl.$setViewValue(number);
    ngModelCtrl.$render();
  }

  $scope.onSign = function() {
    console.log('onSign : ' + $scope.$id);
    var number = '50';
    $scope.discount.number = number;
    ngModelCtrl.$setViewValue(number);
    ngModelCtrl.$render();
  }
}])

.directive('keypad', ['$compile', '$parse', '$templateRequest', function ($compile, $parse, $templateRequest) {
  return {
    restrict: 'EA',
    replace: false,
    templateUrl: function(element, attrs) {
      return attrs.templateUrl || 'template/numpad/numpad2.html';
    },
    scope: {
    },
    require: ['keypad', '^ngModel'],
    controller: 'KeypadController',
    controllerAs: 'keypad',
    link: function(scope, element, attrs, ctrls) {
      var numpadCtrl = ctrls[0], ngModelCtrl = ctrls[1];
      numpadCtrl.init(ngModelCtrl);

      var tplUrl = $parse(attrs.templateUrl)(scope.$parent) || 'template/numpad/numpad2.html';
      $templateRequest(tplUrl).then(function(tplContent) {
        $compile(tplContent.trim())(scope, function(clonedElement){
          element.after(clonedElement);
        });
      });
    }
    link: function(scope, element, attrs, ngModel) {
      var numpadEl = angular.element('<div numpad-wrap><div numpad></div></div>');

      // Prevent jQuery cache memory leak (template is now redundant after linking)
      numpadEl.remove();

      var $numpad = $compile(popupEl)(scope);
      // Prevent jQuery cache memory leak (template is now redundant after linking)
      $numpad.remove();

      element.after($numpad);
      console.log('append here!!!!!!!!!!');

      scope.$on('$destroy', function() {
        $numpad.remove();
      });
    }
  };
}])
*/

.controller('TestController', function($rootScope, $scope, $state) {

  $scope.$on('$viewContentLoaded', function() {   
    // initialize core components
    Metronic.initAjax();
  });

  $scope.saleItem = {
    'price': '4.00',
    'price_include_tax': '4.60',
    'discount': '0.20',
    'tax': '0.60',
  };
});

