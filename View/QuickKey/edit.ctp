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
                                foreach($key['keys'] as $attr) {?>
                                    <li class="col-md-3 col-xs-3 col-sm-3 product clickable col-alpha col-omega button-view qKey" data-id="<?php echo $attr['product_id'];?>" page="<?php echo $key['page'];?>" <?php if($key['page'] !== 1){echo 'style="display:none;"';}?>>
                                        <span class="button-remove"><i class="glyphicon glyphicon-remove"></i></span>
                                        <p><?php echo $attr['label'];?></p>
                                    </li>
                                <?php }
                               } ?>
                           </ul>
                        </div>
                        <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega product-list-footer">
                            <span class="pull-left clickable prev"><i class="glyphicon glyphicon-chevron-left"></i></span>
                            <span class="pull-right clickable next"><i class="glyphicon glyphicon-chevron-right"></i></span>
                            <?php $keyArray = json_decode($keys['MerchantQuickKey']['key_layouts'], true);
                               foreach($keyArray['pages'] as $key){ ?>
                            <span rel="<?php echo $key['page'];?>" class="page clickable <?php if($key['page'] == 1){echo "selected";}?>"><?php echo $key['page'];?></span>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12 col-sm-12 text-align-center">
                        <button class="btn btn-default cancel">Cancel</button>
                        <button class="btn btn-primary save">Save Layout</button>
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
<!-- END PAGE LEVEL SCRIPTS -->

<script src="/js/notify.js" type="text/javascript"></script>
<script>
var quick = [];

jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    QuickSidebar.init() // init quick sidebar
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
        var page_count = 1;
        var i = 0;
        var sortable_length = $("#sortable li").length;
        $("#sortable li").each(function(index, element){
            if($(this).attr("page") == page_count){
                if(index == sortable_length-1) {
                    layout.push(pages);
                    
                    layouts.pages = layout;
                }
                pages.page = page_count;
                
                products.product_id = $(this).attr("data-id");
                products.position = i;
                products.label = $(this).find("p").text();
                
                keys.push(products);
                
                pages.keys = keys;
                
                products = {};
                i++;

            } else {

                page_count++;
                i = 0;

                layout.push(pages);

                keys = [];
                products = {};
                pages = {};
                pages.page = page_count;

                products.product_id = $(this).attr("data-id");
                products.position = i;
                products.label = $(this).find("p").text();

                keys.push(products);

                pages.keys = keys;

                products = {};
                i++;

            }
        });

        var key_layouts = JSON.stringify(layouts);

        $.ajax({
            url: location.href,
            type: "POST",
            data: {
                name: $("#layout_name").val(),
                key_layouts: key_layouts,
            },
            success: function() {
                window.location.href = "/setup/quick_keys";
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