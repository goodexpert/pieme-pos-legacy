<div class="clearfix"></div>
<div class="container">
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
                    <form class="sidebar-search sidebar-search-bordered" action="extra_search.html" method="POST">
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
                    Stock Levels
                </h2>
                <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20">
                    <a href="#" id="export"><button class="btn btn-white pull-right">
                        <div class="glyphicon glyphicon-export"></div>&nbsp;
                    export</button></a>
                </div>
            </div>
                
            <!-- FILTER -->
            <form class="col-md-12 col-xs-12 col-sm-12 line-box filter-box" action="/reports/stock/levels" method="get">
                <div class="col-md-4 col-xs-6 col-sm-6">
                    <dl>
                        <dt>Group by handle</dt> 
                        <dd>
                            <select>
                                <option selected>by variant</option>
                                <option>by handle</option>
                            </select>
                        </dd>
                    </dl> 
                </div>
                <div class="col-md-4 col-xs-6 col-sm-6">
                    <dl>
                        <dt>Name / SKU / Handle</dt> 
                        <dd>
                            <input type="text" name="name" value="<?php if(isset($_GET['name'])){echo $_GET['name'];}?>">
                        </dd>
                    </dl>
                 </div>
                <div class="col-md-4 col-xs-6 col-sm-6">
                    <dl>
                        <dt>Product type</dt> 
                        <dd>
                            <select name="product_type_id">
                                <option value=""></option>
                                <?php foreach($types as $type) { ?>
                                    <option value="<?php echo $type['MerchantProductType']['id'];?>" <?php if(isset($_GET['product_type_id']) && $_GET['product_type_id'] == $type['MerchantProductType']['id']){echo "selected";}?>><?php echo $type['MerchantProductType']['name'];?></option>
                                <?php } ?>
                            </select>
                        </dd>
                    </dl>
                 </div>
                <div class="col-md-4 col-xs-6 col-sm-6">
                    <dl>
                        <dt>Brand</dt> 
                        <dd>
                            <select name="product_brand_id">
                                <option value=""></option>
                                <?php foreach($brands as $brand) { ?>
                                    <option value="<?php echo $brand['MerchantProductBrand']['id'];?>" <?php if(isset($_GET['product_brand_id']) && $_GET['product_brand_id'] == $brand['MerchantProductBrand']['id']){echo "selected";}?>><?php echo $brand['MerchantProductBrand']['name'];?></option>
                                <?php } ?>
                            </select>
                        </dd>
                    </dl>
                 </div>
                <div class="col-md-4 col-xs-6 col-sm-6">
                    <dl>
                        <dt>Supplier</dt> 
                        <dd>
                            <select name="supplier_id">
                                <option value=""></option>
                                <?php foreach($suppliers as $supplier) { ?>
                                    <option value="<?php echo $supplier['MerchantSupplier']['id'];?>" <?php if(isset($_GET['supplier_id']) && $_GET['supplier_id'] == $supplier['MerchantSupplier']['id']){echo "selected";}?>><?php echo $supplier['MerchantSupplier']['name'];?></option>
                                <?php } ?>
                            </select>
                        </dd>
                    </dl>
                 </div>
                <div class="col-md-4 col-xs-6 col-sm-6">
                    <dl>
                        <dt>Outlet</dt> 
                        <dd>
                            <select name="outlet_id">
                                <option value=""></option>
                                <?php foreach($outlets as $outlet) { ?>
                                    <option value="<?php echo $outlet['MerchantOutlet']['id'];?>" <?php if(isset($_GET['outlet_id']) && $_GET['outlet_id'] == $outlet['MerchantOutlet']['id']){echo "selected";}?>><?php echo $outlet['MerchantOutlet']['name'];?></option>
                                <?php } ?>
                            </select>
                        </dd>
                    </dl>
                 </div>
                <div class="col-md-4 col-xs-6 col-sm-6">
                    <dl>
                        <dt>Tag</dt> 
                        <dd>
                            <input type="search" list="tag" id="tag_search" class="col-md-8" autocomplete="off">
                            <datalist id="tag">
                                <?php foreach($tags as $tag) { ?>
                                <option value="<?php echo $tag['MerchantProductTag']['name'];?>">
                                <?php } ?>
                            </datalist>
                            <button type="button" class="col-md-4" id="add_tag">ADD</button>
                        </dd>
                    </dl>
                 </div>
                 <div class="col-md-12 col-xs-12 col-sm-12 tag_list" style="margin-top:15px;">
                     <?php if(!empty($_GET['tag'])) {
                         foreach($_GET['tag'] as $key => $tag) { ?>
                             <div class="tag_wrap" sqn="<?php echo $key;?>">
                                 <div class="added_tag" style="width:8%; text-align:center; float:left"><?php echo $tag;?> <span class="remove_tag clickable"><i class="glyphicon glyphicon-remove"></i></span></div>
                                 <input type="hidden" name="tag[<?php echo $key;?>]" value="<?php echo $tag;?>">
                             </div>
                         <?php }
                     } ?>
                 </div>
                 <div class="col-md-12 col-xs-12 col-sm-12">
                     <button type="submit" class="btn btn-primary filter pull-right">Update</button>
                 </div>
            </form>

            <table class="table-bordered dataTable table-price">
                <colgroup>
                    <col width="">
                    <col width="15%">
                    <col width="10%">
                    <col width="7%">
                    <col width="13%">
                    <col width="13%">
                    <col width="13%">
                </colgroup>
                <thead>
                <tr>
                    <th>Product</th>
                    <th>SKU</th>
                    <th>Outlet</th>
                    <th class="text-right">Count</th>
                    <th class="text-right">Value</th>
                    <th class="text-right">Avg. Item Value</th>
                    <th class="text-right">Recorder pointe</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    $totalCount = 0;
                    $totalValue = 0;
                    $totalAvg = 0;
                    $productCount = 0;
                    if(empty($products)) {
                    } else {
                        foreach($products as $product) {
                            foreach($product['MerchantProductInventory'] as $inventory) {
                                $totalCount += $inventory['count'];
                                $totalValue += $product['MerchantProduct']['supply_price'] * $inventory['count'];
                                $productCount++;
                            }
                        }
                        $totalAvg = $totalValue / $productCount;
                    ?>
                    <tr class="table-color">
                        <td><strong>TOTAL</strong></td>
                        <td> </td>
                        <td> </td>
                        <td class="text-right"><strong><?php echo $totalCount;?></strong></td>
                        <td class="text-right"><strong>$<?php echo number_format($totalValue,2,'.',',');?></strong></td>
                        <td class="text-right"><strong>$<?php echo number_format($totalAvg,2,'.',',');?></strong></td>
                        <td class="text-right"><strong>&nbsp;</strong></td>
                    </tr>
                    <?php foreach($products as $proudct) {
                        foreach($proudct['MerchantProductInventory'] as $inventory) {?>
                        <tr>
                            <td><?php echo $proudct['MerchantProduct']['name'];?></td>
                            <td><?php echo $proudct['MerchantProduct']['sku'];?></td>
                            <td><?php echo $inventory['MerchantOutlet']['name'];?></td>
                            <td class="text-right"><?php echo $inventory['count'];?></td>
                            <td class="text-right"><?php echo '$'.number_format($proudct['MerchantProduct']['supply_price'] * $inventory['count'],2,'.',',');?></td>
                            <td class="text-right"><?php echo '$'.number_format($proudct['MerchantProduct']['supply_price'],2,'.',',');?></td>
                            <td class="text-right"><?php echo $inventory['reorder_point'];?></td>
                        </tr>
                        <?php }
                    } ?>
                    <?php } ?>
                    <tr class="table-color">
                        <td><strong>TOTAL</strong></td>
                        <td> </td>
                        <td> </td>
                        <td class="text-right"><strong><?php echo $totalCount;?></strong></td>
                        <td class="text-right"><strong>$<?php echo number_format($totalValue,2,'.',',');?></strong></td>
                        <td class="text-right">&nbsp;</td>
                        <td class="text-right">&nbsp;</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- END CONTENT -->
</div>
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="/theme/onzsa/assets/global/plugins/respond.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<script src="/theme/onzsa/assets/global/plugins/jquery-1.11.0.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="/theme/onzsa/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
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
<script>
jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    Index.init();
    
    $("#date_from").datepicker();
    $("#date_to").datepicker();
    
    var i = $(".tag_wrap").length;
    $("#add_tag").click(function() {
        var tag_name = $("#tag_search").val();
        var tag_available = false;
        $("datalist option").each(function(){
            if($(this).val() == tag_name) {
                tag_available = true;
            }
        });
        if(tag_available) {
            $(".tag_list").append('<div class="tag_wrap" sqn="'+i+'"></div>');
            $(".tag_wrap[sqn="+i+"]").append('<div class="added_tag" style="width:8%; text-align:center; float:left">'+tag_name+' <span class="remove_tag clickable"><i class="glyphicon glyphicon-remove"></i></span></div>');
            $(".tag_wrap[sqn="+i+"]").append('<input type="hidden" name="tag['+i+']" value="'+tag_name+'">');
            i++;
        }
    });
    $(document).on("click",".remove_tag",function() {
        $(this).parents(".tag_wrap").remove();
        i--;
    });
});
</script>
