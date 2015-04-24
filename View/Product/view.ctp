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
                <input type="hidden" id="product_id" value="<?=$id;?>">
                <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
                <?=$product['MerchantProduct']['name'];?>
                </h2>
                
                <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20">
                    <a href="<?php echo $_SERVER['REQUEST_URI'];?>/delete">
                    <button class="btn btn-white btn-right pull-right">
                        <span class="glyphicon glyphicon-trash"></span>&nbsp;Delete Product
                    </button>
                    </a>
                    <button class="btn btn-white pull-right btn-center">
                        <div class="glyphicon glyphicon-print"></div>&nbsp;
                    Print Label</button>
                    <a href="/product/<?=$id;?>/edit"><button id="import" class="btn btn-white pull-right btn-left">
                        <div class="glyphicon glyphicon-edit"></div>&nbsp;
                    Edit Product</button></a>
                </div>
            </div>
            
            
            <div class="product_tags"></div>
                <!-- START col-md-12-->
                <div class="form-body line-box col-md-12 col-xs-12 col-sm-12 col-alpha col-omega product_tags-list margin-top-20"> 
                  <!-- START col-md-12-->
                  <div class="col-md-12 col-xs-12 col-sm-12">
                      <h5>A cup of Coffee. You can delete this once you have some other products setup.</h5>
                      <?php foreach($tags as $tag) { ?>
                          <span class="btn btn-sm btn-default"><?php echo $tag['MerchantProductTag']['name'];?></span>
                      <?php } ?>
                  </div>
                  <span class="dashed-line-gr"></span>
                  <div class="col-md-9 col-xs-9 col-sm-9 col-alpha col-omega margin-top-20">
                      <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                      <dl class="col-md-6 col-xs-6 col-sm-6 col-alpha"> 
                        <dt class="col-md-4">Type</dt>
                        <dd class="col-md-8">
                            <span class="product_type"><?=$product['MerchantProductType']['name'];?></span>
                        </dd>
                      </dl>
                      <dl class="col-md-6 col-xs-6 col-sm-6 col-alpha"> 
                        <dt class="col-md-4">Brand</dt>
                        <dd class="col-md-8">
                            <span class="product_brand"><?=$product['MerchantProductBrand']['name'];?></span>
                        </dd>
                      </dl>
                      <dl class="col-md-6 col-xs-6 col-sm-6 col-alpha"> 
                        <dt class="col-md-4">Handle</dt>
                        <dd class="col-md-8">
                            <span class="product_handle"><?=$product['MerchantProduct']['handle'];?></span>
                        </dd>
                      </dl>
                      <dl class="col-md-6 col-xs-6 col-sm-6 col-alpha"> 
                        <dt class="col-md-4">Supplier</dt>
                        <dd class="col-md-8">
                            <span class="product_supplier"><?=$product['MerchantSupplier']['name'];?></span>
                        </dd>
                      </dl>
                  </div>
                  <!-- END col-md-12-->
                  <!-- START col-md-12-->
                  <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                      <dl class="col-md-6 col-xs-6 col-sm-6 col-alpha"> 
                        <dt class="col-md-4">SKU</dt>
                        <dd class="col-md-8">
                            <span class="product_sku"><?=$product['MerchantProduct']['sku'];?></span>
                        </dd>
                      </dl>
                      <dl class="col-md-6 col-xs-6 col-sm-6 col-alpha"> 
                        <dt class="col-md-4">Supplier code</dt>
                        <dd class="col-md-8">
                            <span class="product_supplier_code"><?=$product['MerchantProduct']['supplier_code'];?></span>
                        </dd>
                      </dl>
                      <dl class="col-md-6 col-xs-6 col-sm-6 col-alpha"> 
                        <dt class="col-md-4">Average cost</dt>
                        <dd class="col-md-8">
                            <span class="product_average_cost"><?php echo number_format($product['MerchantProduct']['supply_price'],2,'.',',');?></span>
                        </dd>
                      </dl>
                      </div>
                    <span class="dashed-line-gr"></span>
                    <!-- END col-md-12-->
                      <!-- START col-md-12-->
                      <div class="col-md-12 col-xs-12 col-sm-12">
                          <h4>Inventory</h4>
                          <table class="table-bordered dataTable-sm">
                              <thead>
                                <tr>
                                    <th>Outlet</th>
                                    <th>In stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($inventories as $inventory) { ?>
                                <tr>
                                    <td><?php echo $inventory['MerchantOutlet']['name'];?></td>
                                    <td><?php echo $inventory['MerchantProductInventory']['count'];?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                          </table>
                        </div>
                        <!-- END col-md-12-->
                  </div>
                  <div class="col-md-3 col-xs-3 col-sm-3 col-alpha col-omega product-detail-img" style="text-align:center;">
                      <img src="/img/<?=$product['MerchantProduct']['image'];?>">
                  </div>
                  <!-- END col-md-12-->
                </div>
                <!-- END col-md-12-->
                <!-- filter-->
                <form class="col-md-12 col-xs-12 col-sm-12 line-box filter-box margin-top-20" action="<?php echo "$_SERVER[REQUEST_URI]";?>" method="get">
                    <div class="col-md-4 col-xs-4 col-sm-4">
                        <dl>
                            <dt>Period start</dt> 
                            <dd>
                                <span class="glyphicon glyphicon-calendar icon-calendar"></span>
                                <input type="text" id="Period_start" name="from" value="<?php if(isset($_GET['from'])){echo $_GET['from'];}?>">
                            </dd>
                            <dt>User</dt>
                            <dd>
                                <select name="user_id">
                                    <option></option>
                                    <?php foreach($users as $user) { ?>
                                        <option value="<?php echo $user['MerchantUser']['id'];?>" <?php if(isset($_GET['user_id']) && $_GET['user_id'] == $user['MerchantUser']['id']){echo "selected";}?>><?php echo $user['MerchantUser']['display_name'];?></option>
                                    <?php } ?>
                                </select>
                            </dd>
                        </dl> 
                    </div>
                    <div class="col-md-4 col-xs-4 col-sm-4">
                        <dl>
                            <dt>Period end</dt>
                            <dd>
                                <span class="glyphicon glyphicon-calendar icon-calendar"></span>
                                <input type="text" id="Period_end" name="to" value="<?php if(isset($_GET['to'])){echo $_GET['to'];}?>">
                            </dd>
                            <dt>Outlet</dt>
                            <dd>
                                <select name="outlet_id">
                                    <option></option>
                                    <?php foreach($outlets as $outlet) { ?>
                                        <option value="<?php echo $outlet['MerchantOutlet']['id'];?>" <?php if(isset($_GET['outlet_id']) && $_GET['outlet_id'] == $outlet['MerchantOutlet']['id']){echo "selected";}?>><?php echo $outlet['MerchantOutlet']['name'];?></option>
                                    <?php } ?>
                                </select>
                            </dd>
                        </dl>
                     </div>
                    <div class="col-md-4 col-xs-4 col-sm-4">
                        <dl>
                            <dt>Action type</dt>
                            <dd>
                                <select name="action_type">
                                    <option value="" selected="selected"></option>
                                    <option value="back_order_placed">Back Order Placed</option>
                                    <option value="back_order_transfer_placed">Back Order Transfer Placed</option>
                                    <option value="order_cancelled">Order Cancelled</option>
                                    <option value="order_placed">Order Placed</option>
                                    <option value="order_received">Order Received</option>
                                    <option value="stocktake_complete">Inventory Count Complete</option>
                                    <option value="transfer_cancelled">Transfer Cancelled</option>
                                    <option value="transfer_placed">Transfer Placed</option>
                                    <option value="transfer_received">Transfer Received</option>
                                    <option value="sale">Sale</option>
                                    <option value="layby_sale">Layby Sale</option>
                                    <option value="account_sale">Account Sale</option>
                                    <option value="sale_voided">Voided Sale</option>
                                    <option value="component_deleted">Deleted</option>
                                    <option value="create">Created</option>
                                    <option value="delete">Deleted</option>
                                    <option value="update">Update</option>
                                    <option value="shopify">Shopify</option>
                                </select>
                            </dd>
                        </dl>
                     </div>
                     <div class="col-md-12 col-xs-12 col-sm-12">
                         <button class="btn btn-primary filter pull-right">Update</button>
                     </div>
                </form>
                <!-- filter end-->
            <table id="transactionTable" class="table dataTable">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>User</th>
                        <th>Outlet</th>
                        <th>Quantity</th>
                        <th>Outlet Quantity</th>
                        <th>Change</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($logs as $log) { ?>
                        <tr>
                            <td><?php echo $log['MerchantProductLog']['created'];?></td>
                            <td><?php echo $log['MerchantUser']['display_name'];?></td>
                            <td><?php echo $log['MerchantOutlet']['name'];?></td>
                            <td><?php echo $log['MerchantProductLog']['quantity'];?></td>
                            <td><?php echo $log['MerchantProductLog']['outlet_quantity'];?></td>
                            <td><?php echo $log['MerchantProductLog']['change'];?></td>
                            <td><?php echo $log['MerchantProductLog']['action_type'];?></td>
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
<!-- END PAGE LEVEL SCRIPTS -->

<script src="/js/dataTable.js" type="text/javascript"></script>
<script>
jQuery(document).ready(function() {    
   Metronic.init(); // init metronic core componets
   Layout.init(); // init layout
   QuickSidebar.init() // init quick sidebar
   Index.init();
   
    $("#Period_start").datepicker({ dateFormat: 'yy-mm-dd' });
    $("#Period_end").datepicker({ dateFormat: 'yy-mm-dd' });
});
</script>
<!-- END JAVASCRIPTS -->