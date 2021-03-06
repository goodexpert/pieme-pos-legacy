<?php
    $filters = [];

    if (!empty($stocktake) && is_array($stocktake)) {
        if (isset($stocktake['MerchantStockTake']['filters']) &&
            !empty($stocktake['MerchantStockTake']['filters'])) {
            $filters = json_decode($stocktake['MerchantStockTake']['filters'], true);
        }
    }
?>
<style>
.order-product-header {
    background: #eee;
    margin-bottom: 20px;
    padding: 10px 15px;
}
.line-box {
    padding: 0;
}
.inventory-view-no-list {
    padding: 100px 0;
    text-align: center;
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
                <div class="pull-left col-md-9 col-xs-9 col-sm-9 col-alpha col-omega">
                    <h2>
                        Review Inventory Count
                    </h2>
                    <h4 class="col-lg-5 col-md-6 col-xs-12 col-sm-7 col-alpha">Main Outlet 25-03-2015 3:00 PM</h4>
                    <h5 class="col-lg-7 col-md-6 col-xs-12 col-sm-5 col-alpha col-omega">Full Count</h5>
                    <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                        <h5 class="col-lg-4 col-md-5 col-xs-12 col-sm-6 col-alpha col-omega">
                            <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                            Start: 25 Mar 2015, 2:37 PM
                        </h5>
                        <h5 class="col-lg-8 col-md-7 col-xs-12 col-sm-6 col-alpha col-omega">
                            <span class="glyphicon glyphicon-map-marker"></span>&nbsp;
                            Main Outlet
                        </h5>
                </div>
                <div class="col-md-12 col-xs-12 col-sm-12 filter-selection">
                <?php foreach ($filters as $filter) :?>
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
            </div>
            <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                <div class="inventory-content">
                    <div class="inventory-tab">
                        <ul>
                            <li id="inventory-tab-uncounted" class="active">Uncounted (<span class="inventory-tab-uncounted-label">0</span>)</li>
                            <li id="inventory-tab-unmatched">Unmatched (<span class="inventory-tab-unmatched-label">0</span>)</li>
                            <li id="inventory-tab-matched">Matched (<span class="inventory-tab-matched-label">0</span>)</li>
                            <li id="inventory-tab-excluded">Excluded (<span class="inventory-tab-excluded-label">0</span>)</li>
                            <li id="inventory-tab-all">All (<span class="inventory-tab-all-label">0</span>)</li>
                        </ul>
                    </div>
                    <div class="inventory-view-no-list" style="display: none;">
                        <p class="inventory-view-no-list-label">You have no matched items</p>
                    </div>
                    <div class="inventory-view-list">
                        <table class="table-bordered dataTable" id="inventory-table">
                            <colgroup>
                                <col width="2%">
                                <col width="50%">
                                <col width="12%">
                                <col width="12%">
                                <col width="12%">
                                <col width="12%">
                            </colgroup>
                            <thead>
                                <tr role="row">
                                    <th colspan="2" class="text-center">COUNT LIST</th>
                                    <th colspan="2" class="text-center">INVENTORY COUNT</th>
                                    <th colspan="2" class="text-center">DIFFERENCES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr role="row" class="odd table-color-gr table-head">
                                    <td><input type="checkbox" class="checkbox" id="select-all" onclick="toggleSelectAll(this)"></td>
                                    <td class="table-cell-product">
                                        PRODUCT 
                                    </td>
                                    <td>EXPECTED</td>
                                    <td>TOTAL</td>
                                    <td>UNIT</td>
                                    <td>COST</td>
                                </tr>
                                <tr role="row" class="even">
                                    <td><input type="checkbox"></td>
                                    <td>T-shirt (Demo)
                                        <h6>tshirt-white</h6>
                                    </td>
                                    <td>8</td>
                                    <td>6</td>
                                    <td>5</td>
                                    <td>$0.00</td>
                                </tr>
                                <tr role="row" class="even table-color">
                                    <td></td>
                                    <td><strong>Total</strong></td>
                                    <td></td>
                                    <td></td>
                                    <td><strong>-15</strong></td>
                                    <td><strong>$0.00</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 pull-right margin-top-20 margin-bottom-20">
                <button class="btn btn-primary btn-wide pull-right complete">Complete</button>
                <button class="btn btn-default pull-right margin-right-10 resume">Resume Count</button>
                <button class="btn btn-default pull-left cancel">Abandon Count</button>
            </div>
        </div>
    </div>
    <!-- COMPLETE POPUP BOX -->
    <div id="Complete_popup" class="confirmation-modal modal fade in" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="confirm-close cancel" data-dismiss="modal" aria-hidden="true">
                  <i class="glyphicon glyphicon-remove"></i>
                  </button>
                  <h4 class="modal-title">Complete Stocktake</h4>
              </div>
              <div class="modal-body">
                  Awesome! You've finished counting. When you click submit, we'll begin updating your inventory levels.
              </div>
              <div class="modal-footer">
                <button class="btn btn-primary confirm-close">Cancel</button>
                <button class="btn btn-success confirm-complete">Submit</button>
            </div>
          </div>
      </div>
    </div>
    <!-- COMPLETE POPUP BOX END -->
    <!-- Abandon count POPUP BOX -->
    <div id="Abandon_popup" class="confirmation-modal modal fade in" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="confirm-close cancel" data-dismiss="modal" aria-hidden="true">
                  <i class="glyphicon glyphicon-remove"></i>
                  </button>
                  <h4 class="modal-title">Are you sure you want to abandon count?</h4>
              </div>
              <div class="modal-body">
                  Your inventory levels will not be updated. A record of this inventory will be saved but you will no longer be able to edit it.
              </div>
              <div class="modal-footer">
                <button class="btn btn-primary confirm-close">Cancel</button>
                <button class="btn btn-success confirm-cancel">Abandon</button>
            </div>
          </div>
      </div>
    </div>
    <!-- COMPLETE POPUP BOX END -->
    <!-- END CONTENT -->
    <div class="hidden-data">
        <input type="hidden" id="hidden-data1" value='<?php echo json_encode($stocktake['MerchantStockTakeItem']); ?>' />
    </div>
</div>
<!-- END CONTAINER -->
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
var stockTakeItems = JSON.parse($("#hidden-data1").val());
var selectedTab = 'uncounted';

jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    Index.init();

    $("body").find(".hidden-data").remove();
    updateTabContents();

    $("#inventory-tab-uncounted").click(function() {
        selectTab(this, 'uncounted');
    });

    $("#inventory-tab-unmatched").click(function() {
        selectTab(this, 'unmatched');
    });

    $("#inventory-tab-matched").click(function() {
        selectTab(this, 'matched');
    });

    $("#inventory-tab-excluded").click(function() {
        selectTab(this, 'excluded');
    });

    $("#inventory-tab-all").click(function() {
        selectTab(this, 'all');
    });

    $(".cancel").click(function() {
        $("#Abandon_popup").show();
    });

    $(".complete").click(function() {
        $("#Complete_popup").show();
    });

    $(".confirm-close").click(function() {
        $(".confirmation-modal").hide();
    });

    $(".confirm-cancel").click(function() {
        window.location = "/stock_takes/<?php echo $stocktake['MerchantStockTake']['id']; ?>/cancel";
    });

    $(".confirm-complete").click(function() {
        window.location = "/stock_takes/<?php echo $stocktake['MerchantStockTake']['id']; ?>/complete";
    });

    $(".resume").click(function() {
        window.location = "/stock_takes/<?php echo $stocktake['MerchantStockTake']['id']; ?>/perform";
    });
});

