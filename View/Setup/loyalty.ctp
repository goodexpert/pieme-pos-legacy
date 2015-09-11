<?php
$data = $this->request->data;
?>

<div id="notify"></div>
<!-- BEGIN CONTENT -->
<div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega margin-bottom-20">
  <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">Loyalty</h2>
</div>
<div class="portlet-body form">
  <!-- BEGIN FORM-->
  <?php
  echo $this->Form->create('MerchantLoyalty', array(
      'id' => 'loyalty_setup_form'
  ));
  echo $this->Form->input('id', array(
      'type' => 'hidden',
      'div' => false,
      'label' => false
  ));
  ?>
  <div class="form-horizontal col-md-12 col-xs-12 col-sm-12">
    <div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">
      <?php
      echo $this->Form->input('enable_loyalty', array(
          'id' => 'enable_loyalty',
          'type' => 'checkbox',
          'div' => false
      ));
      ?>
    </div>
    <!-- START col-md-12-->
    <div id="enable_loyalty_body" class="form-body line-box line-box-content col-md-12 col-xs-12 col-sm-12">
      <div class="disable" <?php if ($data['MerchantLoyalty']['enable_loyalty'] == 1) {
        echo "style='display:none;'";
      } ?>></div>
      <h6 class="line-box-stitle">Allow customers to earn Loyalty $ when purchasing products. You can set Loyalty $
        earned on individual products from the Edit Product page or from a price book. You can turn off Loyalty for
        individual customers on the Edit Customer page.</h6>

      <div class="loyalty-box">
        <h3>Earning Loyalty</h3>
        <ul class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
          <li class="col-md-5 col-xs-5 col-sm-5 col-alpha col-omega">
            <?php
            echo $this->Form->input('loyalty_spend_amount', array(
                'id' => 'loyalty_spend_amount',
                'type' => 'text',
                'div' => false,
                'label' => false
            ));
            ?>
          </li>
          <li class="col-md-2 col-xs-2 col-sm-2 col-alpha col-omega">
            <span class="glyphicon glyphicon-pause"></span>
          </li>
          <li class="col-md-5 col-xs-5 col-sm-5 col-alpha col-omega">
            $1.00 Loyalty
          </li>
        </ul>
      </div>
      <h6 class="text-center">Spending $<span
            id="spend_amount_display"><?php echo number_format($data['MerchantLoyalty']['loyalty_spend_amount'], 2, '.', ''); ?></span>
        earns $1.00 Loyalty.</h6>

      <div class="dashed-line-gr"></div>
      <dl class="dl-oneline">
        <dt>Bonus Loyalty</dt>
        <dd>
          <?php
          echo $this->Form->input('offer_signup_bonus_loyalty', array(
              'id' => 'offer_signup_bonus_loyalty',
              'type' => 'checkbox',
              'div' => false,
              'label' => false
          ));
          ?>&nbsp;Offer bonus Loyalty $ if a customer fills out all of their details in the Customer Portal (see
          example)
        </dd>
        <dt></dt>
        <dd>
          <?php
          echo $this->Form->input('signup_bonus_loyalty_amount', array(
              'id' => 'signup_bonus_loyalty_amount',
              'type' => 'text',
              'class' => 'text-right',
              'div' => false,
              'label' => false
          ));
          ?>&nbsp;Loyalty
        </dd>
      </dl>
    </div>
  </div>
  <div class="form-horizontal col-md-12 col-xs-12 col-sm-12">
    <div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">
      <div class="disable" <?php if ($data['MerchantLoyalty']['enable_loyalty'] == 1) {
        echo "style='display:none;'";
      } ?>></div>
      <?php
      echo $this->Form->input('send_welcome_email', array(
          'id' => 'send_welcome_email',
          'type' => 'checkbox',
          'div' => false,
      ));
      ?>
    </div>
    <!-- START col-md-12-->
    <div id="send_welcome_email_body" class="form-body line-box line-box-content col-md-12 col-xs-12 col-sm-12">
      <div class="disable" <?php if ($data['MerchantLoyalty']['send_welcome_email'] == 1) {
        echo "style='display:none;'";
      } ?>></div>
      <h6 class="line-box-stitle">Selecting this option will send customers an email welcoming them to the Loyalty
        program. The welcome email will be sent the next time the customer is added to a sale and includes a link where
        they can edit their details. Please note, the email will not be sent to customers if they haven't provided an
        email address, or if the customer has Loyalty disabled.</h6>
      <dl class="dl-oneline">
        <dt>Email subject</dt>
        <dd>
          <?php
          echo $this->Form->input('welcome_email_subject', array(
              'id' => 'welcome_email_subject',
              'type' => 'text',
              'div' => false,
              'label' => false
          ));
          ?>
        </dd>
        <dt>Email message</dt>
        <dd style="height: inherit;">
          <?php
          echo $this->Form->input('welcome_email_body', array(
              'id' => 'welcome_email_body',
              'type' => 'textarea',
              'div' => false,
              'label' => false
          ));
          ?>
        </dd>
        <dt></dt>
        <dd class="margin-top-10">
          <button id="preview_email" class="btn btn-sm btn-default">Preview Welcome Email</button>
        </dd>
      </dl>
    </div>
  </div>
  <div class="col-md-12 col-sm-12 col-xs-12 pull-right margin-top-20 margin-bottom-20">
    <button class="btn btn-primary btn-wide save pull-right">Save</button>
    <button class="btn btn-default btn-wide pull-right margin-right-10">Cancel</button>
  </div>
  <?php
  echo $this->Form->end();
  ?>
