<div class="container">
    <form action="/stock_orders/<?php echo $order_id; ?>/send" method="post" class="form-horizontal" id="send_order_form">
    <div class="modal-header">
        <h4 class="modal-title">Send order</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="recipient_name" class="col-sm-3 control-label">Recipient</label>
            <div class="col-sm-8">
                <?php
                    echo $this->Form->input('recipient_name', array(
                        'type' => 'text',
                        'class' => 'form-control',
                        'id' => 'recipient_name',
                        'div' => false,
                        'label' => false
                    ));
                 ?>
            </div>
        </div>
        <div class="form-group">
            <label for="to" class="col-sm-3 control-label">Email</label>
            <div class="col-sm-8">
                <?php
                    echo $this->Form->input('to', array(
                        'type' => 'email',
                        'class' => 'form-control',
                        'id' => 'to',
                        'div' => false,
                        'label' => false
                    ));
                 ?>
            </div>
        </div>
        <div class="form-group">
            <label for="cc" class="col-sm-3 control-label">Cc</label>
            <div class="col-sm-8">
                <?php
                    echo $this->Form->input('cc', array(
                        'type' => 'email',
                        'class' => 'form-control',
                        'id' => 'cc',
                        'div' => false,
                        'label' => false
                    ));
                 ?>
            </div>
        </div>
        <div class="form-group">
            <label for="subject" class="col-sm-3 control-label">Subject</label>
            <div class="col-sm-8">
                <?php
                    echo $this->Form->input('subject', array(
                        'type' => 'text',
                        'class' => 'form-control',
                        'id' => 'subject',
                        'div' => false,
                        'label' => false
                    ));
                 ?>
            </div>
        </div>
        <div class="form-group">
            <label for="message" class="col-sm-3 control-label">Message</label>
            <div class="col-sm-8">
                <?php
                    echo $this->Form->input('message', array(
                        'type' => 'textarea',
                        'class' => 'form-control',
                        'rows' => '4',
                        'cols' => '30',
                        'id' => 'message',
                        'div' => false,
                        'label' => false
                    ));
                 ?>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-wide" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success btn-wide send-email">Send</button>
    </div>
    </form>
</div>
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<?php if (!$this->request->is('ajax')) : ?>
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
<script src="/theme/onzsa/assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/global/plugins/gritter/js/jquery.gritter.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<!-- END PAGE LEVEL SCRIPTS -->
<?php endif; ?>
<script type="text/javascript">
$(document).ready(function() {
    formValidation();
});

// form validation
var formValidation = function() {
    // for more info visit the official plugin documentation: 
    // http://docs.jquery.com/Plugins/Validation
    $("#send_order_form").validate({
        rules: {
            'data[recipient_name]': {
                required: false
            },
            'data[to]': {
                required: true,
                email: true
            },
            'data[cc]': {
                required: false,
                email: true
            },
            'data[subject]': {
                required: true
            },
            'data[message]': {
                required: true
            }
        },
        messages: {
            'data[to]': {
                required: "Required",
                email: "The email address appears to be invalid."
            },
            'data[cc]': {
                email: "The email address appears to be invalid."
            },
            'data[subject]': {
                required: "Required"
            },
            'data[message]': {
                required: "Don't forget to put in an introduction to the order email."
            }
        },
    });
}
</script>
<!-- END JAVASCRIPTS -->