var filterInt = function (value) {
    if (/^(\-|\+)?([0-9]+|Infinity)$/.test(value))
        return true;
    return false;
}

var toFixed = function(x, n) {
    return (Math.round(x * 100) / 100).toFixed(n);
}

function addExcludedDropBox(title) {
    var appendString = '';
    appendString += '<button type="button" class="btn btn-default btn-sm" data-toggle="dropdown" onclick="excludeItems()">';
    appendString += title + '</button>';

    $(".table-cell-product").append(appendString);
}

function addIncludedDropBox(title) {
    var appendString = '';
    appendString += '<button type="button" class="btn btn-default btn-sm" data-toggle="dropdown" onclick="includeItems()">';
    appendString += title + '</button>';

    $(".table-cell-product").append(appendString);
}

function removeDropBox() {
    $(".table-cell-product").empty();
    $(".table-cell-product").text("PRODUCT");
}

function excludeItems() {
    $.each($(".checkbox"), function(e) {
        if ($(this).attr("id") != "select-all") {
            if ($(this).attr("checked") == "checked") {
                var id = $(this).data("id");

                for (var idx in stockTakeItems) {
                    if (stockTakeItems[idx]['id'] == id) {
                        stockTakeItems[idx]['excluded'] = 1;
                    }
                }
            }
        }
    });

    $(".checkbox").removeAttr("checked");
    removeDropBox();
    updateTabContents();

    $.ajax({
        url: "/stock_takes/<?php echo $stocktake['MerchantStockTake']['id']; ?>/pause.json",
        method: "POST",
        dataType: "json",
        data: {
            'StockTakeItem' : JSON.stringify(stockTakeItems)
        },
        success: function (data) {
            if (!data.success) {
                alert(data.message);
                return;
            }
        }
    });
}

