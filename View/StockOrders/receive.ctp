<?php
    $order_id = '';
    $order_name = '';
    $order_type = '';
    $order_date = '';
    $order_status = '';
    $order_status_name = '';
    $received_date = '';
    $outlet_id = '';
    $supplier_name = '';
    $source_outlet_name = '';
    $outlet_name = '';
    $stock_order_items = null;

    if ($data) {
        $order_id = $data['MerchantStockOrder']['id'];
        $order_name = $data['MerchantStockOrder']['name'];
        $order_type = $data['MerchantStockOrder']['order_type_id'];
        $order_date = $data['MerchantStockOrder']['date'];
        $order_status = $data['MerchantStockOrder']['order_status_id'];
        $order_status_name = $data['StockOrderStatus']['name'];
        $received_date = $data['MerchantStockOrder']['received'];

        $outlet_id = $data['MerchantStockOrder']['outlet_id'];
        if (!empty($outlet_id)) {
            $outlet_name = $data['MerchantOutlet']['name'];
        }

        $source_outlet_id = $data['MerchantStockOrder']['source_outlet_id'];
        if (!empty($source_outlet_id)) {
            $source_outlet_name = $data['MerchantSourceOutlet']['name'];
        }

        $supplier_id = $data['MerchantStockOrder']['supplier_id'];
        if (!empty($supplier_id)) {
            $supplier_name = $data['MerchantSupplier']['name'];
        }

        $stock_order_items = $data['MerchantStockOrderItem'];
    }
 ?>
<div class="clearfix"></div>
<div class="container">
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
                <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">Receive Stock Order</h2>
                <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20">
                    <a href="/stock_orders/<?php echo $order_id; ?>/editDetails"><button id="import" class="btn btn-white pull-right" style="color:black">
                    <div class="glyphicon glyphicon-edit"></div>&nbsp;Edit Order Details</button></a>
                </div>
            </div>
            <div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">Details</div>
            <div class="line-box line-box-content col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-6">
                    <dl>
                        <dt>Order name</dt>
                        <dd>
                            <?php echo $order_name; ?>
                        </dd>
                        <dt>Order from</dt>
                        <dd>
                        <?php if ('stock_order_type_stockorder' === $order_type) : ?>
                            <?php echo $supplier_name; ?>
                        <?php elseif ('stock_order_type_transfer' === $order_type) : ?>
                            <?php echo $source_outlet_name; ?>
                        <?php endif; ?>
                        </dd>
                        <dt>Deliver to</dt>
                        <dd>
                            <?php echo $outlet_name; ?>
                        </dd>
                    </dl>
                </div>
                <div class="col-md-6">
                </div>
            </div>
            <div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">Order Products</div>
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
                <form action="/stock_orders/<?php echo $order_id; ?>/receive" method="post" id="stock_order_item_form">
                <?php
                    echo $this->Form->input('MerchantStockOrder.id', array(
                        'id' => 'id',
                        'type' => 'hidden'
                    ));

                    echo $this->Form->input('save-send', array(
                        'id' => 'save-send',
                        'type' => 'hidden',
                        'value' => 0
                    ));

                    echo $this->Form->input('save-receive', array(
                        'id' => 'save-receive',
                        'type' => 'hidden',
                        'value' => 0
                    ));
                 ?>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <table class="dataTable table-bordered stock_order_list">
                        <colgroup>
                            <col width="100">
                            <col>
                            <col width="120">
                            <col width="100">
                            <col width="100">
                            <col width="110">
                            <col width="110">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Product</th>
                                <th class="text-right">Stock on Hand</th>
                                <th class="text-right">Quantity</th>
                                <th>Received</th>
                                <th>Supply Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $totalCost = 0.0;

                            if (!empty($stock_order_items) && is_array($stock_order_items)) :
                                foreach ($stock_order_items as $idx => $item) :
                         ?>
                            <tr data-id="<?php echo $item['id']; ?>" data-group-id="<?php echo $item['id']; ?>">
                                <?php
                                    echo $this->Form->input('items.' . $idx . '.MerchantStockOrderItem.id', array(
                                        'id' => 'order_item_' . $item['id']. '_id',
                                        'type' => 'hidden',
                                        'value' => $item['id']
                                    ));

                                    $totalSupplyCost = round($item['quantity'] * $item['supply_price'], 2);
                                    $totalCost += $totalSupplyCost;
                                 ?>
                                <td><?php echo $item['sequence']; ?></td>
                                <td><?php echo $item['name']; ?></td>
                                <td class="text-right"><?php echo $item['in_stock']; ?></td>
                                <td class="text-right"><?php echo $item['quantity']; ?></td>
                                <td>
                                    <?php
                                        echo $this->Form->input('items.' . $idx . '.MerchantStockOrderItem.received', array(
                                            'id' => 'order_item_' . $item['id'] . '_received',
                                            'type' => 'text',
                                            'class' => 'text-right changable quantity',
                                            'div' => false,
                                            'label' => false,
                                            'value' => empty($item['received']) ? $item['quantity'] : $item['received']
                                        ));
                                     ?>
                                </td>
                                <td>
                                    <?php
                                        echo $this->Form->input('items.' . $idx . '.MerchantStockOrderItem.supply_price', array(
                                            'id' => 'order_item_' . $item['id'] . '_supply_price',
                                            'type' => 'text',
                                            'class' => 'text-right changable supply_price',
                                            'div' => false,
                                            'label' => false,
                                            'value' => sprintf("%.2f", $item['supply_price'])
                                        ));
                                     ?>
                                </td>
                                <td class="text-right">
                                    <strong class="calculated-total font-xl"><?php echo sprintf("%.2f", $totalSupplyCost); ?></strong>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr class="order-null">
                                <td colspan="6">There are no products in this consignment order yet.</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
