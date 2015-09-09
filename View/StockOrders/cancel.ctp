<form action="/stock_orders/<?php echo $order_id; ?>/cancel" method="post" class="form-horizontal"
      id="cancel_order_form">
  <div class="modal-header">
    <button type="button" class="confirm-close close-pop" data-dismiss="modal" aria-hidden="true">
      <i class="glyphicon glyphicon-remove"></i>
    </button>
    <h4 class="modal-title">Are you sure?</h4>
  </div>
  <div class="modal-body margin-bottom-20">
    <p>You are about to perform an action that can't be undone.</p>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-primary btn-wide" data-dismiss="modal">Cancel</button>
    <button type="submit" class="btn btn-success btn-wide confirm">Ok</button>
  </div>
</form>
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<?php if (!$this->request->is('ajax')) : ?>
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
  <script src="/theme/onzsa/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
  <script src="/theme/onzsa/assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
  <script src="/theme/onzsa/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js"></script>
  <script src="/theme/onzsa/assets/global/plugins/jquery.sparkline.min.js"></script>
  <script src="/theme/onzsa/assets/global/plugins/gritter/js/jquery.gritter.js"></script>
  <!-- END PAGE LEVEL PLUGINS -->
  <!-- BEGIN PAGE LEVEL SCRIPTS -->
  <!-- END PAGE LEVEL SCRIPTS -->
<?php endif; ?>
<!-- BEGIN COMMON INIT -->
<?php echo $this->element('common-init'); ?>
<!-- END COMMON INIT -->
<script>
  $(document).ready(function () {
    documentInit();
  });

  function documentInit() {
    // common init function
    commonInit();
    formValidation();
  };

  // form validation
  var formValidation = function () {
    // for more info visit the official plugin documentation: 
    // http://docs.jquery.com/Plugins/Validation
  }
</script>
<!-- END JAVASCRIPTS -->
