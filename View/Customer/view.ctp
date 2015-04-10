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
                <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">Real Customer name !!</h2>
                <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega">
                    <button class="btn btn-white btn-right add-customer pull-right margin-top-20">
                    <div class="glyphicon glyphicon-remove"></div>&nbsp;Delete</button>
                    <button class="btn btn-white btn-left add-customer pull-right margin-top-20">
                    <div class="glyphicon glyphicon-edit"></div>&nbsp;Edit</button>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-xs-12 col-sm-12 margin-top-20 col-alpha">
                <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega line-box">
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <dl>
                            <dt>Group</dt>
                            <dd>All Customers</dd>
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
                            <dd class="font-big">$0.00</dd>
                            <dt>Year to date</dt>
                            <dd>$33.87</dd>
                            <dt>Total spent</dt>
                            <dd>$33.87</dd>
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
                        <td><?php echo $sale['MerchantCustomer']['name'];?></td>
                        <td><?=$sale['RegisterSale']['note'];?></td>
                        <td class="history_status"><?=$sale['RegisterSale']['status'];?></td>
                        <td class="tdTotal">$<?=number_format($sale['RegisterSale']['total_cost'],2,'.','');?></td>
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
                                        <?php $itemCount = 0;
                                        foreach($sale['RegisterSaleItem'] as $item) { ?>
                                        
                                            <li class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega <?php if($itemCount > 4){echo 'hidden_product';}?>" <?php if($itemCount > 4){echo 'style="display:none;"';}?>>
                                                <span class="col-md-4 col-xs-4 col-sm-4 col-alpha col-omega row-product">
                                                    <b><?=$item['quantity'];?> x</b> <?=$item['MerchantProduct']['name'];?></span>
                                                <span class="col-md-4 col-xs-4 col-sm-4 col-alpha col-omega row-product-pice">
                                                    <b>@ $<?=number_format($item['MerchantProduct']['price_include_tax'] - $item['MerchantProduct']['tax'],2,'.','');?></b>
                                                    <small>+ $<?=number_format($item['MerchantProduct']['tax'],2,'.','');?> Tax (GST)</small>
                                                </span>
                                                <span class="col-md-4 col-xs-4 col-sm-4 col-alpha col-omega row-amount">
                                                    $<?=number_format($item['price'],2,'.','');?>
                                                </span>
                                            </li>
                                        
                                        <?php $itemCount++;
                                        } ?>
                                    </ul>
                                    <div class="solid-line"></div>
                                    <?php if($itemCount > 5) { ?>
                                    <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega text-align-center">
                                        <button class="ShowMore btn btn-default">Show More<span class="glyphicon glyphicon-chevron-down"></span></button>
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="col-md-4 col-xs-4 col-sm-4 col-alpha col-omega receipt-container">
                                    <div class="receipt"></div>
                                    <div class="col-md-12 col-xs-12 col-sm-12 show-amount">
                                        <ul class="receipt-text">
                                            <li class="pull-left">Subtotal</li>
                                            <li class="pull-right"><text class="subTotal">$<?=number_format($sale['RegisterSale']['total_price'],2,'.','');?></text></li>
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
                                                <text class="total"><strong>$<?=number_format($sale['RegisterSale']['total_cost'],2,'.','');?></strong></text>
                                            </li>
                                        </ul>
                                        <div class="solid-line"></div>
                                        <ul class="receipt-text">
                                            <?php foreach($sale['RegisterSalePayment'] as $payment) { ?>
                                            <li class="col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
                                                <?php echo $payment['MerchantPaymentType']['name'];?>
                                            </li>
                                            <li class="pull-right col-md-5 col-xs-5 col-sm-5 col-omega" style="text-align:right;">
                                                <div>
                                                    <?='$'.number_format($payment['amount'],2,'.','');?>
                                                    <div class="glyphicon glyphicon-remove clickable"></div>
                                                </div>
                                            </li>
                                            <?php } ?>
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
  <!-- MAP POPUP BOX -->
  <div class="confirmation-modal modal fade in view_map" tabindex="-1" role="dialog" aria-hidden="false">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="confirm-close cancel" data-dismiss="modal" aria-hidden="true">
                  <i class="glyphicon glyphicon-remove"></i>
                  </button>
                  <h4 class="modal-title">Are you sure?</h4>
              </div>
              <div class="modal-body">
                  <h3>Are you sure you want to void this sale?</h3><br>All products and payments will be removed from the current sale. Voided sale information is saved in the sales history.
              </div>
              <div class="modal-footer">
                  <button class="cancel btn btn-primary" type="button" data-dismiss="modal">Cancel</button>
                  <button class="confirm btn btn-success void-sale" type="button" data-dismiss="modal">Void Sale</button>
              </div>
          </div>
      </div>
  </div>
  <!-- MAP POPUP BOX END -->
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
<div class="modal-backdrop fade in" style="display: none;"></div>
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
<script>
jQuery(document).ready(function() {    
   Metronic.init(); // init metronic core componets
   Layout.init(); // init layout
   QuickSidebar.init() // init quick sidebar
   Index.init();
   
   $(document).on("click",".same_as_physical",function(){
      $(".postal_street_1").val($(".physical_street_1").val());
      $(".postal_street_2").val($(".physical_street_2").val());
      $(".postal_suburb").val($(".physical_suburb").val());
      $(".postal_city").val($(".physical_city").val());
      $(".postal_postcode").val($(".physical_postcode").val());
      $(".postal_state").val($(".physical_state").val());
      $(".postal_country").val($(".physical_country").val());
   });
   
    $("#date_from").datepicker();
    $("#date_to").datepicker();
    
    $("#view_map").click(function(){
        $(".view_map").show();
        $(".modal-backdrop").show();
    });
    $(".cancel").click(function(){
        $(".fade").hide();
    });
   
});
</script>
<!-- END JAVASCRIPTS -->

<script>

$(".save").click(function(){
    var gender;
    $("input[type=radio]").each(function(){
        if($(this).attr("checked")){
            gender = $(this).val();
        }
    });
    
    $(".required").each(function(){
        if($(this).val() == ""){
            $(this).parent().addClass("incorrect");
            $('<h5 class="incorrect-message"><i class="glyphicon glyphicon-remove-circle margin-right-5"></i>This field is required.</h5>').insertAfter($(this));
        } else {
            $(this).parent().removeClass("incorrect");
        }
    });
    
    if($(".incorrect").length == 0) {
        $.ajax({
            url: '/customer/add',
            type: 'POST',
            data: {
                company_name: $(".company_name").val(),
                first_name: $(".name_first").val(),
                last_name: $(".name_last").val(),
                birthday: $(".customer_yyyy").val()+'-'+$(".customer_mm").val()+'-'+$(".customer_dd").val(),
                phone: $(".phone").val(),
                mobile: $(".mobile").val(),
                email: $(".email").val(),
                website: $(".website").val(),
                physical_address_1: $(".physical_street_1").val(),
                physical_address_2: $(".physical_street_2").val(),
                physical_suburb: $(".physical_suburb").val(),
                physical_city: $(".physical_city").val(),
                physical_state: $(".physical_state").val(),
                physical_postcode: $(".physical_postcode").val(),
                physical_country: $(".physical_country").val(),
                postal_address_1: $(".postal_street_1").val(),
                postal_address_2: $(".postal_street_2").val(),
                postal_suburb: $(".postal_suburb").val(),
                postal_city: $(".postal_city").val(),
                postal_state: $(".postal_state").val(),
                postal_postcode: $(".postal_postcode").val(),
                postal_country: $(".postal_country").val(),
                customer_group_id: $(".customer_group").val(),
                customer_code: $(".customer_code").val(),
                name: $(".name_first").val() +' '+ $(".name_last").val(),
                gender: gender,
                user_field_1: $(".customer_field_1").val(),
                user_field_2: $(".customer_field_2").val(),
                user_field_3: $(".customer_field_3").val(),
                user_field_4: $(".customer_field_4").val(),
                note: $(".customer_note").val()
            }
        }).done(function(){
            window.location.href = "/customer";
        });
    } else {
        $("html, body").animate({ scrollTop: 0 }, "slow");
    }
});
</script>