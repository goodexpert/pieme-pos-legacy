<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" >
<!--<![endif]-->
<head>
    <?php echo $this->Html->charset(); ?>
    <title>PieMe | <?php echo $this->fetch('title'); ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
    <link href="/theme/onzsa/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="/theme/onzsa/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="/theme/onzsa/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/theme/onzsa/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <link href="/theme/onzsa/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="/theme/onzsa/assets/admin/pages/css/lock.css" rel="stylesheet" type="text/css"/>
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link href="/theme/onzsa/assets/global/css/components.css" rel="stylesheet" type="text/css"/>
    <link href="/theme/onzsa/assets/global/css/plugins.css" rel="stylesheet" type="text/css"/>
    <link href="/theme/onzsa/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
    <link href="/theme/onzsa/assets/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
    <link href="/theme/onzsa/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="/pieme.ico"/>
</head>
<body class="page-header-fixed page-quick-sidebar-over-content page-full-width">
    <div class="page-lock"> 
        <div class="page-logo">
            <a class="brand" href="http://www.pieme.co.nz/">
                <img src="/img/pieme_logo.png" alt="logo" class="logo-default"/>
            </a>
        </div>
        <div class="page-body">
            <?php echo $this->fetch('content'); ?>
        </div>
        <div class="page-footer-custom">
            2017 &copy; PieMe Limited
        </div>
    </div>
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
-->
</script>
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
