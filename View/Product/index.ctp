<style>
.added_tag {
    border: 1px solid #ddd;
    border-radius: 8px;
    background: #eee;
    padding: 5px 10px;
}
</style>
<link href="/css/dataTable.css" rel="stylesheet" type="text/css">
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
        
        
            <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega margin-bottom-20">
                <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
                    STOCK
                </h2>
                
                <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20">
                    <button id="import" class="btn btn-white pull-right btn-right" style="color:black">
                        <div class="glyphicon glyphicon-import"></div>&nbsp;
                    import</button>
                    <a href="#" id="export"><button class="btn btn-white pull-right btn-center">
                        <div class="glyphicon glyphicon-export"></div>&nbsp;
                    export</button></a>
                    <a href="product/add"><button class="btn btn-white pull-right btn-left">
                        <div class="glyphicon glyphicon-plus"></div>&nbsp;
                    Add</button></a> 
                    <div>
                        <input type="file" name="File Upload" id="txtFileUpload" style="display:none" accept=".csv"> 
                    </div>
                </div>
            </div>
                
            <!-- FILTER -->
            <form class="col-md-12 col-xs-12 col-sm-12 line-box filter-box" action="/product" method="get">
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <dl>
                        <dt>Show</dt> 
                        <dd>
                            <select name="is_active" class="status">
                                <option value="1" class="active_product_count" <?php if(isset($_GET['is_active']) && $_GET['is_active'] == 1){echo "selected";}?>>Active products</option>
                                <option value="0" class="inactive_product_count" <?php if(isset($_GET['is_active']) && $_GET['is_active'] == 0){echo "selected";}?>>Inactive products</option>
                                <option value="" class="product_count" <?php if(isset($_GET['is_active']) && $_GET['is_active'] == ""){echo "selected";}?>>All products</option>
                            </select>
                        </dd>

                        <dt>Name / SKU / Handle</dt>
                        <dd><input type="text" name="name" value="<?php if(isset($_GET['name'])){echo $_GET['name'];}?>"></dd>
                        <dt>Tag</dt>
                        <dd>
                            <input type="search" list="tag" id="tag_search" class="col-md-7" autocomplete="off">
                            <datalist id="tag">
                                <?php foreach($tags as $tag) { ?>
                                <option value="<?php echo $tag['MerchantProductTag']['name'];?>">
                                <?php } ?>
                            </datalist>
                            <button type="button" class="col-md-4 btn btn-default pull-right" style="height: 30px;" id="add_tag">ADD</button>
                        </dd>
                    </dl> 
                </div>
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <dl>
                        <dt>Product type</dt>
                        <dd><select name="product_type_id">
                            <option value=""></option>
                            <?php foreach($types as $type){?>
                            <option value="<?=$type['MerchantProductType']['id'];?>" <?php if(isset($_GET['product_type_id']) && $_GET['product_type_id'] == $type['MerchantProductType']['id']){echo "selected";}?>><?=$type['MerchantProductType']['name'];?></option>
                            <?php } ?>
                        </select></dd>
                           <dt>Brand</dt>
                        <dd><select name="product_brand_id">
                            <option value=""></option>
                            <?php foreach($brands as $brand){?>
                            <option value="<?=$brand['MerchantProductBrand']['id'];?>" <?php if(isset($_GET['product_brand_id']) && $_GET['product_brand_id'] == $brand['MerchantProductBrand']['id']){echo "selected";}?>><?=$brand['MerchantProductBrand']['name'];?></option>
                            <?php } ?>
                        </select></dd>
                    </dl>
                 </div>
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <dl>
                        <dt>Supplier</dt>
                        <dd><select name="supplier_id">
                        <option></option>
                        <?php foreach($suppliers as $supplier){?>
                            <option value="<?=$supplier['MerchantSupplier']['id'];?>" <?php if(isset($_GET['supplier_id']) && $_GET['supplier_id'] == $supplier['MerchantSupplier']['id']){echo "selected";}?>><?=$supplier['MerchantSupplier']['name'];?></option>
                            <?php } ?>
                        </select></dd>
                    </dl>
                 </div>
                 <div class="col-md-12 col-xs-12 col-sm-12 tag_list" style="margin-top:15px;">
                     <?php if(!empty($_GET['tag'])) {
                         foreach($_GET['tag'] as $key => $tag) { ?>
                             <div class="tag_wrap" sqn="<?php echo $key;?>">
                                 <div class="added_tag" style="width:8%; text-align:center; float:left"><?php echo $tag;?> <span class="remove_tag clickable"><i class="glyphicon glyphicon-remove"></i></span></div>
                                 <input type="hidden" name="tag[<?php echo $key;?>]" value="<?php echo $tag;?>">
                             </div>
                         <?php }
                     } ?>
                 </div>
                 <div class="col-md-12 col-xs-12 col-sm-12">
                     <button class="btn btn-primary filter pull-right">Update</button>
                 </div>
            </form>


            <br>
            <table id="productTable" class="table-bordered">
                <colgroup>
                    <col width="15%">
                    <col width="10%">
                    <col width="15%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                    <col width="5%">
                    <col width="15%">
                </colgroup>
                <thead>
                <tr>
                    <th>name</th>
                    <th class="hidden">id</th>
                    <th>created</th>
                    <th>handle</th>
                    <th>type</th>
                    <th>brand</th>
                    <th class="hidden">supplier_id</th>
                    <th class="hidden">supplier_code</th>
                    <th class="hidden">supply_price</th>
                    <th class="hidden">markup</th>
                    <th class="hidden">retail_price</th>
                    <th>Variants</th>
                    <th>price_include_tax</th>
                    <th class="hidden">tax_value</th>
                    <th class="hidden">tax_id</th>
                    <th class="hidden">description</th>
                    <th class="hidden">image</th>
                    <th class="hidden">image_large</th>
                    <th class="hidden">has_variants</th>
                    <th class="hidden">variant_option_one_name</th>
                    <th class="hidden">variant_option_one_value</th>
                    <th class="hidden">variant_option_two_name</th>
                    <th class="hidden">variant_option_two_value</th>
                    <th class="hidden">variant_option_three_name</th>
                    <th class="hidden">variant_option_three_value</th>
                    <th>sku</th>
                    <th class="hidden">stock_type</th>
                    <th class="hidden">track_inventory</th>
                    <th class="hidden">active</th>
                    <th class="last-child"></th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach($items as $item){?>
                    <tr <?php if(!empty($item['MerchantProduct']['parent_id'])){echo 'style="display: none;"';}?>>
                        <td><?=$item['MerchantProduct']['name'];?></td>
                        <td class="hidden"><?=$item['MerchantProduct']['id'];?></td>
                        <td><?=date("d M Y",strtotime($item['MerchantProduct']['created']));?></td>
                        <td><?=$item['MerchantProduct']['handle'];?></td>
                        <td><?=$item['MerchantProductType']['name'];?></td>
                        <td><?=$item['MerchantProductBrand']['name'];?></td>
                        <td class="hidden"><?=$item['MerchantProduct']['supplier_id'];?></td>
                        <td class="hidden"><?=$item['MerchantProduct']['supplier_code'];?></td>
                        <td class="hidden"><?=$item['MerchantProduct']['supply_price'];?></td>
                        <td class="hidden"><?=$item['MerchantProduct']['markup'];?></td>
                        <td class="hidden"><?=$item['MerchantProduct']['price'];?></td>
                        <td>
                            <?php if(empty($item['Variants'])){
                                echo "None";
                            } else {
                                echo '<span data-id="'.$item['MerchantProduct']['id'].'" class="clickable check_variants">'.count($item['Variants']).' variants</span>';
                            }?>
                        </td>
                        <td><?=number_format($item['MerchantProduct']['price_include_tax'],2,'.','');?></td>
                        <td class="hidden"><?=$item['MerchantProduct']['tax'];?></td>
                        <td class="hidden"><?=$item['MerchantProduct']['tax_id'];?></td>
                        <td class="hidden"><?=$item['MerchantProduct']['description'];?></td>
                        <td class="hidden"><?=$item['MerchantProduct']['image'];?></td>
                        <td class="hidden"><?=$item['MerchantProduct']['image_large'];?></td>
                        <td class="hidden"><?=$item['MerchantProduct']['has_variants'];?></td>
                        <td class="hidden"><?=$item['MerchantProduct']['variant_option_one_name'];?></td>
                        <td class="hidden"><?=$item['MerchantProduct']['variant_option_one_value'];?></td>
                        <td class="hidden"><?=$item['MerchantProduct']['variant_option_two_name'];?></td>
                        <td class="hidden"><?=$item['MerchantProduct']['variant_option_two_value'];?></td>
                        <td class="hidden"><?=$item['MerchantProduct']['variant_option_three_name'];?></td>
                        <td class="hidden"><?=$item['MerchantProduct']['variant_option_three_value'];?></td>
                        <td><?=$item['MerchantProduct']['sku'];?></td>
                        <td class="hidden"><?=$item['MerchantProduct']['stock_type'];?></td>
                        <td class="hidden"><?=$item['MerchantProduct']['track_inventory'];?></td>
                        <td class="hidden"><?=$item['MerchantProduct']['is_active'];?></td>
                        <td>
                            <a href="/product/<?=$item['MerchantProduct']['id'];?>">View</a> | 
                            <a href="/product/<?=$item['MerchantProduct']['id'];?>/edit">Edit</a> | 
                            <span data-id="<?php echo $item['MerchantProduct']['id'];?>" class="clickable <?php if($item['MerchantProduct']['is_active'] == 0){echo "active_product";}else{echo "inactive_product";}?>"><?php if($item['MerchantProduct']['is_active'] == 0){echo "Active";}else{echo "Inactive";}?></span>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

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
    
    $(".filter").click(function(){
      window.location.href = 'product?status='+$(".status").val(); 
    });
    
    $("#productTable").DataTable({
        searching: false
    });
    $("#productTable_length").hide();
    
    $(document).on('click','.active_product',function(){
        $.ajax({
            url: '/product/change_status.json',
            type: 'POST',
            data: {
                product_id: $(this).attr("data-id"),
                is_active: 1
            },
            success: function(result){
                if(result.success) {
                    // do nothing
                } else {
                    console.log(result);
                }
            }
        });
        $(this).removeClass("active_product");
        $(this).addClass("inactive_product");
        $(this).text('Inactive');
    });
    $(document).on('click','.inactive_product',function(){
        $.ajax({
            url: '/product/change_status.json',
            type: 'POST',
            data: {
                product_id: $(this).attr("data-id"),
                is_active: 0
            },
            success: function(result){
                if(result.success) {
                    // do nothing
                } else {
                    console.log(result);
                }
            }
        });
        $(this).removeClass("inactive_product");
        $(this).addClass("active_product");
        $(this).text('Active');
    });
});
</script>

