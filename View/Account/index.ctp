<?php
    $user = $this->Session->read('Auth.User');
 ?>
<div class="clearfix"></div>
    <div id="notify"></div>
    <!-- BEGIN CONTENT -->
<h2>PLAN SELECTION</h2>
<div class="col-md-12 col-sm-12 col-xs-12 col-alpha col-omega line-box">
    <h4>You're currently on the 'Free' Plan</h4>
    <h5>Payment Frequency <span>Monthly</span></h5>
    <h5><span id="total_outlet"><?php echo $total_outlet;?></span> Outlets</h5>
    <h5><span id="total_register"><?php echo $total_register;?></span> Registers</h5>
    <h5><span id="total_user"><?php echo $total_user;?></span> Users</h5>
    <h5><span id="total_product"><?php echo $total_product;?></span> Products</h5>
    <h5><span id="total_customer"><?php echo $total_customer;?></span> Customers</h5>
</div>
<div class="inventory-tab">
    <li id="show_retail" target="retailer" class="active">Retail</li>
    <li id="show_franchise" target="franchise">Franchise</li>
    <li id="show_franchise_hq" target="franchise_hq">Franchise HQ</li>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 col-alpha col-omega">
    <div class="col-md-12 col-sm-12 col-xs-12 col-alpha col-omega line-box">
        <h4 class="col-md-12 col-sm-12 col-xs-12 col-alpha col-omega">
            Select a Plan
        </h4>
        <?php foreach($plans as $plan) { ?>
            <div class="col-md-3 col-sm-6 col-xs-6 margin-bottom-20 <?php if(strpos($plan['Plan']['id'], 'franchise') == true && strpos($plan['Plan']['id'], 'hq') == false){echo 'franchise hidden';} else if(strpos($plan['Plan']['id'], 'hq') == true){echo 'franchise_hq hidden';} else if(strpos($plan['Plan']['id'], 'retailer') == true){echo 'retailer';}?>">
                <div class="plan-item clickable <?php if($user['Plan']['id'] == $plan['Plan']['id']){echo "selected_plan";}?> line-box">
                    <div class="col-md-12 col-sm-12 col-xs-12 plan-header">
                        <input type="radio" value="<?php echo $plan['Plan']['id'];?>" data-outlet="<?php echo $plan['Plan']['limit_outlets'];?>" data-register="<?php echo $plan['Plan']['limit_registers'];?>" data-product="<?php echo $plan['Plan']['limit_products'];?>" data-customer="<?php echo $plan['Plan']['limit_customers'];?>" data-user="<?php echo $plan['Plan']['limit_users'];?>" name="account_plan" <?php if($user['Plan']['id'] == $plan['Plan']['id']){echo "checked";}?>> <lable for="account_plan"><?php echo $plan['Plan']['name'];?></lable>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="plan-price">
                            <?php
                                if($plan['Plan']['price'] > 0) {
                                    echo "$".number_format($plan['Plan']['price'],2,'.',',');
                                } else {
                                    echo "FREE";
                                }
                            ?>
                        </div>
                        <span class="triangle-left"></span>
                        <span class="triangle-right"></span>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 plan-desc">
                        <ul>
                            <li>
                                <?php if($plan['Plan']['limit_outlets'] == 1){
                                    echo "Single";
                                } else if($plan['Plan']['limit_outlets'] == -1){
                                   echo "Unlimited";
                                } else {
                                    echo $plan['Plan']['limit_outlets'];
                                }?>
                            outlet</li>
                            <li>
                                <?php if($plan['Plan']['limit_registers'] == -1){
                                    echo "Unlimited register";
                                } else {
                                    echo $plan['Plan']['limit_registers']." register included";
                                }?>
                            </li>
                            <li>
                                <?php if($plan['Plan']['limit_products'] == -1){
                                    echo "Unlimited product";
                                } else {
                                    echo $plan['Plan']['limit_products']." product included";
                                }?>
                            </li>
                            <li>
                                <?php if($plan['Plan']['limit_customers'] == -1){
                                    echo "Unlimited customer";
                                } else {
                                    echo $plan['Plan']['limit_customers']." customer included";
                                }?>
                            </li>
                            <li>
                                <?php if($plan['Plan']['limit_users'] == -1){
                                    echo "Unlimited user";
                                } else {
                                    echo $plan['Plan']['limit_users']." user included";
                                }?>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<div id="merchant_code_section" class="col-md-12 col-sm-12 col-xs-12 col-alpha col-omega margin-top-20" style="display: none;">
    <div class="col-md-12 col-sm-12 col-xs-12 col-alpha col-omega line-box">
        <div class="col-md-3 col-sm-6 col-xs-6 margin-bottom-20">
            Merchant Code
            <input type="text" id="merchant_code">
            <button type="button" id="verify_merchant_code" class="btn btn-default">Verify</button>
            <input type="hidden" id="subscriber_id">
            <input type="hidden" id="parent_merchant_id">
        </div>
    </div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 col-alpha col-omega line-box payment_details margin-top-20" style="display: none;">
    <dl>
        <dt>Credit card number</dt>
        <dd><input type="text"></dd>
        <dt>Expiry date</dt>
        <dd><input type="text"></dd>
        <dt>Security code (CVV)</dt>
        <dd><input type="text"></dd>
        <dt>Coupon code</dt>
        <dd><input type="text"></dd>
    </dl>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 pull-right margin-top-20 margin-bottom-20">
    <button class="btn btn-primary btn-wide save pull-right">Save</button>
    <button class="btn btn-default btn-wide cancel pull-right margin-right-10">Cancel</button>
</div>
<!-- END CONTENT -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<!-- BEGIN CORE PLUGINS -->
<?php echo $this->element('script-jquery'); ?>
<?php echo $this->element('script-angularjs'); ?>
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
<script src="/theme/onzsa/assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/admin/pages/scripts/index.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/admin/pages/scripts/tasks.js" type="text/javascript"></script>
<script type="text/javascript" src="/js/jquery.confirm.js"></script> 
<script src="/js/notify.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<?php echo $this->element('common-init'); ?>
<script>
jQuery(document).ready(function() {
    documentInit();
});

function documentInit() {
    // common init function
    commonInit();
    QuickSidebar.init() // init quick sidebar

    $(document).on("click", ".plan-item", function(){
        $(".plan-item").children(".plan-header").children(".radio").children("span").removeClass('checked');
        $(".plan-item").children(".plan-header").children(".radio").children("span").children("input[name=account_plan]").attr({'checked':false});
        $(".plan-item").removeClass("selected_plan");
        $(this).children(".plan-header").children(".radio").children("span").addClass('checked');
        $(this).children(".plan-header").children(".radio").children("span").children("input[name=account_plan]").attr({'checked':'checked'});
        $(this).addClass("selected_plan");

        if($(this).find(".plan-price").text() !== "FREE") {
            $(".payment_details").show();
        } else {
            $(".payment_details").hide();
        }
        if(RegExp("Franchise").test($(this).find("lable").text()) == true) {
            $("#merchant_code_section").show();
        } else {
            $("#merchant_code_section").hide();
        }
    });

    $(document).on("click", ".cancel", function(){
        location.reload();
    });

    $(document).on("click", ".save", function(){
        var plan = $("input[name=account_plan]:checked");
        if((plan.attr("data-product") < $("#total_product").text() && plan.attr("data-product") > 0) || (plan.attr("data-outlet") < $("#total_outlet").text() && plan.attr("data-outlet") > 0) || (plan.attr("data-register") < $("#total_register").text() && plan.attr("data-register") > 0) || (plan.attr("data-user") < $("#total_user").text() && plan.attr("data-user") > 0) || (plan.attr("data-customer") < $("#total_customer").text() && plan.attr("data-customer") > 0)) {
            $.confirm({
                title:'Warning',
                text:'You will going to lose your data if you change your current plan to selected plan.',
                cancelButton: "Cancel",
                confirmButton: "Process",
                confirmButtonClass: "btn btn-success pull-right",
                cancelButtonClass: "btn btn-primary margin-right-5",
                confirm: function() {
                    if(RegExp("franchise").test($("input[type='radio']:checked").attr("value")) == true) {
                        if($(".success-message").length > 0) {
                            $.ajax({
                                url: '/account/update_plan.json',
                                type: 'POST',
                                data: {
                                    plan_id: plan.val(),
                                    subscriber_id: $("#subscriber_id").val(),
                                    merchant_id: $("#parent_merchant_id").val()
                                },
                                success: function(result) {
                                    if(result.success) {
                                        alert("changed");
                                        window.location.href = "/users/logout";
                                    } else {
                                        console.log(result);
                                    }
                                }
                            });
                        } else {
                            alert("Please check the form");
                        }
                    } else {
                        $.ajax({
                            url: '/account/update_plan.json',
                            type: 'POST',
                            data: {
                                plan_id: plan.val()
                            },
                            success: function(result) {
                                if(result.success) {
                                    alert("changed");
                                } else {
                                    console.log(result);
                                }
                            }
                        });
                    }
                }
            });
        } else {
            if(RegExp("franchise").test($("input[type='radio']:checked").attr("value")) == true) {
                if($(".success-message").length > 0) {
                    $.ajax({
                        url: '/account/update_plan.json',
                        type: 'POST',
                        data: {
                            plan_id: plan.val(),
                            subscriber_id: $("#subscriber_id").val(),
                            merchant_id: $("#parent_merchant_id").val()
                        },
                        success: function(result) {
                            if(result.success) {
                                alert("changed");
                                window.location.href = "/users/logout";
                            } else {
                                console.log(result);
                            }
                        }
                    });
                } else {
                    alert("Please check the form");
                }
            } else {
                $.ajax({
                    url: '/account/update_plan.json',
                    type: 'POST',
                    data: {
                        plan_id: plan.val()
                    },
                    success: function(result) {
                        if(result.success) {
                            alert("changed");
                        } else {
                            console.log(result);
                        }
                    }
                });
            }
        }
    });
    
    $(document).on('click', '.inventory-tab li', function() {
        $(".inventory-tab li").removeClass("active");
        $(this).addClass("active");
        $(".plan-item").parent().addClass("hidden");
        $("." + $(this).attr("target")).removeClass("hidden");
    });
    
    $("#verify_merchant_code").click(function(){
        $("#merchant_code").removeClass("incorrect");
        $(".message").remove();
        $('<h5 class="message">verifying...</h5>').insertAfter($("#merchant_code"));
        $.ajax({
            url: '/signup/check_exist.json',
            type: 'POST',
            data: {
                merchant_code: $("#merchant_code").val()
            },
            success: function(result) {
                $(".message").remove();
                if(result.success) {
                    $("#merchant_code").attr({disabled:'disabled'});
                    $("#subscriber_id").val(result.subscriber_id);
                    $("#parent_merchant_id").val(result.merchant_id);
                    $('<h5 class="message success-message">'+result.store_name+'</h5>').insertAfter($("#merchant_code"));
                } else {
                    $("#merchant_code").addClass("incorrect");
                    $('<h5 class="message incorrect-message"><i class="glyphicon glyphicon-remove-circle margin-right-5"></i>Incorrect code.</h5>').insertAfter($("#merchant_code"));
                }
            }
        });
    });
}
</script>
<!-- END JAVASCRIPTS -->
