<?php
    $user = $this->Session->read('Auth.User');
?>
<style>
.receipt-parent {
    position: absolute;
    top: 40px;
    z-index: 20000;
    display: none;
}

.search_result {
    position: absolute;
    z-index: 50;
}

.payment-display li ul li {
    display: inline;
}

.payment-display .total_cost {
    border-top: 1px solid white;
}
</style>
<div class="clearfix"></div>
<div class="receipt-parent col-md-12 col-xs-12 col-sm-12">
    <div class="col-md-12 col-xs-12 col-sm-12">
        <div class="close-popup">
            <i class="glyphicon glyphicon-remove"></i>
        </div>
        <div class="receipt-pos">
            <span class="receipt-pos-inner"></span>
        </div>
    </div>
    <div id="receipt" class="receipt-content">
        <div class="col-md-12 col-xs-12 col-sm-12 show-amount">
            <div class="receipt-header">
                <button type="button" class="pull-right btn btn-white print">
                    <div class="glyphicon glyphicon-print"></div>
                    &nbsp;Print
                </button>
                <h2>ONZSA</h2>
            </div>
            <div class="dashed-line-gr"></div>
            <div class="receipt-body">
                <div class="receipt-body-customer">
                    <span class="receipt-customer-name">customer name</span><br>
                    <span class="receupt-customer-region">New Zealand</span>
                </div>
                <h4 class="receipt-body-type">
                    Receipt / Tax Invoice
                </h4>
                <div class="receipt-body-info">
                    Invoice #<span class="invoice-id"><?php echo $merchant['MerchantRegister']['invoice_sequence']; ?></span><br>
                    <span class="invoice-date">2015-03-10 15:23:49</span><br>
                    Served by: <?php echo $user['display_name'] . ' on ' . $user['MerchantRegister']['name']; ?>
                </div>
                <div class="dashed-line-gr"></div>
                <div class="col-md-12 col-xs-12 col-sm-12 col-omega col-alpha receipt-body-sales">
                    <table class="col-md-12 col-xs-12 col-sm-12 col-omega col-alpha receipt-product-table">
                        <tbody>
                        </tbody>
                    </table>
                    <div class="dashed-line-gr"></div>
                    <table class="col-md-12 col-xs-12 col-sm-12 col-omega col-alpha receipt-product-table-total">
                        <tr>
                            <th>Subtotal</th>
                            <td class="total-amount receipt-subtotal pull-right">$10.00</td>
                        </tr>
                        <tr>
                            <th>Tax (GST)</th>
                            <td class="total-amount receipt-tax pull-right">$10.00</td>
                        </tr>
                        <tr class="receipt_total">
                            <th>TOTAL</th>
                            <td class="total-amount receipt-total pull-right">$20.00</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="receipt-bt"></div>
    </div>
