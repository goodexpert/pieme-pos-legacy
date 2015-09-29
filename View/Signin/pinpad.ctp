<div class="clearfix"></div>
<div class="container"> 
    <div class="page-content-wrapper">
        <div class="page-content col-xs-12 col-alpha col-omega">
            <div class="col-xs-12 signin-pin-content">
                <?php
                    echo $this->Form->create('MerchantUser', array(
                        'id' => 'login_form',
                        'type' => 'POST'
                    ));
                    echo $this->Form->input('domain_prefix', array(
                        'id' => 'domain_prefix',
                        'type' => 'hidden',
                        'div' => false,
                        'label' => false
                    ));
                    echo $this->Form->input('username', array(
                        'id' => 'username',
                        'type' => 'hidden',
                        'div' => false,
                        'label' => false
                    ));
                    echo $this->Form->input('pincode', array(
                        'id' => 'pincode',
                        'type' => 'hidden',
                        'div' => false,
                        'label' => false
                    ));
                    echo $this->Form->end();
                 ?>
                <div class="help-block with-errors"><?php echo $this->Session->flash(); ?></div>
                <ul class="col-xs-12 numpad-enter">
                    <h2 class="text-center"><strong>CLICK THE PASSWORD</strong></h2>
                    <li>
                        <div class="numpad-enter-button" id="pin_number0"></div>
                    </li>
                    <li>
                        <div class="numpad-enter-button" id="pin_number1"></div>
                    </li>
                    <li>
                        <div class="numpad-enter-button" id="pin_number2"></div>
                    </li>
                    <li>
                        <div class="numpad-enter-button" id="pin_number3"></div>
                    </li>
                </ul>
                <div class="col-xs-12">
                    <div id="numpad-signin" class="col-xs-12">
                        <div class="number_button pincode" id="pincode1">1</div>
                        <div class="number_button pincode" id="pincode2">2</div>
                        <div class="number_button pincode" id="pincode3">3</div>
                        <div class="number_button pincode" id="pincode4">4</div>
                        <div class="number_button pincode" id="pincode5">5</div>
                        <div class="number_button pincode" id="pincode6">6</div>
                        <div class="number_button pincode" id="pincode7">7</div>
                        <div class="number_button pincode" id="pincode8">8</div>
                        <div class="number_button pincode" id="pincode9">9</div>
                        <div class="number_button-gr number_button pin-clear">CLR</div>
                        <div class="number_button pincode" id="pincode0">0</div>
                        <div class="number_button-gr number_button pin-enter">ENT</div>
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
<!-- END PAGE LEVEL SCRIPTS -->
<script>
var pincode = ['', '', '', ''];
var pinidx = 0;

jQuery(document).ready(function() {
    Metronic.init(); // init metronic core components
    Layout.init(); // init current layout

    $(".pincode").click(function(e) {
        if (pinidx >= 4) {
            clear();
        }

        pincode[pinidx++] = $(this).text();
        updateView();
    });

    $(".pin-clear").click(function(e) {
        clear();
    });

    $(".pin-enter").click(function(e) {
        if (pinidx < 4)
            return;

        var pinNumber = '';
        for (var i = 0; i < 4; i++) {
            pinNumber += pincode[i];
        }

        $("#pincode").val(pinNumber);
        $("#username").val($("#domain_prefix").val() + '_' + pinNumber);
        $("#login_form").submit();
    });
});

function clear() {
    pincode = ['', '', '', ''];
    pinidx = 0;
    updateView();
}

function updateView() {
    for (var i = 0; i < 4; i++) {
        $("#pin_number" + i).text(pincode[i] == '' ? '' : '*');
    }
}
</script>
<!-- END JAVASCRIPTS -->
