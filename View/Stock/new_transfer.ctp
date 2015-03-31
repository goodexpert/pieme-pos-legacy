input[type=file] {
	border: 0;
}
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
		
			<h3>New Stock Transfer</h3>
			
			<div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">Details</div>
                
                <form action="/stock/newTransfer" method="post" id="stock_order_form">
	            <div class="line-box line-box-content col-md-12 col-sm-12 col-xs-12">
					<div class="col-md-6">
						<dl>
							<dt>Name / reference</dt>
							<dd>
								<input tpye="text" name="data[MerchantStockOrder][name]" value="Order - <?=date('d M Y');?>" id="order-name">
							</dd>
							<dt>Due at</dt>
							<dd>
								<span class="glyphicon glyphicon-calendar icon-calendar"></span>
								<input type="text" name="data[MerchantStockOrder][due_date]" class="datepicker" id="order-due">
							</dd>
						</dl>
					</div>
					<div class="col-md-6">
						<dl>
							<dt>Source outlet</dt>
							<dd>
                                <?php
                                    $merchantOutlets = $this->Form->input('MerchantStockOrder.source_outlet_id', array(
                                        'type'    => 'select',
                                        'div'     => false,
                                        'label'   => false,
                                        'options' => $outlets
                                    ));
                                    echo $merchantOutlets;
                                ?>
							</dd>
							<dt>Destination outlet</dt>
							<dd>
                                <?php
                                    $merchantOutlets = $this->Form->input('MerchantStockOrder.outlet_id', array(
                                        'type'    => 'select',
                                        'div'     => false,
                                        'label'   => false,
                                        'options' => $outlets
                                    ));
                                    echo $merchantOutlets;
                                ?>
							</dd>
						</dl>
					</div>
					<div class="dashed-line-gr margin-top-20"></div>
					<div class="col-md-6">
						<dl>
							<dt>Auto fill</dt>
							<dd>
								<select id="order-auto" name="data[order-auto]">
									<option value="1">Auto-fill from reorder point</option>
									<option value="0">Don't auto-fill</option>
								</select>
							</dd>
							<dt></dt>
							<dd><p>Auto fill your order with products that have low stock levels (500 product max).</p></dd>
						</dl>
					</div>
					<div class="col-md-6">
						<dl>
							<dt>Import order</dt>
							<dd><input type="file"></dd>
						</dl>
					</div>
	            </div>
				<div class="col-md-12 col-sm-12 col-xs-12 pull-right margin-top-20 margin-bottom-20">
					<button type="submit" class="btn btn-primary btn-wide pull-right save">Save</button>
					<button class="btn btn-default btn-wide pull-right margin-right-10 cancel">Cancel</button>
				</div>
                </form>

			</div>
            		
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

	$(".datepicker").datepicker({ dateFormat: 'yy-mm-dd' });

	$(document).on('click','.save',function(){
		$.ajax({

			url: '/stock/order.json',
			type: 'POST',
			data: {
				name: $("#order-name").val(),
				supplier_id: $("#order-supplier").val(),
				outlet_id: $("#order-outlet").val(),
				type: 'SUPPLIER',
				status: 'OPEN',
				due_date: $("#order-due").val()
			}
		
		}).done(function(result){
			console.log(result);
		});
	});
   
	$(".cancel").click(function(){
		parent.history.back();
	});
});
</script>
<!-- END JAVASCRIPTS -->
