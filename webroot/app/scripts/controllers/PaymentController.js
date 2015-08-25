'use strict';

/**
 * @ngdoc function
 * @name OnzsaApp.controller:PaymentController
 * @description
 * # PaymentController
 * Controller of the OnzsaApp
 */
angular.module('OnzsaApp', [])
  .controller('PaymentController', function($rootScope, $scope, $ocLazyLoad, $http, $modalInstance, $window, locale, LocalStorage, items) {
    $scope.$on('$includeContentLoaded', function() {
          Metronic.init();
          initPaymentTable();
        }
    )

    // Cancel Button Click
    $scope.cancel = function() {
      $scope.payinfo.status = "cancel";
      $modalInstance.close($scope.payinfo);
    };

    // Initialize
    $scope.init = function() {
      $scope.payinfo = {};
      $scope.payinfo.status = "";

      // define alias for local Datastore
      $scope.ds = Datastore_sqlite;

      // Get ID Information
      var saleID = LocalStorage.getSaleID();
      var config = LocalStorage.getConfig();
      $scope.sale_id = saleID;
      $scope.register_id = config.register_id;
      console.table($scope.sale_id);
      console.table($scope.register_id);

      // Initialize amount
      $scope.remains = $rootScope.registerSale.total_price_incl_tax - $rootScope.registerSale.total_payment;
      $scope.toPayAmount = $scope.remains;

      // Get Payment Type from Local DB
      $scope.paymentTypes = [];
      $scope.ds.getRegisterPaymentTypes(function(rs) {
        if (rs.length > 0) {
          for (var idx=0; idx < rs.length; idx++) {
            $scope.paymentTypes.push(rs[idx]);
          }
          console.table($scope.paymentTypes);
        } else {
          debug("PAYMENT: [WARNING] Not found payment types.");
        }

        // Display reload
        $scope.$apply();
      });

      // Payment Infomation
      $scope.paymentInfo = [];
      var data = {'sale_id':$scope.sale_id};
      $scope.ds.getRegisterSalePayments(data, function(rs) {
        if (rs.length > 0) {
          for (var idx=0; idx < rs.length; idx++) {
            var item = rs[idx];
            item.name = _getPaymentTypeName(item.payment_type_id);
            $scope.paymentInfo.push(item);
          }
        } else {
          debug("PAYMENT: [WARNING] Not found register sale payments.");
        }
        // Display reload
        $scope.$apply();
      });
    }
    $modalInstance.opened.then( $scope.init() );

    // Initialize Payment Table Screen
    var initPaymentTable = function(){
      var table = $("#table_payment");

      var oTable = table.dataTable({
        "dom": "<'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // datatable layout without  horizobtal scroll
        "scrollY": "234px",
        "autoWidth": false,
        "deferRender": true,
        "paging": false,
        "searching": false,
        "ordering": false,
        "info": false,
        "language" : {
          "emptyTable": "&nbsp;",
          "zeroRecords": "&nbsp;"
        }
        /*
         "order": [
         [0, 'asc']
         ],
         "lengthMenu": [
         [5, 15, 20, -1],
         [5, 15, 20, "All"] // change per page values here
         ],
         "pageLength": 10 // set the initial value
         */
      });

      var tableWrapper = $('#table_payment_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
      tableWrapper.find('.dataTables_length select').select2(); // initialize select2 dropdown
    }

    // Click Payment Resource Button
    var payments = {};
    $(document).on("click", ".payment_method", function () {
      var payment_id = $(this).attr("payment-id");
      var payment_name = $(this).attr("payment-type");
      var payment_type_id = parseInt($(this).attr("payment-type-id"));
      var payment_type = $(this).attr("payment-type");
      var paying = parseFloat($("#set-pay-amount").val()).toFixed(2);

      // case payment_type_id eq 5 or payment_type eq 'Integrated EFTPOS (DPS)'

      //if (5 == payment_type_id || 'Integrated EFTPOS (DPS)' == payment_type) {
      //  var dpsClient = new DpsClient();
      //
      //  dpsClient.connect(function (connected, error) {
      //    if (connected) {
      //      dpsClient.payment('TXN12345', paying, function (data, error) {
      //
      //        if (data.responsetext == "ACCEPTED" || data.responsetext == "SIG ACCEPTED") {
      //
      //          //payments.push([payment_id, paying]);
      //
      //          if (parseFloat($scope.remains).toFixed(2) == parseFloat(paying).toFixed(2)) {
      //            //save_register_sale(payments);
      //            //print_receipt(payment_name, paying);
      //            //clear_sale();
      //          } else {
      //            //to_pay = to_pay - paying;
      //            $(".pay").show();
      //            $(".modal-backdrop").show();
      //            //$("#set-pay-amount").val(to_pay.toFixed(2));
      //            $(".payment-display").children("li").prepend('<ul class="split_attr"><li>' + payment_name + '</li><li class="pull-right">$' + paying + '</li></ul>');
      //            //$(".payment-display").find(".total_cost").children(".pull-right").text('$' + to_pay.toFixed(2));
      //            $('<tr class="split_receipt_attr"><td>' + payment_name + '</td><td class="pull-right">$' + paying + '</td></tr>').insertBefore('.receipt_total');
      //          }
      //        }
      //      });
      //    } else {
      //    }
      //  });
      //
      //  return;
      //} else
      //{
      //
      //  if (parseFloat($scope.remains).toFixed(2) == parseFloat(paying).toFixed(2)) {
      //    //save_register_sale(payments);
      //
      //    //print_receipt(payment_name, paying);
      //
      //    //clear_sale();
      //  } else {
      //    $scope.remains = $scope.remains - paying;
      //    $("#set-pay-amount").val($scope.remains.toFixed(2));
      //    $(".payment-display").children("li").prepend('<ul class="split_attr"><li>' + payment_name + '</li><li class="pull-right">$' + paying + '</li></ul>');
      //    $(".payment-display").find(".total_cost").children(".pull-right").text('$' + $scope.remains.toFixed(2));
      //    $('<tr class="split_receipt_attr"><td>' + payment_name + '</td><td class="pull-right">$' + paying + '</td></tr>').insertBefore('.receipt_total');
      //  }


      $scope.remains = $scope.remains - paying;
      $scope.toPayAmount = $scope.remains;

      var now =  getUnixTimestamp();
      var payment = [];
      payment.id = getUUID();
      payment.sale_id = $scope.sale_id;
      payment.register_id = $scope.register_id;
      payment.name = payment_name;
      payment.payment_type_id = payment_type_id;
      payment.merchant_payment_type_id = null;
      payment.amount = paying;
      payment.date = now;

      console.log("amount : "+paying);
      console.log("date : " +now);
      console.log("type : "+payment_name);

      $rootScope.registerSale.total_payment = parseFloat($rootScope.registerSale.total_payment) + parseFloat(paying);
      console.log("total_payment : "+$rootScope.registerSale.total_payment);
      $scope.paymentInfo.push(payment);

      // Save to Payment
      $scope.ds.saveRegisterSalePayments(payment);


      if($scope.remains == 0 ) {
        print_receipt(payment_name, paying);
        clear_sale();
      }

      // Update View
      $scope.$apply();
    });

    // Layby
    $(document).on("click", ".layby-sale", function () {
      if ($("#customer-result-name").text() == "") {
        alert("Customer not selected");
      } else {
        park_register_sale('sale_status_layby', $("#set-pay-amount").val(), payments);
        clear_sale();
      }
      $(".fade").hide();

      $scope.payinfo.status = "layby";
      $modalInstance.close($scope.payinfo);
    });

    // Onaccount
    $(document).on("click", ".onaccount-sale", function () {

      if ($("#customer-result-name").text() == "") {
        alert("Customer not selected");
      } else {
        park_register_sale('sale_status_onaccount', $("#set-pay-amount").val(), payments);
        clear_sale();
      }

      $(".fade").hide();

      $scope.payinfo.status = "onaccount";
      $modalInstance.close($scope.payinfo);
    });


    function print_receipt(payment_name, paying) {
      var now = new Date(Date.now());
      //$(".invoice-date").text($.datepicker.formatDate('yy/mm/dd', new Date()) + ' ' + now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds());
      $(".fade").hide();

      $scope.payinfo.status = "done";
      $modalInstance.close($scope.payinfo);

      console.log($(this));
      $(".receipt-product-table").children("tbody").text('');
      $(".order-product").each(function () {
        $(".receipt-product-table").children("tbody").append('<tr><td class="receipt-product-qty">' + $(this).find(".sale-item-qty").text() + '</td><td class="receipt-product-name">' + $(this).find(".sale-item-name").text().split("$")[0] + '</td><td class="receipt-price pull-right">' + $(this).children(".sale-item-price").text() + '</td></tr>');

      });
      $(".order-discount").each(function () {
        $(".receipt-product-table").children("tbody").append('<tr><td class="receipt-product-qty"></td><td class="receipt-product-name">Discount</td><td class="receipt-price pull-right">- $' + $(this).find(".amount").text() + '</td></tr>');
      });

      $(".payment-info").each(function () {
        $('<tr class="split_receipt_attr"><td>' + payment_name + '</td><td class="pull-right">$' + paying + '</td></tr>').insertBefore('.receipt_total');
      });
      $(".receipt-customer-name").text($("#customer-result-name").text());
      $(".receipt-subtotal").text('$' + $(".subTotal").text());
      $(".receipt-tax").text('$' + $(".gst").text());
      $(".receipt-total").text('$' + $(".toPay").text());
      $(".receipt-parent").show('blind');
      $(".modal-backdrop").show();
    }

    _getPaymentTypeName = function(typeID) {
      var name;
      for(var idx=0; idx<$scope.paymentTypes.length; idx++) {
        var paymentType = $scope.paymentTypes[idx];
        if(paymentType.payment_type_id == typeID) {
          name = paymentType.name;
          break;
        }
      }

      return name;
    }
  });

//TODO: Get UUID for PaymentID
function getUUID() {
  return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
    var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8);
    return v.toString(16);
  });
}

//TODO: get unix timestamp
function getUnixTimestamp() {
  return Math.floor(new Date().getTime() / 1000);
}
$(".confirm-close").click(function () {
  $(".fade").hide();



});

$(document).on("click", ".close-popup", function(){

  $(".receipt-parent").hide();
  $(".fade").hide();
  $(".split_receipt_attr").remove();
  console.log("ddddd");
});

$(document).on("click", ".print", function(){
  console.log('asdfsd');
  $(this).hide();
  $("#receipt").print();
  $(this).show();
});

var total_discount = 0;
var total_cost = 0;

function clear_sale() {
  $(".customer-search-result").children().hide();
  $("#customer-result-name").text('');
  $("#customer-selected-id").val($("#customer-null").val());
  $(".dataTables_scrollBody").empty();
  $(".dataTables_scrollFoot").find('.sale-item-price').text('0');
  //$(".sale-item-name").remove();
  //$(".order-discount").remove();
  //$(".added-null").show();
  //$(".split_attr").remove();
}

var sale_id;


// Void
//$(document).on("click", ".void-sale", function () {
//  park_register_sale('sale_status_voided', $("#set-pay-amount").val(), payments);
//  $(".fade").hide();
//  clear_sale();
//});

