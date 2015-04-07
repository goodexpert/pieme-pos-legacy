<link href="/css/dataTable.css" rel="stylesheet" type="text/css">

<div class="clearfix">
</div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
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
                    <a href="index.php">
                    Sell
                    </a>
                </li>
                <li class="active">
                    <a href="history">
                    History <span class="selected">
                    </span>
                    </a>
                </li>
                <li>
                    <a href="history">
                    Product </a>
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
                <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">History</h2>
            </div>
            <!-- FILTER -->
            <div class="col-md-12 col-xs-12 col-sm-12 line-box filter-box">
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <dl>
                        <dt>Date from</dt> 
                        <dd>
                            <span class="glyphicon glyphicon-calendar icon-calendar"></span>
                            <input type="text" id="Date_from">
                        </dd>
                        <dt>Register</dt>
                        <dd><input type="text" id=""></dd>
                        <dt>Customer name</dt>
                        <dd><input type="text" id=""></dd>
                    </dl> 
                </div>
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <dl>
                        <dt>Date to</dt>
                        <dd>
                            <span class="glyphicon glyphicon-calendar icon-calendar"></span>
                            <input type="text" id="Date_to">
                        </dd>
                        <dt>Receipt number</dt>
                        <dd><input type="text" id=""></dd>
                        <dt>Amount</dt>
                        <dd><input type="text" id=""></dd>
                    </dl>
                 </div>
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <dl>
                        <dt>Show</dt>
                        <dd><select>
                        <option></option>
                        </select>
                        </dd>
                        <dt>User</dt>
                        <dd><select>
                        <option></option>
                        </select>
                        </dd>
                    </dl>
                 </div>
                 <div class="col-md-12 col-xs-12 col-sm-12">
                     <button class="btn btn-primary filter pull-right">Update</button>
                 </div>
            </div>
            <table id="historyTable" class="table table-striped table-bordered dataTable">
                <thead>
                <tr>
                    <th class="hisID">ID</th>
                    <th class="hisUser">User</th>
                    <th class="hisCustomer">Customer</th>
                    <th class="hisNote">Note</th>
                    <th class="hisStatus">Status</th>
                    <th class="tblTotal">Total</th>
                    <th class="hisDate">Date</th>
                </tr>
                </thead>
                <tbody>
                
                <?php foreach($sales as $sale){ ?>
                
                    <tr class="expandable" data-id="<?=$sale['RegisterSale']['id'];?>">
                        <td>ID</td>
                        <td>PERSON</td>
                        <td>CUSTOMER</td>
                        <td><?=$sale['RegisterSale']['note'];?></td>
                        <td class="history_status"><?=$sale['RegisterSale']['status'];?></td>
                        <td class="tdTotal">$<?=number_format($sale['RegisterSale']['total_price'],2,'.','');?></td>
                        <td><?=$sale['RegisterSale']['sale_date'];?></td>
                    </tr>
                    <tr class="expandable-child" data-parent-id="<?=$sale['RegisterSale']['id'];?>">
                        <td colspan="8" class="expandable-child-td">
                            <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega table-inner-btn">
                                <div class="pull-left">
                                    <?php if($sale['RegisterSale']['status'] !== "VOIDED") { ?>
                                    <a href="/history/edit?r=<?=$sale['RegisterSale']['id'];?>" class="edit_history"><button class="btn btn-default">Edit Sale</button></a>
                                    <?php } ?>
                                    <a href="/history/receipt?r=<?=$sale['RegisterSale']['id'];?>">
                                    <button class="btn btn-default">View Receipt</button>
                                    </a>
                                    <?php if($sale['RegisterSale']['status'] !== "VOIDED") { ?>
                                    <button class="btn btn-default send_receipt">Send Receipt</button>
                                    <?php } ?>
                                </div>
                                <div class="pull-right">
                                    <?php if($sale['RegisterSale']['status'] == 'layby' or $sale['RegisterSale']['status'] == 'saved' or $sale['RegisterSale']['status'] == 'onaccount'){ ?>
                                    <button class="btn btn-default void-history" data-id="<?=$sale['RegisterSale']['id'];?>">Void</button>
                                    <button class="btn btn-default">Continue Sale</button>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                                <div class="col-md-8 col-xs-8 col-sm-8 col-alpha history-detail">
                                    <ul class="row-display">
                                        <?php foreach($sale['RegisterSaleItem'] as $item) { ?>
                                        
                                            <li class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                                                <span class="col-md-4 col-xs-4 col-sm-4 col-alpha col-omega row-product">
                                                    <b><?=$item['quantity'];?> x</b> <?=$item['MerchantProduct']['name'];?></span>
                                                <span class="col-md-4 col-xs-4 col-sm-4 col-alpha col-omega row-product-pice">
                                                    <b>@ $<?=number_format($item['price'],2,'.','');?></b>
                                                    <small>+ $0.00 Tax (GST)</small>
                                                </span>
                                                <span class="col-md-4 col-xs-4 col-sm-4 col-alpha col-omega row-amount">
                                                    $<?=number_format($item['price'],2,'.','');?>
                                                </span>
                                            </li>
                                        
                                        <?php } ?>
                                    </ul>
                                    <div class="solid-line"></div>
                                    <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega text-align-center">
                                        <button class="ShowMore btn btn-default">
                                            Show More<span class="glyphicon glyphicon-chevron-down"></span>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-4 col-sm-4 col-alpha col-omega receipt-container">
                                    <div class="receipt"></div>
                                    <div class="col-md-12 col-xs-12 col-sm-12 show-amount">
                                        <ul class="receipt-text">
                                            <li class="pull-left">Subtotal</li>
                                            <li class="pull-right"><text class="subTotal">$<?=number_format($sale['RegisterSale']['total_price'],2,'.','') - number_format($sale['RegisterSale']['total_tax'],2,'.','');?></text></li>
                                        </ul>
                                        <ul class="receipt-text">
                                            <li class="pull-left">Tax (GST)</li>
                                            <li class="pull-right">
                                                <text class="gst">$<?=number_format($sale['RegisterSale']['total_tax'],2,'.','');?></text>
                                            </li>
                                        </ul>
                                        <div class="dashed-line"></div>
                                        <ul class="inline-block">
                                            <li class="pull-left h4">
                                                <strong>TOTAL</strong>
                                            </li>
                                            <li class="pull-right h4">
                                                <text class="total"><strong>$<?=number_format($sale['RegisterSale']['total_price'],2,'.','');?></strong></text>
                                            </li>
                                        </ul>
                                        <div class="solid-line"></div>
                                        <ul class="receipt-text">
                                            <li class="pull-left col-md-10 col-xs-10 col-sm-10 col-alpha col-omega">Cash – Wed, 11 Feb 2015, 12:00 am– Main Register</li>
                                            <li class="pull-right col-md-2 col-xs-2 col-sm-2 col-omega">
                                                <div class="remove clickable">
                                                    <div class="glyphicon glyphicon-remove"></div>
                                                </div>
                                            </li>
                                        </ul>
                                        <div class="dashed-line-gr"></div>
                                        <button class="btn btn-default pull-right">Apply payment / refund</button>
                                        <div class="solid-line"></div>
                                        <ul class="receipt-text">
                                            <li class="pull-left">Balance</li>
                                            <li class="pull-right"><strong>$0.00</strong></li>
                                        </ul>
                                    </div>
                                    <div class="receipt-bt"></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                
                <?php } ?>
                
                </tbody>
            </table>
            <div class="dataTables_wrapper">
                <div class="dataTables_paginate paging_simple_numbers" id="productTable_paginate">
                    <a class="paginate_button previous disabled" data-dt-idx="1" tabindex="0" id="previous">Previous</a>
                    <span><a class="paginate_button current" data-dt-idx="1" tabindex="0">1</a></span>
                    <a class="paginate_button next" data-dt-idx="" tabindex="0" id="next">Next</a>
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
<script src="assets/global/plugins/respond.min.js"></script>
<script src="assets/global/plugins/excanvas.min.js"></script> 
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
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="/assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="/assets/admin/pages/scripts/index.js" type="text/javascript"></script>
<script src="/assets/admin/pages/scripts/tasks.js" type="text/javascript"></script>

<!-- END PAGE LEVEL SCRIPTS -->

<script src="/js/dataTable.js" type="text/javascript"></script>
<script>
jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    QuickSidebar.init() // init quick sidebar
    Index.init();
    var count = 0;
    var page = 1;
    var currentPage = 1;
    $(".expandable").each(function(){
        $(this).attr({'page':page});
        $(this).next('.expandable-child').attr({'page':page});
        count++;
        if(count == 10){
            count = 0;
            page++;
            $('<span><a class="paginate_button" data-dt-idx="'+page+'" tabindex="0">'+page+'</a></span>').insertBefore("#next");
        }
    });
    $(".expandable").hide();
    $(".expandable-child").hide();
    $(".expandable[page=1]").show();
    
    $("span").children(".paginate_button").click(function(){
        $(".expandable").hide();
        $(".expandable-child").hide();
        $(".paginate_button").removeClass("current");
        $(this).addClass("current");
        if($(this).attr("data-dt-idx") > 1){
            $("#previous").removeClass("disabled");
        }
        if($(this).attr("data-dt-idx") >= page){
            $("#next").addClass("disabled");
        } else {
            $("#next").removeClass("disabled");
        }
        $("#previous").attr({'data-dt-idx':currentPage - 1});
        currentPage = $(this).attr('data-dt-idx');
        $(".expandable[page="+currentPage+"]").show();
    });
    
    $(document).on('click','#previous',function(){
        if(!$(this).hasClass('disabled')){
            currentPage--;
            $(".expandable").hide();
            $(".expandable-child").hide();
            $(".paginate_button").removeClass("current");
            
            $("span").children(".paginate_button[data-dt-idx="+currentPage+"]").addClass('current');
            $(".expandable[page="+currentPage+"]").show();
            
            $(this).attr({'data-dt-idx':currentPage - 1});
            if($(this).attr('data-dt-idx') < 1){
                $(this).addClass("disabled");
            } else {
                $(this).removeClass("disabled");
            }
        }
        if($("span").children("paginate_button").length !== 1){
            $("#next").removeClass("disabled");
        }
    });
    
    $(document).on('click','#next',function(){
        if(!$(this).hasClass('disabled')){
            currentPage++;
            
            $(".expandable").hide();
            $(".expandable-child").hide();
            $(".paginate_button").removeClass("current");
            
            $("span").children(".paginate_button[data-dt-idx="+currentPage+"]").addClass('current');
            $(".expandable[page="+currentPage+"]").show();
            
            $(this).attr({'data-dt-idx':currentPage});
        }
        if($("span").children("paginate_button").length !== 1){
            $("#previous").removeClass("disabled");
        }
        if(currentPage == page){
            $(this).addClass('disabled');
        }
    });
});
</script>

<script>
var firstTime = true;
$(document).on("click", ".expandable", function(){
    $('.expandable-child[data-parent-id='+$(this).attr("data-id")+']').show();
    $(this).attr({"class": "expanded"});
});

$(document).on("click", ".expanded", function(){
    $('.expandable-child[data-parent-id='+$(this).attr("data-id")+']').hide();
    $(this).attr({"class": "expandable"});
});

$(".void-history").click(function(){
    $(this).parents(".expandable-child").prev("tr").children(".history_status").text("voided");
    $(this).parent().prev("div").children(".edit_history").remove();
    $(this).parent().prev("div").children(".send_receipt").remove();
    $(this).parent().remove();
    
    $.ajax({
        url: '/history/void.json',
        type: 'POST',
        data: {
            id: $(this).attr("data-id"),
            status: 'VOIDED',
        }
    });
    $("#Date_from").datepicker();
    $("#Date_to").datepicker();
});
</script>
<!-- END JAVASCRIPTS -->