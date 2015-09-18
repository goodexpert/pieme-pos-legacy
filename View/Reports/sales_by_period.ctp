<link href="/css/dataTable.css" rel="stylesheet" type="text/css">
<div class="clearfix"></div>
<div id="notify"></div>
<!-- BEGIN CONTENT -->
<div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
    <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
        Sales Totals by Period
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
<form class="col-md-12 col-xs-12 col-sm-12 line-box filter-box" action="/reports/sales/sales_by_period" method="get">
    <div class="col-md-4 col-xs-6 col-sm-6">
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
    <div class="col-md-4 col-xs-6 col-sm-6">
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
    <div class="col-md-4 col-xs-6 col-sm-6">
        <dl>
            <dt>Compare to the last</dt>
            <dd>
                <select name="period">
                    <?php for ($i = 1; $i <= 12; $i++) { ?>
                        <option value="<?php echo $i; ?>"
                          <?php if (isset($_GET['period']) && $_GET['period'] == $i) { echo "selected";} ?>>
                          <?php echo $i; ?> <?php if ($i == 1) { echo 'Period'; } else { echo 'Periods'; } ?>
                        </option>
                    <?php } ?>
                </select>
            </dd>
        </dl>
    </div>
    <div class="col-md-12 col-xs-6 col-sm-6">
        <button type="submit" class="btn btn-primary filter pull-right">Update</button>
    </div>
</form>

<table id="productTable" class="table-bordered dataTable table-price">
    <thead>
    <tr>
        <th>&nbsp;</th>
        <?php if (isset($_GET['from'])) {
            $dateRangeFrom = date('M d', strtotime($_GET['from']));
            $dateRangeTo = date('M d', strtotime($_GET['to']));
            foreach ($sales as $date => $sale) {
                $from = date("M d", strtotime(explode("~", $date)[0]));
                $to = date("M d", strtotime(explode("~", $date)[1])); ?>

                <th class="text-right">
                    <?php echo $from . ' - ' . $to; ?>
                </th>
            <?php }
        } ?>
    </tr>
    </thead>
    <tbody>
    <?php if (isset($_GET['from'])) { ?>
        <tr>
            <td>Sales incl. tax ($)</td>
            <?php foreach ($sales as $sale) {
                $salesIncl = 0;
                foreach ($sale as $data) {
                    $salesIncl += $data['RegisterSale']['total_price_incl_tax'];
                } ?>
                <td class="text-right">
                    <?php echo number_format($salesIncl, 2, '.', ','); ?>
                </td>
            <?php } ?>
        </tr>
        <tr>
            <td>Tax ($)</td>
            <?php foreach ($sales as $sale) {
                $tax = 0;
                foreach ($sale as $data) {
                    $tax += $data['RegisterSale']['total_tax'];
                } ?>
                <td class="text-right">
                    <?php echo number_format($tax, 2, '.', ','); ?>
                </td>
            <?php } ?>
        </tr>
        <tr>
            <td>Sales exc. tax ($)</td>
            <?php foreach ($sales as $sale) {
                $salesExc = 0;
                foreach ($sale as $data) {
                    $salesExc += $data['RegisterSale']['total_price'];
                } ?>
                <td class="text-right">
                    <?php echo number_format($salesExc, 2, '.', ','); ?>
                </td>
            <?php } ?>
        </tr>
        <tr>
            <td>Cost of goods ($)</td>
            <?php foreach ($sales as $sale) {
                $cost = 0;
                foreach ($sale as $data) {
                    $cost += $data['RegisterSale']['total_cost'];
                } ?>
                <td class="text-right">
                    <?php echo number_format($cost, 2, '.', ','); ?>
                </td>
            <?php } ?>
        </tr>
        <tr>
            <td>Discounts ($)</td>
            <?php foreach ($sales as $sale) {
                $discount = 0;
                foreach ($sale as $data) {
                    $discount += $data['RegisterSale']['total_discount'];
                } ?>
                <td class="text-right">
                    <?php echo number_format($discount, 2, '.', ','); ?>
                </td>
            <?php } ?>
        </tr>
        <tr class="table-color">
            <td>Gross Profit ($)</td>
            <?php foreach ($sales as $sale) {
                $salesExc = 0;
                $cost = 0;
                foreach ($sale as $data) {
                    $salesExc += $data['RegisterSale']['total_price'];
                    $cost += $data['RegisterSale']['total_cost'];
                } ?>
                <td class="text-right">
                    <?php echo number_format($salesExc - $cost, 2, '.', ','); ?>
                </td>
            <?php } ?>
        </tr>
        <tr class="table-color">
            <td>Gross Margin</td>
            <?php foreach ($sales as $sale) {
                $salesExc = 0;
                $cost = 0;
                foreach ($sale as $data) {
                    $salesExc += $data['RegisterSale']['total_price'];
                    $cost += $data['RegisterSale']['total_cost'];
                } ?>
                <td class="text-right">
                    <?php if ($salesExc > 0) {
                        echo number_format(($salesExc - $cost) / $salesExc * 100, 2, '.', ',') . '%';
                    } else {
                        echo '0%';
                    } ?>
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
}
</script>
