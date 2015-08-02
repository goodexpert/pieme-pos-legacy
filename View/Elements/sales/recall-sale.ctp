        <div id="retrieve-sale">
            <div class="tab-content-wrapper col-md-12 col-xs-12 col-sm-12 col-alpha col-omega" style="padding-top: 8px;">
                <table id="retrieveTable" class="table-bordered">
                    <thead>
                    <tr>
                        <th>Date/time</th>
                        <th>Status</th>
                        <th>User</th>
                        <th>Customer</th>
                        <th>Code</th>
                        <th>Total</th>
                        <th>Note</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($retrieves as $sale) { ?>
                        <tr class="clickable retrieve_sale" data-id="<?= $sale['RegisterSale']['id']; ?>" data-customer-id="<?php echo $sale['MerchantCustomer']['id']; ?>" data-customer-name="<?php echo $sale['MerchantCustomer']['name']; ?>" data-customer-balance="<?php echo $sale['MerchantCustomer']['balance']; ?>" data-count="<?= count($sale['RegisterSaleItem']); ?>">
                            <td><?= $sale['RegisterSale']['created']; ?></td>
                            <td><?= $sale['RegisterSale']['status']; ?></td>
                            <td><?= $sale['MerchantUser']['username']; ?></td>
                            <td><?= $sale['MerchantCustomer']['name']; ?></td>
                            <td><?= $sale['MerchantCustomer']['customer_code']; ?></td>
                            <td><?= number_format($sale['RegisterSale']['total_price_incl_tax'], 2, '.', ''); ?></td>
                            <td><?= $sale['RegisterSale']['note']; ?></td>
                            <td>
                                <?php foreach ($sale['RegisterSaleItem'] as $get) { ?>
                                    <span class="hidden retrieve-child-products">
                                    <span class="retrieve-child-id"><?= $get['MerchantProduct']['id']; ?></span>
                                    <span class="retrieve-child-name"><?= $get['MerchantProduct']['name']; ?></span>
                                    <span class="retrieve-child-supply-price"><?php echo number_format($get['MerchantProduct']['supply_price'], 2, '.', ''); ?></span>
                                    <span class="retrieve-child-price"><?php echo number_format($get['MerchantProduct']['price'], 2, '.', ''); ?></span>
                                    <span class="retrieve-child-price-incl-tax"><?= number_format($get['MerchantProduct']['price_include_tax'], 2, '.', ''); ?></span>
                                    <span class="retrieve-child-tax"><?= number_format($get['MerchantProduct']['tax'], 2, '.', ''); ?></span>
                                    <span class="retrieve-child-qty"><?php echo $get['quantity']; ?></span>
                                </span>
                                <?php } ?>
                                <?php foreach ($sale['RegisterSalePayment'] as $paid) { ?>
                                    <span class="hidden retrieve-child-payments">
                                        <input type="hidden" class="payments-name" value="<?php echo $paid['MerchantPaymentType']['name']; ?>">
                                        <input type="hidden" class="payments-amount" value="<?php echo number_format($paid['amount'], 2, '.', ''); ?>">
                                    </span>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<!-- JAVASCRIPT START -->
<script src="/theme/onzsa/assets/global/plugins/jquery-1.11.0.min.js" type="text/javascript"></script>
<script>
jQuery(document).ready(function () {
    $(document).on('click', ".retrieve_sale", function () {
        var customer_name = $(this).attr("data-customer-name");
        var customer_id = $(this).attr("data-customer-id");
        var customer_balance = parseFloat($(this).attr("data-customer-balance")).toFixed(2);
        var retrieve_sale_id = $(this).attr("data-id");
        var customer_group_id = $(this).attr("data-group-id");
        $("#retrieve-sale").addClass("hidden");
        $("#sell-index").removeClass("hidden");
        if ($(".order-product").length !== 0) {
            var targetSale = $(this);
            if ($("#retrieve_sale_id").val() == $(this).attr('data-id')) {
                $("#retrieve-sale").addClass("hidden");
                $("#sell-index").removeClass("hidden");
            } else {
                $(".retrieve-popup").show();
                $(".modal-backdrop").show();
                $("#current_order_count").text($(".order-product").length);
                $("#retrieve_order_count").text($(this).attr("data-count"));
                $(document).on("click", ".retrieve-a", function () {
                    $(".added-null").hide();
                    $(".order-product").remove();
                    $(".order-discount").remove();
                    var retCount = 0;
                    $("#retrieve_sale_id").val(retrieve_sale_id);
                    targetSale.find(".retrieve-child-products").each(function () {
                        var comp_1 = $(this).children(".retrieve-child-price").text();
                        var comp_2 = $(this).children(".retrieve-child-tax").text();
                        var price_including_tax = parseFloat(comp_1) + parseFloat(comp_2);
                        var appendString = '';
                        appendString += '<tr class="order-product">';
                        appendString += '<input type="hidden" class="added-code" value="' + $(this).children(".retrieve-child-id").text() + '">';
                        appendString += '<input type="hidden" class="added-name" value="' + $(this).children(".retrieve-child-name").text() + '">';
                        appendString += '<td class="added-product">' + $(this).children(".retrieve-child-name").text();
                        appendString += '<br><span class="added-price">$' + parseFloat($(this).children(".retrieve-child-price").text()).toFixed(2) + '</span></td>';
                        appendString += '<td class="added-qty"><a qty-id="' + retCount + '" class="qty-control btn btn-white">';
                        appendString += $(this).find(".retrieve-child-qty").text() + '</a></td>';
                        appendString += '<td class="added-discount"><a href="#price-control" class="price-control btn btn-white" data-id="' + retCount + '">@';
                        appendString += price_including_tax.toFixed(2) + '</a></td><td class="added-amount"></td>';
                        appendString += '<td class="added-remove"><div class="remove clickable"><div class="glyphicon glyphicon-remove"></div></div></td></tr>';

                        $(".added-body").prepend(appendString);
                        //$(".added-body").prepend('<tr class="order-product"><input type="hidden" class="added-code" value="'+$(this).children(".retrieve-child-id").text()+'"><td class="added-product">'+$(this).children(".retrieve-child-name").text()+'<br><span class="added-price">$'+parseFloat($(this).children(".retrieve-child-price").text()).toFixed(2)+'</span></td><td class="added-qty"><a qty-id="'+retCount+'" class="qty-control btn btn-white">'+$(this).find(".retrieve-child-qty").text()+'</a></td><td class="added-discount"><a href="#price-control" class="price-control btn btn-white" data-id="'+retCount+'">@'+price_including_tax.toFixed(2)+'</a></td><td class="added-amount"></td><td class="added-remove"><div class="remove clickable"><div class="glyphicon glyphicon-remove"></div></div></td></tr>');
                        retCount++;
                    });
                    targetSale.find(".retrieve-child-payments").each(function () {
                        $('<ul class="split_attr"><li>' + $(this).find(".payments-name").val() + '</li><li class="pull-right">$' + $(this).find(".payments-amount").val() + '</li></ul>').insertBefore(".total_cost");
                    });
                    if (customer_name == '') {

                    } else {
                        $("#customer-result-name").text(customer_name);
                        $("#customer-selected-id").val(customer_id);
                        $("#customer-result-balance").text(customer_balance);
                        $("#customer-selected-group-id").val(customer_group_id);
                        $(".customer-search-result").children("dl").show();
                    }
                });
            }
            showCurrentsale();
        } else {
            var targetSale = $(this);
            $(".added-null").hide();
            var retCount = 0;
            $("#retrieve_sale_id").val($(this).attr("data-id"));
            $(this).find(".retrieve-child-products").each(function () {
                var appendString = '';
                appendString += '<tr class="order-product">';
                appendString += '<input type="hidden" class="added-code" value="' + $(this).children(".retrieve-child-id").text() + '">';
                appendString += '<input type="hidden" class="added-name" value="' + $(this).children(".retrieve-child-name").text() + '">';
                appendString += '<input type="hidden" class="hidden-retail_price" value="' + $(this).find(".retrieve-child-price").text() + '">';
                appendString += '<input type="hidden" class="hidden-tax" value="' + $(this).find(".retrieve-child-tax").text() + '">';
                appendString += '<input type="hidden" class="hidden-supply_price" value="' + $(this).find(".retrieve-child-supply-price").text() + '">';
                appendString += '<td class="added-product">' + $(this).children(".retrieve-child-name").text();
                appendString += '<br><span class="added-price">$' + parseFloat($(this).children(".retrieve-child-price").text()).toFixed(2) + '</span></td>';
                appendString += '<td class="added-qty"><a qty-id="' + retCount + '" class="qty-control btn btn-white">' + $(this).find(".retrieve-child-qty").text() + '</a></td>';
                appendString += '<td class="added-discount"><a href="#price-control" class="price-control btn btn-white" data-id="' + retCount + '">@';
                appendString += $(this).find(".retrieve-child-price-incl-tax").text() + '</a></td>';
                appendString += '<td class="added-amount"></td><td class="added-remove"><div class="remove clickable"><div class="glyphicon glyphicon-remove"></div></div></td></tr>'; /*COME HERE*/

                $(".added-body").prepend(appendString);
                //$(".added-body").prepend('<tr class="order-product"><input type="hidden" class="added-code" value="'+$(this).children(".retrieve-child-id").text()+'"><input type="hidden" class="hidden-retail_price" value="'+$(this).find(".retrieve-child-price").text()+'"><input type="hidden" class="hidden-tax" value="'+$(this).find(".retrieve-child-tax").text()+'"><input type="hidden" class="hidden-supply_price" value="'+$(this).find(".retrieve-child-supply-price").text()+'"><td class="added-product">'+$(this).children(".retrieve-child-name").text()+'<br><span class="added-price">$'+parseFloat($(this).children(".retrieve-child-price").text()).toFixed(2)+'</span></td><td class="added-qty"><a qty-id="'+retCount+'" class="qty-control btn btn-white">'+$(this).find(".retrieve-child-qty").text()+'</a></td><td class="added-discount"><a href="#price-control" class="price-control btn btn-white" data-id="'+retCount+'">@'+$(this).find(".retrieve-child-price-incl-tax").text()+'</a></td><td class="added-amount"></td><td class="added-remove"><div class="remove clickable"><div class="glyphicon glyphicon-remove"></div></div></td></tr>');/*COME HERE*/
                retCount++;
            });
            targetSale.find(".retrieve-child-payments").each(function () {
                $('<ul class="split_attr"><li>' + $(this).find(".payments-name").val() + '</li><li class="pull-right">$' + $(this).find(".payments-amount").val() + '</li></ul>').insertBefore(".total_cost");
            });
            if (customer_name == '') {

            } else {
                $("#customer-result-name").text(customer_name);
                $("#customer-selected-id").val(customer_id);
                $("#customer-result-balance").text(customer_balance);
                $("#customer-selected-group-id").val(customer_group_id);
                $(".customer-search-result").children("dl").show();
            }
            showCurrentsale();
        }
    });

    function initView(){
        $(".current_open").removeClass("active");
        $(".retrieve_open").removeClass("active");
        $(".close_open").removeClass("active");
        $(".table_open").removeClass("active");
                $(".current_sale").hide();
        $(".recall_sale").hide();
        $(".close_sale").hide();
        $(".booking").hide();
        }

    function showCurrentsale(){
        initView();
        $(".current_open").addClass("active");
        $(".current_sale").show();
    }
});
</script>
<!-- JAVASCRIPT START -->
