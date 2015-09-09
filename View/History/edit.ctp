
<link href="/css/dataTable.css" rel="stylesheet" type="text/css">
<div class="clearfix"></div>
    <h3>Edit Sale</h3>

    <div class="portlet-body form">
        <!-- BEGIN FORM-->
        <div class="form-horizontal col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
            <div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">Details</div>
            <input type="hidden" id="sale_id" value="<?=$_GET['r'];?>">
            <!-- START col-md-12-->
            <div class="form-body line-box line-box-content col-md-12 col-xs-12 col-sm-12">
                <!-- START col-md-6-->
                <div class="col-md-6">
                    <dl>
                        <dt>Sale date</dt>
                        <dd>
                            <input type="text" value="<?=$sales[0]['RegisterSale']['sale_date'];?>">
                        </dd>
                        <dt>Register</dt>
                        <dd>
                            <select id="sale_register">
                                <?php foreach($registers as $register){ ?>
                                    <option value="<?=$register['MerchantRegister']['id'];?>" <?php if($register['MerchantRegister']['id'] == $sales[0]['RegisterSale']['register_id']){echo "selected";}?>><?=$register['MerchantRegister']['name'];?></option>
                                <?php } ?>
                            </select>
                        </dd>
                        <dt>Status</dt>
                        <dd>
                            <select id="sale_status">
                                <option value="<?=$sales[0]['RegisterSale']['status'];?>"><?=$sales[0]['RegisterSale']['status'];?></option>
                            </select>
                        </dd>
                        <dt>Note</dt>
                        <dd>
                            <textarea id="sale_note"><?=$sales[0]['RegisterSale']['note'];?></textarea>
                        </dd>
                    </dl>
                </div>
                <!-- START col-md-6-->
                <div class="col-md-6">
                    <dl>
                        <dt>Customer name</dt>
                        <dd>
                            <input type="search" id="customer_search">
                            <div class="search_result" class="display:none;">
                                <span class="search-tri"></span>
                                <div class="search-default"> No Result </div>

                                <?php foreach($customers as $customer){ ?>
                                    <button type="button"
                                    data-id="<?=$customer['MerchantCustomer']['id'];?>"
                                    data-code="<?=$customer['MerchantCustomer']['customer_code'];?>"
                                    data-balance="<?=$customer['MerchantCustomer']['loyalty_balance'];?>"
                                    data-mobile="" class="data-found customer_apply">
                                        <?=$customer['MerchantCustomer']['name'].' ('.
                                        $customer['MerchantCustomer']['customer_code'].')<br>$'.
                                        number_format($customer['MerchantCustomer']['loyalty_balance'],2,'.','');?>
                                    </button>
                                <?php } ?>
                            </div>
                            <input type="hidden" id="sale_customer" value="<?=$sales[0]['RegisterSale']['customer_id'];?>">
                        </dd>
                        <dt>Customer code</dt>
                        <dd class="sale_customer">
                            <?=$sales[0]['MerchantCustomer']['customer_code'];?>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12 pull-right margin-top-20 margin-bottom-20">
        <button class="btn btn-primary btn-wide save pull-right">Save</button>
        <button class="btn btn-default btn-wide pull-right margin-right-10 cancel">Cancel</button>
    </div>
</div>
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

<!-- BEGIN CORE PLUGINS -->
<?php echo $this->element('script-jquery'); ?>
<?php echo $this->element('script-angularjs'); ?>
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
<script src="/js/jquery.jqprint-0.3.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<?php echo $this->element('common-init'); ?>

<script>
jQuery(document).ready(function() {
    documentInit();
});

function documentInit() {
    // common init function
    commonInit();

    $(".cancel").click(function(){
        parent.history.back();
    });
    
    $(".save").click(function(){
        $.ajax({
            url: "/history/edit.json",
            type: "POST",
            data: {
                id: $("#sale_id").val(),
                customer_id: $("#sale_customer").val(),
                register: $("#sale_register").val(),
                status: $("#sale_status").val(),
                note: $("#sale_note").val()
            }
        }).done(function(){
            location.reload();
        });
    });
    
    
    var $cells = $(".data-found");
    $(".search_result").hide();

    $(document).on("keyup","#customer_search",function() {
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
            if($(".search_result").height() <= 20){
                $(".search-default").show();
            }
        }
        $cells.click(function(){
           $("#search").val($(this).text());
        });
    });
    
    $(".customer_apply").click(function(){
        $(".search_result").hide();
        $("#customer_search").val('');
        $("#sale_customer").val($(this).attr("data-id"));
        $(".sale_customer").text($(this).attr("data-code"));
    });
};
</script>
