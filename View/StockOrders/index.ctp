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
            <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega margin-bottom-20">
                <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
                    Stock Control
                </h2>
                <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20">
                    <a href="/stock_takes">
                        <button id="import" class="btn btn-white pull-right btn-right" style="color:black">
                            <div class="glyphicon glyphicon-stats"></div>&nbsp;
                        Inventory Count</button>
                    </a>
                    <a href="/stock_orders/newTransfer">
                        <button id="" class="btn btn-white pull-right btn-center" style="color:black">
                            <div class="glyphicon glyphicon-sort"></div>&nbsp;
                        Transfer Stock</button>
                    </a>
                    <a href="/stock_orders/newOrder">
                        <button class="btn btn-white pull-right btn-left">
                            <div class="glyphicon glyphicon-list-alt"></div>&nbsp;
                        Order Stock</button>
                    </a>
                </div>
            </div>
            <!-- FILTER -->
            <form action="/stock_orders" method="get">
            <div class="col-md-12 col-xs-12 col-sm-12 line-box filter-box">
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <dl>
                        <dt>Show</dt> 
                        <dd>
                            <?php
                                echo $this->Form->input('status', array(
                                    'name' => 'status',
                                    'type' => 'select',
                                    'div' => false,
                                    'label' => false,
                                    'selected' => $status,
                                    'options' => $filters
                                ));
                            ?>
                        </dd>
                        <dt>Date from</dt>
                        <dd>
                            <span class="glyphicon glyphicon-calendar icon-calendar"></span>
                            <?php
                                echo $this->Form->input('date_from', array(
                                    'name' => 'date_from',
                                    'type' => 'text',
                                    'class' => 'datepicker',
                                    'div' => false,
                                    'label' => false,
                                    'value' => $date_from
                                ));
                             ?>
                        </dd>
                        <dt>Due date from</dt>
                        <dd>
                            <span class="glyphicon glyphicon-calendar icon-calendar"></span>
                            <?php
                                echo $this->Form->input('due_date_from', array(
                                    'name' => 'due_date_from',
                                    'type' => 'text',
                                    'class' => 'datepicker',
                                    'div' => false,
                                    'label' => false,
                                    'value' => $due_date_from
                                ));
                             ?>
                        </dd>
                    </dl> 
                </div>
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <dl>
                        <dt>Name / Has product</dt>
                        <dd>
                            <?php
                                echo $this->Form->input('name', array(
                                    'name' => 'name',
                                    'type' => 'text',
                                    'div' => false,
                                    'label' => false,
                                    'value' => $name
                                ));
                             ?>
                        </dd>
                        <dt>Date to</dt>
                        <dd>
                            <span class="glyphicon glyphicon-calendar icon-calendar"></span>
                            <?php
                                echo $this->Form->input('date_to', array(
                                    'name' => 'date_to',
                                    'type' => 'text',
                                    'class' => 'datepicker',
                                    'div' => false,
                                    'label' => false,
                                    'value' => $date_to
                                ));
                             ?>
                        </dd>
                        <dt>Due date to</dt>
                        <dd>
                            <span class="glyphicon glyphicon-calendar icon-calendar"></span>
                            <?php
                                echo $this->Form->input('due_date_to', array(
                                    'name' => 'due_date_to',
                                    'type' => 'text',
                                    'class' => 'datepicker',
                                    'div' => false,
                                    'label' => false,
                                    'value' => $due_date_to
                                ));
                             ?>
                        </dd>
                    </dl>
                 </div>
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <dl>
                        <dt>Supplier invoice</dt>
                        <dd>
                            <?php
                                echo $this->Form->input('supplier_invoice', array(
                                    'name' => 'supplier_invoice',
                                    'type' => 'text',
                                    'div' => false,
                                    'label' => false,
                                    'value' => $supplier_invoice
                                ));
                             ?>
                        </dd>
                        <dt>Outlet</dt>
                        <dd>
                            <?php
                                echo $this->Form->input('outlet_id', array(
                                    'name' => 'outlet_id',
                                    'type' => 'select',
                                    'div' => false,
                                    'label' => false,
                                    'selected' => $outlet_id,
                                    'options' => $outlets,
                                    'empty' => ''
                                ));
                            ?>
                        </dd>
                        <dt>Supplier</dt>
                        <dd>
                            <?php
                                echo $this->Form->input('supplier_id', array(
                                    'name' => 'supplier_id',
                                    'type' => 'select',
                                    'div' => false,
                                    'label' => false,
                                    'selected' => $supplier_id,
                                    'options' => $suppliers,
                                    'empty' => ''
                                ));
                            ?>
                        </dd>
                    </dl>
                 </div>
                 <div class="col-md-12 col-xs-12 col-sm-12">
                     <button id="apply_filter" class="btn btn-primary filter pull-right">Update</button>
                 </div>
            </div>
            </form>
            <table id="stockTable" class="table-bordered">
                <colgroup>
                    <col width="15%">
                    <col width="15%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                    <col width="7%">
                    <col width="7%">
                    <col width="">
                </colgroup>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>date</th>
                    <th>Due at</th>
                    <th>Outlet</th>
                    <th>Source</th>
                    <th>Item</th>
                    <th>Status</th>
                    <th class="last-child"></th>
                </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($orders as $order) :
                            $orderType = $order['MerchantStockOrder']['order_type_id'];
                            $orderStatus = $order['MerchantStockOrder']['order_status_id'];
                            $sourceName = '';
                            $orderItemQuantity = 0;

                            if ($orderType === 'stock_order_type_stockorder') {
                                $orderType = 'Supplier order';
                                $sourceName = $order['MerchantSupplier']['name'];
                            } elseif ($orderType === 'stock_order_type_transfer') {
                                $orderType = 'Outlet transfer';
                                $sourceName = $order['MerchantSourceOutlet']['name'];
                            }

                            if (empty($sourceName)) {
                                $sourceName = 'No Name';
                            }

                            if (!empty($order['MerchantStockOrder']['order_item_quantity'])) {
                                $orderItemQuantity = $order['MerchantStockOrder']['order_item_quantity'];
                            }
                     ?>
                    <tr>
                        <td><?php echo $order['MerchantStockOrder']['name']; ?></td>
                        <td><?php echo $orderType; ?></td>
                        <td>
                            <?php
                                echo is_null($order['MerchantStockOrder']['date'])
                                    ? ''
                                    : date('d M Y', strtotime($order['MerchantStockOrder']['date']));
                            ?>
                        </td>
                        <td>
                            <?php
                                echo is_null($order['MerchantStockOrder']['due_date'])
                                    ? ''
                                    : date('d M Y', strtotime($order['MerchantStockOrder']['due_date']));
                            ?>
                        </td>
                        <td><?php echo $order['MerchantOutlet']['name']; ?></td>
                        <td><?php echo $sourceName; ?></td>
                        <td><?php echo $orderItemQuantity; ?></td>
                        <td><?php echo $order['StockOrderStatus']['name']; ?></td>
                        <td>
                            <a href="/stock_orders/<?php echo $order['MerchantStockOrder']['id']; ?>">View</a>
                            <?php if ($orderStatus === 'stock_order_status_open') : ?>
                            | <a href="/stock_orders/<?php echo $order['MerchantStockOrder']['id']; ?>/edit">Edit</a> 
                            <?php elseif (in_array($orderStatus, array('stock_order_status_sent', 'stock_order_status_approved', 'stock_order_status_shipped'))) : ?>
                            | <a href="/stock_orders/receive/<?php echo $order['MerchantStockOrder']['id']; ?>">Receive</a> 
                            <?php endif; ?>
                        </td>
                    </tr>                
                    <?php
                        endforeach;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- END CONTENT -->
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
    
    $("#stockTable").DataTable({
       searching: false
    });
    $("#stockTable_length").hide();
    $(".datepicker").datepicker();
});
</script>
<!-- END JAVASCRIPTS -->
