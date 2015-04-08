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
            <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega margin-bottom-20">
                <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
                    Add new register
                </h2>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="line-box col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <dl>
                            <dt>Register name</dt>
                            <dd>
                                <input type="text" class="register_name">
                            </dd>
                        </dl>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <dl>
                            <dt>Quick Key template</dt>
                            <dd>
                                <select class="register_quick_key">
                                <?php foreach($quick_keys as $qkey) : ?>
                                    <option value="<?php echo $qkey['id'];?>"><?php echo $qkey['name'];?></option>
                                <?php endforeach; ?>
                                </select>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:15px;">
                <div class="line-box col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <dl>
                            <dt>Receipt template</dt>
                            <dd class="explain">
                                <select class="register_receipt_template">
                                <?php foreach($receipt_templates as $receipt) : ?>
                                    <option value="<?php echo $receipt['id'];?>"><?php echo $receipt['name'];?></option>
                                <?php endforeach; ?>
                                </select>
                            </dd>
                            <dt>Number</dt>
                            <dd class="explain">
                                <input type="text" class="register_number" value="1">
                            </dd>
                        </dl>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                         <dl>
                            <dt>Prefix</dt>
                            <dd class="explain">
                                <input type="text" class="register_prefix">
                                <h6>Maximum 10 characters</h6>
                            </dd>
                            <dt>Suffix</dt>
                            <dd class="explain">
                                <input type="text" class="register_suffix">
                                <h6>Maximum 10 characters</h6>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            
            <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:15px;">
                <div class="line-box col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <dl>
                            <dt>Select user for next sale</dt>
                            <dd>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                <input type="radio" id="ns_yes" name="next_sale" value="1" > <label for="ns_yes">Yes</label> </div>
                                <div class="col-md-6 col-sm-6 col-xs-6"><input type="radio" id="ns_no" name="next_sale" value="0" checked> <label for="ns_no">No</label></div>
                            </dd>
                            <dt>Email receipt</dt>
                            <dd>
                                <div class="col-md-6 col-sm-6 col-xs-6"><input type="radio" id="es_yes" name="email_receipt" value="1"> <label for="es_yes">Yes</label> </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                <input type="radio" id="es_no" name="email_receipt" value="0" checked> <label for="es_no">No</label></div>
                            </dd>
                            <dt>Print receipt</dt>
                            <dd>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                <input type="radio" id="pr_yes" name="print_receipt" value="1" checked> <label for="pr_yes">Yes</label> </div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                <input type="radio" id="pr_no" name="print_receipt" value="0"> <label for="pr_no">No</label></div>
                            </dd>
                        </dl>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                        <dl>
                            <dt>Ask for a note</dt>
                            <dd>
                                <select class="ask_for_note">
                                    <option value="0">Never</option>
                                    <option value="1" selected>On Save/Layby/Account/Return</option>
                                    <option value="2">On all sales</option>
                                </select>
                            </dd>
                            <dt>Print note on receipt</dt>
                            <dd>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                <input type="radio" id="pnr_yes" name="print_note_on_receipt" value="1"> <label for="pnr_yes">Yes</label></div>
                                <div class="col-md-6 col-sm-6 col-xs-6"><input type="radio" id="pnr_no" name="print_note_on_receipt" value="0" checked> <label for="pnr_no">No</label></div>
                            </dd>
                            <dt>Show discounts on receipts</dt>
                            <dd>
                                <div class="col-md-6 col-sm-6 col-xs-6"><input type="radio" id="sdr_yes" name="show_discount" value="1" checked> <label for="sdr_yes">Yes</label></div>
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                <input type="radio" id="sdr_no" name="show_discount" value="0"> <label for="sdr_no">No</label></div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>

            <input type="hidden" class="outlet_id" value="<?php echo $_GET['outlet'];?>">

            <div class="col-md-12 col-sm-12 col-xs-12 pull-right margin-top-20 margin-bottom-20">
                <button class="btn btn-primary btn-wide save pull-right save" style="width: auto;">Save Register</button>
                <button class="btn btn-default btn-wide pull-right margin-right-10 cancel">Cancel</button>
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
jQuery(document).ready(function() {
    Metronic.init(); // init metronic core componets
    Layout.init(); // init layout
    QuickSidebar.init() // init quick sidebar
    Index.init();

    $(".cancel").click(function(){
        parent.history.back();
    });

    $(".save").click(function(){
        saveData();
    });
});

function saveData() {
    var register_id = $(".register_id").val();
    var name = $(".register_name").val();
    var outlet_id = $(".outlet_id").val();
    var quick_key_id = $(".register_quick_key").val();
    var receipt_template_id = $(".register_receipt_template").val();
    var invoice_sequence = $(".register_number").val();
    var invoice_prefix = $(".register_prefix").val();
    var invoice_suffix = $(".register_suffix").val();
    var email_receipt = $("input[name=email_receipt]:checked").val();
    var print_receipt = $("input[name=print_receipt]:checked").val();
    var ask_for_user_on_sale = $("input[name=next_sale]:checked").val();
    var ask_for_note_on_save = $(".ask_for_note").val();
    var print_note_on_receipt = $("input[name=print_note_on_receipt]:checked").val();
    var show_discounts = $("input[name=show_discount]:checked").val();

    $.ajax({
        url: "/register/create.json",
        method: "POST",
        data: {
            register_id: register_id,
            name: name,
            outlet_id: outlet_id,
            quick_key_id: quick_key_id,
            receipt_template_id: receipt_template_id,
            invoice_sequence: invoice_sequence,
            invoice_prefix: invoice_prefix,
            invoice_suffix: invoice_suffix,
            email_receipt: email_receipt,
            print_receipt: print_receipt,
            ask_for_user_on_sale: ask_for_user_on_sale,
            ask_for_note_on_save: ask_for_note_on_save,
            print_note_on_receipt: print_note_on_receipt,
            show_discounts: show_discounts
        },
        error: function( jqXHR, textStatus, errorThrown ) {
        },
        success: function( data, textStatus, jqXHR ) {
            if (data.success) {
                window.location.href = "/setup/outlets_and_registers";
            } else {
                alert(data.message);
            }
        }
    });
}
</script>
<!-- END JAVASCRIPTS -->