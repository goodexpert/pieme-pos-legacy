<link href="/css/dataTable.css" rel="stylesheet" type="text/css">

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
            <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega margin-bottom-20">
                <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
                    Sales Taxes
                </h2>
                <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20">
                    <button class="btn btn-white pull-right add-tax">
                        <div class="glyphicon glyphicon-plus"></div>&nbsp;
                    Add Sales Tax</button>
                </div>
            </div>
        <table id="historyTable" class="table table-striped table-bordered dataTable">
            <colgroup>
               <col width="33%">
               <col width="33%">
               <col width="33%">
            </colgroup>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Rate</th>
                    <th> </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($taxes as $tax) : ?>
                <tr>
                    <td><?php echo $tax['MerchantTaxRate']['name']; ?></td>
                    <td><?php echo round($tax['MerchantTaxRate']['rate'], 2)*100; ?>%</td>
                    <td><span class="clickable edit-tax" data-id="<?php echo $tax['MerchantTaxRate']['id'];?>">Edit</span> | 
                        <span class="clickable delete-tax" data-id="<?php echo $tax['MerchantTaxRate']['id'];?>">Delete</span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        </div>
    </div>
    <!-- END CONTENT -->
    <!-- ADD TAX POPUP BOX -->
    <div id="popup-add_tax" class="confirmation-modal modal fade in" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="confirm-close" data-dismiss="modal" aria-hidden="true">
                    <i class="glyphicon glyphicon-remove"></i>
                    </button>
                    <h4 class="modal-title">Add New Sales Tax</h4>
                </div>
                <div class="modal-body">
                    <dl>
                        <dt>Tax name</dt>
                        <dd><input type="text" id="tax_name"></dd>
                        <dt>Tax rate (%)</dt>
                        <dd><input type="text" id="tax_rate"></dd>
                    </dl>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary confirm-close">Cancel</button>
                    <button class="btn btn-success submit">Add</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ADD TAX POPUP BOX END -->
    <!-- EDIT TAX POPUP BOX -->
    <div id="popup-edit_tax" class="confirmation-modal modal fade in" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="confirm-close" data-dismiss="modal" aria-hidden="true">
                    <i class="glyphicon glyphicon-remove"></i>
                    </button>
                    <h4 class="modal-title">Edit Sales Tax</h4>
                </div>
                <div class="modal-body">
                    <dl>
                        <dt>Tax name</dt>
                        <dd><input type="text" id="tax_name-edit"></dd>
                        <dt>Tax rate (%)</dt>
                        <dd><input type="text" id="tax_rate-edit"></dd>
                    </dl>
                    <h5>Changing this tax rate will recalculate retail
prices for all products associated.</h5>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary confirm-close">Cancel</button>
                    <button class="btn btn-success edit-submit">Edit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- EDIT TAX POPUP BOX END -->
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
<div class="modal-backdrop fade in" style="display: none;"></div>
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

<script src="/js/notify.js" type="text/javascript"></script>
<script>
jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    QuickSidebar.init() // init quick sidebar
    Index.init();
    var target;
    $(".add-tax").click(function(){
        $("#popup-add_tax").show();
        $(".modal-backdrop").show();
    });
    $(".edit-tax").click(function(){
        $("#popup-edit_tax").show();
        $(".modal-backdrop").show();
        $("#tax_rate-edit").val($(this).parent().prev().text());
        $("#tax_name-edit").val($(this).parent().prev().prev().text());
        target = $(this).attr("data-id");
    });
    
    $(".confirm-close").click(function(){
        $("#popup-add_tax").hide();
        $("#popup-edit_tax").hide();
        $(".modal-backdrop").hide();
        $("#tax_rate").val('');
        $("#tax_name").val('');
    });
    
    $(".submit").click(function(){
        var tax_rate = $("#tax_rate").val().replace(/%/,'');
        $.ajax({
          url: '/taxes/add.json',
          type: 'POST',
          data: {
              name: $("#tax_name").val(),
              rate: tax_rate / 100
          },
          success: function(result) {
              if(result.success) {
                  location.reload();
	          } else {
    	          console.log(result);
	          }
          }
        });
    });
    $(".edit-submit").click(function(){
        var tax_rate = $("#tax_rate-edit").val().replace(/%/,'');
        $.ajax({
          url: '/taxes/edit.json',
          type: 'POST',
          data: {
              id: target,
              name: $("#tax_name-edit").val(),
              rate: tax_rate / 100
          },
          success: function(result) {
	          if(result.success) {
		          location.reload();
	          } else {
		          console.log(result);
	          }
          }
        });
    });
    $(".delete-tax").click(function(){
        target = $(this).attr("data-id");
        $.ajax({
            url: '/taxes/delete.json',
            type: 'POST',
            data: {
              id: target
            },
            success: function(result) {
	            if(result.success) {
		            location.reload();
	            } else {
		            console.log(result);
	            }
            }
        });
    });
});
</script>
<!-- END JAVASCRIPTS -->