<?php
  $user = $this->Session->read('Auth.User');
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js" data-ng-app="OnzsaApp"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js" data-ng-app="OnzsaApp"> <![endif]-->
<!--[if !IE]><!-->
<!--
<html lang="en" data-ng-app="OnzsaApp" manifest="/cache.appcache">
-->
<html lang="en" data-ng-app="OnzsaApp">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
  <title data-ng-bind="'PieMe | ' + $state.current.data.pageTitle"></title>

  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
  <meta name="description" content=""/>
  <meta name="author" content=""/>

  <!-- BEGIN GLOBAL MANDATORY STYLES -->
  <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet">
  <link href="/theme/metronic/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
  <link href="/theme/metronic/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet"/>
  <link href="/theme/metronic/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="/theme/metronic/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet"/>
  <link href="/theme/metronic/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet"/>
  <link href="/lib/angular-hotkeys/build/hotkeys.min.css" rel="stylesheet"/>
  <link href="/lib/datatables/media/css/jquery.dataTables.min.css" rel="stylesheet">
  <link href="/lib/datatables/vendor/datatables-tabletools/css/dataTables.tableTools.css" rel="stylesheet">
  <link href="/lib/angular-datatables/dist/plugins/bootstrap/datatables.bootstrap.min.css" rel="stylesheet">
  <!-- END GLOBAL MANDATORY STYLES -->

  <!-- BEGIN DYMANICLY LOADED CSS FILES (all plugin and page related styles must be loaded between GLOBAL and THEME css files ) -->
  <link id="ng_load_plugins_before"/>
  <!-- END DYMANICLY LOADED CSS FILES -->

  <!-- BEGIN THEME STYLES -->
  <!-- DOC: To use 'material design' style just load 'components-md.css' stylesheet instead of 'components.css' in the below style tag -->
  <link href="/theme/metronic/assets/global/css/components-md.css" id="style_components" rel="stylesheet"/>
  <link href="/theme/metronic/assets/global/css/plugins-md.css" rel="stylesheet"/>
  <!--
  <link href="/theme/metronic/assets/admin/layout2/css/layout.css" rel="stylesheet"/>
  <link href="/theme/metronic/assets/admin/layout2/css/themes/default.css" rel="stylesheet" id="style_color">
  <link href="/theme/metronic/assets/admin/layout2/css/custom.css" rel="stylesheet"/>
  -->
  <link href="/css/pos.css" rel="stylesheet"/>
  <link href="/css/register-pos.css" rel="stylesheet"/>
  <link href="/app/styles/layout.css" rel="stylesheet"/>
  <link href="/app/styles/register.css" rel="stylesheet"/>
  <!-- link href="/app/styles/themes/yellow.css" rel="stylesheet"/ --> <!-- PIEME: change theme -->
  <link href="/app/styles/themes/green.css" rel="stylesheet"/>
  <link href="/app/styles/custom.css" rel="stylesheet"/>
  <!-- END THEME STYLES -->

  <link rel="shortcut icon" href="/pieme.ico"/>
</head>
<!-- END HEAD -->

  <!-- BEGIN BODY -->
  <body data-ng-controller="AppController" class="page-md page-boxed page-header-fixed page-container-bg-solid ">

    <!-- BEGIN PAGE SPINNER -->
    <!--
    <div ng-spinner-bar class="page-spinner-bar">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
    -->
    <!-- END PAGE SPINNER -->

    <!-- BEGIN HEADER -->
    <!-- <div data-ng-include="'/app/tpl/header.html'" data-ng-controller="HeaderController" class="page-header md-shadow-z-1-i navbar navbar-fixed-top"></div>-->
    <?php echo $this->element('header'); ?>
    <!-- END HEADER -->

    <div class="clearfix"></div>

    <!-- BEGIN CONTAINER -->
    <div class="container">
      <div class="page-container">
        <!-- BEGIN SIDEBAR -->
        <!-- <div data-ng-include="'/app/tpl/sidebar.html'" data-ng-controller="SidebarController" class="page-sidebar-wrapper"> -->
        <?php if ($user['user_type_id'] !== "user_type_cashier") : ?>
          <?php echo $this->element('sidebar'); ?>
        <?php endif; ?>

        <!-- END SIDEBAR -->
        <div class="page-content-wrapper">
          <div class="page-content">
            <!-- BEGIN STYLE CUSTOMIZER(optional) -->
            <!-- END STYLE CUSTOMIZER -->
            <!-- BEGIN ACTUAL CONTENT -->
            <?php echo $this->fetch('content'); ?>
            <!-- END ACTUAL CONTENT -->
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
      <!-- BEGIN FOOTER -->
      <!-- END FOOTER -->
    </div> 
    <!-- END CONTAINER -->



<!-- BEGIN JAVASCRIPTS (Load javascripts at bottom, this will reduce page load time) -->

  <!-- BEGIN APP LEVEL ANGULARJS SCRIPTS -->
  <script src="/app/scripts/app.js"></script>
  <!-- END APP LEVEL ANGULARJS SCRIPTS -->

  <!-- BEGIN PAGE LEVEL SCRIPTS -->
  <script src="/theme/metronic/assets/global/scripts/metronic.js" type="text/javascript"></script>
  <!--
  <script src="/theme/metronic/assets/admin/layout2/scripts/layout.js" type="text/javascript"></script>
  <script src="/theme/metronic/assets/admin/layout2/scripts/demo.js" type="text/javascript"></script>
  -->
  <script src="/app/scripts/modules/layout.js" type="text/javascript"></script>
  <!-- END PAGE LEVEL SCRIPTS -->
    <script>
      /* Init Metronic's core jquery plugins and layout scripts */
      $(document).ready(function () {
        <?php if ($user['user_type_id'] === "user_type_cashier") : ?>
          $('body').addClass('sidebar-force-closed');
        <?php endif; ?>
        Layout.init();
      });
    </script>
<!-- END JAVASCRIPTS -->

    <!-- BEGIN SESSION TIMEOUT SCRIPTS -->
    <script src="/lib/bootstrap-session-timeout/dist/bootstrap-session-timeout.js" type="text/javascript"></script>
<!--    <script type="text/javascript">-->
<!--      $(document).ready(function() {-->
<!--        // initialize session timeout settings-->
<!--        $.sessionTimeout({-->
<!--            title: 'Session Timeout Notification',-->
<!--            message: 'Your session is about to expire.',-->
<!--            keepAliveUrl: '/api/ping.json',-->
<!--            redirUrl: '/users/logout',-->
<!--            logoutUrl: '/users/logout',-->
<!--            warnAfter: 60000, //warn after 60 seconds-->
<!--            redirAfter: 65000, //redirect after 300 secons-->
<!--        });-->
<!--      });-->
<!--    </script>-->
    <!-- END SESSION TIMEOUT SCRIPTS -->

<!-- BEGIN GOOGLE ANALYTICS SCRIPTS -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-62900916-1', 'auto');
  ga('send', 'pageview');
</script>
<!-- END GOOGLE ANALYTICS SCRIPTS -->
</body>
<!-- END BODY -->
</html>
