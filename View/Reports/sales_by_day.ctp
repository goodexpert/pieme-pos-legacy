<link href="/css/dataTable.css" rel="stylesheet" type="text/css">
<div class="clearfix"></div>
<div id="notify"></div>
<!-- BEGIN CONTENT -->
<div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
    <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
        Sales Totals by Day
    </h2>

    <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20">
        <a href="#" id="export">
            <button class="btn btn-white pull-right">
                <div class="glyphicon glyphicon-export"></div>
                &nbsp;
                export
            </button>
        </a>
    </div>
</div>



<!-- FILTER -->
<form class="col-md-12 col-xs-12 col-sm-12 line-box filter-box" action="/reports/sales/sales_by_day" method="get">
    <div class="col-md-6 col-xs-6 col-sm-6">
        <dl>
            <dt>Date from</dt>
            <dd>
                <span class="glyphicon glyphicon-calendar icon-calendar"></span>
                <input type="text" id="date_from" name="from" value="<?php if (isset($_GET['from'])) {
                    echo $_GET['from'];
                } ?>">
            </dd>
        </dl>
    </div>
    <div class="col-md-6 col-xs-6 col-sm-6">
        <dl>
            <dt>Date to</dt>
            <dd>
                <span class="glyphicon glyphicon-calendar icon-calendar"></span>
                <input type="text" id="date_to" name="to" value="<?php if (isset($_GET['to'])) {
                    echo $_GET['to'];
                } ?>">
            </dd>
        </dl>
    </div>
    <div class="col-md-12 col-xs-12 col-sm-12">
        <button type="submit" class="btn btn-primary filter pull-right">Update</button>
    </div>
</form>

<!-- BEGIN CHART AREA -->
<!--<div class="row">-->
<!--    <div class="col-md-12 col-xs-12 col-sm-12 dashboard-area">-->
<!---->
        <!-- BEGIN PORTLET CHART 1 -->
<!--        <input type="hidden" id="sales-data" value='--><?php //echo json_encode($sales);?><!--'>-->
<!--        <div class="col-md-12 col-xs-12 col-sm-12 dashboard-warpper ">-->
<!--            <div class="portlet light bordered dashboard">-->
<!--                <div class="portlet-title">-->
<!--                    <div class="caption">-->
<!--                        <i class="fa fa-bar-chart"></i>Sales Totals by Day-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="portlet-body">-->
<!--                    <div id="chart_sales_day_loading"> <img src="/theme/metronic/assets/admin/layout/img/loading.gif" alt="loading"/> </div>-->
<!--                    <div id="chart_sales_day_content" class="display-none">-->
<!--                        <div id="chart_sales_day" class="chart" style="height: 228px;"> </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
        <!-- END PORTLET CHART 1 -->
<?php
//foreach ($sales as $key => $value) {
//    var_dump($key);
//    var_dump($value);
//    var_dump($value["salesIncl"]);
//    var_dump($value["tax"]);
//    var_dump($value["salesExc"]);
//    var_dump($value["cost"]);
//    var_dump($value["discounts"]);
//    var_dump($value["grossProfit"]);
//    var_dump($value["grossMargin"]);
//}
?>
<!--    </div>-->
<!--</div>-->
<!-- END CHART AREA -->

<div class="scroll-table-wide">
    <table id="productTable" class="table-bordered dataTable table-price">

        <thead>
        <tr>
            <th></th>
            <?php if (!empty($sales)) {
                foreach ($sales as $key => $value) { ?>
                    <th class="text-center" style="white-space:nowrap;"><?php echo $key; ?></th>
                <?php }
            } ?>
        </tr>
        </thead>
        <tbody>
            <?php if (count($sales) > 0) {
                $salesIncl = 0;
                $tax = 0;
                $salesExc = 0;
                $cost = 0;
                $discounts = 0;
            ?>
            <tr>
                <td  style="white-space:nowrap;">Sales incl. tax</td>
                <?php foreach ($sales as $key => $value) { ?>
                    <td class="text-right ">
                        $<?php echo number_format($value['salesIncl'], 2, '.', ','); ?>
                    </td>
                <?php } ?>
            </tr>
            <tr>
                <td style="white-space:nowrap;">Tax</td>
                <?php foreach ($sales as $key => $value) { ?>
                    <td class="text-right">
                        $<?php echo number_format($value['tax'], 2, '.', ','); ?>
                    </td>
                <?php } ?>
            </tr>
            <tr>
                <td style="white-space:nowrap;">Sales exc. tax</td>
                <?php foreach ($sales as $key => $value) { ?>
                    <td class="text-right">
                        $<?php echo number_format($value['salesExc'], 2, '.', ','); ?>
                    </td>
                <?php } ?>
            </tr>
            <tr>
                <td style="white-space:nowrap;">Cost of goods</td>
                <?php foreach ($sales as $key => $value) { ?>
                    <td class="text-right">
                       $<?php echo number_format($value['cost'], 2, '.', ','); ?>
                    </td>
                <?php } ?>
            </tr>
            <tr>
                <td style="white-space:nowrap;">Discounts</td>
                <?php foreach ($sales as $key => $value) { ?>
                    <td class="text-right">
                        $<?php echo number_format($value['discounts'], 2, '.', ','); ?>
                    </td>
                <?php } ?>
            </tr>
            <tr class="table-color">
                <td style="white-space:nowrap;">Gross Profit</td>
                <?php foreach ($sales as $key => $value) { ?>
                    <td class="text-right">
                        $<?php echo number_format($value['grossProfit'], 2, '.', ','); ?>
                    </td>
                <?php } ?>
            </tr>
            <tr class="table-color">
                <td style="white-space:nowrap;">Gross Margin</td>
                <?php foreach ($sales as $key => $value) { ?>
                    <td class="text-right">
                        <?php echo number_format($value['salesIncl'], 1, '.', '') . '%'; ?>
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
<!-- END CONTENT -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<!-- BEGIN CORE PLUGINS -->
<?php echo $this->element('script-jquery'); ?>
<?php echo $this->element('script-angularjs'); ?>
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
<script src="/theme/onzsa/assets/admin/pages/scripts/dashboard_charts.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<?php echo $this->element('common-init'); ?>
<script>
jQuery(document).ready(function() {
    documentInit();
});

function documentInit() {
    // common init function
    commonInit();
    
    $("#date_from").datepicker({ dateFormat: 'yy-mm-dd' });
    $("#date_to").datepicker({ dateFormat: 'yy-mm-dd' });


    // page init function
    var sales_data = JSON.parse($("#sales-data").val());

    DashboardCharts.initSalesDayChart(sales_data);
}
</script>
