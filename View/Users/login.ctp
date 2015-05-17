<style>
.create_account {
    text-align: center;
}
</style>
<div class="clearfix"></div>
<div class="container"> 
    <div class="page-content-wrapper">
        <div class="page-content sell-index col-lg-12 col-md-12 col-sm-12 col-xs-12 col-alpha col-omega">
            <div class="maximum col-lg-12 col-md-12 col-sm-12 col-xs-12 col-alpha col-omega">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="signin-container">
                        <form action="/users/login" method="post">
                        <div class="line-box">
                            <h1>Sign in</h1>
                            <div class="dashed-line-gr"></div>
                            <dl>
                                <dt>Email or Username</dt>
                                <dd>
                                    <?php
                                        echo $this->Form->input('MerchantUser.username', array(
                                            'type' => 'text',
                                            'id' => 'username',
                                            'div' => false,
                                            'label' => false
                                        ));
                                     ?>
                                </dd>
                                <dt>Password</dt>
                                <dd>
                                    <?php
                                        echo $this->Form->input('MerchantUser.password', array(
                                            'type' => 'password',
                                            'id' => 'password',
                                            'div' => false,
                                            'label' => false
                                        ));
                                     ?>
                                </dd>
                            </dl>
                            <div class="dashed-line-gr"></div>
                            <button class="btn btn-success"><img src="/img/ONZSA_eye.png">Start onzsa</button>
                        </div>
                        </form>
                    </div>
                    <p class="create_account">Don't have an account? <a href="https://www.onzsa.com/signup">Try Onzsa for free</a></p>
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
<script src="/theme/onzsa/assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
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
});
</script>
<!-- END JAVASCRIPTS -->
