
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
                <div class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
                    <h2>
                        New Inventory Count
                    </h2>
                </div>
            </div>
            <form action="/inventory_count/create" method="post" id="inventory_count_form">
            <div class="col-md-12 col-xs-12 col-sm-12 line-box filter-box new-inventory margin-top-20">
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <dl>
                        <dt>Outlet</dt> 
                        <dd>
                            <?php
                                $merchantOutlets = $this->Form->input('MerchantStockTake.outlet_id', array(
                                    'type' => 'select',
                                    'div' => false,
                                    'label' => false,
                                    'class' => 'status outlet',
                                    'optoins' => $outlets,
                                    'empty' => ''
                                ));
                                echo $merchantOutlets;
                            ?>
                        </dd>
                    </dl>
                </div>
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <dl>
                        <dt>Start Date</dt>
                        <dd>
                            <span class="glyphicon glyphicon-calendar icon-calendar"></span>
                            <!--<input type="text" class="hasDatepicker">-->
                            <?php
                                $startDate = $this->Form->input('MerchantStockTake.start_date', array(
                                    'type' => 'text',
                                    'div' => false,
                                    'label' => false,
                                    'class' => 'hasDatepicker',
                                ));
                                echo $startDate;
                            ?>
                        </dd>
                    </dl> 
                </div>
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <dl>
                        <dt>Start Time</dt>
                        <dd>
                            <!--<input type="text">-->
                            <?php
                                $startTime = $this->Form->input('MerchantStockTake.start_time', array(
                                    'type' => 'text',
                                    'div' => false,
                                    'label' => false
                                ));
                                echo $startTime;
                            ?>
                        </dd>
                    </dl>
                 </div>
                <div class="col-md-8 col-xs-8 col-sm-8 margin-top-20">
                    <dl>
                        <dt style="width: 19%;">Count Name</dt>
                        <dd style="width: 81%;">
                            <!--<input type="text">-->
                            <?php
                                $name = $this->Form->input('MerchantStockTake.name', array(
                                    'type' => 'text',
                                    'div' => false,
                                    'label' => false
                                ));
                                echo $name;
                            ?>
                        </dd>
                    </dl>
                 </div>
                <div class="col-md-4 col-xs-4 col-sm-4 margin-top-20">
                    <input type="checkbox" name="data[MerchantStockTake][show_inactive]" value="1">
                    <label>Include inactive products</label>
                 </div>
                 <div class="solid-line-gr"></div>
                <div class="col-md-12 col-xs-12 col-sm-12">
                     <div class="col-md-3 col-xs-3 col-sm-3">
                        <input type="radio" name="data[MerchantStockTake][full_count]" value="0"><label>Partial Count</label>
                    </div>
                     <div class="col-md-3 col-xs-3 col-sm-3">
                        <input type="radio" name="data[MerchantStockTake][full_count]" value="1" ><label>Full Count</label>
                    </div>
                 </div>
                 <div class="line-box-stitle col-md-12 col-xs-12 col-sm-12 margin-top-20">
                  <div class="col-md-12 col-xs-12 col-sm-12">
                    <h5><strong>Partial Count List</strong></h5>
                    <h5>Create your list of items to count using suppliers, brands, types, tags, or SKUs. Combine multiple filters to narrow down your list.</h5>
                    <input type="text" class="margin-top-20" placeholder="Search for suppliers, brands, types, tags, or SKUs.">
                  </div>
                  <div class="col-md-12 col-xs-12 col-sm-12 margin-top-20">
                        <table id="productTable" class="table-bordered dataTable">
                            <colgroup>
                                <col width="100%">
                            </colgroup>
                            <thead>
                                <tr role="row">
                                    <th>Product</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>T-shirt (Demo)<h6>tshirt-white</h6></td>
                                </tr>
                            </tbody>
                        </table>
                  </div>
                </div>
            </div>
            <div class="col-md-12 margin-top-20 col-omega">
              <div class="pull-left">
                <button type="button" class="btn btn-default btn-wide cancel margin-right-10">Cancel</button>
              </div>
              <div class="pull-right">
                <button type="submit" class="btn btn-primary btn-wide cancel margin-right-10">Save</button>
                <button type="button" class="btn btn-success btn-wide addProduct">Start</button>
              </div>
            </div>
            </form>
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


    $(document).on('change', '.outlet', function() {
        var outlet = $('option:selected', $(this)).text();
        var count_name = '';

        if ( outlet != '' ) {
            //count_name = outlet + 
        }
    });
});
</script>
<!-- END JAVASCRIPTS -->
