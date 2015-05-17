<?php
    $order_id = '';
    $order_type = '';
    $supplier_name = '';
    $source_outlet_name = '';
    $outlet_name = '';

    if ($data) {
        $order_id = $data['MerchantStockOrder']['id'];
        $order_type = $data['MerchantStockOrder']['order_type_id'];

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
        <?php if ('stock_order_type_stockorder' === $order_type) : ?>
            <h3>Update Order</h3>
        <?php elseif ('stock_order_type_transfer' === $order_type) : ?>
            <h3>Update Transfer</h3>
        <?php endif; ?>
            <form action="/stock_orders/<?php echo $order_id; ?>/editDetails" method="post">
            <?php
                echo $this->Form->input('MerchantStockOrder.id', array(
                    'id' => 'id',
                    'type' => 'hidden'
                ));

                echo $this->Form->input('MerchantStockOrder.order_type_id', array(
                    'id' => 'order_type_id',
                    'type' => 'hidden'
                ));

                echo $this->Form->input('MerchantStockOrder.order_status_id', array(
                    'id' => 'order_status_id',
                    'type' => 'hidden'
                ));

                echo $this->Form->input('MerchantStockOrder.outlet_id', array(
                    'id' => 'outlet_id',
                    'type' => 'hidden'
                ));

                echo $this->Form->input('MerchantStockOrder.source_outlet_id', array(
                    'id' => 'source_outlet_id',
                    'type' => 'hidden'
                ));

                echo $this->Form->input('MerchantStockOrder.supplier_id', array(
                    'id' => 'supplier_id',
                    'type' => 'hidden'
                ));
             ?>
            <div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">Details</div>
                <div class="line-box line-box-content col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-6">
                        <dl>
                            <dt>Order name</dt>
                            <dd>
                                <?php
                                    echo $this->Form->input('MerchantStockOrder.name', array(
                                        'id' => 'name',
                                        'type' => 'text',
                                        'div' => false,
                                        'label' => false
                                    ));
                                 ?>
                            </dd>
                            <dt>Due at</dt>
                            <dd>
                                <span class="glyphicon glyphicon-calendar icon-calendar"></span>
                                <?php
                                    echo $this->Form->input('MerchantStockOrder.due_date', array(
                                        'id' => 'due_date',
                                        'type' => 'text',
                                        'class' => 'datepicker',
                                        'div' => false,
                                        'label' => false
                                    ));
                                 ?>
                            </dd>
                        <?php if ('stock_order_type_stockorder' === $order_type) : ?>
                            <dt>Supplier invoice</dt>
                            <dd>
                                <?php
                                    echo $this->Form->input('MerchantStockOrder.supplier_invoice', array(
                                        'id' => 'supplier_invoice',
                                        'type' => 'text',
                                        'div' => false,
                                        'label' => false
                                    ));
                                 ?>
                            </dd>
                        <?php endif; ?>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <dl>
                        <?php if ('stock_order_type_stockorder' === $order_type) : ?>
                            <dt>Supplier</dt>
                            <dd>
                                <?php echo $supplier_name; ?>
                            </dd>
                            <dt>Deliver to</dt>
                            <dd>
                                <?php echo $outlet_name; ?>
                            </dd>
                        <?php else : ?>
                            <dt>Source outlet</dt>
                            <dd>
                                <?php echo $source_outlet_name; ?>
                            </dd>
                            <dt>Destination outlet</dt>
                            <dd>
                                <?php echo $outlet_name; ?>
                            </dd>
                        <?php endif; ?>
                        </dl>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 pull-right margin-top-20 margin-bottom-20">
                    <button class="btn btn-primary btn-wide pull-right save" type="save">Save</button>
                    <a href="/stock_orders" class="btn btn-default btn-wide pull-left margin-right-10 cancel">Cancel</a>
                    <a href="/stock_orders/<?php echo $order_id; ?>/cancel" class="btn btn-default btn-wide pull-left margin-right-10">Delete</a>
                </div>
            </div>
            </form>
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

    $(".datepicker").datepicker({ dateFormat: 'yy-mm-dd' });
});
</script>
<!-- END JAVASCRIPTS -->
