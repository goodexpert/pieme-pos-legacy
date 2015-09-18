<div class="clearfix"></div>
<div id="notify"></div>
<!-- BEGIN CONTENT -->
<?php if ('stock_order_type_stockorder' === $order_type) : ?>
<h3>New Stock Order</h3>
<form action="/stock_orders/createOrder" method="post" enctype="multipart/form-data">
  <?php else : ?>
  <h3>New Stock Trasfer</h3>

  <form action="/stock_orders/createTransfer" method="post" enctype="multipart/form-data">
    <?php endif; ?>
    <?php
    echo $this->Form->input('MerchantStockOrder.order_type_id', array(
        'id' => 'order_type_id',
        'type' => 'hidden',
        'value' => $order_type
    ));
    ?>
    <div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">Details</div>
    <div class="line-box line-box-content col-md-12 col-sm-12 col-xs-12">
      <div class="col-md-6">
        <dl>
          <dt>Name / reference</dt>
          <dd>
            <?php
            echo $this->Form->input('MerchantStockOrder.name', array(
                'id' => 'name',
                'type' => 'text',
                'div' => false,
                'label' => false,
                'value' => 'Order - ' . date('d M Y')
            ));
            ?>
          </dd>
          <dt>Due at</dt>
          <dd>
            <span class="glyphicon glyphicon-calendar icon-calendar"></span>
            <?php
            echo $this->Form->input('MerchantStockOrder.due_date', array(
                'id' => 'due_date',
                'type' => 'text',
                'class' => 'datepicker',
                'div' => false,
                'label' => false,
                'placeholder' => date('Y-m-d')
            ));
            ?>
          </dd>
          <?php if ('stock_order_type_stockorder' === $order_type) : ?>
            <dt>Supplier invoice</dt>
            <dd>
              <?php
              echo $this->Form->input('MerchantStockOrder.supplier_invoice', array(
                  'id' => 'supplier_invoice',
                  'type' => 'text',
                  'div' => false,
                  'label' => false
              ));
              ?>
            </dd>
          <?php endif; ?>
        </dl>
      </div>
      <div class="col-md-6">
        <dl>
          <?php if ('stock_order_type_stockorder' === $order_type) : ?>
            <dt>Order from</dt>
            <dd>
              <?php
              echo $this->Form->input('MerchantStockOrder.supplier_id', array(
                  'id' => 'supplier_id',
                  'type' => 'select',
                  'div' => false,
                  'label' => false,
                  'options' => $suppliers,
                  'empty' => 'Any'
              ));
              ?>
            </dd>
            <dt>Deliver to</dt>
            <dd>
              <?php
              echo $this->Form->input('MerchantStockOrder.outlet_id', array(
                  'id' => 'outlet_id',
                  'type' => 'select',
                  'div' => false,
                  'label' => false,
                  'options' => $outlets
              ));
              ?>
            </dd>
          <?php else : ?>
            <dt>Source outlet</dt>
            <dd>
              <?php
              echo $this->Form->input('MerchantStockOrder.source_outlet_id', array(
                  'id' => 'source_outlet_id',
                  'type' => 'select',
                  'div' => false,
                  'label' => false,
                  'options' => $outlets,
                  'empty' => ''
              ));
              ?>
            </dd>
            <dt>Destination outlet</dt>
            <dd>
              <?php
              echo $this->Form->input('MerchantStockOrder.outlet_id', array(
                  'id' => 'outlet_id',
                  'type' => 'select',
                  'div' => false,
                  'label' => false,
                  'options' => $outlets
              ));
              ?>
            </dd>
          <?php endif; ?>
        </dl>
      </div>
      <div class="dashed-line-gr margin-top-20"></div>
      <div class="col-md-6">
        <dl>
          <dt>Auto fill</dt>
          <dd>
            <select name="data[auto_fill]" id="auto_fill">
              <option value="1">Auto-fill from reorder point</option>
              <option value="0">Don't auto-fill</option>
            </select>
          </dd>
          <dt></dt>
          <dd><p>Auto fill your order with products that have low stock levels (500 product max).</p></dd>
        </dl>
      </div>
      <div class="col-md-6">
        <dl>
          <dt>Import order</dt>
          <dd><input type="file" name="order_file"></dd>
        </dl>
      </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12 pull-right margin-top-20 margin-bottom-20">
      <button class="btn btn-primary btn-wide pull-right save" type="submit">Save</button>
      <a href="/stock_orders" class="btn btn-default btn-wide pull-left margin-right-10 cancel">Cancel</a>
    </div>
    </div>
  </form>
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
  <script src="/js/dataTable.js"></script>
  <!-- END PAGE LEVEL SCRIPTS -->
  <!-- BEGIN COMMON INIT -->
  <?php echo $this->element('common-init'); ?>
  <!-- END COMMON INIT -->
  <script>
    jQuery(document).ready(function () {
      documentInit();
    });

    function documentInit() {
      // common init function
      commonInit();

      $(".datepicker").datepicker({dateFormat: 'yy-mm-dd'});
    }
    ;
  </script>
  <!-- END JAVASCRIPTS -->
