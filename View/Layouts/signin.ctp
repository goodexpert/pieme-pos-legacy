<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" >
<!--<![endif]-->
<head>
    <?php echo $this->Html->charset(); ?>
    <title>ONZSA | <?php echo $this->fetch('title'); ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
    <link href="/theme/onzsa/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="/theme/onzsa/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="/theme/onzsa/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="/theme/onzsa/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <link href="/theme/onzsa/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
    <link href="/theme/onzsa/assets/global/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" type="text/css"/>
    <link href="/theme/onzsa/assets/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css"/>
    <link href="/theme/onzsa/assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css"/>
    <link href="/theme/onzsa/assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css"/>
    <!-- END PAGE LEVEL PLUGIN STYLES -->
    <!-- BEGIN PAGE STYLES -->
    <link href="/theme/onzsa/assets/admin/pages/css/tasks.css" rel="stylesheet" type="text/css"/>
    <!-- END PAGE STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link href="/theme/onzsa/assets/global/css/components.css" rel="stylesheet" type="text/css"/>
    <link href="/theme/onzsa/assets/global/css/plugins.css" rel="stylesheet" type="text/css">
    <link href="/theme/onzsa/assets/admin/layout/css/layout.css" rel="stylesheet" type="text/css"/>
    <link href="/theme/onzsa/assets/admin/layout/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
    <link href="/theme/onzsa/assets/admin/layout/css/custom.css" rel="stylesheet" type="text/css"/>
    <link href="/css/pos.css" rel="stylesheet" type="text/css"/>
    <link href="/css/custom.keypad.css" rel="stylesheet" type="text/css">
    <!-- END THEME STYLES -->
    <link rel="shortcut icon" href="/onzsa.ico"/>
</head>
<body class="page-header-fixed page-quick-sidebar-over-content page-full-width">
    <div id="container">
        <div id="header">
            <div class="page-header navbar navbar-fixed-top">
                <div class="page-header-inner container">
                    <div class="page-logo">
                        <a href="http://www.onzsa.com">
                            <img src="/img/ONZSA_logo-05.png" alt="logo" class="logo-default"/>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div id="content">
            <?php echo $this->fetch('content'); ?>
        </div>
        <div id="footer">
            <div class="page-footer">
                <div class="page-footer-inner">
                    2015 © Onzsa Limited
                </div>
            </div>
        </div>
    </div>
</body>
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
