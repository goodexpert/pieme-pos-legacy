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
    	<div id="notify" class="col-lg-12 col-md-12 col-sm-12">
        	<div class="notify-content"><p>Changed information well!!!!!!</p></div>
        </div>
      <div class="col-md-12 col-xs-12 col-sm-12"><h3>General Setup</h3></div>
      <div class="portlet-body form"> 
        <!-- BEGIN FORM-->
        <div class="form-horizontal col-md-12 col-xs-12 col-sm-12">
          <div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">Store Settings</div>
          <!-- START col-md-12-->
          <div class="form-body line-box line-box-content col-md-12 col-xs-12 col-sm-12"> 
              <!-- START col-md-6-->
              <div class="col-md-6">
                <dl>
                  <dt>Store name</dt>
                  <dd>
                    <input type="text" name="merchant[name]" value="<?php echo $merchant['Merchant']['name']; ?>" id="merchant_name">
                  </dd>
                  <dt>Private URL</dt>
                  <dd>
                    <input type="text" name="merchant[domain_prefix]" value="<?php echo $merchant['Merchant']['domain_prefix']; ?>" id="merchant_domain_prefix">
                  </dd>
                  <dt>Default currency</dt>
                  <dd>
                    <select name="merchant[default_currency]" id="merchant_default_currency">
                      <option value="NZD">New Zealand Dollar</option>
                    </select>
                  </dd>
                  <dt>Time zone</dt>
                  <dd>
                    <select name="merchant[time_zone]" id="merchant_time_zone">
                      <option value="Pacific/Auckland">(GMT+13:00) Auckland, Wellington</option>
                      <option value="Pacific/Chatham">(GMT+13:45) Chatham Islands</option>
                    </select>
                  </dd>
                  <dt>Display prices</dt>
                  <dd>
                    <select name="merchant[display_price_tax_inclusive]" id="merchant_display_price_tax_inclusive">
                      <option value="0">Tax exclusive</option>
                      <option value="1">Tax inclusive</option>
                    </select>
                  </dd>
                  <dt>Default sales tax</dt>
                  <dd>
                    <select name="merchant[default_tax_id]" id="merchant_default_tax_id">
                      <?php foreach ($taxes as $tax) : ?>
                      <option value="<?php echo $tax['MerchantTaxRate']['id']; ?>"><?php echo $tax['MerchantTaxRate']['name'] . ' (' . $tax['MerchantTaxRate']['rate'] * 100 . '%)'; ?></option>
                      <?php endforeach; ?>
                      <option value="0" disabled="true">-----------</option>
                      <option value="add-new">+Add sales tax</option>
                    </select>
                  </dd>
                </dl>
              </div>
              <div class="col-md-6">
                <dl>
                  <dt>Label printer format</dt>
                  <dd>
                    <select name="merchant[label_printer_format]" id="merchant_label_printer_format">
                      <option value="" selected="selected"></option>
                      <option value="2x1">Continuous feed</option>
                      <option value="5x1">Continuous feed (wide)</option>
                      <option value="avery_3x11">Avery Sheet of 3 X 11</option>
                      <option value="avery_5x13">Avery Sheet of 5 X 13</option>
                      <option value="letter_3x10">US Letter Sheet of 3 X 10</option>
                      <option value="4x14">Sheet of 4 X 14</option>
                      <option value="jewellery_butterfly">Jewelry Label - Butterfly</option>
                      <option value="jewellery_rats_tail">Jewelry Label - Rats Tail</option>
                    </select>
                  </dd>
                  <dt>SKU generation</dt>
                  <dd>
                    <select name="merchant[use_sku_sequence]" id="merchant_use_sku_sequence">
                      <option value="0">Generate by Name</option>
                      <option value="1">Generate by Sequence Number</option>
                    </select>
                  </dd>
                  <dt>Current sequence number</dt>
                  <dd>
                    <input type="text" name="merchant[sku_sequence]" value="<?php echo $merchant['Merchant']['sku_sequence']; ?>" id="merchant_sku_sequence">
                  </dd>
                  <dt>User switching security</dt>
                  <dd>
                    <select name="merchant[switching_security]" id="merchant_switching_security">
                      <option value="0">Never require a password when switching between users</option>
                      <option value="1">Require a password when switching to a user with greater privileges</option>
                      <option value="2">Always require a password when switching between users</option>
                    </select>
                  </dd>
                  <dt>Cashier discounts and returns</dt>
                  <dd class="form-group">
                    <input type="checkbox" name="merchant[allow_cashier_discount]" id="merchant_allow_cashier_discount" <?php if($merchant['Merchant']['allow_cashier_discount'] == 1){echo "checked";}?>>
                    Allow Cashires to apply discounts and perform returns on sales</dd>
                </dl>
              </div>
          </div>
        </div>
        <div class="form-horizontal col-md-12 col-xs-12 col-sm-12">
          <div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">Contact Information</div>
          <!-- START col-md-12-->
          <div class="form-body line-box line-box-content col-md-12 col-xs-12 col-sm-12"> 
              <!-- START col-md-6-->
              <div class="col-md-6">
                <dl>
                  <dt>Contact name</dt>
                  <dd>
                    <div class="col-md-6 col-sm-6 col-xs-6 col-alpha">
                      <input type="text" placeholder="First" name="merchant[contact][first_name]" value="<?php echo $merchant['Contact']['first_name']; ?>" id="merchant_contact_first_name">
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6 col-omega">
                      <input type="text" placeholder="Last" name="merchant[contact][last_name]" value="<?php echo $merchant['Contact']['last_name']; ?>" id="merchant_contact_last_name">
                    </div>
                  </dd>
                  <dt>Email</dt>
                  <dd>
                    <input type="email" name="merchant[contact][email]" value="<?php echo $merchant['Contact']['email']; ?>" id="merchant_contact_email">
                  </dd>
                  <dt>Phone</dt>
                  <dd>
                    <input type="text" name="merchant[contact][phone]" value="<?php echo $merchant['Contact']['phone']; ?>" id="merchant_contact_phone">
                  </dd>
                </dl>
              </div>
              <div class="col-md-6">
                <dl>
                  <dt>Website</dt>
                  <dd>
                    <input type="text" name="merchant[contact][website]" value="<?php echo $merchant['Contact']['website']; ?>" id="merchant_contact_website">
                  </dd>
                </dl>
              </div>
          </div>
        </div>
        <div class="form-horizontal col-md-12 col-xs-12 col-sm-12">
          <div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">Address</div>
          <!-- START col-md-12-->
          <div class="form-body line-box line-box-content col-md-12 col-xs-12 col-sm-12"> 
              <!-- START col-md-6-->
              <div class="col-md-6">
                <div class="line-box-stitle inline-block">Physical Address</div>
                <dl>
                  <dt>Street</dt>
                  <dd>
                    <input type="text" name="merchant[contact][physical_address1]" value="<?php echo $merchant['Contact']['physical_address1']; ?>" id="merchant_contact_physical_address1">
                  </dd>
                  <dt>Street</dt>
                  <dd>
                    <input type="text" name="merchant[contact][physical_address2]" value="<?php echo $merchant['Contact']['physical_address2']; ?>" id="merchant_contact_physical_address2">
                  </dd>
                  <dt>Suburb</dt>
                  <dd>
                    <input type="text" name="merchant[contact][physical_suburb]" value="<?php echo $merchant['Contact']['physical_suburb']; ?>" id="merchant_contact_physical_suburb">
                  </dd>
                  <dt>City</dt>
                  <dd>
                    <input type="text" name="merchant[contact][physical_city]" value="<?php echo $merchant['Contact']['physical_city']; ?>"id="merchant_contact_physical_city">
                  </dd>
                  <dt>Physical postcode</dt>
                  <dd>
                    <input type="text" name="merchant[contact][physical_postcode]" value="<?php echo $merchant['Contact']['physical_postcode']; ?>" id="merchant_contact_physical_postcode">
                  </dd>
                  <dt>State</dt>
                  <dd>
                    <input type="text" name="merchant[contact][physical_state]" value="<?php echo $merchant['Contact']['physical_state']; ?>" id="merchant_contact_physical_state">
                  </dd>
                  <dt>Country</dt>
                  <dd>
                    <select name="merchant[contact][physical_country_id]" id="merchant_contact_physical_country_id">
                      <option disabled>Select a country</option>
                      <?php foreach($countries as $country) {?>
                      <option value="<?php echo $country['Country']['country_code'];?>" <?php if($merchant['Contact']['physical_country_id'] == $country['Country']['country_code']){echo "selected";}?>><?php echo $country['Country']['country_name'];?></option>
                      <?php } ?>
                    </select>
                  </dd>
                </dl>
              </div>
              <div class="col-md-6">
                <div class="line-box-stitle inline-block">Postal Address <span class="clickable same_as_physical pull-right btn btn-default">Same as Physical Address </span> </div>
                <dl>
                  <dt>Street</dt>
                  <dd>
                    <input type="text" name="merchant[contact][postal_address1]" value="<?php echo $merchant['Contact']['postal_address1']; ?>" id="merchant_contact_postal_address1">
                  </dd>
                  <dt>Street</dt>
                  <dd>
                    <input type="text" name="merchant[contact][postal_address2]" value="<?php echo $merchant['Contact']['postal_address2']; ?>" id="merchant_contact_postal_address2">
                  </dd>
                  <dt>Suburb</dt>
                  <dd>
                    <input type="text" name="merchant[contact][postal_suburb]" value="<?php echo $merchant['Contact']['postal_suburb']; ?>" id="merchant_contact_postal_suburb">
                  </dd>
                  <dt>City</dt>
                  <dd>
                    <input type="text" name="merchant[contact][postal_city]" value="<?php echo $merchant['Contact']['postal_city']; ?>" id="merchant_contact_postal_city">
                  </dd>
                  <dt>Postal postcode</dt>
                  <dd>
                    <input type="text" name="merchant[contact][postal_postcode]" value="<?php echo $merchant['Contact']['postal_postcode']; ?>" id="merchant_contact_postal_postcode">
                  </dd>
                  <dt>State</dt>
                  <dd>
                    <input type="text" name="merchant[contact][postal_state]" value="<?php echo $merchant['Contact']['postal_state']; ?>" id="merchant_contact_postal_state">
                  </dd>
                  <dt>Country</dt>
                  <dd>
                    <select name="merchant[contact][postal_country_id]" id="merchant_contact_postal_country_id">
                      <option disabled>Select a country</option>
                      <?php foreach($countries as $country) {?>
                      <option value="<?php echo $country['Country']['country_code'];?>" <?php if($merchant['Contact']['postal_country_id'] == $country['Country']['country_code']){echo "selected";}?>><?php echo $country['Country']['country_name'];?></option>
                      <?php } ?>
                    </select>
                  </dd>
                </dl>
              </div>
          </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 pull-right margin-top-20 margin-bottom-20">
            <button class="btn btn-primary btn-wide save pull-right">Save</button>
            <button class="btn btn-default btn-wide pull-right margin-right-10">Cancel</button>
        </div>
        </div>
    </div>
  </div>
    <!-- ADD TAX POPUP BOX -->
    <div id="popup-add_tax" class="confirmation-modal modal fade in" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="confirm-close" data-dismiss="modal" aria-hidden="true">
                    <i class="glyphicon glyphicon-remove"></i>
                    </button>
                    <h4 class="modal-title">Add New Sales Tax</h4>
                </div>
                <div class="modal-body">
                    <dl>
                        <dt>Tax name</dt>
                        <dd><input type="text" id="tax_name"></dd>
                        <dt>Tax rate (%)</dt>
                        <dd><input type="text" id="tax_rate"></dd>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary confirm-close">Cancel</button>
                    <button class="btn btn-success submit">Add</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ADD TAX POPUP BOX END -->
  <!-- END CONTENT --> 
  <!-- BEGIN QUICK SIDEBAR --> 
  <a href="javascript:;" class="page-quick-sidebar-toggler"><i class="icon-close"></i></a>
  <div class="page-quick-sidebar-wrapper">
    <div class="page-quick-sidebar">
      <div class="nav-justified">
        <ul class="nav nav-tabs nav-justified">
          <li class="active"> <a href="#quick_sidebar_tab_1" data-toggle="tab"> Users <span class="badge badge-danger">2</span> </a> </li>
          <li> <a href="#quick_sidebar_tab_2" data-toggle="tab"> Alerts <span class="badge badge-success">7</span> </a> </li>
          <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> More<i class="fa fa-angle-down"></i> </a>
            <ul class="dropdown-menu pull-right" role="menu">
              <li> <a href="#quick_sidebar_tab_3" data-toggle="tab"> <i class="icon-bell"></i> Alerts </a> </li>
              <li> <a href="#quick_sidebar_tab_3" data-toggle="tab"> <i class="icon-info"></i> Notifications </a> </li>
              <li> <a href="#quick_sidebar_tab_3" data-toggle="tab"> <i class="icon-speech"></i> Activities </a> </li>
              <li class="divider"> </li>
              <li> <a href="#quick_sidebar_tab_3" data-toggle="tab"> <i class="icon-settings"></i> Settings </a> </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <!-- END QUICK SIDEBAR --> 
