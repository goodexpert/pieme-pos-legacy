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
        <div class="page-content" style="min-height:1383px">
            <div class="quick-key">
                <div class="new-layout">
                    <span class="quick-key-new-layout" >
                        <strong>Edit Stock List Layout</strong>
                    </span>
                    <div class="quick-key-btn" >
                        <button class="btn btn-primary cancel">Cancel</button>
                        <button class="btn btn-primary delete">Delete Layout</button>
                        <button class="btn btn-success save">Save Layout</button>
                    </div>
                </div>
                <div class="quick-key-top" >
                    <div class="quick-key-search">
                        <input type="search" id="search" placeholder="Search Products">
                        <div class="quick_search_result" style="display: none;">
                            <span class="search-tri"></span>
                            <div class="search-default"> No Result </div>
                            <?php foreach($items as $item) : ?>
                                <button type="button" data-id="<?php echo $item['MerchantProduct']['id'];?>" data-sku="<?php echo $item['MerchantProduct']['sku'];?>" class="data-found"><?=$item['MerchantProduct']['name'];?></button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="quick-key-name" >
                       <input type="text" id="layout_name" value="<?php echo $keys['MerchantQuickKey']['name']; ?>">
                       <span class="layout-name">Layout Name: </span>
                    </div>
                    <div class="quick-key-add-page">
                        <span class="page-add">Pages</span>
                        <button id="remove-page" class="btn btn-white btn-left">-</button>
                        <button id="add-page" class="btn btn-white btn-right">+</button>
                    </div>
                </div>
                <div id="block-center" class="quick-key-body">
                    <ul class="nav nav-tabs">
                    <?php
                        $quickKeys= json_decode($keys['MerchantQuickKey']['key_layouts'], true);  
                        foreach ($quickKeys['quick_keys']['groups'] as $group) :
                    ?>
                        <li position="<?php echo $group['position']; ?>" class="<?php if($group['position'] == 0){echo "active";} ?>" role="presentation">
                            <a href="javascript:;" class="<?php if($group['color'] == '#000'){echo 'Black';}elseif($group['color'] == '#FF0000'){echo 'Red';}elseif($group['color'] == '#0100FF'){echo 'Blue';}elseif($group['color'] == '#FFE400'){echo 'Yellow';}else{echo 'White';}; ?>"><?php echo $group['name']; ?> <i class="glyphicon glyphicon-cog" data-toggle="popover" data-placement="bottom" data-container="body"></i></a>
                        </li>
                    <?php
                        endforeach;
                    ?>
                        <button type="button" id="add-category" class="btn btn-white btn-add-category" data-toggle="popover" data-placement="bottom" data-container="body">
                        +
                        </button>
                    </ul>
                    <div class="quick-key-list">
                        <ul id="sortable" class="ui-sortable">
                        <?php
                            foreach ($quickKeys['quick_keys']['groups'] as $group) :
                                foreach ($group['pages'] as $page) :
                                    if (!empty($page['keys'])) :
                                        foreach ($page['keys'] as $key) :
                        ?>
                            <li class="quick-key-item <?php if($key['color'] == '#000'){echo 'Black';}elseif($key['color'] == '#FF0000'){echo 'Red';}elseif($key['color'] == '#0100FF'){echo 'Blue';}elseif($key['color'] == '#FFE400'){echo 'Yellow';}else{echo 'White';}; ?>" 
                                style="<?php if($group['position'] > 0 || $page['page'] > 1){echo "display: none;"; } ?>" 
                                group="<?php echo $group['position']; ?>" 
                                data-id="<?php echo $key['product_id']; ?>" 
                                data-sku="<?php echo $key['sku']; ?>" 
                                page="<?php echo $page['page']; ?>" 
                                background="<?php echo $key['color']; ?>">
                                <p><?php echo $key['label']; ?></p></li>
                        <?php
                                        endforeach;
                                    endif;
                                endforeach;
                            endforeach;
                        ?>
                        </ul>
                    </div>
                    <div class="quick-key-list-footer">
                        <span class="pull-left clickable prev"><i class="glyphicon glyphicon-chevron-left"></i></span>
                        <span class="pull-right clickable next"><i class="glyphicon glyphicon-chevron-right"></i></span>
                        <?php
                            $pages = count($quickKeys['quick_keys']['groups'][0]['pages']);
                            /*
                            foreach($quickKeys['quick_keys']['groups'] as $group) {
                                if(count($group['pages']) > $pages) {
                                    $pages = count($group['pages']);
                                }
                            }
                             */
                            for ($i = 1; $i <= $pages; $i++) :
                        ?>
                            <span rel="<?php echo $i;?>" class="page clickable <?php if($i == 1){echo "selected";}?>"><?php echo $i;?></span>
                        <?php
                            endfor;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="popover-content" class="hide">
    <div class="form-line" role="form">
        <div class="form-group">
            <input type="hidden" class="form-control" name="id">
            <input type="hidden" class="form-control" name="type">
            <input type="text" class="form-control" name="name" placeholder="Name">
            <select class="color-control" name="background">
                <option value="#FF0000">Red</option>
                <option value="#0100FF">Blue</option>
                <option value="#000">Black</option>
                <option value="#FFE400">Yellow</option>
                <option value="#FFF">White</option>
            </select> 
            <div class="popover-buttons">
                <button type="button" class="btn btn-primary cancel-tab">Cancel</button>
                <button type="button" class="btn btn-success action-trigger">Add</button>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT -->
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
<script src="/js/notify.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    Index.init();
    
    $( "#sortable" ).sortable({
        revert: true
    });
    
    /* DYNAMIC PROUCT SEARCH START */
    
    var $cells = $(".data-found");

    $(document).on("keyup","#search",function() {
        var val = $.trim(this.value).toUpperCase();
        if (val === "")
            $(".quick_search_result").hide();
        else {
            $cells.hide();
            $(".quick_search_result").show();
            $(".search-default").hide();
            $cells.filter(function() {
                return -1 != $(this).text().toUpperCase().indexOf(val);
            }).show();
            if($(".quick_search_result").height() == 0){
                $(".search-default").show();
            }
        }
        $cells.click(function(){
           $("#search").val($(this).text());
        });
    });

    /* DYNAMIC PRODUCT SEARCH END */

    /* DATA FOUNDED CLICK EVENT */

    $(document).on("click", ".data-found", function(){
        $("#sortable").append('<li class="quick-key-item White" group="'+$(".nav-tabs").find(".active").attr("position")+'" data-id="'+$(this).attr("data-id")+'" data-sku="'+$(this).attr("data-sku")+'" page="'+$(".quick-key-list-footer").find(".selected").text()+'" background="white"><p>'+$(this).text()+'</p></li>');

        $("#search").val("");
        $(".quick_search_result").hide();
    });

    /* DATA FOUNDED CLICK EVENT END */

    /* PAGE CONTROL */

    $(document).on('click','.page',function(){
        $(".page").removeClass("selected");
        $(".quick-key-item").hide();
        $(".quick-key-item[page="+$(this).attr("rel")+"][group="+$(".nav-tabs").find(".active").attr("position")+"]").show();
        $(this).addClass("selected");
    });
    
    var pageCount = $(".page").length;
    $("#add-page").click(function(){
        pageCount++;
        $(".quick-key-list-footer").append('<span rel="'+pageCount+'" class="page clickable">'+pageCount+'</span>');
        $(".page").removeClass("selected");
        $(".page[rel="+pageCount+"]").addClass("selected");
        $(".quick-key-item").hide();
    });
    $("#remove-page").click(function(){
        if(pageCount !== 1){
            $(".quick-key-list-footer").find("span[rel="+pageCount+"]").remove();
            $(".quick-key-item[page="+pageCount+"]").remove();
            pageCount--;
            $(".page").removeClass("selected");
            $(".page[rel="+pageCount+"]").addClass("selected");
            $(".quick-key-item[page="+pageCount+"]").show();
        }
    });
    /* PAGE CONTROL END */

    /* SAVE TRIGGER */

    $(document).on("click",".save",function(){
        
        var quick_keys = {};
        
        var layouts = {};
        var layout = [];

        var pages = {};
        var keys = [];
        var products = {};

        var groups = {};
        var group = [];
        
        $(".nav-tabs").find("li").each(function() {
            var group_id = parseInt($(this).attr("position"));

            layouts.name = $(this).find("a").text().trim();
            layouts.position = group_id;
            layouts.color = $(this).find("a").attr("class");
            
            var last_page = 0;
            
            $(".quick-key-item[group="+group_id+"]").each(function(){
                if($(this).attr("page") > last_page){
                    last_page = $(this).attr("page");
                }
            });

            for(var j = 1;j <= last_page;j++) {
                repeat_each(j, group_id);
            }

            layouts.pages = layout;
            
            group.push(layouts);
            
            layouts = {};
            layout= [];
        });
        
        groups.groups = group;
        quick_keys.quick_keys = groups;
        
        function repeat_each(page_number, group_number){
            var key_position = 0;
            $(".quick-key-item[page="+page_number+"][group="+group_number+"]").each(function(){

                products.position = key_position;
                products.label = $(this).find("p").text();
                products.sku = $(this).attr("data-sku");
                products.product_id = $(this).attr("data-id");
                products.color = $(this).attr("background");
                
                keys.push(products);
                
                pages.page = page_number;
                pages.keys = keys;
                
                products = {};
                key_position++;
            });
            layout.push(pages);
            keys = [];
            products = {};
            pages = {};
        }

        var key_layouts = JSON.stringify(quick_keys);
        
        $.ajax({
            url: location.href+'.json',
            type: "POST",
            data: {
                name: $("#layout_name").val(),
                key_layouts: key_layouts,
            },
            success: function(result) {
                if(result.success) {
                    window.location.href = "/setup/quick_keys";
                } else {
                    console.log(result);
                }
            }
        });
        
    });

    $(".delete").click(function() {
        var quick_key_id = location.pathname.split("/")[2];
        $.ajax({
            url: "/QuickKey/delete.json",
            type: "POST",
            data: {
                id: quick_key_id
            },
            success: function(result) {
                if(result.success) {
                    window.location.href = "/setup/quick_keys";
                } else {
                    console.log(result);
                }
            }
        });
    });

    /* SAVE TRIGGER END */

    $(".cancel").click(function(){
        window.history.back();
    });
    
    $(document).on("click", ".cancel-tab", function() {
        $(".popover").remove();
    });

    $(document).on("click", "li[role=presentation]", function() {
        $(".nav-tabs").find(".active").removeClass("active");
        $(this).addClass("active");
        $(".quick-key-item").hide();
        $(".quick-key-item[group="+$(this).attr("position")+"][page="+$(".quick-key-list-footer").find(".selected").attr("rel")+"]").show();
    });
});
/**toggle pop over */
$(".glyphicon-cog").popover({
    html: true, 
    content: function() {
        return $('#popover-content').html();
    },
});
$(document).on("click", ".glyphicon-cog", function() {
    $(".target").removeClass("target");
    $(".target-key").removeClass("target-key");
    $(".popover-buttons:last").children(".btn-success").removeClass("add-category");
    $(this).popover({
        html: true, 
        content: function() {
            return $('#popover-content').html();
        },
    });
    var original_name = $(this).parents("a");
    original_name.addClass("target");
    $(".popover:last").find("input[name=name]").val(original_name.text().trim());
    $(".popover-buttons").children(".btn-success").text("Edit");
});
/*
Category Add Click Setting */
$("#add-category").popover({
    html: true, 
    content: function() {
        return $('#popover-content').html();
    },
});
$("#add-category").click(function() {
    $(".target").removeClass("target");
    $(".target-key").removeClass("target-key");
    $(".popover-buttons:last").children(".btn-success").text("Add");
});
/* 
Quick Key Item Click Setting */
$(document).on("click", ".quick-key-item", function() {
    $(".target").removeClass("target");
    $(".target-key").removeClass("target-key");
    $(this).popover({
        html: true, 
        content: function() {
            return $('#popover-content').html();
        },
    });
    var original_name = $(this).find("p");
    $(".popover:last").find("input[name=name]").val(original_name.text().trim());
    $(".popover-buttons").children(".btn-success").text("Edit");
    $(this).addClass("target-key");
});
/*
Action Trigger Event */
$(document).on("click", ".action-trigger", function() {
    if($(".target").length > 0) {
        $(".target").attr("class", "target");
        $(".target").html($(".popover:last").find("input[name=name]").val() + ' <i class="glyphicon glyphicon-cog" data-toggle="popover" data-placement="bottom" data-container="body"></i>');
        $(".target").addClass($(".popover:last").find("select[name=background] option:selected").text());
    } else if($(".target-key").length > 0) {
        var aria = $(".target-key").attr("aria-describedby");
        $(".target-key").attr("class", "target-key quick-key-item");
        $(".target-key").addClass($("#" + aria).find("select[name=background] option:selected").text());
        $(".target-key").attr("background",$("#" + aria).find("select[name=background]").val());
        $(".target-key").find("p").text($("#" + aria).find("input[name=name]").val());
    } else {
        $(".nav-tabs").find(".active").removeClass("active");
        $(".nav-tabs").append('<li position="'+ $(".nav-tabs").find("li").length +'" class="active" role="presentation"><a href="javascript:;" class="' +$(".popover:last").find("select[name=background] option:selected").text()+ '">' + $(".popover:last").find("input[name=name]").val() + ' <i class="glyphicon glyphicon-cog" data-toggle="popover" data-placement="bottom" data-container="body"></i></a></li>');
    }
    $(".popover").remove();
    $(".target").removeClass("target");
    $(".target-key").removeClass("target-key");
});
</script>
<!-- END JAVASCRIPTS -->