function includeItems() {
    $.each($(".checkbox"), function(e) {
        if ($(this).attr("id") != "select-all") {
            if ($(this).attr("checked") == "checked") {
                var id = $(this).data("id");

                for (var idx in stockTakeItems) {
                    if (stockTakeItems[idx]['id'] == id) {
                        stockTakeItems[idx]['excluded'] = 0;
                        break;
                    }
                }
            }
        }
    });

    $(".checkbox").removeAttr("checked");
    removeDropBox();
    updateTabContents();

    $.ajax({
        url: "/stock_takes/<?php echo $stocktake['MerchantStockTake']['id']; ?>/pause.json",
        method: "POST",
        dataType: "json",
        data: {
            'StockTakeItem' : JSON.stringify(stockTakeItems)
        },
        success: function (data) {
            if (!data.success) {
                alert(data.message);
                return;
            }
        }
    });
}

function toggleSelectAll(element) {
    if ($(element).attr("checked") == "checked") {
        $(".checkbox").attr("checked", "checked");
    } else {
        $(".checkbox").removeAttr("checked");
    }

    toggleSelectItem();
}

function toggleSelectItem() {
    var checked = 0;
    var excluded = 0;
    var matched = 0;
    var unmatched = 0;
    var uncounted = 0;
    var total = 0;

    $.each($(".checkbox"), function(e) {
        if ($(this).attr("id") != "select-all") {
            if ($(this).attr("checked") == "checked") {
                checked++;
            }
        }
    });

    for (var idx in stockTakeItems) {
        if (stockTakeItems[idx]['excluded'] == 1) {
            excluded++;
        } else if (!filterInt(stockTakeItems[idx]['counted'])) {
            uncounted++;
        } else if (stockTakeItems[idx]['expected'] == stockTakeItems[idx]['counted']) {
            matched++;
        } else {
            unmatched++;
        }
    }

    switch (selectedTab) {
        case 'uncounted':
            total = uncounted;

            if (checked == 0) {
                removeDropBox();
            } else {
                $(".table-cell-product").empty();
                addExcludedDropBox(checked + ' selected exclude');
            }
            break;
        case 'matched':
            total = matched;

            if (checked == 0) {
                removeDropBox();
            } else {
                $(".table-cell-product").empty();
                addExcludedDropBox(checked + ' selected exclude');
            }
            break;
        case 'unmatched':
            total = unmatched;

            if (checked == 0) {
                removeDropBox();
            } else {
                $(".table-cell-product").empty();
                addExcludedDropBox(checked + ' selected exclude');
            }
            break;
        case 'excluded':
            total = excluded;

            if (checked == 0) {
                removeDropBox();
            } else {
                $(".table-cell-product").empty();
                addIncludedDropBox(checked + ' selected include');
            }
            break;
        default:
            total = uncounted + matched + unmatched + excluded;

            if (checked == 0) {
                removeDropBox();
            } else {
                $(".table-cell-product").empty();
                if (excluded > 0) {
                    addIncludedDropBox(excluded + ' selected include');
                }
                if (excluded != total) {
                    addExcludedDropBox(total - excluded + ' selected exclude');
                }
            }
            break;
    }

    if (checked == total) {
        $("#select-all").attr("checked", "checked");
    } else {
        $("#select-all").removeAttr("checked");
    }
}

function selectTab(element, selected) {
    $(".checkbox").removeAttr("checked");
    removeDropBox();

    $(".inventory-tab").find(".active").removeClass("active");
    $(element).addClass("active");

    selectedTab = selected;
    updateTabContents();
}

