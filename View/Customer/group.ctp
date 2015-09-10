<link href="/css/dataTable.css" rel="stylesheet" type="text/css">
<div class="clearfix"></div>
    <!-- BEGIN CONTENT -->
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

    <!-- EDIT GROUP POPUP BOX END -->
<div class="modal-backdrop fade in" style="display: none;"></div>
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
          <!-- BEGIN CORE PLUGINS -->
          <?php echo $this->element('script-jquery'); ?>
          <?php echo $this->element('script-angularjs'); ?>
          <!-- END CORE PLUGINS --><!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/theme/onzsa/assets/global/plugins/select2/select2.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/theme/onzsa/assets/global/scripts/metronic.js"></script>
<script src="/theme/onzsa/assets/admin/layout/scripts/layout.js"></script>
<script src="/theme/onzsa/assets/admin/pages/scripts/index.js"></script>
<script src="/theme/onzsa/assets/admin/layout/scripts/quick-sidebar.js"></script>
<script src="/js/dataTable.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
          <!-- BEGIN COMMON INIT -->
          <?php echo $this->element('common-init'); ?>
        <!-- END COMMON INIT -->
<script>
jQuery(document).ready(function() {
  documentInit();
});

function documentInit() {
  // common init function
    commonInit();
    Metronic.init(); // init metronic core components
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
};
</script>
<!-- END JAVASCRIPTS -->
