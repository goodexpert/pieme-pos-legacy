<?php
    $data = $this->request->data;

    $current = time();
    $due_date = date('Y-m-d H:i:s', $current- $current % 3600 + 3600);
    $full_count = 0;
    $show_inactive = 0;
    $filters = array();
    $products = array();
    $can_save = false;

    if (!empty($data) && is_array($data)) {
        if (isset($data['MerchantStockTake']['filters']) &&
            !empty($data['MerchantStockTake']['filters'])) {
            $filters = json_decode($data['MerchantStockTake']['filters'], true);
        }

        if (isset($data['products']) && !empty($data['products'])) {
            $products = json_decode($data['products'], true);
        }

        $due_date = $data['MerchantStockTake']['due_date'];
        $full_count = $data['MerchantStockTake']['full_count'];
        $show_inactive = $data['MerchantStockTake']['show_inactive'];
        $can_save = ($full_count == 1 || count($products) > 0);
    }

    $start_date = date('Y-m-d', strtotime($due_date));
    $start_time = date('h:i A', strtotime($due_date));
 ?>
<style>
/*
.ui-helper-hidden-accessible { position: absolute; left:-999em; }
*/
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
                <div class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
                    <h2>
                        Edit Inventory Count
                    </h2>
                </div>
            </div>
            <form action="/stock_takes/create" method="post" id="stock_take_form">
            <?php
                echo $this->Form->input('MerchantStockTake.id', array(
                    'id' => 'id',
                    'type' => 'hidden'
                ));

                echo $this->Form->input('MerchantStockTake.due_date', array(
                    'id' => 'due_date',
                    'type' => 'hidden',
                    'value' => $due_date
                ));

                echo $this->Form->input('MerchantStockTake.filters', array(
                    'id' => 'filters',
                    'type' => 'hidden'
                ));

                echo $this->Form->input('products', array(
                    'id' => 'products',
                    'type' => 'hidden'
                ));

                echo $this->Form->input('save-start', array(
                    'id' => 'save-start',
                    'type' => 'hidden',
                    'value' => 0
                ));
             ?>
            <div class="col-md-12 col-xs-12 col-sm-12 line-box filter-box new-inventory margin-top-20">
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <dl>
                        <dt>Outlet</dt>
                        <dd>
                            <?php
                                echo $this->Form->input('MerchantStockTake.outlet_id', array(
                                    'id' => 'outlet_id',
                                    'type' => 'select',
                                    'class' => 'status outlet',
                                    'div' => false,
                                    'label' => false,
                                    'disabled' => 'disabled',
                                    'empty' => 'Which outlet?'
                                ));
                             ?>
                        </dd>
                    </dl>
                </div>
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <dl>
                        <dt>Start Date</dt>
                        <dd>
                            <span class="glyphicon glyphicon-calendar icon-calendar"></span>
                            <?php
                                echo $this->Form->input('MerchantStockTake.start_date', array(
                                    'id' => 'start_date',
                                    'type' => 'text',
                                    'class' => 'hasDatepicker',
                                    'div' => false,
                                    'label' => false,
                                    'placeholder' => 'e.g. 2000-06-02',
                                    'value' => $start_date
                                ));
                             ?>
                        </dd>
                    </dl> 
                </div>
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <dl>
                        <dt>Start Time</dt>
                        <dd>
                            <?php
                                echo $this->Form->input('MerchantStockTake.start_time', array(
                                    'id' => 'start_time',
                                    'type' => 'text',
                                    'div' => false,
                                    'label' => false,
                                    'placeholder' => 'e.g. 6:00 PM',
                                    'value' => $start_time
                                ));
                             ?>
                        </dd>
                    </dl>
                 </div>
                <div class="col-md-8 col-xs-8 col-sm-8 margin-top-20">
                    <dl>
                        <dt style="width: 19%;">Count Name</dt>
                        <dd style="width: 81%;">
                            <?php
                                echo $this->Form->input('MerchantStockTake.name', array(
                                    'id' => 'name',
                                    'type' => 'text',
                                    'maxlength' => '255',
                                    'div' => false,
                                    'label' => false
                                ));
                             ?>
                        </dd>
                    </dl>
                 </div>
                <div class="col-md-4 col-xs-4 col-sm-4 margin-top-20">
                    <?php
                        echo $this->Form->checkbox('MerchantStockTake.show_inactive', array(
                            'id' => 'show_inactive',
                            'type' => 'checkbox',
                            'div' => false
                        ));
                     ?>
                    <label>Include inactive products</label>
                </div>
                <div class="solid-line-gr"></div>
                <div class="col-md-12 col-xs-12 col-sm-12 stocktake-type-container">
                    <?php
                        echo $this->Form->input('MerchantStockTake.full_count', array(
                            'id' => 'full_count',
                            'type' => 'radio',
                            'class' => 'full_count',
                            'div' => array(
                                'class' => 'col-md-3 col-xs-3 col-sm-3'
                            ),
                            'options' => array(
                                0 => 'Partial Count',
                            ),
                            'checked' => true,
                            'hiddenField' => false,
                            'legend' => false
                        ));

                        echo $this->Form->input('MerchantStockTake.full_count', array(
                            'id' => 'full_count',
                            'type' => 'radio',
                            'class' => 'full_count',
                            'div' => array(
                                'class' => 'col-md-3 col-xs-3 col-sm-3'
                            ),
                            'options' => array(
                                1 => 'Full Count',
                            ),
                            'checked' => false,
                            'hiddenField' => false,
                            'legend' => false
                        ));
                     ?>
                </div>
                <div class="text-center margin-top-10 inline-block full-count" <?php echo $full_count == 1 ? '' : 'style="display:none;"'; ?>>
                    <p class="background-text"><h5>All products will be counted</h5></p>
                </div>
                <div class="col-md-12 col-xs-12 col-sm-12 product-search-container" <?php echo $full_count == 0 ? '' : 'style="display:none;"'; ?>>
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <h5><strong>Partial Count List</strong></h5>
                        <h5>Create your list of items to count using suppliers, brands, types, tags, or SKUs. Combine multiple filters to narrow down your list.</h5>
                        <input type="text" class="margin-top-20" id="search-items" placeholder="Search for suppliers, brands, types, tags, or SKUs.">
                    </div>
                    <div class="col-md-12 col-xs-12 col-sm-12 filter-selection">
                        <div class="filter-product-results">
                        <?php if (count($filters) > 0) : ?>
                            <?php echo count($filters); ?> <?php echo count($filters) > 1 ? ' RESULTS' : ' RESULT'; ?>
                        <?php endif; ?>
                        </div>
                    <?php foreach ($filters as $filter) :?>
                        <div class="filter-tag-group">
                            <span class="filter-tag-group-title"><?php echo $filter['category']; ?>:</span>
                            <div class="filter-tag-items">
                                <span class="filter-tag-item">
                                    <?php echo $filter['name']; ?>
                                    <a class="filter-tag-item-remove clickable" data-type="<?php echo $filter['type']; ?>" data-value="<?php echo $filter['value']; ?>" onclick="removeFilter(this);">
                                        <i class="glyphicon glyphicon-remove"></i></a>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                    <div class="col-md-12 col-xs-12 col-sm-12 margin-bottom-20">
                        <table class="table-bordered dataTable" <?php echo count($products) > 0 ? '' : 'style="display:none;"'; ?>>
                            <colgroup>
                                <col width="100%">
                            </colgroup>
                            <thead>
                                <tr role="row">
                                    <th style="border-radius:5px 5px 0 0">Product</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($products as $id => $data) :?>
                                <tr>
                                    <td><?php echo $data['product']['name']; ?><h6><?php echo $data['product']['sku']; ?></h6></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div class="no-list text-center margin-top-20" <?php echo count($products) == 0 ? '' : 'style="display:none;"'; ?>>
                            <div class="margin-top-20"><img src="/img/stock.png"></div>
                            <h5 class="margin-top-30">Categorising your products makes partial inventory counts easy. <a>Learn how</a></h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 margin-bottom-20 col-omega">
                <div class="pull-left">
                    <button type="button" class="btn btn-default btn-wide margin-right-10 cancel">Cancel</button>
                </div>
                <div class="pull-right">
                    <button type="submit" class="btn btn-primary btn-wide margin-right-10 save" <?php echo $can_save ? '' : 'disabled="disabled"'; ?>>Save</button>
                    <button type="submit" class="btn btn-success btn-wide start" <?php echo $can_save ? '' : 'disabled="disabled"'; ?>>Start</button>
                </div>
            </div>
            </form>
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
<script src="/theme/onzsa/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
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
var modifiedName = false;
var countName= $("#name").val();
var outletName = $(".outlet").val();
var isFullCount = 0;
var filters = $("#filters").val() == "" ? [] : JSON.parse($("#filters").val());
var products = $("#products").val() == "" ? {} : JSON.parse($("#products").val());

jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    Index.init();

    autoCompleteForSearch();
    formValidation();

    $("#name").keyup(function(e) {
        if (countName != $(this).val()) {
            modifiedName = true;
        }
    });

    $(".outlet").on("change", function(e) {
        if (modifiedName)
            return;

        outletName = $("select option:selected").text();
        $("#outlet_id").val($(this).val());

        countName = outletName;

        var dateRegex = /[0-9]{4}.(0[1-9]|1[012]).(0[1-9]|1[0-9]|2[0-9]|3[01])/;
        if (dateRegex.test($("#start_date").val())) {
            countName += ' ' + $("#start_date").val();
        }

        var timeRegex = /^([0-9]|0[0-9]|1[0-2])(:[0-5][0-9]){1}\s?(am|pm){1}/i;
        if (timeRegex.test($("#start_time").val())) {
            countName += ' ' + $("#start_time").val();
        }
        $("#name").val(countName);

    });

    $("#start_date").on("change", function(e) {
        if (modifiedName || outletName == '')
            return;

        countName = outletName;

        var dateRegex = /[0-9]{4}.(0[1-9]|1[012]).(0[1-9]|1[0-9]|2[0-9]|3[01])/;
        if (dateRegex.test($("#start_date").val())) {
            countName += ' ' + $("#start_date").val();
        }

        var timeRegex = /^([0-9]|0[0-9]|1[0-2])(:[0-5][0-9]){1}\s?(am|pm){1}/i;
        if (timeRegex.test($("#start_time").val())) {
            countName += ' ' + $("#start_time").val();
        }
        $("#name").val(countName);

        if (dateRegex.test($("#start_date").val()) && timeRegex.test($("#start_time").val())) {
            var dueDate = new Date($("#start_date").val() + ' ' + $("#start_time").val());
            $("#due_date").val(dueDate.getFullYear() + "-" + (dueDate.getMonth() + 1) + 
                dueDate.getDate() + " " + dueDate.getHours() + ":" + dueDate.getMinutes() + ":" +
                dueDate.getSeconds());
        }
    });

    $("#start_time").on("change", function(e) {
        if (modifiedName || outletName == '')
            return;

        countName = outletName;

        var dateRegex = /[0-9]{4}.(0[1-9]|1[012]).(0[1-9]|1[0-9]|2[0-9]|3[01])/;
        if (dateRegex.test($("#start_date").val())) {
            countName += ' ' + $("#start_date").val();
        }

        var timeRegex = /^([0-9]|0[0-9]|1[0-2])(:[0-5][0-9]){1}\s?(am|pm){1}/i;
        if (timeRegex.test($("#start_time").val())) {
            countName += ' ' + $("#start_time").val();
        }
        $("#name").val(countName);

        if (dateRegex.test($("#start_date").val()) && timeRegex.test($("#start_time").val())) {
            var dueDate = new Date($("#start_date").val() + ' ' + $("#start_time").val());
            $("#due_date").val(dueDate.getFullYear() + "-" + (dueDate.getMonth() + 1) + 
                dueDate.getDate() + " " + dueDate.getHours() + ":" + dueDate.getMinutes() + ":" +
                dueDate.getSeconds());
        }
    });

    $("#show_inactive").change(function(e) {
        if (!$(this).prop('checked')) {
            for (var productId in products) {
                var product = products[productId];
                if (product['is_active'] == 0) {
                    delete products[productId];

                    var temp = [];
                    for (var index in filters) {
                        if (filters[index]['type'] != 'products' || filters[index]['value'] != productId) {
                            temp.push(filters[index]);
                        }
                    }
                    filters = temp;
                    $("#filters").val(JSON.stringify(filters));
                }
            }
            updateView();
        }
    });

    $(".full_count").on("change", function(e) {
        if ($(this).val() == 0) {
            $(".full-count").css('display', 'none');
            $(".product-search-container").css('display', '');

            if (Object.keys(products).length == 0) {
                $(".no-list").css('display', '');
                $(".save").attr('disabled', true);
                $(".start").attr('disabled', true);
            }

            $("#filters").val(JSON.stringify(filters));
            $("#products").val(JSON.stringify(products));
        } else {
            $(".full-count").css('display', '');
            $(".product-search-container").css('display', 'none');
            $(".no-list").css('display', 'none');

            $(".save").attr('disabled', false);
            $(".start").attr('disabled', false);

            $("#filters").val('');
            $("#products").val('');
        }
        isFullCount = $(this).val(); 
        $("#full_count0").attr('checked', isFullCount == 0);
        $("#full_count1").attr('checked', isFullCount == 1);
    });

    $(".save").click(function(e) {
        if (!outletName) {
            alert('Please select the outlet!');
            return false;
        } else if ($("#name").val() == '') {
            alert('Please input the count name!');
            return false;
        }
    });

    $(".start").click(function(e) {
        if (!outletName) {
            alert('Please select the outlet!');
            return false;
        } else if ($("#name").val() == '') {
            alert('Please input the count name!');
            return false;
        }

        $("#save-start").val(1);
    });
});

