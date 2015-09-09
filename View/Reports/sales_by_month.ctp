<link href="/css/dataTable.css" rel="stylesheet" type="text/css">
<div class="clearfix"></div>
<div id="notify"></div>
<!-- BEGIN CONTENT -->
<div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
    <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
        Sales Totals by Month
    </h2>
    <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20">
        <a href="#" id="export"><button class="btn btn-white pull-right">
            <div class="glyphicon glyphicon-export"></div>&nbsp;
        export</button></a>
    </div>
</div>

<!-- FILTER -->
<form class="col-md-12 col-xs-12 col-sm-12 line-box filter-box" action="/reports/sales/sales_by_month" method="get">
    <div class="col-md-4 col-xs-6 col-sm-6">
        <dl>
            <dt>Start month</dt>
            <dd>
                <select name="month">
                    <option value="1" <?php if(isset($_GET['month']) && $_GET['month'] == '1'){echo "selected";}?>>January</option>
                    <option value="2" <?php if(isset($_GET['month']) && $_GET['month'] == '2'){echo "selected";}?>>February</option>
                    <option value="3" <?php if(isset($_GET['month']) && $_GET['month'] == '3'){echo "selected";}?>>March</option>
                    <option value="4" <?php if(isset($_GET['month']) && $_GET['month'] == '4'){echo "selected";}?>>April</option>
                    <option value="5" <?php if(isset($_GET['month']) && $_GET['month'] == '5'){echo "selected";}?>>May</option>
                    <option value="6" <?php if(isset($_GET['month']) && $_GET['month'] == '6'){echo "selected";}?>>June</option>
                    <option value="7" <?php if(isset($_GET['month']) && $_GET['month'] == '7'){echo "selected";}?>>July</option>
                    <option value="8" <?php if(isset($_GET['month']) && $_GET['month'] == '8'){echo "selected";}?>>August</option>
                    <option value="9" <?php if(isset($_GET['month']) && $_GET['month'] == '9'){echo "selected";}?>>September</option>
                    <option value="10" <?php if(isset($_GET['month']) && $_GET['month'] == '10'){echo "selected";}?>>October</option>
                    <option value="11" <?php if(isset($_GET['month']) && $_GET['month'] == '11'){echo "selected";}?>>November</option>
                    <option value="12" <?php if(isset($_GET['month']) && $_GET['month'] == '12'){echo "selected";}?>>December</option>
                </select>
            </dd>
        </dl>
    </div>
    <div class="col-md-4 col-xs-6 col-sm-6">
        <dl>
            <dt>Year</dt>
            <dd>
                <select name="year">
                    <option value="2015">2015</option>
                </select>
            </dd>
        </dl>
     </div>
    <div class="col-md-4 col-xs-6 col-sm-6">
        <dl>
            <dt>Compare to the last</dt>
            <dd>
                <select name="period">
                    <?php for($i = 1;$i <= 12;$i++){ ?>
                    <option value="<?php echo $i;?>" <?php if(isset($_GET['period']) && $_GET['period'] == $i){echo "selected";}?>><?php echo $i;?> Period</option>
                    <?php } ?>
                </select>
            </dd>
        </dl>
     </div>
     <div class="col-md-12 col-xs-12 col-sm-12">
         <button type="submit" class="btn btn-primary filter pull-right">Update</button>
     </div>
</form>
<table id="productTable" class="table-bordered dataTable table-price">
    <thead>
    <tr>
        <th>&nbsp;</th>
        <?php if(isset($_GET['period'])) {
            foreach($sales as $key => $value) {
                $month = date('M', strtotime('2015-'.$key));?>
                <th class="text-right">
                    <?php echo $month;?>
                </th>
            <?php }
        }?>
    </tr>
    </thead>
    <tbody>
        <?php if(isset($_GET['period'])) {
            $salesIncl = 0;
            $tax = 0;
            $salesExc = 0;
            $cost = 0;
            $discounts = 0; ?>
            <tr>
                <td>Sales incl. tax ($)</td>
                <?php foreach($sales as $sale){
                    if(!empty($sale)) {
                        foreach($sale as $data) {
                            $salesIncl += $data['RegisterSale']['total_price_incl_tax'];
                        }
                    }?>
                    <td class="text-right">
                        <?php echo number_format($salesIncl,2,'.',',');?>
                    </td>
                <?php $salesIncl = 0; } ?>
            </tr>
            <tr>
                <td>Tax ($)</td>
                <?php foreach($sales as $sale){
                    if(!empty($sale)) {
                        foreach($sale as $data) {
                            $tax += $data['RegisterSale']['total_tax'];
                        }
                    }?>
                    <td class="text-right">
                        <?php echo number_format($tax,2,',','.');?>
                    </td>
                <?php $tax = 0; } ?>
            </tr>
            <tr>
                <td>Sales exc. tax ($)</td>
                <?php foreach($sales as $sale){
                    if(!empty($sale)) {
                        foreach($sale as $data) {
                            $salesExc += $data['RegisterSale']['total_price'];
                        }
                    }?>
                    <td class="text-right">
                        <?php echo number_format($salesExc,2,'.',',');?>
                    </td>
                <?php $salesExc = 0; } ?>
            </tr>
            <tr>
                <td>Cost of goods ($)</td>
                <?php foreach($sales as $sale){
                    if(!empty($sale)) {
                        foreach($sale as $data) {
                            $cost += $data['RegisterSale']['total_cost'];
                        }
                    }?>
                    <td class="text-right">
                        <?php echo number_format($cost,2,'.',',');?>
                    </td>
                <?php $cost = 0; } ?>
            </tr>
            <tr>
                <td>Discounts ($)</td>
                <?php foreach($sales as $sale){
                    if(!empty($sale)) {
                        foreach($sale as $data) {
                            $discounts += $data['RegisterSale']['total_discount'];
                        }
                    }?>
                    <td class="text-right">
                        <?php echo number_format($discounts,2,'.',',');?>
                    </td>
                <?php $discounts = 0; } ?>
            </tr>
            <tr class="table-color">
                <td>Gross Profit ($)</td>
                <?php foreach($sales as $sale){
                    if(!empty($sale)) {
                        foreach($sale as $data) {
                            $salesExc += $data['RegisterSale']['total_price'];
                            $cost += $data['RegisterSale']['total_cost'];
                        }
                    }?>
                    <td class="text-right">
                        <?php echo number_format($salesExc - $cost,2,'.',',');?>
                    </td>
                <?php $salesExc = 0; $cost = 0; } ?>
            </tr>
            <tr class="table-color">
                <td>Gross Margin</td>
                <?php foreach($sales as $sale){
                    if(!empty($sale)) {
                        foreach($sale as $data) {
                            $salesExc += $data['RegisterSale']['total_price'];
                            $cost += $data['RegisterSale']['total_cost'];
                        }
                    }?>
                    <td class="text-right">
                        <?php if($salesExc > 0){echo number_format(($salesExc - $cost) / $salesExc * 100,1,'.','').'%';} else {echo "0%";}?>
                    </td>
                <?php $salesExc = 0; $cost = 0; } ?>
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
}
</script>
