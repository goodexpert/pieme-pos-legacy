<style>
.line-box-stitle {
    padding: 8px 20px;
}
.help-block {
    padding-left: 14px;
}
.variant_add {
    float: left;
    padding-top: 12px;
    margin-left: 29px;
    font-size: 12px;
    color: blue;
    text-decoration: underline;
}
.variant_max {
    float: left;
    padding-top: 12px;
    margin-left: 29px;
    font-size: 12px;
}
.variant_add:hover {
    cursor: pointer;
}
</style>

<link href="/css/dropzone.css" rel="stylesheet" type="text/css"/>
<link href="/css/loader.css" rel="stylesheet" type="text/css"/>
<div class="clearfix"> </div>
<!-- BEGIN CONTAINER -->
<div class="page-container">

    <div id="loader-wrapper" style="display:none">
    
        <div id="loader"></div>
        
    </div>


  <div id="notify"></div>
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
              <input type="text" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
              <button class="btn submit"><i class="icon-magnifier"></i></button>
              </span> </div>
          </form>
          <!-- END RESPONSIVE QUICK SEARCH FORM --> 
        </li>
        <li> <a href="index"> Sell </a> </li>
        <li> <a href="history"> History </a> </li>
        <li class="active"> <a href="history"> Product <span class="selected"></span> </a> </li>
      </ul>
    </div>
    <!-- END HORIZONTAL RESPONSIVE MENU --> 
  </div>
  <!-- END SIDEBAR --> 
  <!-- BEGIN CONTENT -->
  <div class="page-content-wrapper">
    <div class="page-content">
      <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
        <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega"> Edit User </h2>
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
                        <input type="text" name="merchant_user['username']" id="merchant_user_username" value="<?php echo $users['MerchantUser']['username'];?>">                
                     </dd>
                  </dl>
                  <dl>
                    <dt class="col-md-4">Display name</dt>
                    <dd class="col-md-8">
                        <input type="text" name="merchant_user['display_name']" id="merchant_user_display_name" value="<?php echo $users['MerchantUser']['display_name'];?>">                
                     </dd>
                  </dl>
                  <dl>
                    <dt class="col-md-4">Email Address</dt>
                    <dd class="col-md-8">
                        <input type="text" name="merchant_user['email']" id="merchant_user_email" value="<?php echo $users['MerchantUser']['email'];?>">                
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
                            <option value="<?php echo $outlet_id; ?>" <?php if($users['MerchantUser']['outlet_id'] == $outlet_id){echo "selected";}?>><?php echo $name; ?></option>
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
                        <select name="merchant_user['user_type']" id="merchant_user_type">
                        <?php
                            foreach($user_types as $user_type) :
                                $type = $user_type['MerchantUserType']['user_type'];
                         ?>
                            <option value="<?php echo $type; ?>" <?php if($users['MerchantUser']['user_type'] == $type){echo "selected";}?>><?php echo ucwords($type); ?></option>
                        <?php
                            endforeach;
                         ?>
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
<script src="assets/global/plugins/respond.min.js"></script>
<script src="assets/global/plugins/excanvas.min.js"></script> 
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
<!-- END PAGE LEVEL SCRIPTS --> 
<script>
jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    Index.init();
    
    $("#submit").click(function(){
        $.ajax({
            url: location.href+'.json',
            type: 'POST',
            data: {
                user_type: $("#merchant_user_type").val(),
                username: $("#merchant_user_username").val(),
                password: $("#merchant_user_password").val(),
                display_name: $("#merchant_user_display_name").val(),
                email: $("#merchant_user_email").val(),
                outlet_id: $("#merchant_user_outlet_id").val()
            },
            success: function(result) {
                if(result.success) {
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
<!-- END JAVASCRIPTS --> 
<script src="/js/dropzone.js"></script> 