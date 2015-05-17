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
                <div class="pull-left col-md-9 col-xs-9 col-sm-9 col-alpha col-omega">
                    <h2>
                        Perform Inventory Count
                    </h2>
                    <h4 class="col-lg-5 col-md-6 col-xs-12 col-sm-7 col-alpha"><?php echo $stockTake['MerchantStockTake']['name']; ?></h4>
                    <h5 class="col-lg-7 col-md-6 col-xs-12 col-sm-5 col-alpha col-omega"><?php echo ($stockTake['MerchantStockTake']['full_count'] == '1') ? 'Full Count' : 'Partial Count'; ?></h5>
                    <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                        <h5 class="col-lg-4 col-md-5 col-xs-12 col-sm-6 col-alpha col-omega">
                            <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                            Start: <?php echo date('d M Y, g:m A', strtotime($stockTake['MerchantStockTake']['start_date'])); ?>
                        </h5>
                        <h5 class="col-lg-8 col-md-7 col-xs-12 col-sm-6 col-alpha col-omega">
                            <span class="glyphicon glyphicon-map-marker"></span>&nbsp;
                            <?php echo $stockTake['MerchantOutlet']['name']; ?>
                        </h5>
                    </div>
                    <div class="col-md-12 col-xs-12 col-sm-12 col-alpha count-input">
                        <div id="search-items-wrapper" class="col-md-6 col-xs-6 col-sm-6 col-alpha">
                            <input type="text" id="search-items" placeholder="Type to search for products">
                        </div>
                        <div id="item-qty-wrapper" class="col-md-3 col-xs-3 col-sm-3 col-alpha">
                            <input type="text" id="item-qty" class="btn-left" value="1" style="width:50%;">
                            <button id="count-inventory" class="btn btn-success btn-right" style="width:50%;" disabled>Count</button>
                        </div>
                        <div class="col-md-3 col-xs-3 col-sm-3 col-alpha">
                            <input type="checkbox" value="1" id="quick-scan-mode">
                            <label for="quick-scan-mode">Quick-scan mode</label>
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                        <div class="inventory-content">
                            <div class="inventory-tab">
                                <ul>
                                    <li id="inventory-tab-all" class="active">All</li>
                                    <li id="inventory-tab-counted">Counted (<span class="counted-no">0</span>)</li>
                                    <li id="inventory-tab-uncounted">Uncounted (<span class="uncounted-no">0</span>)</li>
                                </ul>
                            </div>
                            <div class="inventory-Due">
                                <table id="productTable" class="table-bordered dataTable">
                                    <colgroup>
                                        <col width="70%">
                                        <col width="15%">
                                        <col width="15%">
                                    </colgroup>
                                    <thead>
                                        <tr role="row">
                                            <th>PRODUCT</th>
                                            <th>EXPECTED</th>
                                            <th>COUNT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!--
                                        <?php foreach ($stockTake['MerchantStockTakeItem'] as $item): ?>
                                        <tr role="row" class="odd product-list" data-id="<?php echo $item['product_id']; ?>">
                                            <td><?php echo $item['name']; ?>
                                                <h6 class="inline-block-z margin-left-10"><?php echo $item['sku']; ?></h6>
                                            </td>
                                            <td>
                                                <?php
                                                    echo isset($item['MerchantProduct']['MerchantProductInventory'][0]['count'])
                                                        ? $item['MerchantProduct']['MerchantProductInventory'][0]['count']
                                                        : '0';
                                                ?>
                                            </td>
                                            <td class="product-list-count">0</td>
                                        </tr>
                                        <?php endforeach; ?>
                                        -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 pull-right margin-top-20 margin-bottom-20">
                        <button class="btn btn-primary pull-right">Review Count</button>
                        <button class="btn btn-default pull-right margin-right-10">Pause Count</button>
                    </div>
                </div>
                <div class="pull-right col-md-3 col-xs-3 col-sm-3 col-omega margin-top-20">
                    <div class="last-counted">
                        <h4>Your last counted items</h4>
                        <div class="last-counted-list">
                        </div>
                    </div>
                </div>
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
var quickScanMode = false;
var stockTakeCounts = [];
var stockTakeItems = [];
var selectedTab = 'all';

jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    Index.init();
    getStockTakeItems();

    $("#search-items").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "/stock/searchProduct.json",
                method: "POST",
                dataType: "json",
                data: {
                    q: request.term
                },
                success: function (data) {
                    response($.map(data.products, function (item) {
                        if (!item.MerchantProduct.is_active)
                            return;
                        return {
                            label: item.MerchantProduct.name,
                            value: item.MerchantProduct.id,
                            sku: item.MerchantProduct.sku
                        }
                    }));
                }
            });
        },
        minLength: 2,
        select: function( event, ui ) {
            event.preventDefault();

            $(this).val(ui.item.label);
            $(this).attr('data-id', ui.item.value);
            $('#count-inventory').removeAttr("disabled");
            //$('#productTable tbody').append('<tr><td>'+ui.item.label+'<h6>'+ui.item.sku+'</h6></td></tr>');

            return false;
        },
        focus: function( event, ui ) {
            event.preventDefault();
        }
    });

    $("#quick-scan-mode").change(function() {
        $("#item-qty-wrapper").toggle();

        if ($("#item-qty-wrapper").is(':visible')) {
            $("#search-items-wrapper").attr('class','col-md-6 col-xs-6 col-sm-6 col-alpha');
        } else {
            $("#search-items-wrapper").attr('class','col-md-9 col-xs-9 col-sm-9 col-alpha');
        }
        $("#search-items").removeAttr("data-id");
        $("#search-items").val('');

        quickScanMode = $("#quick-scan-mode").attr('checked') == 'checked';
    });

    $("#search-items").keypress(function(e) {
        var key = event.keyCode || event.which;

        if (key == 13 && quickScanMode && $(this).attr("data-id")) {
        } else {
            $('#count-inventory').attr("disabled", "disabled");
        }
    });

    $("#count-inventory").click(function(e) {
    });

    $("#inventory-tab-all").click(function(){
        $(".inventory-tab").find(".active").removeClass("active");
        $(this).addClass("active");

        selectedTab = 'all';
        updateView();
    });

    $("#inventory-tab-counted").click(function(){
        $(".inventory-tab").find(".active").removeClass("active");
        $(this).addClass("active");

        selectedTab = 'counted';
        updateView();
    });

    $("#inventory-tab-uncounted").click(function(){
        $(".inventory-tab").find(".active").removeClass("active");
        $(this).addClass("active");

        selectedTab = 'uncounted';
        updateView();
    });

    /*
    $(document).on("keyup","#search-items",function(event){
        var key = event.keyCode || event.which;
        if (key === 13) {
            if($(this).attr("data-id") && !$("#item-qty-wrapper").is(':visible')) {
                $(".last-counted-list").prepend('<ul class="added-item" data-id="'+$("#search-items").attr("data-id")+'"><li class="pull-left"><span class="added-item-qty">'+1+'</span> '+$("#search-items").val()+'</li><li class="pull-right"><span class="remove inline-block"><span class="glyphicon glyphicon-remove"></span></span></li></ul>');
            }
        } else {
            $(this).removeAttr("data-id");
        }
    });

    var item_qty = 1;
    $("#count-inventory").click(function(){
        if($("#item-qty-wrapper").is(':visible')){
            item_qty = $("#item-qty").val();
        }
        $(".last-counted-list").prepend('<ul class="added-item" data-id="'+$("#search-items").attr("data-id")+'"><li class="pull-left"><span class="added-item-qty">'+item_qty+'</span> '+$("#search-items").val()+'</li><li class="pull-right"><span class="remove inline-block"><span class="glyphicon glyphicon-remove"></span></span></li></ul>');
    });

    $(document).on("click", ".remove", function(){
        $(this).parents('ul').remove();
    });
    */
});

function getStockTakeItems() {
    $.ajax({
        url: "/inventory_count/<?php echo $stockTake['MerchantStockTake']['id']; ?>/items.json",
        method: "POST",
        dataType: "json",
        success: function (data) {
            if (data.success) {
                stockTakeItems = data.items;
                updateView();
            } else {
                alert(data.message);
                console.log(data.message);
            }
        }
    });
}

function updateData(product) {
}

function updateView() {
    var counted = 0;
    var uncounted = 0;

    $("#productTable").find('tbody').empty();

    for (var key in stockTakeItems) {
        if (stockTakeItems[key]['counted'] > 0) {
            counted++;

            if (selectedTab == 'uncounted') {
                continue;
            }
        } else {
            uncounted++;

            if (selectedTab == 'counted') {
                continue;
            }
        }

        var appendString = '';
        appendString = '<tr role="row" class="odd product-list" data-id="' + stockTakeItems[key]['id'] + '">';
        appendString += '<td>' + stockTakeItems[key]['name'];
        appendString += '<h6 class="inline-block-z margin-left-10">' + stockTakeItems[key]['sku'] + '</h6></td>';
        appendString += '<td class="product-list-expected">' + stockTakeItems[key]['expected'] + '</td>';
        appendString += '<td class="product-list-count">' + stockTakeItems[key]['counted'] + '</td>';
        appendString += '</tr>';
        $("#productTable").find('tbody').append(appendString);
    }
    $(".counted-no").text(counted);
    $(".uncounted-no").text(uncounted);
}

/*
$(document).on("click", function(){
    $(".product-list-count").text('0');
    $(".added-item").each(function(){
        var current_count = $("tbody").find("tr[data-id="+$(this).attr("data-id")+"]").find(".product-list-count").text();
        var to_add = $(this).find(".added-item-qty").text();
        $("tbody").find("tr[data-id="+$(this).attr("data-id")+"]").find(".product-list-count").text(parseInt(current_count) + parseInt(to_add));
    });
    update_product_status();
    validate();
});

$(document).on("keyup", function(){
    validate();
    update_product_status();
});

function update_product_status() {
    var count_counted = 0;
    var count_uncounted = 0;
    $(".product-list-count").each(function(){
        if($(this).text() == 0){
            $(this).parent().addClass("uncounted-product");
            count_uncounted++;
        } else {
            $(this).parent().addClass("counted-product");
            count_counted++;
        }
    });
    $(".counted-no").text(count_counted);
    $(".uncounted-no").text(count_uncounted);
    
    if($(".inventory-tab").find(".active").attr("id") == 'inventory-tab-counted') {
        $(".product-list").hide();
        $(".counted-product").show();
    } else if ($(".inventory-tab").find(".active").attr("id") == 'inventory-tab-uncounted') {
        $(".product-list").hide();
        $(".uncounted-product").show();
    } else {
        $(".product-list").show();
    }
}

function validate() {
    if($("#search-items").attr("data-id") && $("#item-qty").val().length > 0 && $.isNumeric($("#item-qty").val())){
        $("#count-inventory").removeAttr("disabled");
    } else {
        $("#count-inventory").attr("disabled","disabled");
    }
}

function merge_array() {
    var stockTakeItems = [];
    $(".added-item").each(function(){
        stockTakeItems.push({'qty':$(this).find(".added-item-qty").text(),'product_id':$(this).attr("data-id")});
    });
}
*/
</script>
<!-- END JAVASCRIPTS -->
