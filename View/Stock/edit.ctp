
<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <div id="notify"></div>
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar-wrapper">
        <!-- BEGIN HORIZONTAL RESPONSIVE MENU -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <div class="page-sidebar navbar-collapse collapse">
            <ul class="page-sidebar-menu" data-slide-speed="200" data-auto-scroll="true">
                <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
                <!-- DOC: This is mobile version of the horizontal menu. The desktop version is defined(duplicated) in the header above -->
                <li class="sidebar-search-wrapper">
                    <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                    <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
                    <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
                    <form class="sidebar-search sidebar-search-bordered" action="extra_search.html" method="POST">
                        <a href="javascript:;" class="remove">
                        <i class="icon-close"></i>
                        </a>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                            <button class="btn submit"><i class="icon-magnifier"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- END RESPONSIVE QUICK SEARCH FORM -->
                </li>
                <li>
                    <a href="index">
                    Sell
                    </a>
                </li>
                <li>
                    <a href="history">
                    History </a>
                </li>
                <li class="active">
                    <a href="history">
                    Product <span class="selected">
                    </span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- END HORIZONTAL RESPONSIVE MENU -->
    </div>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">Edit Stock Order</h2>
                <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20">
                    <a href="/stock/<?php echo $data['MerchantStockOrder']['id']; ?>/editDetails"><button id="import" class="btn btn-white pull-right" style="color:black">
                    <div class="glyphicon glyphicon-edit"></div>&nbsp;Edit Order Details</button></a>
                </div>
            </div>
            <div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">Details</div>
            <div class="line-box line-box-content col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-6">
                    <dl>
                        <dt>Order name</dt>
                        <dd>
                            <?php echo $data['MerchantStockOrder']['name']; ?>
                        </dd>
                        <dt>Order from</dt>
                        <dd>
                        <?php if ($data['MerchantStockOrder']['type'] == 'OUTLET') : ?>
                            <?php echo empty($data['MerchantSourceOutlet']['id']) ? 'Any' : $data['MerchantSourceOutlet']['name']; ?>
                        <?php elseif ($data['MerchantStockOrder']['type'] == 'SUPPLIER' ) : ?>
                            <?php echo empty($data['MerchantSupplier']['id']) ? 'Any' : $data['MerchantSupplier']['name']; ?>
                        <?php endif; ?>
                        </dd>
                        <dt>Deliver to</dt>
                        <dd>
                            <?php echo $data['MerchantOutlet']['name']; ?> 
                        </dd>
                    </dl>
                </div>
                <div class="col-md-6">
<!--
                    <dl>
                        <dt>Due at</dt>
                        <dd>
                            <?php echo date('d F Y', strtotime($order['MerchantStockOrder']['due_date'])); ?>
                        </dd>
                        <dt>Supplier invoice</dt>
                        <dd>
                            <?php echo $order['MerchantStockOrder']['supplier_invoice']; ?>
                        </dd>
                    </dl>
