<div class="clearfix"></div>

<!-- BEGIN CONTENT -->

<div id="notify" class="hidden col-lg-12 col-md-12 col-sm-12">
  <div class="notify-content"><p>Setup has been changed. Please login again to your account.</p></div>
</div>
<div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega margin-bottom-20">
  <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">General Setup</h2>
</div>
<div class="form">
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
            <input type="text" name="merchant[name]" value="<?php echo $merchant['Merchant']['name']; ?>"
                   id="merchant_name">
          </dd>
          <dt>Private URL</dt>
          <dd>
            <input type="text" name="merchant[domain_prefix]"
                   value="<?php echo $merchant['Merchant']['domain_prefix']; ?>" id="merchant_domain_prefix">
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
              <option value="Pacific/Auckland" <?php if ($merchant['Merchant']['time_zone'] == "Pacific/Auckland") {
                echo "selected";
              } ?>>(GMT+13:00) Auckland, Wellington
              </option>
              <option value="Pacific/Chatham" <?php if ($merchant['Merchant']['time_zone'] == "Pacific/Chatham") {
                echo "selected";
              } ?>>(GMT+13:45) Chatham Islands
              </option>
            </select>
          </dd>
          <dt>Display prices</dt>
          <dd>
            <select name="merchant[display_price_tax_inclusive]" id="merchant_display_price_tax_inclusive">
              <option value="0" <?php if ($merchant['Merchant']['display_price_tax_inclusive'] == 0) {
                echo "selected";
              } ?>>Tax exclusive
              </option>
              <option value="1" <?php if ($merchant['Merchant']['display_price_tax_inclusive'] == 1) {
                echo "selected";
              } ?>>Tax inclusive
              </option>
            </select>
          </dd>
          <dt>Default sales tax</dt>
          <dd>
            <select name="merchant[default_tax_id]" id="merchant_default_tax_id">
              <?php foreach ($taxes as $tax) : ?>
                <option
                    value="<?php echo $tax['MerchantTaxRate']['id']; ?>" <?php if ($merchant['Merchant']['default_tax_id'] == $tax['MerchantTaxRate']['id']) {
                  echo "selected";
                } ?>><?php echo $tax['MerchantTaxRate']['name'] . ' (' . $tax['MerchantTaxRate']['rate'] * 100 . '%)'; ?></option>
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
              <option value="2x1" <?php if ($merchant['Merchant']['label_printer_format'] == "2x1") {
                echo "selected";
              } ?>>Continuous feed
              </option>
              <option value="5x1" <?php if ($merchant['Merchant']['label_printer_format'] == "5x1") {
                echo "selected";
              } ?>>Continuous feed (wide)
              </option>
              <option value="avery_3x11" <?php if ($merchant['Merchant']['label_printer_format'] == "avert_ 3x11") {
                echo "selected";
              } ?>>Avery Sheet of 3 X 11
              </option>
              <option value="avery_5x13" <?php if ($merchant['Merchant']['label_printer_format'] == "avery_5x13") {
                echo "selected";
              } ?>>Avery Sheet of 5 X 13
              </option>
              <option value="letter_3x10" <?php if ($merchant['Merchant']['label_printer_format'] == "letter_3x10") {
                echo "selected";
              } ?>>US Letter Sheet of 3 X 10
              </option>
              <option value="4x14" <?php if ($merchant['Merchant']['label_printer_format'] == "4x14") {
                echo "selected";
              } ?>>Sheet of 4 X 14
              </option>
              <option
                  value="jewellery_butterfly" <?php if ($merchant['Merchant']['label_printer_format'] == "jewellery_butterfly") {
                echo "selected";
              } ?>>Jewelry Label - Butterfly
              </option>
              <option
                  value="jewellery_rats_tail" <?php if ($merchant['Merchant']['label_printer_format'] == "jewellery_rats_tail") {
                echo "selected";
              } ?>>Jewelry Label - Rats Tail
              </option>
            </select>
          </dd>
          <dt>SKU generation</dt>
          <dd>
            <select name="merchant[use_sku_sequence]" id="merchant_use_sku_sequence">
              <option value="0" <?php if ($merchant['Merchant']['use_sku_sequence'] == 0) {
                echo "selected";
              } ?>>Generate by Name
              </option>
              <option value="1" <?php if ($merchant['Merchant']['use_sku_sequence'] == 1) {
                echo "selected";
              } ?>>Generate by Sequence Number
              </option>
            </select>
          </dd>
          <dt <?php if ($merchant['Merchant']['use_sku_sequence'] == 0) {
            echo "style='display:none;'";
          } ?>>Current sequence number
          </dt>
          <dd <?php if ($merchant['Merchant']['use_sku_sequence'] == 0) {
            echo "style='display:none;'";
          } ?>>
            <input type="text" name="merchant[sku_sequence]"
                   value="<?php echo $merchant['Merchant']['sku_sequence']; ?>" id="merchant_sku_sequence">
          </dd>
          <dt>User switching security</dt>
          <dd>
            <select name="merchant[switching_security]" id="merchant_switching_security">
              <option value="0" <?php if ($merchant['Merchant']['switching_security'] == 0) {
                echo "selected";
              } ?>>Never require a password when switching between users
              </option>
              <option value="1" <?php if ($merchant['Merchant']['switching_security'] == 1) {
                echo "selected";
              } ?>>Require a password when switching to a user with greater privileges
              </option>
              <option value="2" <?php if ($merchant['Merchant']['switching_security'] == 2) {
                echo "selected";
              } ?>>Always require a password when switching between users
              </option>
            </select>
          </dd>
          <dt>Use pincode</dt>
          <dd>
            <input type="checkbox" name="merchant[allow_use_pincode]" id="merchant_allow_use_pincode"></dd>
        </dl>
        <dt>Cashier discounts and returns</dt>
        <dd>
          <input type="checkbox" name="merchant[allow_cashier_discount]"
                 id="merchant_allow_cashier_discount" <?php if ($merchant['Merchant']['allow_cashier_discount'] == 1) {
            echo "checked";
          } ?>>
          Allow Cashires to apply discounts and perform returns on sales
        </dd>
        <dt>Use scale</dt>
        <dd>
          <input type="checkbox" name="merchant[allow_use_scale]" id="merchant_allow_use_scale"></dd>
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
              <input type="text" placeholder="First" name="merchant[contact][first_name]"
                     value="<?php echo $merchant['Subscriber']['Contact']['first_name']; ?>"
                     id="merchant_contact_first_name">
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6 col-omega">
              <input type="text" placeholder="Last" name="merchant[contact][last_name]"
                     value="<?php echo $merchant['Subscriber']['Contact']['last_name']; ?>"
                     id="merchant_contact_last_name">
            </div>
          </dd>
          <dt>Email</dt>
          <dd>
            <input type="email" name="merchant[contact][email]"
                   value="<?php echo $merchant['Subscriber']['Contact']['email']; ?>" id="merchant_contact_email">
          </dd>
          <dt>Phone</dt>
          <dd>
            <input type="text" name="merchant[contact][phone]"
                   value="<?php echo $merchant['Subscriber']['Contact']['phone']; ?>" id="merchant_contact_phone">
          </dd>
        </dl>
      </div>
      <div class="col-md-6">
        <dl>
          <dt>Website</dt>
          <dd>
            <input type="text" name="merchant[contact][website]"
                   value="<?php echo $merchant['Subscriber']['Contact']['website']; ?>" id="merchant_contact_website">
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
            <input type="text" name="merchant[contact][physical_address1]"
                   value="<?php echo $merchant['Subscriber']['Contact']['physical_address1']; ?>"
                   id="merchant_contact_physical_address1">
          </dd>
          <dt>Street</dt>
          <dd>
            <input type="text" name="merchant[contact][physical_address2]"
                   value="<?php echo $merchant['Subscriber']['Contact']['physical_address2']; ?>"
                   id="merchant_contact_physical_address2">
          </dd>
          <dt>Suburb</dt>
          <dd>
            <input type="text" name="merchant[contact][physical_suburb]"
                   value="<?php echo $merchant['Subscriber']['Contact']['physical_suburb']; ?>"
                   id="merchant_contact_physical_suburb">
          </dd>
          <dt>City</dt>
          <dd>
            <input type="text" name="merchant[contact][physical_city]"
                   value="<?php echo $merchant['Subscriber']['Contact']['physical_city']; ?>"
                   id="merchant_contact_physical_city">
          </dd>
          <dt>Physical postcode</dt>
          <dd>
            <input type="text" name="merchant[contact][physical_postcode]"
                   value="<?php echo $merchant['Subscriber']['Contact']['physical_postcode']; ?>"
                   id="merchant_contact_physical_postcode">
          </dd>
          <dt>State</dt>
          <dd>
            <input type="text" name="merchant[contact][physical_state]"
                   value="<?php echo $merchant['Subscriber']['Contact']['physical_state']; ?>"
                   id="merchant_contact_physical_state">
          </dd>
          <dt>Country</dt>
          <dd>
            <select name="merchant[contact][physical_country]" id="merchant_contact_physical_country">
              <option disabled>Select a country</option>
              <?php foreach ($countries as $country) { ?>
                <option
                    value="<?php echo $country['Country']['country_code']; ?>" <?php if ($merchant['Subscriber']['Contact']['physical_country'] == $country['Country']['country_code']) {
                  echo "selected";
                } ?>><?php echo $country['Country']['country_name']; ?></option>
              <?php } ?>
            </select>
          </dd>
        </dl>
      </div>
      <div class="col-md-6">
        <div class="line-box-stitle inline-block">Postal Address <span
              class="clickable same_as_physical pull-right btn btn-default">Same as Physical Address </span></div>
        <dl>
          <dt>Street</dt>
          <dd>
            <input type="text" name="merchant[contact][postal_address1]"
                   value="<?php echo $merchant['Subscriber']['Contact']['postal_address1']; ?>"
                   id="merchant_contact_postal_address1">
          </dd>
          <dt>Street</dt>
          <dd>
            <input type="text" name="merchant[contact][postal_address2]"
                   value="<?php echo $merchant['Subscriber']['Contact']['postal_address2']; ?>"
                   id="merchant_contact_postal_address2">
          </dd>
          <dt>Suburb</dt>
          <dd>
            <input type="text" name="merchant[contact][postal_suburb]"
                   value="<?php echo $merchant['Subscriber']['Contact']['postal_suburb']; ?>"
                   id="merchant_contact_postal_suburb">
          </dd>
          <dt>City</dt>
          <dd>
            <input type="text" name="merchant[contact][postal_city]"
                   value="<?php echo $merchant['Subscriber']['Contact']['postal_city']; ?>"
                   id="merchant_contact_postal_city">
          </dd>
          <dt>Postal postcode</dt>
          <dd>
            <input type="text" name="merchant[contact][postal_postcode]"
                   value="<?php echo $merchant['Subscriber']['Contact']['postal_postcode']; ?>"
                   id="merchant_contact_postal_postcode">
          </dd>
          <dt>State</dt>
          <dd>
            <input type="text" name="merchant[contact][postal_state]"
                   value="<?php echo $merchant['Subscriber']['Contact']['postal_state']; ?>"
                   id="merchant_contact_postal_state">
          </dd>
          <dt>Country</dt>
          <dd>
            <select name="merchant[contact][postal_country]" id="merchant_contact_postal_country">
              <option disabled>Select a country</option>
              <?php foreach ($countries as $country) { ?>
                <option
                    value="<?php echo $country['Country']['country_code']; ?>" <?php if ($merchant['Subscriber']['Contact']['postal_country'] == $country['Country']['country_code']) {
                  echo "selected";
                } ?>><?php echo $country['Country']['country_name']; ?></option>
              <?php } ?>
            </select>
          </dd>
        </dl>
      </div>
    </div>
  </div>
  <div class="col-md-12 col-sm-12 col-xs-12 pull-right margin-top-20 margin-bottom-20">
    <button class="btn btn-primary btn-wide save pull-right">Save</button>
    <button class="btn btn-default btn-wide cancel pull-right margin-right-10">Cancel</button>
  </div>
