<div class="clearfix"> </div>
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
      <div class="col-md-12 col-xs-12 col-sm-12"><h3>Edit Receipt Template</h3></div>
      <div class="portlet-body form"> 
        <!-- BEGIN FORM-->
        <div class="form-horizontal col-md-12 col-xs-12 col-sm-12">
          <div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">Details</div>
          <!-- START col-md-12-->
          <div class="form-body line-box line-box-content col-md-12 col-xs-12 col-sm-12"> 
              <!-- START col-md-6-->
              <div class="col-md-6">
                <dl>
                  <dt>Receipt name</dt>
                  <dd>
                    <input type="text">
                  </dd>
                  <dt>Receipt style</dt>
                  <dd>
                    <select>
						<option></option>
					</select>
                  </dd>
                  <dt>Print receipt barcode</dt>
                  <dd>
                    <input type="radio"> Yes <span class="margin-right-10"></span>
                    <input type="radio"> No
                  </dd>
                </dl>
              </div>
          </div>
        </div>
        <div class="form-horizontal col-md-12 col-xs-12 col-sm-12">
          <div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">Layout</div>
          <!-- START col-md-12-->
          <div class="form-body line-box line-box-content col-md-12 col-xs-12 col-sm-12"> 
              <!-- START col-md-6-->
              <div class="col-md-6">
                <dl>
                  <dt>Banner image</dt>
                  <dd class="height-inherit">
                    <input type="file">
					<h6>Upload a JPG, PNG or GIF file, no wider than 280px.</h6>
                  </dd>
                  <dt>Header text</dt>
                  <dd class="height-inherit">
                    <textarea></textarea>
					<h6>Limit this to around one paragraph or no more than 15 lines.</h6>
                  </dd>
                  <dt>Invoice.no.prefix</dt>
                  <dd>
                    <input type="text" value="">
                  </dd>
                  <dt>Invoice heading</dt>
                  <dd>
                    <input type="text">
                  </dd>
                  <dt>Served by label</dt>
                  <dd>
                    <input type="text">
                  </dd>
                  <dt>Discount label</dt>
                  <dd>
                    <input type="text">
                  </dd>
                  <dt>Sub total label</dt>
                  <dd>
                    <input type="text">
                  </dd>
                  <dt>Tax label</dt>
                  <dd>
                    <input type="text">
                  </dd>
                  <dt>To pay label</dt>
                  <dd>
                    <input type="text">
                  </dd>
                  <dt>Total label</dt>
                  <dd>
                    <input type="text">
                  </dd>
                  <dt>Change label</dt>
                  <dd>
                    <input type="text">
                  </dd>
                  <dt>Footer text</dt>
                  <dd class="height-inherit">
                    <textarea></textarea>
					<h6>Limit this to around one paragraph or no more than 15 lines.</h6>
                  </dd>
                </dl>
              </div>
          </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12 pull-right margin-top-20 margin-bottom-20">
            <button class="btn btn-primary btn-wide save pull-right">Save</button>
            <button class="btn btn-default btn-wide pull-right margin-right-10">Cancel</button>
        </div>
        </div>
    </div>
  </div>
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
  <!-- END CONTENT --> 
  <!-- BEGIN QUICK SIDEBAR --> 
  <a href="javascript:;" class="page-quick-sidebar-toggler"><i class="icon-close"></i></a>
  <div class="page-quick-sidebar-wrapper">
    <div class="page-quick-sidebar">
      <div class="nav-justified">
        <ul class="nav nav-tabs nav-justified">
          <li class="active"> <a href="#quick_sidebar_tab_1" data-toggle="tab"> Users <span class="badge badge-danger">2</span> </a> </li>
          <li> <a href="#quick_sidebar_tab_2" data-toggle="tab"> Alerts <span class="badge badge-success">7</span> </a> </li>
          <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> More<i class="fa fa-angle-down"></i> </a>
            <ul class="dropdown-menu pull-right" role="menu">
              <li> <a href="#quick_sidebar_tab_3" data-toggle="tab"> <i class="icon-bell"></i> Alerts </a> </li>
              <li> <a href="#quick_sidebar_tab_3" data-toggle="tab"> <i class="icon-info"></i> Notifications </a> </li>
              <li> <a href="#quick_sidebar_tab_3" data-toggle="tab"> <i class="icon-speech"></i> Activities </a> </li>
              <li class="divider"> </li>
              <li> <a href="#quick_sidebar_tab_3" data-toggle="tab"> <i class="icon-settings"></i> Settings </a> </li>
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
});
</script> 
<!-- END JAVASCRIPTS -->