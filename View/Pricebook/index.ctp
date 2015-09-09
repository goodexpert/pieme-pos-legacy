
<link href="/css/dataTable.css" rel="stylesheet" type="text/css">
<div class="clearfix"></div>
<div id="notify"></div>
<!-- BEGIN CONTENT -->
<div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega margin-bottom-20">
  <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
    Price Book
  </h2>

  <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20">
    <a href="/pricebook/add">
      <button class="btn btn-white pull-right add-brand">
        <div class="glyphicon glyphicon-plus"></div>
        &nbsp;
        Add
      </button>
    </a>
  </div>
</div>
<table class="table-condensed table-striped table-bordered dataTable">
  <thead>
  <tr>
    <th>Price Book Name</th>
    <th>Customer Group</th>
    <th>Outlet</th>
    <th>Valid From</th>
    <th>Valid To</th>
    <th>Created At</th>
    <th></th>
  </tr>
  </thead>
  <tbody>
  <?php foreach ($books as $book) { ?>
    <tr>
      <td><?php echo $book['MerchantPriceBook']['name']; ?></td>
      <td><?php echo $book['MerchantCustomerGroup']['name']; ?></td>
      <td><?php echo $book['MerchantOutlet']['name']; ?></td>
      <td></td>
      <td></td>
      <td></td>
      <td>
        <a href="/pricebook/view?r=<?php echo $book['MerchantPriceBook']['id']; ?>">View</a>
        <?php if (!$book['MerchantPriceBook']['is_default'] == 1) { ?>
          | <a href="/pricebook/<?php echo $book['MerchantPriceBook']['id']; ?>/edit">Edit</a>
        <?php } ?>
      </td>
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
<script type="text/javascript" src="/js/jquery.confirm.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<?php echo $this->element('common-init'); ?>
<script>
  jQuery(document).ready(function () {
    documentInit();
  });

  function documentInit() {
    commonInit();
  }
</script>
