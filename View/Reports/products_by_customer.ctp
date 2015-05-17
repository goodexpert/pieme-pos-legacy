<style>
.added_tag {
    border: 1px solid #ddd;
    border-radius: 8px;
    background: #eee;
    padding: 5px 10px;
}
.user_row {
    background: #eee;
}
</style>
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
                    Products by Customer
                </h2>
                <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20">
                    <a href="#" id="export"><button class="btn btn-white pull-right">
                        <div class="glyphicon glyphicon-export"></div>&nbsp;
                    export</button></a>
                </div>
            </div>
                
            <!-- FILTER -->
            <form class="col-md-12 col-xs-12 col-sm-12 line-box filter-box" action="/reports/sales/products_by_customer" method="get">
                <div class="col-md-4 col-xs-6 col-sm-6">
                    <dl>
                        <dt>Date from</dt> 
                        <dd>
                            <span class="glyphicon glyphicon-calendar icon-calendar"></span>
                            <input type="text" id="date_from" name="from" value="<?php if(isset($_GET['from'])){echo $_GET['from'];}?>">
                        </dd>
                    </dl> 
                </div>
                <div class="col-md-4 col-xs-6 col-sm-6">
                    <dl>
                        <dt>Date to</dt> 
                        <dd>
                            <span class="glyphicon glyphicon-calendar icon-calendar"></span>
                            <input type="text" id="date_to" name="to"  value="<?php if(isset($_GET['to'])){echo $_GET['to'];}?>">
                        </dd>
                    </dl>
                 </div>
                <div class="col-md-4 col-xs-6 col-sm-6">
                    <dl>
                        <dt>Group</dt>
                        <dd>
                            <select>
                                <option value="0" selected="selected">by variant</option>
                                <option value="1">by handle</option>
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
                        <dt>Register</dt> 
                        <dd>
                            <select name="register_id">
                                <option value=""></option>
                                <?php foreach($registers as $register) { ?>
                                    <option value="<?php echo $register['MerchantRegister']['id'];?>" <?php if(isset($_GET['register_id']) && $_GET['register_id'] == $register['MerchantRegister']['id']){echo "selected";}?>><?php echo $register['MerchantRegister']['name'];?></option>
                                <?php } ?>
                            </select>
                        </dd>
                    </dl>
                 </div>
                <div class="col-md-4 col-xs-6 col-sm-6">
                    <dl>
                        <dt>User</dt>
                        <dd>
                            <select name="user_id">
                                <option value=""></option>
                                <?php foreach($users as $user) { ?>
                                    <option value="<?php echo $user['MerchantUser']['id'];?>" <?php if(isset($_GET['user_id']) && $_GET['user_id'] == $user['MerchantUser']['id']){echo "selected";}?>><?php echo $user['MerchantUser']['display_name'];?></option>
                                <?php } ?>
                            </select>
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
                        <dt>Customer group</dt> 
                        <dd>
                            <select name="customer_group_id">
                                <option value=""></option>
                                <?php foreach($groups as $group) { ?>
                                    <option value="<?php echo $group['MerchantCustomerGroup']['id'];?>" <?php if(isset($_GET['customer_group_id']) && $_GET['customer_group_id'] == $group['MerchantCustomerGroup']['id']){echo "selected";}?>><?php echo $group['MerchantCustomerGroup']['name'];?></option>
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
            <div class="col-md-12 col-xs-12 col-sm-12 filter-ShowMore text-center margin-bottom-20">
                <button class="ShowMore btn btn-default">
                    Show More<span class="glyphicon glyphicon-chevron-down"></span>
                </button>
            </div>
            <?php $salesCount = 0;
            if(!empty($datas)) {
                foreach($datas as $products) {
                    if(!empty($products)) {
                        foreach($products as $product) {
                            if(!empty($_GET['tag'])) {
                                if(!empty($product['RegisterSaleItem']) && !empty($product['MerchantProductCategory'])) {
                                    foreach($product['RegisterSaleItem'] as $saleItem) {
                                        if(!empty($saleItem['RegisterSale']))
                                            $salesCount++;
                                    }
                                }
                            } else {
                                if(!empty($product['RegisterSaleItem'])) {
                                    foreach($product['RegisterSaleItem'] as $saleItem) {
                                        if(!empty($saleItem['RegisterSale']))
                                            $salesCount++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if($salesCount > 0) {?>
            <div class="col-md-3 col-sm-3 col-xs-3 col-omega">
                <table class="table-bordered dataTable">
                    <thead>
                        <tr>
                            <th class="first-child">Product</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($datas as $key => $products) {
                            $len = count($products);
                            $i = 0;
                        ?>
                            <tr>
                                <td class="user_row"><?php echo $key;?></td>
                            </tr>
                            <?php foreach($products as $product) {
                                $i++;
                                $salesCount = 0;
                                if(!empty($_GET['tag'])) {
                                    if(!empty($product['RegisterSaleItem']) && !empty($product['MerchantProductCategory'])) {
                                        foreach($product['RegisterSaleItem'] as $saleItem) {
                                            if(!empty($saleItem['RegisterSale']))
                                                $salesCount++;
                                        }
                                    }
                                } else {
                                    if(!empty($product['RegisterSaleItem'])) {
                                        foreach($product['RegisterSaleItem'] as $saleItem) {
                                            if(!empty($saleItem['RegisterSale']))
                                                $salesCount++;
                                        }
                                    }
                                }
                                if($salesCount > 0) {?>
                                    <tr>
                                        <td><?php echo $product['MerchantProduct']['name'];?></td>
                                    </tr>
                                <?php }
                                if($i == $len) { ?>
                                <tr class="table-color">
                                    <td><strong>Total</strong></td>
                                </tr>
                            <?php }
                            }
                        }?>
                        <tr class="table-color">
                            <td><strong>Grand Total</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-9 col-sm-9 col-xs-9 col-alpha">
                <div class="scroll-table">
                    <table class="table-bordered dataTable">
                        <colgroup>
                            <col width="5%">
                            <col width="5%">
                            <col width="7%">
                            <col width="7%">
                            <col width="9%">
                            <col width="7%">
                            <col width="7%">
                            <col width="7%">
                            <col width="7%">
                            <col width="7%">
                            <col width="7%">
                            <col width="7%">
                            <col width="7%">
                            <col width="9%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th class="text-right">Count</th>
                                <th class="text-right">Sales ($)</th>
                                <th class="text-right">Discount ($)</th>
                                <th class="text-right">Cost ($)</th>
                                <th class="text-right">Gross Profit ($)</th>
                                <th class="text-right">Margin (%)</th>
                                <th class="text-right">Tax ($)</th>
                                <th class="text-right">Sales+Tax ($)</th>
                                <th>SKU</th>
                                <th>Brand</th>
                                <th>Supplier</th>
                                <th>Type</th>
                                <th>Tags</th>
                                <th>Supplier Code</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php
                                $grandTotalCount = 0;
                                $grandTotalSales = 0;
                                $grandTotalDiscount = 0;
                                $grandTotalCost = 0;
                                $grandTotalGrossProfit = 0;
                                $grandTotalTax = 0;

                                $totalCount = 0;
                                $totalSales = 0;
                                $totalDiscount = 0;
                                $totalCost = 0;
                                $totalGrossProfit = 0;
                                $totalTax = 0;
                                foreach($datas as $products) {
                                $len = count($products);
                                $i = 0;
                                ?>
                                    <tr>
                                        <td colspan="14" class="user_row">&nbsp;</td>
                                    </tr>
                                    <?php foreach($products as $product) {
                                        $i++;
                                        $count = 0;
                                        $sales = 0;
                                        $discount = 0;
                                        $cost = 0;
                                        $margin = 0;
                                        $tax = 0;
                                        if(!empty($_GET['tag'])) {
                                            if(!empty($product['RegisterSaleItem']) && !empty($product['MerchantProductCategory'])) {
                                                foreach($product['RegisterSaleItem'] as $saleItem) {
                                                    if(!empty($saleItem['RegisterSale'])) {
                                                        $count++;
                                                        $sales += $saleItem['price'];
                                                        $discount += $saleItem['discount'];
                                                        $cost += $saleItem['supply_price'];
                                                        $tax += $saleItem['tax'];
                                                    }
                                                }
                                            }
                                        } else {
                                            if(!empty($product['RegisterSaleItem'])) {
                                                foreach($product['RegisterSaleItem'] as $saleItem) {
                                                    if(!empty($saleItem['RegisterSale'])) {
                                                        $count++;
                                                        $sales += $saleItem['price'];
                                                        $discount += $saleItem['discount'];
                                                        $cost += $saleItem['supply_price'];
                                                        $tax += $saleItem['tax'];
                                                    }
                                                }
                                            }
                                        }
                                        if($count > 0) { ?>
                                        <tr>
                                            <td class="text-right"><?php echo $count;?></td>
                                            <td class="text-right"><?php echo number_format($sales,2,'.',',');?></td>
                                            <td class="text-right"><?php echo number_format($discount,2,'.',',');?></td>
                                            <td class="text-right"><?php echo number_format($cost,2,'.',',');?></td>
                                            <td class="text-right"><?php echo number_format($sales - $cost,2,'.',',');?></td>
                                            <td class="text-right"><?php if($sales > 0){echo number_format(($sales - $cost) / $sales * 100,2,'.',',');}else{echo 0;}?></td>
                                            <td class="text-right"><?php echo number_format($tax,2,'.',',');?></td>
                                            <td class="text-right"><?php echo number_format($sales + $tax,2,'.',',');?></td>
                                            <td class="text-limit"><?php echo $product['MerchantProduct']['sku'];?></td>
                                            <td class="text-limit"><?php echo $product['MerchantProductBrand']['name'];?></td>
                                            <td><?php echo $product['MerchantSupplier']['name'];?></td>
                                            <td><?php echo $product['MerchantProductType']['name'];?></td>
                                            <td>
                                                <?php if(!empty($product['MerchantProductCategory'])) {
                                                    $tagCount = 0;
                                                    foreach($product['MerchantProductCategory'] as $category) {
                                                        if($tagCount > 0) {
                                                            echo ', '.$category['MerchantProductTag']['name'];
                                                        } else {
                                                            echo $category['MerchantProductTag']['name'];
                                                            $tagCount++;
                                                        }
                                                    }
                                                }?>
                                            </td>
                                            <td><?php echo $product['MerchantProduct']['supplier_code'];?></td>
                                        </tr>
                                    <?php }
                                        $totalCount += $count;
                                        $totalSales += $sales;
                                        $totalDiscount += $discount;
                                        $totalCost += $cost;
                                        $totalGrossProfit += $sales - $cost;
                                        $totalTax += $tax;
                                        if($len == $i) { ?>
                                            <tr class="table-color">
                                                <td class="text-right"><?php echo $totalCount;?></td>
                                                <td class="text-right"><?php echo number_format($totalSales,2,'.',',');?></td>
                                                <td class="text-right"><?php echo number_format($totalDiscount,2,'.',',');?></td>
                                                <td class="text-right"><?php echo number_format($totalCost,2,'.',',');?></td>
                                                <td class="text-right"><?php echo number_format($totalGrossProfit,2,'.',',');?></td>
                                                <td class="text-right"><?php if($totalSales > 0){echo number_format(($totalSales - $totalCost) / $totalSales * 100,2,'.',',');} else {echo "0.00";}?></td>
                                                <td class="text-right"><?php echo number_format($totalTax,2,'.',',');?></td>
                                                <td class="text-right"><?php echo number_format($totalSales + $totalTax,2,'.',',');?></td>
                                                <td class="text-limit"> </td>
                                                <td class="text-limit"> </td>
                                                <td> </td>
                                                <td> </td>
                                                <td> </td>
                                                <td> </td>
                                            </tr>
                                        <?php
                                        $grandTotalCount += $totalCount;
                                        $grandTotalSales += $totalSales;
                                        $grandTotalDiscount += $totalDiscount;
                                        $grandTotalCost += $totalCost;
                                        $grandTotalGrossProfit += $totalGrossProfit;
                                        $grandTotalTax += $totalTax;
                                        
                                        $totalCount = 0;
                                        $totalSales = 0;
                                        $totalDiscount = 0;
                                        $totalCost = 0;
                                        $totalGrossProfit = 0;
                                        $totalTax = 0;
                                        }
                                    }
                                }?>
                                <tr class="table-color">
                                    <td class="text-right"><?php echo $grandTotalCount;?></td>
                                    <td class="text-right"><?php echo number_format($grandTotalSales,2,'.',',');?></td>
                                    <td class="text-right"><?php echo number_format($grandTotalDiscount,2,'.',',');?></td>
                                    <td class="text-right"><?php echo number_format($grandTotalCost,2,'.',',');?></td>
                                    <td class="text-right"><?php echo number_format($grandTotalGrossProfit,2,'.',',');?></td>
                                    <td class="text-right"><?php echo number_format(($grandTotalSales - $grandTotalCost) / $grandTotalSales * 100,2,'.',',');?></td>
                                    <td class="text-right"><?php echo number_format($grandTotalTax,2,'.',',');?></td>
                                    <td class="text-right"><?php echo number_format($grandTotalSales + $grandTotalTax,2,'.',',');?></td>
                                    <td class="text-limit"> </td>
                                    <td class="text-limit"> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php } else { ?>
                    <div class="col-md-12 col-sm-12 col-xs-12 col-alpha">
                        <table class="table-bordered dataTable">
                            <thead>
                                <tr>
                                    <th>Popular Products</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="text-align:center">No results. Try broadening your criteria above.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>
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

    $("#date_from").datepicker({ dateFormat:'yy-mm-dd' });
    $("#date_to").datepicker({ dateFormat:'yy-mm-dd' });

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
