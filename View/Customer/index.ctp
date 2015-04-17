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
                    <!-- END RESPONSIVE QUICK SEARCH FORM -->
                </li>
                <li class="active">
                    <a href="index">
                    Sell <span class="selected">
                    </span>
                    </a>
                </li>
                <li>
                    <a href="history">
                    History </a>
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
                <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">Customer</h2>
                <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20">
                    <button id="import" class="btn btn-white pull-right btn-right" style="color:black">
                        <div class="glyphicon glyphicon-import"></div>&nbsp;
                    import</button>
                    <a href="#" id="export"><button class="btn btn-white pull-right btn-center">
                        <div class="glyphicon glyphicon-export"></div>&nbsp;
                    export</button></a>
                    <a href="customer/add"><button class="btn btn-white pull-right btn-left">
                        <div class="glyphicon glyphicon-plus"></div>&nbsp;
                    Add</button></a> 
                    <div>
                        <input type="file" name="File Upload" id="txtFileUpload" style="display:none" accept=".csv"> 
                    </div>
                </div>
            </div>
            <!-- FILTER -->
            <form class="col-md-12 col-xs-12 col-sm-12 line-box filter-box" action="/customer" method="get">
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <dl>
                        <dt>Name</dt> 
                        <dd>
                            <input type="text" name="name">
                        </dd>

                        <dt>Created on/after</dt>
                        <dd>
                            <span class="glyphicon glyphicon-calendar icon-calendar"></span>
                            <input type="text" id="Created_after" name="from">
                        </dd>
                    </dl> 
                </div>
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <dl>
                        <dt>Code</dt> 
                        <dd>
                            <input type="text" name="customer_code">
                        </dd>
                        <dt>Created on/before</dt> 
                        <dd>
                            <span class="glyphicon glyphicon-calendar icon-calendar"></span>
                            <input type="text" id="Created_before" name="to">
                        </dd>
                    </dl>
                 </div>
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <dl>
                        <dt>Customer group</dt>
                        <dd><select name="customer_group_id">
                        <?php foreach($customer_groups as $group) { ?>
                        	<option value="<?php echo $group['MerchantCustomerGroup']['id'];?>" <?php if(isset($_GET['customer_group_id']) && $_GET['customer_group_id'] == $group['MerchantCustomerGroup']['id']){echo "selected";}?>><?php echo $group['MerchantCustomerGroup']['name'];?></option>
                        <?php } ?>
                        </select></dd>
                    </dl>
                 </div>
                 <div class="col-md-12 col-xs-12 col-sm-12">
                     <button type="submit" class="btn btn-primary filter pull-right">Update</button>
                 </div>
            </form>

            <table id="customerTable" class="table-bordered">
                <thead>
                <tr>
                    <th>Contact Name</th>
                    <th>Company</th>
                    <th>Suburb</th>
                    <th>City</th>
                    <th>Code</th>
                    <th>Group</th>
                    <th>$ YTD</th>
                    <th>$ Balance</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach($customers as $customer){ ?>
                        <tr>
                            <td><a href="/customer/<?php echo $customer['MerchantCustomer']['id'];?>"><?=$customer['Contact']['first_name'].' '.$customer['Contact']['last_name'];?></a></td>
                            <td><?=$customer['Contact']['company_name'];?></td>
                            <td><?=$customer['Contact']['physical_suburb'];?></td>
                            <td><?=$customer['Contact']['physical_city'];?></td>
                            <td><?=$customer['MerchantCustomer']['customer_code'];?></td>
                            <td><?=$customer['MerchantCustomerGroup']['name'];?></td>
                            <td><?=$customer['MerchantCustomer']['loyalty_balance'];?></td>
                            <td><?=$customer['MerchantCustomer']['balance'];?></td>
                            <td></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            
        </div>
    </div>
    <!-- END CONTENT -->
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
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script type="text/javascript" src="/assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="/assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
<script src="/js/dataTable.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core components
    Layout.init(); // init current layout
    QuickSidebar.init() // init quick sidebar
    
    $("#customerTable").DataTable({
        searching: false
    });
    $("#customerTable_length").hide();
    $("#Created_before").datepicker({dateFormat: 'yy-mm-dd'});
    $("#Created_after").datepicker({dateFormat: 'yy-mm-dd'});
});
</script>
<!-- END JAVASCRIPTS -->