<!-- BOOKING POPUP BOX -->
<div id="booking_box" class="tab-content-wrapper col-md-12 col-xs-12 col-sm-12 col-alpha col-omega" tabindex="4" style="width=100%;">
    <div id="booking-wrapper" class="line-box  col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
        <select id="booking-availability" style="width: auto;">
            <option value="all">All</option>
            <option value="available">Available</option>
            <option value="unavailable">Unavailable</option>
        </select>
        <span class="glyphicon glyphicon-calendar icon-calendar"></span>
        <input type="text" id="booking-date" style="width: auto;">
        <input type="text" id="booking-start" placeholder="00:00" style="width: 120px;"> ~ <input type="text" id="booking-end" placeholder="00:00" style="width: 120px;">
        <ul style="width: 100%;">
            <li style="width: auto;">
                available
            </li>
            <li style="color: #FF0000; width:auto;">
                unavailable
            </li>
        </ul>
        <div class="solid-line"></div>
        <div class="portlet-body col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
            <div class="scroller setHeight" data-always-visible="1" data-rail-visible="0" style="height:359px; border: 0;">
                <ul class="feeds">
                    <li>
                    <?php if(!empty($res)) : ?>
                        <?php foreach($res as $resource) : ?>
                            <button class="btn btn-default booking-attr <?php if(!empty($bookings[$resource['MerchantResource']['id']])) {echo "booking-unavailable";} ?>" resource-id="<?php echo $resource['MerchantResource']['id']; ?>"><?php echo $resource['MerchantResource']['name']; ?></button>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- BOOKING POPUP BOX END -->
<!-- BOOKING CONFIRM POPUP BOX -->
<div id="booking_confirm_box" class="confirmation-modal modal fade in" tabindex="-1" role="dialog" aria-hidden="false" style="display: none;">
    <div class="modal-dialog" style="margin-top: 130px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="booking_confirm-close close_booking_popup" data-dismiss="modal" aria-hidden="true">
                    <i class="glyphicon glyphicon-remove"></i>
                </button>
                <h4 class="modal-title">Confirm booking</h4>
            </div>
            <div class="modal-body">
                <div class="booking_datetime" style="border: 1px solid red; padding: 5px;">
                    <h4 class="modal-title" style="width: auto;">Booking date & time&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input id="booking_asap" type="checkbox">ASAP</h4>
                    <span class="glyphicon glyphicon-calendar icon-calendar"></span>
                    <input type="text" id="booking-date-confirm" style="width: auto;">
                    <input type="text" id="booking-start-confirm" placeholder="00:00" style="width: 120px;"> ~ <input type="text" id="booking-end-confirm" placeholder="00:00" style="width: 120px;">
                </div>
                <div class="booking_customer" style="border: 1px solid red; padding: 5px; margin-top: 10px;">
                    <h4 class="modal-title">Select customer</h4>
                    <select id="booking-customer">
                    <?php foreach($customers as $customer) : ?>
                        <option value="<?php echo $customer['MerchantCustomer']['id']; ?>" <?php if($customer['MerchantCustomer']['customer_code'] == "walkin"){echo "selected";} ; ?>><?php if($customer['MerchantCustomer']['customer_code'] == "walkin") {echo "Search customer (No Customer)";} else {echo $customer['MerchantCustomer']['name'].'('.$customer['MerchantCustomer']['customer_code'].')';} ?></option>
                    <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button id="booking-proceed" class="btn btn-success" type="button" data-dismiss="modal">Booking</button>
                <button class="btn btn-primary close_booking_popup" type="button" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- BOOKING CONFIRM POPUP BOX END -->
<!-- SCRIPT BEGIN -->
<script src="/theme/onzsa/assets/global/plugins/jquery-1.11.0.min.js" type="text/javascript"></script>
<script>
$(document).ready(function () {
    $(document).on("click", ".booking-attr", function() {
        $(".booking-selected").removeClass("booking-selected");
        $(this).addClass("booking-selected");
        $("#booking_confirm_box").show();
    });

    $(document).on("click", ".booking-selected", function() {
        $(this).removeClass("booking-selected");
    });

    $(document).on("change", "#booking-availability", function() {
        if($(this).val() == "available") {
            $(".booking-attr").show();
            $(".booking-unavailable").hide();
        } else if($(this).val() == "unavailable") {
            $(".booking-attr").hide();
            $(".booking-unavailable").show();
        } else {
            $(".booking-attr").show();
        }
    });

    $("#booking-proceed").click(function (){
        var start_date = $("#booking-date-confirm").val() + ' ' + $("#booking-start-confirm").val();
        var end_date = $("#booking-date-confirm").val() + ' ' + $("#booking-end-confirm").val();
        $.ajax({
            url: '/home/booking.json',
            type: 'POST',
            data: {
                resource_id: $(".booking-selected").attr("resource-id"),
                start_date: start_date,
                end_date: end_date,
                customer_id: $("#booking-customer").val()
            },
            success: function(result) {
                if(result.success) {
                    $("#booking_confirm_box").hide();
                    $(".booking-attr[resource-id="+$(".booking-selected").attr("resource-id")+"]").addClass("booking-unavailable");
                    $(".booking-selected").removeClass("booking-selected");
                } else {
                    console.log(result);
                    console.log($("#booking-customer").val());
                }
            }
        });
    });

    $("#booking-date").change(function() {
        $("#booking-date-confirm").val($(this).val());
    });

    $("#booking-start").change(function() {
        $("#booking-start-confirm").val($(this).val());
    });

    $("#booking-end").change(function() {
        $("#booking-end-confirm").val($(this).val());
    });

    $("#booking_asap").change(function() {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1;
        var yyyy = today.getFullYear();
        var time = today.getHours() + ':' + today.getMinutes();
        console.log(time);
        if($("#booking_asap").is(':checked')) {
            $("#booking-date-confirm").val(yyyy+'-'+mm+'-'+dd);
            $("#booking-start-confirm").val(time);
        } else {
            console.log("u");
        }
    });
});
</script>
