$(".confirm-close").click(function () {
  $(".fade").hide();
});
var to_pay;
$("#pay").click(function () {
  if ($(".added-null").is(':visible')) {

  } else {
    $(".pay").show();
    $(".modal-backdrop").show();
    $("#set-pay-amount").val($(".toPay").text());
    to_pay = $(".toPay").text();
    if ($(".split_attr").length > 0) {
      current_amount = to_pay;
      $(".split_attr").each(function () {
        current_amount = current_amount - $(this).find(".pull-right").text().split("$")[1];
        to_pay = to_pay - $(this).find(".pull-right").text().split("$")[1];
      })
      $("#set-pay-amount").val(current_amount.toFixed(2));
      $(".payment-display").find(".total_cost").children(".pull-right").text('$' + current_amount.toFixed(2));
    } else {
      $(".payment-display").find(".total_cost").children(".pull-right").text('$' + $(".toPay").text());
    }
    payments = [];
  }
});

var payments = {};
// Pay
$(document).on("click", ".payment_method", function () {
  payment_id = $(this).attr("payment-id");
  payment_name = $(this).find("p").text();
  var payment_type_id = parseInt($(this).attr("payment-type-id"));
  var payment_type = $(this).attr("payment-type");
  paying = parseFloat($("#set-pay-amount").val()).toFixed(2);
  // case payment_type_id eq 5 or payment_type eq 'Integrated EFTPOS (DPS)'
  if (5 == payment_type_id || 'Integrated EFTPOS (DPS)' == payment_type) {
    var dpsClient = new DpsClient();

    dpsClient.connect(function (connected, error) {
      if (connected) {
        dpsClient.payment('TXN12345', paying, function (data, error) {
          console.log('Call callback:');
          console.log(data);
          if (data.responsetext == "ACCEPTED" || data.responsetext == "SIG ACCEPTED") {

            payments.push([payment_id, paying]);

            if (parseFloat(to_pay).toFixed(2) == parseFloat(paying).toFixed(2)) {
              save_register_sale(payments);
              print_receipt(payment_name, paying);
              clear_sale();
            } else {
              to_pay = to_pay - paying;
              $(".pay").show();
              $(".modal-backdrop").show();
              $("#set-pay-amount").val(to_pay.toFixed(2));
              $(".payment-display").children("li").prepend('<ul class="split_attr"><li>' + payment_name + '</li><li class="pull-right">$' + paying + '</li></ul>');
              $(".payment-display").find(".total_cost").children(".pull-right").text('$' + to_pay.toFixed(2));
              $('<tr class="split_receipt_attr"><td>' + payment_name + '</td><td class="pull-right">$' + paying + '</td></tr>').insertBefore('.receipt_total');
            }
          }
        });
      } else {
      }
    });

    return;
  }



  if (parseFloat(to_pay).toFixed(2) == parseFloat(paying).toFixed(2)) {
    save_register_sale(payments);

    print_receipt(payment_name, paying);

    clear_sale();
  } else {
    to_pay = to_pay - paying;
    $("#set-pay-amount").val(to_pay.toFixed(2));
    $(".payment-display").children("li").prepend('<ul class="split_attr"><li>' + payment_name + '</li><li class="pull-right">$' + paying + '</li></ul>');
    $(".payment-display").find(".total_cost").children(".pull-right").text('$' + to_pay.toFixed(2));
    $('<tr class="split_receipt_attr"><td>' + payment_name + '</td><td class="pull-right">$' + paying + '</td></tr>').insertBefore('.receipt_total');
  }
});
