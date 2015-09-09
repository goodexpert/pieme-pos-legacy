<div class="clearfix"></div>
<!-- BEGIN CONTENT -->
<div class="col-md-12 col-xs-12 col-sm-12"><h3>Edit Receipt Template</h3></div>
<div class="portlet-body form">
  <!-- BEGIN FORM-->
  <div class="form-horizontal col-md-12 col-xs-12 col-sm-12">
    <div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">Details</div>
    <!-- START col-md-12-->
    <div class="form-body line-box line-box-content col-md-12 col-xs-12 col-sm-12">
      <!-- START col-md-6-->
      <div class="col-md-6">
        <dl>
          <dt>Receipt name</dt>
          <dd>
            <input type="text" id="name" value="<?php echo $template['MerchantReceiptTemplate']['name']; ?>">
          </dd>
          <dt>Receipt style</dt>
          <dd>
            <select id="receipt_style_id">
              <?php foreach ($styles as $style) { ?>
                <option
                    value="<?php echo $style['ReceiptStyle']['id']; ?>" <?php if ($template['MerchantReceiptTemplate']['receipt_style_id'] == $style['ReceiptStyle']['id']) {
                  echo "selected";
                } ?>><?php echo $style['ReceiptStyle']['name']; ?></option>
              <?php } ?>
            </select>
          </dd>
          <dt>Print receipt barcode</dt>
          <dd>
            <input type="radio" value="1"
                   name="MerchantReceiptTemplate[receipt_barcode]" <?php if ($template['MerchantReceiptTemplate']['receipt_barcode'] == 1) {
              echo "checked";
            } ?>> Yes <span class="margin-right-10"></span>
            <input type="radio" value="0"
                   name="MerchantReceiptTemplate[receipt_barcode]" <?php if ($template['MerchantReceiptTemplate']['receipt_barcode'] == 0) {
              echo "checked";
            } ?>> No
          </dd>
        </dl>
      </div>
    </div>
  </div>
  <div class="form-horizontal col-md-12 col-xs-12 col-sm-12">
    <div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">Layout</div>
    <!-- START col-md-12-->
    <div class="form-body line-box line-box-content col-md-12 col-xs-12 col-sm-12">
      <!-- START col-md-6-->
      <div class="col-md-6">
        <dl>
          <dt>Banner image</dt>
          <dd class="height-inherit">
            <input type="file">
            <h6>Upload a JPG, PNG or GIF file, no wider than 280px.</h6>
          </dd>
          <dt>Header text</dt>
          <dd class="height-inherit">
            <textarea
                id="receipt_header"><?php echo $template['MerchantReceiptTemplate']['receipt_header']; ?></textarea>
            <h6>Limit this to around one paragraph or no more than 15 lines.</h6>
          </dd>
          <dt>Invoice.no.prefix</dt>
          <dd>
            <input type="text" id="label_invoice"
                   value="<?php echo $template['MerchantReceiptTemplate']['label_invoice']; ?>">
          </dd>
          <dt>Invoice heading</dt>
          <dd>
            <input type="text" id="label_invoice_title"
                   value="<?php echo $template['MerchantReceiptTemplate']['label_invoice_title']; ?>">
          </dd>
          <dt>Served by label</dt>
          <dd>
            <input type="text" id="label_served_by"
                   value="<?php echo $template['MerchantReceiptTemplate']['label_served_by']; ?>">
          </dd>
          <dt>Discount label</dt>
          <dd>
            <input type="text" id="label_line_discount"
                   value="<?php echo $template['MerchantReceiptTemplate']['label_line_discount']; ?>">
          </dd>
          <dt>Sub total label</dt>
          <dd>
            <input type="text" id="label_sub_total"
                   value="<?php echo $template['MerchantReceiptTemplate']['label_sub_total']; ?>">
          </dd>
          <dt>Tax label</dt>
          <dd>
            <input type="text" id="label_tax" value="<?php echo $template['MerchantReceiptTemplate']['label_tax']; ?>">
          </dd>
          <dt>To pay label</dt>
          <dd>
            <input type="text" id="label_to_pay"
                   value="<?php echo $template['MerchantReceiptTemplate']['label_to_pay']; ?>">
          </dd>
          <dt>Total label</dt>
          <dd>
            <input type="text" id="label_total"
                   value="<?php echo $template['MerchantReceiptTemplate']['label_total']; ?>">
          </dd>
          <dt>Change label</dt>
          <dd>
            <input type="text" id="label_change"
                   value="<?php echo $template['MerchantReceiptTemplate']['label_change']; ?>">
          </dd>
          <dt>Footer text</dt>
          <dd class="height-inherit">
            <textarea
                id="receipt_footer"><?php echo $template['MerchantReceiptTemplate']['receipt_footer']; ?></textarea>
            <h6>Limit this to around one paragraph or no more than 15 lines.</h6>
          </dd>
        </dl>
      </div>
    </div>
  </div>
  <div class="col-md-12 col-sm-12 col-xs-12 pull-right margin-top-20 margin-bottom-20">
    <button class="btn btn-primary btn-wide save pull-right">Save</button>
    <button class="btn btn-default btn-wide delete pull-right margin-right-10">Delete</button>
    <button class="btn btn-default btn-wide cancel pull-right margin-right-10">Cancel</button>
  </div>
</div>
<!-- END CONTENT -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<!-- BEGIN CORE PLUGINS -->
<?php echo $this->element('script-jquery'); ?>
<?php echo $this->element('script-angularjs'); ?>
<!-- END CORE PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/theme/onzsa/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/admin/pages/scripts/index.js" type="text/javascript"></script>
<script type="text/javascript" src="/js/jquery.confirm.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<?php echo $this->element('common-init'); ?>
<script>
jQuery(document).ready(function() {
  documentInit();
});

function documentInit() {
  // common init function
  commonInit();

  $(".save").click(function () {
    $.ajax({
      url: location.href + '.json',
      type: 'POST',
      data: {
        name: $("#name").val(),
        receipt_style_id: $("#receipt_style_id").val(),
        receipt_barcode: $("input[type='radio']:checked").val(),
        receipt_header: $("#receipt_header").val(),
        receipt_footer: $("#receipt_footer").val(),
        label_invoice: $("#label_invoice").val(),
        label_invoice_title: $("#label_invoice_title").val(),
        label_served_by: $("#label_served_by").val(),
        label_line_discount: $("#label_line_discount").val(),
        label_sub_total: $("#label_sub_total").val(),
        label_tax: $("#label_tax").val(),
        label_to_pay: $("#label_to_pay").val(),
        label_total: $("#label_total").val(),
        label_change: $("#label_change").val()
      },
      success: function (result) {
        if (result.success) {
          window.location.href = "/setup/outlets_and_registers";
        } else {
          console.log(result);
        }
      }
    });
  });

  $(".delete").click(function () {
    $.confirm({
      text: "Are you sure you want to delete this template?",
      title: "Confirmation required",
      confirm: function (button) {
        $.ajax({
          url: location.href + '.json',
          type: 'POST',
          data: {
            request: 'delete'
          },
          success: function (result) {
            if (result.success) {
              window.location.href = "/setup/outlets_and_registers";
            } else {
              alert(result.message);
            }
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
          }
        });
      },
      cancel: function (button) {
      },
      confirmButton: "Delete",
      cancelButton: "Cancel",
      confirmButtonClass: "btn-danger",
      cancelButtonClass: "btn-default",
      dialogClass: "modal-dialog modal-lg" // Bootstrap classes for large modal
    });
  });

  $(".cancel").click(function () {
    window.history.back();
  });
}
</script>
<!-- END JAVASCRIPTS -->
