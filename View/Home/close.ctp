<style>
#close-register-wrapper {
    float: left;
    width: 700px;
    border: 1px solid black;
    border-radius: 8px;
    margin-left: 21%;
    margin-right: 21%;
}
#close-register-details, #close-register-sales, #close-register-payments {
    margin: 10px 0;
}
#close-register-details span {
    font-weight: bold;
}
.sales-table th, .sales-table td {
    border-bottom: 1px dashed black;
    padding: 5px;
}
h4 {
    font-weight: 500;
}
</style>

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
            
            <div id="close-register-wrapper">
                <div id="close-register-header" class="col-md-12 col-sm-12 col-xs-12">
                
                    <h3><strong>Closing totals to verify</strong></h3>
                    <h4>Register details</h4>
                
                </div>
                
                <div class="dashed-line"></div>
                
                <div id="close-register-details" class="col-md-12 col-sm-12 col-xs-12 col-alpha col-omega">
                    <div class="col-md-6 col-sm-12 col-xs-6 col-alpha col-omega">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-4 col-sm-4 col-xs-4"><span>Register: </span></div>
                            <div class="col-md-8 col-sm-8 col-xs-8"><?=$user['MerchantRegister']['name'];?></div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-4 col-sm-4 col-xs-4"><span>Outlet: </span></div>
                            <div class="col-md-8 col-sm-8 col-xs-8"><?=$user['MerchantOutlet']['name'];?></div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-6 col-alpha col-omega">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-4 col-sm-4 col-xs-4"><span>Opened: </span></div>
                            <div class="col-md-8 col-sm-8 col-xs-8"><?=$open['MerchantRegisterOpen']['register_open_time'];?></div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="col-md-4 col-sm-4 col-xs-4"><span>Closed: </span></div>
                            <div class="col-md-8 col-sm-8 col-xs-8"><?=date('Y-m-d H:i:s');?></div>
                        </div>
                    </div>
                </div>
                
                <div id="close-register-sales" class="col-md-12 col-sm-12 col-xs-12">
                    <h4>Sales</h4>
                    
                    <table class="col-md-12 col-sm-12 col-xs-12 sales-table">
                        <tr style="border-top:4px double black;">
                            <th>New sales</th>
                            <th></th>
                            <th>$<?=number_format($open['MerchantRegisterOpen']['total_sales'],2,'.','');?></th>
                        </tr>
                        <tr>
                            <td></td>
                            <td>New</td>
                            <td>$<?=number_format($open['MerchantRegisterOpen']['total_new_sales'],2,'.','');?></td>
                        </tr>
                        <?php if($open['MerchantRegisterOpen']['onaccount'] > 0) { ?>
                        <tr>
                            <td></td>
                            <td>On account</td>
                            <td>$<?=number_format($open['MerchantRegisterOpen']['onaccount'],2,'.','');?></td>
                        </tr>
                        <?php } ?>
                        <?php if($open['MerchantRegisterOpen']['layby'] > 0) { ?>
                        <tr>
                            <td></td>
                            <td>Layby</td>
                            <td>$<?=number_format($open['MerchantRegisterOpen']['layby'],2,'.','');?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td></td>
                            <td>Tax (GST)</td>
                            <td>$<?=number_format($open['MerchantRegisterOpen']['total_tax'],2,'.','');?></td>
                        </tr>
                        <?php if($open['MerchantRegisterOpen']['total_discounts'] > 0) { ?>
                        <tr style="border-top:4px double black;">
                            <th>Discounts</th>
                            <th></th>
                            <th>$<?=number_format($open['MerchantRegisterOpen']['total_discounts']);?></th>
                        </tr>
                        <?php } ?>
                        <tr style="border-top:4px double black;">
                            <th>Payments</th>
                            <th></th>
                            <th>$<?=number_format($open['MerchantRegisterOpen']['total_payments'],2,'.','');?></th>
                        </tr>
                        <tr>
                            <td></td>
                            <td>New</td>
                            <td>$<?=number_format($open['MerchantRegisterOpen']['total_new_payments'],2,'.','');?></td>
                        </tr>
                    </table>
                    
                </div>
                
                <div id="close-register-payments" class="col-md-12 col-sm-12 col-xs-12">
                    <h4>Payments</h4>
                    
                    <table class="dataTable table-bordered">
                        <thead>
                            <tr>
                                <th>Payment</th>
                                <th>Amount</th>
                                <th>To post</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Cash</td>
                                <td>258.29</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                
                </div>
                
                <div class="dashed-line"></div>
                
                <div class="col-md-12 col-sm-12 col-xs-12 pull-right margin-top-20 margin-bottom-20">
                    <button class="btn btn-primary save pull-right close-register">Close Register</button>
                    <button class="btn btn-default pull-right margin-right-10">Print</button>
                </div>
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

<script src="/js/notify.js" type="text/javascript"></script>
<script>
jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    QuickSidebar.init() // init quick sidebar
    Index.init();
    
    $(".close-register").click(function(){
        $.ajax({
            url: '/home/close.json',
            type: 'POST',
            data: {
                action: "close"
            }
        });
        window.location.href = "/dashboard";
    });
});
</script>
<!-- END JAVASCRIPTS -->