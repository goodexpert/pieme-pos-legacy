<div class="clearfix"></div>
    <div id="notify"></div>
    <!-- BEGIN CONTENT -->
            <div class="quick-key">
                <div class="new-layout">
                    <span class="quick-key-new-layout" >
                        <strong>New Stock List Layout</strong>
                    </span>
                    <div class="quick-key-btn" >
                        <button class="btn btn-primary cancel">Cancel</button>
                        <button class="btn btn-primary delete">Delete Layout</button>
                        <button class="btn btn-success save">Save Layout</button>
                    </div>
                </div>
                <div class="quick-key-top" >
                    <div class="quick-key-search">
                        <input type="search" id="search" placeholder="Search Products">
                        <div class="quick_search_result" style="display: none;">
                            <span class="search-tri"></span>
                            <div class="search-default"> No Result </div>
                        </div>
                    </div>
                    <div class="quick-key-name" >
                       <input type="text" id="layout_name" value="New Stock List Layout" >
                       <span class="layout-name">Layout Name: </span>
                    </div>
                    <div class="quick-key-add-page">
                      <!--
                        <span class="page-add">Pages</span>
                        <button id="remove-page" class="btn btn-white btn-left">-</button>
                        <button id="add-page" class="btn btn-white btn-right">+</button>
                      -->
                    </div>
                </div>
                <div id="block-center" class="quick-key-body">
                    <ul class="nav nav-tabs">
                        <li position="0" class="active" role="presentation">
                            <a href="javascript:;">Group 1 <i class="glyphicon glyphicon-cog" data-toggle="popover" data-placement="bottom" data-container="body"></i></a>
                        </li>
                        <button type="button" id="add-category" class="btn btn-white btn-add-category" data-toggle="popover" data-placement="bottom" data-container="body">
                        +
                        </button>
                    </ul>
                    <div class="quick-key-list">
                        <ul id="sortable" class="ui-sortable">
                        </ul>
                    </div>
                  <!--
                    <div class="quick-key-list-footer">
                        <span class="pull-left clickable prev"><i class="glyphicon glyphicon-chevron-left"></i></span>
                        <span class="pull-right clickable next"><i class="glyphicon glyphicon-chevron-right"></i></span>
                        <span rel="1" class="page clickable selected">1</span>
                    </div>
                  -->
                </div>
            </div>

<div id="popover-content" class="hide">
  <div class="form-line" role="form">
    <div class="form-group">
      <input type="hidden" class="form-control" name="id">
      <input type="hidden" class="form-control" name="type">
      <input type="text" class="form-control" name="name" placeholder="Name">
      <select class="color-control" name="background">
        <option value="#FF0000">Red</option>
        <option value="#0100FF">Blue</option>
        <option value="#000">Black</option>
        <option value="#FFE400">Yellow</option>
        <option value="#FFF">White</option>
      </select>
      <div class="popover-buttons">
        <button type="button" class="btn btn-success action-trigger col-xs-6 col-sm-6 col-md-6 col-lg-6">Add</button>
        <button type="button" class="btn btn-primary cancel-tab col-xs-6 col-sm-6 col-md-6 col-lg-6">Cancel</button>
        <button type="button" class="btn btn-danger delete-item col-xs-12 col-sm-12 col-md-12 col-lg-12">Delete</button>
      </div>
    </div>
  </div>
