<?php
    $filters = [];

    if (!empty($stocktake) && is_array($stocktake)) {
        if (isset($stocktake['MerchantStockTake']['filters']) &&
            !empty($stocktake['MerchantStockTake']['filters'])) {
            $filters = json_decode($stocktake['MerchantStockTake']['filters'], true);
        }
    }
?>
<div class="clearfix"></div>
<div id="notify"></div>
<!-- BEGIN CONTENT -->
<div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
  <div class="pull-left col-md-9 col-xs-9 col-sm-9 col-alpha col-omega">
    <h2>
      Perform Inventory Count
    </h2>
    <input type="hidden" id="id" value="<?php echo $stocktake['MerchantStockTake']['id']; ?>">
    <input type="hidden" id="outlet_id" value="<?php echo $stocktake['MerchantStockTake']['outlet_id']; ?>">
    <input type="hidden" id="show_inactive" value="<?php echo $stocktake['MerchantStockTake']['show_inactive']; ?>">
    <input type="hidden" id="full_count" value="<?php echo $stocktake['MerchantStockTake']['full_count']; ?>">
    <h4 class="col-lg-5 col-md-6 col-xs-12 col-sm-7 col-alpha"><?php echo $stocktake['MerchantStockTake']['name']; ?></h4>
    <h5 class="col-lg-7 col-md-6 col-xs-12 col-sm-5 col-alpha col-omega"><?php echo ($stocktake['MerchantStockTake']['full_count'] == '1') ? 'Full Count' : 'Partial Count'; ?></h5>

    <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
      <h5 class="col-lg-4 col-md-5 col-xs-12 col-sm-6 col-alpha col-omega">
        <span class="glyphicon glyphicon-calendar"></span>&nbsp;
        Start: <?php echo date('d M Y, g:m A', strtotime($stocktake['MerchantStockTake']['due_date'])); ?>
      </h5>
      <h5 class="col-lg-8 col-md-7 col-xs-12 col-sm-6 col-alpha col-omega">
        <span class="glyphicon glyphicon-map-marker"></span>&nbsp;
        <?php echo $stocktake['MerchantStockTake']['outlet_name']; ?>
      </h5>
    </div>
    <div class="col-md-12 col-xs-12 col-sm-12 filter-selection">
      <?php foreach ($filters as $filter) : ?>
        <div class="filter-tag-group">
          <span class="filter-tag-group-title"><?php echo $filter['category']; ?>:</span>

          <div class="filter-tag-items">
                                <span class="filter-tag-item">
                                    <?php echo $filter['name']; ?>
                                </span>
          </div>
        </div>
      <?php endforeach; ?>
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
        <input type="checkbox" id="quick-scan-mode" value="1">
        <label for="quick-scan-mode">Quick-scan mode</label>
      </div>
    </div>
    <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
      <div class="inventory-content">
        <div class="inventory-tab">
          <ul>
            <li id="inventory-tab-all" class="active">All (<span class="inventory-tab-all-label">0</span>)</li>
            <li id="inventory-tab-counted">Counted (<span class="inventory-tab-counted-label">0</span>)</li>
            <li id="inventory-tab-uncounted">Uncounted (<span class="inventory-tab-uncounted-label">0</span>)</li>
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
                                        <?php foreach ($stocktake['MerchantStockTakeItem'] as $item): ?>
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
      <button class="btn btn-primary pull-right" onclick="review()">Review Count</button>
      <button class="btn btn-default pull-right margin-right-10" onclick="save()">Pause Count</button>
    </div>
  </div>
  <div class="pull-right col-md-3 col-xs-3 col-sm-3 col-omega margin-top-20">
    <div class="last-counted">
      <h4>Your last counted items</h4>

      <div class="last-counted-list" id="counted_list">
      </div>
    </div>
  </div>
</div>

<!-- END CONTENT -->
<div class="hidden-data">
  <input type="hidden" id="hidden-data1" value='<?php echo json_encode($stocktake['MerchantStockTakeItem']); ?>'/>
  <input type="hidden" id="hidden-data2" value='<?php echo json_encode($stocktake['MerchantStockTakeCount']); ?>'/>
  <input type="hidden" id="hidden-data3" value='<?php echo json_encode($inventory); ?>'/>
</div>

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<?php echo $this->element('script-jquery'); ?>
<?php echo $this->element('script-angularjs'); ?>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js"></script>
<script src="/theme/onzsa/assets/global/plugins/flot/jquery.flot.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/flot/jquery.flot.resize.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/flot/jquery.flot.categories.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jquery.pulsate.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/bootstrap-daterangepicker/moment.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
<script src="/theme/onzsa/assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jquery.sparkline.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/gritter/js/jquery.gritter.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/theme/onzsa/assets/global/scripts/metronic.js"></script>
<script src="/theme/onzsa/assets/admin/layout/scripts/layout.js"></script>
<script src="/theme/onzsa/assets/admin/pages/scripts/index.js"></script>
<script src="/theme/onzsa/assets/admin/pages/scripts/tasks.js"></script>
<script src="/js/dataTable.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN COMMON INIT -->
<?php echo $this->element('common-init'); ?>
<!-- END COMMON INIT -->
<script>
var quickScanMode = false;
var stockTakeItems = JSON.parse($("#hidden-data1").val());
var stockTakeCounts = JSON.parse($("#hidden-data2").val());
var inventory = JSON.parse($("#hidden-data3").val());
var selectedTab = 'all';

