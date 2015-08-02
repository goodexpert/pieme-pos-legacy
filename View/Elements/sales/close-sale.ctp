<?php
    $user = $this->Session->read('Auth.User');
?>
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper" style="margin-top: 30px;">
    <div id="close-register-wrapper" class="line-box">
        <div class="col-md-12 col-sm-12 col-xs-12 col-omega col-alpha to_print">
            <div id="close-register-header" class="col-md-12 col-sm-12 col-xs-12">
                <h3><strong>Closing totals to verify</strong></h3>
                <h4>Register details</h4>
            </div>
            <div class="dashed-line"></div>
            <div id="close-register-details" class="col-md-12 col-sm-12 col-xs-12 col-alpha col-omega">
                <div class="col-md-6 col-sm-12 col-xs-6 col-alpha col-omega">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-4 col-sm-4 col-xs-4"><span>Register: </span></div>
                        <div class="col-md-8 col-sm-8 col-xs-8"><?=$user['MerchantRegister']['name'];?></div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-4 col-sm-4 col-xs-4"><span>Outlet: </span></div>
                        <div class="col-md-8 col-sm-8 col-xs-8"><?=$user['MerchantOutlet']['name'];?></div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-6 col-alpha col-omega">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-4 col-sm-4 col-xs-4"><span>Opened: </span></div>
                        <div class="col-md-8 col-sm-8 col-xs-8">2015-08-03 09:00:00</div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-4 col-sm-4 col-xs-4"><span>Closed: </span></div>
                        <div class="col-md-8 col-sm-8 col-xs-8" id="register_close_time">2015-08-03 16:00:00</div>
                    </div>
                </div>
            </div>
            <div id="close-register-sales" class="col-md-12 col-sm-12 col-xs-12">
                <h4>Sales</h4>
                <table class="col-md-12 col-sm-12 col-xs-12 sales-table">
                    <tr style="border-top:4px double black;">
                        <th>New sales</th>
                        <th></th>
                        <th>$<?=number_format($open['MerchantRegisterOpen']['total_sales'],2,'.','');?></th>
                    </tr>
                    <tr>
                        <td></td>
                        <td>New</td>
                        <td>$<?=number_format($open['MerchantRegisterOpen']['total_new_sales'],2,'.','');?></td>
                    </tr>
                    <?php if($open['MerchantRegisterOpen']['onaccount'] > 0) { ?>
                    <tr>
                        <td></td>
                        <td>On account</td>
                        <td>$<?=number_format($open['MerchantRegisterOpen']['onaccount'],2,'.','');?></td>
                    </tr>
                    <?php } ?>
                    <?php if($open['MerchantRegisterOpen']['layby'] > 0) { ?>
                    <tr>
                        <td></td>
                        <td>Layby</td>
                        <td>$<?=number_format($open['MerchantRegisterOpen']['layby'],2,'.','');?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                        <td></td>
                        <td>Tax (GST)</td>
                        <td>$<?=number_format($open['MerchantRegisterOpen']['total_tax'],2,'.','');?></td>
                    </tr>
                    <?php if($open['MerchantRegisterOpen']['total_discounts'] > 0) { ?>
                    <tr style="border-top:4px double black;">
                        <th>Discounts</th>
                        <th></th>
                        <th>$<?=number_format($open['MerchantRegisterOpen']['total_discounts']);?></th>
                    </tr>
                    <?php } ?>
                    <tr style="border-top:4px double black;">
                        <th>Payments</th>
                        <th></th>
                        <th>$<?=number_format($open['MerchantRegisterOpen']['total_payments'],2,'.','');?></th>
                    </tr>
                    <tr>
                        <td></td>
                        <td>New</td>
                        <td>$<?=number_format($open['MerchantRegisterOpen']['total_new_payments'],2,'.','');?></td>
                    </tr>
                    <tr style="border-top:4px double black;">
                        <th>Total Transaction Count</th>
                        <th></th>
                        <th><?php if(empty($payments)){echo 0;} else {echo count($payments);}?></th>
                    </tr>
                </table>
            </div>
            <div id="close-register-payments" class="col-md-12 col-sm-12 col-xs-12">
                <h4>Payments</h4>
                <?php
                        $payment_list = array();
                        
                        foreach($payments as $payment) {
                                if(isset($payment_list[$payment['MerchantPaymentType']['name']])) {
                                        $payment_list[$payment['MerchantPaymentType']['name']] += $payment['RegisterSalePayment']['amount'];
                                } else {
                                        $payment_list[$payment['MerchantPaymentType']['name']] = $payment['RegisterSalePayment']['amount'];
                                }
                        }
                ?>
                <table class="dataTable table-bordered">
                    <thead>
                        <tr>
                            <th>Payment</th>
                            <th>Amount</th>
                            <th>To post</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($payment_list as $payment_name => $payment_amount) { ?>
                        <tr>
                            <td><?php echo $payment_name;?></td>
                            <td><?php echo number_format($payment_amount,2,'.','');?></td>
                            <td><input type="text" value="<?php echo number_format($payment_amount,2,'.','');?>"></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php if(!empty($laybys) || !empty($onaccounts)) { ?>
            <div id="close-register-account" class="col-md-12 col-sm-12 col-xs-12">
                <h4>Account sales</h4>
                <table class="dataTable table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Receipt #</th>
                            <th>User</th>
                            <th>Customer</th>
                            <th>Note</th>
                            <th></th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                    <!-- New laybys -->
                    <?php if(!empty($laybys)) { ?>
                        <tr style="background:#eee;">
                                <th style="border:0;">Laybys started</th>
                                <th style="border:0;" colspan="6"></th>
                        </tr>
                    <?php
                    $total_layby_amount = 0;
                    foreach($laybys as $layby) { ?>
                        <tr>
                                <td><?php echo $layby['RegisterSale']['created'];?></td>
                                <td><?php echo $layby['RegisterSale']['receipt_number'];?></td>
                                <td><?php echo $layby['MerchantUser']['display_name'];?></td>
                                <td><?php echo $layby['MerchantCustomer']['name'];?></td>
                                <td><?php echo $layby['RegisterSale']['note'];?></td>
                                <td></td>
                                <td><?php echo '$'.number_format($layby['RegisterSale']['total_price_incl_tax'],2,'.','');?></td>
                        </tr>
                    <?php
                    $total_layby_amount += $layby['RegisterSale']['total_price_incl_tax'];
                    } ?>
                        <tr style="background:#FFF7D6">
                                <th style="border:0; text-align:right;" colspan="6">Total new laybys</th>
                                <td style="border:0;"><?php echo '$'.number_format($total_layby_amount,2,'.','');?></td>
                        </tr>
                    <?php } ?>
                    <!-- New laybys END -->
                    <!-- Layby payments -->
                    <?php $layby_payment_available = false;
                    foreach($laybys as $layby) {
                            if(!empty($layby['RegisterSalePayment']))
                                    $layby_payment_available = true;
                    }
                    if($layby_payment_available == true) { ?>
                        <tr style="background:#eee;">
                            <th style="border:0;">Layby payments</th>
                            <th style="border:0;" colspan="6"></th>
                        </tr>
                    <?php
                    $total_layby_payment = 0;
                    foreach($laybys as $layby) {
                            if(!empty($layby['RegisterSalePayment'])) {
                                foreach($layby['RegisterSalePayment'] as $payment) { ?>
                            <tr>
                                <td><?php echo $payment['payment_date'];?></td>
                                <td><?php echo $layby['RegisterSale']['receipt_number'];?></td>
                                <td><?php echo $layby['MerchantUser']['display_name'];?></td>
                                <td><?php echo $layby['MerchantCustomer']['name'];?></td>
                                <td></td>
                                <td><?php echo $payment['MerchantPaymentType']['name'];?></td>
                                <td><?php echo '$'.number_format($payment['amount'],2,'.','');?></td>
                            </tr>
                            <?php $total_layby_payment += $payment['amount'];
                            }
                        }
                    }?>
                        <tr style="background:#FFF7D6">
                            <th style="border:0; text-align:right;" colspan="6">Total layby payments</th>
                            <td style="border:0;"><?php echo '$'.number_format($total_layby_payment,2,'.','');?></td>
                        </tr>
                    <?php } ?>
                    <!-- Layby payments END -->
                    <!-- New account sales -->
                    <?php if(!empty($onaccounts)) { ?>
                        <tr style="background:#eee;">
                            <th style="border:0;">Account sales started</th>
                            <th style="border:0;" colspan="6"></th>
                        </tr>
                    <?php
                    $total_onaccount_amount = 0;
                    foreach($onaccounts as $onaccount) { ?>
                        <tr>
                            <td><?php echo $onaccount['RegisterSale']['created'];?></td>
                            <td><?php echo $onaccount['RegisterSale']['receipt_number'];?></td>
                            <td><?php echo $onaccount['MerchantUser']['display_name'];?></td>
                            <td><?php echo $onaccount['MerchantCustomer']['name'];?></td>
                            <td><?php echo $onaccount['RegisterSale']['note'];?></td>
                            <td></td>
                            <td><?php echo '$'.number_format($onaccount['RegisterSale']['total_price_incl_tax'],2,'.',',');?></td>
                        </tr>
                    <?php
                    $total_onaccount_amount += $onaccount['RegisterSale']['total_price_incl_tax'];
                    } ?>
                        <tr style="background:#FFF7D6">
                            <th style="border:0; text-align:right;" colspan="6">Total new account sales</th>
                            <td style="border:0;"><?php echo '$'.number_format($total_onaccount_amount,2,'.',',');?></td>
                        </tr>
                    <?php } ?>
                    <!-- New account sales END -->
                    <!-- Account sale payments -->
                    <?php $account_payment_available = false;
                    foreach($onaccounts as $onaccount) {
                            if(!empty($onaccount['RegisterSalePayment']))
                                    $account_payment_available = true;
                    }
                    if($account_payment_available == true) { ?>
                        <tr style="background:#eee;">
                            <th style="border:0;">Account sale payments</th>
                            <th style="border:0;" colspan="6"></th>
                        </tr>
                    <?php
                    $total_onaccount_payment = 0;
                    foreach($onaccounts as $onaccount) {
                            foreach($onaccount['RegisterSalePayment'] as $payment) { ?>
                            <tr>
                                <td><?php echo $payment['payment_date'];?></td>
                                <td><?php echo $onaccount['RegisterSale']['receipt_number'];?></td>
                                <td><?php echo $onaccount['MerchantUser']['display_name'];?></td>
                                <td><?php echo $onaccount['MerchantCustomer']['name'];?></td>
                                <td></td>
                                <td></td>
                                <td><?php echo '$'.number_format($payment['amount'],2,'.',',');?></td>
                            </tr>
                            <?php
                            $total_onaccount_payment += $payment['amount'];
                            }
                    }?>
                        <tr style="background:#FFF7D6">
                            <th style="border:0; text-align:right;" colspan="6">Total account sale payments</th>
                            <td style="border:0;"><?php echo '$'.number_format($total_onaccount_payment,2,'.',',');?></td>
                        </tr>
                    <?php } ?>
                    <!-- Account sale payments -->
                    </tbody>
                </table>
            </div>
            <?php } ?>
            </div>
        <div class="dashed-line"></div>
        <div class="col-md-12 col-sm-12 col-xs-12 pull-right margin-top-20 margin-bottom-20">
            <button class="btn btn-primary save pull-right close-register">Close Register</button>
            <button class="btn btn-default pull-right margin-right-10 print">Print</button>
        </div>
    </div>
</div>
<!-- END CONTENT -->
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
<script src="/js/jquery.jqprint-0.3.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    Index.init();
    
    $(".close-register").click(function(){
        $.ajax({
            url: '/home/close.json',
            type: 'POST',
            data: {
                register_close_time: $("#register_close_time").text()
            },
            success: function(result) {
                if(result.success) {
                    window.location.href = "/users/logout";
                } else {
                    console.log(result);
                }
            }
        });
    });
    $(".print").click(function(){
        $(".to_print").jqprint();
    });
});
</script>
<!-- END JAVASCRIPTS -->