</div>
<!-- END CONTENT -->
<!-- ADD TAX POPUP BOX -->
<div id="popup-add_tax" class="confirmation-modal modal fade in" tabindex="-1" role="dialog" aria-hidden="false"
     style="display: none;">
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
<div class="modal-backdrop fade in" style="display: none;"></div>
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
  });

  function documentInit() {
    // common init function
    commonInit();
    Metronic.init(); // init metronic core componets
    Index.init();

    $('#merchant_default_tax_id').on('change', function (e) {
      if ($(this).val() == 'add-new') {
        $("#popup-add_tax").show();
        $(".modal-backdrop").show();
      }
    });

    $(".confirm-close").click(function () {
      $("#popup-add_tax").hide();
      $(".modal-backdrop").hide();
      $("#tax_rate").val('');
      $("#tax_name").val('');
    });

    $(".submit").click(function () {
      var tax_rate = $("#tax_rate").val().replace(/%/, '');
      $.ajax({
        url: '/taxes/add.json',
        type: 'POST',
        data: {
          name: $("#tax_name").val(),
          rate: tax_rate / 100
        }
      }).done(function (msg) {
        $("#merchant_default_tax_id").prepend('<option value="' + msg['id'] + '">' + msg['data']['name'] + ' (' + msg['data']['rate'] * 100 + '%)</option>');
        $("#merchant_default_tax_id").val(msg['id']);
        $("#popup-add_tax").hide();
        $(".modal-backdrop").hide();
      });
    });
    $(document).on('change', '#merchant_use_sku_sequence', function () {
      if ($(this).val() == 0) {
        $("#merchant_sku_sequence").parent().prev().hide();
        $("#merchant_sku_sequence").parent().hide();
      } else {
        $("#merchant_sku_sequence").parent().prev().show();
        $("#merchant_sku_sequence").parent().show();
      }
    });

    $('.same_as_physical').on('click', function (e) {
      same_as_physical();
    });

    $(".cancel").click(function () {
      location.reload();
    });

    $(".save").click(function () {
      var allow_cashier_discount;
      var allow_use_pincode;
      var allow_use_scale;

      if ($("#merchant_allow_cashier_discount").is(':checked')) {
        allow_cashier_discount = 1;
      } else {
        allow_cashier_discount = 0;
      }

      if ($("#merchant_allow_use_pincode").is(':checked')) {
        allow_use_pincode = 1;
      } else {
        allow_use_pincode = 0;
      }

      if ($("#merchant_allow_use_scale").is(':checked')) {
        allow_use_scale = 1;
      } else {
        allow_use_scale = 0;
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
          label_printer_format: $("#merchant_label_printer_format").val(),
          use_sku_sequence: $("#merchant_use_sku_sequence").val(),
          sku_sequence: $("#merchant_sku_sequence").val(),
          switching_security: $("#merchant_switching_security").val(),
          allow_cashier_discount: allow_cashier_discount,
          allow_use_pincode: allow_use_pincode,
          allow_use_scale: allow_use_scale,
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
          physical_country: $("#merchant_contact_physical_country").val(),
          postal_address1: $("#merchant_contact_postal_address1").val(),
          postal_address2: $("#merchant_contact_postal_address2").val(),
          postal_suburb: $("#merchant_contact_postal_suburb").val(),
          postal_city: $("#merchant_contact_postal_city").val(),
          postal_postcode: $("#merchant_contact_postal_postcode").val(),
          postal_state: $("#merchant_contact_postal_state").val(),
          postal_country: $("#merchant_contact_postal_country").val(),
        },
        success: function () {
          $("#notify").removeClass('hidden');
          $('html, body').animate({scrollTop: 0}, 0);
        }
      });
    });
  }
  ;

  function same_as_physical() {
    var address1 = $('#merchant_contact_physical_address1').val()
    var address2 = $('#merchant_contact_physical_address2').val()
    var suburb = $('#merchant_contact_physical_suburb').val()
    var city = $('#merchant_contact_physical_city').val()
    var postcode = $('#merchant_contact_physical_postcode').val()
    var state = $('#merchant_contact_physical_state').val()
    var country = $('#merchant_contact_physical_country').val()

    $('#merchant_contact_postal_address1').val(address1);
    $('#merchant_contact_postal_address2').val(address2)
    $('#merchant_contact_postal_suburb').val(suburb)
    $('#merchant_contact_postal_city').val(city)
    $('#merchant_contact_postal_postcode').val(postcode)
    $('#merchant_contact_postal_state').val(state)
    $('#merchant_contact_postal_country').val(country)
  }
</script>
<!-- END JAVASCRIPTS -->