jQuery(document).ready(function() {
  documentInit();
});

function documentInit() {
  // common init function
    commonInit();
    $("body").find(".hidden-data").remove();
    updateTabContents();
    updateCounted();

    autoCompleteForSearch();

    $("#inventory-tab-all").click(function() {
        selectTab(this, 'all');
    });

    $("#inventory-tab-counted").click(function() {
        selectTab(this, 'counted');
    });

    $("#inventory-tab-uncounted").click(function() {
        selectTab(this, 'uncounted');
    });

    $("#quick-scan-mode").change(function() {
        $("#item-qty-wrapper").toggle();

        if ($("#item-qty-wrapper").is(':visible')) {
            $("#search-items-wrapper").attr('class','col-md-6 col-xs-6 col-sm-6 col-alpha');
        } else {
            $("#search-items-wrapper").attr('class','col-md-9 col-xs-9 col-sm-9 col-alpha');
        }

        $('#count-inventory').attr("disabled", "disabled");
        $("#search-items").removeAttr("data-id");
        $("#search-items").val('');

        quickScanMode = $("#quick-scan-mode").attr('checked') == 'checked';
    });

    $(document).on("keypress", "#search-items", function(e) {
        var key = event.keyCode || event.which;

        if (key == 13 && quickScanMode && $(this).attr("data-id")) {
            addStockTakeCount($(this).attr("data-id"), $(this).val(), 1);
        } else {
            $('#count-inventory').attr("disabled", "disabled");
            $(this).removeAttr("data-id");
        }
    });

    $("#count-inventory").click(function(e) {
        if (quickScanMode || !$("#search-items").attr("data-id") || !filterInt($("#item-qty").val())) {
            return;
        }

        addStockTakeCount($("#search-items").attr("data-id"), $("#search-items").val(), $("#item-qty").val());
    });

    $(document).on("click", ".product-list", function(e) {
        if (!quickScanMode) {
            var id = $(this).attr("data-id");

            for (var idx in stockTakeItems) {
                if (stockTakeItems[idx]['id'] == id) {
                    $("#search-items").attr("data-id", stockTakeItems[idx]['product_id']);
                    $("#search-items").val(stockTakeItems[idx]['name']);
                    $('#count-inventory').removeAttr("disabled");
                    return;
                }
            }
        }
    });

    $(document).on("click", ".remove", function(e) {
        var id = $(this).parents('ul').attr("data-id");
        removeInventoryCount($(this).parents('ul'), id);
    });
};

function autoCompleteForSearch() {
    $("#search-items").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "/stock_takes/search.json",
                method: "POST",
                dataType: "json",
                data: {
                    keyword: request.term,
                    filter: 'products',
                    show_inactive: $("show_inactive").val()
                },
                success: function (data) {
                    $(this).removeAttr('data-id');
                    $("#count-inventory").attr("disabled","disabled");

                    if (!data.success) {
                        alert(data.message);
                        return;
                    }

                    response($.map(data.products, function (item) {
                        var label = item.name;
                        if (item.variant_option_one_name != null) {
                            label += " / " + item.variant_option_one_value
                        }
                        if (item.variant_option_two_name != null) {
                            label += " / " + item.variant_option_two_value
                        }
                        if (item.variant_option_three_name != null) {
                            label += " / " + item.variant_option_three_value
                        }

                        return {
                            label: label,
                            value: item.sku,
                            data: item
                        };
                    }));
                }
            });
        },
        minLength: 2,
        select: function( event, ui ) {
            var data = ui.item.data;

            $(this).attr('data-id', data.id);
            $(this).val(ui.item.label);
            $(this).select();

            if (quickScanMode) {
                addStockTakeCount(data.id, ui.item.label, 1);
            } else {
                $('#count-inventory').removeAttr("disabled");
            }

            return false;
        }
    });
}

var filterInt = function (value) {
    if (/^(\-|\+)?([0-9]+|Infinity)$/.test(value))
        return true;
    return false;
}

function addStockTakeCount(product_id, name, count) {
    for (var idx in stockTakeItems) {
        if (stockTakeItems[idx].product_id == product_id) {
            if (filterInt(stockTakeItems[idx].counted)) {
                stockTakeItems[idx].counted += parseInt(count);
            } else {
                stockTakeItems[idx].counted = parseInt(count);
            }

            addInventoryCount(product_id, name, count);
            updateTabContents();
            return;
        }
    }

    addStockTakeItem($("#outlet_id").val(), product_id, name, count);
}

