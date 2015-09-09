<link href="/css/dataTable.css" rel="stylesheet" type="text/css">
<div class="clearfix"></div>
<div id="notify"></div>
<!-- BEGIN CONTENT -->

<div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega margin-bottom-20">
  <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
    Cash
  </h2>
</div>
<div class="col-md-12 col-xs-12 col-sm-12 form-title">Detail</div>
<input type="hidden" value="<?php echo $payment['PaymentType']['id']; ?>" id="target_id">
<div class="line-box line-box-content col-md-12 col-sm-12 col-xs-12">
  <div class="col-md-6">
    <dl>
      <dt>Payment type</dt>
      <dd><?php echo $payment['PaymentType']['name']; ?></dd>
      <dt>Name</dt>
      <dd>
        <input type="text" value="<?php echo $payment['MerchantPaymentType']['name']; ?>" id="payment_name">
      </dd>
      <dt>Gateway (optional)</dt>
      <dd class="explain">
        <input type="text">
      </dd>
    </dl>
  </div>
  <div class="col-md-6">

  </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 pull-right margin-top-20 margin-bottom-20">
  <button class="btn btn-primary btn-wide pull-right edit">Save</button>
  <button class="btn btn-default btn-wide pull-right margin-right-10 delete">Delete</button>
  <button class="btn btn-default btn-wide pull-right margin-right-10">Cancel</button>
</div>
<!-- END CONTENT -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<?php echo $this->element('script-jquery'); ?>
<?php echo $this->element('script-angularjs'); ?>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js"></script>
<script src="/theme/onzsa/assets/global/plugins/flot/jquery.flot.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/flot/jquery.flot.resize.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/flot/jquery.flot.categories.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jquery.pulsate.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/bootstrap-daterangepicker/moment.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
<script src="/theme/onzsa/assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jquery.sparkline.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/gritter/js/jquery.gritter.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/theme/onzsa/assets/global/scripts/metronic.js"></script>
<script src="/theme/onzsa/assets/admin/layout/scripts/layout.js"></script>
<script src="/theme/onzsa/assets/admin/pages/scripts/index.js"></script>
<script src="/theme/onzsa/assets/admin/pages/scripts/tasks.js"></script>
<script src="/js/notify.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN COMMON INIT -->
<?php echo $this->element('common-init'); ?>
<!-- END COMMON INIT -->
<script>
  jQuery(document).ready(function () {
    documentInit();
  });

  function documentInit() {
    // common init function
    commonInit();

    $(".edit").click(function () {
      $.ajax({
        url: window.location,
        type: 'PUT',
        data: {
          name: $("#payment_name").val()
        }
      });
      window.location.href = "/setup/payments";
    });
    $(".delete").click(function () {
      $.ajax({
        url: '/payments/' + window.location.pathname.split("/")[2] + '/delete',
        type: 'DELETE'
      });
      window.location.href = "/setup/payments";
    });
  }
  ;
</script>
<!-- END JAVASCRIPTS -->
