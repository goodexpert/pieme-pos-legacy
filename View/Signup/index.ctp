<div class="clearfix"></div>
<div class="container">
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content sell-index col-lg-12 col-md-12 col-sm-12 col-xs-12 col-alpha col-omega">
            <div class="maximum col-lg-12 col-md-12 col-sm-12 col-xs-12 col-alpha col-omega">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7 signup-img">
                        <img src="/img/ipad.png" alt="signup-img" >
                    </div>
                    <!-- General Information -->
                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 signup-container">
                        <p class="pull-right grey-text signin">Already have an account? <a href="/signin">Sign in</a></p>
                        <div class="line-box">
                            <form action="/signup" method="post" id="signup_form">
                            <?php
                                echo $this->Form->input('plan_id', array(
                                    'id' => 'plan_id',
                                    'type' => 'hidden',
                                    'value' => 'subscriber_plan_retailer_trial'
                                ));

                                echo $this->Form->input('physical_city', array(
                                    'id' => 'physical_city',
                                    'type' => 'hidden'
                                ));

                                echo $this->Form->input('physical_country', array(
                                    'id' => 'physical_country',
                                    'type' => 'hidden'
                                ));

                                echo $this->Form->input('time_zone', array(
                                    'id' => 'time_zone',
                                    'type' => 'hidden'
                                ));
                             ?>
                            <h1>Sign up</h1>
                            <div class="dashed-line-gr"><?php echo $this->Session->flash(); ?></div>
                            <dl>
                                <dt>Store name</dt>
                                <dd>
                                    <?php
                                        echo $this->Form->input('name', array(
                                            'id' => 'name',
                                            'type' => 'text',
                                            'class' => 'form-control',
                                            'div' => false,
                                            'label' => false,
                                            'placeholder' => 'Store name'
                                        ));
                                     ?>
                                    <div class="help-block with-errors"></div>
                                </dd>
                                <dt>Private web address</dt>
                                <dd>
                                    <div class="input-group">
                                    <?php
                                        echo $this->Form->input('domain_prefix', array(
                                            'id' => 'domain_prefix',
                                            'type' => 'text',
                                            'class' => 'form-control',
                                            'div' => false,
                                            'label' => false,
                                            'placeholder' => 'Private web address'
                                        ));
                                     ?>
                                        <span class="input-group-addon">.onzsa.com</span>
                                    </div>
                                    <div class="help-block with-errors"></div>
                                </dd>
                                <dt>First name</dt>
                                <dd>
                                    <?php
                                        echo $this->Form->input('first_name', array(
                                            'id' => 'first_name',
                                            'type' => 'text',
                                            'class' => 'form-control',
                                            'div' => false,
                                            'label' => false,
                                            'placeholder' => 'First name'
                                        ));
                                     ?>
                                    <div class="help-block with-errors"></div>
                                </dd>
                                <dt>Last name</dt>
                                <dd>
                                    <?php
                                        echo $this->Form->input('last_name', array(
                                            'id' => 'last_name',
                                            'type' => 'text',
                                            'class' => 'form-control',
                                            'div' => false,
                                            'label' => false,
                                            'placeholder' => 'Last name'
                                        ));
                                     ?>
                                    <div class="help-block with-errors"></div>
                                </dd>
                                <dt>Email address</dt>
                                <dd>
                                    <?php
                                        echo $this->Form->input('username', array(
                                            'id' => 'username',
                                            'type' => 'text',
                                            'class' => 'form-control',
                                            'div' => false,
                                            'label' => false,
                                            'placeholder' => 'Email address'
                                        ));
                                     ?>
                                    <div class="help-block with-errors"></div>
                                </dd>
                                <dt>Password</dt>
                                <dd>
                                    <?php
                                        echo $this->Form->input('password', array(
                                            'id' => 'password',
                                            'type' => 'password',
                                            'class' => 'form-control',
                                            'div' => false,
                                            'label' => false,
                                            'placeholder' => 'Password'
                                        ));
                                     ?>
                                    <div class="help-block with-errors"></div>
                                </dd>
                                <dt>City</dt>
                                <dd>
                                    <?php
                                        echo $this->Form->input('address_lookup', array(
                                            'id' => 'address_lookup',
                                            'type' => 'text',
                                            'class' => 'form-control',
                                            'div' => false,
                                            'label' => false,
                                            'placeholder' => 'City'
                                        ));
                                     ?>
                                </dd>
                                <dt>Currency</dt>
                                <dd>
                                    <select name="data[default_currency]" id="default_currency" class="form-control">
                                        <option value="USD" disabled>US Dollar</option>
                                        <option value="GBP" disabled>UK Pounds</option>
                                        <option value="EUR" disabled>Euro</option>
                                        <option value="AUD" disabled>Australian Dollar</option>
                                        <option value="NZD">New Zealand Dollar</option>
                                        <option value="KRW" disabled>South Korean Won</option>
                                    </select>
                                </dd>
								<dt> Terms</dt>
								<dd>
									<p><a href ="http://www.onzsa.com/terms.html" target="_blank"> Terms and conditions </a><p>
									<input type="checkbox" title="Please agree to our policy!" name="data[agree]" id="terms" class="form-control"/>
                                    <label class="error" for="data[agree]" style="display: none;">Please agree to our policy!</label>									</input>
									<div class="help-block with-errors"></div>
									</dd>
								
                            </dl>
                            <!--
                            <div class="dashed-line-gr"></div>
                            <dl>
                                <dt>Type</dt>
                                <dd>
                                    <select id="plan_id_1" name="plan_id_1">
                                        <option value="subscriber_plan_retailer">Single Merchant</option>
                                        <option value="subscriber_plan_franchise">Join Franchise</option>
                                        <option value="subscriber_plan_franchise_hq">Open Franchise</option>
                                        <option value="subscriber_plan_retailer_trial" selected>Trial</option>
                                    </select>
                                </dd>
                                <dt class="plan_id_2" style="display: none;">Plan</dt>
                                <dd class="plan_id_2" style="display: none;">
                                    <select id="plan_id_2" name="plan_id_2">
                                        <option value="small">Small</option>
                                        <option value="medium">Medium</option>
                                        <option value="large">Large</option>
                                        <option value="xlarge">Extra Large</option>
                                    </select>
                                    <h5><a>Detail about our plan</a></h5>
                                </dd>
                                <dt class="merchant_code" style="display: none;">Store code</dt>
                                <dd class="merchant_code" style="display: none;">
                                    <input type="text" id="merchant_code" name="merchant_code" maxlength="6" placeholder="Enter store code" autocomplete="off">
                                    <input type="hidden" id="subscriber_id" name="subscriber_id">
                                    <input type="hidden" id="parent_merchant_id" name="parent_merchant_id">
                                </dd>
                            </dl>
                            -->


                            <div class="dashed-line-gr"></div>
                            <button type="submit" id="signup" class="btn btn-success" >Start</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT --> 
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
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/theme/onzsa/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/select2/select2.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/theme/onzsa/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/admin/pages/scripts/login-soft.js" type="text/javascript"></script>
<script src="https://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&language=kr" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>

