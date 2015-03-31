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
			<h3>New Price Book</h3>
			<div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">Detail</div>
            <div class="line-box line-box-content col-md-12 col-sm-12 col-xs-12">
                <div class="price_book_details">
                    <div class="col-md-6">
                        <dl>
                          <dt>Name</dt>
                          <dd>
                              <input type="text" id="price_book_name">
                          </dd>
                          <dt>Customer group</dt>
                          <dd>
                            <select><option value="0">All Customers</option></select>
                          </dd>
                          <dt>Outlet</dt>
                          <dd>
                            <select><option>All Outlets</option></select>
                          </dd>
                        </dl>
                      </div>
                    <div class="col-md-6">
                        <dl>
                          <dt>Valid from</dt>
                          <dd>
                            <span class="glyphicon glyphicon-calendar icon-calendar"></span>
							<input type="text" id="valid_from">
                          </dd>
                          <dt>Valid to</dt>
                          <dd>
                            <span class="glyphicon glyphicon-calendar icon-calendar"></span>
                            <input type="text" id="valid_to">
                          </dd>
                          <dt>Type</dt>
                          <dd class="price_book_type">
                            <input type="button" class="btn btn-white btn-left individual col-md-6 active" value="individual">
                            <input type="button" class="btn btn-white btn-right general selecetd col-md-6" value="general">
                          </dd>
                        </dl>
                	</div>
                </div>
                <div class="price_book_general" style="display:none;">
					<div class="dashed-line"></div>
                    <h2>General</h2>
					<div class="margin-bottom-20 col-md-12 col-alpha col-omega">
						<dl class="col-md-6">
							<dt>Markup</dt>
							<dd><input type="text"></dd>
							<dt>Discount</dt>
							<dd><input type="text"></dd>
						</dl>
						<dl class="col-md-6">
							<dt>Min. Units</dt>
							<dd><input type="number"></dd>
							<dt>Max. Unites</dt>
							<dd><input type="number"></dd>
						</dl>
					</div>
                </div>
                <div class="price_book_individual">
					<div class="dashed-line"></div>
                    <h2>Individual</h2>
					<div class="margin-bottom-20 price_book_individual-search">
						<input type="search" id="search" placeholder="Search Products">
						<div class="search_result">
							<span class="search-tri"></span>
							<?php foreach($items as $item){ ?>
						
							<button type="button" data-id="<?=$item['MerchantProduct']['id'];?>" data-supply_price="<?=$item['MerchantProduct']['supply_price'];?>" data-price="<?=$item['MerchantProduct']['price'];?>" data-tax="<?=$item['MerchantProduct']['tax'];?>" class="data-found"><?=$item['MerchantProduct']['name'];?>
							</button>
							
							<?php } ?>
						</div>
					</div>
                    <!-- DATA HOLDER START -->
                    <input type="hidden" class="data-name">
                    <input type="hidden" class="data-supply_price">
                    <input type="hidden" class="data-handle">
                    <!-- DATA HOLDER END -->
                    <table class="table table-bordered dataTable">
					  <colgroup>
							<col width="15%">
							<col width="10%">
							<col width="10%">
							<col width="10%">
							<col width="10%">
							<col width="10%">
							<col width="10%">
							<col width="10%">
							<col width="10%">
							<col width="5%">
					  </colgroup>
                          <thead>
                            <tr>
                                <th>Product</th>
                                <th>Supply price</th>
                                <th>Markup</th>
                                <th>Discount</th>
                                <th>Retail Price</th>
                                <th>Sales Tax</th>
                                <th>Retail Price</th>
                                <th>Min. Units</th>
                                <th>Max. Units</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Change all</td>
                                <td></td>
                                <td><input type="text"></td>
                                <td><input type="text"></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
           		</div>
			</div>   
            <div class="col-md-12 col-sm-12 col-xs-12 pull-right margin-top-20 margin-bottom-20">
				<button class="btn btn-primary btn-wide save pull-right">Save</button>
				<button class="btn btn-default btn-wide pull-right margin-right-10">Cancel</button>
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
<script type="text/javascript" src="/js/jquery.confirm.js"></script>

<script src="/js/jquery.popupoverlay.js" type="text/javascript"></script>

