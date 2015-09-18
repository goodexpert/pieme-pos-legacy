<?php
$AuthUser = $this->Session->read('Auth.User');
?>
<link href="/css/dropzone.css" rel="stylesheet" type="text/css"/>
<link href="/css/dataTable.css" rel="stylesheet" type="text/css"/>
<div class="clearfix"></div>
<div id="notify"></div>

<div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega margin-bottom-20">
  <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
    Users
  </h2>

  <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20 customer_quick_add">
    <button class="btn btn-white pull-right">
      <div class="glyphicon glyphicon-plus"></div>
      &nbsp;
      Add user
    </button>
    </a>
  </div>
</div>
<!-- FILTER -->
<form class="col-md-12 col-xs-12 col-sm-12 line-box filter-box" action="/setup/user" method="get">
  <div class="col-md-4 col-xs-4 col-sm-4">
    <dl>
      <dt>Account Type</dt>
      <dd>
        <?php
        echo $this->Form->input('user_type_id', [
            'id' => 'merchant_user_type_id',
            'name' => 'merchant_user[user_type_id]',
            'type' => 'select',
            'div' => false,
            'label' => false,
            'empty' => '',
            'options' => $user_types,
            'default' => $filter['user_type_id']
        ]);
        ?>
      </dd>
    </dl>
  </div>
  <div class="col-md-4 col-xs-4 col-sm-4">
    <dl>
      <dt class="col-md-4">Outlet</dt>
      <dd class="col-md-8">
        <?php
        echo $this->Form->input('outlet_id', [
            'id' => 'merchant_outlet_id',
            'name' => 'merchant_user[outlet_id]',
            'type' => 'select',
            'div' => false,
            'label' => false,
            'empty' => '',
            'options' => $outlets,
            'default' => $filter['outlet_id']
        ]);
        ?>
      </dd>
    </dl>
  </div>
  <div class="col-md-12 col-xs-12 col-sm-12">
    <button type="submit" class="btn btn-primary filter pull-right">Update</button>
  </div>
