<?php
    $user = $this->Session->read('Auth.User');
 ?>
<div data-ng-controller="HeaderController" class="page-header md-shadow-z-1-i navbar navbar-fixed-top">

<!-- BEGIN HEADER INNER -->
<div class="page-header-inner container">
    <!-- BEGIN LOGO -->
    <div class="page-logo">
        <a href="#/">
            <img src="/app/images/logo-default.png" alt="logo" class="logo-default"/>
        </a>
        <div class="menu-toggler sidebar-toggler">
            <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
        </div>
    </div>
    <!-- END LOGO -->


  <!-- BEGIN RESPONSIVE MENU TOGGLER -->
    <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"></a>
    <!-- END RESPONSIVE MENU TOGGLER -->

    <!-- BEGIN PAGE ACTIONS -->
    <!-- DOC: Remove "hide" class to enable the page header actions -->
    <!-- END PAGE ACTIONS -->

    <!-- BEGIN PAGE TOP -->
    <div class="page-top">
        <!-- BEGIN HEADER SEARCH BOX -->
        <!-- DOC: Apply "search-form-expanded" right after the "search-form" class to have half expanded search box -->
        <!-- END HEADER SEARCH BOX -->
        <!-- BEGIN TOP NAVIGATION MENU -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">

              <!-- BEGIN REGISTER DROPDOWN -->
              <?php if ($user['user_type_id'] !== "user_type_cashier") : ?>
              <!-- case : multi register -->
              <li class="dropdown dropdown-register" ng-if="registers_count > 1">
                <a href="#" class="dropdown-toggle" dropdown-menu-hover data-toggle="dropdown" data-close-others="true">
                  <i class="fa fa-fw fa-tv "></i>
                  <span class="registername hide-on-mobile">{{register.name}}</span>
                  <i class="fa fa-angle-down"></i>
                </a>
                <ul class="dropdown-menu">
                  <li>
                    <a href ng-click="changeRegister()"><i class="fa fa-refresh"></i> Change Register </a>
                  </li>
                </ul>
              </li>
              <!-- case : only one register -->
              <li class="dropdown dropdown-register" ng-if="registers_count == 1">
                <span class="dropdown-toggle-only">
                  <i class="fa fa-fw fa-tv"></i>
                  <span class="registername hide-on-mobile">{{register.name}}</span>
                </span>
              </li>
              <?php endif ?>
              <!-- END REGISTER DROPDOWN -->

              <!-- BEGIN USER LOGIN DROPDOWN -->
              <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
              <li class="dropdown dropdown-user">
                  <a href="#" class="dropdown-toggle" dropdown-menu-hover data-toggle="dropdown" data-close-others="true">
                    <i class="fa fa-fw fa-user "></i>
                    <span class="username hide-on-mobile" id="TEST" ng-if="!config"> <?php echo $user['display_name']; ?></span>
                    <span class="username hide-on-mobile" id="TEST" ng-if="config">{{config.user_display_name}}</span>
                    <i class="fa fa-angle-down"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-default">
                      <!--
                      <li>
                        <a href="#/profile/dashboard">
                        <i class="icon-user"></i> My Profile </a>
                      </li>
                      <li>
                        <a href="#">
                        <i class="icon-calendar"></i> My Calendar </a>
                      </li>
                      <li>
                        <a href="#">
                        <i class="icon-envelope-open"></i> My Inbox <span class="badge badge-danger">
                        3 </span>
                        </a>
                      </li>
                      <li>
                        <a href="#/todo">
                        <i class="icon-rocket"></i> My Tasks <span class="badge badge-success">
                        7 </span>
                        </a>
                      </li>
                      <li class="divider">
                      </li>
                      <li>
                        <a href="#">
                        <i class="icon-lock"></i> Lock Screen </a>
                      </li>
                      -->
                      <li>
                        <a href="#"><i class="icon-notebook"></i> My Sales </a>
                      </li>
                      <li class="divider">
                      <li>
                        <a href="/signin/logout"><i class="icon-key"></i> Log Out </a>
                      </li>
                  </ul>
              </li>
              <!-- END USER LOGIN DROPDOWN -->
            </ul>
        </div>
        <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END PAGE TOP -->
</div>
<!-- END HEADER INNER -->

</div>

<script>
  // Handles the horizontal menu
  var handleHeader = function() {
    // handle search box expand/collapse
    $('.page-header').on('click', '.search-form', function(e) {
      $(this).addClass("open");
      $(this).find('.form-control').focus();

      $('.page-header .search-form .form-control').on('blur', function(e) {
        $(this).closest('.search-form').removeClass("open");
        $(this).unbind("blur");
      });
    });

    // handle hor menu search form on enter press
    $('.page-header').on('keypress', '.hor-menu .search-form .form-control', function(e) {
      if (e.which == 13) {
        $(this).closest('.search-form').submit();
        return false;
      }
    });

    // handle header search button click
    $('.page-header').on('mousedown', '.search-form.open .submit', function(e) {
      e.preventDefault();
      e.stopPropagation();
      $(this).closest('.search-form').submit();
    });
  };
</script>