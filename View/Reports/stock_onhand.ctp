<link href="/css/dataTable.css" rel="stylesheet" type="text/css">
<div class="clearfix"></div>
<div id="notify"></div>
<!-- BEGIN CONTENT -->
<div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
    <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
        Stock On Hand
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
<div class="col-md-12 col-xs-12 col-sm-12 line-box filter-box">
    <div class="col-md-4 col-xs-6 col-sm-6">
        <dl>
            <dt>Group by handle</dt>
            <dd>
                <select>
                    <option selected>by variant</option>
                    <option>by handle</option>
                </select>
            </dd>
        </dl>
    </div>
    <div class="col-md-4 col-xs-6 col-sm-6">
        <dl>
            <dt>Name / SKU / Handle</dt>
            <dd>
                <input type="text">
            </dd>
        </dl>
    </div>
    <div class="col-md-4 col-xs-6 col-sm-6">
        <dl>
            <dt>Product type</dt>
            <dd>
                <select>
                    <option></option>
                </select>
            </dd>
        </dl>
    </div>
    <div class="col-md-4 col-xs-6 col-sm-6">
        <dl>
            <dt>Brand</dt>
            <dd>
                <select>
                    <option></option>
                </select>
            </dd>
        </dl>
    </div>
    <div class="col-md-4 col-xs-6 col-sm-6">
        <dl>
            <dt>Supplier</dt>
            <dd>
                <select>
                    <option></option>
                </select>
            </dd>
        </dl>
    </div>
    <div class="col-md-4 col-xs-6 col-sm-6">
        <dl>
            <dt>Outlet</dt>
            <dd>
                <select>
                    <option></option>
                </select>
            </dd>
        </dl>
    </div>
    <div class="col-md-4 col-xs-6 col-sm-6">
        <dl>
            <dt>Tag</dt>
            <dd>
                <input type="text">
            </dd>
        </dl>
    </div>
    <div class="col-md-12 col-xs-12 col-sm-12">
        <button class="btn btn-primary filter pull-right">Update</button>
    </div>
</div>

<table class="table-bordered dataTable table-price">
    <colgroup>
        <col width="">
        <col width="15%">
        <col width="10%">
        <col width="7%">
        <col width="13%">
        <col width="13%">
        <col width="13%">
    </colgroup>
    <thead>
    <tr>
        <th>Product</th>
        <th>SKU</th>
        <th>Outlet</th>
        <th class="text-right">Count</th>
        <th class="text-right">Value</th>
        <th class="text-right">Avg. Item Value</th>
        <th class="text-right">Recorder pointe</th>
    </tr>
    </thead>
    <tbody>
    <tr class="table-color">
        <td><strong>TOTAL</strong></td>
        <td></td>
        <td></td>
        <td class="text-right"><strong>50</strong></td>
        <td class="text-right"><strong>$64.35</strong></td>
        <td class="text-right"><strong>$0.00.35</strong></td>
        <td class="text-right"><strong>0</strong></td>
    </tr>
    <tr>
        <td>Coffee</td>
        <td>Coffee-hot</td>
        <td>Main Outlet</td>
        <td class="text-right">21</td>
        <td class="text-right">$64.35</td>
        <td class="text-right">$0.00.35</td>
        <td class="text-right">0</td>
    </tr>
    <tr>
        <td>Coffee</td>
        <td>Coffee-hot</td>
        <td>Main Outlet</td>
        <td class="text-right">21</td>
        <td class="text-right">$64.35</td>
        <td class="text-right">$0.00.35</td>
        <td class="text-right">0</td>
    </tr>
    <tr>
        <td>Coffee</td>
        <td>Coffee-hot</td>
        <td>Main Outlet</td>
        <td class="text-right">21</td>
        <td class="text-right">$64.35</td>
        <td class="text-right">$0.00.35</td>
        <td class="text-right">0</td>
    </tr>
    <tr>
        <td>Coffee</td>
        <td>Coffee-hot</td>
        <td>Main Outlet</td>
        <td class="text-right">21</td>
        <td class="text-right">$64.35</td>
        <td class="text-right">$0.00.35</td>
        <td class="text-right">0</td>
    </tr>
    <tr>
        <td>Coffee</td>
        <td>Coffee-hot</td>
        <td>Main Outlet</td>
        <td class="text-right">21</td>
        <td class="text-right">$64.35</td>
        <td class="text-right">$0.00.35</td>
        <td class="text-right">0</td>
    </tr>
    <tr class="table-color">
        <td><strong>TOTAL</strong></td>
        <td></td>
        <td></td>
        <td class="text-right"><strong>50</strong></td>
        <td class="text-right"><strong>$64.35</strong></td>
        <td class="text-right"><strong>$0.00.35</strong></td>
        <td class="text-right"><strong>0</strong></td>
    </tr>
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
    
    $("#date_from").datepicker();
    $("#date_to").datepicker();
}
</script>
