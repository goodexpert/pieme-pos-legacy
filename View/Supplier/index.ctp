<link href="/css/dataTable.css" rel="stylesheet" type="text/css">
<div class="clearfix"></div>
<div id="notify"></div>
<!-- BEGIN CONTENT -->
<div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega margin-bottom-20">
    <h2 class="col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
        Supplier
    </h2>

    <div class="col-md-5 col-xs-5 col-sm-5 col-alpha col-omega">
        <a href="/supplier/add">
            <button class="btn btn-white pull-right margin-top-20">Add</button>
        </a>
    </div>
</div>

<table id="supplierTable" class="table-bordered">
    <colgroup>
        <col width="33%">
        <col width="33%">
        <col width="33%">
    </colgroup>
    <thead>
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($suppliers as $supplier) { ?>
        <tr data-id="<?= $supplier['MerchantSupplier']['id']; ?>">
            <td class="supplier_name"><?= $supplier['MerchantSupplier']['name']; ?></td>
            <td><?= $supplier['MerchantSupplier']['description']; ?></td>
            <td>
                <a href="/product?supplier_id=<?= $supplier['MerchantSupplier']['id']; ?>">View Products</a>
                | <a href="/supplier/edit?id=<?= $supplier['MerchantSupplier']['id']; ?>" class="edit-supplier">Edit</a>
                | <span class="clickable delete-supplier"
                        data-id="<?= $supplier['MerchantSupplier']['id']; ?>">Delete</span>
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

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/theme/onzsa/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/admin/pages/scripts/index.js" type="text/javascript"></script>
<script type="text/javascript" src="/js/jquery.confirm.js"></script>
<script src="/js/dataTable.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<?php echo $this->element('common-init'); ?>
<script>
jQuery(document).ready(function() {
    documentInit();
});

function documentInit() {
    // common init function
    commonInit();

    $("#supplierTable").DataTable({
        searching: false
    });

    $("#supplierTable_length").hide();

    $(".delete-supplier").click(function(){
        var id = $(this).attr("data-id");
        var parentTr = $(this).parent().parent()
        $.confirm({
            text:'Delete this supplier',
            confirmButton: "Delete",
            confirm: function(button){
                $.ajax({
                    url: "/supplier/delete.json",
                    type: "POST",
                    data: {
                        id: id
                    }
                }).done(function(result){
                    location.reload();
                });
            },
            confirmButtonClass: "pull-right btn-success margin-left-10",
            cancelButton: "Cancel",
        });
    });
}
</script>
