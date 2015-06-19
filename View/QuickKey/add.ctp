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
                        <strong>New Quick Key Layout</strong>
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
                    </div>
                    <div class="quick-key-name" >
                       <input type="text" id="layout_name" value="New Quick Key Layout" >
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
                        <li class="active" role="presentation">
                            <a href="#">Group 1 <i class="glyphicon glyphicon-cog" data-toggle="popover" data-placement="bottom" data-container="body"></i></a>
                        </li>
                        <button type="button" id="add-category" class="btn btn-white btn-add-category" data-toggle="popover" data-placement="bottom" data-container="body">
                        +
                        </button>
                    </ul>
                    <div class="quick-key-list">
                        <ul id="sortable" class="ui-sortable">
                            <li class="quick-key-item"><p><span>Coke</span></p></li>
                            <li class="quick-key-item"><p><span>Coke</span></p></li>
                            <li class="quick-key-item"><p><span>Coke</span></p></li>
                            <li class="quick-key-item"><p><span>Coke</span></p></li>
                            <li class="quick-key-item"><p><span>Coke</span></p></li>
                            <li class="quick-key-item image"><p><span>Coke</span></p></li>
                            <li class="quick-key-item image"><p><span>Coke</span></p></li>
                            <li class="quick-key-item image"><p><span>Coke</span></p></li>
                            <li class="quick-key-item image"><p><span>Coke</span></p></li>
                            <li class="quick-key-item detail"><p><span>Coke</span></p></li>
                            <li class="quick-key-item detail"><p><span>Coke</span></p></li>
                            <li class="quick-key-item detail"><p><span>Coke</span></p></li>
                        </ul>
                    </div>
                    <div class="quick-key-list-footer">
                        <span class="pull-left clickable prev"><i class="glyphicon glyphicon-chevron-left"></i></span>
                        <span class="pull-right clickable next"><i class="glyphicon glyphicon-chevron-right"></i></span>
                        <span rel="1" class="page clickable selected">1</span>
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
                <option value="category-red">Red</option>
                <option value="category-blue">Blue</option>
                <option value="category-black">black</option>
                <option value="category-yellow">Yellow</option>
                <option value="category-white">White</option>
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
	$(this).addClass("target-key");
});
/*
Action Trigger Event */
$(document).on("click", ".action-trigger", function() {
	if($(".target").length > 0) {
		$(".target").attr("class", "target");
		$(".target").html($(".popover:last").find("input[name=name]").val() + ' <i class="glyphicon glyphicon-cog" data-toggle="popover" data-placement="bottom" data-container="body"></i>');
		$(".target").addClass($(".popover:last").find("select[name=background]").val());
	} else if($(".target-key").length > 0) {
		var aria = $(".target-key").attr("aria-describedby");
		$(".target-key").attr("class", "target-key quick-key-item");
		$(".target-key").addClass($("#" + aria).find("select[name=background]").val());
		$(".target-key").find("span").text($("#" + aria).find("input[name=name]").val());
	} else {
		$(".nav-tabs").append('<li class="active" role="presentation"><a href="#" class="' +$(".popover:last").find("select[name=background]").val()+ '">' + $(".popover:last").find("input[name=name]").val() + ' <i class="glyphicon glyphicon-cog" data-toggle="popover" data-placement="bottom" data-container="body"></i></a></li>');
	}
	$(".popover").remove();
	$(".target").removeClass("target");
	$(".target-key").removeClass("target-key");
});
</script>
<!-- END JAVASCRIPTS -->
