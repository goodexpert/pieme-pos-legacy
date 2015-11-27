<?php
  $user = $this->Session->read('Auth.User');

  $this->Number->addFormat('NZD', array(
      'wholeSymbol'      => '$ ',
      'wholePosition'    => 'before',
      'fractionSymbol'   => false,
      'fractionPosition' => 'after',
      'zero'             => 0,
      'places'           => 2,
      'thousands'        => ',',
      'decimals'         => '.',
      'negative'         => '-',
      'escape'           => true,
      'fractionExponent' => 2
  ));
?>
<link href="/css/dataTable.css" rel="stylesheet"/>
<link href="/app/styles/receipt.css" rel="stylesheet"/>

<div class="closure-verify">
  <div class="portlet light bordered">
    <div class="page-content-wrapper" style="margin-top: 30px;">
      <div id="closure-verify-wrapper">
        <div class="col-md-12 col-sm-12 col-xs-12 col-omega col-alpha ">
          <div id="closure-verify-header" class="col-md-12 col-sm-12 col-xs-12">
            <h3><strong>Closing totals to verify</strong></h3>

            <div>&nbsp;</div>

            <h4>Register details</h4>
            <div id="closure-verify-details" class="col-md-12 col-sm-12 col-xs-12 col-alpha col-omega">
              <div class="col-md-6 col-sm-12 col-xs-6 col-alpha col-omega">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="col-md-4 col-sm-4 col-xs-4"><span>Register: </span></div>
                  <div class="col-md-8 col-sm-8 col-xs-8"><?php echo($register_info['name']); ?></div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="col-md-4 col-sm-4 col-xs-4"><span>Outlet: </span></div>
                  <div class="col-md-8 col-sm-8 col-xs-8"><?php echo($register_info['outlet']); ?></div>
                </div>
              </div>
              <div class="col-md-6 col-sm-12 col-xs-6 col-alpha col-omega">
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="col-md-4 col-sm-4 col-xs-4"><span>Opened: </span></div>
                  <div class="col-md-8 col-sm-8 col-xs-8"><?php echo($register_info['opened']); ?></div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="col-md-4 col-sm-4 col-xs-4"><span>Closed: </span></div>
                  <div class="col-md-8 col-sm-8 col-xs-8"><?php echo($register_info['closed']); ?></div>
                </div>
              </div>
            </div>
          </div>

          <div>&nbsp;</div>

          <!-- Section Sales -->
          <div id="closure-verify-sales" class="col-md-12 col-sm-12 col-xs-12">
            <h4><strong>Sales</strong></h4>
            <table class="col-md-12 col-sm-12 col-xs-12 sales-table">

              <tr style="border-top:4px double black;">
                <th>New sales</th>
                <th></th>
                <th class="text-right"><?php echo($this->Number->currency($total['sale'], "NZD")); ?></th>
              </tr>
              <?php foreach($new_sales as $sale) { ?>
              <tr>
                <td></td>
                <td><?php echo($sale['name']); ?></td>
                <td class="text-right"><?php echo($this->Number->currency($sale['total_sales'], "NZD")); ?></td>
              </tr>
              <?php }; ?>
              <tr>
                <td></td>
                <td>Tax (GST)</td>
                <td class="text-right"><?php echo($this->Number->currency($total['tax'], "NZD")); ?></td>
              </tr>

              <tr style="border-top:4px double black;">
                <th>Discounts</th>
                <th></th>
                <th class="text-right"><?php echo($this->Number->currency($total['discount'], "NZD")); ?></th>
              </tr>

              <tr style="border-top:4px double black;">
                <th>Payments</th>
                <th></th>
                <th class="text-right"><?php echo($this->Number->currency($total['payment'], "NZD")); ?></th>
              </tr>
              <?php foreach($new_sales as $sale) { ?>
                <tr>
                  <td></td>
                  <td><?php echo($sale['name']); ?></td>
                  <td class="text-right"><?php echo($this->Number->currency($sale['total_payments'], "NZD")); ?></td>
                </tr>
              <?php }; ?>
              <tr style="border-top:4px double black;">
                <th>Total Transaction Count</th>
                <th></th>
                <th class="text-right"><?php echo($total['transaction']); ?></th>
              </tr>
              <tr style="border-top:4px double black; border-bottom:hidden;">
                <th>Rounding</th>
                <th></th>
                <th class="text-right"><?php echo($this->Number->currency($total['sale'] - $total['payment'], "NZD")); ?></th>
              </tr>
            </table>
          </div>

          <div>&nbsp;</div>

          <!-- Section Payments -->
          <div id="closure-verify-payments" class="col-md-12 col-sm-12 col-xs-12">
            <h4><strong>Payments</strong></h4>
            <table class="dataTable table-bordered">
              <thead>
              <tr>
                <th>Payment</th>
                <th>Amount</th>
                <!--<th>To post</th>-->
              </tr>
              </thead>
              <tbody>
              <?php foreach ($payment_types as $type) { ?>
                <tr>
                  <td><?php echo $type['name']; ?></td>
                  <td class="text-right"><?php echo($this->Number->currency($type['amount'], "NZD")); ?></td>
                  <!--<td><input type="text" value="<?php echo($this->Number->currency($type['amount'], "NZD")); ?>"></td>-->
                </tr>
              <?php } ?>
              </tbody>
            </table>
          </div>

          <div>&nbsp;</div>

          <!-- Section Account Sales -->
          <div id="closure-verify-account" class="col-md-12 col-sm-12 col-xs-12">
            <h4><strong>Account sales</strong></h4>
            <table class="dataTable table-bordered">
              <thead>
              <tr>
                <th>Date</th>
                <th>Receipt #</th>
                <th>User</th>
                <th>Customer</th>
                <th>Note</th>
                <th>Amount</th>
              </tr>
              </thead>

              <!-- Layby sale started -->
              <!--
              <tbody ng-if="register.layby_sales.sales.length > 0">
              <tr style="background:#eee;">
                <th style="border:0;">Layby sale started</th>
                <th style="border:0;" colspan="5"></th>
              </tr>
              <tr data-ng-repeat="sale in register.layby_sales.sales">
                <td>{{sale.sale_date}}</td>
                <td>{{sale.reciept_number}}</td>
                <td>{{sale.user_name}}</td>
                <td>{{sale.customer_name}}</td>
                <td>{{sale.note}}</td>
                <td class="text-right">{{sale.amount | currency}}</td>
              </tr>
              <tr style="background:#FFF7D6">
                <th style="border:0; text-align:right;" colspan="5">Total new laybys</th>
                <td class="text-right" style="border:0;">{{register.layby_sales.total_sales | currency}}</td>
              </tr>
              </tbody>
              -->

              <!-- Layby sale payments -->
              <!--
              <tbody data-ng-if="register.layby_sales.payments.length > 0">
              <tr style="background:#eee;">
                <th style="border:0;">Layby sale payments</th>
                <th style="border:0;" colspan="5"></th>
              </tr>
              <tr data-ng-repeat="payment in register.layby_sales.payments">
                <td>{{payment.sale_date}}</td>
                <td>{{payment.reciept_number}}</td>
                <td>{{payment.user_name}}</td>
                <td>{{payment.customer_name}}</td>
                <td>{{payment.note}}</td>
                <td class="text-right">{{payment.amount | currency}}</td>
              </tr>
              <tr style="background:#FFF7D6">
                <th style="border:0; text-align:right;" colspan="5">Total new laybys</th>
                <td class="text-right" style="border:0;">{{register.layby_sales.total_payments | currency}}</td>
              </tr>
              </tbody>
              -->

              <!-- Account sale started -->
              <!--
              <tbody data-ng-if="register.account_sales.sales.length > 0">
              <tr style="background:#eee;">
                <th style="border:0;">Account sale started</th>
                <th style="border:0;" colspan="5"></th>
              </tr>
              <tr data-ng-repeat="sale in register.account_sales.sales">
                <td>{{sale.sale_date}}</td>
                <td class="text-center">{{sale.reciept_number}}</td>
                <td>{{sale.user_name}}</td>
                <td>{{sale.customer_name}}</td>
                <td>{{sale.note}}</td>
                <td class="text-right">{{sale.amount | currency}}</td>
              </tr>
              <tr style="background:#FFF7D6">
                <th style="border:0; text-align:right;" colspan="5">Total new laybys</th>
                <td class="text-right" style="border:0;">{{register.account_sales.total_sales | currency}}</td>
              </tr>
              </tbody>
              -->

              <!-- Account sale payments -->
              <!--
              <tbody data-ng-if="register.account_sales.payments.length > 0">
              <tr style="background:#eee;">
                <th style="border:0;">Account sale payments</th>
                <th style="border:0;" colspan="5"></th>
              </tr>
              <tr data-ng-repeat="payment in register.account_sales.payments">
                <td>{{payment.sale_date}}</td>
                <td class="text-center">{{payment.reciept_number}}</td>
                <td>{{payment.user_name}}</td>
                <td>{{payment.customer_name}}</td>
                <td>{{payment.note}}</td>
                <td class="text-right">{{payment.amount | currency}}</td>
              </tr>
              <tr style="background:#FFF7D6">
                <th style="border:0; text-align:right;" colspan="5">Total new accounts</th>
                <td class="text-right" style="border:0;">{{register.account_sales.total_payments | currency}}</td>
              </tr>
              -->

              </tbody>
            </table>
          </div>
        </div>

        <div>&nbsp;</div>

        <div class="col-md-12 col-sm-12 col-xs-12 pull-right margin-top-20 margin-bottom-20">
          <button class="btn btn-primary pull-right btn-close">close</button>
          <button class="btn btn-default pull-right margin-right-10 btn-print" id="print">Print</button>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
  </div>