function updateTabContents() {
    var excluded = 0;
    var matched = 0;
    var unmatched = 0;
    var uncounted = 0;
    var totalDiff = 0;
    var totalCost = 0;

    $("#inventory-table").find('.table-head').siblings().empty();

    for (var idx in stockTakeItems) {
        if (stockTakeItems[idx]['excluded'] == 1) {
            excluded++;

            if (selectedTab != 'all' && selectedTab != 'excluded') {
                continue;
            }
        } else if (!filterInt(stockTakeItems[idx]['counted'])) {
            uncounted++;

            if (selectedTab != 'all' && selectedTab != 'uncounted') {
                continue;
            }
        } else if (stockTakeItems[idx]['expected'] == stockTakeItems[idx]['counted']) {
            matched++;

            if (selectedTab != 'all' && selectedTab != 'matched') {
                continue;
            }
        } else {
            unmatched++;

            if (selectedTab != 'all' && selectedTab != 'unmatched') {
                continue;
            }
        }

        var expected = parseInt(stockTakeItems[idx]['expected']);
        var counted = filterInt(stockTakeItems[idx]['counted']) ? stockTakeItems[idx]['counted'] : 0;

        var diff = (counted - expected);
        var cost = diff * stockTakeItems[idx]['supply_price'];
        totalDiff += diff;
        totalCost += cost;

        var appendString = '';
        appendString += '<tr role="row" class="even">';
        appendString += '<td><input type="checkbox" class="checkbox" data-id="' + stockTakeItems[idx]['id'] + '" onclick="toggleSelectItem()"></td>';
        appendString += '<td>' + stockTakeItems[idx]['name'];
        appendString += '<h6>' + stockTakeItems[idx]['sku'] + '</h6></td>';
        appendString += '<td>' + stockTakeItems[idx]['expected'] + '</td>';
        appendString += '<td>' + (filterInt(stockTakeItems[idx]['counted']) ? stockTakeItems[idx]['counted'] : "&nbsp;") + '</td>';
        appendString += '<td>' + (diff == 0 ? "&nbsp;" : diff) + '</td>';
        appendString += '<td>' + (cost == 0 ? "&nbsp;" : toFixed(cost, 2)) + '</td></tr>';
        $("#inventory-table").find('tbody').append(appendString);
    }

    var appendString = '';
    appendString += '<tr role="row" class="even table-color">';
    appendString += '<td></td><td><strong>Total</strong></td>';
    appendString += '<td></td><td></td>';
    appendString += '<td><strong>' + totalDiff + '</strong></td>';
    appendString += '<td><strong>$' + toFixed(totalCost, 2) + '</strong></td></tr>';
    $("#inventory-table").find('tbody').append(appendString);

    switch (selectedTab) {
        case 'uncounted':
            if (uncounted == 0) {
                $(".inventory-view-no-list").css("display", "");
                $(".inventory-view-list").css("display", "none");
            } else {
                $(".inventory-view-no-list").css("display", "none");
                $(".inventory-view-list").css("display", "");
            }

            $(".inventory-view-no-list-label").text("You have no matched items");
            break;
        case 'excluded':
            if (excluded == 0) {
                $(".inventory-view-no-list").css("display", "");
                $(".inventory-view-list").css("display", "none");
            } else {
                $(".inventory-view-no-list").css("display", "none");
                $(".inventory-view-list").css("display", "");
            }

            $(".inventory-view-no-list-label").text("You have no excluded items");
            break;
        case 'matched':
            if (matched == 0) {
                $(".inventory-view-no-list").css("display", "");
                $(".inventory-view-list").css("display", "none");
            } else {
                $(".inventory-view-no-list").css("display", "none");
                $(".inventory-view-list").css("display", "");
            }

            $(".inventory-view-no-list-label").text("You have no matched items");
            break;
        case 'unmatched':
            if (unmatched == 0) {
                $(".inventory-view-no-list").css("display", "");
                $(".inventory-view-list").css("display", "none");
            } else {
                $(".inventory-view-no-list").css("display", "none");
                $(".inventory-view-list").css("display", "");
            }

            $(".inventory-view-no-list-label").text("You have no unmatched items");
            break;
        case 'all':
            $(".inventory-view-no-list").css("display", "none");
            $(".inventory-view-list").css("display", "");
            break;
    }

    $(".inventory-tab-excluded-label").text(excluded);
    $(".inventory-tab-uncounted-label").text(uncounted);
    $(".inventory-tab-matched-label").text(matched);
    $(".inventory-tab-unmatched-label").text(unmatched);
    $(".inventory-tab-all-label").text(excluded + uncounted + matched + unmatched);
}

</script>
<!-- END JAVASCRIPTS -->
