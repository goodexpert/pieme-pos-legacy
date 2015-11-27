<?php
  $user = $this->Session->read('Auth.User');
?>
<link href="/css/dataTable.css" rel="stylesheet" type="text/css">
<div class="clearfix"></div>
<div id="notify"></div>
<!-- BEGIN CONTENT -->
<div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
  <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
    Register Closures
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
<form class="col-md-12 col-xs-12 col-sm-12 line-box filter-box" action="/reports/closures" method="get">
  <div class="col-md-4 col-xs-6 col-sm-6">
    <dl>
      <dt>Register</dt>
      <dd>
        <select name="register_id">
          <option></option>
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
  <?php if ($user['user_type_id'] === "user_type_admin") : ?>
    <div class="col-md-4 col-xs-6 col-sm-6">
      <dl>
        <dt>Outlet</dt>
        <dd>
          <select name="outlet_id">
            <option></option>
            <?php foreach ($outlets as $outlet) { ?>
              <option value="<?php echo $outlet['id']; ?>"
                  <?php if (isset($_GET['outlet_id']) && $_GET['outlet_id'] == $outlet['id']) {
                    echo "selected";
                  } ?>>
                <?php echo $outlet['name']; ?></option>
            <?php } ?>
          </select>
        </dd>
      </dl>
    </div>
  <?php endif; ?>
  <div class="col-md-12 col-xs-12 col-sm-12">
    <button type="submit"  class="btn btn-primary filter pull-right">Update</button>
  </div>
</form>

<table id="closeTable" class="table-bordered dataTable">
  <colgroup>
    <col width="15%">
    <col width="5%">
    <col width="20%">
    <col width="20%">
    <col width="10%">
    <col width="10%">
    <col width="10%">
  </colgroup>
  <thead>
  <tr>
    <th>Register</th>
    <th class="text-right">#</th>
    <th>Time Opened</th>
    <th>Time Closed</th>
    <th class="text-right">Total</th>
  </tr>
  </thead>
  <tbody>
  <?php foreach ($closures as $closure) { ?>
    <tr>
      <td><a href="/reports/closure_verify/<?php echo $closure['MerchantRegisterOpen']['id']; ?>"><?php echo $closure['MerchantRegister']['name']; ?></a></td>
      <td class="text-right"><?php echo $closure['MerchantRegisterOpen']['register_open_count_sequence']; ?></td>
      <td><?php echo $closure['MerchantRegisterOpen']['register_open_time']; ?></td>
      <td><?php if (empty($closure['MerchantRegisterOpen']['register_close_time'])) {
          echo "Still open";
        } else {
          echo $closure['MerchantRegisterOpen']['register_close_time'];
        } ?></td>
      <td class="text-right">
        $<?php echo number_format($closure['MerchantRegisterOpen']['total_sales'] + $closure['MerchantRegisterOpen']['total_tax'], 2, '.', ','); ?></td>
    </tr>
  <?php } ?>
  </tbody>
</table>
<!-- END CONTENT -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->

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
<!-- END PAGE LEVEL SCRIPTS -->
<?php echo $this->element('common-init'); ?>
<script>
  jQuery(document).ready(function() {
    documentInit();
  });

  function documentInit() {
    // common init function
    commonInit();
    $("#closeTable").DataTable({
      searching: false
    });
    $("#closeTable_length").hide();

    $("#date_from").datepicker();
    $("#date_to").datepicker();
  }
</script>
