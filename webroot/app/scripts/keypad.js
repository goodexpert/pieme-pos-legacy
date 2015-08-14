/**
 * Created by kunwoo  on 13/08/2015.
 */

function priceCalculator() {
  var setPriceS;
  var qtyS;
  var linePriceS = 0;
  var totalTax = 0;
  var totalSub = 0;
  var toPay = 0;

  $(".order-product").each(function () {
    var setPrice = $(this).children(".added-discount").text();
    var qty = $(this).children(".added-qty").children($(".qty-control")).text();
    var linePrice = qty * $(this).children(".hidden-retail_price").val();
    var lineTax = qty * $(this).children(".hidden-tax").val();
    var setPrice = $(this).children('.added-discount').children('.price-control').text().slice(1);
    totalTax += qty * $(this).children(".hidden-tax").val();
    totalSub += qty * $(this).children(".hidden-retail_price").val();
    linePriceS += linePrice + lineTax;

    $(this).children(".added-amount").text((setPrice * qty).toFixed(2));

    toPay += setPrice * qty;
  });

  if ($(".order-discount").length > 0) {
    $(".order-discount").each(function () {
      toPay -= parseFloat($(this).find('.amount').text());
    });
  }

  $(".gst").text(parseFloat(toPay - toPay / 1.15).toFixed(2));
  $(".total").text(parseFloat(toPay).toFixed(2));
  $(".toPay").text(parseFloat(toPay).toFixed(2));
  $(".subTotal").text(parseFloat($(".total").text() - $(".gst").text()).toFixed(2));
}

function number_write(x) {
  var text_box = document.getElementsByClassName("price_field")[0];
  if (x >= 0 && x <= 9) {
    if (isNaN(text_box.value))
      text_box.value = 0;

    if (x > 0 && x <= 9 && text_box.value == '0') {

      text_box.value = "";
      text_box.value += x;

    } else if (x == 0 && text_box.value == '0') {
      text_box.value = "0";
    } else if (x == '00' && text_box.value == '0') {
      x = "";
      text_box.value = "0";
    } else {
      text_box.value += x;
    }
  }
  if (x == '.') {
    if (text_box.value.indexOf(".") >= 0) {
    } else {
      text_box.value += '.';
    }
  }
}

function number_clear() {
  document.getElementsByClassName("price_field")[0].value = '';
}

function number_c() {
  var text_box = document.getElementsByClassName("price_field")[0];
  var num = text_box.value;
  var num1 = num % 10;
  num -= num1;
  num /= 10;
  text_box.value = num;
}

function number_negative() {
  var text_box = document.getElementsByClassName("price_field")[0];
  var num = text_box.value;
  text_box.value = -num;
}

function qty_write(x) {
  var text_box = document.getElementsByClassName("qty_field")[0];
  if (x >= 0 && x <= 9) {
    if (isNaN(text_box.value))
      text_box.value = 0;

    if (x > 0 && x <= 9 && text_box.value == '0') {

      text_box.value = "";
      text_box.value += x;

    } else if (x == 0 && text_box.value == '0') {
      text_box.value = "0";
    } else if (x == '00' && text_box.value == '0') {
      x = "";
      text_box.value = "0";
    } else {
      text_box.value += x;
    }
  }
  if (x == '.') {
    if (text_box.value.indexOf(".") >= 0) {
    } else {
      text_box.value += '.';
    }
  }
}

function qty_clear() {
  document.getElementsByClassName("qty_field")[0].value = '';
}

function qty_c() {
  var text_box = document.getElementsByClassName("qty_field")[0];
  var num = text_box.value;
  var num1 = num % 10;
  num -= num1;
  num /= 10;
  text_box.value = num;
}

function qty_negative() {
  var text_box = document.getElementsByClassName("qty_field")[0];
  var num = text_box.value;
  text_box.value = -num;
}

/** NUMBER PAD SETTINGS END **/

