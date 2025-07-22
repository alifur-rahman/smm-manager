<?php 
    // Disable direct access
    if (!defined('APP_VERSION')) die("Yo, what's up?"); 
?>
<style>
    .al_tableWidth{
        width: 200px;
    }

    @media screen and (min-width: 991px) {
        .active-managemet-class {
            max-width: 90%;
            margin-left: 200px;
        }
        .active-managemet-class .skeleton-content {
            float: left;
        }
    }
    @media screen and (max-width: 767px) {
        .al_tableWidth{
            width: 100%;
        }
       
    }
</style>

<div class="skeleton skeleton--full active-managemet-class" id="audit">
    <div class="clearfix mt-30">
        <?php require_once(__DIR__.'/includes/aside-nav.fragment.php'); ?>

        <section class="skeleton-content" style="border-top-left-radius: 0; box-shadow: none;">
            <div style="width: 96%; margin: 2%">
                <?php
                if($action == 'services')
                    require_once(PLUGINS_PATH."/".$this->getVariable("idname")."/views/fragments/includes/services.fragment.php");
                else if($action == 'orders')
                    require_once(PLUGINS_PATH."/".$this->getVariable("idname")."/views/fragments/includes/orders.fragment.php");
                else if($action == 'refills-history')
                    require_once(PLUGINS_PATH."/".$this->getVariable("idname")."/views/fragments/includes/refills-history.fragment.php");
                ?>
            </div>
        </section>

    </div>
</div>