<?php
    $data = $this->request->data;
 ?>
<style>
.disable {
    background: gray;
    opacity: 0.2;
    position: absolute;
    left:0;
    top:0;
    width:100%;
    height: 100%;
    z-index: 100;
}

#signup_bonus_loyalty_amount {
    width: 100px;
}

#welcome_email_subject {
    width: 300px;
}
</style>
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
                        <a href="javascript:;" class="remove"> <i class="icon-close"></i> </a>
                        <div class="input-group">
                            <input type="text" placeholder="Search...">
                            <span class="input-group-btn">
                            <button class="btn submit"><i class="icon-magnifier"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- END RESPONSIVE QUICK SEARCH FORM --> 
                </li>
                <li> <a href="index"> Sell </a> </li>
                <li> <a href="history"> History </a> </li>
                <li class="active"> <a href="history"> Product <span class="selected"> </span> </a> </li>
            </ul>
        </div>
        <!-- END HORIZONTAL RESPONSIVE MENU --> 
    </div>
    <!-- END SIDEBAR --> 
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega margin-bottom-20">
                <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">Loyalty</h2>
            </div>
            <div class="portlet-body form"> 
                <!-- BEGIN FORM-->
                <?php
                    echo $this->Form->create('MerchantLoyalty', array(
                        'id' => 'loyalty_setup_form'
                    ));
                    echo $this->Form->input('id', array(
                        'type' => 'hidden',
                        'div' => false,
                        'label' => false
                    ));
                 ?>
                <div class="form-horizontal col-md-12 col-xs-12 col-sm-12">
                    <div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">
                        <?php
                            echo $this->Form->input('enable_loyalty', array(
                                'id' => 'enable_loyalty',
                                'type' => 'checkbox',
                                'div' => false
                            ));
                         ?>
                    </div>
                    <!-- START col-md-12-->
                    <div id="enable_loyalty_body" class="form-body line-box line-box-content col-md-12 col-xs-12 col-sm-12">
                        <div class="disable" <?php if ($data['MerchantLoyalty']['enable_loyalty'] == 1){echo "style='display:none;'";}?>></div>
                        <h6 class="line-box-stitle">Allow customers to earn Loyalty $ when purchasing products. You can set Loyalty $ earned on individual products from the Edit Product page or from a price book. You can turn off Loyalty for individual customers on the Edit Customer page.</h6>
                        <div class="loyalty-box">
                            <h3>Earning Loyalty</h3>
                            <ul class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                                <li class="col-md-5 col-xs-5 col-sm-5 col-alpha col-omega">
                                <?php
                                    echo $this->Form->input('loyalty_spend_amount', array(
                                        'id' => 'loyalty_spend_amount',
                                        'type' => 'text',
                                        'div' => false,
                                        'label' => false
                                    ));
                                 ?>
                                </li>
                                <li class="col-md-2 col-xs-2 col-sm-2 col-alpha col-omega">
                                    <span class="glyphicon glyphicon-pause"></span>
                                </li>
                                <li class="col-md-5 col-xs-5 col-sm-5 col-alpha col-omega">
                                    $1.00 Loyalty
                                </li>
                            </ul>
                        </div>
                        <h6 class="text-center">Spending $<span id="spend_amount_display"><?php echo number_format($data['MerchantLoyalty']['loyalty_spend_amount'],2,'.','');?></span> earns $1.00 Loyalty.</h6>
                        <div class="dashed-line-gr"></div>
                        <dl class="dl-oneline">
                            <dt>Bonus Loyalty</dt>
                            <dd>
                            <?php
                                echo $this->Form->input('offer_signup_bonus_loyalty', array(
                                    'id' => 'offer_signup_bonus_loyalty',
                                    'type' => 'checkbox',
                                    'div' => false,
                                    'label' => false
                                ));
                             ?>&nbsp;Offer bonus Loyalty $ if a customer fills out all of their details in the Customer Portal (see example)
                            </dd>
                            <dt></dt>
                            <dd>
                            <?php
                                echo $this->Form->input('signup_bonus_loyalty_amount', array(
                                    'id' => 'signup_bonus_loyalty_amount',
                                    'type' => 'text',
                                    'class' => 'text-right',
                                    'div' => false,
                                    'label' => false
                                ));
                             ?>&nbsp;Loyalty
                            </dd>
                        </dl>
                    </div>
                </div>
                <div class="form-horizontal col-md-12 col-xs-12 col-sm-12">
                    <div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">
                        <div class="disable" <?php if ($data['MerchantLoyalty']['enable_loyalty'] == 1){echo "style='display:none;'";}?>></div>
                        <?php
                            echo $this->Form->input('send_welcome_email', array(
                                'id' => 'send_welcome_email',
                                'type' => 'checkbox',
                                'div' => false,
                            ));
                         ?>
                    </div>
                    <!-- START col-md-12-->
                    <div id="send_welcome_email_body" class="form-body line-box line-box-content col-md-12 col-xs-12 col-sm-12">
                        <div class="disable" <?php if ($data['MerchantLoyalty']['send_welcome_email'] == 1){echo "style='display:none;'";}?>></div>
                        <h6 class="line-box-stitle">Selecting this option will send customers an email welcoming them to the Loyalty program. The welcome email will be sent the next time the customer is added to a sale and includes a link where they can edit their details. Please note, the email will not be sent to customers if they haven't provided an email address, or if the customer has Loyalty disabled.</h6>
                        <dl class="dl-oneline">
                            <dt>Email subject</dt>
                            <dd>
                            <?php
                                echo $this->Form->input('welcome_email_subject', array(
                                    'id' => 'welcome_email_subject',
                                    'type' => 'text',
                                    'div' => false,
                                    'label' => false
                                ));
                             ?>
                            </dd>
                            <dt>Email message</dt>
                            <dd style="height: inherit;">
                            <?php
                                echo $this->Form->input('welcome_email_body', array(
                                    'id' => 'welcome_email_body',
                                    'type' => 'textarea',
                                    'div' => false,
                                    'label' => false
                                ));
                             ?>
                            </dd>
                            <dt></dt>
                            <dd class="margin-top-10">
                                <button id="preview_email" class="btn btn-sm btn-default">Preview Welcome Email</button>
                            </dd>
                        </dl>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 pull-right margin-top-20 margin-bottom-20">
                    <button class="btn btn-primary btn-wide save pull-right">Save</button>
                    <button class="btn btn-default btn-wide pull-right margin-right-10">Cancel</button>
                </div>            
                <?php
                    echo $this->Form->end();
                 ?>
            </div>
        </div>
    </div>
    <!-- END CONTENT --> 
    <!-- LOYALTY POPUP BOX -->
    <div class="confirmation-modal modal fade in void" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="confirm-close cancel" data-dismiss="modal" aria-hidden="true">
                    <i class="glyphicon glyphicon-remove"></i>
                    </button>
                    <h4 class="modal-title">Preview Email</h4>
                </div>
                <div class="modal-body">
                    <div class="preview-email-content">
                        <h2>Welcome to emcorpos Loyalty Program</h2>
                        <br>
                        You can earn Loyalty $ when you make purchases at emcorpos and redeem your credit in store.<br><br>
                        Thanks,<br>
                        emcorpos
                        <br><br>
                        <h4>Register your details with the emcorpos Loyalty Program:</h4>
                        
                        #link-appears-here
                        <span class="solid-line-gr"></span>
                        <span class="text-right inline-block"><strong>$0.00</strong></span>
                        <div class="preview-email-footer">
                            <img src="/img/ONZSA_logo-gr.png" alt="logo-gr" class="margin-top-20" style="width:115px;">
                            <p>Powered by ONZSA | Point-of-sale for clever stores.</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="cancel btn btn-primary" type="button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- LOYALTY POPUP BOX END -->
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
<script src="/plugin/textboxio/textboxio.js">
<script src="/js/notify.js" type="text/javascript"></script> 
<script src="/js/lib/jquery-number/jquery.number.min.js" type="text/javascript"></script> 
<script src="/js/lib/tinymce/tinymce.min.js" type="text/javascript"></script> 
<!-- END PAGE LEVEL SCRIPTS --> 
<script>
jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    Index.init();

    tinymce.init({
        selector: "textarea"
    });

    $("#loyalty_spend_amount").number(true, 2);
    $("#signup_bonus_loyalty_amount").number(true, 2);

    $("#enable_loyalty").change(function(e) {
        $(".disable").toggle();

        if (!$(this).is(':checked')) {
            $("#send_welcome_email").removeAttr("checked");
        }
        $("#send_welcome_email_body").find('.disable').show();
    });

    $("#send_welcome_email").change(function(e) {
        if($(this).is(':checked')) {
            $("#send_welcome_email_body").find('.disable').hide();
        } else {
            $("#send_welcome_email_body").find('.disable').show();
        }
    });
    
    $("#preview_email").click(function(e) {
        $(".confirmation-modal").show();
        return false;
    });

    $(".confirm-close").click(function(){
        $(".confirmation-modal").hide();
    });

    $(".cancel").click(function(){
        $(".confirmation-modal").hide();
    });
});
</script> 
<!-- END JAVASCRIPTS -->