-->
                </div>
            </div>
            <div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">Order Products</div>
                <!--<form action="/stock/<?php echo $order['MerchantStockOrder']['id']; ?>/edit" method="post" id="stock_order_item_form">-->
                <form id="stock_order_item_form">
                <?php
                    echo $this->Form->input('MerchantStockOrder.id', array(
                        'id' => 'id',
                        'type' => 'hidden',
                        'div' => false,
                        'label' => false
                    ));
                 ?>
                <div class="line-box line-box-content col-md-12 col-sm-12 col-xs-12 col-alpha col-omega">
                <div class="col-md-12 col-sm-12 col-xs-12 order-product-header col-alpha col-omega">
                    <div class="col-md-7 col-alpha">
                        <input type="text" class="" id="search-items" placeholder="Search Products">
                    </div>
                    <div class="col-md-1 col-alpha">
                        <input type="number" id="quantity" placeholder="1" value="1">
                    </div>
                    <div class="col-md-4 col-alpha">
                        <button type="button" class="btn btn-default add-order-item">Add</button>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <table class="dataTable table-bordered" id="orderItemTable">
                        <colgroup>
                            <col width="10%">
                            <col width="35%">
                            <col width="15%">
                            <col width="10%">
                            <col width="15%">
                            <col width="15%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Product</th>
                                <th>Stock on Hand</th>
                                <th>Quantity</th>
                                <th>Supply Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="order-null">
                                <td colspan="6">There are no products in this consignment order yet.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 pull-right margin-top-20 margin-bottom-20">
                <button class="btn btn-primary save_and_send pull-right">Save and Send</button>
                <button class="btn btn-primary btn-wide pull-right save margin-right-10">Save</button>
                <button class="btn btn-default btn-wide pull-right margin-right-10 cancel">Cancel</button>
            </div>
            </form>
        </div>
    </div>
    <!-- END CONTENT -->
    <div class="hidden-data">
        <input type="hidden" id="hidden-data1" value='<?php echo json_encode($data['MerchantStockOrderItem']); ?>' />
        <input type="hidden" id="hidden-data2" value='<?php echo json_encode($inventories); ?>' />
    </div>
    <!-- Save&Send POPUP BOX -->
    <div class="confirmation-modal modal fade in save_send" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="confirm-close close-pop" data-dismiss="modal" aria-hidden="true">
                    <i class="glyphicon glyphicon-remove"></i>
                    </button>
                    <h4 class="modal-title">Send order</h4>
                </div>
                <form id="confirmation-email-form">
                <input type="hidden" name="data[Email][order_id]" value="<?php echo $data['MerchantStockOrder']['id']; ?>" />
                <div class="modal-body margin-bottom-20">
                    <dl>
                        <dt>Recipient name</dt>
                        <dd>
                            <input type="text" name="data[Email][recipient_name]" id="recipient_name">
                        </dd>
                        <dt>Email</dt>
                        <dd>
                            <input type="text" name="data[Email][email]" id="email">
                        </dd>
                        <dt>CC</dt>
                        <dd>
                            <input type="text" name="data[Email][cc]" id="cc">
                        </dd>
                        <dt>Subject</dt>
                        <dd>
                            <input type="text" name="data[Email][subject]" id="subject">
                        </dd>
                        <dt>Message</dt>
                        <dd>
                            <textarea col="2" name="data[Email][message]" id="message"></textarea>
                        </dd>
                    </dl>
                </div>
                <div class="modal-footer">
                    <button class="close-pop btn btn-primary btn-wide" type="button" data-dismiss="modal">Cancel</button>
                    <button class="send-email btn btn-success btn-wide modal-send" type="button" data-dismiss="modal">Send</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Save&Send POPUP BOX END -->
    <!-- BEGIN QUICK SIDEBAR -->
    <a href="javascript:;" class="page-quick-sidebar-toggler"><i class="icon-close"></i></a>
    <div class="page-quick-sidebar-wrapper">
        <div class="page-quick-sidebar">            
            <div class="nav-justified">
                <ul class="nav nav-tabs nav-justified">
                    <li class="active">
                        <a href="#quick_sidebar_tab_1" data-toggle="tab">
                        Users <span class="badge badge-danger">2</span>
                        </a>
                    </li>
                    <li>
                        <a href="#quick_sidebar_tab_2" data-toggle="tab">
                        Alerts <span class="badge badge-success">7</span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        More<i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <li>
                                <a href="#quick_sidebar_tab_3" data-toggle="tab">
                                <i class="icon-bell"></i> Alerts </a>
                            </li>
                            <li>
                                <a href="#quick_sidebar_tab_3" data-toggle="tab">
                                <i class="icon-info"></i> Notifications </a>
                            </li>
                            <li>
                                <a href="#quick_sidebar_tab_3" data-toggle="tab">
                                <i class="icon-speech"></i> Activities </a>
                            </li>
                            <li class="divider">
                            </li>
                            <li>
                                <a href="#quick_sidebar_tab_3" data-toggle="tab">
                                <i class="icon-settings"></i> Settings </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
