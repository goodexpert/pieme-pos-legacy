<?php
    $user = $this->Session->read('Auth.User');
    $xero_auth_token = null;

    if (isset($user['Addons']['xero_auth_token'])) {
        $xero_auth_token = $user['Addons']['xero_auth_token'];
    }   
 ?>
<link href="/css/dataTable.css" rel="stylesheet" type="text/css">
<div class="clearfix"></div>
    <!-- BEGIN CONTENT -->
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
                <?php
                    echo $this->Form->input('register_id', array(
                        'id' => 'register_id',
                        'name' => 'register_id',
                        'type' => 'select',
                        'div' => false,
                        'label' => false,
                        'empty' => '',
                        'options' => $registers
                    ));
                 ?>
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
                <?php
                    echo $this->Form->input('filter', array(
                        'id' => 'filter',
                        'name' => 'filter',
                        'type' => 'select',
                        'div' => false,
                        'label' => false,
                        'empty' => 'All Sales',
                        'options' => $status
                    ));
                 ?>
                </dd>
                <dt>User</dt>
                <dd>
                <?php
                    echo $this->Form->input('user_id', array(
                        'id' => 'user_id',
                        'name' => 'user_id',
                        'type' => 'select',
                        'div' => false,
                        'label' => false,
                        'empty' => '',
                        'options' => $users
                    ));
                 ?>
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
        <?php foreach ($sales as $sale) : ?>
            <?php
                if ($sale['RegisterSale']['status'] === 'sale_status_onaccount') {
                    $contact_id = $sale['MerchantCustomer']['xero_contact_id'];
                    $invoice_id = $sale['RegisterSale']['xero_invoice_id'];

                    $xero_edit_invoice_url = 'https://go.xero.com/AccountsReceivable/Edit.aspx?InvoiceID=' . $invoice_id;
                    $xero_fetch_payment_url = '/xero/fetchPayment?id=' . $sale['RegisterSale']['id'];
                    $xero_post_invoice_url = '/xero/postInvoice?id=' . $sale['RegisterSale']['id'];

                    if (!empty($xero_auth_token) && !empty($invoice_id)) {
                        $xero_connect_link = '<a href="' . $xero_edit_invoice_url . '" target="_blank" title="View on Xero"><img src="/img/xero_connect.png"/></a>';
                    } elseif (!empty($xero_auth_token) && !empty($contact_id)) {
                        $xero_connect_link = '<a href="' . $xero_post_invoice_url . '"><img src="/img/xero_connect.png"/></a>';
                    }
                } elseif ($sale['RegisterSale']['status'] === 'sale_status_onaccount_closed') {
                    $invoice_id = $sale['RegisterSale']['xero_invoice_id'];
                    if (!empty($xero_auth_token) && !empty($invoice_id)) {
                    }
                }
             ?>
            <tr class="expandable" data-id="<?=$sale['RegisterSale']['id'];?>">
                <td><?php echo $sale['RegisterSale']['receipt_number'];?></td>
                <td><?php echo $sale['MerchantUser']['display_name'];?></td>
                <td><?php echo $sale['MerchantCustomer']['name'];?></td>
                <td><?=$sale['RegisterSale']['note'];?></td>
                <td class="history_status">
                    <?php echo $sale['RegisterSale']['status_name']; ?>
                    <?php if (!empty($xero_connect_link)) :?>
                        &nbsp;<?php echo $xero_connect_link; ?>
                    <?php endif; ?>
                </td>
                <td class="tdTotal">$<?=number_format($sale['RegisterSale']['total_price_incl_tax'],2,'.',',');?></td>
                <td><?=$sale['RegisterSale']['created'];?></td>
            </tr>
            <tr class="expandable-child" data-parent-id="<?=$sale['RegisterSale']['id'];?>">
                <td colspan="8" class="expandable-child-td">
                    <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega table-inner-btn">
                        <div class="pull-left">
                            <?php if ($sale['RegisterSale']['status'] !== "sale_status_voided") : ?>
                            <a href="/history/edit?r=<?=$sale['RegisterSale']['id'];?>" class="edit_history">
                                <button class="btn btn-default">Edit Sale</button>
                            </a>
                            <?php endif; ?>
                            <a href="/history/receipt?r=<?=$sale['RegisterSale']['id'];?>">
                                <button class="btn btn-default">View Receipt</button>
                            </a>
                            <?php if ($sale['RegisterSale']['status'] !== "sale_status_voided") : ?>
                            <button class="btn btn-default send_receipt">Send Receipt</button>
                            <?php endif; ?>
                        </div>
                        <div class="pull-right">
                            <?php if (!empty($xero_auth_token) && !empty($contact_id)) : ?>
                            <div class="btn-group">
                                <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    Xero <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="<?php echo $xero_fetch_payment_url; ?>">Check for Xero payments</a></li>
                                    <li><a href="<?php echo $xero_edit_invoice_url; ?>" target="_blank" title="View on Xero">View on Xero</a></li>
                                </ul>
                            </div>
                            <?php endif; ?>
                            <?php if ($sale['RegisterSale']['status'] !== "sale_status_voided") : ?>
                            <button class="btn btn-default void-history" data-id="<?=$sale['RegisterSale']['id'];?>">Void</button>
                            <?php endif; ?>
                            <?php if ($sale['RegisterSale']['status'] == 'sale_status_layby' or $sale['RegisterSale']['status'] == 'sale_status_saved' or $sale['RegisterSale']['status'] == 'sale_status_onaccount') : ?>
                            <button class="btn btn-default">Continue Sale</button>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                        <div class="col-md-8 col-xs-8 col-sm-8 col-alpha history-detail">
                            <ul class="row-display">
                            <?php
                                $itemCount = 0;
                                foreach($sale['RegisterSaleItem'] as $item) :
                             ?>

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

                            <?php
                                    $itemCount++;
                                endforeach;
                             ?>
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
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="dataTables_wrapper">
        <div class="dataTables_paginate paging_simple_numbers" id="productTable_paginate">
            <a class="paginate_button previous disabled" data-dt-idx="1" tabindex="0" id="previous">Previous</a>
            <span><a class="paginate_button current" data-dt-idx="1" tabindex="0">1</a></span>
            <a class="paginate_button next" data-dt-idx="" tabindex="0" id="next">Next</a>
        </div>
    </div>
    <!-- END CONTENT -->
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
                        <?php
                            echo $this->Form->input('register_id', array(
                                'id' => 'register_id',
                                'type' => 'select',
                                'class' => 'payment_action_register',
                                'div' => false,
                                'label' => false,
                                'empty' => '',
                                'options' => $registers
                            ));
                         ?>
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
<?php echo $this->element('script-jquery'); ?>
<?php echo $this->element('script-angularjs'); ?>
<!-- END CORE PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/theme/onzsa/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/admin/pages/scripts/index.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/admin/pages/scripts/tasks.js" type="text/javascript"></script>
<script src="/js/dataTable.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<?php echo $this->element('common-init'); ?>
<script>
jQuery(document).ready(function() {
  documentInit();
});


