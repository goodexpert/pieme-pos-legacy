<link href="/css/dataTable.css" rel="stylesheet" type="text/css"/>

<div class="clearfix"></div>
<!-- BEGIN CONTENT -->
<div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
  <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega"><?php echo $customer['MerchantCustomer']['name']; ?></h2>
  <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega">
    <button id="delete" class="btn btn-white btn-right pull-right margin-top-20">
      <div class="glyphicon glyphicon-remove"></div>
      &nbsp;Delete
    </button>
    <a href="<?php echo "$_SERVER[REQUEST_URI]"; ?>/edit">
      <button class="btn btn-white btn-left pull-right margin-top-20">
        <div class="glyphicon glyphicon-edit"></div>
        &nbsp;Edit
      </button>
    </a>
  </div>
</div>
<div class="col-lg-6 col-md-12 col-xs-12 col-sm-12 margin-top-20 col-alpha">
  <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega line-box">
    <div class="col-md-12 col-xs-12 col-sm-12">
      <dl>
        <dt>Group</dt>
        <dd><?php echo $customer['MerchantCustomerGroup']['name']; ?></dd>
        <dt>Physical address</dt>
        <dd>New Zealand<br>
          <a id="view_map">View map</a>
        </dd>
        <dt></dt>
        <dd>
        </dd>
      </dl>
    </div>
  </div>
</div>
<div class="col-lg-6 col-md-12 col-xs-12 col-sm-12 margin-top-20 col-alpha col-omega">
  <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega line-box">
    <div class="col-md-12 col-xs-12 col-sm-12">
      <dl>
        <dt>Balance</dt>
        <dd class="font-big"><?php echo str_replace('$-', '-$', '$' . number_format($customer['MerchantCustomer']['balance'], 2, '.', ',')); ?></dd>
        <dt>Year to date</dt>
        <dd>$<?php echo number_format($cost, 2, '.', ','); ?></dd>
        <dt>Total spent</dt>
        <dd>$<?php echo number_format($paid, 2, '.', ','); ?></dd>
      </dl>
    </div>
  </div>
</div>
<!-- FILTER -->
<div class="col-md-12 col-xs-12 col-sm-12 line-box filter-box margin-top-20">
  <div class="col-md-4 col-xs-4 col-sm-4">
    <dl>
      <dt>Date from</dt>
      <dd>
        <span class="glyphicon glyphicon-calendar icon-calendar"></span>
        <input type="text" id="date_from">
      </dd>
      <dt>Register</dt>
      <dd><input type="text" id=""></dd>
      <dt>Amount</dt>
      <dd><input type="text" id=""></dd>
    </dl>
  </div>
  <div class="col-md-4 col-xs-4 col-sm-4">
    <dl>
      <dt>Date to</dt>
      <dd>
        <span class="glyphicon glyphicon-calendar icon-calendar"></span>
        <input type="text" id="date_to">
      </dd>
      <dt>Receipt number</dt>
      <dd><input type="text" id=""></dd>
      <dt></dt>
      <dd><input type="checkbox" class="margin-right-10">Is discounted</dd>
    </dl>
  </div>
  <div class="col-md-4 col-xs-4 col-sm-4">
    <dl>
      <dt>Show</dt>
      <dd><select>
          <option></option>
        </select>
      </dd>
      <dt>User</dt>
      <dd><select>
          <option></option>
        </select>
      </dd>
    </dl>
  </div>
  <div class="col-md-12 col-xs-12 col-sm-12">
    <button class="btn btn-primary filter pull-right">Update</button>
  </div>
</div>
<table id="historyTable">
  <thead>
  <tr>
    <th>Date</th>
    <th>User</th>
    <th>Register</th>
    <th>Receipt</th>
    <th>Note</th>
    <th>Status</th>
    <th>Total</th>
  </tr>
  </thead>
  <tbody>
  <?php foreach ($salesHistory as $sh) { ?>
    <tr>
      <td><?php echo $sh['RegisterSale']['created']; ?></td>
      <td>user</td>
      <td>register</td>
      <td><?php echo $sh['RegisterSale']['receipt_number']; ?></td>
      <td><?php echo $sh['RegisterSale']['note']; ?></td>
      <td><?php echo $sh['RegisterSale']['status']; ?></td>
      <td>$<?php echo number_format($sh['RegisterSale']['total_cost'], 2, '.', ','); ?></td>
    </tr>
  <?php } ?>
  </tbody>
</table>

<!-- END CONTENT -->

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
<!-- END PAGE LEVEL SCRIPTS -->
<script src="/js/dataTable.js" type="text/javascript"></script>
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

    $("#historyTable").DataTable({
      searching: false
    });

    $("#historyTable_length").hide();

    $("#delete").click(function () {
      $.ajax({
        url: location.href + '/delete.json',
        type: 'POST',
        data: {
          request: 'delete'
        },
        success: function (result) {
          if (result.success) {
            window.location.href = "/customer";
          } else {
            console.log(result);
          }
        }
      });
    });
  };
</script>
<!-- END JAVASCRIPTS -->
