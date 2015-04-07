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
                <button type="button" class="pull-right btn btn-white print"><div class="glyphicon glyphicon-print"></div>&nbsp;Print</button>
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
                    Invoice #: <span class="invoice-id">13jf93-o3p2f2930</span><br>
                    <span class="invoice-date">2015-03-10 15:23:49</span><br>
                    Served by: sales person on register: Register
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
                            <td class="total-amount receipt-tax pull-right">$2.40</td>
                        </tr>
                        <tr>
                            <th>TOTAL</th>
                            <td class="total-amount receipt-total pull-right">$12.40</td>
                        </tr>
                    </table>
                </div>
            </div>
         </div>
        <div class="receipt-bt"></div>
    </div>
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container"> 
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
              </span> </div>
          </form>
          <!-- END RESPONSIVE QUICK SEARCH FORM --> 
        </li>
        <li class="active"> <a href="index"> Sell <span class="selected"> </span> </a> </li>
        <li> <a href="history"> History </a> </li>
      </ul>
    </div>
    <!-- END HORIZONTAL RESPONSIVE MENU --> 
  </div>
  <!-- END SIDEBAR --> 
  <!-- BEGIN CONTENT -->
  <div class="page-content-wrapper">
    <div class="page-content sell-index">
      <div class="maximum">
          <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega margin-top-30">
             <button class="btn btn-white maxi pull-right"><i class="icon-size-fullscreen"></i></button>
           <button class="btn btn-white mini pull-right" style="display:none;"><i class="icon-size-actual"></i></button>
             <a href="#current"><button class="btn btn-white pull-right btn-right margin-right-5">CURRENT SALE</button></a>
             <a href="#retrieve"><button class="btn btn-white pull-right btn-left">RETRIEVE SALE</button></a>
        </div>
        <div id="block-left" class="col-md-6 col-xs-6">
          <div id="table-wrapper" class="col-md-12 col-sm-12 col-alpha col-omega">
            <div class="box col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
              <table class="added col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                <thead>
                  <tr class="added-header">
                    <th class="added-product" width="50%">Product</th>
                    <th class="added-qty" width="15%">Qty</th>
                    <th class="added-discount" width="15%">Price</th>
                    <th class="added-amount" width="12%">Amount</th>
                    <th class="added-remove" width="8%"></th>
                  </tr>
                </thead>
              </table>
              <div class="portlet-body col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                  <div class="discount_tag" style="display:none;">50% DISCOUNT</div>
                  <div class="added-null">
                    <img src="img/no-order.png" alt="no-order">
                    <h3>NO ORDER FOUND</h3>
                </div>
                <div class="scroller setHeight" data-always-visible="1" data-rail-visible="0">
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
              <?php if(!empty($authUser['outlet_id'])) { ?>
            <div class="col-lg-6 col-md-6 col-xs-6 col-sm-6 customer-search col-omega col-alpha">
                  <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                    <div class="col-md-9 col-xs-9 col-sm-9 col-alpha col-omega">
                        <input type="search" id="customer_search" class="search" placeholder="Customer Search">
                        <div class="search_result" style="display:none;">
                            <span class="search-tri"></span>
                            <div class="search-default"> No Result </div>

                            <?php foreach($customers as $customer){ ?>
                                <button type="button" 
                                data-id="<?=$customer['MerchantCustomer']['id'];?>"
                                data-name="<?=$customer['MerchantCustomer']['name'];?>"  
                                data-balance="<?=$customer['MerchantCustomer']['loyalty_balance'];?>" 
                                class="data-found customer_apply">
                                    <?=$customer['MerchantCustomer']['name'].' ('.
                                    $customer['MerchantCustomer']['customer_code'].')<br>$'.
                                    number_format($customer['MerchantCustomer']['loyalty_balance'],2,'.','');?>
                                </button>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-3 col-sm-3 col-alpha col-omega customer_quick_add"><button class="btn btn-default pull-right">Add</button></div>
                </div>
                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 col-omega col-alpha customer-search-result">
                    <dl style="display:none;">
                      <dt>Name</dt>
                      <dd id="customer-result-name"></dd>
                      <dt>Balance</dt>
                      <dd id="customer-result-balance"></dd>
                      <input type="hidden" id="customer-selected-id" value="<?php echo $customers[0]['MerchantCustomer']['id'];?>">
                    </dl>
                </div>
                <div class="col-md-12 col-xs-12 col-sm-12 buttons col-alpha col-omega">
                  <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4 col-omega col-alpha"><button id="park" class="btn btn-primary">Park</button></div>
                  <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4 col-omega col-alpha"><button class="btn btn-primary void">VOID</button></div>
                  <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4 col-omega col-alpha"><button class="btn btn-primary discount">Discount</button></div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-xs-6 col-sm-6 col-omega">
                <div class="receipt"></div>
                <div class="col-md-12 col-xs-12 col-sm-12 show-amount">
                      <ul class="receipt-text">
                          <li class="pull-left">Subtotal</li>
                        <li class="pull-right">$<text class="subTotal">0.00</text></li>
                    </ul>
                    <ul class="receipt-text">
                        <li class="pull-left">Tax (GST)</li>
                        <li class="pull-right">$<text class="gst">0.00</text></li>
                    </ul>
                    <ul class="receipt-text">
                        <li class="pull-left">TOTAL</li>
                        <li class="pull-right">$<text class="total">0.00</text></li>
                    </ul>
                    <div class="solid-line"></div>
                    <ul class="receipt-text">
                        <li class="pull-left h4">TO PAY</li>
                        <li class="pull-right h4">$<text class="toPay">0.00</text></li>
                    </ul>
                    <input type="button" value="PAY" id="pay" class="btn">
                </div>
                <div class="receipt-bt"></div>
            </div>
            <?php } ?>
        </div>
        </div>
        <div id="block-right" class="col-md-6 col-xs-6 col-sm-6">
          <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
            <div class="col-lg-9 col-md-9 col-xs-9 col-sm-9 col-alpha col-omega">
                <input type="search" id="product_search" class="search" placeholder="Product Search" autocomplete="off">
            </div>
            <div class="col-lg-3 col-md-3 col-xs-3 col-sm-3 col-omega">
                <button id="image-view-c" class="btn btn-white btn-right pull-right active"><div class="glyphicon glyphicon-th-large"></div></button>
                <button id="button-view-c" class="btn btn-white btn-left pull-right"><div class="glyphicon glyphicon-th"></div></button>
            </div>
          </div>
          <div class="col-md-12 col-xs-12 col-sm-12 product-list col-alpha col-omega">
          
              <div class="scroller" data-always-visible="1" data-rail-visible="0">
                  <ul class="feeds">
                    <li>

                    <?php
                    $count = 0;
                    $page = 1;
                    $pageCount = 1;
                    if(!empty($authUser['outlet_id'])) {
                    foreach($items as $item) {
                        if($count == 10){$page++; $count = 0; $pageCount++;}?>
                        <div class="col-md-4 col-xs-12 col-sm-6 product clickable col-alpha col-omega" data-id="<?=$item['MerchantProduct']['id'];?>" page="<?=$page;?>">
                            <div class="product-container">
                                <div class="product-img"><img src="img/<?php if($item['MerchantProduct']['image'] == null){echo 'no-image.png';}else{echo $item['MerchantProduct']['image'];}?>" alt="product"></div>
                                <div class="product-info">
                                    <div class="product-name"><p><?=$item['MerchantProduct']['name'];?></p></div>
                                    <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega price-wrap">
                                        <div class="product-price col-lg-5 col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                                            <b>$<span class="price_including_tax"><?=number_format($item['MerchantProduct']['price_include_tax'],2,'.','');?></span></b>
                                        </div>
                                        <div class="product-stock col-lg-7 col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                                            <small>In Stock: 222</small>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" class="product-retail_price" value="<?=$item['MerchantProduct']['price'];?>">
                                <input type="hidden" class="product-tax" value="<?=$item['MerchantProduct']['tax'];?>">
                            </div>
                        </div>
                    <?php $count++;
                    }} ?>
                    </li>
                  </ul>
              </div>

          </div>
          <div class="col-md-12 col-xs-12 col-sm-12 product-found-list col-alpha col-omega" style="display:none;">
              <div class="scroller" data-always-visible="1" data-rail-visible="0">
                  <ul class="feeds">
                    <li>
                    
                    </li>
                  </ul>
              </div>
          </div>
          <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega product-list-footer">
              <span class="pull-left clickable prev"><i class="glyphicon glyphicon-chevron-left"></i></span>
              <span class="pull-right clickable next"><i class="glyphicon glyphicon-chevron-right"></i></span>
              <span class="page clickable selected">1</span>
              <?php
              if($pageCount > 1){
                  for($i = 2;$i <= $pageCount;$i++){?>
                  <span class="page clickable"><?=$i;?></span>
              <?php }} ?>
          </div>
        </div>
      </div>
    </div>
    
    <div class="page-content retrieve-sale hidden">
        
        <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega margin-bottom-20">
            <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">Select a Sale to Open</h2>
            <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20">
                <a href="#current"><button class="btn btn-white pull-right btn-right margin-right-5">CURRENT SALE</button></a>
                <a href="#retrieve"><button class="btn btn-white pull-right btn-left">RETRIEVE SALE</button></a>
            </div>
        </div>
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
            
                <?php foreach($retrieves as $sale){ ?>
                    <tr class="clickable retrieve_sale" data-id="<?=$sale['RegisterSale']['id'];?>" data-count="<?=count($sale['RegisterSaleItem']);?>">
                    
                        <td><?=$sale['RegisterSale']['created'];?></td>
                        <td><?=$sale['RegisterSale']['status'];?></td>
                        <td><?=$sale['MerchantUser']['username'];?></td>
                        <td><?=$sale['RegisterSale']['customer_id'];?></td>
                        <td></td>
                        <td><?=$sale['RegisterSale']['total_price'];?></td>
                        <td><?=$sale['RegisterSale']['note'];?></td>
                        <td>
                            <?php foreach($sale['RegisterSaleItem'] as $get) { ?>
                            <span class="hidden retrieve-child-products">
                                <span class="retrieve-child-id"><?=$get['MerchantProduct']['id'];?></span>
                                <span class="retrieve-child-name"><?=$get['MerchantProduct']['name'];?></span>
                                <span class="retrieve-child-price"><?=$get['MerchantProduct']['price'];?></span>
                                <span class="retrieve-child-tax"><?=$get['MerchantProduct']['tax'];?></span>
                            </span>
                            <?php } ?>
                        </td>
                    
                    </tr>
                <?php } ?>
            
            </tbody>
        </table>
                
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
                      <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 col-omega col-alpha">
                          <input type="text">
                      </div>
                      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 col-omega">
                          <button class="btn btn-primary pull-right"><span class="glyphicon glyphicon-th"></span></button>
                      </div>
                  </div>
                  <ul class="margin-top-20 col-lg-12 col-md-12 col-sm-12 col-omega col-alpha payment-btn">
                  
                      <?php foreach($payments as $payment){ ?>
                      
                          <li class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-omega col-alpha btn-left payment_method" payment-id="<?=$payment['MerchantPaymentType']['id'];?>">
                          <button class="btn btn-primary col-lg-12 col-md-12 col-sm-12 col-xs-12 col-omega col-alpha">
                              <span class="co-md-12"><img src="/img/<?php if($payment['PaymentType']['name'] == 'Credit Card'){echo 'card';}else if($payment['PaymentType']['name'] == 'Cheque'){echo 'cheque';}else{echo 'cash';}?>.png" alt="cash"></span>
                              <p class="co-md-12"><?=$payment['MerchantPaymentType']['name'];?></p>
                          </button>
                          </li>
                      
                      <?php } ?>
                  
                  </ul>
              </div>
              <div class="modal-footer col-md-12 col-sm-12 col-xs-12">
                  <button class="cancel pull-left btn btn-primary" type="button" data-dismiss="modal">Back to Sale</button>                                  
                <button class="btn btn-success onaccount-sale" type="button" data-dismiss="modal">On account</button>
                  <button class="btn btn-success layby-sale" type="button" data-dismiss="modal">Layby</button>

              </div>
          </div>
      </div>
  </div>
  <!-- PAY POPUP BOX END -->
 
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
                  <h3>Are you sure you want to void this sale?</h3><br>All products and payments will be removed from the current sale. Voided sale information is saved in the sales history.
              </div>
              <div class="modal-footer">
                  <button class="cancel btn btn-primary" type="button" data-dismiss="modal">Cancel</button>
                  <button class="confirm btn btn-success void-sale" type="button" data-dismiss="modal">Void Sale</button>
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
                  You are loading a saved sale (<span id="retrieve_order_count"></span> items). What would you like to do with the current sale (<span id="current_order_count"></span> items)?
              </div>
              <div class="modal-footer">
                  <button class="cancel btn btn-primary pull-left" type="button" data-dismiss="modal">Back to Sale</button>
                <button class="confirm btn btn-success park-sale retrieve-a" type="button" data-dismiss="modal">Park</button>
                  <button class="btn btn-success void-sale retrieve-a" type="button" data-dismiss="modal">Void</button>
              </div>
          </div>
      </div>
  </div>
  <!-- RETRIEVE POPUP BOX END -->
  
  <!-- CUSTOMER ADD BOX -->
  <?php if(!empty($authUser['outlet_id'])){ ?>
  <input type="hidden" id="customer-null" value="<?=$customers[0]['MerchantCustomer']['id'];?>">
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
                            <div class="col-md-12">
                                <input type="radio" name="gender" value="F" style="width:30px;" id="gender_female"> 
                                <label for="gender_female">Female</label>
                                <input type="radio" name="gender" value="M" style="width:30px;" id="gender_male"> 
                                <label for="gender_male">Male</label>
                            </div>
                          <select id="add_customer-group">
                              <?php foreach($groups as $group){ ?>
                                  <option value="<?=$group['MerchantCustomerGroup']['id'];?>"><?=$group['MerchantCustomerGroup']['name'];?></option>
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
                              <?php foreach($countries as $country){ ?>
                                  <option value="<?=$country['Country']['country_code'];?>"><?=$country['Country']['country_name'];?></option>
                              <?php } ?>
                          </select>
                      </div>
                  </div>
              </div>
              <div class="modal-footer col-md-12 col-sm-12 col-xs-12">
                  <button class="btn add_customer-submit" type="button" data-dismiss="modal">Save</button>
                  <button class="cancel btn" type="button" data-dismiss="modal">Cancel</button>
              </div>
          </div>
      </div>
  </div>
  <?php } ?>
  <!-- CUSTOMER ADD BOX END -->
  
  <!-- SELECT REGISTER POPUP BOX -->
  <div class="confirmation-modal modal fade in" id="register_box" tabindex="-1" role="dialog" aria-hidden="false" style="display: <?php if(empty($authUser['MerchantRegister'])){echo "block";}else{echo "none";}?>">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="confirm-close cancel" data-dismiss="modal" aria-hidden="true">
                  <i class="glyphicon glyphicon-remove"></i>
                  </button>
                  <h4 class="modal-title">Select a register</h4>
              </div>
              <div class="modal-body">
                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12 col-omega">
                    <button id="" class="btn btn-white btn-right pull-right active"><div class="glyphicon glyphicon-th-large"></div></button>
                    <button id="" class="btn btn-white btn-left pull-right"><div class="glyphicon glyphicon-th-list"></div></button>
                </div>
                <div class="multi_btn margin-top-10 inline-block" style="display:block;">
                      <?php foreach($outlets as $outlet){ ?>
                          <?php foreach($outlet['MerchantRegister'] as $register) { ?>
                  
                          <div class="col-md-3 col-sm-3 col-sx-3">
                            <button class="btn btn-success full-width register-set" register-id="<?php echo $register['id'];?>" outlet-id="<?php echo $register['outlet_id'];?>"><?php echo $register['name'];?></button>
                        </div>
                
                        <?php } ?>
                    <?php } ?>
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

  <!-- STATUS POPUP BOX -->
  <div class="confirmation-modal modal fade in" id="register_box" tabindex="-1" role="dialog" aria-hidden="false" >
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="confirm-close cancel" data-dismiss="modal" aria-hidden="true">
                  <i class="glyphicon glyphicon-remove"></i>
                  </button>
                  <h4 class="modal-title">Status</h4>
              </div>
              <div class="modal-body">
			  	<p>Please wait while your offline data is updated</p>
              </div>
              <div class="modal-footer col-md-12 col-sm-12 col-xs-12">
                  <button class="btn add_customer-submit" type="button" data-dismiss="modal">Go to the Dashboard</button>
                  <button class="cancel btn" type="button" data-dismiss="modal">Cancel</button>
              </div>
          </div>
      </div>
  </div>
  <!-- STATUS POPUP BOX END -->
  
  <!-- END CONTENT --> 
  <!-- BEGIN QUICK SIDEBAR --> 
  <a href="javascript:;" class="page-quick-sidebar-toggler"><i class="icon-close"></i></a>
  <div class="page-quick-sidebar-wrapper">
    <div class="page-quick-sidebar">
      <div class="nav-justified">
        <ul class="nav nav-tabs nav-justified">
          <li class="active"> <a href="#quick_sidebar_tab_1" data-toggle="tab"> Users <span class="badge badge-danger">2</span> </a> </li>
          <li> <a href="#quick_sidebar_tab_2" data-toggle="tab"> Alerts <span class="badge badge-success">7</span> </a> </li>
          <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> More<i class="fa fa-angle-down"></i> </a>
            <ul class="dropdown-menu pull-right" role="menu">
              <li> <a href="#quick_sidebar_tab_3" data-toggle="tab"> <i class="icon-bell"></i> Alerts </a> </li>
              <li> <a href="#quick_sidebar_tab_3" data-toggle="tab"> <i class="icon-info"></i> Notifications </a> </li>
              <li> <a href="#quick_sidebar_tab_3" data-toggle="tab"> <i class="icon-speech"></i> Activities </a> </li>
              <li class="divider"> </li>
              <li> <a href="#quick_sidebar_tab_3" data-toggle="tab"> <i class="icon-settings"></i> Settings </a> </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <!-- END QUICK SIDEBAR --> 
</div>
<div class="qty_block">
            
    <form action="#" novalidate class="qty-form">

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
            
    <form action="#" novalidate class="price-form">

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
            
    <form action="#" novalidate class="discount-form">

        <div class="main_panel col-md-12 col-sm-12 col-xs-12 col-alpha col-omega">
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
            <div class="col-md-12 col-sm-12 col-xs-12 col-alpha col-omega margin-bottom-10">
                <input type="button" id="set-discount-all" class="col-md-6 btn btn-primary btn-left active" value="Percentage">
                <input type="button" id="set-unit-price-all" class="col-md-6 btn btn-primary btn-right" value="Amount">
            </div>
            
            
            <div class="col-md-12 col-sm-12 col-xs-12 col-alpha col-omega">
                <input id="item-discount" class="discount_field numpad_text col-md-10" type="text" name="num" placeholder="E.g. 20% or 20" pattern="([0-9]{0,}[.]{1}[0-9]{1,}|[0-9]{1,}[.]{0,1}[0-9]{0,})[%]{0,1}">
                <button type="button" class="btn btn-primary col-md-2 show_numpad"><i class="glyphicon glyphicon-th"></i></button>
            </div>
            
        </div>
    
    </form>
    
</div>
<div class="modal-backdrop fade in" style="display:<?php if(empty($authUser['MerchantRegister'])){echo "block";}else{echo "none";};?>"></div>
<!-- END CONTAINER --> 
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) --> 
<!-- BEGIN CORE PLUGINS --> 
<!--[if lt IE 9]>
<script src="assets/global/plugins/respond.min.js"></script>
<script src="assets/global/plugins/excanvas.min.js"></script> 
<![endif]--> 
<script src="assets/global/plugins/jquery-1.11.0.min.js" type="text/javascript"></script> 
<script src="assets/global/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script> 
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip --> 
<script src="assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script> 
<script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> 
<script src="assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script> 
<script src="assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script> 
<script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script> 
<script src="assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script> 
<script src="assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script> 
<script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script> 
<!-- END CORE PLUGINS -->  
<!-- END PAGE LEVEL PLUGINS --> 
<!-- BEGIN PAGE LEVEL SCRIPTS --> 
<script src="assets/global/scripts/metronic.js" type="text/javascript"></script> 
<script src="assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="/js/jquery.jqprint-0.3.js" type="text/javascript"></script>
<script src="/js/dataTable.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS --> 
<script>
jQuery(document).ready(function() {
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    
    
    
    /**
     *    Retrieve Sale
     **/
    
    $("#retrieveTable").DataTable({
        searching: false
    });
    $("#retrieveTable_length").hide();
    
    $(document).on("click","a[href=#current]",function(){
        $(".retrieve-sale").addClass("hidden");
        $(".sell-index").removeClass("hidden");
    });
    $(document).on("click","a[href=#retrieve]",function(){
        $(".retrieve-sale").removeClass("hidden");
        $(".sell-index").addClass("hidden");
    });
    $(".retrieve_sale").click(function(){
        $(".retrieve-sale").addClass("hidden");
        $(".sell-index").removeClass("hidden");
        if($(".order-product").length !== 0){
            $(".retrieve-popup").show();
            $(".modal-backdrop").show();
            $("#current_order_count").text($(".order-product").length);
            $("#retrieve_order_count").text($(this).attr("data-count"));
            
            var targetSale = $(this)
            
            $(document).on("click",".retrieve-a",function(){
                $(".added-null").hide();
                $(".order-product").remove();
                var retCount = 0;
                targetSale.find(".retrieve-child-products").each(function(){
                    var comp_1 = $(this).children(".retrieve-child-price").text();
                    var comp_2 = $(this).children(".retrieve-child-tax").text();
                    var price_including_tax = parseFloat(comp_1) + parseFloat(comp_2);
    
                    $(".added-body").prepend('<tr class="order-product"><input type="hidden" class="added-code" value="'+$(this).children(".retrieve-child-id").text()+'"><td class="added-product">'+$(this).children(".retrieve-child-name").text()+'<br><span class="added-price">$'+parseFloat($(this).children(".retrieve-child-price").text()).toFixed(2)+'</span></td><td class="added-qty"><a qty-id="'+retCount+'" class="qty-control btn btn-white">1</a></td><td class="added-discount"><a href="#price-control" class="price-control btn btn-white" data-id="'+retCount+'">@'+price_including_tax.toFixed(2)+'</a></td><td class="added-amount"></td><td class="added-remove"><div class="remove clickable"><div class="glyphicon glyphicon-remove"></div></div></td></tr>');
                    retCount++;
                });
            });
            
        } else {
            $(".added-null").hide();
            var retCount = 0;
            $(this).find(".retrieve-child-products").each(function(){

                var comp_1 = $(this).children(".retrieve-child-price").text();
                var comp_2 = $(this).children(".retrieve-child-tax").text();
                var price_including_tax = parseFloat(comp_1) + parseFloat(comp_2);

                $(".added-body").prepend('<tr class="order-product"><input type="hidden" class="added-code" value="'+$(this).children(".retrieve-child-id").text()+'"><td class="added-product">'+$(this).children(".retrieve-child-name").text()+'<br><span class="added-price">$'+parseFloat($(this).children(".retrieve-child-price").text()).toFixed(2)+'</span></td><td class="added-qty"><a qty-id="'+retCount+'" class="qty-control btn btn-white">1</a></td><td class="added-discount"><a href="#price-control" class="price-control btn btn-white" data-id="'+retCount+'">@'+price_including_tax.toFixed(2)+'</a></td><td class="added-amount"></td><td class="added-remove"><div class="remove clickable"><div class="glyphicon glyphicon-remove"></div></div></td></tr>');
                retCount++;
            });
        }
    });


    /**
     *    Popup Control From Here
     **/

    $(".customer_quick_add").click(function(){
        $(".customer_add").show();
        $(".modal-backdrop").show();
    });
    $(".close-popup").click(function(){
        $(".receipt-parent").hide();
        $(".fade").hide();
    });
    $("#pay").click(function(){
        $(".pay").show();
        $(".modal-backdrop").show();
    });
    $("#park").click(function(){
        $(".park").show();
        $(".modal-backdrop").show();
    });
    $(".void").click(function(){
        $(".void").show();
        $(".modal-backdrop").show();
    })
    $(".confirm-close").click(function(){
        $(".fade").hide();
    });
    $(document).on('click','.cancel',function(){
        $('.fade').hide();
    });


    /**
     *    Dynamic Control From Here
     **/
     
    // DYNAMIC PROUCT SEARCH
    var found_count = 0;
    var found_page = 1;
    $(document).on("keyup","#product_search",function() {
        var val = $.trim(this.value).toUpperCase();
        if (val === ""){
            $(".product").hide();
            $("div[page="+$(".selected").text()+"]").show();
            $(".product-list").show();
            $(".product-found-list").hide();
        } else {
            $(".product").removeClass('search_target');
            $(".product-name").filter(function() {
                return -1 != $(this).text().toUpperCase().indexOf(val);
            }).parent().parent().parent().addClass('search_target');
            
            $(".product-found-list").find('li').html('');
            $(".search_target").each(function(){
                found_count++;
                if(found_count == 7) {
                    found_page++;
                    found_count = 0;
                    $(".product-found-list").find('li').append($(this).clone().attr("page", found_page));
                } else {
                    $(".product-found-list").find('li').append($(this).clone().attr("page", found_page));
                }
            });
            $(".product-list").hide();
            $(".product-found-list").show();
        }
    });

    // DYNAMIC CUSTOMER SEARCH 

    var $cells = $(".data-found");
    $(".search_result").hide();

    $(document).on("keyup","#customer_search",function() {
        var val = $.trim(this.value).toUpperCase();
        if (val === "")
            $(".search_result").hide();
        else {
            $cells.hide();
            $(".search_result").show();
            $(".search-default").hide();
            $cells.filter(function() {
                return -1 != $(this).text().toUpperCase().indexOf(val);
            }).show();
            if($(".search_result").height() <= 20){
                $(".search-default").show();
            }
        }
        $cells.click(function(){
           $("#search").val($(this).text());
        });
    });


    /**
     *Transaction Control From Here
     **/

    function save_line_order() {
        var sequence = 0;
        line_array = [];
        
        $(".order-product").each(function(){
            line_array.push([$(this).children(".added-code").val(), $(this).children(".added-qty").children("a").text(), $(this).children(".added-amount").text(), sequence]);
            sequence++;
        });
    }
    
    function save_register_sale() {
        save_line_order();
        
        line_array = JSON.stringify(line_array);
        $.ajax({
            url: "/home/pay.json",
            type: "POST",
            data: {
                customer_id: $("#customer-selected-id").val(),
                receipt_number: '323232',
                total_price: $(".subTotal").text(),
                total_cost: $(".toPay").text(),
                total_discount: '',
                total_tax: $(".gst").text(),
                note: '',
                merchant_payment_type_id: payment_id,
                items: line_array
            }
        });
        
        $(".customer-search-result").children().hide();
        $("#customer-result-name").val('');
        $("#customer-selected-id").val($("#customer-null").val());
    }

    function park_register_sale(status) {
        save_line_order();

        line_array = JSON.stringify(line_array);
        $.ajax({
            url: "/home/park.json",
            type: "POST",
            data: {
                customer_id: $("#customer-selected-id").val(),
                receipt_number: '323232',
                total_price: $(".subTotal").text(),
                total_cost: $(".toPay").text(),
                total_discount: '',
                total_tax: $(".gst").text(),
                note: $("#leave_note").val(),
                status: status,
                items: line_array
            }
        });
        
        $(".customer-search-result").children().hide();
        $("#customer-result-name").text('');
        $("#customer-selected-id").val($("#customer-null").val());
    }
    
    // Pay
    $(document).on("click",".payment_method",function(){
        payment_id = $(this).attr("payment-id");

        save_register_sale();

        $(".fade").hide();
        $(".receipt-product-table").children("tbody").text('');
        $(".order-product").each(function(){
            $(".receipt-product-table").children("tbody").append('<tr><td class="receipt-product-qty">'+$(this).children(".added-qty").children("a").text()+'</td><td class="receipt-product-name">'+$(this).children(".added-product").text().split("$")[0]+'</td><td class="receipt-price pull-right">$'+$(this).children(".added-amount").text()+'</td></tr>');
        });
        $(".order-product").remove();
        $(".receipt-parent").show('blind');
        $(".modal-backdrop").show();
        $(".receipt-customer-name").text($("#customer-result-name").text());
        $(".receipt-subtotal").text('$'+ $(".subTotal").text());
        $(".receipt-tax").text('$'+ $(".gst").text());
        $(".receipt-total").text('$'+ $(".toPay").text());


        var now = new Date(Date.now());

        $(".invoice-date").text($.datepicker.formatDate('yy/mm/dd', new Date())+' '+now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds());
    });

    // Park
    $(document).on("click",".park-sale",function(){
        
        park_register_sale('saved');
        
        $(".fade").hide();
        $(".order-product").remove();
    });
    
    // Layby
    $(document).on("click",".layby-sale",function(){
        
        if($("#customer-result-name").text() == ""){
            alert("Customer not selected");
        } else {
            park_register_sale('layby');
            $(".order-product").remove();
        }
        
        $(".fade").hide();
    });
    
    // Onaccount
    $(document).on("click",".onaccount-sale",function(){
        
        if($("#customer-result-name").text() == ""){
            alert("Customer not selected");
        } else {
            park_register_sale('onaccount');
            $(".order-product").remove();
        }
        
        $(".fade").hide();
    });
    
    // Void
    $(document).on("click",".void-sale",function(){
        $(".order-product").remove();
        $(".added-null").show();
        $(".fade").hide();
    });


    /**
     *ustomer add & apply
     **/
     

    $(document).on("click",".add_customer-submit",function(){
        $.ajax({
            url: '/customer/customer_quick_add.json',
            type: 'POST',
            data: {
                first_name: $("#add_customer-first").val(),
                last_name: $("#add_customer-last").val(),
                birthday: $("#add_customer-yyyy").val()+'-'+$("#add_customer-mm").val()+'-'+$("#add_customer-dd").val(),
                dob: $("#add_customer-yyyy").val()+'-'+$("#add_customer-mm").val()+'-'+$("#add_customer-dd").val(),
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
                name: $("#add_customer-first").val() +' '+ $("#add_customer-last").val(),
                gender: 'M',
            }
        }).done(function(result){
            $("#customer-selected-id").val(result['id']);
            $("#customer-result-name").text(result['data']['name']);
            $("#customer-result-balance").text('$0.00');
            $(".customer-search-result").children("dl").show();
            $(".modal-backdrop").hide();
            $(".customer_add").hide();
        });
    });
    
    $(".customer_apply").click(function(){
        $("#customer_search").val('');
        $(".search_result").hide();
        $(".customer-search-result").children("dl").show();

        $("#customer-result-name").text($(this).attr("data-name"));
        $("#customer-result-balance").text('$'+ parseFloat($(this).attr("data-balance")).toFixed(2));
        $("#customer-selected-id").val($(this).attr("data-id"));
        
    });

    $(".product").hide();
    $(".product[page=1]").show();
    
    
    $(".print").click(function(){
        $(this).hide();
        $("#receipt").jqprint();
        $(this).show();
    });





    $(document).on("click","#button-view-c",function(){
       $(this).addClass("active");
       $("#image-view-c").removeClass("active");
       $(".product").attr("class","col-md-3 col-md-4 col-sm-4 col-xs-6 product clickable col-alpha col-omega button-view");
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
       $(".product").each(function(){
               if(productList <= 32){
                   $(this).attr("page",pageNav);
               }
               if(productList == 32){
                   productList = 0;
                   pageNav++;
               }
               productList++;
               productTotal++;
       });
       $(".product").hide();
       $("div[page=1]").show();
       $(".page").removeClass("selected");
       var productPage = 1;
       $(".page").each(function(){
           if(productPage == 1){
               $(this).addClass("selected");
           }
           if(productPage > Math.ceil(productTotal / 32)){
               $(this).hide();
           }
           productPage++;
       });
    });
    
    $(".register-set").click(function(){
        var outlet_id = $(this).attr("outlet-id");
        var register_id = $(this).attr("register-id");
        $.ajax({  
           url: "/home/select_register.json",
           type: "POST",
           data: {
               outlet_id: outlet_id,
               register_id: register_id
           }
        });
        location.reload();
    });

    $(document).on("click","#image-view-c",function(){
       $(this).addClass("active");
       $("#button-view-c").removeClass("active");
       $(".product").attr("class","col-md-4 col-sm-4 col-xs-4 product clickable col-alpha col-omega");
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

       for(var j = 1;j <= Math.ceil($(".product").length / 6);j++){
           var i = 1;
           $("div[page="+j+"]").each(function(){
              if(i >= 7){
                  $(this).attr("page",j+1).hide();
              }
              i++;
           });
       }

       $(".page").removeClass("selected");
       var p = 0;
       $(".page").each(function(){
           if(p == 0)
               $(this).addClass("selected");
               
           p++;
       });
       $(".page").show();
       $("div[page=1]").show();
    });
});
</script> 
<!-- END JAVASCRIPTS --> 
<script type="text/javascript" src="/js/jquery.confirm.js"></script> 
<script type="text/javascript" src="/js/jquery.fullscreen.min.js"></script> 
<script src="/js/jquery.plugin.js"></script> 
<script src="/js/jquery.calculator.js"></script>
<script>
$(document).ready(function(){

    $("#change_register").click(function(){
        $("#register_box").show();
        $(".modal-backdrop").show();
    });

    /* FULL SCREEN MODE START */
    $(".maxi").click(function(){
        $("body").fullscreen();
        $(".maxi").hide();
        $(".mini").show();
        return false;
    });
    $(".mini").confirm({
        text:"Exit full screen?",
        confirm: function(button){
            $.fullscreen.exit();
            return false;
        },
        cancel: function(button){
        },
        confirmButton: "Exit",
        cancelButton: "Cancel"
    });
    $(document).bind('fscreenchange', function(e, state, elem) {
        if (!$.fullscreen.isFullScreen()) {
            $(".maxi").show();
            $(".mini").hide();
        }
    });
    /* FULL SCREEN MODE END */
    /* MENU TAB START */
    $(".specials").click(function(){
        $(this).addClass("active");
        $(".ordered").removeClass("active");
        $(".results").removeClass("active");
        $("#specials").show();
        $("#frequently_ordered").hide();
        $("#search_results").hide();
    });
    $(".ordered").click(function(){
        $(this).addClass("active");
        $(".specials").removeClass("active");
        $(".results").removeClass("active");
        $("#specials").hide();
        $("#frequently_ordered").show();
        $("#search_results").hide();
    });
    $(".results").click(function(){
        $(this).addClass("active");
        $(".specials").removeClass("active");
        $(".ordered").removeClass("active");
        $("#specials").hide();
        $("#frequently_ordered").hide();
        $("#search_results").show();
    });
    /* MENU TAB END */
    
    var mq = window.matchMedia('all and (max-width: 1028px)');
    if(mq.matches) {
    } else {
        window.addEventListener('resize', handleWindowResize);
        handleWindowResize();
    }


});

function handleWindowResize() {
    var height = $(window).height() - $(".page-header").height() - $("#footer").height();
    var table = height - $(".commands").height() - $(".page-header").height() - $("#footer").height();
    var productTable = height - $(".commands").height() - $(".page-header").height() - $("#footer").height() + 90;
    $("#block-right").css({
        "height": height - 60
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

$(document).on("click", function(){
    priceCalculator();
});
$(document).on("keyup", function(){
    priceCalculator();
});

$(document).mouseup(function (e)
{
    var container = $(".price_block");
    var container_2 = $(".qty_block");
    var container_3 = $(".discount_block");

    if (container.is(':visible') && !container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
        container.hide();
    }
    if(container_2.is(':visible') && !container_2.is(e.target) // if the target of the click isn't the container...
        && container_2.has(e.target).length === 0)
    {
        container_2.hide();
    }
    if(container_3.is(':visible') && !container_3.is(e.target) // if the target of the click isn't the container...
        && container_3.has(e.target).length === 0)
    {
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

    $(".order-product").each(function(){
        var setPrice = $(this).children(".added-discount").text();
        var qty = $(this).children(".added-qty").children($(".qty-control")).text();
        var linePrice = qty*$(this).children(".hidden-retail_price").val();
        var lineTax = qty*$(this).children(".hidden-tax").val();
        var setPrice = $(this).children('.added-discount').children('.price-control').text().slice(1);
        totalTax += qty*$(this).children(".hidden-tax").val();
        totalSub += qty*$(this).children(".hidden-retail_price").val();
        linePriceS += linePrice + lineTax;

        $(this).children(".added-amount").text(setPrice * qty);
        
        toPay += setPrice * qty;
    });

    $(".gst").text(parseFloat(toPay - toPay/1.15).toFixed(2));
    $(".total").text(parseFloat(toPay).toFixed(2));
    $(".toPay").text(parseFloat(toPay).toFixed(2));
    $(".subTotal").text(parseFloat($(".total").text() - $(".gst").text()).toFixed(2));
}

/** CALCULATION END **/
</script> 
<script src="js/jquery.keypad.js"></script>

<script>
var listCount = 0;
$(document).on('click', '.product', function(){
    $(".added-body").prepend('<tr class="order-product"><input type="hidden" class="added-code" value="'+$(this).attr("data-id")+'"><input type="hidden" class="hidden-retail_price" value="'+$(this).children().children(".product-retail_price").val()+'"><input type="hidden" class="hidden-tax" value="'+$(this).children().children(".product-tax").val()+'"><td class="added-product">'+$(this).children(".product-container").children(".product-info").children(".product-name").text()+'<br><span class="added-price">$'+$(this).children(".product-container").children(".product-info").children(".price-wrap").children(".product-price").children("b").children(".price_including_tax").text()+'</span></td><td class="added-qty"><a qty-id="'+listCount+'" class="qty-control btn btn-white">1</a></td><td class="added-discount"><a href="#price-control" class="price-control btn btn-white" data-id="'+listCount+'">@'+$(this).children(".product-container").children(".product-info").children(".price-wrap").children(".product-price").children("b").children(".price_including_tax").text()+'</a></td><td class="added-amount">'+$(this).children(".product-container").children(".product-info").children(".price-wrap").children(".product-price").children("b").children(".price_including_tax").text()+'</td><td class="added-remove"><div class="remove clickable"><div class="glyphicon glyphicon-remove"></div></div></td></tr>');
    listCount++;
    $(".added-null").hide();
});

$(document).on('click', '.page', function(){
    $(".page").addClass("clickable");
    $(".page").removeClass("selected");
    $(this).removeClass("clickable");
    $(this).addClass("selected");
    $(".product").hide();
    $("div[page="+$(this).text()+"]").show();
});


$(document).on('click', '.prev', function(){
    var targetPage = $(".product-list-footer").children(".selected");
    if(targetPage.text() > 1){
        targetPage.removeClass("selected");
        var destination = targetPage.prev();
        $(".product").hide();
        $("div[page="+destination.text()+"]").show();
        destination.addClass("selected");
    }
});

$(document).on('click', '.next', function(){
    var targetPage = $(".product-list-footer").children(".selected");
    if(targetPage.text() >= 1 && targetPage.text() < $(".page").length){
        targetPage.removeClass("selected");
        var destination = targetPage.next();
        $(".product").hide();
        $("div[page="+destination.text()+"]").show();
        destination.addClass("selected");
    }
});

$(document).on('click', '.price-control', function() {
    
    return false;
});


$(document).on('click', '.remove', function(){
    $(this).closest("tr").remove();
    if($(".order-product").length == 0){
        $(".added-null").show();
    }
});
</script>


<script>
/** NUMBER PAD SETTINGS START **/
function number_write(x)
{
  var text_box = document.getElementsByClassName("price_field")[0];
  if(x>=0 && x<=9)
  {
    if(isNaN(text_box.value))
        text_box.value = 0;
    
    if(x>0 && x<=9 && text_box.value == '0'){
    
        text_box.value = "";
        text_box.value += x;
        
    }else if(x==0 && text_box.value == '0'){
        text_box.value = "0";
    }else if(x == '00' && text_box.value == '0'){
        x = "";
        text_box.value = "0";
    }else{
        text_box.value += x;
    }
  }
  if(x=='.')
  {
      if(text_box.value.indexOf(".") >= 0){
      } else {
          text_box.value += '.';
    }
  }
}
function number_clear()
{
  document.getElementsByClassName("price_field")[0].value = '';
}
function number_c()
{
  var text_box = document.getElementsByClassName("price_field")[0];
  var num = text_box.value;
  var num1 = num%10;
  num -= num1;
  num /= 10;
  text_box.value = num;
}
function number_negative()
{
  var text_box = document.getElementsByClassName("price_field")[0];
  var num = text_box.value;
  text_box.value = -num;
}





function qty_write(x)
{
  var text_box = document.getElementsByClassName("qty_field")[0];
  if(x>=0 && x<=9)
  {
    if(isNaN(text_box.value))
        text_box.value = 0;
    
    if(x>0 && x<=9 && text_box.value == '0'){
    
        text_box.value = "";
        text_box.value += x;
        
    }else if(x==0 && text_box.value == '0'){
        text_box.value = "0";
    }else if(x == '00' && text_box.value == '0'){
        x = "";
        text_box.value = "0";
    }else{
        text_box.value += x;
    }
  }
  if(x=='.')
  {
      if(text_box.value.indexOf(".") >= 0){
      } else {
          text_box.value += '.';
    }
  }
}
function qty_clear()
{
  document.getElementsByClassName("qty_field")[0].value = '';
}
function qty_c()
{
  var text_box = document.getElementsByClassName("qty_field")[0];
  var num = text_box.value;
  var num1 = num%10;
  num -= num1;
  num /= 10;
  text_box.value = num;
}
function qty_negative()
{
  var text_box = document.getElementsByClassName("qty_field")[0];
  var num = text_box.value;
  text_box.value = -num;
}
/** NUMBER PAD SETTINGS END **/

$(".show_numpad").click(function(){
    $(".numpad").toggle();
    $(".price_block").toggleClass('numpad_active');
    $(".price_block").position({
        my: "left+60 bottom+90",
        using: function( position ) {
            $( this ).animate( position );
        }
    });
    $(".qty_block").toggleClass('numpad_active');
    $(".qty_block").position({
        my: "left+60 bottom+90",
        using: function( position ) {
            $( this ).animate( position );
        }
    });
    $(".discount_block").toggleClass('numpad_active');
    $(".discount_block").position({
        my: "left+860 bottom+10",
        using: function( position ) {
            $( this ).animate( position );
        }
    });
    return false;
});
var priceEdit = "discount";
var priceEditAll = "discount";
$(document).on("click","#set-discount",function(){
    $(this).addClass("active");
    $("#set-unit-price").removeClass("active");
    $(".numpad_text").val("");
    $(".numpad_text").attr({'id':'item-discount'});
    $(".numpad_text").attr({'placeholder':'E.g. 20% or 20'});
    $("#text-top").text("Apply discount percentage");
    priceEdit = "discount";
});
$(document).on("click","#set-discount-all",function(){
    $(this).addClass("active");
    $("#set-unit-price-all").removeClass("active");
    $(".numpad_text").val("");
    $(".numpad_text").attr({'id':'item-discount'});
    $(".numpad_text").attr({'placeholder':'E.g. 20% or 20'});
    $("#text-top").text("Apply discount percentage");
    priceEditAll = "discount";
});

$(document).on("click","#set-unit-price",function(){
    $(this).addClass("active");
    $("#set-discount").removeClass("active");
    $(".numpad_text").val("");
    $(".numpad_text").attr({'id':'item-unit-price'});
    $(".numpad_text").attr({'placeholder':'E.g. 2.50'});
    $("#text-top").text("Edit unit price");
    priceEdit = "price";
});
$(document).on("click","#set-unit-price-all",function(){
    $(this).addClass("active");
    $("#set-discount-all").removeClass("active");
    $(".numpad_text").val("");
    $(".numpad_text").attr({'id':'item-unit-price'});
    $(".numpad_text").attr({'placeholder':'E.g. 2.50'});
    $("#text-top").text("Edit unit price");
    priceEditAll = "price";
});


$(document).on("click",".price-control",function(event){
    $(".price-form").attr({"data-id":$(this).attr("data-id")});
    if(($(this).position().top + 136) == $(".price_block").position().top){
        $(".price_block").hide();
        $(".price_block").removeClass("price_block_active");
    } else if(($(this).position().top + 135) == $(".price_block").position().top){
        $(".price_block").hide();
        $(".price_block").removeClass("price_block_active");
    } else {
        $(".price_block").show();
        $(".qty_block").hide();
        $(".numpad_text").focus();
        $(".numpad_text").val("");
        $(".price_block").addClass("price_block_active");
        if($(".price_block").hasClass("numpad_active")){
        
            if($(this).position().top < 120){
                
                $(".price_block").position({
                    my: "left+70 bottom+61",
                    of: $(this),
                    using: function( position ) {
                        $( this ).animate( position );
                    }
                });
                
            } else {
            
                $(".price_block").position({
                    my: "left+70 bottom+325",
                    of: $(this),
                    using: function( position ) {
                        $( this ).animate( position );
                    }
                });
                
            }
        } else {
            $(".price_block").position({
                my: "left+70 bottom+110",
                of: $(this),
                using: function( position ) {
                    $( this ).animate( position );
                }
            });
        }
    }

});
$(document).on('submit',".price-form",function(){
    if(priceEdit == 'price') {
        $("a[data-id="+$(this).attr("data-id")+"]").text("@"+parseFloat($(".price_field").val()).toFixed(2));
    } else {
        var currentPrice = $("a[data-id="+$(this).attr("data-id")+"]").text().replace(/@/,'');
        var toDiscount = currentPrice * $(".price_field").val().replace(/%/,"") / 100;
        $("a[data-id="+$(this).attr("data-id")+"]").text("@"+ parseFloat(currentPrice - toDiscount).toFixed(2));
    }
    $(".price_block").hide();
    return false;
});

$(document).on('submit',".discount-form",function(){
    if(priceEditAll == 'price') {
        $(".price-control").each(function(){
            var currentPrice = $(this).text().replace(/@/,'');
            var toDiscount = $(".discount_field").val();
            $(this).text('@'+parseFloat(currentPrice - toDiscount).toFixed(2));
        });
    } else {
        $(".price-control").each(function(){
            var currentPrice = $(this).text().replace(/@/,'');
            var toDiscount = currentPrice * $(".discount_field").val().replace(/%/,"") / 100;
            $(this).text('@'+parseFloat(currentPrice - toDiscount).toFixed(2));
        });
    }
    $(".discount_block").hide();
    return false;
});


$(document).on("click",".qty-control",function(event){
    $(".qty-form").attr({"data-id":$(this).attr("qty-id")});
    if(($(this).position().top + 169) == $(".qty_block").position().top){
        $(".qty_block").hide();
        $(".qty_block").removeClass("qty_block_active");
    } else if(($(this).position().top + 171) == $(".qty_block").position().top){
        $(".qty_block").hide();
        $(".qty_block").removeClass("qty_block_active");
    } else {
        $(".qty_block").show();
        $(".price_block").hide();
        $(".numpad_text").focus();
        $(".numpad_text").val("");
        $(".qty_block").addClass("qty_block_active");
        if($(".qty_block").hasClass("numpad_active")){
            if($(this).position().top < 80){
                $(".qty_block").position({
                    my: "left+32 bottom+25",
                    of: $(this),
                    using: function( position ) {
                        $( this ).animate( position );
                    }
                });
            } else {
                $(".qty_block").position({
                    my: "left+32 bottom+289",
                    of: $(this),
                    using: function( position ) {
                        $( this ).animate( position );
                    }
                });
            }
        } else {
            $(".qty_block").position({
                my: "left+32 bottom+71",
                of: $(this),
                using: function( position ) {
                    $( this ).animate( position );
                }
            });
        }
    }
});
$(".qty-form").submit(function(){
    $("a[qty-id="+$(this).attr("data-id")+"]").text(parseInt($(".qty_field").val()));
    $(".qty_block").hide();
    return false;
});

$(document).on("click",".discount",function(event){
    $(".discount-form").attr({"data-id":$(this).attr("data-id")});
    if(($(this).position().top + 136) == $(".discount_block").position().top){
        $(".discount_block").hide();
        $(".discount_block").removeClass("discount_block_active");
    } else if(($(this).position().top + 135) == $(".discount_block").position().top){
        $(".discount_block").hide();
        $(".discount_block").removeClass("discount_block_active");
    } else {
        $(".discount_block").show();
        $(".price_block").hide();
        $(".qty_block").hide();
        $(".numpad_text").focus();
        $(".numpad_text").val("");
        $(".discount_block").addClass("pdiscount_block_active");
        if($(".discount_block").hasClass("numpad_active")){
            $(".discount_block").position({
                my: "left-83 bottom+255",
                of: $(this),
                using: function( position ) {
                    $( this ).animate( position );
                }
            });
        } else {
            $(".discount_block").position({
                my: "left-83 bottom+155",
                of: $(this),
                using: function( position ) {
                    $( this ).animate( position );
                }
            });
        }
    }
});
</script>