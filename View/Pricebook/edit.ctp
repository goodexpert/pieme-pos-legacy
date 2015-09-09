
<link href="/css/dataTable.css" rel="stylesheet" type="text/css">
<div class="clearfix"></div>
<div id="notify"></div>
<!-- BEGIN CONTENT -->
<h3><?php echo $pricebook['MerchantPriceBook']['name']; ?></h3>
<div class="col-md-12 col-xs-12 col-sm-12 form-title margin-top-20">Detail</div>
<div class="line-box line-box-content col-md-12 col-sm-12 col-xs-12">
  <div class="price_book_details">
    <div class="col-md-6">
      <dl>
        <dt>Name</dt>
        <dd>
          <input type="text" id="price_book_name" value="<?php echo $pricebook['MerchantPriceBook']['name']; ?>">
        </dd>
        <dt>Customer group</dt>
        <dd>
          <select id="price_book_customer_group_id">
            <?php foreach ($groups as $group) { ?>
              <option
                  value="<?php echo $group['MerchantCustomerGroup']['id']; ?>" <?php if ($group['MerchantCustomerGroup']['id'] == $pricebook['MerchantPriceBook']['customer_group_id']) {
                echo "selected";
              } ?>><?php echo $group['MerchantCustomerGroup']['name']; ?></option>
            <?php } ?>
          </select>
        </dd>
        <dt>Outlet</dt>
        <dd>
          <select id="price_book_outlet_id">
            <option value="">All Outlets</option>
            <?php foreach ($outlets as $outlet) { ?>
              <option
                  value="<?php echo $outlet['MerchantOutlet']['id']; ?>" <?php if ($pricebook['MerchantPriceBook']['outlet_id'] == $outlet['MerchantOutlet']['id']) {
                echo "selected";
              } ?>><?php echo $outlet['MerchantOutlet']['name']; ?></option>
            <?php } ?>
          </select>
        </dd>
      </dl>
    </div>
    <div class="col-md-6">
      <dl>
        <dt>Valid from</dt>
        <dd>
          <span class="glyphicon glyphicon-calendar icon-calendar"></span>
          <input type="text" id="valid_from" value="<?php echo $pricebook['MerchantPriceBook']['valid_from']; ?>">
        </dd>
        <dt>Valid to</dt>
        <dd>
          <span class="glyphicon glyphicon-calendar icon-calendar"></span>
          <input type="text" id="valid_to" value="<?php echo $pricebook['MerchantPriceBook']['valid_to']; ?>">
        </dd>
        <dt>Type</dt>
        <dd class="price_book_type">
          <input type="button" class="btn btn-white btn-left individual col-md-6 active" value="individual">
          <input type="button" class="btn btn-white btn-right general selecetd col-md-6" value="general">
        </dd>
      </dl>
    </div>
  </div>
  <div class="price_book_general" style="display:none;">
    <div class="dashed-line"></div>
    <h2>General</h2>

    <div class="margin-bottom-20 col-md-12 col-alpha col-omega">
      <dl class="col-md-6">
        <dt>Markup</dt>
        <dd><input type="text" id="general_markup"></dd>
        <dt>Discount</dt>
        <dd><input type="text" id="general_discount"></dd>
      </dl>
      <dl class="col-md-6">
        <dt>Min. Units</dt>
        <dd><input type="number" id="general_min_units"></dd>
        <dt>Max. Unites</dt>
        <dd><input type="number" id="general_max_units"></dd>
      </dl>
    </div>
  </div>
  <div class="price_book_individual">
    <div class="dashed-line"></div>
    <h2>Individual</h2>

    <div class="margin-bottom-20 price_book_individual-search">
      <input type="search" id="search" placeholder="Search Products">

      <div class="search_result">
        <span class="search-tri"></span>

        <div class="search-default"> No Result</div>
        <?php foreach ($items as $item) { ?>

          <button type="button" data-id="<?= $item['MerchantProduct']['id']; ?>"
                  data-supply_price="<?= number_format($item['MerchantProduct']['supply_price'], 2, '.', ''); ?>"
                  data-retail-price="<?= number_format($item['MerchantProduct']['price'], 2, '.', ''); ?>"
                  data-markup="<?php echo $item['MerchantProduct']['markup'] * 100; ?>"
                  data-price="<?= number_format($item['MerchantProduct']['price_include_tax'], 2, '.', ''); ?>"
                  data-tax="<?= number_format($item['MerchantProduct']['tax'], 2, '.', ''); ?>"
                  data-tax-rate="<?php echo $item['MerchantTaxRate']['rate']; ?>"
                  class="data-found"><?= $item['MerchantProduct']['name']; ?>
          </button>

        <?php } ?>
      </div>
    </div>
    <!-- DATA HOLDER START -->
    <input type="hidden" class="data-name">
    <input type="hidden" class="data-supply_price">
    <input type="hidden" class="data-handle">
    <!-- DATA HOLDER END -->
    <table class="table table-bordered dataTable">
      <colgroup>
        <col width="15%">
        <col width="10%">
        <col width="10%">
        <col width="10%">
        <col width="10%">
        <col width="10%">
        <col width="10%">
        <col width="10%">
        <col width="10%">
        <col width="5%">
      </colgroup>
      <thead>
      <tr>
        <th>Product</th>
        <th>Supply price</th>
        <th>Markup (%)</th>
        <th>Discount</th>
        <th>Retail Price<br>
          <small>excluding tax</small>
        </th>
        <th>Sales Tax</th>
        <th>Retail Price<br>
          <small>including tax</small>
        </th>
        <th>Min. Units</th>
        <th>Max. Units</th>
        <th></th>
      </tr>
      </thead>
      <tbody>
      <tr>
        <td>Change all</td>
        <td></td>
        <td><input type="text" id="change_all_markup"></td>
        <td><input type="text" id="change_all_discount"></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <?php foreach ($pricebook['MerchantPriceBookEntry'] as $entry) { ?>
        <tr class="added_price_book_entry" data-id="<?php echo $entry['product_id']; ?>">
          <td><?php echo $entry['MerchantProduct']['name']; ?></td>
          <td class="entry_supply_price"><?php echo number_format($entry['MerchantProduct']['supply_price'], 2, '.', ''); ?></td>
          <td><input type="text" class="entry_markup" value="<?php echo $entry['markup'] * 100; ?>"></td>
          <td><input type="text" class="entry_discount"
                     value="<?php echo number_format($entry['discount'], 2, '.', ''); ?>"></td>
          <td class="entry_retail_price_exclude_tax"><?php echo number_format($entry['price'], 2, '.', ''); ?></td>
          <td class="entry_tax"
              tax-rate="<?php echo $entry['MerchantProduct']['MerchantTaxRate']['rate']; ?>"><?php echo number_format($entry['tax'], 2, '.', ''); ?></td>
          <td><input type="text" class="entry_retail_price_include_tax"
                     value="<?php echo number_format($entry['price_include_tax'], 2, '.', ''); ?>"></td>
          <td><input type="number" class="entry_min_unit" value="<?php echo $entry['min_units']; ?>"></td>
          <td><input type="number" class="entry_max_unit" value="<?php echo $entry['max_units']; ?>"></td>
          <td>
            <div class="clickable remove"><i class="glyphicon glyphicon-remove"></i></div>
          </td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
  </div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12 pull-right margin-top-20 margin-bottom-20">
  <button class="btn btn-primary btn-wide save pull-right">Save</button>
  <button class="btn btn-default btn-wide cancel pull-right margin-right-10">Cancel</button>
</div>
<!-- END CONTENT -->
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
<script src="/theme/onzsa/assets/admin/pages/scripts/index.js" type="text/javascript"></script>
<script src="/theme/onzsa/assets/admin/pages/scripts/tasks.js" type="text/javascript"></script>
<script type="text/javascript" src="/js/jquery.confirm.js"></script>
<script src="/js/jquery.popupoverlay.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<?php echo $this->element('common-init'); ?>
<script>
  jQuery(document).ready(function () {
    documentInit();
  });


  function documentInit() {
    // common init function
    commonInit();

    $("#valid_from").datepicker({dateFormat: 'yy-mm-dd'});
    $("#valid_to").datepicker({dateFormat: 'yy-mm-dd'});

    var price_book_type = 'individual';

    $(".general").click(function () {
      $(".price_book_general").show('bounce');
      $(".individual").removeClass("active");
      $(this).addClass("active");
      $(".price_book_individual").hide();
      $(this).blur();
      price_book_type = 'general';
    });
    $(".individual").click(function () {
      $(".price_book_general").hide();
      $(".general").removeClass("active");
      $(this).addClass("active");
      $(".price_book_individual").show('bounce');
      $(this).blur();
      price_book_type = 'individual';
    });

    $(document).on("click", ".data-found", function () {
      $(".price_book_individual tbody").append('<tr class="added_price_book_entry" data-id="' + $(this).attr("data-id") + '"><td>' + $(this).text() + '</td><td class="entry_supply_price">' + $(this).attr("data-supply_price") + '</td><td><input type="text" class="entry_markup" value="' + $(this).attr("data-markup") + '"></td><td><input type="text" class="entry_discount"></td><td class="entry_retail_price_exclude_tax">' + $(this).attr("data-retail-price") + '</td><td class="entry_tax" tax-rate="' + $(this).attr("data-tax-rate") + '">' + $(this).attr("data-tax") + '</td><td><input type="text" class="entry_retail_price_include_tax" value="' + $(this).attr("data-price") + '"></td><td><input type="number" class="entry_min_unit"></td><td><input type="number" class="entry_max_unit"></td><td><div class="clickable remove"><i class="glyphicon glyphicon-remove"></i></div></td></tr>');
      calculation();
    });
    /* DYNAMIC PROUCT SEARCH START */

    var $cells = $(".data-found");
    $(".search_result").hide();

    $(document).on("keyup", "#search", function () {
      var val = $.trim(this.value).toUpperCase();
      if (val === "")
        $(".search_result").hide();
      else {
        $cells.hide();
        $(".search_result").show();
        $(".search-default").hide();
        $cells.filter(function () {
          return -1 != $(this).text().toUpperCase().indexOf(val);
        }).show();
        if ($(".search_result").height() == 0) {
          $(".search-default").show();
        }
      }
    });
    /* DYNAMIC PRODUCT SEARCH END */

    $(document).on("click", ".remove", function () {
      $(this).parent().parent().remove();
    });

    $(document).on("click", ".save", function () {
      var entries = [];
      var entry = {};
      $(".added_price_book_entry").each(function () {
        entry.product_id = $(this).attr("data-id");
        entry.price = $(this).find(".entry_retail_price_exclude_tax").text();
        entry.markup = $(this).find(".entry_markup").val() / 100;
        entry.discount = $(this).find(".entry_discount").val();
        entry.tax = $(this).find(".entry_tax").text();
        entry.price_include_tax = $(this).find(".entry_retail_price_include_tax").val()
        entry.min_units = $(this).find(".entry_min_unit").val();
        entry.max_units = $(this).find(".entry_max_unit").val();
        entries.push(entry);
        entry = {};
      });
      $.ajax({
        url: location.href + '.json',
        type: 'POST',
        data: {
          name: $("#price_book_name").val(),
          customer_group_id: $("#price_book_customer_group_id").val(),
          outlet_id: $("#price_book_outlet_id").val(),
          valid_from: $("#valid_from").val(),
          valid_to: $("#valid_to").val(),
          entries: JSON.stringify(entries),
          type: price_book_type,
          general_markup: $("#general_markup").val() / 100,
          general_discount: $("#general_discount").val(),
          general_min_units: $("#general_min_units").val(),
          general_max_units: $("#general_max_units").val()
        },
        success: function (result) {
          if (result.success) {
            window.location.href = "/pricebook/view?r=" + result.price_book_id;
          } else {
            console.log(result.message);
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
          console.log(textStatus, errorThrown);
        }
      });
    });

    $(".cancel").click(function () {
      window.history.back();
    });

    function calculation() {
      $(".added_price_book_entry").each(function () {
        var supply_price = $(this).find(".entry_supply_price");
        var retail_price = $(this).find(".entry_retail_price_exclude_tax");
        var markup = $(this).find(".entry_markup");
        var discount = $(this).find(".entry_discount");
        var tax = $(this).find(".entry_tax");
        var price = $(this).find(".entry_retail_price_include_tax");

        var changed_retail_price = supply_price.text() * (markup.val() / 100 + 1);
        var changed_tax = changed_retail_price * tax.attr("tax-rate");

        retail_price.text(changed_retail_price.toFixed(2));
        tax.text(changed_tax.toFixed(2));
        price.val((changed_retail_price + changed_tax - discount.val()).toFixed(2));
      });
    }

    $(document).on("focusout", "#change_all_markup", function () {
      var value_to_change = $(this).val();
      if (!value_to_change == '') {
        $(".added_price_book_entry").each(function () {
          $(this).find(".entry_markup").val(value_to_change);
        });
      }
      calculation();
    });
    $(document).on("focusout", "#change_all_discount", function () {
      var value_to_change = $(this).val();
      if (!value_to_change == '') {
        $(".added_price_book_entry").each(function () {
          $(this).find(".entry_discount").val(value_to_change);
        });
      }
      calculation();
    });
  }
</script>