<!--
                        <tfoot>
                            <tr>
                                <td colspan="7" class="strong total currency">
                                    TOTAL
                                    <span class="spaced" id="grand-total"><?php echo $totalCost; ?></span>
                                </td>
                            </tr>
                        </tfoot>
-->
                    </table>
                </div>
                </form>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 pull-right margin-top-20 margin-bottom-20">
            <?php if (in_array($order_status, array('stock_order_status_open'))) : ?>
                <button type="submit" class="btn btn-primary pull-right save_and_send">Save and Send</button>
            <?php endif; ?>
            <?php if (in_array($order_status, array('stock_order_status_sent', 'stock_order_status_approved', 'stock_order_status_shipped'))) : ?>
                <button type="submit" class="btn btn-primary pull-right save_and_receive">Save and Receive</button>
            <?php endif; ?>
                <button type="submit" class="btn btn-primary btn-wide pull-right margin-right-10 save">Save</button>
                <a href="/stock_orders/<?php echo $order_id; ?>" class="btn btn-default btn-wide pull-right margin-right-10 cancel">Cancel</a>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
    <div class="hidden-data">
        <input type="hidden" id="hidden-data1" value='<?php echo json_encode($stock_order_items); ?>' />
    </div>
</div>
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="/theme/onzsa/assets/global/plugins/respond.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="/theme/onzsa/assets/global/plugins/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="/theme/onzsa/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
<!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
<script src="/theme/onzsa/assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/gritter/js/jquery.gritter.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/theme/onzsa/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/admin/pages/scripts/index.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/admin/pages/scripts/tasks.js" type="text/javascript"></script>
<script src="/js/dataTable.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
var orderItems = JSON.parse($("#hidden-data1").val());
var product = null;

jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    Index.init();

    $("body").find(".hidden-data").remove();

    $("#search-items").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "/stock_orders/search.json",
                method: "POST",
                dataType: "json",
                data: {
                    keyword: request.term,
                    outlet_id: '<?php echo $outlet_id; ?>'
                },
                success: function (data) {
                    product = null;
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
            product = ui.item.data;
            $(this).val(ui.item.sku);
            return false;
        },
        open: function( event, ui ) {
            $("ul").last().attr({class:"ui-autocomplete ui-front ui-menu ui-widget-1 ui-widget-content-1 ui-corner-all"});
        }
    });

    $(".add-order-item").click(function(e) {
        if (product == null) {
            return;
        }

        addProduct(product['id'], parseFloat($("#quantity").val()), product['name'], product['product_uom'],
            product['supply_price'], product['stock_type'], product['subitems'], product['in_stock']);

        $("#quantity").val('1');
        $("#search-items").val('');
        product = null;
    });

    $("#stock_order_item_form").on("click", ".js-delete", function(e) {
        $.ajax({
            url: $(this).attr('href') + '.json',
            method: "GET",
            error: function( jqXHR, textStatus, errorThrown ) {
                console.log(errorThrown);
            },
            success: function( data ) {
                if (data.success) {
                    for (var idx in orderItems) {
                        if (orderItems[idx]['id'] == data.id) {
                            orderItems.splice(idx, 1);
                            break;
                        }
                    }
                    updateView();
                } else {
                    alert(data.message);
                }
            }
        });
        return false;
    });

    $(".save").click(function(e) {
        $("#stock_order_item_form").submit();
    });

    $(".save_and_receive").click(function(e) {
        $("#save-receive").val(1);
        $("#stock_order_item_form").submit();
    });

    $(".save_and_send").click(function(e) {
        $("#save-send").val(1);
        $("#stock_order_item_form").submit();
    });
});