</div>
<!-- END CONTENT -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<?php echo $this->element('script-jquery'); ?>
<?php echo $this->element('script-angularjs'); ?>
<!-- END CORE PLUGINS --><!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" ></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" ></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" ></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" ></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" ></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" ></script>
<script src="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" ></script>
<script src="/theme/onzsa/assets/global/plugins/flot/jquery.flot.min.js" ></script>
<script src="/theme/onzsa/assets/global/plugins/flot/jquery.flot.resize.min.js" ></script>
<script src="/theme/onzsa/assets/global/plugins/flot/jquery.flot.categories.min.js" ></script>
<script src="/theme/onzsa/assets/global/plugins/jquery.pulsate.min.js" ></script>
<script src="/theme/onzsa/assets/global/plugins/bootstrap-daterangepicker/moment.min.js" ></script>
<script src="/theme/onzsa/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js" ></script>
<!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support -->
<script src="/theme/onzsa/assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.min.js" ></script>
<script src="/theme/onzsa/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" ></script>
<script src="/theme/onzsa/assets/global/plugins/jquery.sparkline.min.js" ></script>
<script src="/theme/onzsa/assets/global/plugins/gritter/js/jquery.gritter.js" ></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="/theme/onzsa/assets/global/scripts/metronic.js" ></script>
<script src="/theme/onzsa/assets/admin/layout/scripts/layout.js" ></script>
<script src="/theme/onzsa/assets/admin/pages/scripts/index.js" ></script>
<script src="/theme/onzsa/assets/admin/pages/scripts/tasks.js" ></script>
<script src="/js/notify.js" ></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN COMMON INIT -->
<?php echo $this->element('common-init'); ?>
<!-- END COMMON INIT -->
<script>

  // Quick Keys Data
  var quick_keys = {"quick_keys":{"groups":[{"position":0,"name":"Group 1","color":"white","pages":[{"page":1,"keys":[]}]}]}};

  // Indicate for current group and current page
  var currentGroupNo = 0;
  var currentPageNo = 0;


  /**
   * Initialize Tabs(Groups) UI for Quick Keys
   *
   * @return void
   */
  function initTabs(){
    $("li[role=presentation]").remove();
  }

  /**
   * Initialize Quick Keys UI for Quick Keys
   *
   * @return void
   */
  function initQuickKeys(){
    $('.ui-sortable').empty();
  }

  /**
   * Initialize Pages UI for Quick Keys
   *
   * @return void
   */
  function initPages(){
    $('.quick-key-list-footer').filter(":not(:contains('span'))").remove();
    currentPageNo = 0;
  }

  /**
   * Reload Quick Keys UI for Quick Keys
   *
   * @return void
   */
  function reloadQuickKeysData() {
    initTabs();
    initQuickKeys();
    initPages();

    setTabs();
    setQuickKeys();
    setPages();
  }

  /**
   * Set Quick Keys UI for Quick Keys
   *
   * @return void
   */
  function loadQuickKeysData() {
    setTabs();
    setQuickKeys();
    setPages();

//    console.log(quick_keys);
  }

  /**
   * Set Tabs(Group) UI for Quick Keys
   *
   * @return void
   */
  function setTabs(){

    var keyLayouts = quick_keys;
    keyLayouts = keyLayouts['quick_keys']['groups'];

    for(var i=0; i < keyLayouts.length; i++){

      var keyLayout = keyLayouts[i];
      var active = "";
      var color = "";

      if(currentGroupNo == keyLayout['position']) active = "active";
      switch(keyLayout['color']){
        case "#000" : color = 'Black'; break;
        case "#ff0000" : color = 'Red'; break;
        case "#0100ff" : color = 'Blue'; break;
        case "#ffe400" : color = 'Yellow'; break;
        case "#fff" : color = 'White'; break;
        default : color = keyLayout['color'];
      }

      $(".quicKeyLayout").append("<li position='" + keyLayout['position'] + "' class='tab " + active + "' role='presentation'><a href='javascript:;' class='" + color + "'>"
          + keyLayout['name']+ "<i class='glyphicon glyphicon-cog' data-toggle='popover' data-placement='bottom' data-container='body'></i></a></li>");
    }
  }

  /**
   * Set Quick Keys UI for Quick Keys
   *
   * @return void
   */
  function setQuickKeys(){

    var groups = quick_keys;
    groups = groups['quick_keys']['groups'];

    for(var i=0; i < groups.length; i++){
      var group = groups[i];
      var pages = group['pages'];

      if(currentGroupNo == group['position']) {

        for (var j = 0; j < pages.length; j++) {
          var page = pages[j];

          if (page['keys'] != null) {
            var keys = page['keys'];

            for (var k = 0; k < keys.length; k++) {
              var key = keys[k];

              var active = "";
              var color = "";
              if(groups['position'] > 0 ||  page['page'] > 1 ) active = "display: none";
              if(key['color'] != null) {
                switch (key['color']) {
                  case "#000" : color = 'Black'; break;
                  case "#ff0000" : color = 'Red'; break;
                  case "#0100ff" : color = 'Blue'; break;
                  case "#ffe400" : color = 'Yellow'; break;
                  case "#fff" : color = 'White'; break;
                  default : color = key['color'];
                }
              }else {
                color = 'White';
              }

              $('.ui-sortable').append("<li class='quick-key-item " + color + "' style='" + active + "' group='" + groups['position'] + "' data-id='" + key['product_id'] + "' data-sku='" + key['sku'] + "' page='" + page['page'] + "' background=" + key['color'] + "'><p>" + key['label'] + "</p></li>");
            }
          }
        }
      }
    }
  }

  /**
   * Set Pages UI for Quick Keys
   *
   * @return void
   */
  function setPages(){

    var pages = quick_keys['quick_keys']['groups'][currentGroupNo]['pages'];

    for(var i=0; i < pages.length; i++){

      $('.quick-key-list-footer').append("&nbsp;" + (i+1) + "&nbsp;");
    }
  }



  jQuery(document).ready(function() {
    documentInit();
  });

  function documentInit() {
    // common init function
    Metronic.init();  // init metronic core componets
    Layout.init();    // init layout
    Index.init();
    loadQuickKeysData();

    $( "#sortable" ).sortable({
      revert: true,
      disabled: true
    });

    extThis = this;

    /* DYNAMIC PROUCT SEARCH START */

    $("#search").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "/quick_key/search.json",
                method: "POST",
                dataType: "json",
                data: {
                    keyword: request.term
                },
                success: function (data) {
                    product = null;
                    if (!data.success)
                        return;

                    response($.map(data.products, function (item) {
                        return ({
                            label: item.name + ' (' + item.sku + ')',
                            handle: item.handle,
                            sku: item.sku,
                            data: item
                        });
                    }));
                }
            });
        },
        minLength: 2,
        select: function( event, ui ) {
          product = ui.item.data;
          $(this).val(ui.item.sku);

          // If it has variants or child node, need to one more query
          if (product.has_variants == "1" || product.parent_id != null) {
            $.ajax({
              url: "/quick_key/variants.json",
              method: "POST",
              dataType: "json",
              data: {
                sku: ui.item.sku,
                label: ui.item.label,
                product_id: ui.item.data.id,
                parent_id: ui.item.data.parent_id
              },
              success: function (data) {
                product = null;
                if (!data.success)
                  return;

                var key = {};
                key.position = quick_keys["quick_keys"]["groups"][currentGroupNo]["pages"][currentPageNo]["keys"].length;
                key.color = "White";
                key.label = data.label;
                key.sku = data.sku;
                key.product_id = data.id;
                key.parent = data.parent;
                key.selections = data.selections;
                if (data.parent == true) {
                  key.options = data.options;
                  key.variants = data.variants;
                }

                quick_keys["quick_keys"]["groups"][currentGroupNo]["pages"][currentPageNo]["keys"].push(key);
                initQuickKeys();
                setQuickKeys();

                $("#search").val("");
              }
            });
          }
          // Normal Item
          else {
            var key = {};
            key.position = quick_keys["quick_keys"]["groups"][currentGroupNo]["pages"][currentPageNo]["keys"].length;
            key.color = "White";
            key.label = ui.item.label;
            key.sku = ui.item.sku;
            key.product_id = product.id;
            key.parent = false;

            quick_keys["quick_keys"]["groups"][currentGroupNo]["pages"][currentPageNo]["keys"].push(key);
            initQuickKeys();
            setQuickKeys();

            $("#search").val("");
          }
          return false;
        },
        open: function( event, ui ) {
            $("ul").last().attr({class:"ui-autocomplete ui-front ui-menu ui-widget-1 ui-widget-content-1 ui-corner-all"});
        }
    });
    /* DYNAMIC PRODUCT SEARCH END */

    /* PAGE CONTROL */

    $(document).on('click','.page',function(){
      $(".page").removeClass("selected");
      $(".quick-key-item").hide();
      $(".quick-key-item[page="+$(this).attr("rel")+"][group="+$(".nav-tabs").find(".active").attr("position")+"]").show();
      $(this).addClass("selected");

      currentPageNo = $(this).attr("positon");
    });

    var pageCount = $(".page").length;
    $("#add-page").click(function(){
      pageCount++;
      $(".quick-key-list-footer").append('<span rel="'+pageCount+'" class="page clickable">'+pageCount+'</span>');
      $(".page").removeClass("selected");
      $(".page[rel="+pageCount+"]").addClass("selected");
      $(".quick-key-item").hide();

      currentPageNo = pageCount;
    });
    $("#remove-page").click(function(){
      if(pageCount !== 1){
        $(".quick-key-list-footer").find("span[rel="+pageCount+"]").remove();
        $(".quick-key-item[page="+pageCount+"]").remove();
        pageCount--;
        $(".page").removeClass("selected");
        $(".page[rel="+pageCount+"]").addClass("selected");
        $(".quick-key-item[page="+pageCount+"]").show();
      }
      currentPageNo = pageCount;
    });
    /* PAGE CONTROL END */

    /* SAVE TRIGGER */

    $(document).on("click",".save",function(){
      var key_layouts = JSON.stringify(quick_keys);

      $.ajax({
        url: location.href+'.json',
        type: "POST",
        data: {
          name: $("#layout_name").val(),
          key_layouts: key_layouts,
        },
        success: function(result) {
          if(result.success) {
            window.location.href = "/setup/quick_keys";
          } else {
            console.log(result);
          }
        }
      });

    });

    /* SAVE TRIGGER END */

    /**
     * Cancel Edit Layout
     */
    $(".cancel").click(function(){
      window.history.back();
    });

    /**
     * Click Delect from Popover
     */
    $(document).on("click", ".delete-item", function() {
      // Quick Key Delete
      if($(".target-key").length > 0) {
        var idx = $(".target-key").index();
        quick_keys["quick_keys"]["groups"][currentGroupNo]["pages"][currentPageNo]["keys"].splice(idx,1);

        // change position value
        if(idx < quick_keys["quick_keys"]["groups"][currentGroupNo]["pages"][currentPageNo]["keys"].length) {
          for(var i=idx; i < quick_keys["quick_keys"]["groups"][currentGroupNo]["pages"][currentPageNo]["keys"].length; i++) {
            quick_keys["quick_keys"]["groups"][currentGroupNo]["pages"][currentPageNo]["keys"][i]["position"] = i;
          }
        }
        initQuickKeys();
        setQuickKeys();
      }
      // Group Delete
      else if($(".target").length > 0) {
        var idx = currentGroupNo;
        quick_keys["quick_keys"]["groups"].splice(currentGroupNo,1);

        // Select Right Group
        if(idx < quick_keys["quick_keys"]["groups"].length) {
          // change position value
          for(var i=idx; i < quick_keys["quick_keys"]["groups"].length; i++) {
            quick_keys["quick_keys"]["groups"][i]["position"] = i;
          }
        }
        // Select Left Group
        else {
          currentGroupNo = currentGroupNo - 1;
        }

        $(".popover").remove();
        $(".target").removeClass("target");
        $(".target-key").removeClass("target-key");

        initTabs();
        setTabs();
        initQuickKeys();
        setQuickKeys();
      }
    });

    /**
     * Click Cancel from Popover
     */
    $(document).on("click", ".cancel-tab", function() {
      $(".popover").remove();
    });

    /**
     * Tab Click
     */
    $(document).on("click", ".tab", function() {
      var prePos = parseInt($(".nav-tabs").find(".active").attr("position"));
      $(".nav-tabs").find(".active").removeClass("active");
      $(this).addClass("active");
      currentGroupNo = parseInt($(".nav-tabs").find(".active").attr("position"));
      initQuickKeys();
      setQuickKeys();
    });
  };

  /**
   * toggle pop over
   */
  $(".glyphicon-cog").popover({
    html: true,
    content: function() {
      return $('#popover-content').html();
    },
  });

  /**
   * Config Icon Click on Tabs
   */
  $(document).on("click", ".glyphicon-cog", function() {
    $(".target").removeClass("target");
    $(".target-key").removeClass("target-key");
    $(".popover-buttons:last").children(".btn-success").removeClass("add-category");
    $(this).popover({
      html: true,
      content: function() {
        return $('#popover-content').html();
      },
    });
    var original_name = $(this).parents("a");
    original_name.addClass("target");
    $(".popover:last").find("input[name=name]").val(original_name.text().trim());
    $(".popover-buttons").children(".btn-success").text("Edit");
    $(".popover-buttons").children(".delete-item").removeClass("hide");
  });

  /**
   * Category Add Click Setting
   */
  $("#add-category").popover({
    html: true,
    content: function() {
      return $('#popover-content').html();
    },
  });


  /**
   * Click Group Add BTN
   */
  $("#add-category").click(function() {
    $(".target").removeClass("target");
    $(".target-key").removeClass("target-key");
    $(".popover-buttons").children(".btn-success").text("Add");
    $(".popover-buttons").children(".delete-item").addClass("hide");
  });

  /**
   * Quick Key Item Click Setting
   */
  $(document).on("click", ".quick-key-item", function() {
    $(".target").removeClass("target");
    $(".target-key").removeClass("target-key");
    $(this).popover({
      html: true,
      content: function() {
        return $('#popover-content').html();
      },
    });
    var original_name = $(this).find("p");
    $(".popover:last").find("input[name=name]").val(original_name.text().trim());
    $(".popover-buttons").children(".btn-success").text("Edit");
    $(".popover-buttons").children(".delete-item").removeClass("hide");
    $(this).addClass("target-key");
  });

  /**
   * Action Trigger Event
   */
  $(document).on("click", ".action-trigger", function() {
    // Edit Group
    if($(".target").length > 0) {
      var idx = $(".target").index();
      var name = $(".popover:last").find("input[name=name]").val();
      var color = $(".popover:last").find("select[name=background] option:selected").text();
      $(".target").attr("class", "target");
      $(".target").html(name + ' <i class="glyphicon glyphicon-cog" data-toggle="popover" data-placement="bottom" data-container="body"></i>');
      $(".target").addClass(color);

      quick_keys["quick_keys"]["groups"][currentGroupNo]["color"] = color;
      quick_keys["quick_keys"]["groups"][currentGroupNo]["name"] = name;
    }
    // Edit Quick Key
    else if($(".target-key").length > 0) {
      var aria = $(".target-key").attr("aria-describedby"),
          color = $("#" + aria).find("select[name=background] option:selected").text(),
          color_code = $("#" + aria).find("select[name=background]").val(),
          label = $("#" + aria).find("input[name=name]").val(),
          idx = $(".target-key").index();

      $(".target-key").attr("class", "target-key quick-key-item");
      $(".target-key").addClass(color);
      $(".target-key").attr("background", color_code);
      $(".target-key").find("p").text(label);

      quick_keys["quick_keys"]["groups"][currentGroupNo]["pages"][currentPageNo]["keys"][idx]["color"] = color;
      quick_keys["quick_keys"]["groups"][currentGroupNo]["pages"][currentPageNo]["keys"][idx]["label"] = label;
    }
    // Add Group
    else {
      var idx = $(".nav-tabs").find("li").length,
          name = $(".popover:last").find("input[name=name]").val(),
          color = $(".popover:last").find("select[name=background] option:selected").text();

      $(".nav-tabs").find(".active").removeClass("active");
      $(".nav-tabs").append('<li position="'+ idx +'" class="active" role="presentation">' +
          '<a href="javascript:;" class="' + color + '">' + name +
          ' <i class="glyphicon glyphicon-cog" data-toggle="popover" data-placement="bottom" data-container="body"></i></a></li>');

      var groupLayout = {}, pageHolder = {}, pageLayout = [], keys = [];
      pageHolder.page = 1;
      pageHolder.keys = keys;
      pageLayout.push(pageHolder);
      groupLayout.position = idx;
      groupLayout.name = name;
      groupLayout.color = color;
      groupLayout.pages = pageLayout;
      quick_keys["quick_keys"]["groups"].push(groupLayout);

      currentGroupNo = idx;
      initQuickKeys();
      setQuickKeys();
    }
    $(".popover").remove();
    $(".target").removeClass("target");
    $(".target-key").removeClass("target-key");
  });
</script>
<!-- END JAVASCRIPTS -->
