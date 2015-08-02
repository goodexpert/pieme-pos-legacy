<style>
.receipt-parent {
    position: absolute;
    top: 40px;
    z-index: 20000;
    display: none;
}

.search_result {
    position: absolute;
    z-index: 50;
}

.payment-display li ul li {
    display: inline;
}

.payment-display .total_cost {
    border-top: 1px solid white;
}
</style>
<div class="clearfix"></div>
<div class="container">
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content" id="sell-index">
            <input type="hidden" id="discount_auth" value="0">
            <div class="sales-screen-tabs" id="tabs">
                <ul class="margin-top-30 tab-menu-wrapper">
                    <li><a href="#tabs-current-sale">CURRENT SALE</a></li>
                    <li><a href="#tabs-retrieve-sale">RECALL SALE</a></li>
                    <li><a href="#tabs-close-sale">CLOSE_REGISTER</a></li>
                    <li><a href="#tabs-table-sale">TABLE</a></li>
                </ul>
                <div id="tabs-current-sale">
                    <?php echo $this->element('sales/current-sale'); ?>
                </div>
                <div id="tabs-retrieve-sale">
                    <?php echo $this->element('sales/recall-sale'); ?>
                </div>
                <div id="tabs-close-sale">
                    <?php echo $this->element('sales/close-sale'); ?>
                </div>
                <div id="tabs-table-sale">
                    <?php echo $this->element('sales/table-sale'); ?>
                </div>
                <div class="page-footer-inner col-lg-12 col-md-12 col-sm-12 col-xs-12 col-alpha col-omega">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="pull-left col-lg-6 col-md-6 col-sm-6 col-xs-6 col-omega col-alpha margin-top-20">
                            <img src="/img/ONZSA_logo-gr.png" alt="logo-gr">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-omega col-alpha footer-status margin-top-20">
                            <button class="btn btn-default pull-right"><span class="status-online"></span>Online </button>
                            <p class="pull-right">Main register</p>
                        </div>
                    </div>
                </div>
            </div>
<!--
            <div class="maximum">
                <ul class="tab-menu-wrapper col-md-12 col-xs-12 col-sm-12 col-alpha col-omega margin-top-30">
                    <li class="current_open active">CURRENT SALE</li>
                    <li class="retrieve_open">RECALL SALE</li>
                    <li class="close_open">CLOSE REGISTER</li>
                    <li class="table_open">TABLE</li>
                </ul>
                <input type="hidden" id="retrieve_sale_id">
                <div class="tab-content-wrapper col-md-12 col-xs-12 col-alpha col-omega">
                    <div id="current-sale"></div>
                    <div class="tab_display"></div>
                    <div class="page-footer-inner col-lg-12 col-md-12 col-sm-12 col-xs-12 col-alpha col-omega">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="pull-left col-lg-6 col-md-6 col-sm-6 col-xs-6 col-omega col-alpha margin-top-20">
                                <img src="/img/ONZSA_logo-gr.png" alt="logo-gr">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-omega col-alpha footer-status margin-top-20">
                                <button class="btn btn-default pull-right"><span class="status-online"></span>Online </button>
                                <p class="pull-right">Main register</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
-->
        </div>
    </div>
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
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/theme/onzsa/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="/js/jquery.jqprint-0.3.js" type="text/javascript"></script>
<script src="/js/dataTable.js" type="text/javascript"></script>
<script src="/js/dpsclient.js" type="text/javascript"></script>
<script src="/js/jxon.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function () {
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    Register.init();

    init();
});

function init() {
    $( "#tabs" ).tabs();
}

function selectTab(index) {
}
</script>
