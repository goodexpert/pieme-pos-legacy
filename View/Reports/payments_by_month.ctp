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
                    Payment Types by Month
                </h2>
                <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20">
                    <a href="#" id="export"><button class="btn btn-white pull-right">
                        <div class="glyphicon glyphicon-export"></div>&nbsp;
                    export</button></a>
                </div>
            </div>
                
            <!-- FILTER -->
            <div class="col-md-12 col-xs-12 col-sm-12 line-box filter-box">
                <div class="col-md-4 col-xs-6 col-sm-6">
                    <dl>
                        <dt>Start month</dt> 
                        <dd>
                            <select>
                            <option value="1">January</option>
                            <option value="2" selected="selected">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                            </select>
                        </dd>
                    </dl> 
                </div>
                <div class="col-md-4 col-xs-6 col-sm-6">
                    <dl>
                        <dt>Year</dt> 
                        <dd>
                            <select>
                            <option value="2015" selected="selected">2015</option>
                            <option value="2014">2014</option>
                            <option value="2013">2013</option>
                            <option value="2012">2012</option>
                            <option value="2011">2011</option>
                            <option value="2010">2010</option>
                            </select>
                        </dd>
                    </dl>
                 </div>
                <div class="col-md-4 col-xs-6 col-sm-6">
                    <dl>
                        <dt>Periods</dt>
                        <dd>
                            <select>
                            <option value="1">1 Month</option>
                            <option value="2">2 Months</option>
                            <option value="3">3 Months</option>
                            <option value="4">4 Months</option>
                            <option value="5">5 Months</option>
                            <option value="6">6 Months</option>
                            <option value="7">7 Months</option>
                            <option value="8">8 Months</option>
                            <option value="9">9 Months</option>
                            <option value="10">10 Months</option>
                            <option value="11">11 Months</option>
                            <option value="12" selected="selected">12 Months</option>
                            </select>
                        </dd>
                    </dl>
                 </div>
                 <div class="col-md-12 col-xs-12 col-sm-12">
                     <button class="btn btn-primary filter pull-right">Update</button>
                 </div>
            </div>
                    <div class="col-md-3 col-omega">
                        <table class="table-bordered dataTable">
                            <colgroup>
                                <col width="15%">
                            </colgroup>
                            <thead>
                            <tr>
                                <th class="first-child">Payment Type</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="first-child">Cash ($) </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
        <div class="col-md-9 col-alpha">
            <div class="scroll-table">
                <table class="table-bordered dataTable">
                        <colgroup>
                        <col width="8%">
                        <col width="8%">
                        <col width="8%">
                        <col width="8%">
                        <col width="8%">
                        <col width="8%">
                        <col width="8%">
                        <col width="8%">
                        <col width="8%">
                        <col width="8%">
                        <col width="8%">
                        <col width="8%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>March</th>
                            <th>February</th>
                            <th>January</th>
                            <th>December</th>
                            <th>November</th>
                            <th>October</th>
                            <th>September</th>
                            <th>August</th>
                            <th>July</th>
                            <th>June</th>
                            <th>May</th>
                            <th>April</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td> -</td>
                                <td> -</td>
                                <td> -</td>
                                <td> -</td>
                                <td> -</td>
                                <td> -</td>
                                <td> -</td>
                                <td> -</td>
                                <td> -</td>
                                <td> -</td>
                                <td> -</td>
                                <td> -</td>
                            </tr>
                        </tbody>
                    </table>
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
<script src="/js/dataTable.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    QuickSidebar.init(); // init quick sidebar
    Index.init();
    
    $("#date_from").datepicker();
});
</script>