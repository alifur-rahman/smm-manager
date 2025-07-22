<?php if (!defined('APP_VERSION')) die("Yo, what's up?");  ?>
<!DOCTYPE html>
<html lang="<?= ACTIVE_LANG ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
        <meta name="theme-color" content="#fff">

        <meta name="description" content="<?= site_settings("site_description") ?>">
        <meta name="keywords" content="<?= site_settings("site_keywords") ?>">

        <link rel="icon" href="<?= site_settings("logomark") ? site_settings("logomark") : APPURL."/assets/img/logomark.png" ?>" type="image/x-icon">
        <link rel="shortcut icon" href="<?= site_settings("logomark") ? site_settings("logomark") : APPURL."/assets/img/logomark.png" ?>" type="image/x-icon">
 
        <link rel="stylesheet" type="text/css" href="<?= APPURL."/assets/css/plugins.css?v=".VERSION ?>">
        <link rel="stylesheet" type="text/css" href="<?= APPURL."/assets/css/core.css?v=".VERSION ?>">


        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


        <!-- Include custom CSS file for this module -->
        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="<?= PLUGINS_URL."/smm-manager/assets/css/core.css?v=".VERSION ?>">



        <title><?= __("SMM Manager") ?> <?= isset($_GET['a']) ? ('|| '.$_GET['a']) : ""  ?></title>
        <style>
            .al_expand_alert_wrapper.onprogress::after {
                background: rgba(99, 99, 99, 0.61) url("<?= APPURL ?>/assets/img/round-loading.svg") center no-repeat;
            }
        </style>
    </head>

    <body class="<?= $AuthUser ? ( $AuthUser->get("preferences.dark_mode_status") ? ( $AuthUser->get("preferences.dark_mode_status") == "1" ? "darkside" : "" ) : "" ) : "" ?>">
        <?php 
            $Nav = new stdClass;
            $Nav->activeMenu = "smm-manager";
            require_once(APPPATH.'/views/fragments/navigation.fragment.php');
            ?>

        <?php 
            $TopBar = new stdClass;
            $TopBar->title = __("SMM Manager");
            $TopBar->btn = false;
            require_once(APPPATH.'/views/fragments/topbar.fragment.php'); 
        ?>
        <?php require_once(__DIR__.'/fragments/index.fragment.php'); ?>
        
        <script type="text/javascript" src="<?= APPURL."/assets/js/plugins.js?v=".VERSION ?>"></script>
        <?php require_once(APPPATH.'/inc/js-locale.inc.php'); ?>
        <script type="text/javascript" src="<?= APPURL."/assets/js/core.js?v=".VERSION ?>"></script>

        <!-- Include custom JS file for this module -->
        <script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


        <script type="text/javascript" src="<?= PLUGINS_URL ."/smm-manager/assets/js/core.js?v=3333223".VERSION?>"></script>
        <script type="text/javascript" src="<?= PLUGINS_URL ."/smm-manager/assets/js/dataTable.js?v=340".VERSION?>"></script>


        <script type="text/javascript">
            $(function(){
                SmmDataTable.go('<?= isset($ajaxUrl) ? $ajaxUrl : '' ?>', '<?= rtrim(APPURL, '/') ?>');
            });
        </script>


        <script type="text/javascript" charset="utf-8">
            $(function(){
                SmmManager.defaultAjaxHandler();
                SmmManager.orderActionAjax();
                SmmManager.createOrderAction();
                SmmManager.js_smm_create_order();
            })
        </script>

       
        <!-- GOOGLE ANALYTICS -->
        <?php require_once(APPPATH.'/views/fragments/google-analytics.fragment.php'); ?>
    </body>
</html>