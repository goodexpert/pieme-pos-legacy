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
            <h3><?=$keys['MerchantQuickKey']['name'];?></h3>
            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="col-md-6 col-xs-6 col-sm-6 col-alpha col-omega">
                    <div id="block-right" class="col-md-12 col-xs-12 col-sm-12">
                        <div class="col-lg-8 col-md-7 col-xs-7 col-sm-7">
                           <input type="text" id="layout_name" value="<?=$keys['MerchantQuickKey']['name'];?>">
                        </div>
                        <div class="col-lg-4 col-md-5 col-xs-5 col-sm-5">
                            <span class="page-add">Pages</span>
                            <button id="remove-page" class="btn btn-white btn-left">-</button>
                            <button id="add-page" class="btn btn-white btn-right">+</button>
                        </div>
                    <div class="dashed-line"></div>
                       <div class="col-md-12 col-xs-12 col-sm-12 product-list" style="height: 300px;">
                           <ul id="sortable">
                               <?php $keyArray = json_decode($keys['MerchantQuickKey']['key_layouts'], true);
                               foreach($keyArray['pages'] as $key){
                                if(!empty($key['keys'])) {
                                    foreach($key['keys'] as $attr) { ?>
                                        <li class="col-md-3 col-xs-3 col-sm-3 product clickable col-alpha col-omega button-view qKey" data-id="<?php echo $attr['product_id'];?>" page="<?php echo $key['page'];?>" <?php if($key['page'] !== 1){echo 'style="display:none;"';}?>>
                                            <span class="button-remove"><i class="glyphicon glyphicon-remove"></i></span>
                                            <p><?php echo $attr['label'];?></p>
                                        </li>
                                    <?php }
                                }
                               } ?>
                           </ul>
                        </div>
                        <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega product-list-footer">
                            <span class="pull-left clickable prev"><i class="glyphicon glyphicon-chevron-left"></i></span>
                            <span class="pull-right clickable next"><i class="glyphicon glyphicon-chevron-right"></i></span>
                            <?php $keyArray = json_decode($keys['MerchantQuickKey']['key_layouts'], true);
                            $pages = count($keyArray['pages']);
                            for($i = 1;$i <= $pages;$i++){?>
                                <span rel="<?php echo $i;?>" class="page clickable <?php if($i == 1){echo "selected";}?>"><?php echo $i;?></span>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12 col-sm-12 text-align-center">
                        <button class="btn btn-primary cancel">Cancel</button>
                        <button class="btn btn-success save">Save Layout</button>
                    </div>
                </div>
                <div class="col-md-6 col-xs-6 col-sm-6 col-omega margin-top-30">
                    <input type="search" id="search" placeholder="Search Products">
                    <div class="search_result">
                        <span class="search-tri"></span>
                        <div class="search-default"> No Result </div>
                        <?php foreach($items as $item){ ?>
                    
                        <button type="button" data-id="<?=$item['MerchantProduct']['id'];?>" class="data-found"><?=$item['MerchantProduct']['name'];?></button>
                        
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- END CONTENT -->
</div>
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
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="/assets/admin/pages/scripts/index.js" type="text/javascript"></script>
<script src="/assets/admin/pages/scripts/tasks.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<script src="/js/notify.js" type="text/javascript"></script>
<script>
var quick = [];

jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    Index.init();

    $( "#sortable" ).sortable({
        revert: true
    });

    /* DYNAMIC PROUCT SEARCH START */
    
    var $cells = $(".data-found");
    $(".search_result").hide();

    $(document).on("keyup","#search",function() {
        var val = $.trim(this.value).toUpperCase();
        if (val === "")
            $(".search_result").hide();
        else {
            $cells.hide();
            $(".search_result").show();
            $(".search-default").hide();
            $cells.filter(function() {
                return -1 != $(this).text().toUpperCase().indexOf(val);
            }).show();
            if($(".search_result").height() == 0){
                $(".search-default").show();
            }
        }
        $cells.click(function(){
           $("#search").val($(this).text());
        });
    });

    /* DYNAMIC PRODUCT SEARCH END */
    

    /* PAGE CONTROL */

    $(document).on('click','.page',function(){
        $(".page").removeClass("selected");
        $(".qKey").hide();
        $(".qKey[page="+$(this).attr("rel")+"]").show();
        $(this).addClass("selected");
    });
    
    var pageCount = $(".page").length;
    $("#add-page").click(function(){
        pageCount++;
        $(".product-list-footer").append('<span rel="'+pageCount+'" class="page clickable">'+pageCount+'</span>');
        $(".page").removeClass("selected");
        $(".page[rel="+pageCount+"]").addClass("selected");
        $(".qKey").hide();
    });
    $("#remove-page").click(function(){
        if(pageCount !== 1){
            $(".product-list-footer").find("span[rel="+pageCount+"]").remove();
            $(".qKey[page="+pageCount+"]").remove();
            pageCount--;
            $(".page").removeClass("selected");
            $(".page[rel="+pageCount+"]").addClass("selected");
            $(".qKey[page="+pageCount+"]").show();
        }
    });

    /* PAGE CONTROL END */

    /* DATA FOUNDED CLICK EVENT */

    $(".data-found").click(function(){
        $("#sortable").append('<li class="col-lg-3 col-md-4 col-xs-6 col-sm-6 product clickable col-alpha col-omega button-view qKey" data-id="'+$(this).attr("data-id")+'" page="'+$(".product-list-footer").find(".selected").text()+'"><span class="button-remove"><i class="glyphicon glyphicon-remove"></i></span><p>'+$(this).text()+'</p></li>');
    });

    /* DATA FOUNDED CLICK EVENT END */
    
    $(document).on('click','.button-remove',function(){
        $(this).parent().remove();
    });
    
    /* SAVE TRIGGER */

    $(document).on("click",".save",function(){
        
        var layouts = {};

        var layout = [];

        var pages = {};
        var keys = [];
        var products = {};
        var last_page = 0;
        var sortable_length = $(".qKey").length;
        $(".qKey").each(function(){
            if($(this).attr("page") > last_page){
                last_page = $(this).attr("page");
            }
        });
        
        for(var j = 1;j <= last_page;j++) {
            repeat_each(j);
        }
        
        function repeat_each(page_number){
            $(".qKey[page="+page_number+"]").each(function(){
            
                products.product_id = $(this).attr("data-id");
                products.position = 0;
                products.label = $(this).find("p").text();
                
                keys.push(products);
                
                pages.page = page_number;
                pages.keys = keys;
                
                products = {};
                
            });
            layout.push(pages);
            keys = [];
            products = {};
            pages = {};
        }

        layouts.pages = layout;

        var key_layouts = JSON.stringify(layouts);
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

    /* SAVE TRIGGER END */
    
    $(".cancel").click(function(){
        window.history.back();
    });

});
</script>
<!-- END JAVASCRIPTS -->