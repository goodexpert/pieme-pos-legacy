<link href="/css/dataTable.css" rel="stylesheet" type="text/css">
<div class="clearfix"></div>
    <div id="notify"></div>
    <!-- BEGIN CONTENT -->
    <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega margin-bottom-20">
        <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
            Tags
        </h2>
        <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20">
            <button class="add-tag btn btn-white pull-right">
                <div class="glyphicon glyphicon-plus"></div>&nbsp;
            New Tag</button>
        </div>
    </div>
    <br>
    <table id="tagTable" class="table-bordered">
        <colgroup>
           <col width="33%">
           <col width="33%">
           <col width="33%">
        </colgroup>
        <thead>
        <tr>
            <th>Name</th>
            <th>Number of Products</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            <?php foreach($tags as $tag){ ?>
            <tr>
                <td><?php echo $tag['MerchantProductTag']['name'];?></td>
                <td><?php echo count($tag['MerchantProductCategory']);?></td>
                <td>
                    <span data-id="<?php echo $tag['MerchantProductTag']['id'];?>" class="clickable edit-tag">Edit</span> |
                    <span data-id="<?php echo $tag['MerchantProductTag']['id'];?>" class="clickable delete-tag">Delete</span>
                </td>
            </tr>
            <?php } ?>
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
<script type="text/javascript" src="/js/jquery.confirm.js"></script>
<script type="text/javascript" src="/js/jquery.popupoverlay.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<?php echo $this->element('common-init'); ?>
<script>
jQuery(document).ready(function() {
    documentInit();
});


function documentInit() {
    // common init function
    commonInit();

    $("#tagTable").DataTable({
        searching: false
    });
    $("#tagTable_length").hide();

            
    $(".add-tag").confirm({
        title:'Add new tag',
        text:'<input type="text" id="tag_name" placeholder="Tag name">',
        confirmButton: "Add",
        confirm: function(button){
            $.ajax({
                url: "/product/tag.json",
                type: "POST",
                data: {
                    name: $("#tag_name").val()
                },
                success: function(result) {
                    if(result.success) {
                        location.reload();
                    } else {
                        alert(result.message);
                    }
                }
            });
        },
        confirmButtonClass: "tag-add pull-right btn-success margin-left-10",
        cancel: function(button){
            $("input").val('');
        },
        cancelButton: "Cancel"
    });
    
    $(".edit-tag").click(function(){
        var current_name = $(this).parents("tr").find(".sorting_1").text();
        var current_id = $(this).attr("data-id");
        $.confirm({
            title:'Edit tag',
            text:'<input type="text" id="tag_name" placeholder="Tag name" value="'+current_name+'">',
            confirmButton: "Save",
            confirm: function(button){
                $.ajax({
                    url: "/product/tag_edit.json",
                    type: "POST",
                    data: {
                        tag_id: current_id,
                        name: $("#tag_name").val()
                    },
                    success: function(result) {
                        if(result.success) {
                            location.reload();
                        } else {
                            alert(result.message);
                        }
                    }
                });
            },
            confirmButtonClass: "tag-add pull-right btn-success margin-left-10",
            cancel: function(button){
                $("input").val('');
            },
            cancelButton: "Cancel",
        })
    });
    
    $(".delete-tag").click(function(){
        var current_name = $(this).parents("tr").find(".sorting_1").text();
        var current_id = $(this).attr("data-id");
        $.confirm({
            text:'Are you sure want to delete this tag?',
            confirmButton: "Delete",
            confirm: function(button){
                $.ajax({
                    url: "/product/tag_delete.json",
                    type: "POST",
                    data: {
                        tag_id: current_id,
                        name: $("#tag_name").val()
                    },
                    success: function(result) {
                        if(result.success) {
                            location.reload();
                        } else {
                            alert(result.message);
                        }
                    }
                });
            },
            confirmButtonClass: "tag-add pull-right btn-success margin-left-10",
            cancel: function(button){
                $("input").val('');
            },
            cancelButton: "Cancel",
        })
    });
};
</script>
