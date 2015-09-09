<link href="/css/dataTable.css" rel="stylesheet" type="text/css">
<div class="clearfix"></div>
<div id="notify"></div>
<!-- BEGIN CONTENT -->
<div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
  <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
    Register Sales Detail
  </h2>

  <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20">
    <a href="#" id="export">
      <button class="btn btn-white pull-right">
        <div class="glyphicon glyphicon-export"></div>
        &nbsp;
        export
      </button>
    </a>
  </div>
</div>

<!-- FILTER -->
<form class="col-md-12 col-xs-12 col-sm-12 line-box filter-box" action="/reports/sales/register_sales_detail"
      method="get">
  <div class="col-md-4 col-xs-6 col-sm-6">
    <dl>
      <dt>Date from</dt>
      <dd>
        <span class="glyphicon glyphicon-calendar icon-calendar"></span>
        <input type="text" id="date_from" name="from" value="<?php if (isset($_GET['from'])) {
          echo $_GET['from'];
        } ?>" )>
      </dd>
    </dl>
  </div>
  <div class="col-md-4 col-xs-6 col-sm-6">
    <dl>
      <dt>Date to</dt>
      <dd>
        <span class="glyphicon glyphicon-calendar icon-calendar"></span>
        <input type="text" id="date_to" name="to" value="<?php if (isset($_GET['to'])) {
          echo $_GET['to'];
        } ?>">
      </dd>
    </dl>
  </div>
  <div class="col-md-4 col-xs-6 col-sm-6">
    <dl>
      <dt>Register</dt>
      <dd>
        <select name="register_id">
          <option value=""></option>
          <?php foreach ($registers as $register) { ?>
            <option
                value="<?php echo $register['MerchantRegister']['id']; ?>" <?php if (isset($_GET['register_id']) && $_GET['register_id'] == $register['MerchantRegister']['id']) {
              echo "selected";
            } ?>><?php echo $register['MerchantRegister']['name']; ?></option>
          <?php } ?>
        </select>
      </dd>
    </dl>
  </div>
  <div class="col-md-4 col-xs-6 col-sm-6">
    <dl>
      <dt>Outlet</dt>
      <dd>
        <select name="outlet_id">
          <option value=""></option>
          <?php foreach ($outlets as $outlet) { ?>
            <option
                value="<?php echo $outlet['MerchantOutlet']['id']; ?>" <?php if (isset($_GET['outlet_id']) && $_GET['outlet_id'] == $outlet['MerchantOutlet']['id']) {
              echo "selected";
            } ?>><?php echo $outlet['MerchantOutlet']['name']; ?></option>
          <?php } ?>
        </select>
      </dd>
    </dl>
  </div>
  <div class="col-md-4 col-xs-6 col-sm-6">
    <dl>
      <dt>Customer group</dt>
      <dd>
        <select name="customer_group_id">
          <option value=""></option>
          <?php foreach ($customerGroups as $customerGroup) { ?>
            <option
                value="<?php echo $customerGroup['MerchantCustomerGroup']['id']; ?>" <?php if (isset($_GET['customer_group_id']) && $_GET['customer_group_id'] == $customerGroup['MerchantCustomerGroup']['id']) {
              echo "selected";
            } ?>><?php echo $customerGroup['MerchantCustomerGroup']['name']; ?></option>
          <?php } ?>
        </select>
      </dd>
    </dl>
  </div>
  <div class="col-md-12 col-xs-12 col-sm-12">
    <button type="submit" class="btn btn-primary filter pull-right">Update</button>
  </div>
