<link href="/css/dropzone.css" rel="stylesheet" type="text/css"/>
<link href="/css/loader.css" rel="stylesheet" type="text/css"/>
<div id="loader-wrapper" style="display:none">
  <div id="loader"></div>
</div>
<div id="notify"></div>
<!-- BEGIN CONTENT -->
<div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
  <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega"> Edit User </h2>
</div>
<div class="product-add">
  <div class="portlet-body form">
    <!-- BEGIN FORM-->
    <input type="hidden" name="merchant_user['id']" id="merchant_user_id"/>
    <input type="hidden" name="merchant_user['merchant_id']" id="merchant_user_merchant_id"/>

    <div class="form-horizontal">
      <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega form-title">Detail</div>
      <!-- START col-md-12-->
      <div class="form-body line-box line-box-content col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
        <!-- START col-md-12-->
        <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
          <!-- START col-md-6-->
          <div class="col-md-6 col-alpha col-omega">
            <dl>
              <dt class="col-md-4">Username</dt>
              <dd class="col-md-8">
                <input type="text" name="merchant_user['username']" id="merchant_user_username"
                       value="<?php echo $users['MerchantUser']['username']; ?>">
              </dd>
            </dl>
            <dl>
              <dt class="col-md-4">Display name</dt>
              <dd class="col-md-8">
                <input type="text" name="merchant_user['display_name']" id="merchant_user_display_name"
                       value="<?php echo $users['MerchantUser']['display_name']; ?>">
              </dd>
            </dl>
            <dl>
              <dt class="col-md-4">Email Address</dt>
              <dd class="col-md-8">
                <input type="text" name="merchant_user['email']" id="merchant_user_email"
                       value="<?php echo $users['MerchantUser']['email']; ?>">
              </dd>
            </dl>
            <dl>
              <dt class="col-md-4">Outlet</dt>
              <dd class="col-md-8">
                <select name="merchant_user['outlet_id']" id="merchant_user_outlet_id">
                  <option value=""></option>
                  <?php
                  foreach ($outlets as $outlet) :
                    $outlet_id = $outlet['MerchantOutlet']['id'];
                    $name = $outlet['MerchantOutlet']['name'];
                    ?>
                    <option
                        value="<?php echo $outlet_id; ?>" <?php if ($users['MerchantUser']['outlet_id'] == $outlet_id) {
                      echo "selected";
                    } ?>><?php echo $name; ?></option>
                    <?php
                  endforeach;
                  ?>
                </select>
              </dd>
            </dl>
          </div>
          <!-- END col-md-6-->
          <!-- START col-md-6-->
          <div class="col-md-6 col-alpha col-omega">
            <dl>
              <dt class="col-md-4">Password</dt>
              <dd class="col-md-8">
                <input type="password" name="merchant_user['password']" id="merchant_user_password">
              </dd>
            </dl>
            <dl>
              <dt class="col-md-4">Password again</dt>
              <dd class="col-md-8">
                <input type="password" name="merchant_user['password_confirm']" id="merchant_user_password_confirm">
              </dd>
            </dl>
            <dl>
              <dt class="col-md-4">User account type</dt>
              <dd class="col-md-8">
                <select name="merchant_user['user_type_id']" id="merchant_user_type_id">
                  <?php foreach ($user_types as $key => $value) : ?>
                    <?php $user_type_id = $users['MerchantUser']['user_type_id']; ?>
                    <option
                        value="<?php echo $key; ?>" <?php echo $user_type_id == $key ? "selected" : ""; ?>><?php echo $value; ?></option>
                  <?php endforeach; ?>
                </select>
              </dd>
            </dl>
          </div>
          <!-- END col-md-6-->
        </div>
        <!-- END col-md-12-->
        <div class="dashed-line-gr"></div>
        <!-- START col-md-12-->
        <div class="col-md-12 col-xs-12 col-sm-12 margin-top-20">
          <dl class="form-group">
            <dt class="col-md-2">Images</dt>
            <dd class="col-md-10">
              <form action="/file-upload" class="dropzone" id="drop-file">
                <div class="fallback">
                  <input name="file" type="file">
                </div>
              </form>
            </dd>
          </dl>
        </div>
        <!-- END col-md-12-->
      </div>
      <!-- END col-md-12-->
    </div>
    <div class="form-actions fluid">
      <div class="col-md-12 margin-top-20 col-omega">
        <div class="pull-right">
          <button type="button" id="delete" class="btn btn-default btn-wide Delete  margin-right-10">Delete</button>
          <button type="button" class="btn btn-default btn-wide cancel margin-right-10">Cancel</button>
          <button type="button" id="submit" class="btn btn-primary btn-wide">Submit</button>
        </div>
      </div>
    </div>
  </div>
  <!-- END FORM-->
</div>
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="/theme/onzsa/assets/global/plugins/respond.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/excanvas.min.js"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<?php echo $this->element('script-jquery'); ?>
<?php echo $this->element('script-angularjs'); ?>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/theme/onzsa/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/admin/pages/scripts/index.js" type="text/javascript"></script>
<script src="/js/dropzone.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN COMMON INIT -->
<?php echo $this->element('common-init'); ?>
<!-- END COMMON INIT -->
<script>

  jQuery(document).ready(function (){
    documentInit();
  });

    function documentInit() {
      // common init function
      commonInit();
    $("#submit").click(function () {
      $.ajax({
        url: location.pathname + '.json',
        type: 'POST',
        data: {
          user_type_id: $("#merchant_user_type_id").val(),
          username: $("#merchant_user_username").val(),
          password: $("#merchant_user_password").val(),
          display_name: $("#merchant_user_display_name").val(),
          email: $("#merchant_user_email").val(),
          outlet_id: $("#merchant_user_outlet_id").val()
        },
        success: function (result) {
          if (result.success) {
            window.location.href = "/users/" + result.user_id;
          } else {
            console.log(result);
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log(textStatus, errorThrown);
        }
      });
    });

      $("#delete").click(function () {
        $.ajax({
          url: location.pathname + '.json',
          type: 'POST',
          data: {
            is_deleted: 1
          },
          success: function (result) {
            if (result.success) {
              window.location.href = "/users/" + result.user_id;
            } else {
              console.log(result);
            }
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
          }
        });
      });
  }
</script>
<!-- END JAVASCRIPTS --> 