</div>
<div class="container">
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
                        <a href="javascript:;" class="remove"> <i class="icon-close"></i> </a>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn submit"><i class="icon-magnifier"></i></button>
                            </span>
                        </div>
                    </form>
                    <!-- END RESPONSIVE QUICK SEARCH FORM -->
                </li>
                <li class="active"><a href="index"> Sell <span class="selected"> </span> </a></li>
                <li><a href="history"> History </a></li>
            </ul>
        </div>
        <!-- END HORIZONTAL RESPONSIVE MENU -->
    </div>
    <!-- END SIDEBAR -->
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content" id="sell-index">
            <input type="hidden" id="discount_auth" value="<?php echo $user['Merchant']['allow_cashier_discount']; ?>">
            <div class="maximum">
                <ul class="tab-menu-wrapper col-md-12 col-xs-12 col-sm-12 col-alpha col-omega margin-top-30">
                    <!--
                    <button class="btn btn-white maxi pull-right"><i class="icon-size-fullscreen"></i></button>
                    <button class="btn btn-white mini pull-right" style="display:none;"><i class="icon-size-actual"></i></button>
                    -->
                    <li class="current_open active">CURRENT SALE</li>
                    <li class="retrieve_open">RETRIEVE SALE</li>
                    <li><a href="/home/close">CLOSE REGISTER</a></li>
                </ul>
                <input type="hidden" id="retrieve_sale_id">
                <div class="tab-content-wrapper col-md-12 col-xs-12 col-alpha col-omega">
                    <div id="block-left" class="col-md-6 col-xs-6">
                        <div id="table-wrapper" class="col-md-12 col-sm-12 col-alpha col-omega">
                            <div class="box col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                                <table class="added col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                                    <thead>
                                    <tr class="added-header">
                                        <th class="added-product" width="50%">Product</th>
                                        <th class="added-qty-head" width="15%">Qty</th>
                                        <th class="added-discount" width="15%">Price</th>
                                        <th class="added-amount" width="12%">Amount</th>
                                        <th class="added-remove" width="8%"></th>
                                    </tr>
                                    </thead>
                                </table>
                                <div class="portlet-body col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                                    <div class="added-null">
                                        <img src="img/no-order.png" alt="no-order">
                                        <h3>NO ORDER FOUND</h3>
                                    </div>
                                    <div class="scroller setHeight" data-always-visible="1" data-rail-visible="0" style="height:359px;">
                                        <ul class="feeds">
                                            <li>
                                                <div class="cont-col2">
                                                    <table class="added">
                                                        <colgroup>
                                                            <col width="50%">
                                                            <col width="15%">
                                                            <col width="15%">
                                                            <col width="12%">
                                                            <col width="8%">
                                                        </colgroup>
                                                        <tbody class="added-body">
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="commands col-md-12">
                            <?php if (!empty($user['current_outlet_id'])) { ?>
                                <div class="col-lg-6 col-md-6 col-xs-6 col-sm-6 customer-search col-omega col-alpha">
                                    <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                                        <div class="col-md-9 col-xs-9 col-sm-9 col-alpha col-omega">
                                            <input type="search" id="customer_search" class="search" placeholder="Customer Search">
                                            <div class="search_result" style="display:none;">
                                                <span class="search-tri"></span>
                                                <div class="search-default"> No Result</div>
                                                <?php foreach ($customers as $customer) : ?>
                                                    <button type="button"
                                                            data-id="<?= $customer['MerchantCustomer']['id']; ?>"
                                                            data-name="<?= $customer['MerchantCustomer']['name']; ?>"
                                                            data-balance="<?= $customer['MerchantCustomer']['balance']; ?>"
                                                            data-group-id="<?= $customer['MerchantCustomer']['customer_group_id']; ?>"
                                                            class="data-found customer_apply">
                                                        <?= $customer['MerchantCustomer']['name'] . ' (' .
                                                        $customer['MerchantCustomer']['customer_code'] . ')<br>$' .
                                                        number_format($customer['MerchantCustomer']['balance'], 2, '.', ''); ?>
                                                    </button>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-xs-3 col-sm-3 col-alpha col-omega customer_quick_add">
                                            <button class="btn btn-default pull-right">Add</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 col-omega col-alpha customer-search-result">
                                        <dl style="display:none;">
                                            <dt>Name</dt>
                                            <dd id="customer-result-name"></dd>
                                            <dt>Balance</dt>
                                            <dd id="customer-result-balance"></dd>
                                            <input type="hidden" id="customer-selected-id" value="<?php echo $customers[0]['MerchantCustomer']['id']; ?>">
                                            <input type="hidden" id="customer-selected-group-id" value="<?php echo $customers[0]['MerchantCustomer']['customer_group_id']; ?>">
                                        </dl>
                                    </div>
                                    <div class="col-md-12 col-xs-12 col-sm-12 buttons col-alpha col-omega">
                                        <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4 col-omega col-alpha">
                                            <button id="park" class="btn btn-primary">Park</button>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4 col-omega col-alpha">
                                            <button class="btn btn-primary void">VOID</button>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4 col-omega col-alpha">
                                            <button class="btn btn-primary discount" <?php if ($user['Merchant']['allow_cashier_discount'] == 0) { echo "disabled"; } ?>>Discount </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-xs-6 col-sm-6 col-omega">
                                    <div class="receipt"></div>
                                    <div class="col-md-12 col-xs-12 col-sm-12 show-amount">
                                        <ul class="receipt-text">
                                            <li class="pull-left">Subtotal</li>
                                            <li class="pull-right">$
                                                <text class="subTotal">0.00</text>
                                            </li>
                                        </ul>
                                        <ul class="receipt-text">
                                            <li class="pull-left">Tax (GST)</li>
                                            <li class="pull-right">$
                                                <text class="gst">0.00</text>
                                            </li>
                                        </ul>
                                        <ul class="receipt-text">
                                            <li class="pull-left">TOTAL</li>
                                            <li class="pull-right">$
                                                <text class="total">0.00</text>
                                            </li>
                                        </ul>
                                        <div class="solid-line"></div>
                                        <ul class="receipt-text">
                                            <li class="pull-left h4">TO PAY</li>
                                            <li class="pull-right h4">$
                                                <text class="toPay">0.00</text>
                                            </li>
                                        </ul>
                                        <input type="button" value="PAY" id="pay" class="btn">
                                    </div>
                                    <div class="receipt-bt"></div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-6 col-sm-6 col-alpha col-omega pull-right">
                        <div id="block-right-search" class="col-md-12 col-xs-12 col-sm-12">
                            <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                                <div class="col-lg-9 col-md-9 col-xs-9 col-sm-9 col-alpha col-omega">
                                    <input type="search" id="product_search" class="search" placeholder="Product Search" autocomplete="off">
                                </div>
                                <div class="col-lg-3 col-md-3 col-xs-3 col-sm-3 col-omega">
                                    <button id="image-view-c" class="btn btn-white btn-right pull-right">
                                        <div class="glyphicon glyphicon-th-large"></div>
                                    </button>
                                    <button id="button-view-c" class="btn btn-white btn-left pull-right active">
                                        <div class="glyphicon glyphicon-th"></div>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="block-right" class="col-md-12 col-xs-12 col-sm-12 quick-key-body ">
                            <ul class="nav nav-tabs">
                            <?php $keyArray = json_decode($quick_key, true); 
                                foreach($keyArray['quick_keys']['groups'] as $group) { ?>
                                    <li position="<?php echo $group['position']; ?>" class="<?php if($group['position'] == 0){echo "active";} ?>" role="presentation">
                                        <a href="#" class="<?php if($group['color'] == '#000'){echo 'Black';}elseif($group['color'] == '#FF0000'){echo 'Red';}elseif($group['color'] == '#0100FF'){echo 'Blue';}elseif($group['color'] == '#FFE400'){echo 'Yellow';}else{echo 'White';}; ?>"><?php echo $group['name']; ?></a>
                                    </li>
                            <?php } ?>
                            </ul>
                            <div class="quick-key-list">
                                <ul id="sortable" class="ui-sortable">
                                <?php if(!empty($key_layout)) {
                                    foreach($key_layout as $product) { ?>
                                        <li class="quick-key-item clickable <?php if($product['color'] == '#000'){echo 'Black';}elseif($product['color'] == '#FF0000'){echo 'Red';}elseif($product['color'] == '#0100FF'){echo 'Blue';}elseif($product['color'] == '#FFE400'){echo 'Yellow';}else{echo 'White';}; ?>" 
                                            style="<?php if($product['group'] > 0 || $product['page'] > 1){echo "display: none;"; } ?>" 
                                            group="<?php echo $product['group']; ?>" 
                                            data-id="<?php echo $product['product_id']; ?>"
                                            variable="<?php echo $key_items[$product['product_id']]['MerchantProduct']['has_variants']; ?>"
                                            page="<?php echo $product['page']; ?>" 
                                            background="<?php echo $product['color']; ?>"
                                            data-uom="<?php if(!empty($key_items[$product['product_id']]['ProductUom'])){echo $key_items[$product['product_id']]['ProductUom']['ProductUomCategory']['name'];}?>" 
                                            data-symbol="<?php if(!empty($key_items[$product['product_id']]['ProductUom'])){echo $key_items[$product['product_id']]['ProductUom']['symbol'];}?>">
                                            <div class="product-container">
                                                <div class="product-img" style="background: url('<?php if($key_items[$product['product_id']]['MerchantProduct']['image'] == null){echo 'no-image.png';} else {echo $key_items[$product['product_id']]['MerchantProduct']['image'];}?>'); background-size:100%;">
                                                    <span><?php echo $product['label']; ?></span>
                                                </div>
                                                <div class="product-info">
                                                    <div class="product-name"><p><?php echo $product['label']; ?></p></div>
                                                    <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega price-wrap" style="display: none;">
                                                        <div class="product-price col-lg-5 col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                                                            <b>$<span class="price_including_tax">
                                                                <?php
                                                                $priceAvailable = false;
                                                                foreach($pricebooks as $pricebook) {
                                                                    if($pricebook['MerchantPriceBook']['outlet_id'] == $user['current_outlet_id']) {
                                                                        foreach($pricebook['MerchantPriceBookEntry'] as $entry) {
                                                                            if($entry['product_id'] == $key_items[$product['product_id']]['MerchantProduct']['id'] && $entry['min_units'] == null && $entry['max_units'] == null) {
                                                                                echo number_format($entry['price_include_tax'],2,'.','');
                                                                                $priceAvailable = true;
                                                                                break;
                                                                            }
                                                                        }
                                                                        break;
                                                                    }
                                                                }
                                                                foreach($pricebooks as $pricebook) {
                                                                    if($priceAvailable == false) {
                                                                        if($pricebook['MerchantPriceBook']['outlet_id'] == $user['current_outlet_id']) {
                                                                            foreach($pricebook['MerchantPriceBookEntry'] as $entry){
                                                                                if($entry['product_id'] == $key_items[$product['product_id']]['MerchantProduct']['id'] && $entry['min_units'] == null && $entry['max_units'] == null) {
                                                                                    echo number_format($entry['price_include_tax'],2,'.','');
                                                                                    $priceAvailable = false;
                                                                                    break 2;
                                                                                }
                                                                            }
                                                                        }
                                                                        if($pricebook['MerchantPriceBook']['is_default'] == 1) {
                                                                            foreach($pricebook['MerchantPriceBookEntry'] as $entry){
                                                                                if($entry['product_id'] == $key_items[$product['product_id']]['MerchantProduct']['id'] && $entry['min_units'] == null && $entry['max_units'] == null) {
                                                                                    echo number_format($entry['price_include_tax'],2,'.','');
                                                                                    $priceAvailable = false;
                                                                                    break;
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                            </span></b>
                                                        </div>
                                                        <?php if($key_items[$product['product_id']]['MerchantProduct']['track_inventory'] == 1 && !empty($key_items[$product['product_id']]['MerchantProductInventory'])) { ?>
                                                        <div class="product-stock col-lg-7 col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                                                            <small>In Stock: <?php echo $key_items[$product['product_id']]['MerchantProductInventory'][0]['count'];?></small>
                                                        </div>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="product-unit-table hidden">
                                                    <table class="col-md-12">
                                                        <tr>
                                                            <th>Min.</th>
                                                            <th>Max.</th>
                                                            <th>Price</th>
                                                        </tr>
                                                    <?php foreach($pricebooks as $pricebook) {
                                                        foreach($pricebook['MerchantPriceBookEntry'] as $entry) {
                                                            if($entry['product_id'] == $key_items[$product['product_id']]['MerchantProduct']['id'] && isset($entry['min_units'])) { ?>
                                                                <tr class="price-book-row"
                                                                 data-id="<?php echo $entry['product_id'];?>"
                                                                 group-id="<?php if($pricebook['MerchantPriceBook']['customer_group_id'] == $groups[0]['MerchantCustomerGroup']['id']){
                                                                    echo '';
                                                                } else {
                                                                    echo $pricebook['MerchantPriceBook']['customer_group_id'];
                                                                }?>">
                                                                    <td class="item_min"><?php echo $entry['min_units'];?></td>
                                                                    <td class="item_max"><?php echo $entry['max_units'];?></td>
                                                                    <td class="item_price"><?php echo number_format($entry['price_include_tax'],2,'.','');?></td>
                                                                </tr>
                                                            <?php }
                                                        }
                                                    }?>
                                                    </table>
                                                </div>
                                                <input type="hidden" class="product-retail_price" value="<?=$key_items[$product['product_id']]['MerchantProduct']['price'];?>">
                                                <input type="hidden" class="product-tax" value="<?=$key_items[$product['product_id']]['MerchantProduct']['tax'];?>">
                                                <input type="hidden" class="product-supply_price" value="<?=$key_items[$product['product_id']]['MerchantProduct']['supply_price'];?>">
                                            </div>
                                        </li>
                                    <?php }
                                } ?>
                                </ul>
                            </div>
                            <div class="quick-key-list product-found-list" style="display: none;">
                                <ul id="sortable" class="ui-sortable">
                                
                                </ul>
                            </div>
                            <div class="quick-key-list-footer">
                                <span class="pull-left clickable prev"><i class="glyphicon glyphicon-chevron-left"></i></span>
                                <span class="pull-right clickable next"><i class="glyphicon glyphicon-chevron-right"></i></span>
                                <?php
                                $pages = count($keyArray['quick_keys']['groups'][0]['pages']);
                                foreach($keyArray['quick_keys']['groups'] as $group) {
                                    if(count($group['pages']) > $pages) {
                                        $pages = count($group['pages']);
                                    }
                                }
                                for($i = 1;$i <= $pages; $i++){?>
                                    <span rel="<?php echo $i;?>" class="page clickable <?php if($i == 1){echo "selected";}?>"><?php echo $i;?></span>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-footer-inner col-lg-12 col-md-12 col-sm-12 col-xs-12 col-alpha col-omega">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="pull-left col-lg-6 col-md-6 col-sm-6 col-xs-6 col-omega col-alpha margin-top-20">
                            <img src="/img/ONZSA_logo-gr.png" alt="logo-gr">
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-omega col-alpha footer-status margin-top-20">
                            <button class="btn btn-default pull-right"><span class="status-online"></span>Online </button>
                            <p class="pull-right">Main register</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="retrieve-sale" class="hidden">
            <ul class="tab-menu-wrapper col-md-12 col-xs-12 col-sm-12 col-alpha col-omega" style="margin-top: 5px;">
                <!--
                <button class="btn btn-white maxi pull-right"><i class="icon-size-fullscreen"></i></button>
                <button class="btn btn-white mini pull-right" style="display:none;"><i class="icon-size-actual"></i></button>
                -->
                <li class="current_open active">CURRENT SALE</li>
                <li class="retrieve_open">RETRIEVE SALE</li>
                <li><a href="/home/close">CLOSE REGISTER</a></li>
            </ul>
            <div class="tab-content-wrapper col-md-12 col-xs-12 col-sm-12 col-alpha col-omega" style="padding-top: 8px;">
                <table id="retrieveTable" class="table-bordered">
                    <thead>
                    <tr>
                        <th>Date/time</th>
                        <th>Status</th>
                        <th>User</th>
                        <th>Customer</th>
                        <th>Code</th>
                        <th>Total</th>
                        <th>Note</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($retrieves as $sale) { ?>
                        <tr class="clickable retrieve_sale" data-id="<?= $sale['RegisterSale']['id']; ?>" data-customer-id="<?php echo $sale['MerchantCustomer']['id']; ?>" data-customer-name="<?php echo $sale['MerchantCustomer']['name']; ?>" data-customer-balance="<?php echo $sale['MerchantCustomer']['balance']; ?>" data-count="<?= count($sale['RegisterSaleItem']); ?>">
                            <td><?= $sale['RegisterSale']['created']; ?></td>
                            <td><?= $sale['RegisterSale']['status']; ?></td>
                            <td><?= $sale['MerchantUser']['username']; ?></td>
                            <td><?= $sale['MerchantCustomer']['name']; ?></td>
                            <td><?= $sale['MerchantCustomer']['customer_code']; ?></td>
                            <td><?= number_format($sale['RegisterSale']['total_price_incl_tax'], 2, '.', ''); ?></td>
                            <td><?= $sale['RegisterSale']['note']; ?></td>
                            <td>
                                <?php foreach ($sale['RegisterSaleItem'] as $get) { ?>
                                    <span class="hidden retrieve-child-products">
                                    <span class="retrieve-child-id"><?= $get['MerchantProduct']['id']; ?></span>
                                    <span class="retrieve-child-name"><?= $get['MerchantProduct']['name']; ?></span>
                                    <span class="retrieve-child-supply-price"><?php echo number_format($get['MerchantProduct']['supply_price'], 2, '.', ''); ?></span>
                                    <span class="retrieve-child-price"><?php echo number_format($get['MerchantProduct']['price'], 2, '.', ''); ?></span>
                                    <span class="retrieve-child-price-incl-tax"><?= number_format($get['MerchantProduct']['price_include_tax'], 2, '.', ''); ?></span>
                                    <span class="retrieve-child-tax"><?= number_format($get['MerchantProduct']['tax'], 2, '.', ''); ?></span>
                                    <span class="retrieve-child-qty"><?php echo $get['quantity']; ?></span>
                                </span>
                                <?php } ?>
                                <?php foreach ($sale['RegisterSalePayment'] as $paid) { ?>
                                    <span class="hidden retrieve-child-payments">
                                        <input type="hidden" class="payments-name" value="<?php echo $paid['MerchantPaymentType']['name']; ?>">
                                        <input type="hidden" class="payments-amount" value="<?php echo number_format($paid['amount'], 2, '.', ''); ?>">
                                    </span>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- PAY POPUP BOX -->
    <div class="confirmation-modal modal fade in pay" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;margin-left:33%;">
        <div class="modal-dialog col-md-12 col-sm-12 col-xs-12">
            <div class="modal-content col-md-12 col-sm-12 col-xs-12">
                <div class="modal-header col-md-12 col-sm-12 col-xs-12">
                    <button type="button" class="confirm-close cancel" data-dismiss="modal" aria-hidden="true">
                        <i class="glyphicon glyphicon-remove"></i>
                    </button>
                    <h4 class="modal-title">Select a payment method</h4>
                </div>
                <div class="modal-body col-md-12 col-sm-12 col-xs-12">
                    <div class="col-lg-12 col-omega col-alpha">
                        <ul class="payment-display">
                            <li>
                                <ul class="total_cost">
                                    <li>TO PAY</li>
                                    <li class="pull-right">$123.45</li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-12 col-omega col-alpha">
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 col-omega col-alpha">
                            <input type="text" id="set-pay-amount">
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 col-omega">
                            <button class="btn btn-primary pull-right"><span class="glyphicon glyphicon-th"></span> </button>
                        </div>
                    </div>
                    <ul class="margin-top-20 col-lg-12 col-md-12 col-sm-12 col-omega col-alpha payment-btn">
                        <?php foreach ($payments as $payment) { ?>
                            <li class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-omega col-alpha btn-left payment_method" payment-id="<?= $payment['MerchantPaymentType']['id']; ?>" payment-type-id="<?php echo $payment['PaymentType']['id']; ?>" payment-type="<?php echo $payment['PaymentType']['name']; ?>">
                                <button class="btn btn-primary col-lg-12 col-md-12 col-sm-12 col-xs-12 col-omega col-alpha">
                                    <span class="co-md-12"><img src="/img/<?php if ($payment['PaymentType']['name'] == 'Credit Card') { echo 'card'; } else if ($payment['PaymentType']['name'] == 'Cheque') { echo 'cheque'; } else { echo 'cash'; } ?>.png" alt="cash"></span>
                                    <p class="co-md-12"><?= $payment['MerchantPaymentType']['name']; ?></p>
                                </button>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="modal-footer col-md-12 col-sm-12 col-xs-12">
                    <button class="cancel pull-left btn btn-primary" type="button" data-dismiss="modal">Back to Sale </button>
                    <button class="btn btn-success onaccount-sale" type="button" data-dismiss="modal">On account </button>
                    <button class="btn btn-success layby-sale" type="button" data-dismiss="modal">Layby</button>
                </div>
            </div>
        </div>
    </div>
    <!-- PAY POPUP BOX END -->
    <!-- EFTPOS TRANSACTION BOX -->
    <div class="confirmation-modal modal fade in eftpos_status" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body display-msg" style="text-align:center;">
                </div>
            </div>
        </div>
    </div>
    <!-- EFTPOS TRANSACTION BOX END -->
    <!-- VOID POPUP BOX -->
    <div class="confirmation-modal modal fade in void" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="confirm-close cancel" data-dismiss="modal" aria-hidden="true">
                        <i class="glyphicon glyphicon-remove"></i>
                    </button>
                    <h4 class="modal-title">Are you sure?</h4>
                </div>
                <div class="modal-body">
                    <h3>Are you sure you want to void this sale?</h3><br>All products and payments will be removed from
                    the current sale. Voided sale information is saved in the sales history.
                </div>
                <div class="modal-footer">
                    <button class="cancel btn btn-primary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="confirm btn btn-success void-sale" type="button" data-dismiss="modal">Void Sale </button>
                </div>
            </div>
        </div>
    </div>
    <!-- VOID POPUP BOX END -->
    <!-- PARK POPUP BOX -->
    <div class="confirmation-modal modal fade in park" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="confirm-close cancel" data-dismiss="modal" aria-hidden="true">
                        <i class="glyphicon glyphicon-remove"></i>
                    </button>
                    <h4 class="modal-title">Park Current Sale</h4>
                </div>
                <div class="modal-body">
                    <textarea id="leave_note" cols=48 rows=5></textarea>
                </div>
                <div class="modal-footer">
                    <button class="cancel btn btn-primary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="confirm btn btn-success park-sale" type="button" data-dismiss="modal">Park</button>
                </div>
            </div>
        </div>
    </div>
    <!-- PARK POPUP BOX END -->
    <!-- RETRIEVE POPUP BOX -->
    <div class="confirmation-modal modal fade in retrieve-popup" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="confirm-close cancel" data-dismiss="modal" aria-hidden="true">
                        <i class="glyphicon glyphicon-remove"></i>
                    </button>
                    <h4 class="modal-title">Loading a Saved Sale</h4>
                </div>
                <div class="modal-body">
                    You are loading a saved sale (<span id="retrieve_order_count"></span> items). What would you like to
                    do with the current sale (<span id="current_order_count"></span> items)?
                </div>
                <div class="modal-footer">
                    <button class="cancel btn btn-primary pull-left" type="button" data-dismiss="modal">Back to Sale </button>
                    <button class="confirm btn btn-success park-sale retrieve-a" type="button" data-dismiss="modal">Park</button>
                    <button class="btn btn-success void-sale retrieve-a" type="button" data-dismiss="modal">Void </button>
                </div>
            </div>
        </div>
    </div>
    <!-- RETRIEVE POPUP BOX END -->
    <!-- CUSTOMER ADD BOX -->
    <?php if (!empty($user['current_outlet_id'])) { ?>
        <input type="hidden" id="customer-null" value="<?= $customers[0]['MerchantCustomer']['id']; ?>">
        <div class="confirmation-modal modal fade in customer_add" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;margin-left:33%;">
            <div class="modal-dialog col-md-12 col-sm-12 col-xs-12">
                <div class="modal-content col-md-12 col-sm-12 col-xs-12">
                    <div class="modal-header col-md-12 col-sm-12 col-xs-12">
                        <button type="button" class="confirm-close cancel" data-dismiss="modal" aria-hidden="true">
                            <i class="glyphicon glyphicon-remove"></i>
                        </button>
                        <h4 class="modal-title">Add a new customer</h4>
                    </div>
                    <div class="modal-body col-md-12 col-sm-12 col-xs-12">
                        <div class="col-lg-12 col-omega col-alpha">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-6 col-omega">
                                <h5>Customer details</h5>

                                <div class="col-md-6 col-sm-12 col-alpha padding-right-5">
                                    <input type="text" id="add_customer-first" placeholder="Fisrt">
                                </div>
                                <div class="col-md-6 col-sm-12 col-alpha col-omega">
                                    <input type="text" id="add_customer-last" placeholder="Last">
                                </div>
                                <input type="text" id="add_customer-code" placeholder="Customer Code">
                                <input type="text" id="add_customer-phone" placeholder="Phone">
                                <input type="text" id="add_customer-email" placeholder="Email">
                                <h5>Birthdate</h5>
                                <input type="text" id="add_customer-dd" style="width:50px;" placeholder="DD">
                                <input type="text" id="add_customer-mm" style="width:50px;" placeholder="MM">
                                <input type="text" id="add_customer-yyyy" style="width:80px;" placeholder="YYYY">
                                <h5>Gender</h5>
                                <div class="col-md-12 col-alpha col-omega">
                                    <input type="radio" name="gender" value="F" style="width:30px;" id="gender_female">
                                    <label for="gender_female">Female</label>
                                    <input type="radio" name="gender" value="M" style="width:30px;" id="gender_male">
                                    <label for="gender_male">Male</label>
                                </div>
                                <select id="add_customer-group">
                                    <?php foreach ($groups as $group) { ?>
                                        <option value="<?= $group['MerchantCustomerGroup']['id']; ?>"><?= $group['MerchantCustomerGroup']['name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-6">
                                <h5>Physical address</h5>
                                <input type="text" id="add_customer-address1" placeholder="Address">
                                <input type="text" id="add_customer-address2" placeholder="Address">
                                <input type="text" id="add_customer-suburb" placeholder="Suburb">
                                <input type="text" id="add_customer-postcode" placeholder="Postcode">
                                <input type="text" id="add_customer-city" placeholder="City">
                                <input type="text" id="add_customer-state" placeholder="State">
                                <select id="add_customer-country">
                                    <option selected disabled>Select a country</option>
                                    <?php foreach ($countries as $country) { ?>
                                        <option value="<?= $country['Country']['country_code']; ?>"><?= $country['Country']['country_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer col-md-12 col-sm-12 col-xs-12">
                        <button class="btn add_customer-submit btn-success" type="button" data-dismiss="modal">Save </button>
                        <button class="cancel btn btn-primary" type="button" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <!-- CUSTOMER ADD BOX END -->
    <!-- SELECT REGISTER POPUP BOX -->
    <div class="confirmation-modal modal fade in" id="register_box" tabindex="-1" role="dialog" aria-hidden="false" style="display: <?php if (empty($user['MerchantRegister'])) { echo "block"; } else { echo "none"; } ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="confirm-close cancel register-cancel" data-dismiss="modal" aria-hidden="true">
                        <i class="glyphicon glyphicon-remove"></i>
                    </button>
                    <h4 class="modal-title">Select a register</h4>
                </div>
                <div class="modal-body">
                    <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 col-omega">
                        <button id="" class="btn btn-white btn-right pull-right active">
                            <div class="glyphicon glyphicon-th-large"></div>
                        </button>
                        <button id="" class="btn btn-white btn-left pull-right">
                            <div class="glyphicon glyphicon-th-list"></div>
                        </button>
                    </div>
                    <div class="multi_btn margin-top-10 inline-block" style="display:block;">
                        <?php foreach ($registers as $register) : ?>
                            <div class="col-md-3 col-sm-3 col-sx-3">
                                <button class="btn btn-success full-width register-set" register-id="<?php echo $register['id']; ?>" outlet-id="<?php echo $register['outlet_id']; ?>"><?php echo $register['name']; ?></button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <!--
                    <div class="multi_btn-list margin-top-10 inline-block">
                        <ul>
                            <li>Main Register</li>
                            <li>Main Register</li>
                            <li>Main Register</li>
                            <li>Main Register</li>
                            <li>Main Register</li>
                            <li>Main Register</li>
                            <li>Main Register</li>
                            <li>Main Register</li>
                        </ul>
                    </div>
                    -->
                </div>
            </div>
        </div>
    </div>
    <!-- SELECT REGISTER POPUP BOX END -->

    <!-- Variable POPUP BOX -->
    <div class="confirmation-modal modal fade in" id="variable_box" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
        <div class="modal-dialog" style="width: 440px;">
            <div class="modal-content">
                <div class="modal-header">
                      <button type="button" class="confirm-close cancel" data-dismiss="modal" aria-hidden="true">
                        <i class="glyphicon glyphicon-remove"></i>
                      </button>
                      <h4 class="modal-title">Select a variable</h4>
                </div>
                <div class="modal-body">
                    <div class="multi_btn margin-top-10 inline-block" style="display:block;">
                    <?php
                        foreach($key_items as $product) :
                            $product = $product['MerchantProduct'];
                            if(!empty($product['parent_id']) || $product['has_variants'] == 1) :
                    ?>
                        <li class="quick-key-item clickable" 
                            style="display: none; background:#fff; color:#000" 
                            parent-id="<?php if($product['has_variants'] == 1) {echo $product['id'];} else {echo $product['parent_id'];} ?>"
                            data-id="<?php echo $product['id']; ?>" 
                            variable="0"
                            data-uom="<?php if(!empty($key_items[$product['id']]['ProductUom'])){echo $key_items[$product['id']]['ProductUom']['ProductUomCategory']['name'];}?>" 
                            data-symbol="<?php if(!empty($key_items[$product['id']]['ProductUom'])){echo $key_items[$product['id']]['ProductUom']['symbol'];}?>">
                            <div class="product-container">
                                <div class="product-info">
                                    <!--
                                    <div class="product-name"><p><?php echo $product['variant_option_one_value']; ?></p></div>
                                    -->
                                        <div class="product-name"><p>
                                        <?php echo $product['name']; ?>
                                        (<?php echo $product['variant_option_one_value']; 
                                            if( !empty($product['variant_option_two_value']) ) {
                                                echo "/".$product['variant_option_two_value'] ;
                                            }
                                            if( !empty($product['variant_option_three_value']) ) {
                                                echo "/".$product['variant_option_three_value'] ;
                                            }
                                        ?>)
                                        </p></div>
                                    <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega price-wrap" style="display: none;">
                                        <div class="product-price col-lg-5 col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                                            <b>$<span class="price_including_tax">
                                            <?php
                                                $priceAvailable = false;
                                                foreach($pricebooks as $pricebook) {
                                                    if($pricebook['MerchantPriceBook']['outlet_id'] == $user['current_outlet_id']) {
                                                        foreach($pricebook['MerchantPriceBookEntry'] as $entry) {
                                                            if($entry['product_id'] == $key_items[$product['id']]['MerchantProduct']['id'] && $entry['min_units'] == null && $entry['max_units'] == null) {
                                                                echo number_format($entry['price_include_tax'],2,'.','');
                                                                $priceAvailable = true;
                                                                break;
                                                            }
                                                        }
                                                        break;
                                                    }
                                                }
                                                foreach($pricebooks as $pricebook) {
                                                    if($priceAvailable == false) {
                                                        if($pricebook['MerchantPriceBook']['outlet_id'] == $user['current_outlet_id']) {
                                                            foreach($pricebook['MerchantPriceBookEntry'] as $entry){
                                                                if($entry['product_id'] == $key_items[$product['id']]['MerchantProduct']['id'] && $entry['min_units'] == null && $entry['max_units'] == null) {
                                                                    echo number_format($entry['price_include_tax'],2,'.','');
                                                                    $priceAvailable = false;
                                                                    break 2;
                                                                }
                                                            }
                                                        }
                                                        if($pricebook['MerchantPriceBook']['is_default'] == 1) {
                                                            foreach($pricebook['MerchantPriceBookEntry'] as $entry){
                                                                if($entry['product_id'] == $key_items[$product['id']]['MerchantProduct']['id'] && $entry['min_units'] == null && $entry['max_units'] == null) {
                                                                    echo number_format($entry['price_include_tax'],2,'.','');
                                                                    $priceAvailable = false;
                                                                    break;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            ?>
                                            </span></b>
                                        </div>
                                        <?php if ($key_items[$product['id']]['MerchantProduct']['track_inventory'] == 1 && !empty($key_items[$product['id']]['MerchantProductInventory'])) : ?>
                                        <div class="product-stock col-lg-7 col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                                            <small>In Stock: <?php echo $key_items[$product['id']]['MerchantProductInventory'][0]['count'];?></small>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="product-unit-table hidden">
                                    <?php foreach($pricebooks as $pricebook) {
                                        foreach($pricebook['MerchantPriceBookEntry'] as $entry) {
                                            if($entry['product_id'] == $key_items[$product['id']]['MerchantProduct']['id'] && isset($entry['min_units'])) { ?>
                                                <tr class="price-book-row"
                                                 data-id="<?php echo $entry['product_id'];?>"
                                                 group-id="<?php if($pricebook['MerchantPriceBook']['customer_group_id'] == $groups[0]['MerchantCustomerGroup']['id']){
                                                    echo '';
                                                } else {
                                                    echo $pricebook['MerchantPriceBook']['customer_group_id'];
                                                }?>">
                                                    <td class="item_min"><?php echo $entry['min_units'];?></td>
                                                    <td class="item_max"><?php echo $entry['max_units'];?></td>
                                                    <td class="item_price"><?php echo number_format($entry['price_include_tax'],2,'.','');?></td>
                                                </tr>
                                            <?php }
                                        }
                                    }?>
                                </div>
                                <input type="hidden" class="product-retail_price" value="<?=$key_items[$product['id']]['MerchantProduct']['price'];?>">
                                <input type="hidden" class="product-tax" value="<?=$key_items[$product['id']]['MerchantProduct']['tax'];?>">
                                <input type="hidden" class="product-supply_price" value="<?=$key_items[$product['id']]['MerchantProduct']['supply_price'];?>">
                            </div>
                        </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Variable POPUP BOX END -->

    <!-- STATUS POPUP BOX -->
    <div class="confirmation-modal modal fade in" id="status_box" tabindex="-1" role="dialog" aria-hidden="false" style="display:none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Status</h4>
                </div>
                <div class="modal-body">
                    <p>Please wait while your offline data is updated</p>
                </div>
                <div class="modal-footer">
                    <a href="/dashboard">
                        <button class="btn btn-success" type="button" data-dismiss="modal">Go to the Dashboard</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- STATUS POPUP BOX END -->
<!-- END CONTENT -->
</div>
<div class="qty_block">
    <form novalidate class="qty-form">
        <div class="main_panel col-md-12 col-sm-12 col-xs-12 col-alpha col-omega">
            <p class="col-md-12 col-alpha col-omega">Quantity</p>
            <div class="col-md-12 col-sm-12 col-xs-12 col-alpha col-omega">
                <input id="item-qty" class="qty_field numpad_text col-md-10" type="text" name="num" placeholder="">
                <button type="button" class="btn btn-primary col-md-2 show_numpad"><i class="glyphicon glyphicon-th"></i></button>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 col-alpha col-omega numpad" style="display: none;">
                <div id="numpad-main" class="col-md-9 col-sm-9 col-xs-9">
                    <div class="number_button" onclick="qty_write(1);">1</div>
                    <div class="number_button" onclick="qty_write(2);">2</div>
                    <div class="number_button" onclick="qty_write(3);">3</div>
                    <div class="number_button" onclick="qty_write(4);">4</div>
                    <div class="number_button" onclick="qty_write(5);">5</div>
                    <div class="number_button" onclick="qty_write(6);">6</div>
                    <div class="number_button" onclick="qty_write(7);">7</div>
                    <div class="number_button" onclick="qty_write(8);">8</div>
                    <div class="number_button" onclick="qty_write(9);">9</div>
                    <div class="number_button" onclick="qty_write(0);">0</div>
                    <div class="number_button" onclick="qty_write('00');">00</div>
                    <div class="number_button" onclick="qty_write('.');">.</div>
                </div>
                <div id="numpad-sub" class="col-md-3 col-sm-3 col-xs-3">
                    <div class="number_button-gr" onclick="qty_c();">C</div>
                    <div class="number_button-gr" onclick="qty_negative();">+/-</div>
                    <input type="submit" class="number_button-gr num_submit" value="return">
                </div>
            </div>
        </div>
    </form>
</div>
<div class="price_block">
    <form novalidate class="price-form">
        <div class="main_panel col-md-12 col-sm-12 col-xs-12 col-alpha col-omega">
            <div class="col-md-12 col-sm-12 col-xs-12 col-alpha col-omega">
                <input type="button" id="set-discount" class="col-md-6 btn btn-primary btn-left active" value="Discount">
                <input type="button" id="set-unit-price" class="col-md-6 btn btn-primary btn-right" value="Unit Price">
            </div>
            <p id="text-top" class="margin-top-20 col-md-12 col-alpha col-omega">Apply discount percentage</p>
            <div class="col-md-12 col-sm-12 col-xs-12 col-alpha col-omega">
                <input id="item-discount" class="price_field numpad_text col-md-10" type="text" name="num" placeholder="E.g. 20% or 20" pattern="([0-9]{0,}[.]{1}[0-9]{1,}|[0-9]{1,}[.]{0,1}[0-9]{0,})[%]{0,1}">
                <button type="button" class="btn btn-primary col-md-2 show_numpad"><i class="glyphicon glyphicon-th"></i></button>
                <span id="text-bottom">some text</span>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 col-alpha col-omega numpad" style="display: none;">
                <div id="numpad-main" class="col-md-9 col-sm-9 col-xs-9">
                    <div class="number_button" onclick="number_write(1);">1</div>
                    <div class="number_button" onclick="number_write(2);">2</div>
                    <div class="number_button" onclick="number_write(3);">3</div>
                    <div class="number_button" onclick="number_write(4);">4</div>
                    <div class="number_button" onclick="number_write(5);">5</div>
                    <div class="number_button" onclick="number_write(6);">6</div>
                    <div class="number_button" onclick="number_write(7);">7</div>
                    <div class="number_button" onclick="number_write(8);">8</div>
                    <div class="number_button" onclick="number_write(9);">9</div>
                    <div class="number_button" onclick="number_write(0);">0</div>
                    <div class="number_button" onclick="number_write('00');">00</div>
                    <div class="number_button" onclick="number_write('.');">.</div>
                </div>
                <div id="numpad-sub" class="col-md-3 col-sm-3 col-xs-3">
                    <div class="number_button-gr" onclick="number_c();">C</div>
                    <div class="number_button-gr" onclick="number_negative();">+/-</div>
                    <input type="submit" class="number_button-gr num_submit" value="return">
                </div>
            </div>
        </div>
    </form>
</div>
<div class="discount_block">
    <form novalidate class="discount-form">
        <div class="main_panel col-md-12 col-sm-12 col-xs-12 col-alpha col-omega">
            <!--
            <div class="col-md-12 col-sm-12 col-xs-12 col-alpha col-omega numpad" style="display: none;">
                <div id="numpad-main" class="col-md-9 col-sm-9 col-xs-9">
                    <div class="number_button" onclick="number_write(1);">1</div>
                    <div class="number_button" onclick="number_write(2);">2</div>
                    <div class="number_button" onclick="number_write(3);">3</div>
                    <div class="number_button" onclick="number_write(4);">4</div>
                    <div class="number_button" onclick="number_write(5);">5</div>
                    <div class="number_button" onclick="number_write(6);">6</div>
                    <div class="number_button" onclick="number_write(7);">7</div>
                    <div class="number_button" onclick="number_write(8);">8</div>
                    <div class="number_button" onclick="number_write(9);">9</div>
                    <div class="number_button" onclick="number_write(0);">0</div>
                    <div class="number_button" onclick="number_write('00');">00</div>
                    <div class="number_button" onclick="number_write('.');">.</div>
                </div>
                <div id="numpad-sub" class="col-md-3 col-sm-3 col-xs-3">
                    <div class="number_button-gr" onclick="number_c();">C</div>
                    <div class="number_button-gr" onclick="number_negative();">+/-</div>
                    <input type="submit" class="number_button-gr num_submit" value="return">
                </div>
            </div>
            -->
            <div class="col-md-12 col-sm-12 col-xs-12 col-alpha col-omega margin-bottom-10">
                <input type="button" id="set-discount-all" class="col-md-6 btn btn-primary btn-left active" value="Percentage">
                <input type="button" id="set-unit-price-all" class="col-md-6 btn btn-primary btn-right" value="Amount">
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 col-alpha col-omega">
                <input id="item-discount" class="discount_field numpad_text col-md-10" type="text" name="num" placeholder="E.g. 20% or 20">
                <button type="button" class="btn btn-primary col-md-2 show_numpad" disabled><i class="glyphicon glyphicon-th"></i></button>
            </div>
        </div>
    </form>
</div>
<div class="modal-backdrop fade in" style="display:<?php if (empty($user['MerchantRegister'])) { echo "block"; } else { echo "none"; }; ?>"></div>
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
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/theme/onzsa/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="/js/jquery.jqprint-0.3.js" type="text/javascript"></script>
<script src="/js/dataTable.js" type="text/javascript"></script>
<script src="/js/dpsclient.js" type="text/javascript"></script>
<script src="/js/jxon.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function () {
    Metronic.init(); // init metronic core componets
    //Layout.init(); // init layout
    /**
     *    Retrieve Sale
     **/

    $("#retrieveTable").DataTable({
        searching: false
    });
    $("#retrieveTable_length").hide();

    $(document).on("click", ".current_open", function () {
        $(".tab-menu-wrapper").find(".active").removeClass("active");
        $(".current_open").addClass("active");
        $("#retrieve-sale").addClass("hidden");
        $("#sell-index").removeClass("hidden");
    });

    $(document).on("click", ".retrieve_open", function () {
        $(".tab-menu-wrapper").find(".active").removeClass("active");
        $(".retrieve_open").addClass("active");
        $("#retrieve-sale").removeClass("hidden");
        $("#sell-index").addClass("hidden");
    });

    $(document).on('click', ".retrieve_sale", function () {
        var customer_name = $(this).attr("data-customer-name");
        var customer_id = $(this).attr("data-customer-id");
        var customer_balance = parseFloat($(this).attr("data-customer-balance")).toFixed(2);
        var retrieve_sale_id = $(this).attr("data-id");
        var customer_group_id = $(this).attr("data-group-id");
        $("#retrieve-sale").addClass("hidden");
        $("#sell-index").removeClass("hidden");
        if ($(".order-product").length !== 0) {
            var targetSale = $(this);
            if ($("#retrieve_sale_id").val() == $(this).attr('data-id')) {
                $("#retrieve-sale").addClass("hidden");
                $("#sell-index").removeClass("hidden");
            } else {
                $(".retrieve-popup").show();
                $(".modal-backdrop").show();
                $("#current_order_count").text($(".order-product").length);
                $("#retrieve_order_count").text($(this).attr("data-count"));
                $(document).on("click", ".retrieve-a", function () {
                    $(".added-null").hide();
                    $(".order-product").remove();
                    $(".order-discount").remove();
                    var retCount = 0;
                    $("#retrieve_sale_id").val(retrieve_sale_id);
                    targetSale.find(".retrieve-child-products").each(function () {
                        var comp_1 = $(this).children(".retrieve-child-price").text();
                        var comp_2 = $(this).children(".retrieve-child-tax").text();
                        var price_including_tax = parseFloat(comp_1) + parseFloat(comp_2);
                        var appendString = '';
                        appendString += '<tr class="order-product">';
                        appendString += '<input type="hidden" class="added-code" value="' + $(this).children(".retrieve-child-id").text() + '">';
                        appendString += '<input type="hidden" class="added-name" value="' + $(this).children(".retrieve-child-name").text() + '">';
                        appendString += '<td class="added-product">' + $(this).children(".retrieve-child-name").text();
                        appendString += '<br><span class="added-price">$' + parseFloat($(this).children(".retrieve-child-price").text()).toFixed(2) + '</span></td>';
                        appendString += '<td class="added-qty"><a qty-id="' + retCount + '" class="qty-control btn btn-white">';
                        appendString += $(this).find(".retrieve-child-qty").text() + '</a></td>';
                        appendString += '<td class="added-discount"><a href="#price-control" class="price-control btn btn-white" data-id="' + retCount + '">@';
                        appendString += price_including_tax.toFixed(2) + '</a></td><td class="added-amount"></td>';
                        appendString += '<td class="added-remove"><div class="remove clickable"><div class="glyphicon glyphicon-remove"></div></div></td></tr>';

                        $(".added-body").prepend(appendString);
                        //$(".added-body").prepend('<tr class="order-product"><input type="hidden" class="added-code" value="'+$(this).children(".retrieve-child-id").text()+'"><td class="added-product">'+$(this).children(".retrieve-child-name").text()+'<br><span class="added-price">$'+parseFloat($(this).children(".retrieve-child-price").text()).toFixed(2)+'</span></td><td class="added-qty"><a qty-id="'+retCount+'" class="qty-control btn btn-white">'+$(this).find(".retrieve-child-qty").text()+'</a></td><td class="added-discount"><a href="#price-control" class="price-control btn btn-white" data-id="'+retCount+'">@'+price_including_tax.toFixed(2)+'</a></td><td class="added-amount"></td><td class="added-remove"><div class="remove clickable"><div class="glyphicon glyphicon-remove"></div></div></td></tr>');
                        retCount++;
                    });
                    targetSale.find(".retrieve-child-payments").each(function () {
                        $('<ul class="split_attr"><li>' + $(this).find(".payments-name").val() + '</li><li class="pull-right">$' + $(this).find(".payments-amount").val() + '</li></ul>').insertBefore(".total_cost");
                    });
                    if (customer_name == '') {

                    } else {
                        $("#customer-result-name").text(customer_name);
                        $("#customer-selected-id").val(customer_id);
                        $("#customer-result-balance").text(customer_balance);
                        $("#customer-selected-group-id").val(customer_group_id);
                        $(".customer-search-result").children("dl").show();
                    }
                });
            }
        } else {
            var targetSale = $(this);
            $(".added-null").hide();
            var retCount = 0;
            $("#retrieve_sale_id").val($(this).attr("data-id"));
            $(this).find(".retrieve-child-products").each(function () {
                var appendString = '';
                appendString += '<tr class="order-product">';
                appendString += '<input type="hidden" class="added-code" value="' + $(this).children(".retrieve-child-id").text() + '">';
                appendString += '<input type="hidden" class="added-name" value="' + $(this).children(".retrieve-child-name").text() + '">';
                appendString += '<input type="hidden" class="hidden-retail_price" value="' + $(this).find(".retrieve-child-price").text() + '">';
                appendString += '<input type="hidden" class="hidden-tax" value="' + $(this).find(".retrieve-child-tax").text() + '">';
                appendString += '<input type="hidden" class="hidden-supply_price" value="' + $(this).find(".retrieve-child-supply-price").text() + '">';
                appendString += '<td class="added-product">' + $(this).children(".retrieve-child-name").text();
                appendString += '<br><span class="added-price">$' + parseFloat($(this).children(".retrieve-child-price").text()).toFixed(2) + '</span></td>';
                appendString += '<td class="added-qty"><a qty-id="' + retCount + '" class="qty-control btn btn-white">' + $(this).find(".retrieve-child-qty").text() + '</a></td>';
                appendString += '<td class="added-discount"><a href="#price-control" class="price-control btn btn-white" data-id="' + retCount + '">@';
                appendString += $(this).find(".retrieve-child-price-incl-tax").text() + '</a></td>';
                appendString += '<td class="added-amount"></td><td class="added-remove"><div class="remove clickable"><div class="glyphicon glyphicon-remove"></div></div></td></tr>'; /*COME HERE*/

                $(".added-body").prepend(appendString);
                //$(".added-body").prepend('<tr class="order-product"><input type="hidden" class="added-code" value="'+$(this).children(".retrieve-child-id").text()+'"><input type="hidden" class="hidden-retail_price" value="'+$(this).find(".retrieve-child-price").text()+'"><input type="hidden" class="hidden-tax" value="'+$(this).find(".retrieve-child-tax").text()+'"><input type="hidden" class="hidden-supply_price" value="'+$(this).find(".retrieve-child-supply-price").text()+'"><td class="added-product">'+$(this).children(".retrieve-child-name").text()+'<br><span class="added-price">$'+parseFloat($(this).children(".retrieve-child-price").text()).toFixed(2)+'</span></td><td class="added-qty"><a qty-id="'+retCount+'" class="qty-control btn btn-white">'+$(this).find(".retrieve-child-qty").text()+'</a></td><td class="added-discount"><a href="#price-control" class="price-control btn btn-white" data-id="'+retCount+'">@'+$(this).find(".retrieve-child-price-incl-tax").text()+'</a></td><td class="added-amount"></td><td class="added-remove"><div class="remove clickable"><div class="glyphicon glyphicon-remove"></div></div></td></tr>');/*COME HERE*/
                retCount++;
            });
            targetSale.find(".retrieve-child-payments").each(function () {
                $('<ul class="split_attr"><li>' + $(this).find(".payments-name").val() + '</li><li class="pull-right">$' + $(this).find(".payments-amount").val() + '</li></ul>').insertBefore(".total_cost");
            });
            if (customer_name == '') {

            } else {
                $("#customer-result-name").text(customer_name);
                $("#customer-selected-id").val(customer_id);
                $("#customer-result-balance").text(customer_balance);
                $("#customer-selected-group-id").val(customer_group_id);
                $(".customer-search-result").children("dl").show();
            }
        }
    });


    /**
     *    Popup Control From Here
     **/

    $(".customer_quick_add").click(function () {
        $(".customer_add").show();
        $(".modal-backdrop").show();
    });
    $(".close-popup").click(function () {
        $(".receipt-parent").hide();
        $(".fade").hide();
        $(".split_receipt_attr").remove();
    });
    var to_pay;
    $("#pay").click(function () {
        if ($(".added-null").is(':visible')) {

        } else {
            $(".pay").show();
            $(".modal-backdrop").show();
            $("#set-pay-amount").val($(".toPay").text());
            to_pay = $(".toPay").text();
            if ($(".split_attr").length > 0) {
                current_amount = to_pay;
                $(".split_attr").each(function () {
                    current_amount = current_amount - $(this).find(".pull-right").text().split("$")[1];
                    to_pay = to_pay - $(this).find(".pull-right").text().split("$")[1];
                })
                $("#set-pay-amount").val(current_amount.toFixed(2));
                $(".payment-display").find(".total_cost").children(".pull-right").text('$' + current_amount.toFixed(2));
            } else {
                $(".payment-display").find(".total_cost").children(".pull-right").text('$' + $(".toPay").text());
            }
            payments = [];
        }
    });
    $("#park").click(function () {
        if ($(".added-null").is(':visible')) {

        } else {
            $(".park").show();
            $(".modal-backdrop").show();
        }
    });
    $(".void").click(function () {
        if ($(".added-null").is(':visible')) {

        } else {
            $(".void").show();
            $(".modal-backdrop").show();
        }
    })
    $(".confirm-close").click(function () {
        $(".fade").hide();
    });
    $(document).on('click', '.cancel', function () {
        $('.fade').hide();
    });
    $(".register-cancel").click(function () {
        window.location.href = "/dashboard";
    });


    /**
     *    Dynamic Control From Here
     **/

    // DYNAMIC PROUCT SEARCH
    var found_count = 0;
    var found_page = 1;
    $(document).on("keyup", "#product_search", function () {
        found_count = 0;
        found_page = 1;
        var val = $.trim(this.value).toUpperCase();
        if (val == "") {
            $(".quick-key-item").hide();
            $("li[page="+$(".selected").text()+"][group="+$(".nav-tabs").find(".active").attr("position")+"]").show();
            $(".quick-key-list").show();
            $(".product-found-list").hide();
        } else {
            $(".quick-key-item").removeClass('search_target');
            $(".product-name").filter(function () {
                return -1 != $(this).text().toUpperCase().indexOf(val);
            }).parent().parent().parent().addClass('search_target').show();

            $(".product-found-list").find('ul').html('');
            $(".search_target").each(function () {
                found_count++;
                if (found_count == 10) {
                    found_page++;
                    found_count = 0;
                    $(".product-found-list").find('ul').append($(this).clone().attr("page", found_page));
                } else {
                    $(".product-found-list").find('ul').append($(this).clone().attr("page", found_page));
                }
            });
            $(".quick-key-list").hide();
            $(".product-found-list").show();
        }
    });

    // DYNAMIC CUSTOMER SEARCH

    var $cells = $(".data-found");
    $(".search_result").hide();

    $(document).on("keyup", "#customer_search", function () {
        var val = $.trim(this.value).toUpperCase();
        if (val === "")
            $(".search_result").hide();
        else {
            $cells.hide();
            $(".search_result").show();
            $(".search-default").hide();
            $cells.filter(function () {
                return -1 != $(this).text().toUpperCase().indexOf(val);
            }).show();
            if ($(".search_result").height() <= 20) {
                $(".search-default").show();
            }
        }
        $cells.click(function () {
            $("#search").val($(this).text());
        });
    });


    /**
     *Transaction Control From Here
     **/

    var total_discount = 0;
    var total_cost = 0;

    function clear_sale() {
        $(".customer-search-result").children().hide();
        $("#customer-result-name").text('');
        $("#customer-selected-id").val($("#customer-null").val());
        $(".order-product").remove();
        $(".order-discount").remove();
        $(".added-null").show();
        $(".split_attr").remove();
    }

    function print_receipt(payment_name, paying) {
        var now = new Date(Date.now());

        $(".invoice-date").text($.datepicker.formatDate('yy/mm/dd', new Date()) + ' ' + now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds());
        $(".fade").hide();
        $(".receipt-product-table").children("tbody").text('');
        $(".order-product").each(function () {
            $(".receipt-product-table").children("tbody").append('<tr><td class="receipt-product-qty">' + $(this).children(".added-qty").children("a").text() + '</td><td class="receipt-product-name">' + $(this).children(".added-product").text().split("$")[0] + '</td><td class="receipt-price pull-right">$' + $(this).children(".added-amount").text() + '</td></tr>');
        });
        $(".order-discount").each(function () {
            $(".receipt-product-table").children("tbody").append('<tr><td class="receipt-product-qty"></td><td class="receipt-product-name">Discount</td><td class="receipt-price pull-right">- $' + $(this).find(".amount").text() + '</td></tr>');
        });
        $('<tr class="split_receipt_attr"><td>' + payment_name + '</td><td class="pull-right">$' + paying + '</td></tr>').insertBefore('.receipt_total');
        $(".receipt-customer-name").text($("#customer-result-name").text());
        $(".receipt-subtotal").text('$' + $(".subTotal").text());
        $(".receipt-tax").text('$' + $(".gst").text());
        $(".receipt-total").text('$' + $(".toPay").text());

        $(".receipt-parent").show('blind');
        $(".modal-backdrop").show();
    }

    function save_line_order() {
        var sequence = 0;
        line_array = [];

        $(".order-product").each(function () {
            var pId = $(this).children(".added-code").val();
            var pName = $(this).children(".added-name").val();
            var pQty = $(this).children(".added-qty").children("a").text();
            var pAmount = $(this).children(".added-amount").text();
            var pSupplyPrice = $(this).children(".hidden-supply_price").val() * pQty;
            var pPrice = $(this).children(".hidden-retail_price").val() * pQty;
            var pTax = $(this).children(".hidden-tax").val() * pQty;
            var pDiscount = $(this).find(".added-price").text().split("$")[1] * pQty - pAmount;

            var line_order = {
                'product_id': pId,
                'name': pName,
                'quantity': pQty,
                'price': pPrice,
                'supply_price': pSupplyPrice,
                'tax': pTax,
                'price_include_tax': pAmount,
                'sequence': sequence,
                'discount': pDiscount,
                'status': 'sale_item_status_valid'
            }

            line_array.push(line_order);
            sequence++;
            total_discount += pDiscount;
            total_cost += pSupplyPrice;
        });

        $(".order-discount").each(function () {
            total_discount += parseFloat($(this).find(".amount").text());
        });
    }

    var sale_id;
    var invoice_sequence = $(".invoice-id").text();

    function save_register_sale(amount) {
        if ($("#retrieve_sale_id").val() !== '') {
            save_line_order();

            line_array = JSON.stringify(line_array);
            $.ajax({
                url: "/home/pay.json",
                type: "POST",
                data: {
                    sale_id: $("#retrieve_sale_id").val(),
                    customer_id: $("#customer-selected-id").val(),
                    total_price: $(".subTotal").text(),
                    total_price_incl_tax: $(".toPay").text(),
                    total_discount: total_discount,
                    total_cost: total_cost,
                    total_tax: $(".gst").text(),
                    note: '',
                    merchant_payment_type_id: payment_id,
                    items: line_array,
                    amount: JSON.stringify(amount)
                },
                success: function (result) {
                    if (result.success) {
                        $("#retrieve_sale_id").val('');
                    } else {
                        console.log(result);
                    }
                }
            });
        } else {
            save_line_order();

            line_array = JSON.stringify(line_array);
            $.ajax({
                url: "/home/pay.json",
                type: "POST",
                data: {
                    customer_id: $("#customer-selected-id").val(),
                    receipt_number: invoice_sequence,
                    total_price: $(".subTotal").text(),
                    total_price_incl_tax: $(".toPay").text(),
                    total_discount: total_discount,
                    total_cost: total_cost,
                    total_tax: $(".gst").text(),
                    note: '',
                    merchant_payment_type_id: payment_id,
                    items: line_array,
                    amount: JSON.stringify(amount)
                },
                success: function (result) {
                    $(".invoice-id").text(invoice_sequence);
                    invoice_sequence++;
                }
            });
        }
    }

    function park_register_sale(status, amount, pays) {
        if ($("#retrieve_sale_id").val() !== '') {
            save_line_order();

            line_array = JSON.stringify(line_array);
            $.ajax({
                url: "/home/park.json",
                type: "POST",
                data: {
                    sale_id: $("#retrieve_sale_id").val(),
                    customer_id: $("#customer-selected-id").val(),
                    total_price: $(".subTotal").text(),
                    total_price_incl_tax: $(".toPay").text(),
                    total_discount: '',
                    total_tax: $(".gst").text(),
                    note: $("#leave_note").val(),
                    status: status,
                    items: line_array,
                    actual_amount: amount,
                    payments: JSON.stringify(pays)
                },
                success: function (result) {
                    if (result.success) {
                        $("#retrieve_sale_id").val('');
                    } else {
                        alert(result.message);
                    }
                }
            });
        } else {
            save_line_order();

            line_array = JSON.stringify(line_array);
            $.ajax({
                url: "/home/park.json",
                type: "POST",
                data: {
                    customer_id: $("#customer-selected-id").val(),
                    receipt_number: invoice_sequence,
                    total_price: $(".subTotal").text(),
                    total_price_incl_tax: $(".toPay").text(),
                    total_discount: '',
                    total_tax: $(".gst").text(),
                    note: $("#leave_note").val(),
                    status: status,
                    items: line_array,
                    actual_amount: amount,
                    payments: JSON.stringify(pays)
                },
                success: function (result) {
                    if (result.success) {
                        invoice_sequence++;
                    } else {
                        console.log(result);
                    }
                }
            });
        }
        clear_sale();
    }

    var payments = {};
    // Pay
    $(document).on("click", ".payment_method", function () {
        payment_id = $(this).attr("payment-id");
        payment_name = $(this).find("p").text();
        var payment_type_id = parseInt($(this).attr("payment-type-id"));
        var payment_type = $(this).attr("payment-type");
        paying = parseFloat($("#set-pay-amount").val()).toFixed(2);
        // case payment_type_id eq 5 or payment_type eq 'Integrated EFTPOS (DPS)'
        if (5 == payment_type_id || 'Integrated EFTPOS (DPS)' == payment_type) {
            var dpsClient = new DpsClient();

            dpsClient.connect(function (connected, error) {
                if (connected) {
                    dpsClient.payment('TXN12345', paying, function (data, error) {
                        console.log('Call callback:');
                        console.log(data);
                        if (data.responsetext == "ACCEPTED" || data.responsetext == "SIG ACCEPTED") {

                            payments.push([payment_id, paying]);

                            if (parseFloat(to_pay).toFixed(2) == parseFloat(paying).toFixed(2)) {
                                save_register_sale(payments);
                                print_receipt(payment_name, paying);
                                clear_sale();
                            } else {
                                to_pay = to_pay - paying;
                                $(".pay").show();
                                $(".modal-backdrop").show();
                                $("#set-pay-amount").val(to_pay.toFixed(2));
                                $(".payment-display").children("li").prepend('<ul class="split_attr"><li>' + payment_name + '</li><li class="pull-right">$' + paying + '</li></ul>');
                                $(".payment-display").find(".total_cost").children(".pull-right").text('$' + to_pay.toFixed(2));
                                $('<tr class="split_receipt_attr"><td>' + payment_name + '</td><td class="pull-right">$' + paying + '</td></tr>').insertBefore('.receipt_total');
                            }
                        }
                    });
                } else {
                }
            });

            return;
        }

        payments.push([payment_id, paying]);

        if (parseFloat(to_pay).toFixed(2) == parseFloat(paying).toFixed(2)) {
            save_register_sale(payments);

            print_receipt(payment_name, paying);

            clear_sale();
        } else {
            to_pay = to_pay - paying;
            $("#set-pay-amount").val(to_pay.toFixed(2));
            $(".payment-display").children("li").prepend('<ul class="split_attr"><li>' + payment_name + '</li><li class="pull-right">$' + paying + '</li></ul>');
            $(".payment-display").find(".total_cost").children(".pull-right").text('$' + to_pay.toFixed(2));
            $('<tr class="split_receipt_attr"><td>' + payment_name + '</td><td class="pull-right">$' + paying + '</td></tr>').insertBefore('.receipt_total');
        }
    });

    // Park
    $(document).on("click", ".park-sale", function () {
        park_register_sale('sale_status_saved', 0, 0);
        $(".fade").hide();
        clear_sale();
    });

    // Layby
    $(document).on("click", ".layby-sale", function () {
        if ($("#customer-result-name").text() == "") {
            alert("Customer not selected");
        } else {
            park_register_sale('sale_status_layby', $("#set-pay-amount").val(), payments);
            clear_sale();
        }
        $(".fade").hide();
    });

    // Onaccount
    $(document).on("click", ".onaccount-sale", function () {

        if ($("#customer-result-name").text() == "") {
            alert("Customer not selected");
        } else {
            park_register_sale('sale_status_onaccount', $("#set-pay-amount").val(), payments);
            clear_sale();
        }

        $(".fade").hide();
    });

    // Void
    $(document).on("click", ".void-sale", function () {
        park_register_sale('sale_status_voided', $("#set-pay-amount").val(), payments);
        $(".fade").hide();
        clear_sale();
    });

    /**
     *Customer add & apply
     **/

    $(document).on("click", ".add_customer-submit", function () {
        $.ajax({
            url: '/customer/customer_quick_add.json',
            type: 'POST',
            data: {
                first_name: $("#add_customer-first").val(),
                last_name: $("#add_customer-last").val(),
                birthday: $("#add_customer-yyyy").val() + '-' + $("#add_customer-mm").val() + '-' + $("#add_customer-dd").val(),
                dob: $("#add_customer-yyyy").val() + '-' + $("#add_customer-mm").val() + '-' + $("#add_customer-dd").val(),
                customer_code: $("#add_customer-code").val(),
                phone: $("#add_customer-phone").val(),
                mobile: $("#add_customer-phone").val(),
                email: $("#add_customer-email").val(),
                physical_address_1: $("#add_customer-address1").val(),
                physical_address_2: $("#add_customer-address2").val(),
                physical_suburb: $("#add_customer_suburb").val(),
                physical_city: $("#add_customer-city").val(),
                physical_state: $("#add_customer-state").val(),
                physical_postcode: $("#add_customer-postcode").val(),
                physical_country: $("#add_customer-country").val(),
                customer_group_id: $("#add_customer-group").val(),
                customer_code: $("#add_customer-code").val(),
                name: $("#add_customer-first").val() + ' ' + $("#add_customer-last").val(),
                gender: 'M',
            }
        }).done(function (result) {
            $("#customer-selected-id").val(result['id']);
            $("#customer-result-name").text(result['data']['name']);
            $("#customer-result-balance").text('$0.00');
            $(".customer-search-result").children("dl").show();
            $(".modal-backdrop").hide();
            $(".customer_add").hide();
        });
    });

    $(".customer_apply").click(function () {
        $("#customer_search").val('');
        $(".search_result").hide();
        $(".customer-search-result").children("dl").show();

        $("#customer-result-name").text($(this).attr("data-name"));
        $("#customer-result-balance").text('$' + parseFloat($(this).attr("data-balance")).toFixed(2));
        $("#customer-selected-id").val($(this).attr("data-id"));
        $("#customer-selected-group-id").val($(this).attr("data-group-id"));
        assign_pricebook();
    });

    $(".print").click(function () {
        $(this).hide();
        $("#receipt").jqprint();
        $(this).show();
    });

    $(".register-set").click(function () {
        var register_id = $(this).attr("register-id");
        $.ajax({
            url: "/home/select_register.json",
            type: "POST",
            data: {
                register_id: register_id
            }
        });
        location.reload();
    });

    $("#image-view-c").click(function() {
        $("#block-right").find(".quick-key-item").addClass("middle-view");
        $("#button-view-c").removeClass("active");
	$("#block-right").find(".product-info").hide();
        $(this).addClass("active");
    });

    $("#button-view-c").click(function() {
        $("#block-right").find(".quick-key-item").removeClass("middle-view");
        $("#image-view-c").removeClass("active");
	$("#block-right").find(".product-info").hide();
        $(this).addClass("active");
    });

/*
    $(document).on("click", "#button-view-c", function () {
        $(this).addClass("active");
        $("#image-view-c").removeClass("active");
        $(".quick-key-item").attr("class", "col-md-3 col-md-4 col-sm-4 col-xs-6 product clickable col-alpha col-omega button-view");
        $(".product-container").addClass("no-border");
        $(".product-container").addClass("no-margin");
        $(".product-container").addClass("full-width");
        $(".product-info").addClass("no-border");
        $(".product-info").addClass("no-padding");
        $(".product-info").addClass("auto-height");
        $(".product-img").addClass("hidden");
        $(".product-name").addClass("word-break");
        $(".product-name").addClass("vertical-padding-8");
        $(".price-wrap").addClass("hidden");

        var productList = 1;
        var productTotal = 1;
        var pageNav = 1;
        $(".quick-key-item").each(function () {
            if (productList <= 32) {
                $(this).attr("page", pageNav);
            }
            if (productList == 32) {
                productList = 0;
                pageNav++;
            }
            productList++;
            productTotal++;
        });
        $(".quick-key-item").hide();
        $("div[page=1]").show();
        $(".page").removeClass("selected");
        var productPage = 1;
        $(".page").each(function () {
            if (productPage == 1) {
                $(this).addClass("selected");
            }
            if (productPage > Math.ceil(productTotal / 32)) {
                $(this).hide();
            }
            productPage++;
        });
    });

    $(document).on("click", "#image-view-c", function () {
        $(this).addClass("active");
        $("#button-view-c").removeClass("active");
        $(".quick-key-item").attr("class", "col-md-4 col-sm-4 col-xs-4 product clickable col-alpha col-omega");
        $(".product-container").removeClass("no-border");
        $(".product-container").removeClass("no-margin");
        $(".product-container").removeClass("full-width");
        $(".product-info").removeClass("no-border");
        $(".product-info").removeClass("no-padding");
        $(".product-info").removeClass("auto-height");
        $(".product-img").removeClass("hidden");
        $(".product-name").removeClass("word-break");
        $(".product-name").removeClass("vertical-padding-8");
        $(".price-wrap").removeClass("hidden");

        for (var j = 1; j <= Math.ceil($(".quick-key-item").length / 6); j++) {
            var i = 1;
            $("div[page=" + j + "]").each(function () {
                if (i >= 7) {
                    $(this).attr("page", j + 1).hide();
                }
                i++;
            });
        }

        $(".page").removeClass("selected");
        var p = 0;
        $(".page").each(function () {
            if (p == 0)
                $(this).addClass("selected");

            p++;
        });
        $(".page").show();
        $("div[page=1]").show();
    });
*/
});
</script>
<!-- END JAVASCRIPTS -->
<script type="text/javascript" src="/js/jquery.confirm.js"></script>
<script type="text/javascript" src="/js/jquery.fullscreen.min.js"></script>
<script src="/js/jquery.plugin.js"></script>
<script src="/js/jquery.calculator.js"></script>
<script>
$(document).ready(function () {

    $("#change_register").click(function () {
        $("#register_box").show();
        $(".modal-backdrop").show();
    });

    /* FULL SCREEN MODE START */
    $(".maxi").click(function () {
        $("body").fullscreen();
        $(".maxi").hide();
        $(".mini").show();
        return false;
    });
    $(".mini").click(function () {
        $.fullscreen.exit();
        return false;
    });
    $(document).bind('fscreenchange', function (e, state, elem) {
        if (!$.fullscreen.isFullScreen()) {
            $(".maxi").show();
            $(".mini").hide();
        }
    });
    /* FULL SCREEN MODE END */
    /* MENU TAB START */
    $(".specials").click(function () {
        $(this).addClass("active");
        $(".ordered").removeClass("active");
        $(".results").removeClass("active");
        $("#specials").show();
        $("#frequently_ordered").hide();
        $("#search_results").hide();
    });
    $(".ordered").click(function () {
        $(this).addClass("active");
        $(".specials").removeClass("active");
        $(".results").removeClass("active");
        $("#specials").hide();
        $("#frequently_ordered").show();
        $("#search_results").hide();
    });
    $(".results").click(function () {
        $(this).addClass("active");
        $(".specials").removeClass("active");
        $(".ordered").removeClass("active");
        $("#specials").hide();
        $("#frequently_ordered").hide();
        $("#search_results").show();
    });
    /* MENU TAB END */
    /*
     var mq = window.matchMedia('all and (max-width: 1028px)');
     if(mq.matches) {
     } else {
     window.addEventListener('resize', handleWindowResize);
     handleWindowResize();
     }
     */
});

function handleWindowResize() {
    var height = $(window).height() - $(".page-header").height() - $("#footer").height() - 200;
    var table = height - $(".commands").height() - $(".page-header").height() - $("#footer").height();
    var productTable = height - $(".commands").height() - $(".page-header").height() - $("#footer").height() + 90;
    var mq = window.matchMedia("(min-width: 1280px)");
    if (mq.matches) {
        productTable = productTable + 50;
    }
    $("#block-right").css({
        "height": height + 11
    });
    $("#block-left").css({
        "height": height
    });
    $("#block-left").find(".scroller").css({
        "height": table
    });
    $("#block-left").find(".slimScrollDiv").css({
        "height": table
    });
    $("#block-right").find(".scroller").css({
        "height": productTable
    });
    $("#block-right").find(".slimScrollDiv").css({
        "height": productTable
    });
}

/** CALCULATION START **/
$(document).on("click", function () {
    priceCalculator();
});

$(document).on("keyup", function () {
    priceCalculator();
});

$(document).mouseup(function (e) {
    var container = $(".price_block");
    var container_2 = $(".qty_block");
    var container_3 = $(".discount_block");

    if (container.is(':visible') && !container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
        container.hide();
    }
    if (container_2.is(':visible') && !container_2.is(e.target) // if the target of the click isn't the container...
        && container_2.has(e.target).length === 0) {
        container_2.hide();
    }
    if (container_3.is(':visible') && !container_3.is(e.target) // if the target of the click isn't the container...
        && container_3.has(e.target).length === 0) {
        container_3.hide();
    }
});

function priceCalculator() {
    var setPriceS;
    var qtyS;
    var linePriceS = 0;
    var totalTax = 0;
    var totalSub = 0;
    var toPay = 0;

    $(".order-product").each(function () {
        var setPrice = $(this).children(".added-discount").text();
        var qty = $(this).children(".added-qty").children($(".qty-control")).text();
        var linePrice = qty * $(this).children(".hidden-retail_price").val();
        var lineTax = qty * $(this).children(".hidden-tax").val();
        var setPrice = $(this).children('.added-discount').children('.price-control').text().slice(1);
        totalTax += qty * $(this).children(".hidden-tax").val();
        totalSub += qty * $(this).children(".hidden-retail_price").val();
        linePriceS += linePrice + lineTax;

        $(this).children(".added-amount").text((setPrice * qty).toFixed(2));

        toPay += setPrice * qty;
    });

    if ($(".order-discount").length > 0) {
        $(".order-discount").each(function () {
            toPay -= parseFloat($(this).find('.amount').text());
        });
    }

    $(".gst").text(parseFloat(toPay - toPay / 1.15).toFixed(2));
    $(".total").text(parseFloat(toPay).toFixed(2));
    $(".toPay").text(parseFloat(toPay).toFixed(2));
    $(".subTotal").text(parseFloat($(".total").text() - $(".gst").text()).toFixed(2));
}

/** CALCULATION END **/
</script>
<script src="js/jquery.keypad.js"></script>
<script>
var listCount = 0;
$(document).on('click', '.quick-key-item', function () {
    if ($(this).attr("data-symbol") !== '') {
        var symbol = '/' + $(this).attr("data-symbol");
    } else {
        var symbol = "";
    }

    if($(this).attr("variable") == 1) {
        var parent_id = $(this).attr('data-id');
        $("#variable_box").show();
        $("#variable_box").find("li").hide();
        $("#variable_box").find("li[parent-id="+ parent_id +"]").show();
    } else {
        var appendString = '';
        appendString += '<tr class="order-product">';
        appendString += '<input type="hidden" class="added-code" value="' + $(this).attr("data-id") + '">';
        appendString += '<input type="hidden" class="added-name" value="' + $(this).children().children(".product-name").val() + '">';
        appendString += '<input type="hidden" class="hidden-retail_price" value="' + $(this).children().children(".product-retail_price").val() + '">';
        appendString += '<input type="hidden" class="hidden-tax" value="' + $(this).children().children(".product-tax").val() + '">';
        appendString += '<input type="hidden" class="hidden-supply_price" value="' + $(this).children().children(".product-supply_price").val() + '">';
        appendString += '<td class="added-product">' + $(this).children(".product-container").children(".product-info").children(".product-name").text();
        appendString += '<br><span class="added-price">$' + $(this).children(".product-container").children(".product-info").children(".price-wrap").children(".product-price").children("b").children(".price_including_tax").text();
        appendString += '</span>' + symbol + '</td>';
        appendString += '<td class="added-qty"><a qty-id="' + listCount + '" class="qty-control btn btn-white">1</a></td>';
        appendString += '<td class="added-discount"><a href="#price-control" class="price-control btn btn-white" data-id="' + listCount + '">@';
        appendString += $(this).children(".product-container").children(".product-info").children(".price-wrap").children(".product-price").children("b").children(".price_including_tax").text();
        appendString += '</a></td><td class="added-amount" style="text-align:right;">' + $(this).children(".product-container").children(".product-info").children(".price-wrap").children(".product-price").children("b").children(".price_including_tax").text();
        appendString += '</td><td class="added-remove"><div class="remove clickable"><div class="glyphicon glyphicon-remove"></div></div></td></tr>';
        $(".added-body").prepend(appendString);
        //$(".added-body").prepend('<tr class="order-product"><input type="hidden" class="added-code" value="'+$(this).attr("data-id")+'"><input type="hidden" class="hidden-retail_price" value="'+$(this).children().children(".product-retail_price").val()+'"><input type="hidden" class="hidden-tax" value="'+$(this).children().children(".product-tax").val()+'"><input type="hidden" class="hidden-supply_price" value="'+$(this).children().children(".product-supply_price").val()+'"><td class="added-product">'+$(this).children(".product-container").children(".product-info").children(".product-name").text()+'<br><span class="added-price">$'+$(this).children(".product-container").children(".product-info").children(".price-wrap").children(".product-price").children("b").children(".price_including_tax").text()+'</span>'+symbol+'</td><td class="added-qty"><a qty-id="'+listCount+'" class="qty-control btn btn-white">1</a></td><td class="added-discount"><a href="#price-control" class="price-control btn btn-white" data-id="'+listCount+'">@'+$(this).children(".product-container").children(".product-info").children(".price-wrap").children(".product-price").children("b").children(".price_including_tax").text()+'</a></td><td class="added-amount" style="text-align:right;">'+$(this).children(".product-container").children(".product-info").children(".price-wrap").children(".product-price").children("b").children(".price_including_tax").text()+'</td><td class="added-remove"><div class="remove clickable"><div class="glyphicon glyphicon-remove"></div></div></td></tr>');
        listCount++;
        $(".added-null").hide();
        $("#variable_box").hide();
        $("#variable_box").find("li[parent-id="+ parent_id +"]").hide();
    }

    if ($(this).attr("data-uom") == "Weight") {
        //Call function here
    }
});

$(document).on('click', '.page', function () {
    $(".page").addClass("clickable");
    $(".page").removeClass("selected");
    $(this).removeClass("clickable");
    $(this).addClass("selected");
    $(".quick-key-item").hide();
    $("li[page="+$(this).text()+"][group="+$(".nav-tabs").find(".active").attr("position")+"]").show();
});

$(document).on('click', '.prev', function () {
    var targetPage = $(".quick-key-list-footer").children(".selected");
    if (targetPage.text() > 1) {
        targetPage.removeClass("selected");
        var destination = targetPage.prev();
        $(".quick-key-item").hide();
        $("li[page="+destination.text()+"]").show();
        destination.addClass("selected");
    }
});

$(document).on('click', '.next', function () {
    var targetPage = $(".quick-key-list-footer").children(".selected");
    if (targetPage.text() >= 1 && targetPage.text() < $(".page").length) {
        targetPage.removeClass("selected");
        var destination = targetPage.next();
        $(".quick-key-item").hide();
        $("li[page=" + destination.text() + "]").show();
        destination.addClass("selected");
    }
});

$(document).on("click", "li[role=presentation]", function() {
    $(".nav-tabs").find(".active").removeClass("active");
    $(this).addClass("active");
    $(".quick-key-item").hide();
    $(".quick-key-item[group="+$(this).attr("position")+"][page="+$(".quick-key-list-footer").find(".selected").attr("rel")+"]").show();
});

$(document).on('click', '.price-control', function () {

    return false;
});

$(document).on('click', '.remove', function () {
    $(this).closest("tr").remove();
    if ($(".order-product").length == 0) {
        $(".added-null").show();
    }
});
</script>

<script>
/** NUMBER PAD SETTINGS START **/
function number_write(x) {
    var text_box = document.getElementsByClassName("price_field")[0];
    if (x >= 0 && x <= 9) {
        if (isNaN(text_box.value))
            text_box.value = 0;

        if (x > 0 && x <= 9 && text_box.value == '0') {

            text_box.value = "";
            text_box.value += x;

        } else if (x == 0 && text_box.value == '0') {
            text_box.value = "0";
        } else if (x == '00' && text_box.value == '0') {
            x = "";
            text_box.value = "0";
        } else {
            text_box.value += x;
        }
    }
    if (x == '.') {
        if (text_box.value.indexOf(".") >= 0) {
        } else {
            text_box.value += '.';
        }
    }
}

function number_clear() {
    document.getElementsByClassName("price_field")[0].value = '';
}

function number_c() {
    var text_box = document.getElementsByClassName("price_field")[0];
    var num = text_box.value;
    var num1 = num % 10;
    num -= num1;
    num /= 10;
    text_box.value = num;
}

function number_negative() {
    var text_box = document.getElementsByClassName("price_field")[0];
    var num = text_box.value;
    text_box.value = -num;
}

function qty_write(x) {
    var text_box = document.getElementsByClassName("qty_field")[0];
    if (x >= 0 && x <= 9) {
        if (isNaN(text_box.value))
            text_box.value = 0;

        if (x > 0 && x <= 9 && text_box.value == '0') {

            text_box.value = "";
            text_box.value += x;

        } else if (x == 0 && text_box.value == '0') {
            text_box.value = "0";
        } else if (x == '00' && text_box.value == '0') {
            x = "";
            text_box.value = "0";
        } else {
            text_box.value += x;
        }
    }
    if (x == '.') {
        if (text_box.value.indexOf(".") >= 0) {
        } else {
            text_box.value += '.';
        }
    }
}

function qty_clear() {
    document.getElementsByClassName("qty_field")[0].value = '';
}

function qty_c() {
    var text_box = document.getElementsByClassName("qty_field")[0];
    var num = text_box.value;
    var num1 = num % 10;
    num -= num1;
    num /= 10;
    text_box.value = num;
}

function qty_negative() {
    var text_box = document.getElementsByClassName("qty_field")[0];
    var num = text_box.value;
    text_box.value = -num;
}

/** NUMBER PAD SETTINGS END **/

$(".show_numpad").click(function () {
    $(".numpad").toggle();
    $(".price_block").toggleClass('numpad_active');
    $(".price_block").position({
        my: "left+60 bottom+90",
        using: function (position) {
            $(this).animate(position);
        }
    });
    $(".qty_block").toggleClass('numpad_active');
    $(".qty_block").position({
        my: "left+60 bottom+90",
        using: function (position) {
            $(this).animate(position);
        }
    });
    /*
     $(".discount_block").toggleClass('numpad_active');
     $(".discount_block").position({
     my: "left+860 bottom+30",
     using: function( position ) {
     $( this ).animate( position );
     }
     });
     */
    return false;
});

var priceEdit = "discount";
var priceEditAll = "discount";
$(document).on("click", "#set-discount", function () {
    $(this).addClass("active");
    $("#set-unit-price").removeClass("active");
    $(".numpad_text").val("");
    $(".numpad_text").attr({'id': 'item-discount'});
    $(".numpad_text").attr({'placeholder': 'E.g. 20% or 20'});
    $("#text-top").text("Apply discount percentage");
    priceEdit = "discount";
});

$(document).on("click", "#set-discount-all", function () {
    $(this).addClass("active");
    $("#set-unit-price-all").removeClass("active");
    $(".numpad_text").val("");
    $(".numpad_text").attr({'id': 'item-discount'});
    $(".numpad_text").attr({'placeholder': 'E.g. 20% or 20'});
    $("#text-top").text("Apply discount percentage");
    priceEditAll = "discount";
});

$(document).on("click", "#set-unit-price", function () {
    $(this).addClass("active");
    $("#set-discount").removeClass("active");
    $(".numpad_text").val("");
    $(".numpad_text").attr({'id': 'item-unit-price'});
    $(".numpad_text").attr({'placeholder': 'E.g. 2.50'});
    $("#text-top").text("Edit unit price");
    priceEdit = "price";
});

$(document).on("click", "#set-unit-price-all", function () {
    $(this).addClass("active");
    $("#set-discount-all").removeClass("active");
    $(".numpad_text").val("");
    $(".numpad_text").attr({'id': 'item-unit-price'});
    $(".numpad_text").attr({'placeholder': 'E.g. 2.50'});
    $("#text-top").text("Edit unit price");
    priceEditAll = "price";
});

$(document).on("click", ".price-control", function (event) {
    if ($("#discount_auth").val() == 1) {
        $(".price-form").attr({"data-id": $(this).attr("data-id")});
        if (($(this).position().top + 136) == $(".price_block").position().top) {
            $(".price_block").hide();
            $(".price_block").removeClass("price_block_active");
        } else if (($(this).position().top + 135) == $(".price_block").position().top) {
            $(".price_block").hide();
            $(".price_block").removeClass("price_block_active");
        } else {
            $(".price_block").show();
            $(".qty_block").hide();
            $(".numpad_text").focus();
            $(".numpad_text").val("");
            $(".price_block").addClass("price_block_active");
            if ($(".price_block").hasClass("numpad_active")) {

                if ($(this).position().top < 120) {

                    $(".price_block").position({
                        my: "left+70 bottom+61",
                        of: $(this),
                        using: function (position) {
                            $(this).animate(position);
                        }
                    });

                } else {
                    $(".price_block").position({
                        my: "left+70 bottom+325",
                        of: $(this),
                        using: function (position) {
                            $(this).animate(position);
                        }
                    });
                }
            } else {
                $(".price_block").position({
                    my: "left+70 bottom+110",
                    of: $(this),
                    using: function (position) {
                        $(this).animate(position);
                    }
                });
            }
        }
    } else {
        alert("You are not authorized to perform this action!");
    }
});

$(document).on("click", ".qty-control", function (event) {
    if ($("#discount_auth").val() == 1) {
        $(".qty-form").attr({"data-id": $(this).attr("qty-id")});
        if (($(this).position().top + 169) == $(".qty_block").position().top) {
            $(".qty_block").hide();
            $(".qty_block").removeClass("qty_block_active");
        } else if (($(this).position().top + 171) == $(".qty_block").position().top) {
            $(".qty_block").hide();
            $(".qty_block").removeClass("qty_block_active");
        } else {
            $(".qty_block").show();
            $(".price_block").hide();
            $(".numpad_text").focus();
            $(".numpad_text").val("");
            $(".qty_block").addClass("qty_block_active");
            if ($(".qty_block").hasClass("numpad_active")) {
                if ($(this).position().top < 80) {
                    $(".qty_block").position({
                        my: "left+32 bottom+25",
                        of: $(this),
                        using: function (position) {
                            $(this).animate(position);
                        }
                    });
                } else {
                    $(".qty_block").position({
                        my: "left+32 bottom+289",
                        of: $(this),
                        using: function (position) {
                            $(this).animate(position);
                        }
                    });
                }
            } else {
                $(".qty_block").position({
                    my: "left+32 bottom+71",
                    of: $(this),
                    using: function (position) {
                        $(this).animate(position);
                    }
                });
            }
        }
    } else {
        alert("You are not authorized to perform this action!");
    }
});

$(document).on("click", ".discount", function (event) {
    $(".discount-form").attr({"data-id": $(this).attr("data-id")});
    if (($(this).position().top + 136) == $(".discount_block").position().top) {
        $(".discount_block").hide();
        $(".discount_block").removeClass("discount_block_active");
    } else if (($(this).position().top + 135) == $(".discount_block").position().top) {
        $(".discount_block").hide();
        $(".discount_block").removeClass("discount_block_active");
    } else {
        $(".discount_block").show();
        $(".price_block").hide();
        $(".qty_block").hide();
        $(".numpad_text").focus();
        $(".numpad_text").val("");
        $(".discount_block").addClass("pdiscount_block_active");
        if ($(".discount_block").hasClass("numpad_active")) {
            $(".discount_block").position({
                my: "left-83 bottom+255",
                of: $(this),
                using: function (position) {
                    $(this).animate(position);
                }
            });
        } else {
            $(".discount_block").position({
                my: "left-83 bottom-45",
                of: $(this),
                using: function (position) {
                    $(this).animate(position);
                }
            });
        }
    }
});

function assign_pricebook() {
    $(".order-product").each(function () {
        var data_row = $(this);
        $(".price-book-row[data-id=" + $(this).find('.added-code').val() + "]").each(function () {
            if ($(this).attr("group-id") == "") {
                if ($(this).find(".item_max").text().length > 0) {
                    if (data_row.find(".qty-control").text() >= parseInt($(this).find(".item_min").text()) && data_row.find(".qty-control").text() <= parseInt($(this).find(".item_max").text())) {
                        data_row.find(".price-control").text('@' + $(this).find(".item_price").text());
                        return false;
                    } else {
                        data_row.find(".price-control").text('@' + $(this).parents(".product-container").find(".price_including_tax").text());
                    }
                } else {
                    if (data_row.find(".qty-control").text() >= parseInt($(this).find(".item_min").text())) {
                        data_row.find(".price-control").text('@' + $(this).find(".item_price").text());
                        return false;
                    } else {
                        data_row.find(".price-control").text('@' + $(this).parents(".product-container").find(".price_including_tax").text());
                    }
                }
            } else {
                if ($(this).attr("group-id") == $("#customer-selected-group-id").val()) {
                    if ($(this).find(".item_max").text().length > 0) {
                        if (data_row.find(".qty-control").text() >= parseInt($(this).find(".item_min").text()) && data_row.find(".qty-control").text() <= parseInt($(this).find(".item_max").text())) {
                            data_row.find(".price-control").text('@' + $(this).find(".item_price").text());
                            return false;
                        } else {
                            data_row.find(".price-control").text('@' + $(this).parents(".product-container").find(".price_including_tax").text());
                        }
                    } else {
                        if (data_row.find(".qty-control").text() >= parseInt($(this).find(".item_min").text())) {
                            data_row.find(".price-control").text('@' + $(this).find(".item_price").text());
                            return false;
                        } else {
                            data_row.find(".price-control").text('@' + $(this).parents(".product-container").find(".price_including_tax").text());
                        }
                    }
                }
            }
        });
    });
}

$(document).on('submit', ".price-form", function () {
    if (priceEdit == 'price') {
        $("a[data-id=" + $(this).attr("data-id") + "]").text("@" + parseFloat($(".price_field").val()).toFixed(2));
    } else {
        var currentPrice = $("a[data-id=" + $(this).attr("data-id") + "]").text().replace(/@/, '');
        var toDiscount = currentPrice * $(".price_field").val().replace(/%/, "") / 100;
        $("a[data-id=" + $(this).attr("data-id") + "]").text("@" + parseFloat(currentPrice - toDiscount).toFixed(2));
    }
    $(".price_block").hide();
    priceCalculator();
    return false;
});

$(document).on('submit', ".discount-form", function () {
    var discounted_amount = 0;
    if (priceEditAll == 'price') {
        discounted_amount = parseFloat($(".discount_field").val());
    } else {
        var toDiscount = $(".toPay").text() * $(".discount_field").val().replace(/%/, "") / 100;
        discounted_amount = toDiscount;
    }
    $(".added-body").prepend('<tr class="order-discount"><td>Discount</td><td></td><td></td><td class="amount" style="text-align:right;">' + discounted_amount.toFixed(2) + '</td><td class="added-remove"><div class="remove clickable"><div class="glyphicon glyphicon-remove"></div></div></td></tr>');
    $(".discount_block").hide();
    priceCalculator();
    return false;
});

$(".qty-form").submit(function () {
    $("a[qty-id=" + $(this).attr("data-id") + "]").text(parseFloat($(".qty_field").val()));
    $(".qty_block").hide();
    priceCalculator();
    assign_pricebook();
    return false;
});
</script>
