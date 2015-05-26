<div class="clearfix"></div>
<div class="container"> 
    <div class="page-content-wrapper">
        <div class="page-content col-xs-12 col-alpha col-omega">
            <div class="col-xs-12 signin-pin-content">
                <ul class="col-xs-12 numpad-enter">
                    <h2 class="text-center"><strong>CLICK THE PASSWORD</strong></h2>
                    <li>
                        <div class="numpad-enter-button"></div>
                    </li>
                    <li>
                        <div class="numpad-enter-button"></div>
                    </li>
                    <li>
                        <div class="numpad-enter-button"></div>
                    </li>
                    <li>
                        <div class="numpad-enter-button"></div>
                    </li>
                </ul>
                <div class="col-xs-12">
                    <div id="numpad-signin" class="col-xs-12">
                        <div class="number_button">1</div>
                        <div class="number_button">2</div>
                        <div class="number_button">3</div>
                        <div class="number_button">4</div>
                        <div class="number_button"></div>
                        <div class="number_button"></div>
                        <div class="number_button"></div>
                        <div class="number_button"></div>
                        <div class="number_button"></div>
                        <div class="number_button-gr number_button">CLR</div>
                        <div class="number_button"></div>
                        <div class="number_button-gr number_button">ENT</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
<script src="/theme/onzsa/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/select2/select2.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/theme/onzsa/assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/admin/layout/scripts/layout.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/admin/pages/scripts/login-soft.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<script>
jQuery(document).ready(function() {
    Metronic.init(); // init metronic core components
    Layout.init(); // init current layout
    Login.init();

    /*
    $(".submit").click(function(e) {
        var domain_prefix = document.getElementById('domain_prefix');
        if (domain_prefix != null) {
            var form = document.getElementById('login_form');
            form.action = "https://"+domain_prefix.value+".onzsa.com/users/login";
        }
    });
     */
});
</script>
<!-- END JAVASCRIPTS -->
