<link href="/css/dataTable.css" rel="stylesheet" type="text/css">
<div class="clearfix"></div>
<div id="notify"></div>
<!-- BEGIN CONTENT -->
<div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega margin-bottom-20">
  <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
    Sales Taxes
  </h2>

  <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20">
    <button class="btn btn-white pull-right add-tax">
      <div class="glyphicon glyphicon-plus"></div>
      &nbsp;
      Add Sales Tax
    </button>
  </div>
</div>
<table id="historyTable" class="table table-striped table-bordered dataTable">
  <colgroup>
    <col width="33%">
    <col width="33%">
    <col width="33%">
  </colgroup>
  <thead>
  <tr>
    <th>Name</th>
    <th>Rate</th>
    <th></th>
  </tr>
  </thead>
  <tbody>
  <?php foreach ($taxes as $tax) : ?>
    <tr>
      <td><?php echo $tax['MerchantTaxRate']['name']; ?></td>
      <td><?php echo round($tax['MerchantTaxRate']['rate'], 2) * 100; ?>%</td>
      <td><span class="clickable edit-tax" data-id="<?php echo $tax['MerchantTaxRate']['id']; ?>">Edit</span> |
        <span class="clickable delete-tax" data-id="<?php echo $tax['MerchantTaxRate']['id']; ?>">Delete</span>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

</div>
</div>
<!-- END CONTENT -->
<!-- ADD TAX POPUP BOX -->
<div id="popup-add_tax" class="confirmation-modal modal fade in" tabindex="-1" role="dialog" aria-hidden="false"
     style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="confirm-close" data-dismiss="modal" aria-hidden="true">
          <i class="glyphicon glyphicon-remove"></i>
        </button>
        <h4 class="modal-title">Add New Sales Tax</h4>
      </div>
      <div class="modal-body">
        <dl>
          <dt>Tax name</dt>
          <dd><input type="text" id="tax_name"></dd>
          <dt>Tax rate (%)</dt>
          <dd><input type="text" id="tax_rate"></dd>
        </dl>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary confirm-close">Cancel</button>
        <button class="btn btn-success submit">Add</button>
      </div>
    </div>
  </div>
</div>
<!-- ADD TAX POPUP BOX END -->
<!-- EDIT TAX POPUP BOX -->
<div id="popup-edit_tax" class="confirmation-modal modal fade in" tabindex="-1" role="dialog" aria-hidden="false"
     style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="confirm-close" data-dismiss="modal" aria-hidden="true">
          <i class="glyphicon glyphicon-remove"></i>
        </button>
        <h4 class="modal-title">Edit Sales Tax</h4>
      </div>
      <div class="modal-body">
        <dl>
          <dt>Tax name</dt>
          <dd><input type="text" id="tax_name-edit"></dd>
          <dt>Tax rate (%)</dt>
          <dd><input type="text" id="tax_rate-edit"></dd>
        </dl>
        <h5>Changing this tax rate will recalculate retail
          prices for all products associated.</h5>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary confirm-close">Cancel</button>
        <button class="btn btn-success edit-submit">Edit</button>
      </div>
    </div>
    </div>
  </div>
    <!-- EDIT TAX POPUP BOX END -->
    <div class="modal-backdrop fade in" style="display: none;"></div>
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
    <script src="/theme/onzsa/assets/global/scripts/metronic.js"></script>
    <script src="/theme/onzsa/assets/admin/layout/scripts/layout.js"></script>
    <script src="/theme/onzsa/assets/admin/pages/scripts/index.js"></script>
    <script src="/theme/onzsa/assets/admin/pages/scripts/tasks.js"></script>
    <script src="/js/notify.js"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN COMMON INIT -->
    <?php echo $this->element('common-init'); ?>
    <!-- END COMMON INIT -->
    <script>
      jQuery(document).ready(function ()  {
        documentInit();
      });

      function documentInit() {
        // common init function
        commonInit();


      var target;
        $(".add-tax").click(function () {
          $("#popup-add_tax").show();
          $(".modal-backdrop").show();
        });

        $(".edit-tax").click(function () {
          $("#popup-edit_tax").show();
          $(".modal-backdrop").show();
          $("#tax_rate-edit").val($(this).parent().prev().text());
          $("#tax_name-edit").val($(this).parent().prev().prev().text());
          target = $(this).attr("data-id");
        });

        $(".confirm-close").click(function () {
          $("#popup-add_tax").hide();
          $("#popup-edit_tax").hide();
          $(".modal-backdrop").hide();
          $("#tax_rate").val('');
          $("#tax_name").val('');
        });

        $(".submit").click(function () {
          var tax_rate = $("#tax_rate").val().replace(/%/, '');
          $.ajax({
            url: '/taxes/add.json',
            type: 'POST',
            data: {
              name: $("#tax_name").val(),
              rate: tax_rate / 100
            },
            success: function (result) {
              if (result.success) {
                location.reload();
              } else {
                console.log(result);
              }
            }
          });
        });

        $(".edit-submit").click(function () {
          var tax_rate = $("#tax_rate-edit").val().replace(/%/, '');
          $.ajax({
            url: '/taxes/edit.json',
            type: 'POST',
            data: {
              id: target,
              name: $("#tax_name-edit").val(),
              rate: tax_rate / 100
            },
            success: function (result) {
              if (result.success) {
                location.reload();
              } else {
                console.log(result);
              }
            }
          });
        });

        $(".delete-tax").click(function () {
          target = $(this).attr("data-id");
          $.ajax({
            url: '/taxes/delete.json',
            type: 'POST',
            data: {
              id: target
            },
            success: function (result) {
              if (result.success) {
                location.reload();
              } else {
                console.log(result);
              }
            }
          });
        });
      }
    </script>
    <!-- END JAVASCRIPTS -->