</div>
<div class="modal-backdrop fade in" style="display: none;"></div>
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
<!-- BEGIN PAGE LEVEL PLUGINS --> 
<script src="/assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script> 
<!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support --> 
<script src="/assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.min.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/gritter/js/jquery.gritter.js" type="text/javascript"></script> 
<!-- END PAGE LEVEL PLUGINS --> 
<!-- BEGIN PAGE LEVEL SCRIPTS --> 
<script src="/assets/global/scripts/metronic.js" type="text/javascript"></script> 
<script src="/assets/admin/layout/scripts/layout.js" type="text/javascript"></script> 
<script src="/assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script> 
<script src="/assets/admin/pages/scripts/index.js" type="text/javascript"></script> 
<script src="/assets/admin/pages/scripts/tasks.js" type="text/javascript"></script> 
<!-- END PAGE LEVEL SCRIPTS --> 

<script src="/js/notify.js" type="text/javascript"></script> 
<script>
jQuery(document).ready(function() {    
   Metronic.init(); // init metronic core componets
   Layout.init(); // init layout
   QuickSidebar.init() // init quick sidebar
   Index.init();

   $('#merchant_default_tax_id').on('change', function(e) {
       if ($(this).val() == 'add-new') {
           $("#popup-add_tax").show();
           $(".modal-backdrop").show();
       }
   });
   
   $(".confirm-close").click(function(){
        $("#popup-add_tax").hide();
        $(".modal-backdrop").hide();
        $("#tax_rate").val('');
        $("#tax_name").val('');
    });

    $(".submit").click(function(){
        var tax_rate = $("#tax_rate").val().replace(/%/,'');
        $.ajax({
          url: '/taxes/add.json',
          type: 'POST',
          data: {
              name: $("#tax_name").val(),
              rate: tax_rate / 100
          }
        }).done(function(msg){
            $("#merchant_default_tax_id").prepend('<option value="'+msg['id']+'">'+msg['data']['name']+' ('+msg['data']['rate']*100+'%)</option>');
            $("#merchant_default_tax_id").val(msg['id']);
            $("#popup-add_tax").hide();
            $(".modal-backdrop").hide();
        });
    });

   $('.same_as_physical').on('click', function(e) {
       same_as_physical();
   });
   
   $(".save").click(function(){
       var allow_cashier_discount;
       if($("#merchant_allow_cashier_discount").is(':checked')) {
	       allow_cashier_discount = 1;
       } else {
	       allow_cashier_discount = 0;
       }
   
       $.ajax({
          url: '/setup.json',
          type: 'POST',
          data: {
              name: $("#merchant_name").val(),
              domain_prefix: $("#merchant_domain_prefix").val(),
              default_currency: $("#merchant_default_currency").val(),
              time_zone: $("#merchant_time_zone").val(),
              display_price_tax_inclusive: $("#merchant_display_price_tax_inclusive").val(),
              default_tax_id: $("#merchant_default_tax_id").val(),
              label_printer_format: $("#merchant_label_printer_formant").val(),
              use_sku_sequence: $("#merchant_use_sku_sequence").val(),
              sku_sequence: $("#merchant_sku_sequence").val(),
              switching_security: $("#merchant_switching_security").val(),
              allow_cashier_discount: allow_cashier_discount,
              first_name: $("#merchant_contact_first_name").val(),
              last_name: $("#merchant_contact_last_name").val(),
              email: $("#merchant_contact_email").val(),
              phone: $("#merchant_contact_phone").val(),
              website: $("#merchant_contact_website").val(),
              physical_address1: $("#merchant_contact_physical_address1").val(),
              physical_address2: $("#merchant_contact_physical_address2").val(),
              physical_suburb: $("#merchant_contact_physical_suburb").val(),
              physical_city: $("#merchant_contact_physical_city").val(),
              physical_postcode: $("#merchant_contact_physical_postcode").val(),
              physical_state: $("#merchant_contact_physical_state").val(),
              physical_country_id: $("#merchant_contact_physical_country_id").val(),
              postal_address1: $("#merchant_contact_postal_address1").val(),
              postal_address2: $("#merchant_contact_postal_address2").val(),
              postal_suburb: $("#merchant_contact_postal_suburb").val(),
              postal_city: $("#merchant_contact_postal_city").val(),
              postal_postcode: $("#merchant_contact_postal_postcode").val(),
              postal_state: $("#merchant_contact_postal_state").val(),
              postal_country_id: $("#merchant_contact_postal_country_id").val(),
          },
          success: function(){
	          location.reload();
          }
       });
   });
});

function same_as_physical() {
    var address1 = $('#merchant_contact_physical_address1').val()
    var address2 = $('#merchant_contact_physical_address2').val()
    var suburb = $('#merchant_contact_physical_suburb').val()
    var city = $('#merchant_contact_physical_city').val()
    var postcode = $('#merchant_contact_physical_postcode').val()
    var state = $('#merchant_contact_physical_state').val()
    var country_id = $('#merchant_contact_physical_country_id').val()

    $('#merchant_contact_postal_address1').val(address1);
    $('#merchant_contact_postal_address2').val(address2)
    $('#merchant_contact_postal_suburb').val(suburb)
    $('#merchant_contact_postal_city').val(city)
    $('#merchant_contact_postal_postcode').val(postcode)
    $('#merchant_contact_postal_state').val(state)
    $('#merchant_contact_postal_country_id').val(country_id)
}
</script> 
<!-- END JAVASCRIPTS -->