$(document).on("click",".show_numpad",function() {
  $(".arrow").toggleClass('numpad_active');
  $(".numpad").toggle();
  $(".numpad").toggleClass('numpad_active');
  $(".numpad").position({
    my: "left+60 bottom+90",
    using: function (position) {
      $(this).animate(position);
    }
  });
  $(".qty_block").toggleClass('numpad_active');
  $(".qty_block").position({
    my: "left+60 bottom+90",
    using: function (position) {
      $(this).animate(position);
    }
  });
  /*
   $(".discount_block").toggleClass('numpad_active');
   $(".discount_block").position({
   my: "left+860 bottom+30",
   using: function( position ) {
   $( this ).animate( position );
   }
   });
   */

  var priceEdit = "discount";
  var priceEditAll = "discount";
  $(document).on("click", "#set-discount", function () {
    $(this).addClass("active");
    $("#set-unit-price").removeClass("active");
    $(".numpad_text").attr({'value': ''});
    $(".numpad_text").attr({'id': 'item-discount'});
    $(".numpad_text").attr({'placeholder': 'E.g. 20% or 20'});
    $("#text-top").text("Apply discount percentage");
    priceEdit = "discount";
  });

  $(document).on("click", "#set-discount-all", function () {
    $(this).addClass("active");
    $("#set-unit-price-all").removeClass("active");
    $(".numpad_text").val("");
    $(".numpad_text").attr({'id': 'item-discount'});
    $(".numpad_text").attr({'placeholder': 'E.g. 20% or 20'});
    $("#text-top").text("Apply discount percentage");
    priceEditAll = "discount";
  });

  $(document).on("click", "#set-unit-price", function () {
    $(this).addClass("active");
    $("#set-discount").removeClass("active");
    $(".numpad_text").val("");
    $(".numpad_text").attr({'id': 'item-unit-price'});
    $(".numpad_text").attr({'placeholder': 'E.g. 2.50'});
    $("#text-top").text("Edit unit price");
    priceEdit = "price";
  });

  $(document).on("click", "#set-unit-price-all", function () {
    $(this).addClass("active");
    $("#set-discount-all").removeClass("active");
    $(".numpad_text").val("");
    $(".numpad_text").attr({'id': 'item-unit-price'});
    $(".numpad_text").attr({'placeholder': 'E.g. 2.50'});
    $("#text-top").text("Edit unit price");
    priceEditAll = "price";
  });

  $(document).on("click", ".price-control", function (event) {
    if ($("#discount_auth").val() == 1) {
      $(".price-form").attr({"data-id": $(this).attr("data-id")});
      if (($(this).position().top + 136) == $(".price_block").position().top) {
        $(".price_block").hide();
        $(".price_block").removeClass("price_block_active");
      } else if (($(this).position().top + 135) == $(".price_block").position().top) {
        $(".price_block").hide();
        $(".price_block").removeClass("price_block_active");
      } else {
        $(".price_block").show();
        $(".qty_block").hide();
        $(".numpad_text").focus();
        $(".numpad_text").val("");
        $(".price_block").addClass("price_block_active");
        if ($(".price_block").hasClass("numpad_active")) {

          if ($(this).position().top < 120) {

            $(".price_block").position({
              my: "left+70 bottom+61",
              of: $(this),
              using: function (position) {
                $(this).animate(position);
              }
            });

          } else {
            $(".price_block").position({
              my: "left+70 bottom+325",
              of: $(this),
              using: function (position) {
                $(this).animate(position);
              }
            });
          }
        } else {
          $(".price_block").position({
            my: "left+70 bottom+110",
            of: $(this),
            using: function (position) {
              $(this).animate(position);
            }
          });
        }
      }
    } else {
      alert("You are not authorized to perform this action!");
    }
  });


  $(document).on('submit', ".price-form", function () {
    if (priceEdit == 'price') {
      $("a[data-id=" + $(this).attr("data-id") + "]").text("@" + parseFloat($(".price_field").val()).toFixed(2));
    } else {
      var currentPrice = $("a[data-id=" + $(this).attr("data-id") + "]").text().replace(/@/, '');
      var toDiscount = currentPrice * $(".price_field").val().replace(/%/, "") / 100;
      $("a[data-id=" + $(this).attr("data-id") + "]").text("@" + parseFloat(currentPrice - toDiscount).toFixed(2));
    }
    $(".price_block").hide();
    priceCalculator();
    return false;
  });

  $(document).on('submit', ".discount-form", function () {
    var discounted_amount = 0;
    if (priceEditAll == 'price') {
      discounted_amount = parseFloat($(".discount_field").val());
    } else {
      var toDiscount = $(".toPay").text() * $(".discount_field").val().replace(/%/, "") / 100;
      discounted_amount = toDiscount;
    }
    $(".added-body").prepend('<tr class="order-discount"><td>Discount</td><td></td><td></td><td class="amount" style="text-align:right;">' + discounted_amount.toFixed(2) + '</td><td class="added-remove"><div class="remove clickable"><div class="glyphicon glyphicon-remove"></div></div></td></tr>');
    $(".discount_block").hide();
    priceCalculator();
    return false;
  });

  $(".qty-form").submit(function () {
    $("a[qty-id=" + $(this).attr("data-id") + "]").text(parseFloat($(".qty_field").val()));
    $(".qty_block").hide();
    priceCalculator();
    assign_pricebook();
    return false;
  });
});