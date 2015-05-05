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
            <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega"><?php echo $customer['MerchantCustomer']['name'];?></h2>
                <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega">
                    <button id="delete" class="btn btn-white btn-right pull-right margin-top-20">
                    <div class="glyphicon glyphicon-remove"></div>&nbsp;Delete</button>
                    <a href="<?php echo "$_SERVER[REQUEST_URI]";?>/edit">
                    <button class="btn btn-white btn-left pull-right margin-top-20">
                    <div class="glyphicon glyphicon-edit"></div>&nbsp;Edit</button></a>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-xs-12 col-sm-12 margin-top-20 col-alpha">
                <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega line-box">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <dl>
                            <dt>Group</dt>
                            <dd><?php echo $customer['MerchantCustomerGroup']['name'];?></dd>
                            <dt>Physical address</dt>
                            <dd>New Zealand<br>
                                <a id="view_map">View map</a>
                            </dd>
                            <dt> </dt>
                            <dd> 
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-xs-12 col-sm-12 margin-top-20 col-alpha col-omega">
                <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega line-box">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <dl>
                            <dt>Balance</dt>
                            <dd class="font-big"><?php echo str_replace('$-','-$','$'.number_format($customer['MerchantCustomer']['balance'],2,'.',','));?></dd>
                            <dt>Year to date</dt>
                            <dd>$<?php echo number_format($cost,2,'.',',');?></dd>
                            <dt>Total spent</dt>
                            <dd>$<?php echo number_format($paid,2,'.',',');?></dd>
                        </dl>
                    </div>
                </div>
            </div>
            <!-- FILTER -->
            <div class="col-md-12 col-xs-12 col-sm-12 line-box filter-box margin-top-20">
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <dl>
                        <dt>Date from</dt> 
                        <dd>
                            <span class="glyphicon glyphicon-calendar icon-calendar"></span>
                            <input type="text" id="date_from">
                        </dd>
                        <dt>Register</dt>
                        <dd><input type="text" id=""></dd>
                        <dt>Amount</dt>
                        <dd><input type="text" id=""></dd>
                    </dl> 
                </div>
                <div class="col-md-4 col-xs-4 col-sm-4">
                    <dl>
                        <dt>Date to</dt>
                        <dd>
                            <span class="glyphicon glyphicon-calendar icon-calendar"></span>
                            <input type="text" id="date_to">
                        </dd>
                        <dt>Receipt number</dt>
                        <dd><input type="text" id=""></dd>
                        <dt> </dt>
                        <dd><input type="checkbox" class="margin-right-10">Is discounted</dd>
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
            <table id="historyTable">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>User</th>
                        <th>Register</th>
                        <th>Receipt</th>
                        <th>Note</th>
                        <th>Status</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($salesHistory as $sh) { ?>
                        <tr>
                            <td><?php echo $sh['RegisterSale']['created'];?></td>
                            <td>user</td>
                            <td>register</td>
                            <td><?php echo $sh['RegisterSale']['receipt_number'];?></td>
                            <td><?php echo $sh['RegisterSale']['note'];?></td>
                            <td><?php echo $sh['RegisterSale']['status'];?></td>
                            <td>$<?php echo number_format($sh['RegisterSale']['total_cost'],2,'.',',');?></td>
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
<script src="/js/dataTable.js" type="text/javascript"></script>
<script>
jQuery(document).ready(function() {    
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    Index.init();
    
    $("#historyTable").DataTable({
        searching: false
    });
    $("#historyTable_length").hide();
    
    $("#delete").click(function(){
        $.ajax({
            url: location.href+'/delete.json',
            type: 'POST',
            data: {
                request: 'delete'
            },
            success: function(result) {
                if(result.success) {
                    window.location.href = "/customer";
                } else {
                    console.log(result);
                }
            }
        });
    });
});
</script>
<!-- END JAVASCRIPTS -->