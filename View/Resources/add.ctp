<link href="/css/dataTable.css" rel="stylesheet" type="text/css">
<div class="clearfix"></div>
<!-- BEGIN CONTENT -->
<div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega margin-bottom-20">
    <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
        Resource index
    </h2>

    <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20">
        <button class="add-resource btn btn-white pull-right">
            <div class="glyphicon glyphicon-plus"></div>
            &nbsp;
            Add
        </button>
    </div>
</div>
<table id="resourceTable" class="table-bordered dataTable no-footer" role="grid" aria-describedby="brandTable_info">
    <colgroup>
        <col width="25%">
        <col width="25%">
        <col width="25%">
        <col width="25%">
    </colgroup>
    <thead>
    <tr>
        <th>Type of resource</th>
        <th>Resource name</th>
        <th>Number of people</th>
        <th></th>
    </tr>
    </thead>
    <?php foreach ($resources as $resource) : ?>
        <tr>
            <td class="id" style="display: none;"><?= $resource['MerchantResource']['id']; ?></td>
            <td class="resource_type_id"><?= $resource['MerchantResource']['resource_type_id']; ?></td>
            <td class="name"><?= $resource['MerchantResource']['name']; ?></td>
            <td class="user_field_1"><?= $resource['MerchantResource']['user_field_1']; ?></td>
            <td>
                <a href="javascript:;" class="edit-resource">Edit</a> |
                <a href="javascript:;" class="delete-resource" data-id="<?= $resource['MerchantResource']['id']; ?>">Delete</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<!-- END CONTENT -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<!-- BEGIN CORE PLUGINS -->
<?php echo $this->element('script-jquery'); ?>
<?php echo $this->element('script-angularjs'); ?>
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
<script src="/js/jquery.confirm.js" type="text/javascript"></script>
<script src="/js/jquery.popupoverlay.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<?php echo $this->element('common-init'); ?>
<script>
jQuery(document).ready(function() {
    documentInit();
});

function documentInit() {
    // common init function
    commonInit();
    
    $("#typeTable").DataTable({
        searching: false
    });

    $("#typeTable_length").hide();

    $(".add-resource").confirm({
        title:'Input New Resource',
        text:'<select name="resource_type_table" id="resourceType" placeholder="Type of resource"><option value="resource_type_car_park">Car Park</option><option value="resource_type_room">Room</option><option value="resource_type_table">Table</option><option value="resource_type_vehicle">Vehicle</option><input type="text" name="name" id="resourceName" placeholder="Resource Name"><input type="text" name="people" id="resourcePeople" placeholder="Number of People">',
        confirmButton: "Add",
        confirm: function(button){
            $.ajax({
                url: "/resources/add.json",
                type: "POST",
                data: {
                    resource_type_id: $("#resourceType").val(),
                    name: $("#resourceName").val(),
                    user_field_1: $("#resourcePeople").val()
                },
                success: function(result){
                    if(result.success) {
                        location.reload();
                    } else {
                        console.log(result);
                    }
                }
            });
            return(false);
        },
        confirmButtonClass: "resource-add pull-right btn-success margin-left-10",
        cancel: function(button){
            $("input").val('');
        },
        cancelButton: "Cancel",
    });
    
    $(".edit-resource").click(function(){
        var id = $(this).parent().parent().children(".resource_type_id").text();
        var idd = $(this).parent().parent().children("id").text();

        $.confirm({
            title:'Edit resource',
            text:'<select name="resource_type_table" id="resourceType" placeholder="Type of resource" value="'+$(this).parent().parent().children(".resource_type_id").text()+'"><option value="resource_type_car_park">Car Park</option><option value="resource_type_room">Room</option><option value="resource_type_table">Table</option><option value="resource_type_vehicle">Vehicle</option><input type="text" name="name" id="resourceName" placeholder="Resource Name"  value="'+$(this).parent().parent().children(".name").text()+'"><input type="text" name="people" id="resourcePeople" placeholder="Number of People"  value="'+$(this).parent().parent().children(".user_field_1").text()+'">',
            confirmButton: "Edit",
            confirm: function(button){
                $.ajax({
                    url: "/resources/edit.json",
                    type: "POST",
                    data: {
                        resource_type_id: $("#resourceType").val(),
                        name: $("#resourceName").val(),
                        user_field_1: $("#resourcePeople").val(),
                                                id: idd
                    }
                }).done(function(){
                    location.reload();
                });
            },
            confirmButtonClass: "resource-edit pull-right btn-success margin-left-10",
            cancel: function(button){
                $("input").val('');
            },
            cancelButton: "Cancel",
        });
    });
    
    $(".delete-resource").click(function(){
        var id = $(this).attr("data-id");
        $.confirm({
            title:'Delete Resource',
            text:'Are you sure to delete this resource?',
            confirmButton: "Delete",
            confirm: function(button){
                            $.ajax({
                                url: "/resources.json",
                                type: "POST",
                                data: {
                                        to_delete: id
                                },
                success: function(result){
                                    if(result.success) {
                                        location.reload();
                                    } else {
                                        console.log(result);
                                    }
                }
                            });

                            return(false);
            },
            confirmButtonClass: "pull-right btn-success margin-left-10",
            cancelButton: "Cancel",
        });
    });
    
    $(document).on("click",".edit-resource",function(){
        document.getElementById('resourceType').value = $(this).parent().parent().children(".resource_type_id").text();
    });
}
</script>
<!-- END JAVASCRIPTS -->
