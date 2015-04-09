
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
                <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">Receive Stock Order</h2>
                <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20">
                    <a href="/stock/editDetails/<?php echo $order['MerchantStockOrder']['id']; ?>"><button id="import" class="btn btn-white pull-right" style="color:black">
                    <div class="glyphicon glyphicon-edit"></div>&nbsp;Edit Order Details</button></a>
                </div>
            </div>
                        
            <div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">Details</div>
                
            <div class="line-box line-box-content col-md-12 col-sm-12 col-xs-12">
                <div class="col-md-6">
                    <dl>
                        <dt>Order name</dt>
                        <dd>
                            <?php echo $order['MerchantStockOrder']['name']; ?>
                        </dd>
                        <dt>Order from</dt>
                        <dd>
                            <?php
                                if ($order['MerchantStockOrder']['type'] == 'SUPPLIER') {
                                    echo is_null($order['MerchantSupplier']['name']) ? 'Any' : $order['MerchantSupplier']['name'];
                                } elseif ($order['MerchantStockOrder']['type'] == 'OUTLET') {
                                    echo is_null($order['MerchantSourceOutlet']['name']) ? 'Any' : $order['MerchantSourceOutlet']['name'];
                                }
                             ?>
                        </dd>
                        <dt>Deliver to</dt>
                        <dd>
                            <?php echo $order['MerchantOutlet']['name']; ?> 
                        </dd>
                    </dl>
                </div>
                <div class="col-md-6">
                    <dl>
                        <dt>Due at</dt>
                        <dd>
                            <?php echo date('d F Y', strtotime($order['MerchantStockOrder']['due_date'])); ?>
                        </dd>
                        <dt>Supplier invoice</dt>
                        <dd>
                            <?php echo $order['MerchantStockOrder']['supplier_invoice']; ?>
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">Order Products</div>
                <form id="stock_order_item_form">
                <div class="line-box line-box-content col-md-12 col-sm-12 col-xs-12 col-alpha col-omega">
                <div class="col-md-12 col-sm-12 col-xs-12 order-product-header col-alpha col-omega">
                    <div class="col-md-7 col-alpha">
                        <input type="search" placeholder="Search Products" id="product_search" autocomplete="off">
                    </div>
                    <div class="col-md-1 col-alpha">
                        <input type="number" id="product_quantity" placeholder="1" >
                    </div>
                    <div class="col-md-4 col-alpha">
                        <button type="button" class="btn btn-default add-order-item">Add</button>
                    </div>
                    <div class="search_result" style="display:none;">
                        <span class="search-tri"></span>
                        <div class="search-default"> No Result </div>
                        <?php foreach($products as $product){ ?>
                        <?php
                            if ( isset($product['MerchantProductInventory'][0]['count']) ):
                                if ( is_null($product['MerchantProductInventory'][0]['count']) ):
                                    $inventoryCount = '0';
                                else:
                                    $inventoryCount = $product['MerchantProductInventory']['count'];
                                endif;
                            else:
                                $inventoryCount = '0';
                            endif;
                        ?>
                        <!--<button type="button" data-stock="0" data-order-id="<?=$order['MerchantStockOrder']['id'];?>" data-name="<?=$product['MerchantProduct']['name'];?>" data-sku="<?=$product['MerchantProduct']['sku'];?>" data-id="<?=$product['MerchantProduct']['id'];?>" data-price-include-tax="<?=$product['MerchantProduct']['price_include_tax'];?>" class="data-found"><?=$product['MerchantProduct']['name']." (".$product['MerchantProduct']['sku'].")";?></button>-->
                        <button type="button" data-stock="0" data-order-id="<?=$order['MerchantStockOrder']['id'];?>" data-name="<?=$product['MerchantProduct']['name'];?>" data-sku="<?=$product['MerchantProduct']['sku'];?>" data-id="<?=$product['MerchantProduct']['id'];?>" data-price-include-tax="<?=$product['MerchantProduct']['price_include_tax'];?>" data-inventory-count="<?php echo $inventoryCount; ?>" data-supply-price="<?php echo $product['MerchantProduct']['supply_price']; ?>" class="data-found"><?=$product['MerchantProduct']['name']." (".$product['MerchantProduct']['sku'].")";?></button>
                        <?php } ?> 
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <table class="dataTable table-bordered">
                        <colgroup>
                            <col width="10%">
                            <col width="35%">
                            <col width="15%">
                            <col width="10%">
                            <col width="15%">
                            <col width="15%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Product</th>
                                <th>Stock on Hand</th>
                                <th>Quantity</th>
                                <th>Received</th>
                                <th>Supply Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <input type="hidden" name="data[MerchantStockOrder][id]" value="<?php echo $order['MerchantStockOrder']['id']; ?>">
                            <?php
                                if ( count($order['MerchantStockOrderItem']) > 0 ):
                                    foreach ($order['MerchantStockOrderItem'] as $idx => $item):
                            ?>
                            <input type="hidden" name="data[MerchantStockOrderItem][<?php echo $idx; ?>][id]" value="<?php echo $item['id']; ?>" />
                            <input type="hidden" name="data[MerchantStockOrderItem][<?php echo $idx; ?>][order_id]" value="<?php echo $item['order_id']; ?>" />
                            <input type="hidden" name="data[MerchantStockOrderItem][<?php echo $idx; ?>][product_id]" value="<?php echo $item['product_id']; ?>" />
                            <tr>
                                <!--
                                <input type="hidden" name="data[MerchantStockOrderItem][<?php echo $idx; ?>][supply_price]" value="<?php echo $item['MerchantProduct']['supply_price']; ?>" />
                                -->
                                <input type="hidden" name="data[MerchantStockOrderItem][<?php echo $idx; ?>][price_include_tax]" value="<?php echo $item['MerchantProduct']['price_include_tax']; ?>" />
                                <td><?php echo $idx+1; ?></td>
                                <td><?php echo $item['MerchantProduct']['name']; ?></td>
                                <td>
                                    <?php
                                        if ( isset($item['MerchantProduct']['MerchantProductInventory'][0]['count']) ):
                                            echo $item['MerchantProduct']['MerchantProductInventory'][0]['count'];
                                        else:
                                            echo '0';
                                        endif;
                                    ?>
                                </td>
                                <td><?php echo $item['count']; ?></td>
                                <td>
                                    <?php
                                        $default = is_null($item['received']) ? $item['count'] : $item['received'];
                                        $received = $this->Form->input('MerchantStockOrderItem.' . $idx . '.received', array(
                                            'type' => 'text',
                                            'div'  => false,
                                            'label' => false,
                                            'class' => 'changable',
                                            'value' => $default
                                        ));
                                        echo $received;
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        $supplyPrice = $this->Form->input('MerchantStockOrderItem.' . $idx . '.supply_price', array(
                                            'type' => 'text',
                                            'div'  => 'false',
                                            'label' => false,
                                            'class' => 'changable',
                                            'value' => sprintf("%.2f", round($this->request->data['MerchantStockOrderItem'][$idx]
                                            ['supply_price'], 2))
                                        ));     
                                        echo $supplyPrice;
                                    ?>
                                </td>
                                <td><?php echo sprintf("%.2f", round($item['count'] * $item['supply_price'], 2)); ?></td>
                            </tr>
                            <?php
                                    endforeach;
                                else:
                            ?>
                            <tr>
                                <td colspan="7">There are no products in this consignment order yet.</td>
                            </tr>
                            <?php
                                endif;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 pull-right margin-top-20 margin-bottom-20">
                <button class="btn btn-primary pull-right save-and-receive">Save and Receive</button>
                <button class="btn btn-primary btn-wide pull-right save margin-right-10">Save</button>
                <button class="btn btn-default btn-wide pull-right margin-right-10 cancel">Cancel</button>
            </div>
            </form>
                    
        </div>
    </div>
    <!-- END CONTENT -->
    <!-- Save&Send POPUP BOX -->
    <div class="confirmation-modal modal fade in save_receive" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="confirm-close close-pop" data-dismiss="modal" aria-hidden="true">
                    <i class="glyphicon glyphicon-remove"></i>
                    </button>
                    <h4 class="modal-title">Send order</h4>
                </div>
                <form id="confirmation-email-form">
                <input type="hidden" name="data[MerchantStockOrder][id]" value="<?php echo $order['MerchantStockOrder']['id']; ?>" />
                <div class="modal-body margin-bottom-20">
                    <dl>
                        <dt>Recipient name</dt>
                        <dd><input type="text" name="data[recipient_name]"></dd>
                        <dt>Email</dt>
                        <dd><input type="text" name="data[email]"></dd>
                        <dt>CC</dt>
                        <dd><input type="text" name="data[cc]"></dd>
                        <dt>Subject</dt>
                        <dd><input type="text" name="data[subject]"></dd>
                        <dt>Message</dt>
                        <dd><textarea col="2" name="data[message]"></textarea></dd>
                    </dl>
                </div>
                <div class="modal-footer">
                    <button class="close-pop btn btn-primary btn-wide" type="button" data-dismiss="modal">Cancel</button>
                    <button class="confirm btn btn-success btn-wide modal-send" type="button" data-dismiss="modal">Send</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Save&Send POPUP BOX END -->

   <!-- BEGIN QUICK SIDEBAR -->
    <a href="javascript:;" class="page-quick-sidebar-toggler"><i class="icon-close"></i></a>
    <div class="page-quick-sidebar-wrapper">
        <div class="page-quick-sidebar">            
            <div class="nav-justified">
                <ul class="nav nav-tabs nav-justified">
                    <li class="active">
                        <a href="#quick_sidebar_tab_1" data-toggle="tab">
                        Users <span class="badge badge-danger">2</span>
                        </a>
                    </li>
                    <li>
                        <a href="#quick_sidebar_tab_2" data-toggle="tab">
                        Alerts <span class="badge badge-success">7</span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        More<i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <li>
                                <a href="#quick_sidebar_tab_3" data-toggle="tab">
                                <i class="icon-bell"></i> Alerts </a>
                            </li>
                            <li>
                                <a href="#quick_sidebar_tab_3" data-toggle="tab">
                                <i class="icon-info"></i> Notifications </a>
                            </li>
                            <li>
                                <a href="#quick_sidebar_tab_3" data-toggle="tab">
                                <i class="icon-speech"></i> Activities </a>
                            </li>
                            <li class="divider">
                            </li>
                            <li>
                                <a href="#quick_sidebar_tab_3" data-toggle="tab">
                                <i class="icon-settings"></i> Settings </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
