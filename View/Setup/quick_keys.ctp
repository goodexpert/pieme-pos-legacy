<link href="/css/dataTable.css" rel="stylesheet" type="text/css">
<div class="clearfix"></div>
<div id="notify"></div>
<!-- BEGIN CONTENT -->
<div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega margin-bottom-20">
  <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
    Stock List
  </h2>

  <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20">
    <a href="/quick_keys/new">
      <button class="btn btn-white pull-right">
        <div class="glyphicon glyphicon-plus"></div>
        &nbsp;
        Add Stock List
      </button>
    </a>
  </div>
</div>
<table id="historyTable" class="table table-striped table-bordered dataTable margin-bottom-20">
  <thead>
  <tr>
    <th>Stock List Layout</th>
    <th>Date Created</th>
    <th></th>
  </tr>
  </thead>
  <tbody>
  <?php foreach ($items as $item) { ?>
    <tr>
      <td><?= $item['MerchantQuickKey']['name']; ?></td>
      <td><?= date("D, d M Y, h:i A", strtotime($item['MerchantQuickKey']['created'])); ?></td>
      <td><a href="/quick_keys/<?= $item['MerchantQuickKey']['id']; ?>/edit">Edit</a></td>
    </tr>
  <?php } ?>
  </tbody>
</table>
<h4 class="margin-top-20 inline-block">Assign Layouts to Registers</h4>
<table class="table-bordered dataTable-sm">
  <thead>
  <tr>
    <th>Register</th>
    <th>Outlet</th>
    <th>Stock List Layout</th>
    <th></th>
  </tr>
  </thead>
  <tbody>
  <?php foreach ($outlets as $outlet) {
    foreach ($outlet['MerchantRegister'] as $register) { ?>
      <tr class="register-list-data" data-id="<?php echo $register['id']; ?>">
        <td><?php echo $register['name']; ?></td>
        <td><?php echo $outlet['MerchantOutlet']['name']; ?></td>
        <td>
          <select class="width-inherit quick_key_id assign_quick_key">
            <?php foreach ($items as $item) { ?>
              <option
                  value="<?php echo $item['MerchantQuickKey']['id']; ?>" <?php if ($register['quick_key_id'] == $item['MerchantQuickKey']['id']) {
                echo "selected";
              } ?>><?php echo $item['MerchantQuickKey']['name']; ?></option>
            <?php } ?>
          </select>
        </td>
        <td><a href="/register/<?php echo $register['id']; ?>/edit">Edit register</a></td>
      </tr>
    <?php }
  } ?>
  </tbody>
</table>
<!-- END CONTENT -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<?php echo $this->element('script-jquery'); ?>
<?php echo $this->element('script-angularjs'); ?>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js"></script>
<script src="/theme/onzsa/assets/global/plugins/flot/jquery.flot.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/flot/jquery.flot.resize.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/flot/jquery.flot.categories.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jquery.pulsate.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/bootstrap-daterangepicker/moment.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
<script src="/theme/onzsa/assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jquery.sparkline.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/gritter/js/jquery.gritter.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->


<script src="/theme/onzsa/assets/admin/pages/scripts/tasks.js"></script>
<script src="/js/notify.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN COMMON INIT -->
<?php echo $this->element('common-init'); ?>
<!-- END COMMON INIT -->
<script>
  jQuery(document).ready(function () {
    documentInit();
  });

  function documentInit(){
    // common init function
    commonInit();
    $(".assign_quick_key").change(function (e) {
      var register_id = $(".register-list-data").attr("data-id");
      var quick_key_id = $(".quick_key_id").val();

      if (register_id == '' || quick_key_id == '')
        return;

      $.ajax({
        url: '/quick_key/assign.json',
        type: 'POST',
        data: {
          register_id: register_id,
          quick_key_id: quick_key_id
        },
        success: function (result) {
          if (result.success) {
            alert("changed");
          } else {
            console.log(result);
          }
        }
      });
    });
  };
</script>
<!-- END JAVASCRIPTS -->
