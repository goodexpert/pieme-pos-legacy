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
            <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega margin-bottom-20">
                <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
                    Add Outlet
                </h2>
            </div>
            <?php
                echo $this->Form->create('MerchantOutlet', array(
                    'id' => 'outlet_add_form'
                ));
                echo $this->Form->input('id', array(
                    'id' => 'outlet_id',
                    'type' => 'hidden',
                    'div' => false,
                    'label' => false
                ));
             ?>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="line-box col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <dl>
                            <dt>Outlet name</dt>
                            <dd>
                            <?php
                                echo $this->Form->input('name', array(
                                    'id' => 'outlet_name',
                                    'type' => 'text',
                                    'class' => 'outlet_class',
                                    'div' => false,
                                    'label' => false
                                ));
                             ?>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            
            <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:15px;">
                <div class="line-box col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <dl>
                            <dt>Street</dt>
                            <dd>
                            <?php
                                echo $this->Form->input('physical_address1', array(
                                    'id' => 'outlet_physical_address1',
                                    'type' => 'text',
                                    'class' => 'outlet_street_1',
                                    'div' => false,
                                    'label' => false
                                ));
                             ?>
                            </dd>
                            <dt>Street</dt>
                            <dd>
                            <?php
                                echo $this->Form->input('physical_address2', array(
                                    'id' => 'outlet_physical_address2',
                                    'type' => 'text',
                                    'class' => 'outlet_street_2',
                                    'div' => false,
                                    'label' => false
                                ));
                             ?>
                            </dd>
                            <dt>Suburb</dt>
                            <dd>
                            <?php
                                echo $this->Form->input('physical_suburb', array(
                                    'id' => 'outlet_physical_suburb',
                                    'type' => 'text',
                                    'class' => 'outlet_suburb',
                                    'div' => false,
                                    'label' => false
                                ));
                             ?>
                            </dd>
                            <dt>City</dt>
                            <dd>
                            <?php
                                echo $this->Form->input('physical_city', array(
                                    'id' => 'outlet_physical_city',
                                    'type' => 'text',
                                    'class' => 'outlet_city',
                                    'div' => false,
                                    'label' => false
                                ));
                             ?>
                            </dd>
                            <dt>Physical postcode</dt>
                            <dd>
                            <?php
                                echo $this->Form->input('physical_postcode', array(
                                    'id' => 'outlet_physical_postcode',
                                    'type' => 'text',
                                    'class' => 'outlet_postcode',
                                    'div' => false,
                                    'label' => false
                                ));
                             ?>
                            </dd>
                            <dt>State</dt>
                            <dd>
                            <?php
                                echo $this->Form->input('physical_state', array(
                                    'id' => 'outlet_physical_state',
                                    'type' => 'text',
                                    'class' => 'outlet_state',
                                    'div' => false,
                                    'label' => false
                                ));
                             ?>
                            </dd>
                            <dt>Country</dt>
                            <dd>
                            <?php
                                echo $this->Form->input('physical_country', array(
                                    'id' => 'outlet_physical_country',
                                    'type' => 'select',
                                    'class' => 'outlet_country',
                                    'div' => false,
                                    'label' => false,
                                    'options' => $countries,
                                    'empty' => __('Select a country')
                                ));
                             ?>
                            </dd>
                        </dl>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <dt>Email</dt>
                        <dd>
                            <?php
                                echo $this->Form->input('physical_email', array(
                                    'id' => 'outlet_physical_email',
                                    'type' => 'text',
                                    'class' => 'outlet_email',
                                    'div' => false,
                                    'label' => false
                                ));
                             ?>
                        </dd>
                        <dt>Phone</dt>
                        <dd>
                            <?php
                                echo $this->Form->input('physical_phone', array(
                                    'id' => 'outlet_physical_phone',
                                    'type' => 'text',
                                    'class' => 'outlet_phone',
                                    'div' => false,
                                    'label' => false
                                ));
                             ?>
                        </dd>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 pull-right margin-top-20 margin-bottom-20">
                <button class="btn btn-primary btn-wide save pull-right save">Save Outlet</button>
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
<script src="/js/notify.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    Index.init();

    $(".save").click(function() {
        saveData();
    });

    $(".cancel").click(function(){
        parent.history.back();
    });
});

function saveData() {
    $("#outlet_add_form").submit();
    /*
    $.ajax({
        url: "/outlet/add.json",
        method: "POST",
        data: $("#outlet_add_form").serialize(),
        error: function( jqXHR, textStatus, errorThrown ) {
            alert(textStatus);
        },
        success: function( data, textStatus, jqXHR ) {
            console.log(data);
            if (data.success) {
                //window.location.href = "/setup/outlets_and_registers";
            } else {
                alert(data.message);
            }
        }
    });
     */
}
</script>
<!-- END JAVASCRIPTS -->