<!-- END QUICK SIDEBAR -->
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
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script>
<script src="/assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script>
<!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
<script src="/assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<script src="/assets/global/plugins/gritter/js/jquery.gritter.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="/assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="/assets/admin/pages/scripts/index.js" type="text/javascript"></script>
<script src="/assets/admin/pages/scripts/tasks.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<script src="/js/dataTable.js" type="text/javascript"></script>
<script>

jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    QuickSidebar.init() // init quick sidebar
    Index.init();

    $(".datepicker").datepicker({ dateFormat: 'yy-mm-dd' });

    $(document).on('click','.save',function(e){
        e.preventDefault();
        $.ajax({
            //url: '/stock/receive.json',
            url: "/stock/saveItems.json",
            method: "POST",
            data: $('#stock_order_item_form').serialize(),
            error: function ( jqXHR, textStatus, errorThrown ) {
            },
            success: function( data, textStatus, jqXHR ) {
                if (data.success) {
                    location.href = "/stock/receive/<?php echo $order['MerchantStockOrder']['id']; ?>";
                } else {
                    alert(data.message);
                    console.log(data.message);
                }
            }
        });
    });

    // 'save and receive' button click ...
    $(document).on('click', '.save-and-receive', function(e) {
        e.preventDefault();
        $.ajax({
            //url: "/stock/saveReceivedItems.json",
            url: "/stock/saveItems.json",
            method: "POST",
            data: $('#stock_order_item_form').serialize(),
            error: function( jqXHR, textStatus, errorThrown ) {
            },
            success: function( data, textStatus, jqXHR ) {
                if (data.success) {
                    $('.save_receive').show();
                } else {
                    alert(data.message);
                    console.log(data.message);
                }
            }
        });

        return false;
    });

    // modal ...
    $(".close-pop").click(function() {
        $(".confirmation-modal").hide();
    });
    $(".confirm").click(function(e) {
        e.preventDefault();

        $.ajax({
            url: "/stock/sendReceive.json",
            method: "POST",
            data: $('#confirmation-email-form').serialize(),
            error: function( jqXHR, textStatus, errorThrown ) {
            },
            success: function( data, textStatus, jqXHR ) {
                if (data.success) {
                    window.location.href = "/stock/view/<?php echo $order['MerchantStockOrder']['id']; ?>";
                } else {
                    $('.save_receive').hide();
                    //alert(data.message);
                    console.log(data.message);
                }
            }
        });

        return false;
    });
   
    $(".cancel").click(function(){
        parent.history.back();
    });
    
    /* DYNAMIC PROUCT SEARCH START */
    
    var $cells = $(".data-found");
    $(".search_result").hide();

    $(document).on("keyup","#product_search",function() {
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
            if($(".search_result").height() == 0){
                $(".search-default").show();
            }
        }
        $cells.click(function(){
           $("#search").val($(this).text());
        });
    });
    
    var selectedProductName;
    var selectedProductStock;
    var selectedProductId;
    var selectedOrderId;
    var selectedProductPriceIncludeTax;
    var selectedProductSku;
    $(".data-found").click(function(){
        $("#product_search").val($(this).attr("data-name"));
        $(".search_result").hide();
        selectedProductName = $(this).attr("data-name");
        selectedProductStock = $(this).attr("data-stock");
        selectedProductId = $(this).attr("data-id");
        selectedOrderId = $(this).attr("data-order-id");
        selectedProductPriceIncludeTax = $(this).attr("data-price-include-tax");
        selectedProductSku = $(this).attr("data-sku");
    });
    
    
    $(document).on("click",".add-order-item",function(){
        if(!selectedProductId == ""){
            if($("tr[data-id="+selectedProductId+"]").length == 0){
                // next index
                var nextIdx = $('.dataTable tbody tr').length;
                $(".dataTable").children("tbody").append('<tr data-id="'+selectedProductId+'" class="added-order"><input type="hidden" name="data[MerchantStockOrderItem]['+nextIdx+'][order_id]" value="'+selectedOrderId+'"><input type="hidden" name="data[MerchantStockOrderItem]['+nextIdx+'][product_id]" value="'+selectedProductId+'"><input type="hidden" name="data[MerchantStockOrderItem]['+nextIdx+'][name]" value="'+selectedProductName+'"><input type="hidden" name="data[MerchantStockOrderItem]['+nextIdx+'][price_include_tax]" value="'+selectedProductPriceIncludeTax+'"><td>'+(nextIdx+1)+'</td><td>'+selectedProductName+'</td><td>'+selectedProductSku+'</td><td>'+$("#product_quantity").val()+'</td><td><input name="data[MerchantStockOrderItem]['+nextIdx+'][received]" placeholder="0" maxlength="11" type="text" value="'+$("#product_quantity").val()+'"></td><td><input name="data[MerchantStockOrderItem]['+nextIdx+'][supply_price]" placeholder="0.00000" maxlength="15,5" type="text"></td><td>0<span class="remove inline-block pull-right"><span class="glyphicon glyphicon-remove"></span></span></td></tr>');
            } else {
                //$("tr[data-id="+selectedProductId+"]").find("#MerchantStockOrderItem0Count").val(function(i, oldval){
                $("tr[data-id="+selectedProductId+"]").find("input[name*=count]").val(function(i, oldval){
                    return parseInt($("#product_quantity").val(),10) + parseInt(oldval, 10);
                });
            }
            $(".order-null").hide();
            $("#product_search").val('');
            selectedProductId = '';
        }

        $('#product_quantity').val('1');
    });
    $(document).on('click','.remove',function(){
        $(this).parents("tr:first").remove();
        if($(".added-order").length == 0){
            $(".order-null").show();
        }
    });

    $(document).on("blur", ".changable", function() {
        var received = $(this).closest('tr').children().find('input[name*=received]').val();
        var supply_price = $(this).closest('tr').children().find('input[name*=supply_price]').val();
            supply_price = (Math.round(supply_price*100)/100).toFixed(2);
        var total = (Math.round(parseFloat(received * supply_price)*100)/100).toFixed(2);

        $(this).closest('tr').find('td:last').text(total);
    });

    /* DYNAMIC PRODUCT SEARCH END */
});
</script>
<!-- END JAVASCRIPTS -->