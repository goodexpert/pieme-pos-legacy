<div class="clearfix"></div>
<div class="container">
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
                <li>
                    <a href="index">
                    Sell
                    </a>
                </li>
                <li>
                    <a href="history">
                    History </a>
                </li>
                <li class="active">
                    <a href="history">
                    Product <span class="selected">
                    </span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- END HORIZONTAL RESPONSIVE MENU -->
    </div>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
        
            <h3>New Supplier</h3>
            
            <!-- DETAILS -->
            <div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">Details</div>
            <div class="line-box line-box-content col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <dl>
                        <dt>Supplier name</dt>
                        <dd><input type="text" class="required" id="supplier_name"></dd>
                        
                        <dt>Default markup</dt>
                        <dd><input type="text" value="0"></dd>
                        
                        <dt>Description</dt>
                        <dd><textarea style="width:100%;" id="supplier_desc"></textarea></dd>
                    </dl>
                </div>
            </div>
            
            <!-- CONTACT INFORMATION -->
            <div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">Contact Information</div>
            <div class="line-box line-box-content col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-6 col-sm-12 col-xs-12" style="border-right:1px solid #eee;">
                    <dl>
                        <dt>Company</dt>
                        <dd><input type="text" id="company_name"></dd>
                        
                        <dt>Contact name</dt>
                        <dd><input type="text" style="width:49%;" placeholder="First" id="first_name">
                        <input type="text" class="pull-right" style="width:49%;" placeholder="Last" id="last_name"></dd>
                        
                        <dt>Phone</dt>
                        <dd><input type="text" id="phone"></dd>
                        
                        <dt>Mobile</dt>
                        <dd><input type="text" id="mobile"></dd>
                    </dl>
                </div>
                
                <div class="col-md-6 col-sm-12 col-xs-12">
                    <dl>
                        <dt>Email</dt>
                        <dd><input type="text" id="email"></dd>
                        
                        <dt>Website</dt>
                        <dd><input type="text" id="website"></dd>
                    </dl>
                </div>
            </div>
        
            <!-- Address -->
            <div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">Address</div>
            <div class="line-box line-box-content col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-6 col-sm-12 col-xs-12">
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
                        <dd><select class="physical_country"><option selected disabled>Select a country</option>
                        <?php foreach($countries as $country) { ?>
                            <option value="<?=$country['Country']['country_code'];?>"><?=$country['Country']['country_name'];?></option>
                        <?php } ?>
                        </select></dd>
                    </dl>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
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
                        <dd><select class="postal_country"><option selected disabled>Select a country</option>
                        <?php foreach($countries as $country) { ?>
                            <option value="<?=$country['Country']['country_code'];?>"><?=$country['Country']['country_name'];?></option>
                        <?php } ?>
                        </select></dd>
                    </dl>
                </div>
            </div>
            
            <div class="col-md-12 col-sm-12 col-xs-12 pull-right margin-top-20 margin-bottom-20">
                <button class="btn btn-primary btn-wide pull-right save">Save</button>
                <button class="btn btn-default btn-wide pull-right margin-right-10 cancel">Cancel</button>
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
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
<!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
<script src="/theme/onzsa/assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/gritter/js/jquery.gritter.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/theme/onzsa/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/admin/pages/scripts/index.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/admin/pages/scripts/tasks.js" type="text/javascript"></script>
<script src="/js/dataTable.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    Index.init();
    
    $(".cancel").click(function(){
        parent.history.back();
    });
    
    $(".same_as_physical").click(function(){
        $(".postal_street_1").val($(".physical_street_1").val()),
        $(".postal_street_2").val($(".physical_street_2").val()),
        $(".postal_suburb").val($(".physical_suburb").val()),
        $(".postal_city").val($(".physical_city").val()),
        $(".postal_state").val($(".physical_state").val()),
        $(".postal_postcode").val($(".physical_postcode").val()),
        $(".postal_country").val($(".physical_country").val())
    });
    
    
    $(".save").click(function(){
        $.ajax({
            url: "/supplier/add.json",
            type: "POST",
            data: {
                name: $("#supplier_name").val(),
                description: $("#supplier_desc").val(),
                first_name: $("#first_name").val(),
                last_name: $("#last_name").val(),
                phone: $("#phone").val(),
                mobile: $("#mobile").val(),
                email: $("#email").val(),
                website: $("#website").val(),
                company_name: $("#company_name").val(),
                physical_address1: $(".physical_street_1").val(),
                physical_address2: $(".physical_street_2").val(),
                physical_suburb: $(".physical_suburb").val(),
                physical_city: $(".physical_city").val(),
                physical_state: $(".physical_state").val(),
                physical_postcode: $(".physical_postcode").val(),
                physical_country_id: $(".physical_country").val(),
                postal_address1: $(".postal_street_1").val(),
                postal_address2: $(".postal_street_2").val(),
                postal_suburb: $(".postal_suburb").val(),
                postal_city: $(".postal_city").val(),
                postal_state: $(".postal_state").val(),
                postal_postcode: $(".postal_postcode").val(),
                postal_country_id: $(".postal_country").val()
            },
            success: function(result) {
                if(result.success) {
                    window.location.href = "/supplier";
                } else {
                    console.log(result);
                }
            }
        });
    });
});
</script>
<!-- END JAVASCRIPTS -->