function addProduct(product_id, quantity, name, product_uom, supply_price, stock_type, subitems, in_stock) {
    var stockOrderItem = null;
    var sequence = 0;

    for (var idx in orderItems) {
        if (orderItems[idx]['product_id'] == product_id && orderItems[idx]['supply_price'] == supply_price) {
            orderItems[idx]['quantity'] = parseFloat(orderItems[idx]['quantity']) + quantity;
            stockOrderItem = orderItems[idx];
            break;
        }
        sequence = orderItems[idx]['sequence'];
    }

    if (stockOrderItem == null) {
        stockOrderItem = {};
        stockOrderItem['order_id'] = $("#id").val();
        stockOrderItem['product_id'] = product_id;
        stockOrderItem['name'] = name;
        stockOrderItem['product_uom'] = product_uom;
        stockOrderItem['supply_price'] = supply_price;
        stockOrderItem['quantity'] = quantity;
        stockOrderItem['in_stock'] = in_stock;
        stockOrderItem['subitems'] = subitems;
        stockOrderItem['sequence'] = ++sequence;
    }
    console.log(stockOrderItem);

    $.ajax({
        url: "/stock_orders/<?php echo $order_id; ?>/addProduct.json",
        method: "POST",
        data: {
            MerchantStockOrderItem: stockOrderItem
        },
        error: function( jqXHR, textStatus, errorThrown ) {
            console.log(errorThrown);
        },
        success: function( data ) {
            if (data.success) {
                if (stockOrderItem.id != data.id) {
                    stockOrderItem.id = data.id;
                    orderItems.push(stockOrderItem);
                }
                updateView();
            } else {
                alert(data.message);
            }
        }
    });
}

function updateView() {
    var tbody = $(".stock_order_list").find("tbody");
    tbody.empty();

    if (orderItems.length == 0) {
        var appendString = '<tr class="order-null">';
        appendString += '<td colspan="6">There are no products in this consignment order yet.</td>';
        appendString += '</tr>';
        tbody.append(appendString);
    } else {
        for (var idx in orderItems) {
            var order_item_id = orderItems[idx]['id'];
            var order_id = orderItems[idx]['order_id'];
            var product_id = orderItems[idx]['product_id'];
            var name = orderItems[idx]['name'];
            var in_stock = orderItems[idx]['in_stock'];
            var stock_on_hand = ((in_stock == null || in_stock == '') ? '&infin;' : in_stock);
            var quantity = orderItems[idx]['quantity'];
            var received = (orderItems[idx]['received'] == null ? orderItems[idx]['quantity'] : orderItems[idx]['received']);
            var supply_price = parseFloat(orderItems[idx]['supply_price']).toFixed(2);
            var total_cost = parseFloat(quantity * supply_price).toFixed(2);
            var sequence = orderItems[idx]['sequence'];
            var subitems = orderItems[idx]['subitems'];

            appendTableRow(idx, sequence, order_item_id, order_id, name, stock_on_hand, quantity, received, supply_price, total_cost);
        }
    }
}

function appendTableRow(idx, sequence, order_item_id, order_id, name, stock_on_hand, quantity, received, supply_price, total_cost) {
    var appendString = '<tr data-id="' + order_item_id + '" data-group-id="' + order_item_id + '">';
    appendString += '<input type="hidden" name="data[' + idx + '][MerchantStockOrderItem][id]" id="order_item_' + order_item_id + '_id" value="' + order_item_id +'" />';
    appendString += '<td>' + sequence + '</td>';
    appendString += '<td>' + name + '</td>';
    appendString += '<td class="text-right">' + stock_on_hand + '</td>';
    appendString += '<td class="text-right">' + quantity + '</td>';
    appendString += '<td><input type="text" class="text-right changable quantity" name="data[' + idx + '][MerchantStockOrderItem][received]" id="order_item_' + order_item_id + '_quantity" value="' + received + '" /></td>';
    appendString += '<td><input type="text" class="text-right changable supply_price" name="data[' + idx + '][MerchantStockOrderItem][supply_price]" id="order_item_' + order_item_id + '_supply_price" value="' + supply_price + '" /></td>';
    appendString += '<td class="text-right"><strong class="calculated-total font-xl">' + total_cost + '</strong>';
    appendString += '</tr>';
    $(".stock_order_list").find('tbody').append(appendString);
}
</script>
<!-- END JAVASCRIPTS -->
