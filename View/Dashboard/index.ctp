<?php
  $user = $this->Session->read('Auth.User');
?>
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

      <div class="clearfix"> </div>

      <!-- BEGIN CHART AREA -->
      <div class="row">
        <div class="col-md-12 col-xs-12 col-sm-12 dashboard-area">

          <!-- BEGIN PORTLET CHART 1 -->
          <input type="hidden" id="sales-data" value='<?php echo json_encode($sales);?>'>
          <div class="col-md-6 col-xs-12 col-sm-12 dashboard-warpper ">
            <div class="portlet light bordered dashboard">
              <div class="portlet-title">
                <div class="caption">
                  <i class="fa fa-line-chart"></i>Sales
                </div>
              </div>
              <div class="portlet-body">
                <div id="chart_amount_loading"> <img src="/theme/metronic/assets/admin/layout/img/loading.gif" alt="loading"/> </div>
                <div id="chart_amount_content" class="display-none">
                  <div id="chart_amount" class="chart" style="height: 228px;"> </div>
                </div>
              </div>
            </div>
          </div>
          <!-- END PORTLET CHART 1 -->

          <!-- BEGIN PORTLET CHART 2-->
          <input type="hidden" id="products-data" value='<?php echo json_encode($products);?>'>
          <div class="col-md-6 col-xs-12 col-sm-12 dashboard-warpper ">
            <div class=" portlet light bordered dashboard">
              <div class="portlet-title">
                <div class="caption">
                  <i class="fa fa-pie-chart"></i>Products
                </div>
              </div>
              <div class="portlet-body">
                <div id="chart_product_loading"> <img src="/theme/metronic/assets/admin/layout/img/loading.gif" alt="loading"/> </div>
                <div id="chart_product_content" class="display-none">
                  <div id="chart_product" class="chart" style="height: 228px;"> </div>
                </div>
              </div>
            </div>
          </div>
          <!-- END PORTLET CHART 2 -->

        </div>
      </div>
      <!-- END CHART AREA -->

      <!-- BEGIN REPORT AREA -->
      <div class="row">
        <div class="col-md-12 col-xs-12 col-sm-12 dashboard-area">

          <!-- BEGIN PORTLET SECTION 1 -->
          <div class="col-md-6 col-xs-12 col-sm-12 dashboard-warpper">
            <div class="portlet box green light bordered dashboard-box line-box-content ">
              <div class="portlet-title dashboard-title">
                <div class="caption dashboard">
                  <i class="fa fa-file-text-o"></i>Sale Reports
                </div>
              </div>
              <div class="col-md-12 col-xs-12 col-sm-12 portlet-body">
                <ul class="col-md-6 col-xs-12 col-sm-12 dashboard-list">
                  <li><a href="/reports/sales/sales_by_month">Sales Totals by Month</a></li>
                  <li><a href="/reports/sales/sales_by_period">Sales Totals by Period</a></li>
                  <li><a href="/reports/sales/sales_by_day">Sales Totals by Day</a></li>

                  <?php if ($user['user_type_id'] === "user_type_admin") : ?>
                    <li><a href="/reports/sales/sales_by_hour">Sales Activity by Hour</a></li>
                  <?php endif; ?>

                </ul>
                <ul class="col-md-6 col-xs-12 col-sm-12 dashboard-list">
                  <?php if ($user['user_type_id'] === "user_type_admin") : ?>
                    <li><a href="/reports/sales/payments_by_month">Payment Types by Month</a></li>
                    <li><a href="/reports/sales/sales_by_category">Sales by Tag</a></li>
                    <li><a href="/reports/sales/register_sales_detail">Register Sales Detail</a></li>
                  <?php endif; ?>
                </ul>
              </div>
            </div>
          </div>
          <!-- END PORTLET SECTION 1 -->

          <!-- BEGIN PORTLET SECTION 2-->
          <?php if ($user['user_type_id'] === "user_type_admin") : ?>
            <div class="col-md-6 col-xs-12 col-sm-12 dashboard-warpper">
              <div class="portlet box green light bordered dashboard-box line-box-content ">
                <div class="portlet-title dashboard-title">
                  <div class="caption">
                    <i class="fa fa-file-text-o"></i>Product Reports
                  </div>
                </div>
                <div class="col-md-12 col-xs-12 col-sm-12 portlet-body">
                  <ul class="col-md-6 col-xs-12 col-sm-12 dashboard-list">
                    <li><a href="/reports/sales/popular_products">Popular Products</a></li>
                    <li><a href="/reports/sales/products_by_type">Product Sales by Type</a></li>
                    <li><a href="/reports/sales/products_by_supplier">Product Sales by Supplier</a></li>
                    <li><a href="/reports/sales/products_by_oulet">Product Sales by Outlet</a></li>
                  </ul>
                  <ul class="col-md-6 col-xs-12 col-sm-12 dashboard-list">
                    <li><a href="/reports/sales/products_by_user">Product Sales by User</a></li>
                    <li><a href="/reports/sales/products_by_customer">Product Sales by Customer</a></li>
                    <li><a href="/reports/sales/products_by_customer_group">Product Sales by Customer Group</a></li>
                  </ul>
                </div>
              </div>
            </div>
          <?php else : ?>
            <!-- If manager, display menu for section 3 to section 2 -->
            <div class="col-md-6 col-xs-12 col-sm-12 dashboard-warpper">
              <div class="portlet box green light bordered dashboard-box line-box-content ">
                <div class="portlet-title dashboard-title">
                  <div class="caption">
                    <i class="fa fa-file-text-o"></i>Register Reports
                  </div>
                </div>
                <div class="col-md-12 col-xs-12 col-sm-12 portlet-body">
                  <ul class="col-md-6 col-xs-12 col-sm-12 dashboard-list">
                    <li><a href="/reports/closures">Register Closures</a></li>
                    <li>&nbsp;</li>
                    <li>&nbsp;</li>
                  </ul>
                  <ul class="col-md-6 col-xs-12 col-sm-12 dashboard-list">
                    <li> </li>
                  </ul>
                </div>
              </div>
            </div>
          <?php endif; ?>
          <!-- END PORTLET SECTION 2 -->
        </div>
      </div>


      <div class="row">
        <div class="col-md-12 col-xs-12 col-sm-12 dashboard-area">

          <!-- BEGIN PORTLET SECTION 3 -->
          <?php if ($user['user_type_id'] === "user_type_admin") : ?>
          <div class="col-md-6 col-xs-12 col-sm-12 dashboard-warpper">
            <div class="portlet box green light bordered dashboard-box line-box-content ">
              <div class="portlet-title dashboard-title">
                <div class="caption">
                  <i class="fa fa-file-text-o"></i>Register Reports
                </div>
              </div>
              <div class="col-md-12 col-xs-12 col-sm-12 portlet-body">
                <ul class="col-md-6 col-xs-12 col-sm-12 dashboard-list">
                  <li><a href="/reports/closures">Register Closures</a></li>
                  <li>&nbsp;</li>
                </ul>
                <ul class="col-md-6 col-xs-12 col-sm-12 dashboard-list">
                  <li> </li>
                </ul>
              </div>
            </div>
          </div>
          <?php endif; ?>
          <!-- END PORTLET SECTION 3 -->

          <!-- BEGIN PORTLET SECTION 4-->
          <?php if ($user['user_type_id'] === "user_type_admin") : ?>
            <div class="col-md-6 col-xs-12 col-sm-12 dashboard-warpper">
              <div class="portlet box green light bordered dashboard-box line-box-content ">
                <div class="portlet-title dashboard-title">
                  <div class="caption">
                    <i class="fa fa-file-text-o"></i>Stock Reports
                  </div>
                </div>
                <div class="col-md-12 col-xs-12 col-sm-12 portlet-body">
                  <ul class="col-md-6 col-xs-12 col-sm-12 dashboard-list">
                    <li><a href="/reports/stock/levels">Stock Levels</a></li>
                    <li><a href="/reports/stock/low">Low Stock</a></li>
                  </ul>
                  <ul class="col-md-6 col-xs-12 col-sm-12 dashboard-list">
                    <li><a href="/reports/stock/onhand">Stock On Hand</a></li>
                  </ul>
                </div>
              </div>
            </div>
          <?php endif; ?>
          <!-- END PORTLET SECTION 4 -->
        </div>
      </div>
      <!-- END REPORT AREA -->

      <div class="clearfix"> </div>

<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->

  <!-- BEGIN CORE PLUGINS -->
  <?php echo $this->element('script-jquery'); ?>
  <?php echo $this->element('script-angularjs'); ?>
  <!-- END CORE PLUGINS -->

  <!-- BEGIN PAGE LEVEL PLUGINS -->
  <script src="/theme/metronic/assets/global/plugins/flot/jquery.flot.min.js"></script>
  <script src="/theme/metronic/assets/global/plugins/flot/jquery.flot.pie.min.js"></script>
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
  <script src="/theme/onzsa/assets/admin/pages/scripts/dashboard_charts.js"></script>
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
    var products_data = JSON.parse($("#products-data").val());

    DashboardCharts.initAmountLineChart(sales_data);
    DashboardCharts.initProductPieChart(products_data);

  }
  </script>
<!-- END JAVASCRIPTS -->