$.widget("custom.catcomplete", $.ui.autocomplete, {
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
                ul.attr({class: "ui-autocomplete ui-front ui-menu ui-widget-1 ui-widget-content-1 ui-corner-all"});
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

function autoCompleteForSearch() {
    $("#search-items").catcomplete({
        source: function (request, response) {
            $.ajax({
                url: "/stock_takes/search.json",
                method: "POST",
                dataType: "json",
                data: {
                    keyword: request.term,
                    show_inactive: $(this).prop('checked') ? 1 : 0
                },
                error: function( jqXHR, textStatus, errorThrown ) {
                    alert(errorThrown);
                },
                success: function (data) {
                    if (!data.success) {
                        alert(data.message);
                        return;
                    }

                    var items = [];
                    $.map(data.suppliers, function (item) {
                        items.push({
                            label: item.name,
                            category: "Supplier",
                            type: "suppliers",
                            typeValue: item.id,
                            value: item.name,
                            data: item.MerchantProduct
                        });
                    });

                    $.map(data.brands, function (item) {
                        items.push({
                            label: item.name,
                            category: "Brand",
                            type: "brands",
                            typeValue: item.id,
                            value: item.name,
                            data: item.MerchantProduct
                        });
                    });

                    $.map(data.types, function (item) {
                        items.push({
                            label: item.name,
                            category: "Type",
                            type: "types",
                            typeValue: item.id,
                            value: item.name,
                            data: item.MerchantProduct
                        });
                    });

                    $.map(data.tags, function (item) {
                        items.push({
                            label: item.name,
                            category: "Tag",
                            type: "tags",
                            typeValue: item.id,
                            value: item.name,
                            data: item.MerchantProduct
                        });
                    });

                    $.map(data.products, function (item) {
                        var label = item.name;
                        if (item.variant_option_one_name != '') {
                            label += " / " + item.variant_option_one_value
                        }
                        if (item.variant_option_two_name != '') {
                            label += " / " + item.variant_option_two_value
                        }
                        if (item.variant_option_three_name != '') {
                            label += " / " + item.variant_option_three_value
                        }

                        items.push({
                            label: label,
                            category: "Product",
                            type: "products",
                            typeValue: item.id,
                            value: item.sku,
                            data: item
                        });
                    });

                    response(items);
                }
            });
        },
        minLength: 2,
        select: function( event, ui ) {
            var category = ui.item.category;
            var name = ui.item.label;
            var type = ui.item.type;
            var typeValue =  ui.item.typeValue;
            var found = false;
            var data = ui.item.data;

            if (ui.item.category == 'Product') {
                addProduct(data.id, data, type, typeValue);
            } else {
                $.each(data, function(index, product) {
                    addProduct(product.id, product, type, typeValue);
                });
            }

            for (var index in filters) {
                if (type == filters[index]['type'] && typeValue == filters[index]['value']) {
                    found = true;
                }
            }

            if (!found) {
                filters.push({
                    category: category,
                    name: name,
                    type: type,
                    value: typeValue
                })
                $("#filters").val(JSON.stringify(filters));
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

}

function addProduct(id, data, type, value) {
    if (products[id] == null) {
        products[id] = {
            product: data,
            types: []
        };
    }

    products[id].types.push({
        type: type,
        value: value
    });

    $("#products").val(JSON.stringify(products));
}

function removeFilter(filter) {
    var type = $(filter).attr('data-type');
    var value = $(filter).attr('data-value');
    var temp = [];

    $.each(filters, function(idx, item) {
        if (item.type != type || item.value != value) {
            temp.push(item);
        }
    });
    filters = temp;
    $("#filters").val(JSON.stringify(filters));

    $.each(products, function(id, data) {
        var types = data.types;
        var product = data.product;
        var temp = [];

        $.each(types, function(idx, item) {
            if (item.type != type || item.value != value) {
                temp.push(item);
            }
        });
        data.types = temp;

        if (temp.length == 0) {
            delete products[id];
        }
    });
    $("#products").val(JSON.stringify(products));

    updateView();
}

function updateView() {
    $(".filter-selection").empty();
    $(".dataTable tbody").empty();

    if (isFullCount == 0) {
        $(".full-count").css('display', 'none');
        $(".product-search-container").css('display', '');

        if (Object.keys(products).length == 0) {
            $(".dataTable").css('display', 'none');
            $(".no-list").css('display', '');

            $(".save").attr('disabled', true);
            $(".start").attr('disabled', true);
        } else {
            $(".dataTable").css('display', '');
            $(".no-list").css('display', 'none');

            $(".save").attr('disabled', false);
            $(".start").attr('disabled', false);
        }

        var index = 0;
        $.each(products, function(id, data) {
            product = data.product;
            $('.dataTable tbody').append('<tr><td><input type="hidden" value="' + id +'" /><p class="pull-left margin-right-10">' + product.name + '</p><h6 class="pull-left" style="margin-top: 3px;">' + product.sku + '</h6></td></tr>');
            index++;
        });

        if (filters.length > 0) {
            var temp = '<div class="filter-product-results">';
            temp += filters.length + (filters.length > 1 ? ' RESULTS' : ' RESULT') + '</div>';
            $('.filter-selection').append(temp);
        }

        $.each(filters, function(idx, filter) {
            var temp = '<div class="filter-tag-group">';
            temp += '<span class="filter-tag-group-title">' + filter['category'] + ':</span>';
            temp += '<div class="filter-tag-items">'
            temp += '<span class="filter-tag-item">' + filter['name'];
            temp += '<a class="filter-tag-item-remove clickable" data-type="' + filter['type'] + '" data-value="' + filter['value'] + '" onclick="removeFilter(this);">';
            temp += '<i class="glyphicon glyphicon-remove"></i></a></span></div></div>';
            $('.filter-selection').append(temp);
        });
    } else {
        $(".full-count").css('display', '');
        $(".product-search-container").css('display', 'none');

        $(".save").attr('disabled', false);
        $(".start").attr('disabled', false);
    }
}

// form validation
var formValidation = function() {
    // for more info visit the official plugin documentation: 
    // http://docs.jquery.com/Plugins/Validation
    $("#stock_take_form").validate({
        rules: {
            'data[MerchantStockTake][outlet_id]': {
                required: true 
            },
            'data[MerchantStockTake][start_date]': {
                required: true,
                dateFormat: true
            },
            'data[MerchantStockTake][start_time]': {
                required: true,
                timeFormat: true
            }
        },
        messages: {
            'data[MerchantStockTake][outlet_id]': {
                required: "Required"
            },
            'data[MerchantStockTake][start_date]': {
                required: "Please enter a valid date. The date format is YYYY-MM-DD",
                dateFormat: "Please enter a valid date. The date format is YYYY-MM-DD"
            },
            'data[MerchantStockTake][start_time]': {
                required: "Please enter a valid time. The date format is hh:mm am/pm",
                timeFormat: "Please enter a valid time. The date format is hh:mm am/pm"
            }
        },
    });

    jQuery.validator.addMethod("dateFormat", function(value, element) {
        //match date in format YYYY-MM-DD
        var dateRegex = /[0-9]{4}.(0[1-9]|1[012]).(0[1-9]|1[0-9]|2[0-9]|3[01])/;
        return dateRegex.test(value);
    });

    jQuery.validator.addMethod("timeFormat", function(value, element) {
        //match time in format hh:mm am/pm
        var timeRegex = /^([0-9]|0[0-9]|1[0-2])(:[0-5][0-9]){1}\s?(am|pm){1}/i;
        return timeRegex.test(value);
    });
}
</script>
<!-- END JAVASCRIPTS -->
