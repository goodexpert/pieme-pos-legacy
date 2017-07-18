<?php
    $user = $this->Session->read('Auth.User');
 ?>
<link href="/css/dataTable.css" rel="stylesheet" type="text/css">
<div class="clearfix"></div>
    <!-- BEGIN CONTENT -->
    <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega margin-bottom-20">
        <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">History</h2>
    </div>
    <!-- FILTER -->
    <form class="col-md-12 col-xs-12 col-sm-12 line-box filter-box" id="form" action="/history" method="get">
        <div class="col-md-4 col-xs-4 col-sm-4">
            <dl>
                <dt>Date from</dt>
                <dd>
                    <span class="glyphicon glyphicon-calendar icon-calendar"></span>
                    <input type="text" id="date_from" name="from" value="<?php if(isset($_GET['from'])){echo $_GET['from'];}?>">
                </dd>
                <dt>Register</dt>
                <dd>
                <?php
                    echo $this->Form->input('register_id', array(
                        'id' => 'register_id',
                        'name' => 'register_id',
                        'type' => 'select',
                        'div' => false,
                        'label' => false,
                        'empty' => '',
                        'options' => $registers,
                        'value' => isset($_GET['register_id']) ? $_GET['register_id'] : ""
                    ));
                 ?>
                </dd>
                <dt>Customer name</dt>
                <dd><input type="text" id="customer" name="customer" value="<?php if(isset($_GET['customer'])){echo $_GET['customer'];}?>"></dd>
            </dl>
        </div>
        <div class="col-md-4 col-xs-4 col-sm-4">
            <dl>
                <dt>Date to</dt>
                <dd>
                    <span class="glyphicon glyphicon-calendar icon-calendar"></span>
                    <input type="text" id="date_to" name="to" value="<?php if(isset($_GET['to'])){echo $_GET['to'];}?>">
                </dd>
                <dt>Receipt number</dt>
                <dd><input type="text" id="receipt_number" name="receipt_number" value="<?php if(isset($_GET['receipt_number'])){echo $_GET['receipt_number'];}?>"></dd>
                <dt>Amount</dt>
                <dd><input type="text" id="total_cost" name="total_cost" value="<?php if(isset($_GET['total_cost'])){echo $_GET['total_cost'];}?>"></dd>
            </dl>
         </div>
        <div class="col-md-4 col-xs-4 col-sm-4">
            <dl>
                <dt>Show</dt>
                <dd>
                <?php
                    echo $this->Form->input('filter', array(
                        'id' => 'filter',
                        'name' => 'filter',
                        'type' => 'select',
                        'div' => false,
                        'label' => false,
                        'empty' => 'All Sales',
                        'options' => $status,
                        'value' => isset($_GET['filter']) ? $_GET['filter'] : ""
                    ));
                 ?>
                </dd>
                <dt>User</dt>
                <dd>
                <?php
                    echo $this->Form->input('user_id', array(
                        'id' => 'user_id',
                        'name' => 'user_id',
                        'type' => 'select',
                        'div' => false,
                        'label' => false,
                        'empty' => '',
                        'options' => $users,
                        'value' => isset($_GET['user_id']) ? $_GET['user_id'] : ""
                    ));
                 ?>
                </dd>
            </dl>
         </div>
         <div class="col-md-12 col-xs-12 col-sm-12">
             <button type="submit" class="btn btn-primary filter pull-right">Update</button>
         </div>
    </form>
    <table id="historyTable" class="table-bordered">
        <colgroup>
            <col width="10%">
            <col width="15%">
            <col width="15%">
            <col width="10%">
            <col width="15%">
            <col width="15%">
            <col width="20%">
        </colgroup>
        <thead>
        <tr>
            <th class="hisID">ID</th>
            <th class="hisUser">User</th>
            <th class="hisCustomer">Customer</th>
            <th class="hisNote">Note</th>
            <th class="hisStatus">Status</th>
            <th class="tblTotal">Total</th>
            <th class="hisDate">Date</th>
        </tr>
        </thead>
        </tbody>
    </table>
    <!-- END CONTENT -->
  </div>
</div>
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

  $("#date_from").datepicker({dateFormat: 'yy-mm-dd'});
  $("#date_to").datepicker({dateFormat: 'yy-mm-dd'});

  $("#historyTable").DataTable({
    "columns": [
      {
        "data": "receipt_number",
      }, {
        "data": "display_name",
      }, {
        "data": "customer_name",
      }, {
        "data": "note",
      }, {
        "data": "status_name",
      }, {
        "data": "total_price_incl_tax",
        "className": "text-right",
        "render": $.fn.dataTable.render.number(",", ".", 5),
      }, {
        "data": "sale_date",
      },
    ],
    "searching": false,
    "processing": true,
    "serverSide": true,
    "ajax": {
      "url": "history/history.json",
      "type": "GET",
      "data": function(d) {
        d.date_from = $('#date_from').val();
        d.date_to = $('#date_to').val();
        d.filter = $('#filter').val();
        d.customer = $('#customer').val();
        d.register_id = $('#register_id').val();
        d.receipt_number = $('#receipt_number').val();
        d.user_id = $('#user_id').val();
        d.amount = $('#total_cost').val();
      }
    }
  });

  $("#form").submit(function(event) {
    $("#historyTable").DataTable.ajax.load();
    event.preventDefault();
  });
}
</script>
<!-- END JAVASCRIPTS -->
