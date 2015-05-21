<link href="/css/dataTable.css" rel="stylesheet" type="text/css">
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
            <div class="col-md-12 col-xs-12 col-sm-12 margin-bottom-20">
                <h2>
                    Add-ons
                </h2>
                <h5>Onzsa integrates with other business and productivity apps to help you streamline your business.</h5>
            </div>
            <div class="col-xs-12 margin-bottom-20">
                <div class="bg-gr inline-block">
                    <h4 class="pull-left">Connected third-party add-ons</h4>
                    <button class="btn btn-white pull-right">Revoke</button>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-xs-12 col-sm-12 addons">
                <div class="col-xs-12 col-alpha col-omega line-box">
                    <div class="padding-20">
                        <div class="col-md-4 col-xs-4 col-sm-4 text-center line-box-brand">
                            <img src="/img/xero.png">
                        </div>
                        <div class="col-md-8 col-xs-8 col-sm-8">
                            <h3 class="no-margin">Xero</h3>
                            <p>Onzsa integrates seamlessly with the Xero accounting software to share customers, product sales, and invoices.</p>
                        </div>
                        <button class="btn btn-default"><span class="glyphicon glyphicon-plus margin-right-5"></span>Add to Onzsa</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-xs-12 col-sm-12 addons">
                <div class="col-xs-12 col-alpha col-omega line-box">
                    <div class="opacity-bk"></div>
                    <div class="padding-20">
                        <div class="col-md-4 col-xs-4 col-sm-4 col-alpha text-center line-box-brand">
                            <img src="/img/shopify.png">
                        </div>
                        <div class="col-md-8 col-xs-8 col-sm-8">
                            <h3 class="no-margin">Shopify</h3>
                            <p>Create an online store with Shopify.</p>
                        </div>
                        <button class="btn btn-default"><span class="glyphicon glyphicon-cog margin-right-5"></span>Setting</button>
                    </div>
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
<script src="/js/notify.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {    
   Metronic.init(); // init metronic core componets
   Layout.init(); // init layout
   Index.init();
});
</script>
<!-- END JAVASCRIPTS -->
