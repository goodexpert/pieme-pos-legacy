<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js"> <!--OFFLINE manifest="cache.manifest" -->
<!--<![endif]-->
<head>
    <?php echo $this->Html->charset(); ?>
    <title>ONZSA | <?php echo $this->fetch('title'); ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
    <link href="/theme/onzsa/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="/theme/onzsa/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="/theme/onzsa/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/theme/onzsa/assets/global/plugins/jquery-ui-themes-1.11.0/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link href="/theme/onzsa/assets/global/css/components.css" rel="stylesheet" type="text/css"/>
    <link href="/theme/onzsa/assets/global/css/plugins.css" rel="stylesheet" type="text/css">
    <link href="/theme/onzsa/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
    <link href="/theme/onzsa/assets/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
    <link href="/theme/onzsa/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
    <link href="/css/register.css" rel="stylesheet" type="text/css"/>
    <link href="/css/custom.keypad.css" rel="stylesheet" type="text/css">
    <link href="/css/dataTable.css" rel="stylesheet" type="text/css">
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="/onzsa.ico"/>
</head>
<body class="page-header-fixed page-quick-sidebar-over-content page-full-width">
    <div id="container">
        <div class="page-header navbar navbar-fixed-top">
            <?php echo $this->element('header'); ?>
        </div>
        <div class="page-container">
            <?php echo $this->fetch('content'); ?>
        </div>
        <!--
        <div class="page-footer">
            <?php echo $this->element('footer'); ?>
        </div>
        -->
    <div>
</body>
<!-- BEGIN SESSION TIMEOUT SCRIPTS -->
<!--
<script src="/theme/onzsa/assets/global/plugins/bootstrap-sessiontimeout/jquery.sessionTimeout.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {    
    // initialize session timeout settings
    $.sessionTimeout({
        title: 'Session Timeout Notification',
        message: 'Your session is about to expire.',
        keepAliveUrl: '/users/ping.json',
        redirUrl: '/users/lock',
        logoutUrl: '/users/logout',
        warnAfter: 240000, //warn after 240 seconds
        redirAfter: 300000, //redirect after 300 seconds
    });
});
</script>
-->
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
</html>
