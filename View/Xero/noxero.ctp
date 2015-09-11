<div class="clearfix"></div>
<div class="col-md-12 col-xs-12 col-sm-12 margin-bottom-20">
    <h2>You are not currently setup to use Xero as your accounts application.</h2>
</div>
<div class="section line">
    <div class="col-md-4 size1of4 unit extra-top-margin-20">
        <img class="xero" src="/img/xero-large.png" style="width:250px">
    </div>
    <div class="col-md-8 size3of4 unit extra-top-margin-30 standard-text">
        <p>To enable Xero as your accounts application, and to let your Vend account connect with and get data from your Xero account click the "continue" button below.</p>
        <div class="enable-xero">
            <a class="btn btn-default" href="/xero/enablexero">Enable Xero</a>      </div>
        <br>
        <p>If you are not a Xero user and would like to find out more about Xero, vist <a href="http://www.xero.com">www.xero.com</a> for more information about the world's easiest accounting software.</p>
    </div>
</div>
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
<script src="/theme/onzsa/assets/admin/pages/scripts/tasks.js" type="text/javascript"></script>
<script src="/js/notify.js" type="text/javascript"></script> 
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN COMMON INIT -->
<?php echo $this->element('common-init'); ?>
<!-- END COMMON INIT -->
<script>
jQuery(document).ready(function() {
    documentInit();
});

function documentInit() {
    // common init function
    commonInit();
}
</script> 
<!-- END JAVASCRIPTS -->
