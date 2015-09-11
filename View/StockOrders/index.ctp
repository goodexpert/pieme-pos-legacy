<link href="/css/dataTable.css" rel="stylesheet" type="text/css"/>
<div class="clearfix"></div>
<div id="notify"></div>
<!-- BEGIN CONTENT -->
<div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega margin-bottom-20">
  <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
    Stock Control
  </h2>

  <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20">
    <a href="/stock_takes">
      <button id="import" class="btn btn-white pull-right btn-right" style="color:black">
        <div class="glyphicon glyphicon-stats"></div>
        &nbsp;
        Inventory Count
      </button>
    </a>
    <a href="/stock_orders/newTransfer">
      <button id="" class="btn btn-white pull-right btn-center" style="color:black">
        <div class="glyphicon glyphicon-sort"></div>
        &nbsp;
        Transfer Stock
      </button>
    </a>
    <a href="/stock_orders/newOrder">
      <button class="btn btn-white pull-right btn-left">
        <div class="glyphicon glyphicon-list-alt"></div>
        &nbsp;
        Order Stock
      </button>
    </a>
  </div>
</div>
<!-- FILTER -->
<form action="/stock_orders" method="get">
  <div class="col-md-12 col-xs-12 col-sm-12 line-box filter-box">
    <div class="col-md-4 col-xs-4 col-sm-4">
      <dl>
        <dt>Show</dt>
        <dd>
          <?php
          echo $this->Form->input('status', array(
              'name' => 'status',
              'type' => 'select',
              'div' => false,
              'label' => false,
              'selected' => $status,
              'options' => $filters
          ));
          ?>
        </dd>
        <dt>Date from</dt>
        <dd>
          <span class="glyphicon glyphicon-calendar icon-calendar"></span>
          <?php
          echo $this->Form->input('date_from', array(
              'name' => 'date_from',
              'type' => 'text',
              'class' => 'datepicker',
              'div' => false,
              'label' => false,
              'value' => $date_from
          ));
          ?>
        </dd>
        <dt>Due date from</dt>
        <dd>
          <span class="glyphicon glyphicon-calendar icon-calendar"></span>
          <?php
          echo $this->Form->input('due_date_from', array(
              'name' => 'due_date_from',
              'type' => 'text',
              'class' => 'datepicker',
              'div' => false,
              'label' => false,
              'value' => $due_date_from
          ));
          ?>
        </dd>
      </dl>
    </div>
    <div class="col-md-4 col-xs-4 col-sm-4">
      <dl>
        <dt>Name / Has product</dt>
        <dd>
          <?php
          echo $this->Form->input('name', array(
              'name' => 'name',
              'type' => 'text',
              'div' => false,
              'label' => false,
              'value' => $name
          ));
          ?>
        </dd>
        <dt>Date to</dt>
        <dd>
          <span class="glyphicon glyphicon-calendar icon-calendar"></span>
          <?php
          echo $this->Form->input('date_to', array(
              'name' => 'date_to',
              'type' => 'text',
              'class' => 'datepicker',
              'div' => false,
              'label' => false,
              'value' => $date_to
          ));
          ?>
        </dd>
        <dt>Due date to</dt>
        <dd>
          <span class="glyphicon glyphicon-calendar icon-calendar"></span>
          <?php
          echo $this->Form->input('due_date_to', array(
              'name' => 'due_date_to',
              'type' => 'text',
              'class' => 'datepicker',
              'div' => false,
              'label' => false,
              'value' => $due_date_to
          ));
          ?>
        </dd>
      </dl>
    </div>
    <div class="col-md-4 col-xs-4 col-sm-4">
      <dl>
        <dt>Supplier invoice</dt>
        <dd>
          <?php
          echo $this->Form->input('supplier_invoice', array(
              'name' => 'supplier_invoice',
              'type' => 'text',
              'div' => false,
              'label' => false,
              'value' => $supplier_invoice
          ));
          ?>
        </dd>
        <dt>Outlet</dt>
        <dd>
          <?php
          echo $this->Form->input('outlet_id', array(
              'name' => 'outlet_id',
              'type' => 'select',
              'div' => false,
              'label' => false,
              'selected' => $outlet_id,
              'options' => $outlets,
              'empty' => ''
          ));
          ?>
        </dd>
        <dt>Supplier</dt>
        <dd>
          <?php
          echo $this->Form->input('supplier_id', array(
              'name' => 'supplier_id',
              'type' => 'select',
              'div' => false,
              'label' => false,
              'selected' => $supplier_id,
              'options' => $suppliers,
              'empty' => ''
          ));
          ?>
        </dd>
      </dl>
    </div>
    <div class="col-md-12 col-xs-12 col-sm-12">
      <button id="apply_filter" class="btn btn-primary filter pull-right">Update</button>
    </div>
  </div>
