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
                <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">Customer Group</h2>
                <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20">
                    <button id="add_group" class="btn btn-white pull-right">
                        <div class="glyphicon glyphicon-plus"></div>&nbsp;
                    Add</button>
                </div>
            </div>

            <table id="groupTable" class="table-bordered">
                <colgroup>
                   <col width="25%">
                   <col width="25%">
                   <col width="25%">
                   <col width="25%">
                </colgroup>
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Created</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach($groups as $group){ ?>
                    <tr data-id="<?php echo $group['MerchantCustomerGroup']['id'];?>">
                        <td class="group_name"><?php echo $group['MerchantCustomerGroup']['name'];?></td>
                        <td class="group_code"><?php echo $group['MerchantCustomerGroup']['group_code'];?></td>
                        <td><?php echo $group['MerchantCustomerGroup']['created'];?></td>
                        <td><?php if($group['MerchantCustomerGroup']['name'] !== 'All Customers'){;?>
                            <span class="clickable edit">Edit</span> |
                            <span class="clickable delete">Delete</span>
                        <?php } ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
            
        </div>
    </div>
    <!-- END CONTENT -->
    <!-- ADD GROUP POPUP BOX -->
    <div id="popup-add_group" class="confirmation-modal modal fade in" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="confirm-close" data-dismiss="modal" aria-hidden="true">
                    <i class="glyphicon glyphicon-remove"></i>
                    </button>
                    <h4 class="modal-title">Add New Group</h4>
                </div>
                <div class="modal-body">
                    <dl>
                        <dt>Group Name</dt>
                        <dd><input type="text" id="group_name"></dd>
                        <dt>Group Code</dt>
                        <dd><input type="text" id="group_code"></dd>
                    </dl>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary confirm-close">Cancel</button>
                    <button class="btn btn-success add_submit">Add</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ADD GROUP POPUP BOX END -->
    <!-- EDIT GROUP POPUP BOX -->
    <div id="popup-edit_group" class="confirmation-modal modal fade in" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="confirm-close" data-dismiss="modal" aria-hidden="true">
                    <i class="glyphicon glyphicon-remove"></i>
                    </button>
                    <h4 class="modal-title">Edit Group</h4>
                    <input type="hidden" id="group_id_edit">
                </div>
                <div class="modal-body">
                    <dl>
                        <dt>Group Name</dt>
                        <dd><input type="text" id="group_name_edit"></dd>
                        <dt>Group Code</dt>
                        <dd><input type="text" id="group_code_edit"></dd>
                    </dl>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary confirm-close">Cancel</button>
                    <button class="btn btn-success edit_submit">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- EDIT GROUP POPUP BOX END -->
</div>
<div class="modal-backdrop fade in" style="display: none;"></div>
<!-- END CONTAINER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="assets/global/plugins/respond.min.js"></script>
<script src="assets/global/plugins/excanvas.min.js"></script> 
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
<script type="text/javascript" src="/assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="/assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="/js/dataTable.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core components
    Layout.init(); // init current layout
    QuickSidebar.init() // init quick sidebar
    
    $("#groupTable").DataTable({
        searching: false
    });
    $("#groupTable_length").hide();
    
    $("#add_group").click(function(){
        $("#popup-add_group").show();
        $(".modal-backdrop").show();
    });
    $(".edit").click(function(){
        $("#group_name_edit").val($(this).parents("tr").find('.group_name').text());
        $("#group_code_edit").val($(this).parents("tr").find('.group_code').text());
        $("#group_id_edit").val($(this).parents("tr").attr('data-id'));
        $("#popup-edit_group").show();
        $(".modal-backdrop").show();
    });
    $(".confirm-close").click(function(){
         $("#popup-add_group").hide();
         $("#popup-edit_group").hide();
         $(".modal-backdrop").hide();
    });
    
    $(".add_submit").click(function(){
        $.ajax({
            url: '/customer/add_group.json',
            type: 'POST', 
            data: {
                name: $("#group_name").val(),
                group_code: $("#group_code").val()
            },
            success: function(){
                location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(textStatus, errorThrown);
            }
        });
    });
    $(".edit_submit").click(function(){
        $.ajax({
            url: '/customer/edit_group.json',
            type: 'POST',
            data: {
                id: $("#group_id_edit").val(),
                name: $("#group_name_edit").val(),
                group_code: $("#group_code_edit").val()
            },
            success: function(){
                location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(textStatus, errorThrown);
            }
        });
    });
    $(".delete").click(function(){
        var target_id = $(this).parents('tr').attr('data-id');
        $.ajax({
            url: '/customer/delete_group.json',
            type: 'POST',
            data: {
                id: target_id
            },
            success: function(){
                location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(textStatus, errorThrown);
            }
        });
    });
});
</script>
<!-- END JAVASCRIPTS -->