<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js"> <!--OFFLINE manifest="cache.manifest" -->
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8"/>
<title>Emcor POS</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport"/>
<meta content="" name="description"/>
<meta content="" name="author"/>
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
<link href="/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
<link href="/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
<link href="/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
<link href="/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
<link href="/assets/global/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" type="text/css"/>
<link href="/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
<link href="/assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css"/>
<link href="/assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL PLUGIN STYLES -->
<!-- BEGIN PAGE STYLES -->
<link href="/assets/admin/pages/css/tasks.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE STYLES -->
<!-- BEGIN THEME STYLES -->
<link href="/assets/global/css/components.css" rel="stylesheet" type="text/css"/>
<link href="/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
<link href="/assets/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
<link href="/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
<link href="/css/pos.css" rel="stylesheet" type="text/css"/>
<link href="/assets/global/css/plugins.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/css/jquery.calculator.css">
<link rel="stylesheet" href="/css/jquery.keypad.css">
<link href="/css/custom.keypad.css" rel="stylesheet" type="text/css">
<!-- END THEME STYLES -->
<link rel="shortcut icon" href="onzsa.ico"/>



</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<!-- DOC: Apply "page-header-fixed-mobile" and "page-footer-fixed-mobile" class to body element to force fixed header or footer in mobile devices -->
<!-- DOC: Apply "page-sidebar-closed" class to the body and "page-sidebar-menu-closed" class to the sidebar menu element to hide the sidebar by default -->
<!-- DOC: Apply "page-sidebar-hide" class to the body to make the sidebar completely hidden on toggle -->
<!-- DOC: Apply "page-sidebar-closed-hide-logo" class to the body element to make the logo hidden on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-hide" class to body element to completely hide the sidebar on sidebar toggle -->
<!-- DOC: Apply "page-sidebar-fixed" class to have fixed sidebar -->
<!-- DOC: Apply "page-footer-fixed" class to the body element to have fixed footer -->
<!-- DOC: Apply "page-sidebar-reversed" class to put the sidebar on the right side -->
<!-- DOC: Apply "page-full-width" class to the body element to have full width page without the sidebar menu -->
<body class="page-header-fixed page-quick-sidebar-over-content page-full-width">
<!-- BEGIN HEADER -->
        <div class="page-header navbar navbar-fixed-top">
            <!-- BEGIN HEADER INNER -->
            <div class="page-header-inner container">
                <!-- BEGIN LOGO -->
                <div class="page-logo">
                    <a href="/index.php">
                    <img src="/img/ONZSA_logo-05.png" alt="logo" class="logo-default"/>
                    </a>
                </div>
                <!-- END LOGO -->
                
            </div>
            <!-- END HEADER INNER -->
        </div>
        <!-- END HEADER -->
    <div id="content">

        <div class="clearfix"> </div>
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
          <!-- BEGIN CONTENT -->
          <div class="page-content-wrapper">
            <div class="page-content sell-index col-lg-12 col-md-12 col-sm-12 col-xs-12 col-alpha col-omega">
              <div class="maximum col-lg-12 col-md-12 col-sm-12 col-xs-12 col-alpha col-omega">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7 signup-img">
                        <img src="/img/ipad.png" alt="signup-img" >
                    </div>
                    <div id="signup_account_type" class="col-lg-5 col-md-5 col-sm-5 col-xs-5 signup-container">
                        <div class="line-box col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h1>Sign up</h1>
                            <div class="dashed-line-gr"><?php echo $this->Session->flash(); ?></div>
                                <h5>Please select an account type</h5>
								<div class="col-md-12 col-sm-12 col-xs-12 col-alpha col-omega">
                            <button type="button" class="btn btn-white btn-right pull-right width-initial">
                                <input type="radio" class="hidden" id="signup_account_type_open_franchise" value="0">
                                <label for="signup_account_type_open_franchise">Open Franchise</label>
                            </button>
                            <button type="button" class="btn btn-white btn-center pull-right width-initial">
                                <input type="radio" class="hidden" id="signup_account_type_join_franchise" value="1">
                                <label for="signup_account_type_join_franchise">Join Franchise</label>
                            </button>
                            <button type="button" class="btn btn-white btn-left pull-right width-initial">
                                <input type="radio" class="hidden" id="signup_account_type_single_merchant" value="2">
                                <label for="signup_account_type_single_merchant">Single Merchant</label>
                            </button>
								</div>
                        </div>
                    </div>
                    
                    <div id="signup_info" class="col-lg-5 col-md-5 col-sm-5 col-xs-5 signup-container" style="display: none;">
                        <div class="line-box">
                            <h1>Sign up</h1>
                            <div class="dashed-line-gr"><?php echo $this->Session->flash(); ?></div>
                            <form action="/signup/index.json" method="post" id="register_form">
                            <dl>
                                <dt>Store name</dt> 
                                <dd><input type="text" name="name" id="name" required></dd>
                                <dt class="hidden">Private web address</dt>
                                <dd class="hidden"><input type="hidden" name="domain_prefix" id="domain_prefix"></dd>
                                <dt>First name</dt>
                                <dd><input type="text" name="first_name" id="first_name" required></dd>
                                <dt>Last name</dt>
                                <dd><input type="text" name="last_name" id="last_name" required></dd>
                                <dt>Mail address</dt>
                                <dd><input type="email" name="username" id="username" required></dd>
                                <dt>Password</dt>
                                <dd><input type="password" name="password" id="password" required></dd>
                                
                                
                                <dt>City</dt>
                                <dd><input type="text" name="physical_city" id="physical_city" autocomplete="on" value="Auckland" required></dd>
                                <dt class="hidden">Country</dt>
                                <dd class="hidden"><input type="text" name="physical_country_id" id="physical_country_id" value="NZ"></dd>
                                <dt class="hidden">Default currency</dt>
                                <dd class="hidden"><input type="text" name="default_currency" id="default_currency" value="NZD"></dd>
                                <dt class="hidden">Timezone</dt>
                                <dd class="hidden"><input type="text" name="time_zone" id="time_zone" value="Pacific/Auckland"></dd>
                            </dl>
                            <div class="dashed-line-gr"></div>
                            <button type="submit" class="btn btn-success"><img src="/img/ONZSA_eye.png">Start onzsa</button>
                            </form>
                        </div>
                    </div>
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
        <script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places&language=kr" type="text/javascript"></script>
        <script>
            $(document).ready(function(){

                /*
            
                var country_code;
                var city;
                var timezone;
                function initialize() {
                    var input = document.getElementById('physical_city');
                    var options = {
                        types: ['(cities)'],
                    };
                    var autocomplete = new google.maps.places.Autocomplete(input, options);
                    google.maps.event.addListener(autocomplete, 'place_changed', function(){
                        var place = autocomplete.getPlace();
                        for(var i = 0; i < place.address_components.length; i++){
                            var placeComponents = place.address_components[i];
                            for(var j = 0; j < placeComponents.types.length; j++){
                                if(placeComponents.types[j] == 'country'){
                                    country_code = placeComponents.short_name;
                                }
                                if(placeComponents.types[j] == 'locality'){
                                    city = placeComponents.long_name;
                                }
                            }
                        }
                        $.ajax({
                            url: 'https://maps.googleapis.com/maps/api/timezone/json?location='+place.geometry.location.k+','+place.geometry.location.D+'&timestamp=1331161200&sensor=false',
                            success: function(result){
                                timezone = result.timeZoneId;    
                            }
                        });
                    });
                }
                google.maps.event.addDomListener(window, 'load', initialize);
            
            
                */
            
                /*
                $("#register_form").submit(function(){
                    $("#domain_prefix").val($("#name").val());
                    $("#physical_city").val(city);
                    $("#physical_country_id").val(country_code);
                    $("#default_currency").val("NZD");
                    $("#time_zone").val(timezone);
                });
                */
                
                /*
                 * Account Type Select
                 */
                $("#signup_account_type input[type=radio]").change(function(){
                    if($(this).val() == 0 || $(this).val() == 2) {
                        $(this).parents("#signup_account_type").hide();
                        $("#signup_info").show();
                    }
                });
            });    
        </script>
    </div>
        
    </div>
    <div id="footer">
        <!-- BEGIN FOOTER -->
        <div class="page-footer">
            <div class="page-footer-inner">
                 <?=date("Y");?> &copy; Emcor Media Lab.
            </div>
        </div>
        <!-- END FOOTER -->
    </div>
</div>
</body>
<!-- END BODY -->
</html>
