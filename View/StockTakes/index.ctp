<style>
.order-product-header {
    background: #eee;
    margin-bottom: 20px;
    padding: 10px 15px;
}
.line-box {
    padding: 0;
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
                    <a href="/">Sell</a>
                </li>
                <li>
                    <a href="history">History</a>
                </li>
                <li class="active">
                    <a href="history">Product<span class="selected"></span></a>
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
                        Inventory Count
                    </h2>
                    <h5>Create, schedule and complete counts to keep track of your inventory.</h5>
                </div>
                <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20">
                    <a href="/stock_takes/create">
                        <button id="" class="btn btn-white pull-right" style="color:black">
                            <div class="glyphicon glyphicon-plus"></div>&nbsp;
                            New inventory count
                        </button>
                    </a>
                </div>
            </div>
            <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                <div class="summary-container">
                    <div class="summary">
                        <a class="summary-item active">Due</a>
                        <a class="summary-item">Upcoming</a>
                        <a class="summary-item">Complted</a>
                        <a class="summary-item">Cancelled</a>
                    </div>
                </div>
                <div class="stocktake-landing-list stocktakes-list">
                    <table class="table-bordered dataTable">
                        <colgroup>
                            <col width="5%">
                            <col width="55%">
                            <col width="20%">
                            <col width="20%">
                        </colgroup>
                        <thead>
                            <tr role="row">
                                <th>
                                <?php
                                    echo $this->Form->checkbox('select_all', array(
                                        'id' => 'select_all',
                                        'class' => 'checkbox select-all',
                                        'div' => false,
                                        'label' => false,
                                        'hiddenField' => false,
                                        'onclick' => 'toggleSelectAll();'
                                    ));
                                 ?>
                                </th>
                                <th>INVENTORY COUNT</th>
                                <th>OUTLET</th>
                                <th>COUNT</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (count($data) > 0) : ?>
                            <?php foreach ($data as $item) : ?>
                                <?php if ($item['order_status_id'] === 'stock_take_status_open') : ?>
                                    <tr class="clickable" data-href="/stock_takes/<?php echo $item['id']; ?>/edit">
                                <?php elseif ($item['order_status_id'] === 'stock_take_status_progressed') : ?>
                                    <tr class="clickable" data-href="/stock_takes/<?php echo $item['id']; ?>/perform">
                                <?php endif; ?>
                                        <td>
                                        <?php
                                            echo $this->Form->checkbox('select', array(
                                                'id' => 'select',
                                                'class' => 'checkbox select',
                                                'div' => false,
                                                'label' => false,
                                                'hiddenField' => false,
                                                'onclick' => 'toggleSelect();'
                                            ));
                                         ?>
                                        </td>
                                        <td>
                                            <?php echo $item['name']; ?>
                                        <?php if ( $item['order_status_id'] === 'stock_take_status_progressed' ) : ?>
                                            <span class="text-bg-blue">In progress</span>
                                        <?php endif; ?>
                                        </td>
                                        <td><?php echo $item['outlet_name']; ?></td>
                                        <td><?php echo $item['full_count'] == 1 ? 'Full' : 'Partial'; ?></td>
                                    </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">There is no data ...</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                    <div class="footer">
                        If you're experiencing problems with your product data, <a onclick="resyncData();">resync data</a> to load it again.
                    </div>
                </div>
                <div class="no-list text-center" style="display:none;">
                    <div class="margin-top-20"><img src="img/no-stock.png"></div>
                    <h4 class="margin-bottom-20">You have no upcoming inventory counts</h4>
                    <a href="/stock_takes/create">
                        <button id="" class="btn btn-white" style="color:black">
                            <div class="glyphicon glyphicon-plus"></div>&nbsp;
                        New inventory count</button>
                    </a>
                    <h5 class="margin-top-30">If you're experiencing problems with your product data, <a>resync data</a> to load it again.</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
    <div class="hidden-data">
        <input type="hidden" id="hidden-data" value='<?php echo json_encode($data); ?>' />
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
var inventoryCounts = JSON.parse($("#hidden-data").val());
var selectedTab = 'due';

jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    Index.init();

/*
    updateView();

    $("#inventory-tab-due").click(function(){
        $(".inventory-tab").find(".active").removeClass("active");
        $(this).addClass("active");

        selectedTab = 'due';
        updateView();
    });

    $("#inventory-tab-upcoming").click(function(){
        $(".inventory-tab").find(".active").removeClass("active");
        $(this).addClass("active");

        selectedTab = 'upcoming';
        updateView();
    });

    $("#inventory-tab-completed").click(function(){
        $(".inventory-tab").find(".active").removeClass("active");
        $(this).addClass("active");

        selectedTab = 'completed';
        updateView();
    });

    $("#inventory-tab-cancelled").click(function(){
        $(".inventory-tab").find(".active").removeClass("active");
        $(this).addClass("active");

        selectedTab = 'cancelled';
        updateView();
    });

    $(".checkbox").on("change", function(e) {
    });
 */

    $(".clickable").click(function() {
        window.document.location = $(this).data("href");
    });
});

function resyncData() {
}

function toggleSelect() {
}

function toggleSelectAll() {
}

/*
function updateView() {
    var arrayMap = inventoryCounts[selectedTab];
    var today = new Date();

    $("body").find(".hidden-data").remove();
    $("#productTable").find('tbody').empty();

    if (arrayMap == null || arrayMap.length == 0) {
        $("#productTable").find('tbody').append('<tr><td colspan="4">There is no data ...</td></tr>');
        $(".inventory-table").css('display', 'none');
        $(".no-list").css('display', '');
    } else {
        $(".inventory-table").css('display', '');
        $(".no-list").css('display', 'none');

        for (var key in arrayMap) {
            var appendString = '';

            if (arrayMap[key]['status'] == 'STOCKTAKE_SCHEDULED') {
                var start_date = new Date(arrayMap[key]['start_date']);
                var diff_date = new Date(start_date.getTime() - today.getTime()).getTime();

                appendString = '<tr>';
                appendString += '<td><input type="checkbox" class="checkbox" id="stocktake-selected" /></td>';
                if (diff_date < 0 && start_date.getDate() < today.getDate()) {
                    appendString += '<td class="clickable" data-href="/stock_takes/' + arrayMap[key]['id'] + '/edit"><p>' + arrayMap[key]['name'];
                    appendString += '<span class="text-bg-blue">OVERDUE</span></p></td>';
                } else {
                    appendString += '<td class="clickable" data-href="/stock_takes/' + arrayMap[key]['id'] + '/edit"><p>' + arrayMap[key]['name'] + '<p></td>';
                }
            } else {
                if (arrayMap[key]['status'] == 'STOCKTAKE_IN_PROGRESS_PROCESSED') {
                    appendString = '<tr>';
                    appendString += '<td></td>';
                    appendString += '<td class="clickable" data-href="/stock_takes/' + arrayMap[key]['id'] + '/perform"><p>' + arrayMap[key]['name'];
                    appendString += '<span class="text-bg-blue">IN PROGRESS</span></p></td>';
                } else {
                    appendString = '<tr>';
                    appendString += '<td></td>';
                    appendString += '<td class="clickable" data-href="/stock_takes/' + arrayMap[key]['id'] + '/view"><p>' + arrayMap[key]['name'] + '</p></td>';
                }
            }
            appendString += '<td>' + arrayMap[key]['outlet'] + '</td>';
            appendString += '<td>' + arrayMap[key]['count'] + '</td>';
            appendString += '</tr>';
            
            $("#productTable").find('tbody').append(appendString);
        }
    }
}
*/
</script>
<!-- END JAVASCRIPTS -->
