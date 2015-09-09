<link href="/css/dataTable.css" rel="stylesheet" type="text/css">
<div class="clearfix"></div>
<div id="notify"></div>
<!-- BEGIN CONTENT -->
<div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
  <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
    Sales Activity by Hour
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
<form class="col-md-12 col-xs-12 col-sm-12 line-box filter-box" action="/reports/sales/sales_by_hour" method="get">
  <div class="col-md-4 col-xs-6 col-sm-6">
    <dl>
      <dt>Date from</dt>
      <dd>
        <span class="glyphicon glyphicon-calendar icon-calendar"></span>
        <input type="text" id="date_from" name="from" value="<?php if (isset($_GET['from'])) {
          echo $_GET['from'];
        } ?>">
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
      <dt>User</dt>
      <dd>
        <select name="user_id">
          <option value=""></option>
          <?php foreach ($users as $user) { ?>
            <option
                value="<?php echo $user['MerchantUser']['id']; ?>" <?php if (isset($_GET['user_id']) && $_GET['user_id'] == $user['MerchantUser']['id']) {
              echo "selected";
            } ?>><?php echo $user['MerchantUser']['display_name']; ?></option>
          <?php } ?>
        </select>
      </dd>
    </dl>
  </div>
  <div class="col-md-12 col-xs-12 col-sm-12">
    <button type="submit" class="btn btn-primary filter pull-right">Update</button>
  </div>
