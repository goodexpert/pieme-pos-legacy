<div class="clearfix">
</div>
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
                        <a href="javascript:;" class="remove">
                        <i class="icon-close"></i>
                        </a>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                            <button class="btn submit"><i class="icon-magnifier"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- END RESPONSIVE QUICK SEARCH FORM -->
                </li>
                <li class="active">
                    <a href="index">
                    Sell <span class="selected">
                    </span>
                    </a>
                </li>
                <li>
                    <a href="history">
                    History </a>
                </li>
            </ul>
        </div>
        <!-- END HORIZONTAL RESPONSIVE MENU -->
    </div>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
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
                            <?php foreach($groups as $group){ ?>
                            
                                <option value="<?=$group['MerchantCustomerGroup']['id'];?>"><?=$group['MerchantCustomerGroup']['name'];?></option>
                            
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
                            <dd><select class="physical_country"><option>Select a country</option><option value="NZ">NZ</option></select></dd>
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
                            <dd><select class="postal_country"><option>Select a country</option><option value="1">NZ</option></select></dd>
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
        </div>
    </div>
    <!-- END CONTENT -->
    <!-- BEGIN QUICK SIDEBAR -->
    <a href="javascript:;" class="page-quick-sidebar-toggler"><i class="icon-close"></i></a>
    <div class="page-quick-sidebar-wrapper">
        <div class="page-quick-sidebar">            
            <div class="nav-justified">
                <ul class="nav nav-tabs nav-justified">
                    <li class="active">
                        <a href="#quick_sidebar_tab_1" data-toggle="tab">
                        Users <span class="badge badge-danger">2</span>
                        </a>
                    </li>
                    <li>
                        <a href="#quick_sidebar_tab_2" data-toggle="tab">
                        Alerts <span class="badge badge-success">7</span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        More<i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <li>
                                <a href="#quick_sidebar_tab_3" data-toggle="tab">
                                <i class="icon-bell"></i> Alerts </a>
                            </li>
                            <li>
                                <a href="#quick_sidebar_tab_3" data-toggle="tab">
                                <i class="icon-info"></i> Notifications </a>
                            </li>
                            <li>
                                <a href="#quick_sidebar_tab_3" data-toggle="tab">
                                <i class="icon-speech"></i> Activities </a>
                            </li>
                            <li class="divider">
                            </li>
                            <li>
                                <a href="#quick_sidebar_tab_3" data-toggle="tab">
                                <i class="icon-settings"></i> Settings </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
<!-- END QUICK SIDEBAR -->
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
<script>
jQuery(document).ready(function() {    
   Metronic.init(); // init metronic core componets
   Layout.init(); // init layout
   QuickSidebar.init() // init quick sidebar
   Index.init();
   
   $(document).on("click",".same_as_physical",function(){
      $(".postal_street_1").val($(".physical_street_1").val());
      $(".postal_street_2").val($(".physical_street_2").val());
      $(".postal_suburb").val($(".physical_suburb").val());
      $(".postal_city").val($(".physical_city").val());
      $(".postal_postcode").val($(".physical_postcode").val());
      $(".postal_state").val($(".physical_state").val());
      $(".postal_country").val($(".physical_country").val());
   });
   
});
</script>
<!-- END JAVASCRIPTS -->

<script>

$(".save").click(function(){
    var gender;
    $("input[type=radio]").each(function(){
        if($(this).attr("checked")){
            gender = $(this).val();
        }
    });
    
    $(".required").each(function(){
        if($(this).val() == ""){
            $(this).parent().addClass("incorrect");
            $('<h5 class="incorrect-message"><i class="glyphicon glyphicon-remove-circle margin-right-5"></i>This field is required.</h5>').insertAfter($(this));
        } else {
            $(this).parent().removeClass("incorrect");
        }
    });
    
    if($(".incorrect").length == 0) {
        $.ajax({
            url: '/customer/add.json',
            type: 'POST',
            data: {
                company_name: $(".company_name").val(),
                first_name: $(".name_first").val(),
                last_name: $(".name_last").val(),
                birthday: $(".customer_yyyy").val()+'-'+$(".customer_mm").val()+'-'+$(".customer_dd").val(),
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
                name: $(".name_first").val() +' '+ $(".name_last").val(),
                gender: gender,
                user_field_1: $(".customer_field_1").val(),
                user_field_2: $(".customer_field_2").val(),
                user_field_3: $(".customer_field_3").val(),
                user_field_4: $(".customer_field_4").val(),
                note: $(".customer_note").val()
            },
            success: function(result) {
                if(result.success) {
                    window.location.href = "/customer";
                } else {
                    console.log(result);
                }
            }
        });
    } else {
        $("html, body").animate({ scrollTop: 0 }, "slow");
    }
});
</script>