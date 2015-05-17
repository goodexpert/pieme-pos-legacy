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
                    <h4 class="col-lg-5 col-md-6 col-xs-12 col-sm-7 col-alpha"><?php echo $take['MerchantStockTake']['name']; ?></h4>
                    <h5 class="col-lg-7 col-md-6 col-xs-12 col-sm-5 col-alpha col-omega"><?php echo $take['MerchantStockTake']['full_count'] == '1' ? 'Full Count' : 'Partial Count'; ?></h5>
                    <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                        <h5 class="col-lg-4 col-md-5 col-xs-12 col-sm-6 col-alpha col-omega">
                            <span class="glyphicon glyphicon-calendar"></span>&nbsp;
                            Start: <?php echo date('d F Y, g:i A', strtotime($take['MerchantStockTake']['start_date'])); ?>
                        </h5>
                        <h5 class="col-lg-8 col-md-7 col-xs-12 col-sm-6 col-alpha col-omega">
                            <span class="glyphicon glyphicon-map-marker"></span>&nbsp;
                            <?php echo $take['MerchantOutlet']['name']; ?>
                        </h5>
                    </div>
                    <div class="col-md-12 col-xs-12 col-sm-12 col-alpha count-input">
                        <div class="col-md-6 col-xs-6 col-sm-6 col-alpha">
                            <input type="text" placeholder="Search Products" id="product_search">
                        <div class="col-md-3 col-xs-3 col-sm-3 col-alpha">
                            <input type="text" class="btn-left"></div>
                            <button class="btn btn-success btn-right" style="width:50%;">Count</button>
                        </div>
                        <div class="col-md-3 col-xs-3 col-sm-3 col-alpha">
                            <input type="checkbox" value="1" checked="">
                            <label>Quick-scan mode</label>
                        </div>
                        <div class="search_result" style="display:none;">
                            <span class="search-tri"></span>
                            <div class="search-default"> No Result </div>
                            <?php foreach ($products as $product) : ?>
                            <button type="button" class="data-found" data-stock-take-id="<?php echo $take['MerchantStockTake']['id']; ?>" data-name="<?php echo $product['MerchantProduct']['name']; ?>" data-id="<?php echo $take['MerchantProduct']['id']; ?>"><?php echo $product['MerchantProduct']['name'] . '(' . $product['MerchantProduct']['sku'] . ')'; ?></button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                        <div class="inventory-content">
                            <div class="inventory-tab">
                                <ul>
                                    <li class="active">All</li>
                                    <li>Counted</li>
                                    <li>Uncounted</li>
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
                                            <th>COUNTED</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!--
                                        <tr role="row" class="odd">
                                            <td>Coffee
                                                <h6 class="inline-block-z margin-left-10">Black coffee</h6>
                                            </td>
                                            <td>-65</td>
                                            <td>1</td>
                                        </tr>
                                        <tr role="row" class="even">
                                            <td>Coffee
                                                <h6 class="inline-block-z margin-left-10">Black coffee</h6>
                                            </td>
                                            <td>-65</td>
                                            <td>1</td>
                                        </tr>
                                        -->
                                        <?php
                                            if ( count($take['MerchantStockTakeItem']) > 0 ):
                                                foreach ($take['MerchantStockTakeItem'] as $item):
                                        ?>
                                        <tr>
                                            <td><?php echo $item['MerchantProduct']['name']; ?> 
                                                <h6 class="inline-block-z margin-left-10"><?php echo $item['MerchantProduct']['sku']; ?></h6>
                                            </td>
                                            <td><?php echo $item['expected']; ?></td>
                                            <td><?php echo $item['counted']; ?></td>
                                        </tr>
                                        <?php
                                                endforeach;
                                            else:
                                        ?>
                                        <tr>
                                            <td colspan="3">There is no items ...</td>
                                        </tr>
                                        <?php
                                            endif;
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pull-right col-md-3 col-xs-3 col-sm-3 col-omega margin-top-20">
                    <div class="last-counted">
                        <h4>Your last counted items</h4>
                        <div class="last-counted-list">
                            <!--
                            <ul>
                                <li class="pull-left">1 T-shirt (Demo)</li>
                                <li class="pull-right"><span class="remove inline-block"><span class="glyphicon glyphicon-remove"></span></span></li>
                            </ul>
                            <ul>
                                <li class="pull-left">1 T-shirt (Demo)</li>
                                <li class="pull-right"><span class="remove inline-block"><span class="glyphicon glyphicon-remove"></span></span></li>
                            </ul>
                            -->
                            <?php
                                foreach ($take['MerchantStockTakeCount'] as $count):
                            ?>
                            <ul>
                                <li class="pull-left"><?php echo $count['MerchantProduct']['name']; ?></li>
                                <li class="pull-right"><span class="remove inline-block"><span class="glyphicon glyphicon-remove"></span></span></li>
                            </ul>
                            <?php
                                endforeach;
                            ?>
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
jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    Index.init();

    /* DYNAMIC PROUCT SEARCH START */
    
    var $cells = $(".data-found");
    $(".search_result").hide();

    $(document).on("keyup","#product_search",function() {
        console.log($(this).val());
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
            console.log($(".search_result").height());
        }
        $cells.click(function(){
           $("#search").val($(this).text());
        });
    });

    /* DYNAMIC PRODUCT SEARCH END */
});
</script>
<!-- END JAVASCRIPTS -->
