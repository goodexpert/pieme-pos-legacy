<style>
#registerTable ul li {
    list-style: square;
    margin-left: 1em;
}
</style>
<link href="/css/dataTable.css" rel="stylesheet" type="text/css"/>
<div class="clearfix"></div>
     <div id="notify"></div>
    <!-- BEGIN CONTENT -->
             <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega margin-bottom-20">
                <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
                    Outlets and Registers
                </h2>
                <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20">
                    <a href="/receipt_template/add"><button class="btn btn-white pull-right btn-right" style="color:black">
                        <div class="glyphicon glyphicon-import"></div>&nbsp;
                    Add Receipt Template</button></a>
                    <a href="/outlet/add"><button class="btn btn-white pull-right btn-left">
                        <div class="glyphicon glyphicon-plus"></div>&nbsp;
                    Add Outlet</button></a> 
                </div>
            </div>
            <table id="registerTable" class="table table-striped table-bordered dataTable">
                <thead>
                <tr>
                    <th>Outlet Name</th>
                    <th>Registers</th>
                    <th>Status</th>
                    <th>Details</th>
                    <th></th>
                </tr>
                </thead>
                
                <tbody>
                    <?php foreach($outlets as $outlet){ ?>
                        <tr>
                            <td><?=$outlet['MerchantOutlet']['name'];?></td>
                            <td colspan="3"></td>
                            <td>
                            <a href="/outlet/<?=$outlet['MerchantOutlet']['id'];?>/edit">Edit Outlet</a> | 
                            <a href="/register/add?outlet=<?=$outlet['MerchantOutlet']['id'];?>">Add a Register</a>
                            </td>
                        </tr>
                        <?php foreach($outlet['MerchantRegister'] as $register){ ?>
                            <tr>
                                <td></td>
                                <td><?=$register['name'];?></td>
                                <td>Open</td>
                                <td>
                                    <ul>
                                        <li><?php echo $register['MerchantQuickKey']['name'];?></li>
                                        <li><?php echo $register['MerchantReceiptTemplate']['name'];?></li>
                                        <li>Invoice <?php echo $register['invoice_sequence']+1;?></li>
                                        <a class="clickable more_details"><li style="list-style: none">More Details</li></a>
                                        <?php if($register['email_receipt'] == 1){ ?>
                                        <li class="hidden_li" style="display:none;">Email receipt</li>
                                        <?php }
                                        if($register['print_receipt'] == 1){ ?>
                                        <li class="hidden_li" style="display:none;">Print receipt</li>
                                        <?php }
                                        if(!$register['ask_for_note_on_save'] == 0) { ?>
                                        <li class="hidden_li" style="display:none;">Ask for note on <?php if($register['ask_for_note_on_save'] == 1){echo 'Save/Layby/Account/Return';}else{echo "all sales";}?></li>
                                        <?php }
                                        if($register['print_note_on_receipt'] == 1){ ?>
                                        <li class="hidden_li" style="display:none;">Print note on receipt</li>
                                        <?php }
                                        if($register['show_discounts'] == 1){ ?>
                                        <li class="hidden_li" style="display:none;">Show discounts on receipt</li>
                                        <?php } ?>
                                        <a class="clickable fewer_details" style="display:none;"><li style="list-style: none">Fewer Details</li></a>
                                    </ul>
                                </td>
                                <td><a href="/register/<?=$register['id'];?>/edit">Edit register</a></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
            <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega margin-bottom-20">
                <h2>
                    Receipt Templates
                </h2>

                <?php foreach($receipt_templates as $template) { ?>
                    <a href="/receipt_template/<?php echo $template['MerchantReceiptTemplate']['id'];?>/edit">
                        <?php echo $template['MerchantReceiptTemplate']['name'];?></a>
                <?php } ?>
            </div>
    <!-- END CONTENT -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<?php echo $this->element('script-jquery'); ?>
<?php echo $this->element('script-angularjs'); ?>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js"></script>
<script src="/theme/onzsa/assets/global/plugins/flot/jquery.flot.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/flot/jquery.flot.resize.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/flot/jquery.flot.categories.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jquery.pulsate.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/bootstrap-daterangepicker/moment.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
<script src="/theme/onzsa/assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/jquery.sparkline.min.js"></script>
<script src="/theme/onzsa/assets/global/plugins/gritter/js/jquery.gritter.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->


<script src="/theme/onzsa/assets/admin/pages/scripts/tasks.js"></script>
<script src="/js/notify.js"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN COMMON INIT -->
<?php echo $this->element('common-init'); ?>
<!-- END COMMON INIT -->
<script>
jQuery(document).ready(function(){
  documentInit();
});

function documentInit() {
  // common init function
    commonInit();
    Metronic.init(); // init metronic core componets
    Index.init();
    
    $(".more_details").click(function(){
        $(this).hide();
        $(this).parent('ul').find(".hidden_li").show();
        $(this).parent().children(".fewer_details").show();
    });
    $(".fewer_details").click(function(){
        $(this).hide();
        $(this).parent('ul').find(".hidden_li").hide();
        $(this).parent().children(".more_details").show();
    });
};
</script>
<!-- END JAVASCRIPTS -->
