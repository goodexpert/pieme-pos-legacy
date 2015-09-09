<?php
$EmptyHistory = 'Sales history does not exist.';
$AuthUser = $this->Session->read('Auth.User');
?>
<style>
  .line-box-content{
    overflow-y:auto;
  }
</style>
<link href="/css/dataTable.css" rel="stylesheet" type="text/css">
<div id="notify"></div>
<!-- BEGIN CONTENT -->
<div id="Users-container">
  <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
    <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega"><?php echo $user['username']; ?></h2>
    <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega">
      <?php if ($user['id'] == $user['id'] || ($user['Merchant']['id'] == $user['Merchant']['id'] && $user['user_type_id'] == 'user_type_admin')) { ?>
        <a href="/users/<?php echo $user['id']; ?>/edit">
          <button class="btn btn-white add-customer pull-right margin-top-20">
            <div class="glyphicon glyphicon-edit"></div>
            &nbsp;Edit
          </button>
        </a>
      <?php } ?>
    </div>
  </div>
  <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
    <div class="col-lg-6 col-md-12 col-xs-12 col-sm-12 user-info-box margin-top-20">
      <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega line-box">
        <div class="col-md-4 col-xs-4 col-sm-4 col-alpha">
          <span class="profile-img"></span>
        </div>
        <div class="col-md-8 col-xs-8 col-sm-8 col-alpha">
          <dl>
            <dt>Username</dt>
            <dd><?php echo $user['username']; ?></dd>
            <dt>Name</dt>
            <dd><?php echo $user['display_name']; ?></dd>
            <dt>Email</dt>
            <dd><?php echo $user['email']; ?></dd>
            <dt>Limit to outlet</dt>
            <dd><?php echo(empty($user['MerchantOutlet']) ? '-' : $user['MerchantOutlet']['name']); ?></dd>
            <dt>Created at</dt>
            <dd><?php echo $user['created']; ?></dd>
          </dl>
        </div>
      </div>
    </div>
    <div class="col-lg-6 col-md-12 col-xs-12 col-sm-12 user-info-box margin-top-20">
      <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega form-title">Alerts</div>
      <div class="form-body line-box line-box-content col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
        <ul>
          <li>You have 25 days left on your trial. Activate your account now.</li>
          <li>You have 25 days left on your trial. Activate your account now.</li>
          <li>You have 25 days left on your trial. Activate your account now.</li>
          <li>You have 25 days left on your trial. Activate your account now.</li>
        </ul>
      </div>
    </div>
  </div>
  <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
    <div class="col-lg-6 col-md-12 col-xs-12 col-sm-12 user-info-box-bg margin-top-20">
      <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega form-title">Sales Targets</div>
      <div id="colchart_diff"
           class="form-body line-box line-box-content col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
        <span id='colchart_before' style='display: inline-block'></span>
        <span id='colchart_after' style='display: inline-block'></span>
        <span id='colchart_diff' style='display: inline-block'></span>
        <span id='barchart_diff' style='display: inline-block'></span>
      </div>
      <input type="hidden" id="daily_target" value="<?php if ($user['daily_target'] == 0) {
        echo 0;
      } else {
        echo $user['daily_target'];
      } ?>">
      <input type="hidden" id="weekly_target" value="<?php if ($user['weekly_target'] == 0) {
        echo 0;
      } else {
        echo $user['weekly_target'];
      } ?>">
      <input type="hidden" id="monthly_target" value="<?php if ($user['monthly_target'] == 0) {
        echo 0;
      } else {
        echo $user['monthly_target'];
      } ?>">
      <?php
      $daily = 0;
      $weekly = 0;
      $monthly = 0;
      foreach ($sales as $sale) {
        if ($sale['RegisterSale']['sale_date'] > date("Y-m-d 00:00:00") && $sale['RegisterSale']['sale_date'] <= date("Y-m-d 23:59:59")) {
          $daily += $sale['RegisterSale']['total_price_incl_tax'];
        }
        if ($sale['RegisterSale']['sale_date'] > date("Y-m-d", strtotime('sunday last week')) && $sale['RegisterSale']['sale_date'] <= date("Y-m-d 23:59:59")) {
          $weekly += $sale['RegisterSale']['total_price_incl_tax'];
        }
        if ($sale['RegisterSale']['sale_date'] > date("Y-m-d", strtotime('first day of this month')) && $sale['RegisterSale']['sale_date'] <= date("Y-m-d 23:59:59")) {
          $monthly += $sale['RegisterSale']['total_price_incl_tax'];
        }
      }
      ?>
      <input type="hidden" id="daily_sales" value="<?php echo $daily; ?>">
      <input type="hidden" id="weekly_sales" value="<?php echo $weekly; ?>">
      <input type="hidden" id="monthly_sales" value="<?php echo $monthly; ?>">
    </div>
    <div class="col-lg-6 col-md-12 col-xs-12 col-sm-12 user-info-box-bg margin-top-20">
      <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega form-title">Sales History</div>
      <div class="form-body line-box line-box-content col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
        <?php if (!empty($sales)) {
          foreach ($sales as $sale) { ?>
            <?php echo $sale['RegisterSale']['sale_date']; ?> // $<?php echo number_format($sale['RegisterSale']['total_price_incl_tax'], 2, '.', ','); ?>
            <br>
          <?php }
        } else {
          echo $EmptyHistory;
        } ?>
      </div>
    </div>
  </div>
  <div class="col-md-12 col-xs-12 col-sm-12 margin-top-20">
    <table id="historyTable" class="table table-striped table-bordered dataTable">
      <thead>
      <tr>
        <th class="hisID">ID</th>
        <th class="hisUser">User</th>
        <th class="hisCustomer">Customer</th>
        <th class="hisNote">Note</th>
        <th class="hisStatus">Status</th>
        <th class="hisType">Type</th>
        <th class="tblTotal">Total</th>
        <th class="hisDate">Date</th>
      </tr>
      </thead>
      <tbody>
      <?php if (!empty($sales)) {
        foreach ($sales as $sale) { ?>
          <tr>
            <td><?php echo $sale['RegisterSale']['receipt_number']; ?></td>
            <td><?php echo $user['display_name']; ?></td>
            <td><?php echo $sale['MerchantCustomer']['name']; ?></td>
            <td><?php echo $sale['RegisterSale']['note']; ?></td>
            <td><?php echo $sale['RegisterSale']['status']; ?></td>
            <td></td>
            <td><?php echo number_format($sale['RegisterSale']['total_price_incl_tax'], 2, '.', ','); ?></td>
            <td><?php echo $sale['RegisterSale']['sale_date']; ?></td>
          </tr>
        <?php }
      } ?>
      </tbody>
    </table>
  </div>
  <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="/theme/onzsa/assets/global/plugins/respond.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/excanvas.min.js"></script>
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<?php echo $this->element('script-jquery'); ?>
<?php echo $this->element('script-angularjs'); ?>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js"
        type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js"
        type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js"
        type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js"
        type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js"
        type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/bootstrap-daterangepicker/moment.min.js"
        type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js"
        type="text/javascript"></script>