jQuery(document).ready(function() {
    Metronic.init(); // init metronic core components
    Layout.init(); // init current layout
    Login.init();

    // initialize Google Maps API
    initGoogleMapsApi();

    formValidation();

    $(document).on("change", "#address_lookup", function(e) {
        document.getElementById('physical_city').value = null;
        document.getElementById('physical_country').value = null;
    });

/*
    $(document).on("keyup", "#merchant_code", function() {
        if($(this).val().length == 6) {
            console.log("Identifying...");

            $.ajax({
                url: '/signup/check_exist.json',
                type: 'POST',
                data: {
                    merchant_code: $("#merchant_code").val()
                },
                success: function(result) {
                    if(result.success) {
                        $("#subscriber_id").val(result.subscriber_id);
                        $("#store_name").val(result.store_name);
                        $("#parent_merchant_id").val(result.merchant_id);
                        $("#merchant_code").removeClass("invalid");
                        $("#signup").attr({"disabled":false});
                    } else {
                        $("#subscriber_id").val('');
                        $("#store_name").val('');
                        $("#parent_merchant_id").val('');
                        $("#merchant_code").addClass("invalid");
                        $("#signup").attr({"disabled":true});
                    }
                }
            });
        }
    });
*/
});


function initGoogleMapsApi() {
    var input = document.getElementById('address_lookup');
    var options = {
        types: ['(cities)'],
        componentRestrictions: {country: 'nz'}
    };

    var autocomplete = new google.maps.places.Autocomplete(input, options);

    google.maps.event.addListener(autocomplete, 'place_changed', function() {
        var place = autocomplete.getPlace();
        console.log(place);
        for (var i = 0; i < place.address_components.length; i++){
            for (var j = 0; j < place.address_components[i].types.length; j++){
                var addressType = place.address_components[i].types[j];
                if (addressType == 'locality') {
                    city = place.address_components[i].long_name;
                    document.getElementById('physical_city').value = city;
                }
                if (addressType == 'country') {
                    country_code = place.address_components[i].short_name;
                    document.getElementById('physical_country').value = country_code;
                }
            }
        }

        timestamp = new Date().getTime() / 1000;
        $.ajax({
            url: 'https://maps.googleapis.com/maps/api/timezone/json?location='
                +place.geometry.location.lat()+','+place.geometry.location.lng()+'&timestamp='+timestamp+'&sensor=false',
            success: function(result){
                timezone = result.timeZoneId;    
                document.getElementById('time_zone').value = time_zone;
            }
        });
    });
}

