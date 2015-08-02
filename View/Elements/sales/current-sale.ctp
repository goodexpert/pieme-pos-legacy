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
        <div class="col-lg-6 col-md-6 col-xs-6 col-sm-6 customer-search col-omega col-alpha">
            <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                <div class="col-md-9 col-xs-9 col-sm-9 col-alpha col-omega">
                    <input type="search" id="customer_search" class="search" placeholder="Customer Search">
                    <div class="search_result" style="display:none;">
                        <span class="search-tri"></span>
                        <div class="search-default"> No Result</div>
                        <button type="button"
                            data-id="aaaa"
                            data-name=""
                            data-balance=""
                            data-group-id=""
                            class="data-found customer_apply">
                            <span>William Lee (BNZ0001)<br>$20.00</span>
                        </button>
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
                    <button class="btn btn-primary park">Save</button>
                </div>
                <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4 col-omega col-alpha">
                    <button class="btn btn-primary void">Cancel</button>
                </div>
                <div class="col-lg-4 col-md-4 col-xs-4 col-sm-4 col-omega col-alpha">
                    <button class="btn btn-primary discount">Discount</button>
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
                <input type="button" value="PAYMENT" id="pay" class="btn">
            </div>
            <div class="receipt-bt"></div>
        </div>
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
    <div id="block-right" class="col-md-12 col-xs-12 col-sm-12 quick-key-body" style="height: 100%;">
        <ul class="nav nav-tabs">
            <li position="" class="active" role="presentation">
                <a href="#" class="">replace</a>
            </li>
        </ul>
        <div class="quick-key-list">
            <ul id="sortable" class="ui-sortable">
            </ul>
        </div>
        <div class="quick-key-list product-found-list" style="display: none;">
            <ul id="sortable" class="ui-sortable">
            </ul>
        </div>
        <div class="quick-key-list-footer">
            <span class="pull-left clickable prev"><i class="glyphicon glyphicon-chevron-left"></i></span>
            <span class="pull-right clickable next"><i class="glyphicon glyphicon-chevron-right"></i></span>
            <span rel="" class="page clickable">1</span>
        </div>
    </div>
</div>

<script>
var Database = function() {
    // initializes 
    var handleInit = function() {
    }

    return {
        // Initiate the register
        init: function() {
            handleInit(); // initialize core variables
        }
    };
} ();

var Register = function () {
    // initializes 
    var handleInit = function() {
        Database.init();
    }

    var synchronous = function() {
    }

    return {
        // Initiate the register
        init: function() {
            handleInit(); // initialize core variables
        }
    };
} ();
</script>
