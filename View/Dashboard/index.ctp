
<div class="clearfix"></div>
      <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
      <div class="modal fade" id="portlet-config" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
              <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body"> Widget settings form goes here </div>
            <div class="modal-footer">
              <button type="button" class="btn blue">Save changes</button>
              <button type="button" class="btn default" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content --> 
        </div>
        <!-- /.modal-dialog --> 
      </div>
      <!-- /.modal --> 
      <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM--> 
      <!-- BEGIN PAGE HEADER-->
      <div class="col-md-12 col-xs-12 col-sm-12">
        <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega"> Dashboard </h2>
        <div class="pull-right col-md-5 col-xs-5 col-sm-5 col-alpha col-omega margin-top-20">
          <a href="/product/add">
          <button class="btn btn-white pull-right btn-right" style="color:black">
          <div class="glyphicon glyphicon-plus"></div>
          &nbsp;
          Add Product</button></a>
          <a href="/">
          <button class="btn btn-white pull-right btn-left">
          <div class="glyphicon glyphicon-tag"></div>
          &nbsp;
          New sale</button></a>
        </div>
      </div>
      <!-- END PAGE HEADER--> 
      <div class="clearfix"> </div>
      <div class="col-md-12 col-sm-12"> 
        <input type="hidden" id="sales-data" value='<?php echo json_encode($sales);?>'>
        <!-- BEGIN PORTLET-->
        <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega form-title margin-top-20">Sales</div>
        <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega line-box line-box-content portlet solid grey-cararra bordered">
          <div class="portlet-body">
            <div id="site_activities_loading"> <img src="/theme/metronic/assets/admin/layout/img/loading.gif" alt="loading"/> </div>
            <div id="site_activities_content" class="display-none">
              <div id="site_activities" style="height: 228px;"> </div>
            </div>
            <div style="margin: 20px 0 10px 30px">
              <?php
              $revenue = 0;
              $tax = 0;
              $count = 0;
              $cost = 0;
              foreach($sales as $key => $value) {
                $revenue += $value['amount'];
                $tax += $value['tax'];
                $count += $value['count'];
                $cost += $value['cost'];
              } ?>
              <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-6 text-stat"> <span class="label label-sm label-success"> Revenue: </span>
                  <h3>$<?php echo number_format($revenue,2,'.',',');?></h3>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-6 text-stat"> <span class="label label-sm label-info"> Tax: </span>
                  <h3>$<?php echo number_format($tax,2,'.',',');?></h3>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-6 text-stat"> <span class="label label-sm label-danger"> Profit: </span>
                  <h3>$<?php echo number_format($revenue - $tax - $cost,2,'.',',');?></h3>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-6 text-stat"> <span class="label label-sm label-warning"> Orders: </span>
                  <h3><?php echo $count;?></h3>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- END PORTLET--> 
      </div>
      <div class="col-md-6 col-sm-6"> 
        <!-- BEGIN PORTLET-->
        <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega form-title margin-top-20">Reports</div>
        <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega line-box line-box-content portlet solid bordered grey-cararra">
          <ul class="col-md-6 col-xs-12 col-sm-12 dashboard-list">
            <li><a href="/reports/sales/sales_by_period">Sales Totals by Period</a></li>
            <li><a href="/reports/sales/sales_by_day">Sales Totals by Day</a></li>
            <li><a href="/reports/sales/sales_by_category">Sales by Tag</a></li>
            <li><a href="/reports/sales/payments_by_month">Payment Types by Month</a></li>
          </ul>
          <ul class="col-md-6 col-xs-12 col-sm-12 dashboard-list">
            <li><a href="/reports/sales/sales_by_month">Sales Totals by Month</a></li>
            <li><a href="/reports/sales/sales_by_hour">Sales Activity by Hour</a></li>
            <li><a href="/reports/sales/register_sales_detail">Register Sales Detail</a></li>
          </ul>
        </div>
      </div>
      <div class="col-md-6 col-sm-6"> 
        <!-- BEGIN PORTLET-->
        <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega form-title margin-top-20">Product Reports</div>
        <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega line-box line-box-content portlet solid bordered grey-cararra">
          <ul class="col-md-6 col-xs-12 col-sm-12 dashboard-list">
            <li><a href="/reports/sales/popular_products">Popular Products</a></li>
            <li><a href="/reports/sales/products_by_type">Product Sales by Type</a></li>
            <li><a href="/reports/sales/products_by_oulet">Product Sales by Outlet</a></li>
            <li><a href="/reports/sales/products_by_supplier">Product Sales by Supplier</a></li>
          </ul>
          <ul class="col-md-6 col-xs-12 col-sm-12 dashboard-list">
            <li><a href="/reports/sales/products_by_user">Product Sales by User</a></li>
            <li><a href="/reports/sales/products_by_customer">Product Sales by Customer</a></li>
            <li><a href="/reports/sales/products_by_customer_group">Product Sales by Customer Group</a></li>
          </ul>
        </div>
      </div>
      <div class="col-md-6 col-sm-6"> 
        <!-- BEGIN PORTLET-->
        <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega form-title margin-top-20">Stock Reports</div>
        <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega line-box line-box-content portlet solid bordered grey-cararra">
          <ul class="col-md-6 col-xs-12 col-sm-12 dashboard-list">
            <li><a href="/reports/stock/levels">Stock Levels</a></li>
            <li><a href="/reports/stock/low">Low Stock</a></li>
          </ul>
          <ul class="col-md-6 col-xs-12 col-sm-12 dashboard-list">
            <li><a href="/reports/stock/onhand">Stock On Hand</a></li>
          </ul>
        </div>
      </div>
      <div class="col-md-6 col-sm-6"> 
        <!-- BEGIN PORTLET-->
        <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega form-title margin-top-20">Product Reports</div>
        <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega line-box line-box-content portlet solid bordered grey-cararra">
          <ul class="col-md-6 col-xs-12 col-sm-12 dashboard-list">
            <li><a href="/reports/closures">Register Closures</a></li>
            <li>&nbsp;</li>
          </ul>
          <ul class="col-md-6 col-xs-12 col-sm-12 dashboard-list">
            <li> </li>
          </ul>
        </div>
      </div>
      <div class="clearfix"> </div>

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

  <!-- BEGIN CORE PLUGINS -->
  <?php echo $this->element('script-jquery'); ?>
  <?php echo $this->element('script-angularjs'); ?>
  <!-- END CORE PLUGINS -->

  <!-- BEGIN PAGE LEVEL PLUGINS -->
  <script src="/theme/metronic/assets/global/plugins/flot/jquery.flot.min.js"></script>
  <script src="/theme/metronic/assets/global/plugins/flot/jquery.flot.resize.min.js"></script>
  <script src="/theme/metronic/assets/global/plugins/flot/jquery.flot.categories.min.js"></script>
  <script src="/theme/metronic/assets/global/plugins/jquery.pulsate.min.js"></script>
  <script src="/theme/metronic/assets/global/plugins/bootstrap-daterangepicker/moment.min.js"></script>
  <script src="/theme/metronic/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script src="/theme/metronic/assets/global/plugins/gritter/js/jquery.gritter.js"></script>
  <!--   IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support-->
  <script src="/theme/onzsa/assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.min.js"></script>
  <script src="/theme/metronic/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.js"></script>
  <script src="/theme/metronic/assets/global/plugins/jquery.sparkline.min.js"></script>
  <!-- END PAGE LEVEL PLUGINS -->

  <!-- BEGIN PAGE LEVEL SCRIPTS -->
  <script src="/theme/metronic/assets/global/scripts/metronic.js"></script>
  <script src="/theme/metronic/assets/admin/layout/scripts/layout.js"></script>
  <script src="/theme/metronic/assets/admin/pages/scripts/index.js"></script>
  <script src="/theme/metronic/assets/admin/pages/scripts/tasks.js"></script>
  <!-- END PAGE LEVEL SCRIPTS -->

  <?php echo $this->element('common-init'); ?>
  <script>
  jQuery(document).ready(function() {
    documentInit();
  });

  function documentInit() {
    // common init function
    commonInit();

    // page init function
    var sales_data = JSON.parse($("#sales-data").val());
    var sales = [];

    $.each(sales_data, function(key, value) {
      sales.push([key.toUpperCase(), value['amount']]);
    });

    Index.init();
    Index.initCharts(sales.reverse()); // init index page's custom scripts
    Index.initMiniCharts();
    Index.initDashboardDaterange();
    Tasks.initDashboardWidget();
  }
  </script>
<!-- END JAVASCRIPTS -->
