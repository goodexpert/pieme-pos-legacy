<?php
    $stock_take_id = "";
    $filters = "";
    $products = "";
    $name = "";
    $outlet_id = "";
    $current = time();
    $start_date = date('Y-m-d', $current);
    $start_time = date('h:i A', $current - $current % 3600 + 3600);
    $show_inactive = 0;
    $full_count = 0;

    if (!empty($data) && is_array($data)) {
        $stock_take_id = $data['id'];
        $filters = $data['filters'];
        $products = $data['products'];
        $name = $data['name'];
        $outlet_id = $data['outlet_id'];
        $timestamp = $this->Time->fromString($data['start_date']);
        $start_date = date('Y-m-d', $timestamp);
        $start_time = date('h:i A', $timestamp);
        $show_inactive = $data['show_inactive'];
        $full_count = $data['full_count'];
    }
 ?>
<style>
/*
.ui-helper-hidden-accessible { position: absolute; left:-999em; }
*/
</style>

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
                <div class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
                    <h2>
                        New Inventory Count
                    </h2>
                </div>
            </div>
            <!--<form action="/inventory_count/create" method="post" id="inventory_count_form">-->
            <form method="post" id="inventory_count_form">
            <input type="hidden" name="data[id]" id="stock_take_id" value="<?php echo $stock_take_id; ?>" />
            <input type="hidden" name="data[outlet_id]" id="outlet_id" value='<?php echo $outlet_id; ?>' />
            <input type="hidden" name="data[filters]" id="filters" value='<?php echo $filters; ?>' />
            <input type="hidden" name="data[products]" id="products" value='<?php echo $products; ?>' />
            <div class="col-md-12 col-xs-12 col-sm-12 line-box filter-box new-inventory margin-top-20">
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <dl>
                        <dt>Outlet</dt>
                        <dd>
                            <select class="status outlet">
                                <option selected="selected" disabled="disabled">Whitch outlet?</option>
                            <?php foreach ($outlets as $key => $value) : ?>
                                <option value="<?php echo $key; ?>" <?php echo $outlet_id == $key ? "selected" : ""; ?>><?php echo $value; ?></option>
                            <?php endforeach; ?>
                            </select>
                        </dd>
                    </dl>
                </div>
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <dl>
                        <dt>Start Date</dt>
                        <dd>
                            <span class="glyphicon glyphicon-calendar icon-calendar"></span>
                            <input class="hasDatepicker" type="text" name="data[start_date]" id="start_date" value="<?php echo $start_date; ?>" />
                        </dd>
                    </dl> 
                </div>
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <dl>
                        <dt>Start Time</dt>
                        <dd>
                            <input type="text" name="data[start_time]" id="start_time" value="<?php echo $start_time; ?>" />
                        </dd>
                    </dl>
                 </div>
                <div class="col-md-8 col-xs-8 col-sm-8 margin-top-20">
                    <dl>
                        <dt style="width: 19%;">Count Name</dt>
                        <dd style="width: 81%;">
                            <input type="text" name="data[name]" id="name" maxlength="255" value="<?php echo $name; ?>" />
                        </dd>
                    </dl>
                 </div>
                <div class="col-md-4 col-xs-4 col-sm-4 margin-top-20">
                    <input type="checkbox" name="data[show_inactive]" id="show_inactive" value="1" <?php echo $show_inactive == 1 ? "checked" : ""; ?> />
                    <label>Include inactive products</label>
                </div>
                <div class="solid-line-gr"></div>
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <div class="col-md-3 col-xs-3 col-sm-3">
                        <input type="radio" class="full_count" name="data[full_count]" id="full_count1" value="0" <?php echo $full_count == 0 ? "checked" : ""; ?>/><label>Partial Count</label>
                    </div>
                    <div class="col-md-3 col-xs-3 col-sm-3">
                        <input type="radio" class="full_count" name="data[full_count]" id="full_count2" value="1" <?php echo $full_count == 1 ? "checked" : ""; ?>/><label>Full Count</label>
                    </div>
                </div>
                <div class="line-box-stitle col-md-12 col-xs-12 col-sm-12 margin-top-20">
                    <div class="partial-count">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <h5><strong>Partial Count List</strong></h5>
                            <h5>Create your list of items to count using suppliers, brands, types, tags, or SKUs. Combine multiple filters to narrow down your list.</h5>
                            <input type="text" class="margin-top-20" id="search-items" placeholder="Search for suppliers, brands, types, tags, or SKUs.">
                        </div>
                        <div class="col-md-12 col-xs-12 col-sm-12 margin-top-20">
                            <table id="productTable" class="table-bordered dataTable" style="display:none;">
                                <colgroup>
                                    <col width="100%">
                                </colgroup>
                                <thead>
                                    <tr role="row">
                                        <th style="border-radius:5px 5px 0 0">Product</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!--
                                    <tr>
                                        <td>T-shirt (Demo)<h6>tshirt-white</h6></td>
                                    </tr>
                                    -->
                                </tbody>
                            </table>
                            <div class="no-list text-center margin-top-20">
                                <div class="margin-top-20"><img src="/img/stock.png"></div>
                                <h5 class="margin-top-30">Categorising your products makes partial inventory counts easy. <a>Learn how</a></h5>
                            </div>
                        </div>
                    </div>
                    <div class="full-count text-center margin-top-10 inline-block" style="display:none;">
                        <p class="background-text"><h5>All products will be counted</h5></p>
                    </div>
                </div>
            </div>
            <div class="col-md-12 margin-top-20 col-omega">
                <div class="pull-left">
                    <button type="button" class="btn btn-default btn-wide cancel margin-right-10">Cancel</button>
                </div>
                <div class="pull-right">
                    <button type="button" class="btn btn-primary btn-wide save margin-right-10" disabled="disabled">Save</button>
                    <button type="button" class="btn btn-success btn-wide start" disabled="disabled">Start</button>
                </div>
            </div>
            </form>
        </div>
    </div>
    <!-- END CONTENT -->
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
var manualNamed = false;
var outletName = $(".outlet").val();
var filters = [];
var isFullCount = <?php echo $full_count; ?>;
var showInactive = <?php echo $show_inactive ? 'true' : 'false'; ?>;
var products = {};

jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    QuickSidebar.init() // init quick sidebar
    Index.init();

    $("#name").keyup(function(e) {
        manualNamed = true;
    });

    $(".outlet").on("change", function(e) {
        if (manualNamed)
            return;

        outletName = $("select option:selected").text();
        $("#name").val(outletName + ' ' + $("#start_date").val() + ' ' + $("#start_time").val());
        $("#outlet_id").val($(this).val());
    });

    $("#start_date").on("change", function(e) {
        if (manualNamed || outletName == '')
            return;

        $("#name").val(outletName + ' ' + $("#start_date").val() + ' ' + $("#start_time").val());
    });

    $("#start_time").on("change", function(e) {
        if (manualNamed || outletName == '')
            return;

        $("#name").val(outletName + ' ' + $("#start_date").val() + ' ' + $("#start_time").val());
    });

    $("#show_inactive").change(function(e) {
        showInactive = $(this).prop('checked');
        if (!showInactive) {
            for (var productId in products) {
                var product = products[productId];
                if (product['is_active'] == 0) {
                    delete products[productId];

                    for (var index in filters) {
                        if (filters[index]['type'] == 'products' && filters[index]['value'] == productId) {
                            filters.splice(index, 1);
                        }
                    }
                }
            }
            updateView();
        }
    });

    $(".full_count").on("change", function(e) {
        isFullCount = $(this).val();
        if (isFullCount == 0) {
            $(".full-count").css('display', 'none');
            $(".partial-count").css('display', '');

            if (Object.keys(products).length == 0) {
                $(".no-list").css('display', '');
                $(".save").attr('disabled', true);
                $(".start").attr('disabled', true);
            }
        } else {
            $(".full-count").css('display', '');
            $(".partial-count").css('display', 'none');
            $(".no-list").css('display', 'none');

            $(".save").attr('disabled', false);
            $(".start").attr('disabled', false);
        }
    });

    $("#search-items").catcomplete({
        source: function (request, response) {
            $.ajax({
                url: "/inventory_count/search.json",
                method: "POST",
                dataType: "json",
                data: {
                    keyword: request.term,
                    show_inactive: showInactive ? 1 : 0
                },
                success: function (data) {
                    if (!data.success)
                        return;

                    var items = [];
                    $.map(data.suppliers, function (item) {
                        items.push({
                            id: item.id,
                            label: item.name,
                            category: "Supplier",
                            type: "suppliers",
                            data: item.MerchantProduct
                        });
                    });

                    $.map(data.brands, function (item) {
                        items.push({
                            id: item.id,
                            label: item.name,
                            category: "Brand",
                            type: "brands",
                            data: item.MerchantProduct
                        });
                    });

                    $.map(data.types, function (item) {
                        items.push({
                            id: item.id,
                            label: item.name,
                            category: "Type",
                            type: "types",
                            data: item.MerchantProduct
                        });
                    });

                    $.map(data.tags, function (item) {
                        items.push({
                            id: item.id,
                            label: item.name,
                            category: "Tag",
                            type: "tags",
                            data: item.MerchantProduct
                        });
                    });

                    $.map(data.products, function (item) {
                        items.push({
                            id: item.id,
                            label: item.name,
                            category: "Product",
                            type: "products",
                            data: item
                        });
                    });

                    response(items);
                }
            });
        },
        minLength: 3,
        select: function( event, ui ) {
            var data = ui.item.data;

            if (ui.item.category == 'Product') {
                products[data.id] = data;
            } else {
                $.each(data, function(index, product) {
                    products[product.id] = product;
                });
            }

            var id =  ui.item.id;
            var type = ui.item.type;
            var found = false;

            for (var index in filters) {
                if (type == filters[index]['type'] && id == filters[index]['value']) {
                    found = true;
                }
            }

            if (!found) {
                filters.push({
                    type: type,
                    value: id
                })
            }

            if (Object.keys(products).length > 0) {
                $(".no-list").css('display', 'none');
                $(".save").attr('disabled', false);
                $(".start").attr('disabled', false);
            }
            $(this).val('');
            updateView();

            return false;
        }
    });

    $(".save").click(function(e) {
        if (!outletName) {
            alert('Please select the outlet!');
            return;
        } else if ($("#name").val() == '') {
            alert('Please input the count name!');
            return;
        }

        if (!isFullCount) {
            $("#filters").val(JSON.stringify(filters));
        }
        $("#products").val(JSON.stringify(products));

        $.ajax({
            url: '/inventory_count/save.json',
            type: 'POST',
            data: $('#inventory_count_form').serialize(),
            error: function( jqXHR, textStatus, errorThrown ) {
            },
            success: function( data ) {
                if ( data.success ) {
                    location.href = "/inventory_count";
                } else {
                    alert(data.message);
                }
            }
        });
        return false;
    });

    $(".start").click(function(e) {
        if (!outletName) {
            alert('Please select the outlet!');
            return;
        } else if ($("#name").val() == '') {
            alert('Please input the count name!');
            return;
        }

        if (!isFullCount) {
            $("#filters").val(JSON.stringify(filters));
        }
        $("#products").val(JSON.stringify(products));

        $.ajax({
            url: '/inventory_count/start.json',
            type: 'POST',
            data: $('#inventory_count_form').serialize(),
            error: function( jqXHR, textStatus, errorThrown ) {
            },
            success: function( data ) {
                if ( data.success ) {
                    location.href = "/inventory_count/" + data.id + "/perform";
                } else {
                    alert(data.message);
                }
            }
        });
        return false;
    });
});

