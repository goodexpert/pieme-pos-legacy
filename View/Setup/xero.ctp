<?php
    $loyalty = $this->Session->read('Auth.User.Loyalty');
    $data = $this->request->data;
 ?>
<style>
dd {
    height: auto;
    padding: 4px;
}
</style>
<div class="clearfix"></div>
<div class="container">
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
                    <a href="javascript:;" class="remove"> <i class="icon-close"></i> </a>
                    <div class="input-group">
                        <input type="text" placeholder="Search...">
                        <span class="input-group-btn">
                        <button class="btn submit"><i class="icon-magnifier"></i></button>
                        </span> </div>
                    </form>
                    <!-- END RESPONSIVE QUICK SEARCH FORM -->
                </li>
                <li> <a href="index"> Sell </a> </li>
                <li> <a href="history"> History </a> </li>
                <li class="active"> <a href="history"> Product <span class="selected"> </span> </a> </li>
            </ul>
        </div>
        <!-- END HORIZONTAL RESPONSIVE MENU --> 
    </div>
    <!-- END SIDEBAR --> 
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <div id="notify" class="hidden col-lg-12 col-md-12 col-sm-12">
                <div class="notify-content"><p>Setup has been changed. Please login again to your account.</p></div>
            </div>
            <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega margin-bottom-20">
                <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">Xero</h2>
                <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20">
                    <a href="/xero/reloadAccounts"><button class="btn btn-white pull-right">
                        <div class="glyphicon glyphicon-refresh"></div>&nbsp;
                    Reload accounts</button></a> 
                </div>
            </div>
            <?php
                echo $this->Form->create('xero_config', array(
                    'id' => 'xero_addon_form'
                ));
             ?>
            <div class="portlet-body form"> 
                <!-- BEGIN FORM-->
                <div class="form-horizontal col-md-12 col-xs-12 col-sm-12">
                    <?php if (!empty($reloaded)) : ?>
                    <div class="success-message">Your Xero accounts have been reloaded.</div>
                    <?php endif ?>
                    <div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">Accounts</div>
                    <div class="form-body line line-box line-box-content col-md-12 col-xs-12 col-sm-12"> 
                        <div class="col-md-6">
                            <dl>
                                <dt><label for="default_sales_account">Default sales account</label></dt>
                                <dd>
                                <?php
                                    echo $this->Form->input('default_sales_account', array(
                                        'id' => 'default_sales_account',
                                        'type' => 'select',
                                        'div' => false,
                                        'label' => false,
                                        'empty' => '',
                                        'required' => 'required',
                                        'options' => array(
                                            'Revenue' => $xero_accounts['REVENUE'],
                                            'Current' => $xero_accounts['CURRENT'],
                                        )
                                    ));
                                 ?>
                                    <div class="help-block with-errors"></div>
                                </dd>
                             </dl>
                             <dl>
                                <dt><label for="default_rounding_account">Rounding errors</label></dt>
                                <dd>
                                <?php
                                    echo $this->Form->input('default_rounding_account', array(
                                        'id' => 'default_rounding_account',
                                        'type' => 'select',
                                        'div' => false,
                                        'label' => false,
                                        'empty' => '',
                                        'required' => 'required',
                                        'options' => array(
                                            'Current' => $xero_accounts['CURRENT'],
                                            'Overheads' => $xero_accounts['OVERHEADS'],
                                            'Direct Costs' => $xero_accounts['DIRECTCOSTS'],
                                            'Current Liability' => $xero_accounts['CURRLIAB'],
                                            'Expense' => $xero_accounts['EXPENSE'],
                                        )
                                    ));
                                 ?>
                                    <div class="help">Rounding errors in sales tax calculations may<br>occur for small transactions.</div>
                                    <div class="help-block with-errors"></div>
                                </dd>
                            </dl>
                             <dl>
                                <dt><label for="default_refund_account">Refund account</label></dt>
                                <dd>
                                <?php
                                    echo $this->Form->input('default_refund_account', array(
                                        'id' => 'default_refund_account',
                                        'type' => 'select',
                                        'div' => false,
                                        'label' => false,
                                        'empty' => '',
                                        'required' => 'required',
                                        'options' => array(
                                            'Current' => $xero_accounts['CURRENT'],
                                        )
                                    ));
                                 ?>
                                    <div class="help">For more information in assigning this refund<br>account <a target="_blank" href="#">view our knowledge base</a>.</div>
                                    <div class="help-block with-errors"></div>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                           <dl>
                                <dt><label for="default_cost_of_goods_account">Default purchases account</label></dt>
                                <dd>
                                <?php
                                    echo $this->Form->input('default_cost_of_goods_account', array(
                                        'id' => 'default_cost_of_goods_account',
                                        'type' => 'select',
                                        'div' => false,
                                        'label' => false,
                                        'empty' => '',
                                        'required' => 'required',
                                        'options' => array(
                                            'Current' => $xero_accounts['CURRENT'],
                                            'Overheads' => $xero_accounts['OVERHEADS'],
                                            'Direct Costs' => $xero_accounts['DIRECTCOSTS'],
                                            'Current Liability' => $xero_accounts['CURRLIAB'],
                                            'Expense' => $xero_accounts['EXPENSE'],
                                        )
                                    ));
                                 ?>
                                    <div class="help-block with-errors"></div>
                                </dd>
                            </dl>
                            <dl>
                                <dt><label for="default_baddebt_account">Till payment discrepancies</label></dt>
                                <dd>
                                <?php
                                    echo $this->Form->input('default_baddebt_account', array(
                                        'id' => 'default_baddebt_account',
                                        'type' => 'select',
                                        'div' => false,
                                        'label' => false,
                                        'empty' => '',
                                        'required' => 'required',
                                        'options' => array(
                                            'Current' => $xero_accounts['CURRENT'],
                                            'Overheads' => $xero_accounts['OVERHEADS'],
                                            'Direct Costs' => $xero_accounts['DIRECTCOSTS'],
                                            'Current Liability' => $xero_accounts['CURRLIAB'],
                                            'Expense' => $xero_accounts['EXPENSE'],
                                        )
                                    ));
                                 ?>
                                    <div class="help">If there are any discrepancies in the till close<br>payment counts, they will be posted here.</div>
                                    <div class="help-block with-errors"></div>
                                </dd>
                            </dl>        
                            <dl>
                                <dt><label for="default_discount_account">Default discount account</label></dt>
                                <dd>
                                <?php
                                    echo $this->Form->input('default_discount_account', array(
                                        'id' => 'default_discount_account',
                                        'type' => 'select',
                                        'div' => false,
                                        'label' => false,
                                        'empty' => '',
                                        'required' => 'required',
                                        'options' => array(
                                            'Revenue' => $xero_accounts['REVENUE'],
                                            'Expense' => $xero_accounts['EXPENSE'],
                                        )
                                    ));
                                 ?>
                                    <div class="help">When the system wide discount product is <br>applied, the value will be posted here.</div>
                                    <div class="help-block with-errors"></div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="form-horizontal col-md-12 col-xs-12 col-sm-12">
                    <div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">Accounts for Payment Types</div>
                    <div class="form-body line line-box line-box-content col-md-12 col-xs-12 col-sm-12"> 
                        <div class="col-md-6">
                            <dl>
                            <?php foreach ($payment_types as $item) : ?>
                                <?
                                    $selected = '';
                                    if (isset($data['xero_config']['setup_payments'])) {
                                        if (isset($data['xero_config']['setup_payments'][$item['id']])) {
                                            $selected = $data['xero_config']['setup_payments'][$item['id']];
                                        }
                                    }
                                 ?>
                                <?php if ($item['payment_type_name'] !== 'Loyalty') : ?>
                                <dt><label for=""><?php echo $item['name']; ?></label></dt>
                                <dd>
                                <?php
                                    echo $this->Form->input('xero_config_setup_payments_' . $item['id'], array(
                                        'id' => 'xero_config_setup_payments_' . $item['id'],
                                        'name' => 'data[xero_config][setup_payments][' . $item['id'] . ']',
                                        'type' => 'select',
                                        'div' => false,
                                        'label' => false,
                                        'empty' => '',
                                        'required' => 'required',
                                        'options' => array(
                                            'Bank' => $xero_accounts['BANK'],
                                            'Current' => $xero_accounts['CURRENT'],
                                        ),
                                        'selected' => $selected
                                    ));
                                 ?>
                                    <div class="help-block with-errors"></div>
                                </dd>
                                <?php elseif ($loyalty['enable_loyalty'] == 1) : ?>
                                <dt><label for="">Loyalty payments</label></dt>
                                <dd>
                                <?php
                                    echo $this->Form->input('xero_config_setup_payments_' . $item['id'], array(
                                        'id' => 'xero_config_setup_payments_' . $item['id'],
                                        'name' => 'data[xero_config][setup_payments][' . $item['id'] . ']',
                                        'type' => 'select',
                                        'div' => false,
                                        'label' => false,
                                        'empty' => '',
                                        'required' => 'required',
                                        'options' => array(
                                            'Current Liability' => $xero_accounts['CURRLIAB'],
                                        ),
                                        'selected' => $selected
                                    ));
                                 ?>
                                    <div class="help">Liability for Loyalty $ earned</div>
                                    <div class="help-block with-errors"></div>
                                </dd>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="form-horizontal col-md-12 col-xs-12 col-sm-12">
                    <div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">Accounts for Sales Taxes</div>
                    <div class="form-body line line-box line-box-content col-md-12 col-xs-12 col-sm-12"> 
                        <div class="col-md-6">
                            <dl>
                            <?php foreach ($tax_rates as $item) : ?>
                                <dt><label for=""><?php echo $item['name']; ?></label></dt>
                                <dd>
                                <?php
                                    $selected = '';
                                    if (isset($data['xero_config']['setup_taxes'])) {
                                        $selected = $data['xero_config']['setup_taxes'][$item['id']];
                                    }

                                    echo $this->Form->input('xero_config_setup_taxes_' . $item['id'], array(
                                        'id' => 'xero_config_setup_taxes_' . $item['id'],
                                        'name' => 'data[xero_config][setup_taxes][' . $item['id'] . ']',
                                        'type' => 'select',
                                        'div' => false,
                                        'label' => false,
                                        'empty' => '',
                                        'required' => 'required',
                                        'options' => $xero_tax_rates,
                                        'selected' => $selected
                                    ));
                                 ?>
                                    <div class="help-block with-errors"></div>
                                </dd>
                            <?php endforeach; ?>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="form-horizontal col-md-12 col-xs-12 col-sm-12">
                    <div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">Other Options</div>
                    <div class="form-body line line-box line-box-content col-md-12 col-xs-12 col-sm-12"> 
                        <div class="col-md-6">
                            <dl>
                            <?php if ($loyalty['enable_loyalty'] == 1) : ?>
                                <dt><label for="loyalty_expense_account">Loyalty expense</label></dt>
                                <dd>
                                <?php
                                    echo $this->Form->input('loyalty_expense_account', array(
                                        'id' => 'loyalty_expense_account',
                                        'type' => 'select',
                                        'div' => false,
                                        'label' => false,
                                        'empty' => '',
                                        'required' => 'required',
                                        'options' => array(
                                            'Expense' => $xero_accounts['EXPENSE'],
                                        )
                                    ));
                                 ?>
                                    <div class="help">For Loyalty $ redemptions</div>
                                    <div class="help-block with-errors"></div>
                                </dd>
                            <?php endif; ?>
                                <dt><label for="">Send invoices as</label></dt>
                                <dd>
                                    <select class="form-control" name="xero_config[post_invoices_as_draft]" id="post_invoices_as_draft">
                                        <option value="0" selected="selected">Approved</option>
                                        <option value="1">Awaiting approval</option>
                                        <option value="2">Draft</option>
                                    </select>
                                    <div class="help">Please note that register closures are always sent to Xero as approved. <a href="#" target="_blank">See more detail</a>.</div>
                                    <div class="help-block with-errors"></div>
                                </dd>
                                <dt><label for="">Register closure detail</label></dt>
                                <dd>
                                    <select class="form-control" name="xero_config[closure_summary_option]" id="closure_summary_option">
                                        <option value="register_sale_product_id">Detail each sale</option>
                                        <option value="product_id">Send a summary by product</option>
                                        <option value="account_code" selected="selected">Send a summary by account code</option>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 pull-right margin-top-20 margin-bottom-20">
                <button class="btn btn-primary btn-wide submit pull-right">Save</button>
                <button class="btn btn-default btn-wide cancel pull-right margin-right-10">Cancel</button>
            </div>
            <?php
                echo $this->Form->end();
             ?>
        </div>
    </div>
    <!-- END CONTENT --> 
    <!-- ADD TAX POPUP BOX -->
    <div id="popup-add_tax" class="confirmation-modal modal fade in" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="confirm-close" data-dismiss="modal" aria-hidden="true">
                    <i class="glyphicon glyphicon-remove"></i>
                    </button>
                    <h4 class="modal-title">Add New Sales Tax</h4>
                </div>
                <div class="modal-body">
                    <dl>
                        <dt>Tax name</dt>
                        <dd><input type="text" id="tax_name"></dd>
                        <dt>Tax rate (%)</dt>
                        <dd><input type="text" id="tax_rate"></dd>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary confirm-close">Cancel</button>
                    <button class="btn btn-success submit">Add</button>
                </div>
            </div>
        </div>
    </div>
    <!-- ADD TAX POPUP BOX END -->
</div>
<div class="modal-backdrop fade in" style="display: none;"></div>
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
<script src="/theme/onzsa/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
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

    formValidation();
});

// form validation
var formValidation = function() {
    // for more info visit the official plugin documentation: 
    // http://docs.jquery.com/Plugins/Validation
    $("#xero_setup_form").validate({
        rules: {
        },
        messages: {
        },
        highlight: function(element, errorClass) {
            $(element).css('border-color', '#ff0000');
        },
        unhighlight: function(element, errorClass) {
            $(element).css('border-color', '#e5e5e5');
        },
        errorPlacement: function(error, element) {
            element.parent("dd").find(".help-block").html(error);
        }
    });
    $.validator.messages.required = 'Required.';
}
</script> 
<!-- END JAVASCRIPTS -->
