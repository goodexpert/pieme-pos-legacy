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
            <form class="col-md-12 col-xs-12 col-sm-12 line-box filter-box" action="/reports/sales/payments_by_month" method="get">
                <div class="col-md-4 col-xs-6 col-sm-6">
                    <dl>
                        <dt>Start month</dt> 
                        <dd>
                            <select name="month">
                                <option value="1" <?php if(isset($_GET['month']) && $_GET['month'] == 1){echo "selected";}?>>January</option>
                                <option value="2" <?php if(isset($_GET['month']) && $_GET['month'] == 2){echo "selected";}?>>February</option>
                                <option value="3" <?php if(isset($_GET['month']) && $_GET['month'] == 3){echo "selected";}?>>March</option>
                                <option value="4" <?php if(isset($_GET['month']) && $_GET['month'] == 4){echo "selected";}?>>April</option>
                                <option value="5" <?php if(isset($_GET['month']) && $_GET['month'] == 5){echo "selected";}?>>May</option>
                                <option value="6" <?php if(isset($_GET['month']) && $_GET['month'] == 6){echo "selected";}?>>June</option>
                                <option value="7" <?php if(isset($_GET['month']) && $_GET['month'] == 7){echo "selected";}?>>July</option>
                                <option value="8" <?php if(isset($_GET['month']) && $_GET['month'] == 8){echo "selected";}?>>August</option>
                                <option value="9" <?php if(isset($_GET['month']) && $_GET['month'] == 9){echo "selected";}?>>September</option>
                                <option value="10" <?php if(isset($_GET['month']) && $_GET['month'] == 10){echo "selected";}?>>October</option>
                                <option value="11" <?php if(isset($_GET['month']) && $_GET['month'] == 11){echo "selected";}?>>November</option>
                                <option value="12" <?php if(isset($_GET['month']) && $_GET['month'] == 12){echo "selected";}?>>December</option>
                            </select>
                        </dd>
                    </dl> 
                </div>
                <div class="col-md-4 col-xs-6 col-sm-6">
                    <dl>
                        <dt>Year</dt> 
                        <dd>
                            <select name="year">
                                <option value="2015" <?php if(isset($_GET['year']) && $_GET['year'] == 2015){echo "selected";}?>>2015</option>
                            </select>
                        </dd>
                    </dl>
                 </div>
                <div class="col-md-4 col-xs-6 col-sm-6">
                    <dl>
                        <dt>Periods</dt>
                        <dd>
                            <select name="period">
                                <option value="1" <?php if(isset($_GET['period']) && $_GET['period'] == 1){echo "selected";}?>>1 Month</option>
                                <option value="2" <?php if(isset($_GET['period']) && $_GET['period'] == 2){echo "selected";}?>>2 Months</option>
                                <option value="3" <?php if(isset($_GET['period']) && $_GET['period'] == 3){echo "selected";}?>>3 Months</option>
                                <option value="4" <?php if(isset($_GET['period']) && $_GET['period'] == 4){echo "selected";}?>>4 Months</option>
                                <option value="5" <?php if(isset($_GET['period']) && $_GET['period'] == 5){echo "selected";}?>>5 Months</option>
                                <option value="6" <?php if(isset($_GET['period']) && $_GET['period'] == 6){echo "selected";}?>>6 Months</option>
                                <option value="7" <?php if(isset($_GET['period']) && $_GET['period'] == 7){echo "selected";}?>>7 Months</option>
                                <option value="8" <?php if(isset($_GET['period']) && $_GET['period'] == 8){echo "selected";}?>>8 Months</option>
                                <option value="9" <?php if(isset($_GET['period']) && $_GET['period'] == 9){echo "selected";}?>>9 Months</option>
                                <option value="10" <?php if(isset($_GET['period']) && $_GET['period'] == 10){echo "selected";}?>>10 Months</option>
                                <option value="11" <?php if(isset($_GET['period']) && $_GET['period'] == 11){echo "selected";}?>>11 Months</option>
                                <option value="12" <?php if(isset($_GET['period']) && $_GET['period'] == 12){echo "selected";}?>>12 Months</option>
                            </select>
                        </dd>
                    </dl>
                 </div>
                 <div class="col-md-12 col-xs-12 col-sm-12">
                     <button type="submit" class="btn btn-primary filter pull-right">Update</button>
                 </div>
            </form>
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
                                <?php if(!empty($sales)) {
                                    foreach($sales as $paymentType => $sale) {?>
                                    <tr>
                                        <td class="first-child"><?php echo $paymentType;?> ($) </td>
                                    </tr>
                                    <?php }
                                } else {?>
                                    <tr>
                                        <td>&nbsp;</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
        <div class="col-md-9 col-alpha">
            <div class="scroll-table">
                <table class="table-bordered dataTable">
                    <thead>
                        <tr>
                            <?php if(!empty($sales)) {
                                foreach($sales as $sale) {
                                    foreach($sale as $month => $data) {?>
                                    <th><?php echo date("M",strtotime('2015-'.$month));?></th>
                                <?php }break;}
                            } else { ?>
                                <th>&nbsp;</th>
                            <?php } ?>
                        </tr>
                    </thead>
                        <tbody>
                            <?php if(!empty($sales)) {
                                foreach($sales as $sale) { ?>
                                    <tr>
                                    <?php foreach($sale as $data) { ?>
                                        <td>
                                        <?php
                                        if(empty($data)){
                                            echo " -";
                                        } else {
                                            $amount = 0;
                                            foreach($data as $price) {
                                                $amount += $price['RegisterSalePayment']['amount'];
                                            }
                                            echo number_format($amount,2,'.',',');
                                        }?>
                                        </td>
                                    <?php } ?>
                                    </tr>
                                <?php }
                            } else {?>
                                <tr>
                                    <td>Select your criteria above to update the table.</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
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
    
    $("#date_from").datepicker();
});
</script>