<!-- END JAVASCRIPTS -->
<script src="/js/jquery.csv-0.71.js" type="text/javascript"></script>
<script>
$(document).ready(function () {

    function exportTableToCSV($table, filename) {
        var $headers = $("#productTable").find('tr:has(th)')
            ,$rows = $("#productTable").find('tr:has(td)')

            // Temporary delimiter characters unlikely to be typed by keyboard
            // This is to avoid accidentally splitting the actual contents
            ,tmpColDelim = String.fromCharCode(11) // vertical tab character
            ,tmpRowDelim = String.fromCharCode(0) // null character

            // actual delimiter characters for CSV format
            ,colDelim = '","'
            ,rowDelim = '"\r\n"';

            // Grab text from table into CSV formatted string
            var csv = '"';
            csv += formatRows($headers.map(grabRow));
            csv += rowDelim;
            csv += formatRows($rows.map(grabRow)) + '"';

            // Data URI
            var csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

        $(this)
            .attr({
            'download': filename
                ,'href': csvData
                //,'target' : '_blank' //if you want it to open in a new window
        });

        //------------------------------------------------------------
        // Helper Functions 
        //------------------------------------------------------------
        // Format the output so it has the appropriate delimiters
        function formatRows(rows){
            return rows.get().join(tmpRowDelim)
                .split(tmpRowDelim).join(rowDelim)
                .split(tmpColDelim).join(colDelim);
        }
        // Grab and format a row from the table
        function grabRow(i,row){
             
            var $row = $(row);
            //for some reason $cols = $row.find('td') || $row.find('th') won't work...
            var $cols = $row.find('td'); 
            if(!$cols.length) $cols = $row.find('th');  

            return $cols.map(grabCol)
                        .get().join(tmpColDelim);
        }
        // Grab and format a column from the table 
        function grabCol(j,col){
            var $col = $(col),
                $text = $col.text();

            return $text.replace('"', '""'); // escape double quotes

        }
    }


    // This must be a hyperlink
    $("#export").click(function (event) {
        // var outputFile = 'export'
        var outputFile = window.prompt("What do you want to name your output file") || 'export';
        outputFile = outputFile.replace('.csv','') + '.csv'
         
        // CSV
        exportTableToCSV.apply(this, [$('table'), outputFile]);
        
        // IF CSV, don't do event.preventDefault() or return false
        // We actually need this to be a typical hyperlink
    });
    
    var datas = [];

    $("#import[style='color:black']").click(function(){
        $("#txtFileUpload").toggle();
    });

    // Import CSV
    $("#txtFileUpload").change(function(e){
        if(e.target.files != undefined) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var csvval = e.target.result.split("\n");
                datas = $.csv.toObjects(e.target.result);
                $("#import").attr({"style":"color:red"});
                
                $("#import[style='color:red']").click(function(){
                    var i = 0;
                    $.each(datas, function(){
                        var id = datas[i]['id'];
                        var name = datas[i]['name'];
                        var handle = datas[i]['handle'];
                        var type = datas[i]['type'];
                        var brand = datas[i]['brand'];
                        var supplier_code = datas[i]['supplier_code'];
                        var supply_price = datas[i]['supply_price'];
                        var markup = datas[i]['markup'];
                        var price = datas[i]['price'];
                        var price_include_tax = datas[i]['price_include_tax'];
                        var tax = datas[i]['tax'];
                        var description = datas[i]['description'];
                        var image = datas[i]['image'];
                        var image_large = datas[i]['image_large'];
                        var has_variants = datas[i]['has_variants'];
                        var variant_option_one_name = datas[i]['variant_option_one_name'];
                        var variant_option_one_value = datas[i]['variant_option_one_value'];
                        var variant_option_two_name = datas[i]['variant_option_two_name'];
                        var variant_option_two_value = datas[i]['variant_option_two_value'];
                        var variant_option_three_name = datas[i]['variant_option_three_name'];
                        var variant_option_three_value = datas[i]['variant_option_three_value'];
                        var sku = datas[i]['sku'];
                        var stock_type = datas[i]['stock_type'];
                        var track_inventory = datas[i]['track_inventory'];
                        var is_active = datas[i]['active'];
                        
                        //RUN AJAX HERE
                        
                        $.ajax({
                            url: '/product/add.json',
                            type: 'POST',
                            data: {
                                name: name,
                                handle: handle,
                                supply_price: supply_price,
                                markup: markup,
                                price: price,
                                price_include_tax: price_include_tax,
                                description: description,
                                tax: tax,
                                variant_option_one_name: variant_option_one_name,
                                variant_option_one_value: variant_option_one_value,
                                variant_option_two_name: variant_option_two_name,
                                variant_option_two_value: variant_option_two_value,
                                variant_option_three_name: variant_option_three_name,
                                variant_option_three_value: variant_option_three_value,
                                sku: sku,
                                image: 'no-image.png',
                                stock_type: stock_type,
                                track_inventory: track_inventory,
                                is_active: is_active
                            }
                        });
                        i++;
                    });
                    location.reload();
                });
                
            }
            reader.readAsText(e.target.files.item(0));
        }
    });
    var i = $(".tag_wrap").length;
    $("#add_tag").click(function() {
        var tag_name = $("#tag_search").val();
        var tag_available = false;
        $("datalist option").each(function(){
            if($(this).val() == tag_name) {
                tag_available = true;
            }
        });
        if(tag_available) {
            $(".tag_list").append('<div class="tag_wrap" sqn="'+i+'"></div>');
            $(".tag_wrap[sqn="+i+"]").append('<div class="added_tag" style="width:8%; text-align:center; float:left">'+tag_name+' <span class="remove_tag clickable"><i class="glyphicon glyphicon-remove"></i></span></div>');
            $(".tag_wrap[sqn="+i+"]").append('<input type="hidden" name="tag['+i+']" value="'+tag_name+'">');
            i++;
        }
    });
    $(document).on("click",".remove_tag",function() {
        $(this).parents(".tag_wrap").remove();
        i--;
    });
    $(".check_variants").click(function(){
        if($(this).hasClass("opened")) {
            $(".child_variant").remove();
            $(this).removeClass("opened");
        } else {
            $(this).addClass("opened");
            var target_tr = $(this).parents("tr");
            $('<tr class="variant_load"><td colspan="9" style="text-align:center;">retrieving data...</td></tr>').insertAfter(target_tr);
            $.ajax({
                url: '/product/check_variants.json',
                type: 'POST',
                data: {
                    product_id: $(this).attr("data-id")
                },
                success: function(result) {
                    $(".variant_load").remove();
                    if(result.success) {
                        var i = 0;
                        $(result.data).each(function() {
                            var product_id = result.data[i]['MerchantProduct']['id'];
                            var product_name = result.data[i]['MerchantProduct']['name'];
                            var option_one = result.data[i]['MerchantProduct']['variant_option_one_value'];
                            var option_two = result.data[i]['MerchantProduct']['variant_option_two_value'];
                            var option_three = result.data[i]['MerchantProduct']['variant_option_three_value'];
                            if(option_two.length > 0){
                                option_one += "/";
                            }
                            if(option_three.length > 0){
                                option_tow += "/";
                            }
                            $('<tr class="child_variant"><td colspan="5" style="border:0;"></td><td><a href="/product/'+ product_id +'/edit">'+ product_name +'/'+ option_one +''+ option_two +''+ option_three +'</a></td><td colspan="3" style="border:0;"></td></tr>').insertAfter(target_tr);
                            i++;
                        });
                    } else {
                        console.log(result);
                    }
                }
            });
        }
    });
});
</script>
