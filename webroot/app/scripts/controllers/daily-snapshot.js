'use strict';

/**
 * @ngdoc function
 * @name OnzsaApp.controller:DailySnapshotController
 *
 * @description
 * Controller of the OnzsaApp
 */
angular.module('OnzsaApp', [])

    .controller('DailySnapshotController', function($rootScope, $scope, $state, $http, $modal, $q, locale, LocalStorage, Register, DTOptionsBuilder, DTColumnBuilder, DTColumnDefBuilder) {

      $scope.$on('$viewContentLoaded', function() {
        // initialize core components
        Metronic.initAjax();
      });


      // initialize payment modal
      init();


      function _getPaymentTypeName(typeId) {
        for (var idx in $scope.register.payments) {
          if (typeId == $scope.register.payments[idx].payment_type_id) {
            return $scope.register.payments[idx].name;
          }
        }
        return "Unknown";
      }

      function init() {

        var config = LocalStorage.getConfig();
        var reg = LocalStorage.getRegister();

        $scope.register = {};
        $scope.register.sales = [];
        $scope.register.payments = [];

        $scope.register.layby_sales = {};
        $scope.register.layby_sales.sales = [];
        $scope.register.layby_sales.payments = [];
        $scope.register.layby_sales.total_sales = 0;
        $scope.register.layby_sales.total_payments = 0;

        $scope.register.account_sales = {};
        $scope.register.account_sales.sales = [];
        $scope.register.account_sales.payments = [];
        $scope.register.account_sales.total_sales = 0;
        $scope.register.account_sales.total_payments = 0;

        $scope.register.name = config.merchant_name;
        $scope.register.outlet_name = config.outlet_name;
        $scope.register.open_time = reg.register_open_time;
        $scope.register.close_time = reg.register_close_time;
        $scope.register.total_transactions = 0;
        $scope.register.total_taxes = 0;
        $scope.register.total_discounts = 0;
        $scope.register.total_payments = 0;
        $scope.register.total_sales = 0;

        $scope.paymentTypes = {};
        $scope.registerSales = {};
        console.debug('adfasdf :%o',$scope.register);
        Register.getRegisterPaymentTypes()
            .then(function(types) {
              // Make payments array by payment types
              $scope.paymentTypes = types;
              for (var idx in types) {
                var payment = {"name": types[idx].name, "payment_type_id": types[idx].payment_type_id, "amount": 0.0};
                $scope.register.payments.push(payment);
              }

              return Register.getRegisterSalesByRegisterID(reg.id, reg.register_open_time);
            })
            .then(function(rtRS) {

              // Getter register sales data
              var defer = $q.defer();
              var promise = [];
              $scope.registerSales = rtRS;
              for (var i=0; i<rtRS.length; i++) {
                var saleID = rtRS[i].id;

                promise.push( Register.getRegisterSalePayments(saleID, i)
                        .then(function(response) {
                          if (response.data.length > 0) {
                            $scope.registerSales[response.index]['payments'] = response.data;
                          }
                        })
                );
              }
              $q.all(promise)
                  .then(function() {
                    var onAccountSales = 0.0, laybySales = 0.0, newSales = 0.0;
                    var onAccountPayments = 0.0, laybyPayments = 0.0, newPayments = 0.0;
                    var totalAmount = parseFloat(0);
                    for (var idx in $scope.registerSales) {

                      // Make data for sales section
                      var registerSale = $scope.registerSales[idx];
                      var amount = 0;

                      for (var index in registerSale.payments) {
                        amount += parseFloat(registerSale.payments[index].amount);
                      }
                      totalAmount += amount;
                      console.debug('aaaaaaaaaaaaaaaaa : ', totalAmount);

                      switch (registerSale.status) {
                        case 'sale_status_layby':
                        case 'sale_status_layby_closed':
                          $scope.register.total_transactions += 1;
                          $scope.register.total_taxes += registerSale.total_tax;
                          $scope.register.total_discounts += registerSale.total_discount;
                          $scope.register.total_payments = totalAmount;
                          $scope.register.total_sales += registerSale.total_price;

                          laybySales += registerSale.total_price;
                          laybyPayments += registerSale.total_payment;

                          var laybySale = {};
                          laybySale.sale_date = new Date(registerSale.sale_date * 1000).format("yyyy-MM-dd hh:mm:ss");
                          laybySale.reciept_number = registerSale.receipt_number;
                          laybySale.user_name = registerSale.user_name;
                          laybySale.customer_name = registerSale.customer_name;
                          laybySale.note = registerSale.note;
                          laybySale.amount = registerSale.total_price;

                          $scope.register.layby_sales.total_sales += registerSale.total_price;
                          $scope.register.layby_sales.sales.push(laybySale);

                          if (registerSale.payments != null) {
                            for (var loop in registerSale.payments) {
                              var salePayment = registerSale.payments[loop];
                              var laybyPayment = {};
                              laybyPayment.sale_date = new Date(salePayment.payment_date * 1000).format("yyyy-MM-dd hh:mm:ss");
                              laybyPayment.reciept_number = registerSale.receipt_number;
                              laybyPayment.user_name = registerSale.user_name;
                              laybyPayment.customer_name = registerSale.customer_name;
                              laybyPayment.note = _getPaymentTypeName(salePayment.payment_type_id);
                              laybyPayment.amount = salePayment.amount;

                              $scope.register.layby_sales.total_payments += salePayment.amount;
                              $scope.register.layby_sales.payments.push(laybyPayment);
                            }
                          }
                          break;

                        case 'sale_status_onaccount':
                        case 'sale_status_onaccount_closed':
                          $scope.register.total_transactions += 1;
                          $scope.register.total_taxes += registerSale.total_tax;
                          $scope.register.total_discounts += registerSale.total_discount;
                          $scope.register.total_payments = totalAmount;
                          $scope.register.total_sales += registerSale.total_price;

                          onAccountSales += registerSale.total_price;
                          onAccountPayments += registerSale.total_payment;

                          var accountSale = {};
                          accountSale.sale_date = new Date(registerSale.sale_date * 1000).format("yyyy-MM-dd hh:mm:ss");
                          accountSale.reciept_number = registerSale.receipt_number;
                          accountSale.user_name = registerSale.user_name;
                          accountSale.customer_name = registerSale.customer_name;
                          accountSale.note = registerSale.note;
                          accountSale.amount = registerSale.total_price;

                          $scope.register.account_sales.total_sales += registerSale.total_price;
                          $scope.register.account_sales.sales.push(accountSale);

                          if (registerSale.payments != null) {
                            for (var loop in registerSale.payments) {
                              var salePayment = registerSale.payments[loop];
                              var accountPayment = {};
                              accountPayment.sale_date = new Date(salePayment.payment_date * 1000).format("yyyy-MM-dd hh:mm:ss");
                              accountPayment.reciept_number = registerSale.receipt_number;
                              accountPayment.user_name = registerSale.user_name;
                              accountPayment.customer_name = registerSale.customer_name;
                              accountPayment.note = _getPaymentTypeName(salePayment.payment_type_id);
                              accountPayment.amount = salePayment.amount;

                              $scope.register.account_sales.total_payments += salePayment.amount;
                              $scope.register.account_sales.payments.push(accountPayment);
                            }
                          }
                          break;

                        case 'sale_status_closed':
                          $scope.register.total_transactions += 1;
                          $scope.register.total_taxes += registerSale.total_tax;
                          $scope.register.total_discounts += registerSale.total_discount;
                          $scope.register.total_payments = totalAmount;
                          $scope.register.total_sales += registerSale.total_price;

                          newSales += registerSale.total_price;
                          newPayments = totalAmount;
                          break;
                      }

                      // Make data for payments section
                      if (registerSale.payments != null) {
                        for (var loop in registerSale.payments) {
                          var salePayment = registerSale.payments[loop];
                          for (var idx in $scope.register.payments) {
                            if ($scope.register.payments[idx].payment_type_id == salePayment.payment_type_id) {
                              $scope.register.payments[idx].amount += salePayment.amount;
                            }
                          }
                        }
                      }
                    }

                    if (newSales > 0 || newPayments > 0) {
                      var sale = {"name" : "New", "total_sales" : newSales, "total_payments" : newPayments };
                      $scope.register.sales.push(sale);
                    }
                    if (onAccountSales > 0 || onAccountPayments > 0) {
                      var sale = {"name" : "On account", "total_sales" : onAccountSales, "total_payments" : onAccountPayments };
                      $scope.register.sales.push(sale);
                    }
                    if (laybySales > 0 || laybyPayments > 0) {
                      var sale = {"name" : "Layby", "total_sales" : laybySales, "total_payments" : laybyPayments };
                      $scope.register.sales.push(sale);
                    }
                  });
            });
      }

      $(".end-of-day").click(function(){
        $state.go('close-register');
      });

      $(".daily-snapshot-print").click(function(){
        print();
      });
    });

