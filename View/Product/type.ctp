<link href="/css/dataTable.css" rel="stylesheet" type="text/css">

<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
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
                <li class="active">
                    <a href="index">
                    Sell <span class="selected">
                    </span>
                    </a>
                </li>
                <li>
                    <a href="history">
                    History </a>
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
                <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
                    Types
                </h2>
                <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20">
                    <button class="add-type btn btn-white pull-right">
                        <div class="glyphicon glyphicon-plus"></div>&nbsp;
                    Add</button>
                </div>
            </div>
            <table id="typeTable" class="table-bordered">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Number of Products</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    
                    <?php foreach($types as $type){ ?>
                    <tr>
                        <td><?=$type['MerchantProductType']['name'];?></td>
                        <td><?=count($type['MerchantProduct']);?></td>
                        <td>
                        View Products | 
                        <a href="javascript:;" class="edit-type" data-id="<?=$type['MerchantProductType']['id'];?>">Edit</a> | 
                        <a href="javascript:;" class="delete-type" data-id="<?=$type['MerchantProductType']['id'];?>">Delete</a>
                        </td>
                    </tr>
                    <?php } ?>
                    
                </tbody>
            </table>
            
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
<script src="/js/dataTable.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    QuickSidebar.init() // init quick sidebar
    Index.init();
    
    $("#typeTable").DataTable({
        searching: false
    });
    $("#typeTable_length").hide();
});
</script>
<!-- END JAVASCRIPTS -->
<script type="text/javascript" src="/js/jquery.confirm.js"></script>
<script type="text/javascript" src="/js/jquery.popupoverlay.js"></script>

<script>
$(document).ready(function(){
    $(".add-type").confirm({
        title:'Type new type',
        text:'<input type="text" id="type_name" placeholder="Type Name">',
        confirmButton: "Add",
        confirm: function(button){
            $.ajax({
                url: "/product/type",
                type: "POST",
                data: {
                    product_type_name: $("#type_name").val()
                }
            }).done(function(){
                location.reload();
            });
        },
        confirmButtonClass: "brand-add pull-right btn-success margin-left-10",
        cancel: function(button){
            $("input").val('');
        },
        cancelButton: "Cancel",
    });
    
    $(".edit-type").click(function(){
        var id = $(this).attr("data-id");
        $.confirm({
            title:'Edit type',
            text:'<input type="text" id="type_name" placeholder="Type Name" value="'+$(this).parent().parent().children(".sorting_1").text()+'">',
            confirmButton: "Edit",
            confirm: function(button){
                $.ajax({
                    url: "/product/type",
                    type: "POST",
                    data: {
                        id: id,
                        product_type_name: $("#type_name").val()
                    }
                }).done(function(){
                    location.reload();
                });
            },
            confirmButtonClass: "brand-edit pull-right btn-success margin-left-10",
            cancel: function(button){
                $("input").val('');
            },
            cancelButton: "Cancel",
        });
    });
    
    $(".delete-type").click(function(){
        var id = $(this).attr("data-id");
        $.confirm({
            title:'Delete type',
            text:'Are you sure to delete this type?',
            confirmButton: "Delete",
            confirm: function(button){
                $.ajax({
                    url: "/product/type",
                    type: "POST",
                    data: {
                        id: id
                    }
                }).done(function(){
                    location.reload();
                });
            },
            confirmButtonClass: "brand-delete pull-right btn-success margin-left-10",
            cancelButton: "Cancel",
        });
    });
    
    $(document).on("click",".edit-type",function(){
        $(".type_name_add").val($(this).parent("td").parent("tr").children(".type_name").text());
        $(".type_id_add").val($(this).attr("data-id"));
        $(".type_add").hide();
        $(".type_edit").show();
        $("#add_type_box").popup('show');
    });
});


</script>