<!-- END QUICK SIDEBAR -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="/assets/global/plugins/respond.min.js"></script>
<script src="/assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="/assets/global/plugins/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
<script src="/assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
<!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
<script src="/assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/gritter/js/jquery.gritter.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="/assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="/assets/admin/pages/scripts/index.js" type="text/javascript"></script>
<script src="/assets/admin/pages/scripts/tasks.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script src="/js/dataTable.js" type="text/javascript"></script>
<script>
var orderItems = JSON.parse($("#hidden-data1").val());
var inventories = JSON.parse($("#hidden-data2").val());
var selectedProduct = null;

jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    QuickSidebar.init() // init quick sidebar
    Index.init();

    updateView();

    $(".datepicker").datepicker({ dateFormat: 'yy-mm-dd' });

    $(".add-order-item").click(function(e) {
        if (selectedProduct == null) {
            return;
        }

        addOrderItem($("#id").val(), selectedProduct['id'], selectedProduct['name'], parseInt($("#quantity").val()), selectedProduct['supply_price'], selectedProduct['price_include_tax']);
    });

    $("#search-items").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "/stock/searchProduct.json",
                method: "POST",
                dataType: "json",
                data: {
                    keyword: request.term
                },
                success: function (data) {
                    selectedProduct = null;
                    if (!data.success)
                        return;

                    response($.map(data.products, function (item) {
                        return ({
                            label: item.name,
                            handle: item.handle,
                            sku: item.sku,
                            data: item
                        });
                    }));
                }
            });
        },
        minLength: 2,
        select: function( event, ui ) {
            selectedProduct = ui.item.data;

            $(this).val(ui.item.sku);
            return false;
        }
    });

    $(".count").on('change', function(e) {
        var orderItemId = $(this).closest('tr').data('id');
        var count = $(this).val();
        var supply_price = $("#order_item_" + orderItemId + "_supply_price").val();
        var total_cost = parseFloat(supply_price * count).toFixed(2);

        $(this).closest('tr').find('.calculated-total').text(total_cost);
        $(this).val(parseInt(count));
    });

    $(".cost").on('change', function(e) {
        var orderItemId = $(this).closest('tr').data('id');
        var count = $("#order_item_" + orderItemId + "_count").val();
        var supply_price = $(this).val();
        var total_cost = parseFloat(supply_price * count).toFixed(2);

        $(this).closest('tr').find('.calculated-total').text(total_cost);
        $(this).val(parseFloat(supply_price).toFixed(2));
    });

    // 'cancel' button click ...
    $(".cancel").click(function(e) {
        parent.history.back();
    });

    // 'save' button click ...
    $(".save").click(function(e) {
        var order_id = $("#id").val();

        $.ajax({
            url: "/stock/saveItems.json",
            method: "POST",
            data: $('#stock_order_item_form').serialize(),
            error: function( jqXHR, textStatus, errorThrown ) {
            },
            success: function( data ) {
                if (data.success) {
                    location.href = "/stock/" + order_id;
                } else {
                    alert(data.message);
                }
            }
        });
        return false;
    });

    // 'save and send' button click ...
    $(".save_and_send").click(function(e) {
        $.ajax({
            url: "/stock/saveItems.json",
            method: "POST",
            data: $('#stock_order_item_form').serialize(),
            error: function( jqXHR, textStatus, errorThrown ) {
            },
            success: function( data ) {
                if (data.success) {
                    $('.save_send').show();
                } else {
                    alert(data.message);
                }
            }
        });
        return false;
    });

    // modal ...
    // 'close-pop' button click ...
    $(".close-pop").click(function() {
        $(".confirmation-modal").hide();
    });

    // 'send-email' button click ...
    $(".send-email").click(function(e) {
        var order_id = $("#id").val();
        var recipient_name = $("#recipient_name").val();
        var email = $("#email").val();
        var cc = $("#cc").val();
        var subject = $("#subject").val();
        var message = $("#message").val();

        if (email == '') {
            return;
        }

        if (subject == '') {
            return;
        }

        if (message == '') {
            return;
        }

        $.ajax({
            url: "/stock/send.json",
            method: "POST",
            data: $('#confirmation-email-form').serialize(),
            error: function( jqXHR, textStatus, errorThrown ) {
            },
            success: function( data ) {
                if (data.success) {
                    window.location.href = "/stock/" + order_id;
                } else {
                    $('.save_send').hide();
                    alert(data.message);
                }
            }
        });
        return false;
    });
});

