<link href="/css/dataTable.css" rel="stylesheet" type="text/css">

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
        
            <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega margin-bottom-20">
                <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
                    Stock Control
                </h2>
                
                <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20">
                    <a href="/inventory_count">
                        <button id="import" class="btn btn-white pull-right btn-right" style="color:black">
                            <div class="glyphicon glyphicon-stats"></div>&nbsp;
                        Inventory Count</button>
                    </a>
                    <a href="/stock/newTransfer">
                        <button id="" class="btn btn-white pull-right btn-center" style="color:black">
                            <div class="glyphicon glyphicon-sort"></div>&nbsp;
                        Transfer Stock</button>
                    </a>
                    <!--
                    <button id="" class="btn btn-white pull-right btn-center" style="color:black">
                        <div class="glyphicon glyphicon-refresh"></div>&nbsp;
                    Transfer Stock</button>
                    -->
                    <a href="/stock/newOrder">
                        <button class="btn btn-white pull-right btn-left">
                            <div class="glyphicon glyphicon-list-alt"></div>&nbsp;
                        Order Stock</button>
                    </a>
                </div>
            </div>
            
            <!-- FILTER -->
            <div class="col-md-12 col-xs-12 col-sm-12 line-box filter-box">
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <dl>
                        <dt>Show</dt> 
                        <dd>
                            <select class="status" name="status" id="status">
                                <option value="ALL" <?php echo $status == 'ALL' ? 'selected="selected"' : ''; ?>>All orders</option>
                                <option value="OPEN" <?php echo $status == 'OPEN' ? 'selected="selected"' : ''; ?>>Open orders</option>
                                <option value="SENT" <?php echo $status == 'SENT' ? 'selected="selected"' : ''; ?>>Sent orders</option>
                                <option value="RECEIVED" <?php echo $status == 'RECEIVED' ? 'selected="selected"' : ''; ?>>Received orders</option>
                                <option value="OVERDUE" <?php echo $status == 'OVERDUE' ? 'selected="selected"' : ''; ?>>Overdue orders</option>
                                <option value="CANCELLED" <?php echo $status == 'RECEIVED' ? 'selected="selected"' : ''; ?>>Cancelled orders</option>
                                <option value="RECEIVE_FAIL" <?php echo $status == 'RECEIVE_FAIL' ? 'selected="selected"' : ''; ?>>Failed orders</option>
                            </select>
                        </dd>
                        <dt>Date from</dt>
                        <dd>
                            <span class="glyphicon glyphicon-calendar icon-calendar"></span>
                            <input type="text" name="date_from" id="date_from" value="<?php echo $date_from; ?>">
                        </dd>
                        <dt>Due date from</dt>
                        <dd>
                            <span class="glyphicon glyphicon-calendar icon-calendar"></span>
                            <input type="text" name="due_date_from" id="due_date_from" value="<?php echo $due_date_from; ?>">
                        </dd>
                    </dl> 
                </div>
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <dl>
                        <dt>Name / Has product</dt>
                        <dd>
                            <input type="text" name="name" id="name" value="<?php echo $name; ?>">
                        </dd>
                        <dt>Date to</dt>
                        <dd>
                            <span class="glyphicon glyphicon-calendar icon-calendar"></span>
                            <input type="text" name="date_to" id="date_to" value="<?php echo $date_to; ?>">
                        </dd>
                        <dt>Due date to</dt>
                        <dd>
                            <span class="glyphicon glyphicon-calendar icon-calendar"></span>
                            <input type="text" name="due_date_to" id="due_date_to" value="<?php echo $due_date_to; ?>">
                        </dd>
                    </dl>
                 </div>
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <dl>
                        <dt>Supplier invoice</dt>
                        <dd>
                            <input type="text" name="supplier_invoice" id="supplier_invoice" value="<?php echo $supplier_invoice; ?>">
                        </dd>
                        <dt>Outlet</dt>
                        <dd>
                            <select name="outlet_id" id="outlet_id">
                                <option></option>
                            <?php foreach ($outlets as $key => $value) : ?>
                                <option value="<?php echo $key; ?>" <?php echo $key == $outlet_id ? 'selected="selected"' : ''; ?>><?php echo $value; ?></option>
                            <?php endforeach; ?>
                            </select>
                        </dd>
                        <dt>Supplier</dt>
                        <dd>
                            <select name="supplier_id" id="supplier_id">
                                <option></option>
                            <?php foreach ($suppliers as $key => $value) : ?>
                                <option value="<?php echo $key; ?>" <?php echo $key == $supplier_id ? 'selected="selected"' : ''; ?>><?php echo $value; ?></option>
                            <?php endforeach; ?>
                            </select>
                        </dd>
                    </dl>
                 </div>
                 <div class="col-md-12 col-xs-12 col-sm-12">
                     <button id="apply_filter" class="btn btn-primary filter pull-right">Update</button>
                 </div>
            </div>
            
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
                        $orderStatusDisp = array(
                            'OPEN' => 'Open',
                            'SEND' => 'Sent',
                            'RECEIVED' => 'Received',
                            'RECEIVE_FAIL' => 'Failed',
                            'OVERDUE' => 'Overdue',
                            'CANCELLED' => 'Cancelled'
                        );

                        foreach ($orders as $order) :
                            $orderType = $order['MerchantStockOrder']['type'];
                            $orderStatus = $order['MerchantStockOrder']['status'];
                            $sourceName = '';

                            if ($orderType === 'SUPPLIER') {
                                $orderType = 'Supplier order';
                                $sourceName = $order['MerchantSupplier']['name'];
                            } elseif ($orderType === 'OUTLET') {
                                $orderType = 'Outlet transfer';
                                $sourceName = $order['SourceOutlet']['name'];
                            }
                            if (empty($sourceName)) {
                                $sourceName = 'No Name';
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
                        <!-- <td><?php echo count($order['MerchantStockOrderItem']); ?></td> -->
                        <td><?php echo $order[0]['items']; ?></td>
                        <td><?php echo $orderStatusDisp[$orderStatus]; ?></td>
                        <td>
                            <a href="/stock/view/<?php echo $order['MerchantStockOrder']['id']; ?>">View</a> |
                            <?php if ( in_array($orderStatus, array('SENT', 'RECEIVED', 'RECEIVE_FAIL')) ): ?>
                            <a href="/stock/receive/<?php echo $order['MerchantStockOrder']['id']; ?>">Edit</a> 
                            <?php else: ?>
                            <a href="/stock/edit/<?php echo $order['MerchantStockOrder']['id']; ?>">Edit</a> 
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
jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    QuickSidebar.init() // init quick sidebar
    Index.init();
    
    $("#stockTable").DataTable({
       searching: false
    });
    $("#stockTable_length").hide();
    $("#date_from").datepicker({ dateFormat: 'yy-mm-dd' });
    $("#date_to").datepicker();
    $("#due_date_from").datepicker();
    $("#due_date_to").datepicker();

    $("#apply_filter").click(function(){
        var status = $('#status').val();
        var name = $('#name').val();
        var date_from = $('#date_from').val();
        var date_to = $('#date_to').val();
        var due_date_from = $('#due_date_from').val();
        var due_date_to = $('#due_date_to').val();
        var outlet_id = $('#outlet_id').val();
        var supplier_id = $('#supplier_id').val();
        var supplier_invoice = $('#supplier_invoice').val();

        uri = 'status=' + status + '&name=' + name
            + '&date_from=' + date_from + '&date_to=' + date_to
            + '&due_date_from=' + due_date_from + '&due_date_to=' + due_date_to
            + '&outlet_id=' + outlet_id + '&supplier_id=' + supplier_id
            + '&supplier_invoice=' + supplier_invoice;
        window.location.href = '/stock?' + encodeURI(uri);
    });
});
</script>
<!-- END JAVASCRIPTS -->