function addInventoryCount(product_id, name, count) {
    var counted = {};
    counted['stock_take_id'] = $("#id").val();
    counted['product_id'] = product_id;
    counted['name'] = name;
    counted['quantity'] = count;

    if (stockTakeCounts == null) {
        stockTakeCounts = {};
    }
    stockTakeCounts.push(counted);
    updateCounted();
}

function removeInventoryCount(element, idx) {
    var item = stockTakeCounts[idx];

    for (var idx in stockTakeItems) {
        if (stockTakeItems[idx].product_id == item['product_id']) {
            stockTakeItems[idx].counted -= parseInt(item['quantity']);
            updateTabContents();
            break;
        }
    }

    stockTakeCounts.splice(idx, 1);
    $(element).remove();
}

function addStockTakeItem(outlet_id, product_id, name, count) {
    $.ajax({
        url: "/stock_takes/<?php echo $stocktake['MerchantStockTake']['id']; ?>/addItem.json",
        method: "POST",
        dataType: "json",
        data: {
            outlet_id: outlet_id,
            product_id: product_id,
            name: name,
        },
        success: function (data) {
            console.log(data);
            if (!data.success) {
                alert(data.message);
                return;
            }

            item = data.item;
            item.counted = count;

            if (stockTakeItems == null) {
                stockTakeItems = {};
            }
            stockTakeItems.push(item);
            updateTabContents();

            addInventoryCount(product_id, name, count);
        }
    });
}

function selectTab(element, selected) {
    $(".inventory-tab").find(".active").removeClass("active");
    $(element).addClass("active");

    selectedTab = selected;
    updateTabContents();
}

function updateTabContents() {
    var counted = 0;
    var uncounted = 0;

    $("#productTable").find('tbody').empty();

    for (var idx in stockTakeItems) {
        if (filterInt(stockTakeItems[idx]['counted'])) {
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
        appendString += '<tr role="row" class="odd product-list" data-id="' + stockTakeItems[idx]['id'] + '">';
        appendString += '<td>' + stockTakeItems[idx]['name'];
        appendString += '<h6 class="inline-block-z margin-left-10">' + stockTakeItems[idx]['sku'] + '</h6></td>';
        appendString += '<td class="product-list-expected">' + (filterInt(stockTakeItems[idx]['expected']) ? stockTakeItems[idx]['expected'] : '&nbsp;') + '</td>';
        appendString += '<td class="product-list-count">' + (filterInt(stockTakeItems[idx]['counted']) ? stockTakeItems[idx]['counted'] : '&nbsp;') + '</td>';
        appendString += '</tr>';
        $("#productTable").find('tbody').append(appendString);
    }
    $(".inventory-tab-all-label").text(counted + uncounted);
    $(".inventory-tab-counted-label").text(counted);
    $(".inventory-tab-uncounted-label").text(uncounted);
}

function updateCounted() {
    $("#counted_list").empty();

    for (var idx in stockTakeCounts) {
        var appendString = '';
        appendString += '<ul class="added-item" data-id="' + idx + '">';
        appendString += '<li class="pull-left"><span class="added-item-qty">' + stockTakeCounts[idx]['quantity'] + '</span>';
        appendString += '&nbsp;&nbsp;' + stockTakeCounts[idx]['name'] + '</li><li class="pull-right">';
        appendString += '<span class="remove inline-block"><span class="glyphicon glyphicon-remove"></span></span></li></ul>';
        $("#counted_list").append(appendString);
    }
}

function review() {
    $.ajax({
        url: "/stock_takes/<?php echo $stocktake['MerchantStockTake']['id']; ?>/pause.json",
        method: "POST",
        dataType: "json",
        data: {
            'StockTakeItem' : JSON.stringify(stockTakeItems),
            'StockTakeCount' : JSON.stringify(stockTakeCounts)
        },
        success: function (data) {
            if (!data.success) {
                alert(data.message);
                return;
            }

            window.location = "/stock_takes/<?php echo $stocktake['MerchantStockTake']['id']; ?>/review";
        }
    });
}

function save() {
    $.ajax({
        url: "/stock_takes/<?php echo $stocktake['MerchantStockTake']['id']; ?>/pause.json",
        method: "POST",
        dataType: "json",
        data: {
            'StockTakeItem' : JSON.stringify(stockTakeItems),
            'StockTakeCount' : JSON.stringify(stockTakeCounts)
        },
        error: function (e) {
            console.log(e);
        },
        success: function (data) {
            console.log(data);
            if (!data.success) {
                alert(data.message);
                return;
            }

            window.location = "/stock_takes";
        }
    });
}
</script>
<!-- END JAVASCRIPTS -->