</form>
<div class="col-md-3 col-sm-3 col-xs-3 col-omega">
  <table class="table-bordered dataTable">
    <colgroup>
      <col width="60%">
      <col width="40%">
    </colgroup>
    <thead>
    <tr>
      <th class="first-child">Date</th>
      <th class="no-radius">Receipt</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($sales)) {
      foreach ($sales as $sale) { ?>
        <tr>
          <td class="text-limit"><?php echo $sale['RegisterSale']['sale_date']; ?></td>
          <td><?php echo $sale['RegisterSale']['receipt_number']; ?></td>
        </tr>
        <?php $emptyRow = 0;
        if (count($sale['RegisterSaleItem']) > count($sale['RegisterSalePayment'])) {
          $emptyRow = count($sale['RegisterSaleItem']);
        } else {
          $emptyRow = count($sale['RegisterSalePayment']);
        }
        for ($i = 0; $i <= $emptyRow - 1; $i++) { ?>
          <tr>
            <td colspan="2" style="border: 0">&nbsp;</td>
          </tr>
        <?php }
      }
    } else { ?>
      <tr>
        <td colspan="2">&nbsp;</td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
</div>
<div class="col-md-9 col-sm-9 col-xs-9 col-alpha">
  <div class="scroll-table">
    <table class="table-bordered dataTable">
      <colgroup>
        <col width="10%">
        <col width="10%">
        <col width="10%">
        <col width="10%">
        <col width="15%">
        <col width="10%">
        <col width="15%">
        <col width="10%">
      </colgroup>
      <thead>
      <tr>
        <th>Register</th>
        <th>User</th>
        <th>Customer</th>
        <th>Notes</th>
        <th>Products</th>
        <th>Total</th>
        <th>Payments</th>
        <th>Paid</th>
      </tr>
      </thead>
      <tbody>
      <?php if (!empty($sales)) {
        foreach ($sales as $sale) { ?>
          <tr class="table-color-gr">
            <td><?php echo $sale['MerchantRegister']['name']; ?></td>
            <td><?php echo $sale['MerchantUser']['display_name']; ?></td>
            <td><?php echo $sale['MerchantCustomer']['name']; ?></td>
            <td class="discrete tiny"><?php echo $sale['RegisterSale']['note']; ?></td>
            <td class="strong">Total sale</td>
            <td class="strong currency"><?php echo number_format($sale['RegisterSale']['total_price_incl_tax'], 2, '.', ','); ?></td>
            <td class="strong">Total paid</td>
            <td class="strong currency">
              <?php $totalPayment = 0;
              foreach ($sale['RegisterSalePayment'] as $payment) {
                $totalPayment += $payment['amount'];
              }
              echo number_format($totalPayment, 2, '.', ','); ?>
            </td>
          </tr>
          <?php
          if (count($sale['RegisterSaleItem']) > count($sale['RegisterSalePayment'])) {
            $emptyRow = count($sale['RegisterSaleItem']);
          } else {
            $emptyRow = count($sale['RegisterSalePayment']);
          }
          for ($i = 0; $i <= $emptyRow - 1; $i++) { ?>
            <tr>
              <td colspan="4" style="border: 0">&nbsp;</td>
              <?php if (!empty($sale['RegisterSaleItem'][$i])) { ?>
                <td class="strong"><?php echo $sale['RegisterSaleItem'][$i]['MerchantProduct']['name']; ?></td>
                <td class="strong currency">
                  <?php echo number_format($sale['RegisterSaleItem'][$i]['MerchantProduct']['price_include_tax'], 2, '.', ','); ?>
                </td>
              <?php } else { ?>
                <td style="border: 0; border-left:1px solid #ddd;">&nbsp;</td>
                <td style="border: 0">&nbsp;</td>
              <?php }
              if (!empty($sale['RegisterSalePayment'][$i])) { ?>
                <td class="strong"><?php echo $sale['RegisterSalePayment'][$i]['MerchantPaymentType']['name']; ?></td>
                <td class="strong currency">
                  <?php echo number_format($sale['RegisterSalePayment'][$i]['amount'], 2, '.', ','); ?>
                </td>
              <?php } else { ?>
                <td style="border: 0; border-left:1px solid #ddd;">&nbsp;</td>
                <td style="border: 0">&nbsp;</td>
              <?php } ?>
            </tr>
          <?php }
        }
      } else { ?>
        <tr>
          <td colspan="8">Select your criteria above to update the table.</td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
  </div>
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

  $("#date_from").datepicker({ dateFormat: 'yy-mm-dd' });
  $("#date_to").datepicker({ dateFormat: 'yy-mm-dd' });
}
</script>
