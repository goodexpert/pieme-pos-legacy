<link href="/css/dropzone.css" rel="stylesheet" type="text/css"/>
<link href="/css/loader.css" rel="stylesheet" type="text/css"/>
    <div id="loader-wrapper" style="display:block">
        <div id="loader"></div>
    </div>
  <div id="notify"></div>
  <!-- BEGIN CONTENT -->
  <div class="page-content-wrapper">
    <div class="page-content">
      <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
        <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega"> Add User </h2>
      </div>
      <div class="portlet box product-add">
        <div class="portlet-body form"> 
          <!-- BEGIN FORM-->
          <input type="hidden" name="merchant_user['id']" id="merchant_user_id" />
          <input type="hidden" name="merchant_user['merchant_id']" id="merchant_user_merchant_id" />
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
                        <input type="text" name="merchant_user['username']" id="merchant_user_username" placeholder="username@onzsa.com">                
                     </dd>
                  </dl>
                  <dl>
                    <dt class="col-md-4">Display name</dt>
                    <dd class="col-md-8">
                        <input type="text" name="merchant_user['display_name']" id="merchant_user_display_name">                
                     </dd>
                  </dl>
                  <dl>
                    <dt class="col-md-4">Email Address</dt>
                    <dd class="col-md-8">
                        <input type="text" name="merchant_user['email']" id="merchant_user_email">                
                     </dd>
                  </dl>
                  <dl>
                    <dt class="col-md-4">Outlet</dt>
                    <dd class="col-md-8">
                        <select name="merchant_user['outlet_id']" id="merchant_user_outlet_id">
                        <?php
                            foreach($outlets as $outlet) :
                                $outlet_id = $outlet['MerchantOutlet']['id'];
                                $name = $outlet['MerchantOutlet']['name'];
                         ?>
                            <option value="<?php echo $outlet_id; ?>"><?php echo $name; ?></option>
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
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
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
                <button type="button" class="btn btn-default btn-wide cancel margin-right-10">Cancel</button>
                <button type="button" id="submit" class="btn btn-primary btn-wide">Submit</button>
              </div>
            </div>
          </div>
        </div>
        <!-- END FORM--> 
      </div>
    </div>
</div>
<!-- END CONTAINER -->
</div>
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) --> 
<!-- BEGIN CORE PLUGINS --> 
<!--[if lt IE 9]>
<script src="/theme/onzsa/assets/global/plugins/respond.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/excanvas.min.js"></script> 
<![endif]--> 
<script src="/theme/onzsa/assets/global/plugins/jquery-1.11.0.min.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/global/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script> 
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip --> 
<script src="/theme/onzsa/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script> 
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS --> 
<script src="/theme/onzsa/assets/global/scripts/metronic.js" type="text/javascript"></script> 
<script src="/theme/onzsa/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/admin/pages/scripts/index.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS --> 
<script>
jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    Index.init();

    $("#submit").click(function(){
        $.ajax({
            url: '/users/add.json',
            type: 'POST',
            data: {
                user_type_id: $("#merchant_user_type_id").val(),
                username: $("#merchant_user_username").val(),
                password: $("#merchant_user_password").val(),
                display_name: $("#merchant_user_display_name").val(),
                email: $("#merchant_user_email").val(),
                outlet_id: $("#merchant_user_outlet_id").val()
            },
            success: function(result) {
                if (result.success) {
                    window.location.href = "/users/"+result.user_id;
                } else {
                    console.log(result);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });
});
</script> 
<script src="/js/dropzone.js"></script> 
