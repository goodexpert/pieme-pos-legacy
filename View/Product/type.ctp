<link href="/css/dataTable.css" rel="stylesheet" type="text/css">
<div class="clearfix"></div>
    <!-- BEGIN CONTENT -->
    <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega margin-bottom-20">
        <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
            STOCK TYPES
        </h2>
        <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20">
            <button class="add-type btn btn-white pull-right">
                <div class="glyphicon glyphicon-plus"></div>&nbsp;
            Add</button>
        </div>
    </div>
    <table id="typeTable" class="table-bordered">
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
            <?php foreach($types as $type){ ?>
            <tr>
                <td><?=$type['MerchantProductType']['name'];?></td>
                <td><?=count($type['MerchantProduct']);?></td>
                <td>
                <a href="/product?product_type_id=<?php echo $type['MerchantProductType']['id'];?>">View Products</a> |
                <a href="javascript:;" class="edit-type" data-id="<?=$type['MerchantProductType']['id'];?>">Edit</a> |
                <a href="javascript:;" class="delete-type" data-id="<?=$type['MerchantProductType']['id'];?>">Delete</a>
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

    $("#typeTable").DataTable({
        searching: false
    });

    $("#typeTable_length").hide();

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
                    url: "/product/type_edit.json",
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
                    url: "/product/type_delete.json",
                    type: "POST",
                    data: {
                        to_delete: id
                    }
                }).done(function(result){
                    location.reload();
                });
            },
            confirmButtonClass: "pull-right btn-success margin-left-10",
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
};
</script>
