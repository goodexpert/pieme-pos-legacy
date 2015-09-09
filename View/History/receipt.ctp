<div class="clearfix"></div>
  <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
      <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega">
          View Receipt
      </h2>
      <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20">
          <button id="import" class="btn btn-white pull-right print">
              <div class="glyphicon glyphicon-print"></div>&nbsp;
          print</button>
      </div>
  </div>
  <div class="receipt-parent col-md-12 col-xs-12 col-sm-12">
      <div class="col-md-12 col-xs-12 col-sm-12">
          <div class="receipt-pos">
              <span class="receipt-pos-inner"></span>
          </div>
      </div>
      <div id="receipt" class="receipt-content">
            <div class="col-md-12 col-xs-12 col-sm-12 show-amount">
              <div class="receipt-header">
                  <h2>ONZSA</h2>
              </div>
              <div class="dashed-line-gr"></div>
              <div class="receipt-body">
                  <div class="receipt-body-customer">
                      <?php if($sales['MerchantCustomer']['customer_code'] !== 'walkin'){ ?>
                          <span class="receipt-customer-name"><?php echo $sales['MerchantCustomer']['customer_code'];?></span><br>
                      <?php } ?>
                      <span class="receupt-customer-region">New Zealand</span>
                  </div>
                  <h4 class="receipt-body-type">
                      Receipt / Tax Invoice
                  </h4>
                  <div class="receipt-body-info">
                      Invoice #: <?php echo $sales['RegisterSale']['receipt_number'];?><br>
                      <span class="invoice-date"><?=$sales['RegisterSale']['sale_date'];?></span><br>
                      Served by: <?php echo $sales['MerchantUser']['display_name'];?> on <?php echo $sales['MerchantRegister']['name'];?>
                  </div>
                  <div class="dashed-line-gr"></div>
                  <div class="col-md-12 col-xs-12 col-sm-12 col-omega col-alpha receipt-body-sales">
                      <table class="col-md-12 col-xs-12 col-sm-12 col-omega col-alpha receipt-product-table">
                          <?php foreach($sales['RegisterSaleItem'] as $item){ ?>
                          <tr>
                              <td class="receipt-product-qty"><?=$item['quantity'];?></td>
                              <td class="receipt-product-name"><?=$item['MerchantProduct']['name'];?></td>
                              <td class="receipt-price pull-right">$<?=number_format($item['price'],2,'.','');?></td>
                          </tr>
                          <?php } ?>
                      </table>
                      <div class="dashed-line-gr"></div>
                      <table class="col-md-12 col-xs-12 col-sm-12 col-omega col-alpha receipt-product-table-total">
                          <tr>
                              <th>Subtotal</th>
                              <td class="total-amount receipt-subtotal pull-right">$<?=number_format($sales['RegisterSale']['total_price'],2,'.',',');?></td>
                          </tr>
                          <tr>
                              <th>Tax (GST)</th>
                              <td class="total-amount receipt-tax pull-right">$<?=number_format($sales['RegisterSale']['total_tax'],2,'.',',');?></td>
                          </tr>
                          <tr>
                              <th>TOTAL</th>
                              <td class="total-amount receipt-total pull-right">$<?=number_format($sales['RegisterSale']['total_price_incl_tax'],2,'.',',');?></td>
                          </tr>
                      </table>
                  </div>
              </div>
           </div>
          <div class="receipt-bt"></div>
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
<script src="/theme/onzsa/assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script>
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

  QuickSidebar.init() // init quick sidebar
  $(".print").click(function(){
      $("#receipt").jqprint();
      return false;
  });
};

function getUrlParameter(sParam)
{
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) 
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) 
        {
            return sParameterName[1];
        }
    }
}
</script>
