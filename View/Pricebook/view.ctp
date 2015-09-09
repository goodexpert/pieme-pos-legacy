
<link href="/css/dataTable.css" rel="stylesheet" type="text/css">
<div class="clearfix"></div>
  <div id="notify"></div>
  <!-- BEGIN CONTENT -->
  <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
      <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
          <?=$book['MerchantPriceBook']['name'];?>
      </h2>
      <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20">
          <?php if(!$book['MerchantPriceBook']['is_default'] == 1){ ?>
          <a href="/pricebook/<?php echo $book['MerchantPriceBook']['id'];?>/edit">
          <button class="btn btn-white pull-right">
              <div class="glyphicon glyphicon-plus"></div>&nbsp;
          Edit</button></a>
          <button id="delete" class="btn btn-white pull-right margin-right-5">
              <div class="glyphicon glyphicon-trash"></div>&nbsp;
          Delete</button>
          <?php } ?>
      </div>
  </div>
  <?php if($book['MerchantPriceBook']['is_default'] == 1) { ?>
  <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
      By default, products will be sold for the following amounts, unless they are overridden by another price book or on the sell screen.<br>To change these amounts you can edit the price and tax rate on individual products.
  </div>
  <?php } ?>
  <div class="dashed-line margin-top-20 margin-bottom-20"></div>
  <table id="productList" class="table-bordered">
      <thead>
      <tr>
          <th>Product</th>
          <th>Retail Price (Excl)</th>
          <th>Sales Tax</th>
          <th>Retail Price (Incl)</th>
          <th>Min Units</th>
          <th>Max Units</th>
      </tr>
      </thead>
      <tbody>
          <?php foreach($book['MerchantPriceBookEntry'] as $product) { ?>
              <tr>
                  <td><?=$product['MerchantProduct']['name'];?></td>
                  <td>$<?=number_format($product['price'],2,'.','');?></td>
                  <td>$<?=number_format($product['tax'],2,'.','');?></td>
                  <td>$<?=number_format($product['price_include_tax'],2,'.','');?></td>
                  <td><?php echo $product['min_units'];?></td>
                  <td><?php echo $product['max_units'];?></td>
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
<script type="text/javascript" src="/js/jquery.confirm.js"></script>
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

  $("#productList").DataTable({
    searching: false
  });
  $("#productList_length").hide();

  $("#delete").confirm({
    text: "Are you sure you want to delete this price book?",
    title: "Confirmation required",
    confirm: function (button) {
      $.ajax({
        url: '/pricebook/delete.json',
        type: 'POST',
        data: {
          id: location.search.split('=')[1]
        },
        success: function (result) {
          if (result.success) {
            window.location.href = "/pricebook";
          } else {
            console.log(result);
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log(textStatus, errorThrown);
        }
      });
    },
    cancel: function (button) {
    },
    confirmButton: "Delete",
    cancelButton: "Cancel",
    confirmButtonClass: "btn-danger",
    cancelButtonClass: "btn-default",
    dialogClass: "modal-dialog modal-lg" // Bootstrap classes for large modal
  });
}
</script>
<!-- END JAVASCRIPTS -->