// form validation
var formValidation = function() {
    // for more info visit the official plugin documentation: 
    // http://docs.jquery.com/Plugins/Validation
    $("#signup_form").validate({
        rules: {
			'data[agree]':{
				required:true
			},
            'data[name]': {
                required: true,
                minlength: 4
            },
            'data[domain_prefix]': {
                required: true,
                minlength: 5,
                remote: {
                    url: '/signup/check_domain_prefix.json',
                    type: 'post',
                    data: {
                        domain_prefix: function() {
                            return $("#domain_prefix").val();
                        }
                    },
                    dataFilter: function(data) {
                        var json = JSON.parse(data);
                        return JSON.stringify(!json.is_exist);
                    }
                }
            },
            'data[first_name]': {
                required: true
            },
            'data[last_name]': {
                required: true
            },
            'data[username]': {
                required: true,
                email: true,
                remote: {
                    url: '/signup/check_username.json',
                    type: 'post',
                    data: {
                        username: function() {
                            return $("#username").val();
                        }
                    },
                    dataFilter: function(data) {
                        var json = JSON.parse(data);
                        return JSON.stringify(!json.is_exist);
                    }
                }
            },
            'data[password]': {
                required: true,
                minlength: 6
            },
            'data[address_lookup]': {
                required: true,
                addressLookup: true
            }
        },
        messages: {
            'data[name]': {
                required: "Please enter your store name.",
                minlength: "Your store name must be at least 4 characters."
            },
            'data[domain_prefix]': {
                required: "Please enter a private web address.",
                minlength: "Your web address must be at least 5 characters.",
                remote: "This web address is unavailable."
            },
            'data[first_name]': {
                required: "Please enter your full name."
            },
            'data[last_name]': {
                required: "Please enter your full name."
            },
            'data[username]': {
                required: "Please enter your email address.",
                email: "Please enter a valid email address.",
                remote: "Your email already registered."
            },
            'data[password]': {
                required: "Please enter a password.",
                minlength: "Your password must be at least 6 characters."
            },
            'data[address_lookup]': {
                required: "Please enter your city and select from the list.",
                addressLookup: "Please enter your city and select from the list."
            },
			'data[agree]':{
                required: "Please check the policy."
			},
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "data[domain_prefix]") {
                element.parent().parent("dd").find(".help-block").html(error);
            } else {
                element.parent("dd").find(".help-block").html(error);
            }
        }
    });

    jQuery.validator.addMethod("addressLookup", function(value, element) {
        var physical_city = $("#physical_city").val();
        var physical_country = $("#physica_country").val();
        return physical_city != '' && physical_country != '';
    });
}
</script>
<!-- END JAVASCRIPTS -->
