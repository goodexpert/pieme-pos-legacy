<style>
.order-product-header {
    background: #eee;
    margin-bottom: 20px;
    padding: 10px 15px;
}
.line-box {
    padding: 0;
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
            <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                <div class="pull-left col-md-9 col-xs-9 col-sm-9 col-alpha col-omega">
                    <h2>
                        Review Inventory Count
                    </h2>
                    <h4 class="col-lg-5 col-md-6 col-xs-12 col-sm-7 col-alpha">Main Outlet 25-03-2015 3:00 PM</h4>
                    <h5 class="col-lg-7 col-md-6 col-xs-12 col-sm-5 col-alpha col-omega">Full Count</h5>
                    <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                        <h5 class="col-lg-4 col-md-5 col-xs-12 col-sm-6 col-alpha col-omega">
                            <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                            Start: 25 Mar 2015, 2:37 PM
                        </h5>
                        <h5 class="col-lg-8 col-md-7 col-xs-12 col-sm-6 col-alpha col-omega">
                            <span class="glyphicon glyphicon-map-marker"></span>&nbsp;
                            Main Outlet
                        </h5>
                </div>
            </div>
            <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                <div class="inventory-content">
                    <div class="inventory-tab">
                        <ul>
                            <li class="active">Uncounted</li>
                            <li>Upmatched</li>
                            <li>Matched</li>
                            <li>Excluded</li>
                            <li>All</li>
                        </ul>
                    </div>
                    <div class="inventory-Due">
                        <span class="glyphicon glyphicon-info-sign pull-left" style="color:#cccccc;"></span><h5>The amount you counted was more or less than expected. You might like to double-check items in this list</h5>
                        <table id="productTable" class="table-bordered dataTable">
                            <colgroup>
                                <col width="2%">
                                <col width="50%">
                                <col width="12%">
                                <col width="12%">
                                <col width="12%">
                                <col width="12%">
                            </colgroup>
                            <thead>
                                <tr role="row">
                                    <th colspan="2" class="text-center">COUNT LIST</th>
                                    <th colspan="2" class="text-center">INVENTORY COUNT</th>
                                    <th colspan="2" class="text-center">DIFFERENCES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr role="row" class="odd table-color-gr">
                                    <td><input type="checkbox"></td>
                                    <td>
                                        PRODUCT 
                                    </td>
                                    <td>EXPECTED</td>
                                    <td>TOTAL</td>
                                    <td>UNIT</td>
                                    <td>COST</td>
                                </tr>
                                <tr role="row" class="even">
                                    <td><input type="checkbox"></td>
                                    <td>T-shirt (Demo)
                                        <h6>tshirt-white</h6>
                                    </td>
                                    <td>8</td>
                                    <td>6</td>
                                    <td>5</td>
                                    <td>$0.00</td>
                                </tr>
                                <tr role="row" class="even table-color">
                                    <td> </td>
                                    <td><strong>Total</strong></td>
                                    <td> </td>
                                    <td> </td>
                                    <td><strong>-15</strong></td>
                                    <td><strong>$0.00</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 pull-right margin-top-20 margin-bottom-20">
                <button id="Complete" class="btn btn-primary btn-wide pull-right">Complete</button>
                <button class="btn btn-default pull-right margin-right-10 ">Resume Count</button>
                <button id="Abandon" class="btn btn-default pull-left">Abandon Count</button>
            </div>
        </div>
    </div>
  <!-- COMPLETE POPUP BOX -->
  <div id="Complete_popup" class="confirmation-modal modal fade in" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="confirm-close cancel" data-dismiss="modal" aria-hidden="true">
                  <i class="glyphicon glyphicon-remove"></i>
                  </button>
                  <h4 class="modal-title">Complete Stocktake</h4>
              </div>
              <div class="modal-body">
                  Awesome! You've finished counting. When you click submit, we'll begin updating your inventory levels.
              </div>
              <div class="modal-footer">
                <button class="btn btn-primary">Cancel</button>
                <button class="btn btn-success">Submit</button>
            </div>
          </div>
      </div>
  </div>
  <!-- COMPLETE POPUP BOX END -->
  <!-- Abandon count POPUP BOX -->
  <div id="Abandon_popup" class="confirmation-modal modal fade in" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="confirm-close cancel" data-dismiss="modal" aria-hidden="true">
                  <i class="glyphicon glyphicon-remove"></i>
                  </button>
                  <h4 class="modal-title">Are you sure you want to abandon count?</h4>
              </div>
              <div class="modal-body">
                  Your inventory levels will not be updated. A record of this inventory will be saved but you will no longer be able to edit it.
              </div>
              <div class="modal-footer">
                <button class="btn btn-primary">Cancel</button>
                <button class="btn btn-success">Abandon</button>
            </div>
          </div>
      </div>
  </div>
  <!-- COMPLETE POPUP BOX END -->
    
    
    
    
    
    
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
    $("#Complete").click(function(){
        $("#Complete_popup").show();
    });
    $(".confirm-close").click(function(){
        $("#Complete_popup").hide();
    });
    $("#Abandon").click(function(){
        $("#Abandon_popup").show();
    });
    $(".confirm-close").click(function(){
        $("#Abandon_popup").hide();
    });
});
</script>
<!-- END JAVASCRIPTS -->