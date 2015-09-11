<link href="/css/dataTable.css" rel="stylesheet" type="text/css">
<div class="clearfix"></div>
<!-- BEGIN CONTENT -->
<div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
  <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">Add Customer</h2>
</div>
<div class="col-md-12 col-sm-12 col-xs-12">
  <div class="line-box col-md-12 col-sm-12 col-xs-12 col-alpha col-omega">
    <div class="col-md-6 col-sm-6 col-xs-6">
      <dl class="pull-left">
        <dt>Contact name</dt>
        <dd>
          <div class="col-md-6 col-sm-6 col-xs-6 col-alpha">
            <input type="text" placeholder="First" class="name_first">
          </div>
          <div class="col-md-6 col-sm-6 col-xs-6 col-omega col-alpha">
            <input type="text" placeholder="Last" class="name_last">
          </div>
        </dd>
        <dt>Company</dt>
        <dd><input type="text" class="company_name"></dd>
        <dt>Customer code</dt>
        <dd><input type="text" class="customer_code pull-left required"></dd>
        <dt>Customer group</dt>
        <dd><select class="customer_group">
            <?php foreach ($groups as $group) { ?>

              <option
                  value="<?= $group['MerchantCustomerGroup']['id']; ?>"><?= $group['MerchantCustomerGroup']['name']; ?></option>

            <?php } ?>
          </select></dd>
      </dl>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-6">
      <dl>
        <dt>Date of birth</dt>
        <dd>
          <div class="col-md-4 col-sm-4 col-xs-4 col-alpha">
            <input type="text" class="customer_dd" placeholder="DD" maxlength="2">
          </div>
          <div class="col-md-4 col-sm-4 col-xs-4 col-alpha">
            <input type="number" class="customer_mm" placeholder="MM" maxlength="2">
          </div>
          <div class="col-md-4 col-sm-4 col-xs-4 col-alpha">
            <input type="number" class="customer_yyyy" placeholder="YYYY" maxlength="4">
          </div>
        </dd>
        <dt>Gender</dt>
        <dd>
          <div class="col-md-6 col-sm-6 col-xs-6 col-alpha">
            <input type="radio" id="female" value="F" name="gender"><label for="female"> Female</label>
          </div>
          <div class="col-md-6 col-sm-6 col-xs-6 col-alpha">
            <input type="radio" id="male" value="M" name="gender"><label for="male"> Male</label>
          </div>
        </dd>
      </dl>
    </div>
  </div>
  <div class="col-md-12 col-sm-12 col-xs-12 margin-top-20 col-alpha col-omega">
    <div class="line-box col-md-12 col-sm-12 col-xs-12">
      <div class="col-md-6 col-sm-6 col-xs-6">
        <dl>
          <dt>Phone</dt>
          <dd><input type="text" class="phone"></dd>
          <dt>Mobile</dt>
          <dd><input type="text" class="mobile"></dd>
        </dl>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-6">
        <dl>
          <dt>Email</dt>
          <dd><input type="email" class="email"></dd>
          <dt>Website</dt>
          <dd><input type="text" class="website"></dd>
        </dl>
      </div>
    </div>
  </div>

  <div class="col-md-12 col-sm-12 col-xs-12 margin-top-20 col-alpha col-omega">
    <div class="line-box col-md-12 col-sm-12 col-xs-12">
      <div class="col-md-6 col-sm-6 col-xs-6">
        <div class="line-box-stitle">Physical Address</div>
        <dl>
          <dt>Street</dt>
          <dd><input type="text" class="physical_street_1"></dd>
          <dt>Street</dt>
          <dd><input type="text" class="physical_street_2"></dd>
          <dt>Suburb</dt>
          <dd><input type="text" class="physical_suburb"></dd>
          <dt>City</dt>
          <dd><input type="text" class="physical_city"></dd>
          <dt>Physical postcode</dt>
          <dd><input type="text" class="physical_postcode"></dd>
          <dt>State</dt>
          <dd><input type="text" class="physical_state"></dd>
          <dt>Country</dt>
          <dd><select class="physical_country">
              <option>Select a country</option>
              <option value="NZ">NZ</option>
            </select></dd>
        </dl>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-6">
        <div class="line-box-stitle">Postal Address
          <span class="clickable same_as_physical pull-right btn btn-default">Same as Physical Address</span>
        </div>
        <dl>
          <dt>Street</dt>
          <dd><input type="text" class="postal_street_1"></dd>
          <dt>Street</dt>
          <dd><input type="text" class="postal_street_2"></dd>
          <dt>Suburb</dt>
          <dd><input type="text" class="postal_suburb"></dd>
          <dt>City</dt>
          <dd><input type="text" class="postal_city"></dd>
          <dt>Physical postcode</dt>
          <dd><input type="text" class="postal_postcode"></dd>
          <dt>State</dt>
          <dd><input type="text" class="postal_state"></dd>
          <dt>Country</dt>
          <dd><select class="postal_country">
              <option>Select a country</option>
              <option value="1">NZ</option>
            </select></dd>
        </dl>
      </div>
    </div>
  </div>

  <div class="col-md-12 col-sm-12 col-xs-12 margin-top-20 col-alpha col-omega">
    <div class="line-box col-md-12 col-sm-12 col-xs-12">
      <div class="col-md-6 col-sm-6 col-xs-6">
        <dl>
          <dt>Custom Field 1</dt>
          <dd><input type="text" class="customer_field_1"></dd>
          <dt>Custom Field 2</dt>
          <dd><input type="text" class="customer_field_2"></dd>
          <dt>Custom Field 3</dt>
          <dd><input type="text" class="customer_field_3"></dd>
          <dt>Custom Field 4</dt>
          <dd><input type="text" class="customer_field_4"></dd>
        </dl>
      </div>
      <div class="col-md-6 col-sm-6 col-xs-6">
        <dl>
          <dt>Note</dt>
          <dd><textarea class="customer_note" rows="5" style="width:100%;"></textarea></dd>
        </dl>
      </div>
    </div>
  </div>
  <div class="col-md-12 col-sm-12 col-xs-12 pull-right margin-top-20 margin-bottom-20">
    <button class="btn btn-primary btn-wide save pull-right">Save</button>
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


  <script src="/theme/onzsa/assets/admin/layout/scripts/quick-sidebar.js"></script>
  <script src="/theme/onzsa/assets/admin/pages/scripts/index.js"></script>
  <script src="/theme/onzsa/assets/admin/pages/scripts/tasks.js"></script>
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
      Layout.init(); // init layout
      QuickSidebar.init() // init quick sidebar
      Index.init();

      $(document).on("click", ".same_as_physical", function () {
        $(".postal_street_1").val($(".physical_street_1").val());
        $(".postal_street_2").val($(".physical_street_2").val());
        $(".postal_suburb").val($(".physical_suburb").val());
        $(".postal_city").val($(".physical_city").val());
        $(".postal_postcode").val($(".physical_postcode").val());
        $(".postal_state").val($(".physical_state").val());
        $(".postal_country").val($(".physical_country").val());
      });
    };
  </script>
  <!-- END JAVASCRIPTS -->

  <script>

    $(".save").click(function () {
      var gender;
      $("input[type=radio]").each(function () {
        if ($(this).attr("checked")) {
          gender = $(this).val();
        }
      });

      $(".required").each(function () {
        if ($(this).val() == "") {
          $(this).parent().addClass("incorrect");
          $('<h5 class="incorrect-message"><i class="glyphicon glyphicon-remove-circle margin-right-5"></i>This field is required.</h5>').insertAfter($(this));
        } else {
          $(this).parent().removeClass("incorrect");
        }
      });

      if ($(".incorrect").length == 0) {
        $.ajax({
          url: '/customer/add.json',
          type: 'POST',
          data: {
            company_name: $(".company_name").val(),
            first_name: $(".name_first").val(),
            last_name: $(".name_last").val(),
            birthday: $(".customer_yyyy").val() + '-' + $(".customer_mm").val() + '-' + $(".customer_dd").val(),
            phone: $(".phone").val(),
            mobile: $(".mobile").val(),
            email: $(".email").val(),
            website: $(".website").val(),
            physical_address1: $(".physical_street_1").val(),
            physical_address2: $(".physical_street_2").val(),
            physical_suburb: $(".physical_suburb").val(),
            physical_city: $(".physical_city").val(),
            physical_state: $(".physical_state").val(),
            physical_postcode: $(".physical_postcode").val(),
            physical_country: $(".physical_country").val(),
            postal_address1: $(".postal_street_1").val(),
            postal_address2: $(".postal_street_2").val(),
            postal_suburb: $(".postal_suburb").val(),
            postal_city: $(".postal_city").val(),
            postal_state: $(".postal_state").val(),
            postal_postcode: $(".postal_postcode").val(),
            postal_country: $(".postal_country").val(),
            customer_group_id: $(".customer_group").val(),
            customer_code: $(".customer_code").val(),
            name: $(".name_first").val() + ' ' + $(".name_last").val(),
            gender: gender,
            user_field_1: $(".customer_field_1").val(),
            user_field_2: $(".customer_field_2").val(),
            user_field_3: $(".customer_field_3").val(),
            user_field_4: $(".customer_field_4").val(),
            note: $(".customer_note").val()
          },
          success: function (result) {
            if (result.success) {
              window.location.href = "/customer";
            } else {
              console.log(result);
            }
          }
        });
      } else {
        $("html, body").animate({scrollTop: 0}, "slow");
      }
    });
  </script>