function documentInit() {
  // common init function
  commonInit();

  $("#date_from").datepicker({dateFormat: 'yy-mm-dd'});
  $("#date_to").datepicker({dateFormat: 'yy-mm-dd'});
  $(".payment_action_date").datepicker({dateFormat: 'yy-mm-dd'});

  $(".ShowMore").click(function () {
    $(this).parents(".history-detail").find(".hidden_product").toggle();
    if ($(this).parents(".history-detail").find(".hidden_product").is(':visible')) {
      $(this).html('Show Less <span class="glyphicon glyphicon-chevron-up"></span>');
    } else {
      $(this).html('Show More <span class="glyphicon glyphicon-chevron-down"></span>');
    }
  });

  var count = 0;
  var page = 1;
  var currentPage = 1;
  $("#historyTable").find(".expandable").each(function () {
    $(this).attr({'page': page});
    $(this).next('.expandable-child').attr({'page': page});
    count++;
    if (count == 10) {
      count = 0;
      page++;
      $('<span><a class="paginate_button" data-dt-idx="' + page + '" tabindex="0">' + page + '</a></span>').insertBefore("#next");
    }
  });
  $(".expandable").hide();
  $(".expandable-child").hide();
  $(".expandable[page=1]").show();

  $("span").children(".paginate_button").click(function () {
    $(".expandable").hide();
    $(".expandable-child").hide();
    $(".paginate_button").removeClass("current");
    $(this).addClass("current");
    if ($(this).attr("data-dt-idx") > 1) {
      $("#previous").removeClass("disabled");
    }
    if ($(this).attr("data-dt-idx") >= page) {
      $("#next").addClass("disabled");
    } else {
      $("#next").removeClass("disabled");
    }
    $("#previous").attr({'data-dt-idx': currentPage - 1});
    currentPage = $(this).attr('data-dt-idx');
    $(".expandable[page=" + currentPage + "]").show();
  });

  $(document).on('click', '#previous', function () {
    if (!$(this).hasClass('disabled')) {
      currentPage--;
      $(".expandable").hide();
      $(".expandable-child").hide();
      $(".paginate_button").removeClass("current");

      $("span").children(".paginate_button[data-dt-idx=" + currentPage + "]").addClass('current');
      $(".expandable[page=" + currentPage + "]").show();

      $(this).attr({'data-dt-idx': currentPage - 1});
      if ($(this).attr('data-dt-idx') < 1) {
        $(this).addClass("disabled");
      } else {
        $(this).removeClass("disabled");
      }
    }
    if ($("span").children("paginate_button").length !== 1) {
      $("#next").removeClass("disabled");
    }
  });

  $(document).on('click', '#next', function () {
    if (!$(this).hasClass('disabled')) {
      currentPage++;

      $(".expandable").hide();
      $(".expandable-child").hide();
      $(".paginate_button").removeClass("current");

      $("span").children(".paginate_button[data-dt-idx=" + currentPage + "]").addClass('current');
      $(".expandable[page=" + currentPage + "]").show();

      $(this).attr({'data-dt-idx': currentPage});
    }
    if ($("span").children("paginate_button").length !== 1) {
      $("#previous").removeClass("disabled");
    }
    if (currentPage == page) {
      $(this).addClass('disabled');
    }
  });

  $(".payment_action").click(function () {
    $(".payment").show();
    $(".modal-backdrop").show();

    $(".payment_action_amount").val($(this).parent().find(".total").text().split("$")[1]);
    $("#apply_payment_refund").attr({sale_id: $(this).parents(".expandable-child").attr("data-parent-id")});
  });

  $(".cancel").click(function () {
    $(".modal").hide();
    $(".modal-backdrop").hide();
  });
  $(".send_receipt").click(function () {
    $(".send").show();
    $(".modal-backdrop").show();
  });
  $("#send_receipt").click(function () {
    $.ajax({
      url: '/history/send_receipt',
      type: 'POST',
      data: {
        to: $("#email_address").val(),
        customer: 'John Doe',
        item: 'NOTHING'
      },
      success: function () {
        $("#email_address").val('');
        $(".send").hide();
        $(".modal-backdrop").hide();
      }
    });
  });
  $("#apply_payment_refund").click(function () {
    var payment_type = $(".payment_action_type").val();
    var paymet_amount = $(".payment_action_amount").val();
    var register_id = $(".payment_action_register").val();
    var payment_date = $(".payment_action_date").val() + ' ' + $(".payment_action_h").val() + ':' + $(".payment_action_m").val();
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
      success: function (result) {
        if (result.success) {
          $(".modal").hide();
          $(".modal-backdrop").hide();
        } else {
          console.log(result);
        }
      }
    });
  });

  var firstTime = true;
  $(document).on("click", ".expandable", function () {
    $('.expandable-child[data-parent-id=' + $(this).attr("data-id") + ']').show();
    $(this).attr({"class": "expanded"});
  });

  $(document).on("click", ".expanded", function () {
    $('.expandable-child[data-parent-id=' + $(this).attr("data-id") + ']').hide();
    $(this).attr({"class": "expandable"});
  });

  $(".void-history").click(function () {
    $(this).parents(".expandable-child").prev("tr").children(".history_status").text("voided");
    $(this).parent().prev("div").children(".edit_history").remove();
    $(this).parent().prev("div").children(".send_receipt").remove();
    $(this).parent().remove();

    $.ajax({
      url: '/history/void.json',
      type: 'POST',
      data: {
        id: $(this).attr("data-id"),
        status: 'sale_status_voided',
      }
    });
  });
}
</script>
<!-- END JAVASCRIPTS -->
