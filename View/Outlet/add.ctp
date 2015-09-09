<div class="clearfix"></div>
    <div id="notify"></div>
    <!-- BEGIN CONTENT -->
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
<script src="/theme/onzsa/assets/global/scripts/metronic.js"></script>
<script src="/theme/onzsa/assets/admin/layout/scripts/layout.js"></script>
<script src="/theme/onzsa/assets/admin/pages/scripts/index.js"></script>
<script src="/theme/onzsa/assets/admin/pages/scripts/tasks.js"></script>
<script src="/js/notify.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN COMMON INIT -->
<?php echo $this->element('common-init'); ?>
<!-- END COMMON INIT -->
<script>
jQuery(document).ready(function() {
  documentInit();
});

function documentInit() {
  // common init function
    commonInit();
    Metronic.init(); // init metronic core componets
    Index.init();

    $(".save").click(function() {
        saveData();
    });

    $(".cancel").click(function(){
        parent.history.back();
    });
};

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
