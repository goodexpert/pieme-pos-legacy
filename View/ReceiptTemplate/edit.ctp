<div class="clearfix"> </div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
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
            <a href="javascript:;" class="remove"> <i class="icon-close"></i> </a>
            <div class="input-group">
              <input type="text" placeholder="Search...">
              <span class="input-group-btn">
              <button class="btn submit"><i class="icon-magnifier"></i></button>
              </span> </div>
          </form>
          <!-- END RESPONSIVE QUICK SEARCH FORM -->
        </li>
        <li> <a href="index"> Sell </a> </li>
        <li> <a href="history"> History </a> </li>
        <li class="active"> <a href="history"> Product <span class="selected"> </span> </a> </li>
      </ul>
    </div>
    <!-- END HORIZONTAL RESPONSIVE MENU --> 
  </div>
  <!-- END SIDEBAR --> 
  <!-- BEGIN CONTENT -->
  <div class="page-content-wrapper">
    <div class="page-content">
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
                    <input type="text" id="name" value="<?php echo $template['MerchantReceiptTemplate']['name'];?>">
                  </dd>
                  <dt>Receipt style</dt>
                  <dd>
                    <select id="receipt_style_id">
                        <?php foreach($styles as $style) { ?>
                            <option value="<?php echo $style['ReceiptStyle']['id'];?>" <?php if($template['MerchantReceiptTemplate']['receipt_style_id'] == $style['ReceiptStyle']['id']){echo "selected";}?>><?php echo $style['ReceiptStyle']['name'];?></option>
                        <?php } ?>
                    </select>
                  </dd>
                  <dt>Print receipt barcode</dt>
                  <dd>
                    <input type="radio" value="1" name="MerchantReceiptTemplate[receipt_barcode]" <?php if($template['MerchantReceiptTemplate']['receipt_barcode'] == 1){echo "checked";}?>> Yes <span class="margin-right-10"></span>
                    <input type="radio" value="0" name="MerchantReceiptTemplate[receipt_barcode]" <?php if($template['MerchantReceiptTemplate']['receipt_barcode'] == 0){echo "checked";}?>> No
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
                    <textarea id="receipt_header"><?php echo $template['MerchantReceiptTemplate']['receipt_header'];?></textarea>
                    <h6>Limit this to around one paragraph or no more than 15 lines.</h6>
                  </dd>
                  <dt>Invoice.no.prefix</dt>
                  <dd>
                    <input type="text" id="label_invoice" value="<?php echo $template['MerchantReceiptTemplate']['label_invoice'];?>">
                  </dd>
                  <dt>Invoice heading</dt>
                  <dd>
                    <input type="text" id="label_invoice_title" value="<?php echo $template['MerchantReceiptTemplate']['label_invoice_title'];?>">
                  </dd>
                  <dt>Served by label</dt>
                  <dd>
                    <input type="text" id="label_served_by" value="<?php echo $template['MerchantReceiptTemplate']['label_served_by'];?>">
                  </dd>
                  <dt>Discount label</dt>
                  <dd>
                    <input type="text" id="label_line_discount" value="<?php echo $template['MerchantReceiptTemplate']['label_line_discount'];?>">
                  </dd>
                  <dt>Sub total label</dt>
                  <dd>
                    <input type="text" id="label_sub_total" value="<?php echo $template['MerchantReceiptTemplate']['label_sub_total'];?>">
                  </dd>
                  <dt>Tax label</dt>
                  <dd>
                    <input type="text" id="label_tax" value="<?php echo $template['MerchantReceiptTemplate']['label_tax'];?>">
                  </dd>
                  <dt>To pay label</dt>
                  <dd>
                    <input type="text" id="label_to_pay" value="<?php echo $template['MerchantReceiptTemplate']['label_to_pay'];?>">
                  </dd>
                  <dt>Total label</dt>
                  <dd>
                    <input type="text" id="label_total" value="<?php echo $template['MerchantReceiptTemplate']['label_total'];?>">
                  </dd>
                  <dt>Change label</dt>
                  <dd>
                    <input type="text" id="label_change" value="<?php echo $template['MerchantReceiptTemplate']['label_change'];?>">
                  </dd>
                  <dt>Footer text</dt>
                  <dd class="height-inherit">
                    <textarea id="receipt_footer"><?php echo $template['MerchantReceiptTemplate']['receipt_footer'];?></textarea>
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
    </div>
  </div>
  <!-- END CONTENT --> 
</div>
<!-- END CONTAINER --> 
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="/assets/global/plugins/respond.min.js"></script>
<script src="/assets/global/plugins/excanvas.min.js"></script>
<![endif]-->
<script src="/assets/global/plugins/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="/assets/admin/pages/scripts/index.js" type="text/javascript"></script>
<script type="text/javascript" src="/js/jquery.confirm.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    Index.init();
    
    $(".save").click(function(){
        $.ajax({
            url: location.href+'.json',
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
            success: function(result) {
                if(result.success) {
                    window.location.href = "/setup/outlets_and_registers";
                } else {
                    console.log(result);
                }
            }
        });
    });
    
    $(".delete").click(function(){
        $.confirm({
            text: "Are you sure you want to delete this template?",
            title: "Confirmation required",
            confirm: function(button) {
                $.ajax({
                    url: location.href+'.json',
                    type: 'POST',
                    data: {
                        request: 'delete'
                    },
                    success: function(result) {
                        if(result.success) {
                            window.location.href = "/setup/outlets_and_registers";
                        } else {
                            alert(result.message);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            },
            cancel: function(button) {
            },
            confirmButton: "Delete",
            cancelButton: "Cancel",
            confirmButtonClass: "btn-danger",
            cancelButtonClass: "btn-default",
            dialogClass: "modal-dialog modal-lg" // Bootstrap classes for large modal
        });
    });
    
    $(".cancel").click(function(){
        window.history.back();
    });
});
</script> 
<!-- END JAVASCRIPTS -->