</div>

<!-- ------------------------------------------ -->
<!-- Print Templet -->
<!-- ------------------------------------------ -->

<div class="clearfix"></div>

<div class="receipt-parent has-receipt-80 to_print" id =receipt>
  <div id="receipt" class="receipt-content">
    <div class="show-amount">
      <div class="receipt-header text-center">
        <h2>Closing totals to verify</h2>
      </div>

      <!-- Print : register details -->
      <div class="register-details">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="row">
            <strong>Register Details</strong>
          </div>
          <div class="row">
            <div class="col-md-2 col-sm-4 col-xs-4"><span>Register: </span></div>
            <div class="col-md-4 col-sm-8 col-xs-8"><?php echo($register_info['name']); ?></div>
            <div class="col-md-2 col-sm-4 col-xs-4"><span>Outlet: </span></div>
            <div class="col-md-4 col-sm-8 col-xs-8"><?php echo($register_info['outlet']); ?></div>
          </div>
          <div class="row">
            <div class="col-md-2 col-sm-4 col-xs-4"><span>Opened: </span></div>
            <div class="col-md-4 col-sm-8 col-xs-8"><?php echo($register_info['opened']); ?></div>
            <div class="col-md-2 col-sm-4 col-xs-4"><span>Closed: </span></div>
            <div class="col-md-4 col-sm-8 col-xs-8"><?php echo($register_info['closed']); ?></div>
          </div>
        </div>
      </div>

      <!-- Print : Sales -->
      <div class="dashed-line-gr"></div>

      <div class="register-sales">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="row">
            <strong>Sales</strong>
          </div>
          <div class="row">
            <div class="col-md-8 col-sm-8 col-xs-8">New sales</div>
            <div class="col-md-4 col-sm-4 col-xs-4 text-right"><?php echo($this->Number->currency($total['sale'], "NZD")); ?></div>
          </div>
          <?php foreach($new_sales as $sale) { ?>
          <div class="row" >
            <div class="col-md-8 col-sm-8 col-xs-8 ">&nbsp;&nbsp;&nbsp;<?php echo($sale['name']); ?></div>
            <div class="col-md-4 col-sm-4 col-xs-4 text-right"><?php echo($this->Number->currency($sale['total_sales'], "NZD")); ?></div>
          </div>
          <?php }; ?>
          <div class="row">
            <div class="col-md-8 col-sm-8 col-xs-8 ">&nbsp;&nbsp;&nbsp;Tax (GST)</div>
            <div class="col-md-4 col-sm-4 col-xs-4 text-right"><?php echo($this->Number->currency($total['tax'], "NZD")); ?></div>
          </div>
          <div class="row">
            <div class="col-md-8 col-sm-8 col-xs-8">Discounts</div>
            <div class="col-md-4 col-sm-4 col-xs-4 text-right"><?php echo($this->Number->currency($total['discount'], "NZD")); ?></div>
          </div>
          <div class="row">
            <div class="col-md-8 col-sm-8 col-xs-8">Payments</div>
            <div class="col-md-4 col-sm-4 col-xs-4 text-right"><?php echo($this->Number->currency($total['payment'], "NZD")); ?></div>
          </div>
          <?php foreach($new_sales as $sale) { ?>
          <div class="row">
            <div class="col-md-8 col-sm-8 col-xs-8 " >&nbsp;&nbsp;&nbsp;<?php echo($sale['name']); ?></div>
            <div class="col-md-4 col-sm-4 col-xs-4 text-right"><?php echo($this->Number->currency($sale['total_payments'], "NZD")); ?></div>
          </div>
          <?php }; ?>
          <div class="row">
            <div class="col-md-8 col-sm-8 col-xs-8">Transaction Count</div>
            <div class="col-md-4 col-sm-4 col-xs-4 text-right"><?php echo($total['transaction']); ?></div>
          </div>
          <div class="row">
            <div class="col-md-8 col-sm-8 col-xs-8">Rounding</div>
            <div class="col-md-4 col-sm-4 col-xs-4 text-right"><?php echo($this->Number->currency($total['sale'] - $total['payment'], "NZD")); ?></div>
          </div>
        </div>
      </div>

      <!-- Print : Payments -->
      <div class="dashed-line-gr"></div>

      <div class="register-payments">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="row">
            <strong>Payments</strong>
          </div>
          <?php foreach ($payment_types as $type) { ?>
          <div class="row">
            <div class="col-md-8 col-sm-8 col-xs-8 "><?php echo $type['name']; ?></div>
            <div class="col-md-4 col-sm-4 col-xs-4 text-right"><?php echo($this->Number->currency($type['amount'], "NZD")); ?></div>
          </div>
          <?php } ?>
        </div>
      </div>

      <!-- Print : Account Sales -->

      <div class="print-wrap" data-ng-if="(register.layby_sales.sales.length > 0) || (register.layby_sales.payments.length > 0) || (register.account_sales.sales.length > 0) || (register.account_sales.payments.length > 0)">

        <div class="dashed-line-gr"></div>

        <div class="register-account-sales">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="row">
              <strong>Account sales</strong>
            </div>

            <!-- Layby sale started -->
            <!--
            <div class="print-wrap" ng-if="register.layby_sales.sales.length > 0">
              <div class="row">
                <div class="col-md-8 col-sm-8 col-xs-8">Layby sale started</div>
                <div class="col-md-4 col-sm-4 col-xs-4 text-right">{{register.layby_sales.total_sales | currency}}</div>
              </div>
              <div class="row" data-ng-repeat="sale in register.layby_sales.sales">
                <div class="col-md-2 col-sm-4 col-xs-6 ">{{sale.sale_date}}</div>
                <div class="col-md-2 col-sm-4 col-xs-6 ">{{sale.reciept_number}}</div>
                <div class="col-md-2 col-sm-4 col-xs-6 ">{{sale.user_name}}</div>
                <div class="col-md-2 col-sm-4 col-xs-6 ">{{sale.customer_name}}</div>
                <div class="col-md-2 col-sm-4 col-xs-6 ">{{sale.note}}</div>
                <div class="col-md-2 col-sm-4 col-xs-6 ">{{sale.amount | currency}}</div>
              </div>
            </div>
            -->

            <!-- Layby sale payments -->
            <!--
            <div class="print-wrap" ng-if="register.layby_sales.payments.length > 0">
              <div class="row">
                <div class="col-md-8 col-sm-8 col-xs-8">Layby sale payments</div>
                <div class="col-md-4 col-sm-4 col-xs-4 text-right">{{register.layby_sales.total_payments | currency}}</div>
              </div>
              <div class="row" data-ng-repeat="payment in register.layby_sales.payments">
                <div class="col-md-2 col-sm-4 col-xs-6 ">{{payment.sale_date}}</div>
                <div class="col-md-2 col-sm-4 col-xs-6 ">{{payment.reciept_number}}</div>
                <div class="col-md-2 col-sm-4 col-xs-6 ">{{payment.user_name}}</div>
                <div class="col-md-2 col-sm-4 col-xs-6 ">{{payment.customer_name}}</div>
                <div class="col-md-2 col-sm-4 col-xs-6 ">{{payment.note}}</div>
                <div class="col-md-2 col-sm-4 col-xs-6 ">{{payment.amount | currency}}</div>
              </div>
            </div>
            -->

            <!-- Account sale started -->
            <!--
            <div class="print-wrap" ng-if="register.account_sales.sales.length > 0">
              <div class="row">
                <div class="col-md-8 col-sm-8 col-xs-8">Account sale started</div>
                <div class="col-md-4 col-sm-4 col-xs-4 text-right">{{register.account_sales.total_sales | currency}}</div>
              </div>
              <div class="row" data-ng-repeat="sale in register.account_sales.sales">
                <div class="col-md-2 col-sm-4 col-xs-6 ">{{sale.sale_date}}</div>
                <div class="col-md-2 col-sm-4 col-xs-6 ">{{sale.reciept_number}}</div>
                <div class="col-md-2 col-sm-4 col-xs-6 ">{{sale.user_name}}</div>
                <div class="col-md-2 col-sm-4 col-xs-6 ">{{sale.customer_name}}</div>
                <div class="col-md-2 col-sm-4 col-xs-6 ">{{sale.note}}</div>
                <div class="col-md-2 col-sm-4 col-xs-6 ">{{sale.amount | currency}}</div>
              </div>
            </div>
            -->

            <!-- Account sale payments -->
            <!--
            <div class="print-wrap" ng-if="register.account_sales.payments.length > 0">
              <div class="row">
                <div class="col-md-8 col-sm-8 col-xs-8">Account sale payments</div>
                <div class="col-md-4 col-sm-4 col-xs-4 text-right">{{register.account_sales.total_payments | currency}}</div>
              </div>
              <div class="row" data-ng-repeat="payment in register.account_sales.payments">
                <div class="col-md-2 col-sm-4 col-xs-6 ">{{payment.sale_date}}</div>
                <div class="col-md-2 col-sm-4 col-xs-6 ">{{payment.reciept_number}}</div>
                <div class="col-md-2 col-sm-4 col-xs-6 ">{{payment.user_name}}</div>
                <div class="col-md-2 col-sm-4 col-xs-6 ">{{payment.customer_name}}</div>
                <div class="col-md-2 col-sm-4 col-xs-6 ">{{payment.note}}</div>
                <div class="col-md-2 col-sm-4 col-xs-6 ">{{payment.amount | currency}}</div>
              </div>
            </div>
            -->
          </div>
        </div>

      </div>

      <div class="foot-space text-center" style="padding: 30px;">
        <p><br><p><br>
          Print by onzsa.com
      </div>

    </div>
  </div>

</div>

<!-- BEGIN CORE PLUGINS -->
<?php echo $this->element('script-jquery'); ?>
<?php echo $this->element('script-angularjs'); ?>
<!-- END CORE PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/theme/onzsa/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/admin/pages/scripts/index.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/admin/pages/scripts/tasks.js" type="text/javascript"></script>
<script src="/js/jquery.jqprint-0.3.js" type="text/javascript"></script>
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

    $(".btn-print").click(function(){
      $("#receipt").jqprint();
      return false;
    });
    $(".btn-close").click(function(){
      location.href = "/reports/closures";
    });
  };
</script>