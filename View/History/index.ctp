<link href="/css/dataTable.css" rel="stylesheet" type="text/css">
<div class="clearfix"></div>
<div class="container">
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
                    <a href="index.php">
                    Sell
                    </a>
                </li>
                <li class="active">
                    <a href="history">
                    History <span class="selected">
                    </span>
                    </a>
                </li>
                <li>
                    <a href="history">
                    Product </a>
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
                <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">History</h2>
            </div>
            <!-- FILTER -->
            <form class="col-md-12 col-xs-12 col-sm-12 line-box filter-box" action="/history" method="get">
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <dl>
                        <dt>Date from</dt> 
                        <dd>
                            <span class="glyphicon glyphicon-calendar icon-calendar"></span>
                            <input type="text" id="date_from" name="from" value="<?php if(isset($_GET['from'])){echo $_GET['from'];}?>">
                        </dd>
                        <dt>Register</dt>
                        <dd>
                            <select name="register_id">
                                <option value=""></option>
                                <?php foreach($registers as $register) { ?>
                                    <option value="<?php echo $register['MerchantRegister']['id'];?>" <?php if(isset($_GET['register_id']) && $_GET['register_id'] == $register['MerchantRegister']['id']){echo "selected";}?>><?php echo $register['MerchantRegister']['name'];?></option>
                                <?php } ?>
                            </select>
                        </dd>
                        <dt>Customer name</dt>
                        <dd><input type="text" name="customer" value="<?php if(isset($_GET['customer'])){echo $_GET['customer'];}?>"></dd>
                    </dl>
                </div>
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <dl>
                        <dt>Date to</dt>
                        <dd>
                            <span class="glyphicon glyphicon-calendar icon-calendar"></span>
                            <input type="text" id="date_to" name="to" value="<?php if(isset($_GET['to'])){echo $_GET['to'];}?>">
                        </dd>
                        <dt>Receipt number</dt>
                        <dd><input type="text" name="receipt_number" value="<?php if(isset($_GET['receipt_number'])){echo $_GET['receipt_number'];}?>"></dd>
                        <dt>Amount</dt>
                        <dd><input type="text" name="total_cost" value="<?php if(isset($_GET['total_cost'])){echo $_GET['total_cost'];}?>"></dd>
                    </dl>
                 </div>
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <dl>
                        <dt>Show</dt>
                        <dd>
                            <select name="status">
                                <option value="">All Sales</option>
                                <?php foreach($status as $stat) { ?>
                                    <option value="<?php echo $stat['SaleStatus']['status'];?>" <?php if(isset($_GET['status']) && $_GET['status'] == $stat['SaleStatus']['status']){echo "selected";}?>><?php echo $stat['SaleStatus']['status'];?></option>
                                <?php } ?>
                            </select>
                        </dd>
                        <dt>User</dt>
                        <dd>
                            <select name="user_id">
                                <option></option>
                                <?php foreach($users as $user) { ?>
                                    <option value="<?php echo $user['MerchantUser']['id'];?>" <?php if(isset($_GET['user_id']) && $_GET['user_id'] == $user['MerchantUser']['id']){echo "selected";}?>><?php echo $user['MerchantUser']['display_name'];?></option>
                                <?php } ?>
                            </select>
                        </dd>
                    </dl>
                 </div>
                 <div class="col-md-12 col-xs-12 col-sm-12">
                     <button type="submit" class="btn btn-primary filter pull-right">Update</button>
                 </div>
            </form>
            <table id="historyTable" class="table table-striped table-bordered dataTable">
                <colgroup>
                    <col width="10%">
                    <col width="15%">
                    <col width="15%">
                    <col width="10%">
                    <col width="15%">
                    <col width="15%">
                    <col width="20%">
                </colgroup>
                <thead>
                <tr>
                    <th class="hisID">ID</th>
                    <th class="hisUser">User</th>
                    <th class="hisCustomer">Customer</th>
                    <th class="hisNote">Note</th>
                    <th class="hisStatus">Status</th>
                    <th class="tblTotal">Total</th>
                    <th class="hisDate">Date</th>
                </tr>
                </thead>
                <tbody>
                
                <?php foreach($sales as $sale){ ?>
                
                    <tr class="expandable" data-id="<?=$sale['RegisterSale']['id'];?>">
                        <td><?php echo $sale['RegisterSale']['receipt_number'];?></td>
                        <td><?php echo $sale['MerchantUser']['display_name'];?></td>
                        <td><?php echo $sale['MerchantCustomer']['name'];?></td>
                        <td><?=$sale['RegisterSale']['note'];?></td>
                        <td class="history_status"><?=$sale['RegisterSale']['status'];?></td>
                        <td class="tdTotal">$<?=number_format($sale['RegisterSale']['total_price_incl_tax'],2,'.',',');?></td>
                        <td><?=$sale['RegisterSale']['created'];?></td>
                    </tr>
                    <tr class="expandable-child" data-parent-id="<?=$sale['RegisterSale']['id'];?>">
                        <td colspan="8" class="expandable-child-td">
                            <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega table-inner-btn">
                                <div class="pull-left">
                                    <?php if($sale['RegisterSale']['status'] !== "voided") { ?>
                                    <a href="/history/edit?r=<?=$sale['RegisterSale']['id'];?>" class="edit_history"><button class="btn btn-default">Edit Sale</button></a>
                                    <?php } ?>
                                    <a href="/history/receipt?r=<?=$sale['RegisterSale']['id'];?>">
                                    <button class="btn btn-default">View Receipt</button>
                                    </a>
                                    <?php if($sale['RegisterSale']['status'] !== "voided") { ?>
                                    <button class="btn btn-default send_receipt">Send Receipt</button>
                                    <?php } ?>
                                </div>
                                <div class="pull-right">
                                    <?php if($sale['RegisterSale']['status'] !== "voided") { ?>
                                    <button class="btn btn-default void-history" data-id="<?=$sale['RegisterSale']['id'];?>">Void</button>
                                    <?php } ?>
                                    <?php if($sale['RegisterSale']['status'] == 'layby' or $sale['RegisterSale']['status'] == 'saved' or $sale['RegisterSale']['status'] == 'onaccount'){ ?>
                                    <button class="btn btn-default">Continue Sale</button>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                                <div class="col-md-8 col-xs-8 col-sm-8 col-alpha history-detail">
                                    <ul class="row-display">
                                        <?php $itemCount = 0;
                                        foreach($sale['RegisterSaleItem'] as $item) { ?>
                                        
                                            <li class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega <?php if($itemCount > 4){echo 'hidden_product';}?>" <?php if($itemCount > 4){echo 'style="display:none;"';}?>>
                                                <span class="col-md-4 col-xs-4 col-sm-4 col-alpha col-omega row-product">
                                                    <b><?=$item['quantity'];?> x</b> <?=$item['MerchantProduct']['name'];?></span>
                                                <span class="col-md-4 col-xs-4 col-sm-4 col-alpha col-omega row-product-pice">
                                                    <b>@ $<?=number_format($item['MerchantProduct']['price_include_tax'] - $item['MerchantProduct']['tax'],2,'.',',');?></b>
                                                    <small>+ $<?=number_format($item['MerchantProduct']['tax'],2,'.',',');?> Tax (GST)</small>
                                                </span>
                                                <span class="col-md-4 col-xs-4 col-sm-4 col-alpha col-omega row-amount">
                                                    $<?=number_format($item['price'],2,'.',',');?>
                                                </span>
                                            </li>
                                        
                                        <?php $itemCount++;
                                        } ?>
                                    </ul>
                                    <div class="solid-line"></div>
                                    <?php if($itemCount > 5) { ?>
                                    <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega text-align-center">
                                        <button class="ShowMore btn btn-default">Show More<span class="glyphicon glyphicon-chevron-down"></span></button>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="col-md-4 col-xs-4 col-sm-4 col-alpha col-omega receipt-container">
                                    <div class="receipt"></div>
                                    <div class="col-md-12 col-xs-12 col-sm-12 show-amount">
                                        <ul class="receipt-text">
                                            <li class="pull-left">Subtotal</li>
                                            <li class="pull-right"><text class="subTotal">$<?=number_format($sale['RegisterSale']['total_price'],2,'.',',');?></text></li>
                                        </ul>
                                        <ul class="receipt-text">
                                            <li class="pull-left">Tax (GST)</li>
                                            <li class="pull-right">
                                                <text class="gst">$<?=number_format($sale['RegisterSale']['total_tax'],2,'.',',');?></text>
                                            </li>
                                        </ul>
                                        <div class="dashed-line"></div>
                                        <ul class="inline-block">
                                            <li class="pull-left h4">
                                                <strong>TOTAL</strong>
                                            </li>
                                            <li class="pull-right h4">
                                                <text class="total"><strong>$<?=number_format($sale['RegisterSale']['total_price_incl_tax'],2,'.',',');?></strong></text>
                                            </li>
                                        </ul>
                                        <div class="solid-line"></div>
                                        <ul class="receipt-text">
                                        <?php
                                            $balance = 0;
                                            foreach($sale['RegisterSalePayment'] as $payment) {
                                                $balance += $payment['amount'];
                                         ?>
                                            <li class="col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
                                                <?php echo $payment['MerchantPaymentType']['name'];?>
                                            </li>
                                            <li class="pull-right col-md-5 col-xs-5 col-sm-5 col-omega" style="text-align:right;">
                                                <div>
                                                    <?php echo number_format($payment['amount'],2,'.',',');?>
                                                    <div class="glyphicon glyphicon-remove clickable"></div>
                                                </div>
                                            </li>
                                            <?php } ?>
                                        </ul>
                                        <div class="dashed-line-gr"></div>
                                        <button type="button" class="btn btn-default pull-right payment_action">Apply payment / refund</button>
                                        <div class="solid-line"></div>
                                        <ul class="receipt-text">
                                            <li class="col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
                                                Balance
                                            </li>
                                            <li class="col-md-5 col-xs-5 col-sm-5 col-omega" style="text-align:right;">
                                                <?php
                                                $balance = number_format($balance,2,'.',',');
                                                if($balance < 0){echo '-$'.$balance;} else {echo '$'.$balance;}?>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="receipt-bt"></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>

                </tbody>
            </table>
            <div class="dataTables_wrapper">
                <div class="dataTables_paginate paging_simple_numbers" id="productTable_paginate">
                    <a class="paginate_button previous disabled" data-dt-idx="1" tabindex="0" id="previous">Previous</a>
                    <span><a class="paginate_button current" data-dt-idx="1" tabindex="0">1</a></span>
                    <a class="paginate_button next" data-dt-idx="" tabindex="0" id="next">Next</a>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
</div>
<!-- PAYMENT POPUP BOX -->
<div class="confirmation-modal modal payment" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="confirm-close cancel" data-dismiss="modal" aria-hidden="true">
              <i class="glyphicon glyphicon-remove"></i>
              </button>
              <h4 class="modal-title">Apply Payment / Refund</h4>
          </div>
          <div class="modal-body">
              <div class="col-md-12 col-alpha col-omega">
                  <div class="col-md-4 col-alpha col-omega">
                  Payment type
                  </div>
                  <div class="col-md-8">
                      <select class="payment_action_type">
                          <?php foreach($payments as $paymentType) { ?>
                          <option value="<?php echo $paymentType['MerchantPaymentType']['id'];?>"><?php echo $paymentType['MerchantPaymentType']['name'];?></option>
                          <?php } ?>
                      </select>
                  </div>
              </div>
              <div class="col-md-12 col-alpha col-omega">
                  <div class="col-md-4 col-alpha col-omega">
                      Amount
                  </div>
                  <div class="col-md-8">
                      <input type="text" class="payment_action_amount">
                      To add a refund, enter a negative amount
                  </div>
              </div>
              <div class="col-md-12 col-alpha col-omega">
                  <div class="col-md-4 col-alpha col-omega">
                      Payment date
                  </div>
                  <div class="col-md-8">
                      <span class="glyphicon glyphicon-calendar icon-calendar"></span>
                      <input type="text" class="payment_action_date">
                  </div>
              </div>
              <div class="col-md-12 col-alpha col-omega">
                  <div class="col-md-4 col-alpha col-omega">
                      Payment time
                  </div>
                  <div class="col-md-8">
                      <select class="col-md-5 payment_action_h">
                          <?php for($i=0;$i<=23;$i++) { ?>
                          <option value="<?php echo $i;?>"><?php echo $i;?></option>
                          <?php } ?>
                      </select>
                      <span class="col-md-2">:</span>
                      <select class="col-md-5 payment_action_m">
                          <?php for($i=0;$i<=59;$i++) { ?>
                          <option value="<?php echo $i;?>"><?php echo $i;?></option>
                          <?php } ?>
                      </select>
                  </div>
              </div>
              <div class="col-md-12 col-alpha col-omega">
                  <div class="col-md-4 col-alpha col-omega">
                      Register
                  </div>
                  <div class="col-md-8">
                      <select class="payment_action_register">
                          <?php foreach($registers as $register) { ?>
                          <option value="<?php echo $register['MerchantRegister']['id'];?>"><?php echo $register['MerchantRegister']['name'];?></option>
                          <?php } ?>
                      </select>
                  </div>
              </div>
          </div>
          <div class="modal-footer">
              <button class="cancel btn btn-primary" type="button" data-dismiss="modal">Cancel</button>
              <button id="apply_payment_refund" class="confirm btn btn-success" type="button" data-dismiss="modal">Save</button>
          </div>
      </div>
  </div>
</div>
<!-- BEGIN POPUP BOX -->
<div class="confirmation-modal modal send" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="confirm-close cancel" data-dismiss="modal" aria-hidden="true">
              <i class="glyphicon glyphicon-remove"></i>
              </button>
              <h4 class="modal-title">Enter email address</h4>
          </div>
          <div class="modal-body">
              <input type="text" name="email" id="email_address">
          </div>
          <div class="modal-footer">
              <button class="cancel btn btn-primary" type="button" data-dismiss="modal">Cancel</button>
              <button id="send_receipt" class="confirm btn btn-success" type="button" data-dismiss="modal">Send</button>
          </div>
      </div>
  </div>
</div>
<div class="fade in modal-backdrop" style="display: none;"></div>
<!-- END POPUP BOX -->
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
    
    $("#date_from").datepicker({ dateFormat: 'yy-mm-dd' });
    $("#date_to").datepicker({ dateFormat: 'yy-mm-dd' });
    $(".payment_action_date").datepicker({ dateFormat: 'yy-mm-dd' });
    
    $(".ShowMore").click(function(){
        $(this).parents(".history-detail").find(".hidden_product").toggle();
        if($(this).parents(".history-detail").find(".hidden_product").is(':visible')){
            $(this).html('Show Less <span class="glyphicon glyphicon-chevron-up"></span>');
        } else {
            $(this).html('Show More <span class="glyphicon glyphicon-chevron-down"></span>');
        }
    });

    var count = 0;
    var page = 1;
    var currentPage = 1;
    $("#historyTable").find(".expandable").each(function(){
        $(this).attr({'page':page});
        $(this).next('.expandable-child').attr({'page':page});
        count++;
        if(count == 10){
            count = 0;
            page++;
            $('<span><a class="paginate_button" data-dt-idx="'+page+'" tabindex="0">'+page+'</a></span>').insertBefore("#next");
        }
    });
    $(".expandable").hide();
    $(".expandable-child").hide();
    $(".expandable[page=1]").show();
    
    $("span").children(".paginate_button").click(function(){
        $(".expandable").hide();
        $(".expandable-child").hide();
        $(".paginate_button").removeClass("current");
        $(this).addClass("current");
        if($(this).attr("data-dt-idx") > 1){
            $("#previous").removeClass("disabled");
        }
        if($(this).attr("data-dt-idx") >= page){
            $("#next").addClass("disabled");
        } else {
            $("#next").removeClass("disabled");
        }
        $("#previous").attr({'data-dt-idx':currentPage - 1});
        currentPage = $(this).attr('data-dt-idx');
        $(".expandable[page="+currentPage+"]").show();
    });
    
    $(document).on('click','#previous',function(){
        if(!$(this).hasClass('disabled')){
            currentPage--;
            $(".expandable").hide();
            $(".expandable-child").hide();
            $(".paginate_button").removeClass("current");
            
            $("span").children(".paginate_button[data-dt-idx="+currentPage+"]").addClass('current');
            $(".expandable[page="+currentPage+"]").show();
            
            $(this).attr({'data-dt-idx':currentPage - 1});
            if($(this).attr('data-dt-idx') < 1){
                $(this).addClass("disabled");
            } else {
                $(this).removeClass("disabled");
            }
        }
        if($("span").children("paginate_button").length !== 1){
            $("#next").removeClass("disabled");
        }
    });
    
    $(document).on('click','#next',function(){
        if(!$(this).hasClass('disabled')){
            currentPage++;
            
            $(".expandable").hide();
            $(".expandable-child").hide();
            $(".paginate_button").removeClass("current");
            
            $("span").children(".paginate_button[data-dt-idx="+currentPage+"]").addClass('current');
            $(".expandable[page="+currentPage+"]").show();
            
            $(this).attr({'data-dt-idx':currentPage});
        }
        if($("span").children("paginate_button").length !== 1){
            $("#previous").removeClass("disabled");
        }
        if(currentPage == page){
            $(this).addClass('disabled');
        }
    });
    
    $(".payment_action").click(function(){
        $(".payment").show();
        $(".modal-backdrop").show();
        
        $(".payment_action_amount").val($(this).parent().find(".total").text().split("$")[1]);
        $("#apply_payment_refund").attr({sale_id : $(this).parents(".expandable-child").attr("data-parent-id")});
    });
    
    $(".cancel").click(function(){
        $(".modal").hide();
        $(".modal-backdrop").hide();
    });
    $(".send_receipt").click(function(){
        $(".send").show();
        $(".modal-backdrop").show();
    });
    $("#send_receipt").click(function(){
        $.ajax({
            url: '/history/send_receipt',
            type: 'POST',
            data: {
                to: $("#email_address").val(),
                customer: 'John Doe',
                item: 'NOTHING'
            },
            success: function(){
                $("#email_address").val('');
                $(".send").hide();
                $(".modal-backdrop").hide();
            }
        });
    });
    $("#apply_payment_refund").click(function(){
        var payment_type = $(".payment_action_type").val();
        var paymet_amount = $(".payment_action_amount").val();
        var register_id = $(".payment_action_register").val();
        var payment_date = $(".payment_action_date").val() +' '+ $(".payment_action_h").val() +':'+ $(".payment_action_m").val();
        var sale_id = $(this).attr("sale_id");
        
        $.ajax({
            url: '/history/add_register_sale_payments.json',
            type: 'POST',
            data: {
                sale_id: sale_id,
                merchant_payment_type_id: payment_type,
                amount: paymet_amount,
                payment_date: payment_date,
                sequence: 999
            },
            success: function(result) {
                if(result.success) {
                    $(".modal").hide();
                    $(".modal-backdrop").hide();
                } else {
                    console.log(result);
                }
            }
        });
    });
});
</script>

<script>
var firstTime = true;
$(document).on("click", ".expandable", function(){
    $('.expandable-child[data-parent-id='+$(this).attr("data-id")+']').show();
    $(this).attr({"class": "expanded"});
});

$(document).on("click", ".expanded", function(){
    $('.expandable-child[data-parent-id='+$(this).attr("data-id")+']').hide();
    $(this).attr({"class": "expandable"});
});

$(".void-history").click(function(){
    $(this).parents(".expandable-child").prev("tr").children(".history_status").text("voided");
    $(this).parent().prev("div").children(".edit_history").remove();
    $(this).parent().prev("div").children(".send_receipt").remove();
    $(this).parent().remove();

    $.ajax({
        url: '/history/void.json',
        type: 'POST',
        data: {
            id: $(this).attr("data-id"),
            status: 'voided',
        }
    });
});
</script>
<!-- END JAVASCRIPTS -->