</form>
<div class="col-md-2 col-sm-2 col-xs-2 col-alpha col-omega">
  <table class="table-bordered dataTable">
    <thead>
    <tr>
      <th class="first-child">Date</th>
    </tr>
    </thead>
    <tbody>
    <?php if (!empty($sales)) {
      foreach ($sales as $date => $value) { ?>
        <tr>
          <td class="text-limit"><?php echo date('d M, Y', strtotime($date)); ?></td>
        </tr>
      <?php }
    } else { ?>
      <tr>
        <td style="border: 0">&nbsp;</td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
</div>
<div class="col-md-10 col-sm-10 col-xs-10 col-alpha col-omega">
  <div class="scroll-table-wide">
    <table class="table-bordered dataTable ">
      <thead>
      <tr class="text-right">
        <th>00:00 - 00:59</th>
        <th>01:00 - 01:59</th>
        <th>02:00 - 02:59</th>
        <th>03:00 - 03:59</th>
        <th>04:00 - 04:59</th>
        <th>05:00 - 05:59</th>
        <th>06:00 - 06:59</th>
        <th>07:00 - 07:59</th>
        <th>08:00 - 08:59</th>
        <th>09:00 - 09:59</th>
        <th>10:00 - 10:59</th>
        <th>11:00 - 11:59</th>
        <th>12:00 - 12:59</th>
        <th>13:00 - 13:59</th>
        <th>14:00 - 14:59</th>
        <th>15:00 - 15:59</th>
        <th>16:00 - 16:59</th>
        <th>17:00 - 17:59</th>
        <th>18:00 - 18:59</th>
        <th>19:00 - 19:59</th>
        <th>20:00 - 20:59</th>
        <th>21:00 - 21:59</th>
        <th>22:00 - 22:59</th>
        <th>23:00 - 23:59</th>
      </tr>
      </thead>
      <tbody class="text-right">
      <?php if (!empty($sales)) {
        foreach ($sales as $sale) { ?>
          <tr>
            <td>
              <?php if (!empty($sale[0])) {
                $totalSale = 0;
                foreach ($sale[0] as $data) {
                  $totalSale += $data['RegisterSale']['total_price_incl_tax'];
                }
                echo number_format($totalSale, 2, '.', ',') . ' (' . count($data) . ')';
              } else {
                echo '&nbsp;';
              } ?>
            </td>
            <td>
              <?php if (!empty($sale[1])) {
                $totalSale = 0;
                foreach ($sale[1] as $data) {
                  $totalSale += $data['RegisterSale']['total_price_incl_tax'];
                }
                echo number_format($totalSale, 2, '.', ',') . ' (' . count($data) . ')';
              } else {
                echo '&nbsp;';
              } ?>
            </td>
            <td><?php if (!empty($sale[2])) {
                $totalSale = 0;
                foreach ($sale[2] as $data) {
                  $totalSale += $data['RegisterSale']['total_price_incl_tax'];
                }
                echo number_format($totalSale, 2, '.', ',') . ' (' . count($data) . ')';
              } else {
                echo '&nbsp;';
              } ?></td>
            <td><?php if (!empty($sale[3])) {
                $totalSale = 0;
                foreach ($sale[3] as $data) {
                  $totalSale += $data['RegisterSale']['total_price_incl_tax'];
                }
                echo number_format($totalSale, 2, '.', ',') . ' (' . count($data) . ')';
              } else {
                echo '&nbsp;';
              } ?></td>
            <td><?php if (!empty($sale[4])) {
                $totalSale = 0;
                foreach ($sale[4] as $data) {
                  $totalSale += $data['RegisterSale']['total_price_incl_tax'];
                }
                echo number_format($totalSale, 2, '.', ',') . ' (' . count($data) . ')';
              } else {
                echo '&nbsp;';
              } ?></td>
            <td><?php if (!empty($sale[5])) {
                $totalSale = 0;
                foreach ($sale[5] as $data) {
                  $totalSale += $data['RegisterSale']['total_price_incl_tax'];
                }
                echo number_format($totalSale, 2, '.', ',') . ' (' . count($data) . ')';
              } else {
                echo '&nbsp;';
              } ?></td>
            <td class="td-color-green"><?php if (!empty($sale[6])) {
                $totalSale = 0;
                foreach ($sale[6] as $data) {
                  $totalSale += $data['RegisterSale']['total_price_incl_tax'];
                }
                echo number_format($totalSale, 2, '.', ',') . ' (' . count($data) . ')';
              } else {
                echo '&nbsp;';
              } ?></td>
            <td><?php if (!empty($sale[7])) {
                $totalSale = 0;
                foreach ($sale[7] as $data) {
                  $totalSale += $data['RegisterSale']['total_price_incl_tax'];
                }
                echo number_format($totalSale, 2, '.', ',') . ' (' . count($data) . ')';
              } else {
                echo '&nbsp;';
              } ?></td>
            <td><?php if (!empty($sale[8])) {
                $totalSale = 0;
                foreach ($sale[8] as $data) {
                  $totalSale += $data['RegisterSale']['total_price_incl_tax'];
                }
                echo number_format($totalSale, 2, '.', ',') . ' (' . count($data) . ')';
              } else {
                echo '&nbsp;';
              } ?></td>
            <td><?php if (!empty($sale[9])) {
                $totalSale = 0;
                foreach ($sale[9] as $data) {
                  $totalSale += $data['RegisterSale']['total_price_incl_tax'];
                }
                echo number_format($totalSale, 2, '.', ',') . ' (' . count($data) . ')';
              } else {
                echo '&nbsp;';
              } ?></td>
            <td><?php if (!empty($sale[10])) {
                $totalSale = 0;
                foreach ($sale[10] as $data) {
                  $totalSale += $data['RegisterSale']['total_price_incl_tax'];
                }
                echo number_format($totalSale, 2, '.', ',') . ' (' . count($data) . ')';
              } else {
                echo '&nbsp;';
              } ?></td>
            <td><?php if (!empty($sale[11])) {
                $totalSale = 0;
                foreach ($sale[11] as $data) {
                  $totalSale += $data['RegisterSale']['total_price_incl_tax'];
                }
                echo number_format($totalSale, 2, '.', ',') . ' (' . count($data) . ')';
              } else {
                echo '&nbsp;';
              } ?></td>
            <td><?php if (!empty($sale[12])) {
                $totalSale = 0;
                foreach ($sale[12] as $data) {
                  $totalSale += $data['RegisterSale']['total_price_incl_tax'];
                }
                echo number_format($totalSale, 2, '.', ',') . ' (' . count($data) . ')';
              } else {
                echo '&nbsp;';
              } ?></td>
            <td><?php if (!empty($sale[13])) {
                $totalSale = 0;
                foreach ($sale[13] as $data) {
                  $totalSale += $data['RegisterSale']['total_price_incl_tax'];
                }
                echo number_format($totalSale, 2, '.', ',') . ' (' . count($data) . ')';
              } else {
                echo '&nbsp;';
              } ?></td>
            <td><?php if (!empty($sale[14])) {
                $totalSale = 0;
                foreach ($sale[14] as $data) {
                  $totalSale += $data['RegisterSale']['total_price_incl_tax'];
                }
                echo number_format($totalSale, 2, '.', ',') . ' (' . count($data) . ')';
              } else {
                echo '&nbsp;';
              } ?></td>
            <td><?php if (!empty($sale[15])) {
                $totalSale = 0;
                foreach ($sale[15] as $data) {
                  $totalSale += $data['RegisterSale']['total_price_incl_tax'];
                }
                echo number_format($totalSale, 2, '.', ',') . ' (' . count($data) . ')';
              } else {
                echo '&nbsp;';
              } ?></td>
            <td><?php if (!empty($sale[16])) {
                $totalSale = 0;
                foreach ($sale[16] as $data) {
                  $totalSale += $data['RegisterSale']['total_price_incl_tax'];
                }
                echo number_format($totalSale, 2, '.', ',') . ' (' . count($data) . ')';
              } else {
                echo '&nbsp;';
              } ?></td>
            <td><?php if (!empty($sale[17])) {
                $totalSale = 0;
                foreach ($sale[17] as $data) {
                  $totalSale += $data['RegisterSale']['total_price_incl_tax'];
                }
                echo number_format($totalSale, 2, '.', ',') . ' (' . count($data) . ')';
              } else {
                echo '&nbsp;';
              } ?></td>
            <td><?php if (!empty($sale[18])) {
                $totalSale = 0;
                foreach ($sale[18] as $data) {
                  $totalSale += $data['RegisterSale']['total_price_incl_tax'];
                }
                echo number_format($totalSale, 2, '.', ',') . ' (' . count($data) . ')';
              } else {
                echo '&nbsp;';
              } ?></td>
            <td><?php if (!empty($sale[19])) {
                $totalSale = 0;
                foreach ($sale[19] as $data) {
                  $totalSale += $data['RegisterSale']['total_price_incl_tax'];
                }
                echo number_format($totalSale, 2, '.', ',') . ' (' . count($data) . ')';
              } else {
                echo '&nbsp;';
              } ?></td>
            <td><?php if (!empty($sale[20])) {
                $totalSale = 0;
                foreach ($sale[20] as $data) {
                  $totalSale += $data['RegisterSale']['total_price_incl_tax'];
                }
                echo number_format($totalSale, 2, '.', ',') . ' (' . count($data) . ')';
              } else {
                echo '&nbsp;';
              } ?></td>
            <td><?php if (!empty($sale[21])) {
                $totalSale = 0;
                foreach ($sale[21] as $data) {
                  $totalSale += $data['RegisterSale']['total_price_incl_tax'];
                }
                echo number_format($totalSale, 2, '.', ',') . ' (' . count($data) . ')';
              } else {
                echo '&nbsp;';
              } ?></td>
            <td><?php if (!empty($sale[22])) {
                $totalSale = 0;
                foreach ($sale[22] as $data) {
                  $totalSale += $data['RegisterSale']['total_price_incl_tax'];
                }
                echo number_format($totalSale, 2, '.', ',') . ' (' . count($data) . ')';
              } else {
                echo '&nbsp;';
              } ?></td>
            <td><?php if (!empty($sale[23])) {
                $totalSale = 0;
                foreach ($sale[23] as $data) {
                  $totalSale += $data['RegisterSale']['total_price_incl_tax'];
                }
                echo number_format($totalSale, 2, '.', ',') . ' (' . count($data) . ')';
              } else {
                echo '&nbsp;';
              } ?></td>
          </tr>
        <?php }
      } else { ?>
        <tr>
          <td colspan="24" style="border: 0; text-align: left;">Select your criteria above to update the table.</td>
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
