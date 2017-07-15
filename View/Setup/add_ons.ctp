<?php
$user = $this->Session->read('Auth.User');
$xero_auth_token = null;
$shopify_auth_token = null;

if (isset($user['Addons']['xero_auth_token'])) {
  $xero_auth_token = $user['Addons']['xero_auth_token'];
}

if (isset($user['Addons']['shopify_auth_token'])) {
  $shopify_auth_token = $user['Addons']['shopify_auth_token'];
}
?>
<link href="/css/dataTable.css" rel="stylesheet" type="text/css">
<div class="clearfix"></div>
<div id="notify"></div>
<!-- BEGIN CONTENT -->
<div class="col-md-12 col-xs-12 col-sm-12 margin-bottom-20">
  <h2>
    Add-ons
  </h2>
  <h5>PieMe integrates with other business and productivity apps to help you streamline your business.</h5>
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

        <p>PieMe integrates seamlessly with the Xero accounting software to share customers, product sales, and
          invoices.</p>
      </div>
      <?php if (empty($xero_auth_token)) : ?>
        <a href="/xero/noxero" class="btn btn-default"><span class="glyphicon glyphicon-plus margin-right-5"></span>Add
          to PieMe</a>
      <?php else : ?>
        <a href="/setup/xero" class="btn btn-default"><span class="glyphicon glyphicon-cog margin-right-5"></span>Setting</a>
      <?php endif; ?>
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
      <?php if (empty($shopify_auth_token)) : ?>
        <a href="#" class="btn btn-default"><span class="glyphicon glyphicon-plus margin-right-5"></span>Add to
          PieMe</a>
      <?php else : ?>
        <a href="#" class="btn btn-default"><span class="glyphicon glyphicon-cog margin-right-5"></span>Setting</a>
      <?php endif; ?>
    </div>
  </div>
  <!-- END CONTENT -->
</div>
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<?php echo $this->element('script-jquery'); ?>
<?php echo $this->element('script-angularjs'); ?>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js"
        type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js"
        type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js"
        type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js"
        type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js"
        type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/bootstrap-daterangepicker/moment.min.js"
        type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js"
        type="text/javascript"></script>
<!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
<script src="/theme/onzsa/assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.min.js"
        type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js"
        type="text/javascript"></script>
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
<!-- BEGIN COMMON INIT -->
<?php echo $this->element('common-init'); ?>
<!-- END COMMON INIT -->
<script>
  jQuery(document).ready(function () {
    documentInit();
   };

  function documentInit() {
    // common init function
    commonInit();
  }
  ;
</script>
<!-- END JAVASCRIPTS -->
