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
                    <?php echo $order['MerchantStockOrder']['name'] . ' (' . $order['MerchantStockOrder']['status'] . ')'; ?>
				</h2>
				
				<div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20">
					<button class="btn btn-white pull-right btn-right">
                    	<div class="glyphicon glyphicon-import"></div>&nbsp;
                    Import Products</button>
                    <a href="/stock/editDetails/<?php echo $order['MerchantStockOrder']['id']; ?>"  class="btn btn-white pull-right btn-center">
                    	<div class="glyphicon glyphicon-edit"></div>&nbsp;
                    Edit Details</button>
                    <a href="/stock/edit/<?php echo $order['MerchantStockOrder']['id']; ?>" class="btn btn-white pull-right btn-left">
                    	<div class="glyphicon glyphicon-edit"></div>&nbsp;
                     Edit Products</a>
                    </a>
				</div>
			</div>
			<div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">Details
                <span class="clickable same_as_physical pull-right btn btn-default btn-right">
                    <a href="/stock/markSent/<?php echo $order['MerchantStockOrder']['id']; ?>">Mark as sent</a>
                </span>
            	<span class="clickable same_as_physical pull-right btn btn-default btn-left">Print labels</span>
            </div>
                
                <div class="line-box line-box-content col-md-12 col-sm-12 col-xs-12">
					<div class="col-md-6 margin-bottom-20">
						<dl>
							<dt>Deliver to</dt>
                            <dd><?php echo $order['MerchantOutlet']['name']; ?></dd>
						</dl>
					</div>
					<div class="col-md-6 margin-bottom-20">
						<dl>
							<dt>Created</dt>
                            <dd><?php echo date('d F Y', strtotime($order['MerchantStockOrder']['created'])); ?></dd>
						</dl>
					</div>
					<div class="col-md-3 col-omega">
						<table class="table-bordered dataTable">
							<colgroup>
								<col width="15%">
								<col width="15%">
							</colgroup>
							<thead>
							<tr>
								<th>Order</th>
								<th>Product</th>
							</tr>
							</thead>
							<tbody>
                                <?php
                                    foreach ($order['MerchantStockOrderItem'] as $idx => $item):
                                ?>
								<tr>
                                    <td><?php echo $idx+1; ?></td>
                                    <td><?php echo $item['MerchantProduct']['name']; ?></td>
								</tr>
                                <?php
                                    endforeach;
                                ?>
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
                                    $totalOrdered = $totalReceived = 0;
                                    $totalSupplyCost = 0.00;
                                    foreach ($order['MerchantStockOrderItem'] as $item):
                                ?>
								<tr>
                                    <td><?php echo $item['MerchantProduct']['sku']; ?></td>
                                    <td><?php echo $item['MerchantProduct']['supplier_code']; ?></td>
                                    <td>
                                        <?php
                                            echo isset($item['MerchantProduct']['MerchantProductInventory'][0])
                                            ? $item['MerchantProduct']['MerchantProductInventory'][0]['count']
                                            : '';
                                        ?>
                                    </td>
                                    <td><?php echo $item['count']; ?></td>
                                    <td><?php echo is_null($item['received']) ? '0' : $item['received']; ?></td>
                                    <td><?php echo $item['supply_price']; ?></td>
                                    <td><?php echo round($item['count'] * $item['supply_price'], 2); ?></td>
                                    <td></td>
								</tr>
                                <?php
                                        $totalOrdered += $item['count'];
                                        $totalReceived += $item['received'];
                                        $totalSupplyCost += round($item['count'] * $item['supply_price'], 2);
                                    endforeach;
                                ?>
								<tr class="table-result">
									<td></td>
									<td></td>
									<td></td>
                                    <td><?php echo $totalOrdered; ?></td>
                                    <td><?php echo $totalReceived; ?></td>
                                    <td><?php echo sprintf('%.2f', $totalSupplyCost); ?></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
							</tbody>
						</table>
						</div>
					</div>
	            </div>
				<div class="col-md-12 col-sm-12 col-xs-12 pull-right margin-top-20 margin-bottom-20">
                    <?php if ( $order['MerchantStockOrder']['status'] == 'SENT' ): ?>
                    <a href="/stock/receive/<?php echo $order['MerchantStockOrder']['id']; ?>" class="btn btn-primary btn-wide pull-right send">Receive</a>
                    <?php else: ?>
					<button type="submit" class="btn btn-primary btn-wide pull-right send">Send</button>
                    <?php endif; ?>
					<a href="#" class="btn btn-default btn-wide pull-left margin-right-10 cancel-order">Cancel</a>
					
                </form>

			</div>
            		
		</div>
	</div>
	<!-- END CONTENT -->
	<!-- Save&Send POPUP BOX -->
	<div class="confirmation-modal modal fade in save_send" tabindex="-1" role="dialog" aria-hidden="false">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="confirm-close close-pop" data-dismiss="modal" aria-hidden="true">
					<i class="glyphicon glyphicon-remove"></i>
					</button>
					<h4 class="modal-title">Send order</h4>
				</div>
				<div class="modal-body margin-bottom-20">
					<dl>
                    	<dt>Recipient name</dt>
                        <dd><input type="text"></dd>
                    	<dt>Email</dt>
                        <dd><input type="text"></dd>
                    	<dt>CC</dt>
                        <dd><input type="text"></dd>
                    	<dt>Subject</dt>
                        <dd><input type="text"></dd>
                    	<dt>Message</dt>
                        <dd><textarea col="2"></textarea></dd>
                    </dl>
				</div>
				<div class="modal-footer">
					<button class="close-pop btn btn-primary btn-wide" type="button" data-dismiss="modal">Cancel</button>
					<button class="confirm btn btn-success btn-wide" type="button" data-dismiss="modal">Send</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Save&Send POPUP BOX END -->
	<!-- Cancel POPUP BOX -->
	<div class="confirmation-modal modal fade in cancel-confirm" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="confirm-close close-pop" data-dismiss="modal" aria-hidden="true">
					<i class="glyphicon glyphicon-remove"></i>
					</button>
					<h4 class="modal-title">Are you sure?</h4>
				</div>
				<div class="modal-body margin-bottom-20">
					<p>You are about to perform an action that can't be undone.</p>
				</div>
				<div class="modal-footer">
					<button class="close-pop btn btn-primary btn-wide" type="button" data-dismiss="modal">Cancel</button>
					<button class="confirm btn btn-success send btn-wide" type="button" data-dismiss="modal">Ok</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Cancel POPUP BOX END -->
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
	
	$(".close-pop").click(function(){
		$(".confirmation-modal").hide();
	});
    /*
	$(".send").click(function(){
		$(".save_send").show();
	});
     */
	$(".cancel-order").click(function(){
		$(".cancel-confirm").show();
	});
});
</script>
<!-- END JAVASCRIPTS -->