function addOrderItem(order_id, product_id, name, count, supply_price, price_include_tax) {
    for (var idx in orderItems) {
        if (orderItems[idx]['product_id'] == product_id) {
            return;
        }
    }

    var orderItem = {
        order_id: order_id,
        product_id: product_id,
        name: name,
        count: count,
        supply_price: supply_price,
        total_cost: supply_price * count,
        price_include_tax: price_include_tax,
        total_price_incl_tax: price_include_tax * count
    };

    $.ajax({
        url: "/stock/saveItem.json",
        method: "POST",
        data: {
            MerchantStockOrderItem: orderItem
        },
        error: function( jqXHR, textStatus, errorThrown ) {
        },
        success: function( data ) {
            if (data.success) {
                orderItem.id = data.id;
                orderItems.push(orderItem);
                updateView();
            } else {
                alert(data.message);
            }
        }
    });
}

function updateView() {
    $("body").find(".hidden-data").remove();
    $("#orderItemTable").find('tbody').empty();

    if (orderItems.length == 0) {
        var appendString = '<tr class="order-null">';
        appendString += '<td colspan="6">There are no products in this consignment order yet.</td>';
        appendString += '</tr>';
        $("#orderItemTable").find('tbody').append(appendString);
    } else {
        for (var idx in orderItems) {
            var index = parseInt(idx) + 1;
            var order_item_id = orderItems[idx]['id'];
            var order_id = orderItems[idx]['order_id'];
            var product_id = orderItems[idx]['product_id'];
            var name = orderItems[idx]['name'];
            var inventory = inventories[orderItems[idx]['product_id']];
            var stock_on_hand = ((inventory == null || inventory == '') ? '<i class="icon-general-infinity"></i>' : inventory['count']);
            var count = orderItems[idx]['count'];
            var supply_price = parseFloat(orderItems[idx]['supply_price']).toFixed(2);
            var price_include_tax = parseFloat(orderItems[idx]['price_include_tax']).toFixed(2);
            var total_cost = parseFloat(orderItems[idx]['total_cost']).toFixed(2);
            var total_price_incl_tax = parseFloat(orderItems[idx]['total_price_incl_tax']).toFixed(2);

            var appendString = '<tr data-id="' + order_item_id + '">'
            appendString +=  '<input type="hidden" name="data[MerchantStockOrderItem][' + idx + '][id]" id="order_item_' + order_item_id + '_id" value="' + order_item_id +'" />';
            appendString +=  '<input type="hidden" name="data[MerchantStockOrderItem][' + idx + '][price_include_tax]" id="order_item_' + order_item_id + '_price_include_tax" value="' + price_include_tax +'" />';
/*
            appendString +=  '<input type="hidden" name="data[MerchantStockOrderItem][' + idx + '][total_cost]" id="order_item_' + order_item_id + '_total_cost" value="' + total_cost +'" />';
            appendString +=  '<input type="hidden" name="data[MerchantStockOrderItem][' + idx + '][total_price_incl_tax]" id="order_item_' + order_item_id + '_total_price_incl_tax" value="' + total_price_incl_tax +'" />';
*/
            appendString += '<td>' + index + '</td>';
            appendString += '<td>' + name + '</td>';
            appendString += '<td>' + stock_on_hand + '</td>';
            appendString += '<td><input type="text" class="count changable" name="data[MerchantStockOrderItem][' + idx + '][count]" id="order_item_' + order_item_id + '_count" value="' + count +'" /></td>';
            appendString += '<td><input type="text" class="cost changable" name="data[MerchantStockOrderItem][' + idx + '][supply_price]" id="order_item_' + order_item_id + '_supply_price" value="' + supply_price +'" /></td>';
            appendString += '<td><strong class="calculated-total font-xl">' + total_cost + '</strong></td>';
            appendString += '</tr>';
            $("#orderItemTable").find('tbody').append(appendString);
        }
    }
}
</script>
<!-- END JAVASCRIPTS -->