</div>
</div>
</div>
<!-- END CONTENT -->
<!-- LOYALTY POPUP BOX -->
<div class="confirmation-modal modal fade in void" tabindex="-1" role="dialog" aria-hidden="false"
     style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="confirm-close cancel" data-dismiss="modal" aria-hidden="true">
          <i class="glyphicon glyphicon-remove"></i>
        </button>
        <h4 class="modal-title">Preview Email</h4>
      </div>
      <div class="modal-body">
        <div class="preview-email-content">
          <h2>Welcome to emcorpos Loyalty Program</h2>
          <br>
          You can earn Loyalty $ when you make purchases at emcorpos and redeem your credit in store.<br><br>
          Thanks,<br>
          emcorpos
          <br><br>
          <h4>Register your details with the emcorpos Loyalty Program:</h4>

          #link-appears-here
          <span class="solid-line-gr"></span>
          <span class="text-right inline-block"><strong>$0.00</strong></span>

          <div class="preview-email-footer">
            <img src="/img/ONZSA_logo-gr.png" alt="logo-gr" class="margin-top-20" style="width:115px;">

            <p>Powered by ONZSA | Point-of-sale for clever stores.</p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="cancel btn btn-primary" type="button" data-dismiss="modal">Close</button>
      </div>
    </div>
    <!-- LOYALTY POPUP BOX END -->
    <!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
    <!-- BEGIN CORE PLUGINS -->
    <?php echo $this->element('script-jquery'); ?>
    <?php echo $this->element('script-angularjs'); ?>
    <!-- END CORE PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js"></script>
    <script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js"></script
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


    <script src="/theme/onzsa/assets/admin/pages/scripts/tasks.js"></script>
    <script src="/plugin/textboxio/textboxio.js"></script>
    <script src="notify.js"></script>
    <script src="/js/lib/jquery-number/jquery.number.min.js"></script>
    <script src="/js/lib/tinymce/tinymce.min.js"></script>
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
        tinymce.init({
          selector: "textarea"
        });

        $("#loyalty_spend_amount").number(true, 2);
        $("#signup_bonus_loyalty_amount").number(true, 2);

        $("#enable_loyalty").change(function (e) {
          $(".disable").toggle();

          if (!$(this).is(':checked')) {
            $("#send_welcome_email").removeAttr("checked");
          }
          $("#send_welcome_email_body").find('.disable').show();
        });

        $("#send_welcome_email").change(function (e) {
          if ($(this).is(':checked')) {
            $("#send_welcome_email_body").find('.disable').hide();
          } else {
            $("#send_welcome_email_body").find('.disable').show();
          }
        });

        $("#preview_email").click(function (e) {
          $(".confirmation-modal").show();
          return false;
        });

        $(".confirm-close").click(function () {
          $(".confirmation-modal").hide();
        });

        $(".cancel").click(function () {
          $(".confirmation-modal").hide();
        });
      }


    </script>
    <!-- END JAVASCRIPTS -->
