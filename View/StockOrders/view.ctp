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
<!-- BEGIN CONTAINER -->
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
                <h2 class="pull-left col-md-6 col-xs-6 col-sm-6 col-alpha col-omega">
                    <?php echo $order_name . ' (' . $order_status_name . ')'; ?>
                </h2>
                <div class="pull-right col-md-6 col-xs-6 col-sm-6 col-alpha col-omega margin-top-20">
                    <button class="btn btn-white pull-right btn-right">
                        <div class="glyphicon glyphicon-export"></div>&nbsp;
                        Export CSV
                    </button>
                <?php if (in_array($order_status, array('stock_order_status_open'))) : ?>
                    <button class="btn btn-white pull-right btn-right">
                        <div class="glyphicon glyphicon-import"></div>&nbsp;
                        Import CSV
                    </button>
                <?php endif; ?>
                <?php if (!in_array($order_status, array('stock_order_status_cancelled', 'stock_order_status_closed', 'stock_order_status_rejected'))) : ?>
                    <a href="/stock_orders/<?php echo $order_id; ?>/editDetails" class="btn btn-white pull-right btn-center">
                        <div class="glyphicon glyphicon-edit"></div>&nbsp;
                        Edit Details
                    </a>
                <?php endif; ?>
                <?php if (in_array($order_status, array('stock_order_status_open'))) : ?>
                    <a href="/stock_orders/<?php echo $order_id; ?>/edit" class="btn btn-white pull-right btn-left">
                        <div class="glyphicon glyphicon-edit"></div>&nbsp;
                        Edit Products
                    </a>
                <?php endif; ?>
                </div>
            </div>
            <div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">Details
            <?php if (in_array($order_status, array('stock_order_status_open'))) : ?>
                <span class="clickable same_as_physical pull-right btn btn-default btn-right mark_as_sent">
                    <a href="/stock_orders/<?php echo $order_id; ?>/markSent">Mark as sent</a>
                </span>
            <?php endif; ?>
            <?php if (in_array($order_status, array('stock_order_status_sent', 'stock_order_status_approved', 'stock_order_status_shipped'))) : ?>
                <span class="clickable same_as_physical pull-right btn btn-default btn-right resend">
                    <a href="/stock_orders/<?php echo $order_id; ?>/send" data-toggle="modal" data-target="#sendModal">Resend</a>
                </span>
            <?php endif; ?>
            <?php if (!in_array($order_status, array('stock_order_status_cancelled', 'stock_order_status_rejected'))) : ?>
                <span class="clickable same_as_physical pull-right btn btn-default btn-left">
                    <a href="/stock_orders/<?php echo $order_id; ?>/barcodes" target="_blank">Print labels</a>
                </span>
            <?php endif; ?>
            </div>
            <div class="line-box line-box-content col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-6 margin-bottom-20">
                    <dl>
                        <dt>Deliver to</dt>
                        <dd><?php echo $outlet_name; ?></dd>
                    </dl>
                </div>
                <div class="col-md-6 margin-bottom-20">
                    <dl>
                        <dt>Created</dt>
                        <dd><?php echo date('d F Y', strtotime($order_date)); ?></dd>
                    </dl>
                <?php if (in_array($order_status, array('stock_order_status_received', 'stock_order_status_closed'))) : ?>
                    <dl>
                        <dt>Received</dt>
                        <dd><?php echo date('d F Y', strtotime($order_date)); ?></dd>
                    </dl>
                <?php endif; ?>
                </div>
                <div class="col-md-3 col-omega">
                    <table class="table-bordered dataTable">
                        <colgroup>
                            <col width="20%">
                            <col width="">
                        </colgroup>
                        <thead>
                        <tr>
                            <th>Order</th>
                            <th class="no-radius">Product</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($stock_order_items as $idx => $item) : ?>
                            <tr>
                                <td><?php echo $idx+1; ?></td>
                                <td>
                                    <!--<span class="text-limit"><?php echo $item['name']; ?></span>-->
                                    <a href="/product/<?php echo $item['product_id']; ?>"><?php echo $item['name']; ?></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                            <tr class="table-result">
                                <td><strong>Total</strong></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-9 col-alpha">
                    <div class="scroll-table">
                        <table class="table-bordered dataTable">
                            <colgroup>
                                <col width="10%">
                                <col width="10%">
                                <col width="10%">
                                <col width="10%">
                                <col width="10%">
                                <col width="10%">
                                <col width="10%">
                                <col width="10%">
                                <col width="">
                            </colgroup>
                            <thead>
                            <tr>
                                <th>SKU</th>
                                <th>Supplier code</th>
                                <th>Stock</th>
                                <th>Ordered</th>
                                <th>Received</th>
                                <th>Supply Cost</th>
                                <th>Total Supply Cost</th>
                                <th>Retail Price</th>
                                <th class="last-child">Total Retail Price</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $totalOrdered = 0;
                                    $totalReceived = 0;
                                    $totalCost = 0.0;
                                    $totalPrice = 0.0;
    
                                    foreach ($stock_order_items as $item) :
                                        $totalOrdered += $item['quantity'];
                                        $totalReceived += $item['received'];

                                        if (in_array($order_status, array('stock_order_status_received', 'stock_order_status_closed'))) {
                                            $totalSupplyCost = round($item['received'] * $item['supply_price'], 2);
                                            $totalRetailPrice = round($item['received'] * $item['price_include_tax'], 2);
                                        } else {
                                            $totalSupplyCost = round($item['quantity'] * $item['supply_price'], 2);
                                            $totalRetailPrice = round($item['quantity'] * $item['price_include_tax'], 2);
                                        }
                                        $totalCost += $totalSupplyCost;
                                        $totalPrice += $totalSupplyCost;
                                ?>
                                <tr>
                                    <td><span class="text-limit"><?php echo $item['sku']; ?></span></td>
                                    <td><?php echo $item['supplier_code']; ?></td>
                                    <td>
                                        <?php echo isset($item['in_stock']) ? $item['in_stock'] : '<i class="icon-general-infinity"></i>'; ?>
                                    </td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td><?php echo is_null($item['received']) ? '0' : $item['received']; ?></td>
                                    <td><?php echo sprintf("%.2f", $item['supply_price']); ?></td>
                                    <td><?php echo sprintf("%.2f", $totalSupplyCost); ?></td>
                                    <td><?php echo sprintf("%.2f", $item['price_include_tax']); ?></td>
                                    <td><?php echo sprintf("%.2f", $totalRetailPrice); ?></td>
                                </tr>
                                <?php
                                    endforeach;
                                ?>
                                <tr class="table-result">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><?php echo $totalOrdered; ?></td>
                                    <td><?php echo $totalReceived; ?></td>
                                    <td></td>
                                    <td><?php echo sprintf("%.2f", $totalCost); ?></td>
                                    <td></td>
                                    <td><?php echo sprintf("%.2f", $totalPrice); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 pull-right margin-top-20 margin-bottom-20">
                <?php if (in_array($order_status, array('stock_order_status_open'))) : ?>
                    <a href="/stock_orders/<?php echo $order_id; ?>/send" class="btn btn-primary btn-wide pull-right send" data-toggle="modal" data-target="#sendModal">Send</a>
                <?php endif; ?>
                <?php if (in_array($order_status, array('stock_order_status_sent', 'stock_order_status_approved', 'stock_order_status_shipped'))) : ?>
                    <a href="/stock_orders/<?php echo $order_id; ?>/receive" class="btn btn-primary btn-wide pull-right">Receive</a>
                <?php endif; ?>
                <?php if (!in_array($order_status, array('stock_order_status_cancelled', 'stock_order_status_closed', 'stock_order_status_rejected'))) : ?>
                    <a href="/stock_orders/<?php echo $order_id; ?>/cancel" class="btn btn-default pull-left margin-right-10" data-toggle="modal" data-target="#cancelModal">Cancel Order</a>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
    <!-- BEGIN POPUP BOX -->
    <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <div class="modal fade" id="sendModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
            </div>
        </div>
    </div>
    <!-- END POPUP BOX -->
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
jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    Index.init();

<?php if ($send == 1) : ?>
    if (history && history.replaceState) {
        history.replaceState(null, null, '/stock_takes/<?php echo $order_id; ?>');
    }
    $(".send").click();
<?php endif; ?>
});
</script>
<!-- END JAVASCRIPTS -->

