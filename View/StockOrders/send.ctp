<form action="/stock_orders/<?php echo $order_id; ?>/send" method="post" class="form-horizontal" id="send_order_form">
  <div class="modal-header">
    <h4 class="modal-title">Send order</h4>
  </div>
  <div class="modal-body">
    <div class="form-group">
      <label for="recipient_name" class="col-sm-3 control-label">Recipient</label>

      <div class="col-sm-8">
        <?php
        echo $this->Form->input('recipient_name', array(
            'type' => 'text',
            'class' => 'form-control',
            'id' => 'recipient_name',
            'div' => false,
            'label' => false
        ));
        ?>
      </div>
    </div>
    <div class="form-group">
      <label for="to" class="col-sm-3 control-label">Email</label>

      <div class="col-sm-8">
        <?php
        echo $this->Form->input('to', array(
            'type' => 'email',
            'class' => 'form-control',
            'id' => 'to',
            'div' => false,
            'label' => false
        ));
        ?>
      </div>
    </div>
    <div class="form-group">
      <label for="cc" class="col-sm-3 control-label">Cc</label>

      <div class="col-sm-8">
        <?php
        echo $this->Form->input('cc', array(
            'type' => 'email',
            'class' => 'form-control',
            'id' => 'cc',
            'div' => false,
            'label' => false
        ));
        ?>
      </div>
    </div>
    <div class="form-group">
      <label for="subject" class="col-sm-3 control-label">Subject</label>

      <div class="col-sm-8">
        <?php
        echo $this->Form->input('subject', array(
            'type' => 'text',
            'class' => 'form-control',
            'id' => 'subject',
            'div' => false,
            'label' => false
        ));
        ?>
      </div>
    </div>
    <div class="form-group">
      <label for="message" class="col-sm-3 control-label">Message</label>

      <div class="col-sm-8">
        <?php
        echo $this->Form->input('message', array(
            'type' => 'textarea',
            'class' => 'form-control',
            'rows' => '4',
            'cols' => '30',
            'id' => 'message',
            'div' => false,
            'label' => false
        ));
        ?>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-primary btn-wide" data-dismiss="modal">Cancel</button>
    <button type="submit" class="btn btn-success btn-wide send-email">Send</button>
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
  <script src="/theme/onzsa/assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
  <script src="/theme/onzsa/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js"></script>
  <script src="/theme/onzsa/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
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
    $("#send_order_form").validate({
      rules: {
        'data[recipient_name]': {
          required: false
        },
        'data[to]': {
          required: true,
          email: true
        },
        'data[cc]': {
          required: false,
          email: true
        },
        'data[subject]': {
          required: true
        },
        'data[message]': {
          required: true
        }
      },
      messages: {
        'data[to]': {
          required: "Required",
          email: "The email address appears to be invalid."
        },
        'data[cc]': {
          email: "The email address appears to be invalid."
        },
        'data[subject]': {
          required: "Required"
        },
        'data[message]': {
          required: "Don't forget to put in an introduction to the order email."
        }
      },
    });
  }
</script>
<!-- END JAVASCRIPTS -->