</form>
<table id="historyTable" class="table table-striped table-bordered dataTable">
  <colgroup>
    <col width="5%">
    <col width="17%">
    <col width="17%">
    <col width="17%">
    <col width="17%">
    <col width="17%">
  </colgroup>
  <thead>
  <tr>
    <th></th>
    <th>ID</th>
    <th>Name</th>
    <th>Account Type</th>
    <th>Outlet</th>
    <th>Last Login</th>
  </tr>
  </thead>
  <tbody>
  <?php foreach ($users as $user) : ?>
    <tr>
      <td class="text-center"><img src="../img/no-image.png" alt="user-image"></td>
      <td>
        <a href="/users/<?php echo $user['MerchantUser']['id']; ?>"><?php echo $user['MerchantUser']['username']; ?></a>
      </td>
      <td><?php echo $user['MerchantUser']['display_name']; ?></td>
      <td><?php echo $user['MerchantUserType']['name']; ?></td>
      <td><?php echo $user['MerchantOutlet']['name']; ?></td>
      <td><?php echo $user['MerchantUser']['last_logged']; ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<div class="modal-backdrop fade in" style="display:<?php if (empty($user['MerchantRegister'])) {
  echo "block";
} else {
  echo "none";
}; ?>"></div>
</div>
</div>
<!-- END CONTENT -->
<!-- USER ADD BOX -->
<div class="confirmation-modal modal fade in customer_add" tabindex="-1" role="dialog" aria-hidden="false">
  <div class="vertical-alignment-helper">
    <div class="modal-dialog vertical-align-center">
      <div class="modal-content add-user-container">
        <div class="form-horizontal">
          <form id="user-add-form" method="post">
            <div class="modal-header">
              <button type="button" class="confirm-close cancel" data-dismiss="modal"
                      aria-hidden="true">
                <i class="glyphicon glyphicon-remove"></i>
              </button>
              <h4 class="modal-title">Add a new User</h4>
            </div>
            <!-- START col-md-12-->
            <div class="modal-body ">
              <!-- START col-md-12-->
              <div class="">
                <!-- START col-md-6-->
                <div class="col-md-5 col-alpha col-omega">
                  <dl>
                    <dt class="col-md-3">Images</dt>
                    <dd class="col-md-8" style="height: 160px;">
                      <div action="/file-upload" class="dropzone dropzone-background"
                           id="myAwesomeDropzone">
                        <div class="dz-message dz-default"><span>Please Click Here To Upload File! </span>
                        </div>
                      </div>
                    </dd>
                  </dl>
                </div>
                <!-- END col-md-6-->
                <!-- START col-md-6-->
                <div class="col-md-7 col-alpha col-omega">
                  <dl>
                    <dt class="col-md-4">Id</dt>
                    <dd class="col-md-8">
                      <?php if ($AuthUser['Merchant']['allow_use_pincode'] === "1"): ?>
                        <input type="text" name="MerchantUser[username]" id="merchant_user_username"
                               placeholder="Enter 4 digit "></input>
                      <?php else: ?>
                        <input type="text" name="MerchantUser[username]" id="merchant_user_username"
                               placeholder="username@onzsa.com"></input>
                      <?php endif; ?>
                      <div class="help-block with-errors"></div>
                    </dd>
                    <?php if ($AuthUser['Merchant']['allow_use_pincode'] === "0"): ?>
                      <dt class="col-md-4">Password</dt>
                      <dd class="col-md-8">
                        <input type="password" title="Please agree to our policy!" name="MerchantUser[password]"
                               id="merchant_user_password">

                        <div class="help-block with-errors"></div>
                      </dd>
                      <dt class="col-md-4">Confirm password</dt>
                      <dd class="col-md-8">
                        <input type="password" name="MerchantUser[password_confrim]"
                               id="merchant_user_password_confirm">
                      </dd>
                    <?php endif; ?>
                    <dt class="col-md-4">name</dt>
                    <dd class="col-md-8">
                      <input type="text" name="MerchantUser[display_name]"
                             title="Please agree to our policy!"
                             id="merchant_user_display_name">

                      <div class="help-block with-errors"></div>
                    </dd>
                    <dt class="col-md-4">Email Address</dt>
                    <dd class="col-md-8">
                      <input type="text" name="MerchantUser[email]" id="merchant_user_email">
                    </dd>
                    <dt class="col-md-4">User account type</dt>
                    <dd class="col-md-8">
                      <?php
                      echo $this->Form->input('user_type_id', [
                          'id' => 'merchant_user_type_id_modal',
                          'name' => 'MerchantUser[user_type_id]',
                          'type' => 'select',
                          'div' => false,
                          'label' => false,
                          'options' => $user_types
                      ]);
                      ?>
                    </dd>
                    <dt class="col-md-4">Outlet</dt>
                    <dd class="col-md-8">
                      <?php
                      echo $this->Form->input('outlet_id', [
                          'id' => 'merchant_user_outlet_id_modal',
                          'name' => 'MerchantUser[outlet_id]',
                          'type' => 'select',
                          'div' => false,
                          'label' => false,
                          'empty' => '',
                          'options' => $outlets
                      ]);
                      ?>
                    </dd>
                  </dl>
                </div>
                <!-- END col-md-6-->
              </div>
              <!-- END col-md-12-->
            </div>
            <!-- END col-md-12-->
            <div class="modal-footer">
              <div class="pull-right">
                <button class="btn add_customer-submit btn-success" type="submit"
                        data-dismiss="modal">Save
                </button>
                <button class="cancel btn btn-primary" type="button" data-dismiss="modal">Cancel
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
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


    <script src="/theme/onzsa/assets/admin/pages/scripts/tasks.js"></script>
    <script src="/js/notify.js"></script>
    <script src="/js/dropzone.js"></script>
    <script src="/theme/onzsa/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <?php echo $this->element('common-init'); ?>

    <script>
      jQuery(document).ready(function () {
        documentInit();
      });

      function documentInit() {
        // common init function
        commonInit();
        formValidation();
        $(".modal-backdrop").hide();
      };

      $(".confirm-close").click(function () {
        $(".fade").hide();
      });
      $(document).on('click', '.cancel', function () {
        $('.fade').hide();
      });


      $(".customer_quick_add").click(function () {
        $(".customer_add").show();
        $(".modal-backdrop").show();
      });
      Dropzone.options.myAwesomeDropzone = {
        accept: function (file, done) {
          console.log("uploaded");
          done();
        },
        init: function () {
          this.on("addedfile", function () {
            if (this.files[1] != null) {
              this.removeFile(this.files[0]);
            }
          });
        }
      };
      <?php if ($AuthUser['Merchant']['allow_use_pincode'] === "1"):?>
      // form validation
      var formValidation = function () {
        $("#user-add-form").validate({
          rules: {
            'MerchantUser[display_name]': {
              required: true,
              minlength: 4
            },
            'MerchantUser[username]': {
              required: true,
              remote: {
                url: '/signup/check_username.json',
                type: 'post',
                data: {
                  username: function () {
                    return $("#username").val();
                  }
                },
                dataFilter: function (data) {
                  var json = JSON.parse(data);
                  return JSON.stringify(!json.is_exist);
                }
              },
              length: 4,
            }
          },
          messages: {
            'MerchantUser[display_name]': {
              required: "Please enter your store name.",
              minlength: "Your store name must be at least 4 characters."
            },
            "MerchantUser[username]": {
              required: "Please enter 4 digit pincode.",
              remote: "Your code already registered.",
              length: "Please enter 4 digit pincode."
            }
          },
          errorPlacement: function (error, element) {

            element.parent("dd").find(".help-block").html(error);
          }
        });
      }
      <?php else:?>
      // form validation
      var formValidation = function () {
        // for more info visit the official plugin documentation:
        // http://docs.jquery.com/Plugins/Validation
        $("#user-add-form").validate({
          rules: {
            'MerchantUser[display_name]': {
              required: true,
              minlength: 4
            },
            'MerchantUser[username]': {
              required: true,
              email: true,
              remote: {
                url: '/signup/check_username.json',
                type: 'post',
                data: {
                  username: function () {
                    return $("#username").val();
                  }
                },
                dataFilter: function (data) {
                  var json = JSON.parse(data);
                  return JSON.stringify(!json.is_exist);
                }
              }
            },
            "MerchantUser[password]": {
              required: true,
              minlength: 6
            }
          },
          messages: {
            "MerchantUser[display_name]": {
              required: "Please enter your store name.",
              minlength: "Your store name must be at least 4 characters."
            },
            "MerchantUser[username]": {
              required: "Please enter your email address.",
              email: "Please enter a valid email address.",
              remote: "Your email already registered."
            },
            "MerchantUser[password]": {
              required: "Please enter a password.",
              minlength: "Your password must be at least 6 characters."
            }
          },
          errorPlacement: function (error, element) {

            element.parent("dd").find(".help-block").html(error);
          }
        });
        console.log("00")

      }
      <?php endif; ?>
      $(".add_customer-submit").click(function () {
        $.ajax({
          url: '/users/add.json',
          type: 'POST',
          data: {
            user_type_id: $("#merchant_user_type_id_modal").val(),
            username: $("#merchant_user_username").val(),
            password: $("#merchant_user_password").val(),
            display_name: $("#merchant_user_display_name").val(),
            email: $("#merchant_user_email").val(),
            outlet_id: $("#merchant_user_outlet_id_modal").val()
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
    </script>
    <!-- END JAVASCRIPTS -->
