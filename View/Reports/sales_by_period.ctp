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
                <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
                    Sales Totals by Period
                </h2>
                <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20">
                    <a href="#" id="export"><button class="btn btn-white pull-right">
                        <div class="glyphicon glyphicon-export"></div>&nbsp;
                    export</button></a>
                </div>
            </div>
                
            <!-- FILTER -->
            <form class="col-md-12 col-xs-12 col-sm-12 line-box filter-box" action="/reports/sales/sales_by_period" method="get">
                <div class="col-md-4 col-xs-6 col-sm-6">
                    <dl>
                        <dt>Date from</dt> 
                        <dd>
                            <span class="glyphicon glyphicon-calendar icon-calendar"></span>
                            <input type="text" id="date_from" name="from" value="<?php if(isset($_GET['from'])){echo $_GET['from'];}?>">
                        </dd>
                    </dl> 
                </div>
                <div class="col-md-4 col-xs-6 col-sm-6">
                    <dl>
                        <dt>Date to</dt> 
                        <dd>
                            <span class="glyphicon glyphicon-calendar icon-calendar"></span>
                            <input type="text" id="date_to" name="to" value="<?php if(isset($_GET['to'])){echo $_GET['to'];}?>">
                        </dd>
                    </dl>
                 </div>
                <div class="col-md-4 col-xs-6 col-sm-6">
                    <dl>
                        <dt>Compare to the last</dt>
                        <dd>
                            <select name="period">
                                <option value="1">1 Period</option>
                                <?php for($i = 0;$i <= 12;$i++) { ?>
                                	<option value="<?php echo $i;?>" <?php if(isset($_GET['period']) && $_GET['period'] == $i){echo "selected";}?>><?php echo $i;?> Periods</option>
                                <?php } ?>
                            </select>
                        </dd>
                    </dl>
                 </div>
                 <div class="col-md-12 col-xs-12 col-sm-12">
                     <button type="submit" class="btn btn-primary filter pull-right">Update</button>
                 </div>
            </form>

            <table id="productTable" class="table-bordered dataTable table-price">
                <thead>
	                <tr>
	                    <th>&nbsp;</th>
	                    <?php if(isset($_GET['from'])) {
		                    $dateRangeFrom = date('M d', strtotime($_GET['from']));
		                    $dateRangeTo = date('M d', strtotime($_GET['to']));
		                    foreach($sales as $date => $sale) {
			                    $from = date("M d",strtotime(explode("~", $date)[0]));
			                    $to = date("M d",strtotime(explode("~", $date)[1]));?>
		                    
		                    	<th class="text-right">
			                    	<?php echo $from.' - '.$to;?>
		                    	</th>
		                    <?php }
	                    } ?>
	                </tr>
                </thead>
                <tbody>
                	<?php if(isset($_GET['from'])) {?>
                    <tr>
                        <td>Sales incl. tax ($)</td>
                        <?php foreach($sales as $sale) {
                        	$salesIncl = 0;
                        	foreach($sale as $data) { 
	                        	$salesIncl += $data['RegisterSale']['total_price_incl_tax'];
	                        }?>
	                        <td class="text-right">
		                        <?php echo number_format($salesIncl,2,'.',',');?>
	                        </td>
	                    <?php } ?>
                    </tr>
                    <tr>
                        <td>Tax ($)</td>
                        <?php foreach($sales as $sale) {
                        	$tax = 0;
                        	foreach($sale as $data) { 
	                        	$tax += $data['RegisterSale']['total_tax'];
	                        }?>
	                        <td class="text-right">
		                        <?php echo number_format($tax,2,'.',',');?>
	                        </td>
	                    <?php } ?>
                    </tr>
                    <tr>
                        <td>Sales exc. tax ($)</td>
                        <?php foreach($sales as $sale) {
                        	$salesExc = 0;
                        	foreach($sale as $data) { 
	                        	$salesExc += $data['RegisterSale']['total_price'];
	                        }?>
	                        <td class="text-right">
		                        <?php echo number_format($salesExc,2,'.',',');?>
	                        </td>
	                    <?php } ?>
                    </tr>
                    <tr>
                        <td>Cost of goods ($)</td>
                        <?php foreach($sales as $sale) {
                        	$cost = 0;
                        	foreach($sale as $data) { 
	                        	$cost += $data['RegisterSale']['total_cost'];
	                        }?>
	                        <td class="text-right">
		                        <?php echo number_format($cost,2,'.',',');?>
	                        </td>
	                    <?php } ?>
                    </tr>
                    <tr>
                        <td>Discounts ($)</td>
                        <?php foreach($sales as $sale) {
                        	$discount = 0;
                        	foreach($sale as $data) { 
	                        	$discount += $data['RegisterSale']['total_discount'];
	                        }?>
	                        <td class="text-right">
		                        <?php echo number_format($discount,2,'.',',');?>
	                        </td>
	                    <?php } ?>
                    </tr>
                    <tr class="table-color">
                        <td>Gross Profit ($)</td>
                        <?php foreach($sales as $sale) {
                        	$salesExc = 0;
                        	$cost = 0;
                        	foreach($sale as $data) {
                        		$salesExc += $data['RegisterSale']['total_price'];
	                        	$cost += $data['RegisterSale']['total_cost'];
	                        }?>
	                        <td class="text-right">
		                        <?php echo number_format($salesExc - $cost,2,'.',',');?>
	                        </td>
	                    <?php } ?>
                    </tr>
                    <tr class="table-color">
                        <td>Gross Margin</td>
                        <?php foreach($sales as $sale) {
                        	$salesExc = 0;
                        	$cost = 0;
                        	foreach($sale as $data) {
                        		$salesExc += $data['RegisterSale']['total_price'];
	                        	$cost += $data['RegisterSale']['total_cost'];
	                        }?>
	                        <td class="text-right">
		                        <?php if($salesExc > 0){echo number_format(($salesExc - $cost) / $salesExc * 100,2,'.',',').'%';}else{echo '0%';}?>
	                        </td>
	                    <?php } ?>
                    </tr>
                    <?php } else { ?>
                    <tr>
                    	<td style="text-align:center">Select your criteria above to update the table.</td>
                    </tr>
                    <?php } ?>
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
<script src="/js/dataTable.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    QuickSidebar.init(); // init quick sidebar
    Index.init();
    
    $("#date_from").datepicker({ dateFormat: 'yy-mm-dd' });
    $("#date_to").datepicker({ dateFormat: 'yy-mm-dd' });
});
</script>