<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {    
   Metronic.init(); // init metronic core componets
   Layout.init(); // init layout
   QuickSidebar.init() // init quick sidebar
   Index.init();
   
   $("#valid_from").datepicker();
   $("#valid_to").datepicker();
   
   $(".general").click(function(){
	  $(".price_book_general").show('bounce');
	  $(".price_book_individual").hide();
   });
   $(".individual").click(function(){
	  $(".price_book_general").hide();
	  $(".price_book_individual").show('bounce');
   });
   
	$(document).on("click",".data-found",function(){
		
		$("tbody").append('<tr><td>'+$(this).text()+'</td><td>'+$(this).attr("data-supply_price")+'</td><td><input type="text"></td><td><input type="text"></td><td>'+($(this).attr("data-price")*(1-$(this).attr("data-tax"))).toFixed(2)+'</td><td>'+($(this).attr("data-price")*$(this).attr("data-tax")).toFixed(2)+'</td><td><input type="text" value="'+$(this).attr("data-price")+'"></td><td><input type="number"></td><td><input type="number"></td><td><div class="clickable remove"><i class="glyphicon glyphicon-remove"></i></div></td></tr>');
		
	});
	/* DYNAMIC PROUCT SEARCH START */

   var $cells = $(".data-found");
   $cells.hide();
   $(".search_result").hide();

   $(document).on("keyup","#search",function() {
	    var val = $.trim(this.value).toUpperCase();
	    if (val === "")
	        $cells.hide();
	    else {
	        $cells.hide();
	        $(".search_result").show();
	        $cells.filter(function() {
	            return -1 != $(this).text().toUpperCase().indexOf(val);
	        }).show();
	        
	    }
	    $cells.click(function(){
		   $("#search").val($(this).text());
		});
	});
	
	/* DYNAMIC PRODUCT SEARCH END */
	
	$(document).on("click",".remove",function() {
		$(this).parent().parent().remove();
	});
});
</script>

<script>
if($(".username").text() == "offline"){
var db;
function indexedDBOk() {
    return "indexedDB" in window;
}
document.addEventListener("DOMContentLoaded", function(){
	var openRequest = indexedDB.open("emcor");
	openRequest.onupgradeneeded = function(e) {
        var thisDB = e.target.result;
    }
    
    openRequest.onsuccess = function(e) {
        console.log("running onsuccess");

        db = e.target.result;
        
        
        $(".save").click(function(){
	       var openPriceBook = db.transaction(["price_book"],"readwrite").objectStore("price_book");
	       var bookData = {
		       name: $("#price_book_name").val(),
		       valid_from: $("#valid_from").val(),
		       valid_to: $("#valid_to").val()
	       }
	       openPriceBook.add(bookData).onsuccess = function(e){
		       console.log(e);
	       }
        });
        
        
        
        var productStore = db.transaction(["products"],"readwrite").objectStore("products");
        productStore.openCursor().onsuccess = function(e) {
	        
	        var product = e.target.result;
	        
	        if(product){
	        	$(".search_result").append('<button type="button" data-id="'+product.value.id+'" data-supply_price="'+product.value.supply_price+'" data-price="'+product.value.price_including_tax+'" data-tax="'+product.value.tax_rate+'" class="data-found">'+product.value.name+'</button>');
	        	product.continue();
	        } else {
	        
		       /* DYNAMIC PROUCT SEARCH START */
   
			   var $cells = $(".data-found");
			   $cells.hide();
			
			   $(document).on("keyup","#search",function() {
				    var val = $.trim(this.value).toUpperCase();
				    if (val === "")
				        $cells.hide();
				    else {
				        $cells.hide();
				        $cells.filter(function() {
				            return -1 != $(this).text().toUpperCase().indexOf(val); }).show();
				    }
				    $cells.click(function(){
					   $("#search").val($(this).text());
					});
				});
				
				/* DYNAMIC PRODUCT SEARCH END */
				
				
				$(document).on("click",".remove",function() {
					$(this).parent().parent().remove();
				});
				
	        }
        }
        
                
    }
    openRequest.onerror = function(e) {
        console.log("error occured", e.target.result);
    }
    
},false);
}
</script>

<script>
function checkNetConnection(){
 $.ajaxSetup({async:false});
 var re="";
 $.get("http://192.168.1.205/history",function(d){
  re="online";
 }).error(function(){
  re="offline";
 });
 $(".username").text(re);
}
checkNetConnection();
</script>