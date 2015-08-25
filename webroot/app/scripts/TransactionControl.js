
    /**
     *Transaction Control From Here
     **/

    var total_discount = 0;
    var total_cost = 0;

    function clear_sale() {
        $(".customer-search-result").children().hide();
        $("#customer-result-name").text('');
        $("#customer-selected-id").val($("#customer-null").val());
        $(".order-product").remove();
        $(".order-discount").remove();
        $(".added-null").show();
        $(".split_attr").remove();
    }

    function print_receipt(payment_name, paying) {
        var now = new Date(Date.now());

        //$(".invoice-date").text($.datepicker.formatDate('yy/mm/dd', new Date()) + ' ' + now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds());
        $(".fade").hide();
        $(".receipt-product-table").children("tbody").text('');
        $(".order-product").each(function () {
            $(".receipt-product-table").children("tbody").append('<tr><td class="receipt-product-qty">' + $(this).children(".added-qty").children("a").text() + '</td><td class="receipt-product-name">' + $(this).children(".added-product").text().split("$")[0] + '</td><td class="receipt-price pull-right">$' + $(this).children(".added-amount").text() + '</td></tr>');
        });
        $(".order-discount").each(function () {
            $(".receipt-product-table").children("tbody").append('<tr><td class="receipt-product-qty"></td><td class="receipt-product-name">Discount</td><td class="receipt-price pull-right">- $' + $(this).find(".amount").text() + '</td></tr>');
        });
        $('<tr class="split_receipt_attr"><td>' + payment_name + '</td><td class="pull-right">$' + paying + '</td></tr>').insertBefore('.receipt_total');
        $(".receipt-customer-name").text($("#customer-result-name").text());
        $(".receipt-subtotal").text('$' + $(".subTotal").text());
        $(".receipt-tax").text('$' + $(".gst").text());
        $(".receipt-total").text('$' + $(".toPay").text());
        $(".receipt-parent").show('blind');
        $(".modal-backdrop").show();
    }

    function save_line_order() {
        var sequence = 0;
        line_array = [];

        $(".order-product").each(function () {
            var pId = $(this).children(".added-code").val();
            var pName = $(this).children(".added-name").val();
            var pQty = $(this).children(".added-qty").children("a").text();
            var pAmount = $(this).children(".added-amount").text();
            var pSupplyPrice = $(this).children(".hidden-supply_price").val() * pQty;
            var pPrice = $(this).children(".hidden-retail_price").val() * pQty;
            var pTax = $(this).children(".hidden-tax").val() * pQty;
            var pDiscount = $(this).find(".added-price").text().split("$")[1] * pQty - pAmount;

            var line_order = {
                'product_id': pId,
                'name': pName,
                'quantity': pQty,
                'price': pPrice,
                'supply_price': pSupplyPrice,
                'tax': pTax,
                'price_include_tax': pAmount,
                'sequence': sequence,
                'discount': pDiscount,
                'status': 'sale_item_status_valid'
            }

            line_array.push(line_order);
            sequence++;
            total_discount += pDiscount;
            total_cost += pSupplyPrice;
        });

        $(".order-discount").each(function () {
            total_discount += parseFloat($(this).find(".amount").text());
        });
    }

    var sale_id;
    var invoice_sequence = $(".invoice-id").text();

    function save_register_sale(amount) {
        if ($("#retrieve_sale_id").val() !== '') {
            save_line_order();

            line_array = JSON.stringify(line_array);
            $.ajax({
                url: "/home/pay.json",
                type: "POST",
                data: {
                    sale_id: $("#retrieve_sale_id").val(),
                    customer_id: $("#customer-selected-id").val(),
                    total_price: $(".subTotal").text(),
                    total_price_incl_tax: $(".toPay").text(),
                    total_discount: total_discount,
                    total_cost: total_cost,
                    total_tax: $(".gst").text(),
                    note: '',
                    merchant_payment_type_id: payment_id,
                    items: line_array,
                    amount: JSON.stringify(amount)
                },
                success: function (result) {
                    if (result.success) {
                        $("#retrieve_sale_id").val('');
                    } else {
                        console.log(result);
                    }
                }
            });
        } else {
            save_line_order();

            line_array = JSON.stringify(line_array);
            $.ajax({
                url: "/home/pay.json",
                type: "POST",
                data: {
                    customer_id: $("#customer-selected-id").val(),
                    receipt_number: invoice_sequence,
                    total_price: $(".subTotal").text(),
                    total_price_incl_tax: $(".toPay").text(),
                    total_discount: total_discount,
                    total_cost: total_cost,
                    total_tax: $(".gst").text(),
                    note: '',
                    merchant_payment_type_id: payment_id,
                    items: line_array,
                    amount: JSON.stringify(amount)
                },
                success: function (result) {
                    $(".invoice-id").text(invoice_sequence);
                    invoice_sequence++;
                }
            });
        }
    }

    function park_register_sale(status, amount, pays) {
        if ($("#retrieve_sale_id").val() !== '') {
            save_line_order();

            line_array = JSON.stringify(line_array);
            $.ajax({
                url: "/home/park.json",
                type: "POST",
                data: {
                    sale_id: $("#retrieve_sale_id").val(),
                    customer_id: $("#customer-selected-id").val(),
                    total_price: $(".subTotal").text(),
                    total_price_incl_tax: $(".toPay").text(),
                    total_discount: '',
                    total_tax: $(".gst").text(),
                    note: $("#leave_note").val(),
                    status: status,
                    items: line_array,
                    actual_amount: amount,
                    payments: JSON.stringify(pays)
                },
                success: function (result) {
                    if (result.success) {
                        $("#retrieve_sale_id").val('');
                    } else {
                        alert(result.message);
                    }
                }
            });
        } else {
            save_line_order();

            line_array = JSON.stringify(line_array);
            $.ajax({
                url: "/home/park.json",
                type: "POST",
                data: {
                    customer_id: $("#customer-selected-id").val(),
                    receipt_number: invoice_sequence,
                    total_price: $(".subTotal").text(),
                    total_price_incl_tax: $(".toPay").text(),
                    total_discount: '',
                    total_tax: $(".gst").text(),
                    note: $("#leave_note").val(),
                    status: status,
                    items: line_array,
                    actual_amount: amount,
                    payments: JSON.stringify(pays)
                },
                success: function (result) {
                    if (result.success) {
                        invoice_sequence++;
                    } else {
                        console.log(result);
                    }
                }
            });
        }
        clear_sale();
    }

    // Park
    $(document).on("click", ".park-sale", function () {
        park_register_sale('sale_status_saved', 0, 0);
        $(".fade").hide();
        clear_sale();
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
    });

    // Void
    $(document).on("click", ".void-sale", function () {
        park_register_sale('sale_status_voided', $("#set-pay-amount").val(), payments);
        $(".fade").hide();
        clear_sale();
    });
