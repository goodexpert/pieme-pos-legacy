<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <div id="notify"></div>
    <!-- BEGIN SIDEBAR -->
    <div class="page-sidebar-wrapper">
        <!-- BEGIN HORIZONTAL RESPONSIVE MENU -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <div class="page-sidebar navbar-collapse collapse">
            <ul class="page-sidebar-menu" data-slide-speed="200" data-auto-scroll="true">
                <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
                <!-- DOC: This is mobile version of the horizontal menu. The desktop version is defined(duplicated) in the header above -->
                <li class="sidebar-search-wrapper">
                    <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                    <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
                    <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
                    <form class="sidebar-search sidebar-search-bordered" method="POST">
                        <a href="javascript:;" class="remove">
                        <i class="icon-close"></i>
                        </a>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                            <button class="btn submit"><i class="icon-magnifier"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- END RESPONSIVE QUICK SEARCH FORM -->
                </li>
                <li>
                    <a href="index">
                    Sell
                    </a>
                </li>
                <li>
                    <a href="history">
                    History </a>
                </li>
                <li class="active">
                    <a href="history">
                    Product <span class="selected">
                    </span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- END HORIZONTAL RESPONSIVE MENU -->
    </div>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">

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

        </div>
    </div>
    <!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="/assets/global/plugins/respond.min.js"></script>
<script src="/assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="/assets/global/plugins/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="/assets/admin/pages/scripts/index.js" type="text/javascript"></script>
<script src="/assets/admin/pages/scripts/tasks.js" type="text/javascript"></script>
<script type="text/javascript" src="/js/jquery.confirm.js"></script>
<script src="/js/dataTable.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    Index.init();
    
    $("#productList").DataTable({
        searching: false
    });
    $("#productList_length").hide();
    
    $("#delete").confirm({
        text: "Are you sure you want to delete this price book?",
        title: "Confirmation required",
        confirm: function(button) {
           $.ajax({
               url: '/pricebook/delete.json',
               type: 'POST',
               data: {
                   id: location.search.split('=')[1]
               },
               success: function(result){
                   if(result.success) {
                       window.location.href = "/pricebook";
                   } else {
                       console.log(result);
                   }
               },
               error: function(jqXHR, textStatus, errorThrown) {
                   console.log(textStatus, errorThrown);
               }
           });
        },
        cancel: function(button) {
        },
        confirmButton: "Delete",
        cancelButton: "Cancel",
        confirmButtonClass: "btn-danger",
        cancelButtonClass: "btn-default",
        dialogClass: "modal-dialog modal-lg" // Bootstrap classes for large modal
    });
});
</script>