<!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
<script src="/theme/onzsa/assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.min.js"
        type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js"
        type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/gritter/js/jquery.gritter.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/theme/onzsa/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/admin/pages/scripts/index.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/admin/pages/scripts/tasks.js" type="text/javascript"></script>
<script type="text/javascript" src="/js/jquery.confirm.js"></script>
<script src="/js/jquery.popupoverlay.js" type="text/javascript"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script src="/js/dataTable.js" type="text/javascript"></script>
<?php echo $this->element('common-init'); ?>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
  jQuery(document).ready(function () {
    commonInit();
    $("#Date_from").datepicker();
    $("#Date_to").datepicker();
  });

  google.load('visualization', '1.1', {packages: ['corechart', 'bar']});
  google.setOnLoadCallback(drawStacked);

  function drawStacked() {
    var oldData = google.visualization.arrayToDataTable([
      ['Name', 'Sales'],
      ['Daily', parseFloat($("#daily_target").val())],
      ['Weekly', parseFloat($("#weekly_target").val())],
      ['Monthly', parseFloat($("#monthly_target").val())]
    ]);

    var newData = google.visualization.arrayToDataTable([
      ['Name', 'Sales'],
      ['Daily', parseFloat($("#daily_sales").val())],
      ['Weekly', parseFloat($("#weekly_sales").val())],
      ['Monthly', parseFloat($("#monthly_sales").val())]
    ]);

    var colChartBefore = new google.visualization.ColumnChart(document.getElementById('colchart_before'));
    var colChartAfter = new google.visualization.ColumnChart(document.getElementById('colchart_after'));
    var colChartDiff = new google.visualization.ColumnChart(document.getElementById('colchart_diff'));
    var barChartDiff = new google.visualization.BarChart(document.getElementById('barchart_diff'));

    var options = {diff: {newData: {widthFactor: 0.1}}};

    colChartBefore.draw(oldData, options);
    colChartAfter.draw(newData, options);

    var diffData = colChartDiff.computeDiff(oldData, newData);
    colChartDiff.draw(diffData, options);
    barChartDiff.draw(diffData, options);
  }

  $("div[dir=ltr]").attr("style", "");
</script>
<!-- END JAVASCRIPT -->