</form>
<table id="stockTable" class="table-bordered">
  <colgroup>
    <col width="15%">
    <col width="15%">
    <col width="10%">
    <col width="10%">
    <col width="10%">
    <col width="10%">
    <col width="7%">
    <col width="7%">
    <col width="">
  </colgroup>
  <thead>
  <tr>
    <th>Name</th>
    <th>Type</th>
    <th>date</th>
    <th>Due at</th>
    <th>Outlet</th>
    <th>Source</th>
    <th>Item</th>
    <th>Status</th>
    <th class="last-child"></th>
  </tr>
  </thead>
  <tbody>
  <?php
  foreach ($orders as $order) :
    $orderType = $order['MerchantStockOrder']['order_type_id'];
    $orderStatus = $order['MerchantStockOrder']['order_status_id'];
    $sourceName = '';
    $orderItemQuantity = 0;

    if ($orderType === 'stock_order_type_stockorder') {
      $orderType = 'Supplier order';
      $sourceName = $order['MerchantSupplier']['name'];
    } elseif ($orderType === 'stock_order_type_transfer') {
      $orderType = 'Outlet transfer';
      $sourceName = $order['MerchantSourceOutlet']['name'];
    }

    if (empty($sourceName)) {
      $sourceName = 'No Name';
    }

    if (!empty($order['MerchantStockOrder']['order_item_quantity'])) {
      $orderItemQuantity = $order['MerchantStockOrder']['order_item_quantity'];
    }
    ?>
    <tr>
      <td><?php echo $order['MerchantStockOrder']['name']; ?></td>
      <td><?php echo $orderType; ?></td>
      <td>
        <?php
        echo is_null($order['MerchantStockOrder']['date'])
            ? ''
            : date('d M Y', strtotime($order['MerchantStockOrder']['date']));
        ?>
      </td>
      <td>
        <?php
        echo is_null($order['MerchantStockOrder']['due_date'])
            ? ''
            : date('d M Y', strtotime($order['MerchantStockOrder']['due_date']));
        ?>
      </td>
      <td><?php echo $order['MerchantOutlet']['name']; ?></td>
      <td><?php echo $sourceName; ?></td>
      <td><?php echo $orderItemQuantity; ?></td>
      <td><?php echo $order['StockOrderStatus']['name']; ?></td>
      <td>
        <a href="/stock_orders/<?php echo $order['MerchantStockOrder']['id']; ?>">View</a>
        <?php if ($orderStatus === 'stock_order_status_open') : ?>
          | <a href="/stock_orders/<?php echo $order['MerchantStockOrder']['id']; ?>/edit">Edit</a>
        <?php elseif (in_array($orderStatus, array('stock_order_status_sent', 'stock_order_status_approved', 'stock_order_status_shipped'))) : ?>
          | <a href="/stock_orders/receive/<?php echo $order['MerchantStockOrder']['id']; ?>">Receive</a>
        <?php endif; ?>
      </td>
    </tr>
    <?php
  endforeach;
  ?>
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

    $("#stockTable").DataTable({
      searching: false
    });
    $("#stockTable_length").hide();
    $(".datepicker").datepicker();
  }
  ;
</script>
<!-- END JAVASCRIPTS -->