$.widget( "custom.catcomplete", $.ui.autocomplete, {
    _create: function() {
        this._super();
        this.widget().menu( "option", "items", "> :not(.ui-autocomplete-category)" );
    },
    _renderMenu: function( ul, items ) {
        var that = this,
        currentCategory = "";
        $.each( items, function( index, item ) {
            var li;
            if ( item.category != currentCategory ) {
                ul.append( "<li class='ui-autocomplete-category'>" + item.category + "</li>" );
                currentCategory = item.category;
            }
            li = that._renderItemData( ul, item );
            if ( item.category ) {
                li.attr( "aria-label", item.category + " : " + item.label );
            }
        });
    }
});

function updateView() {
    $("#productTable tbody").empty();

    if (isFullCount == 0) {
        $(".full-count").css('display', 'none');
        $(".partial-count").css('display', '');

        if (Object.keys(products).length == 0) {
            $("#productTable").css('display', 'none');
            $(".no-list").css('display', '');

            $(".save").attr('disabled', true);
            $(".start").attr('disabled', true);
        } else {
            $("#productTable").css('display', '');
            $(".no-list").css('display', 'none');

            $(".save").attr('disabled', false);
            $(".start").attr('disabled', false);
        }

        var index = 0;
        $.each(products, function(id, product) {
            $('#productTable tbody').append('<tr><td><input type="hidden" value="' + id +'" /><p class="pull-left margin-right-10">' + product.name + '</p><h6 class="pull-left" style="margin-top: 3px;">' + product.sku + '</h6></td></tr>');
            index++;
        });
    } else {
        $(".full-count").css('display', '');
        $(".partial-count").css('display', 'none');

        $(".save").attr('disabled', false);
        $(".start").attr('disabled', false);
    }
}
</script>
<!-- END JAVASCRIPTS -->
