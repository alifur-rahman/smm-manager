<?php 
// Defining a name space is not required,
// But it's a good practise.
namespace Plugins\SmmManagerModule;
const IDNAME = "smm-manager";
// Disable direct access
if (!defined('APP_VERSION')) 
    die("Yo, what's up?"); 



    function install($Plugin)
    {
        $pdo = \DB::pdo();
          // Create table for plugin settings
        $sql1 = "CREATE TABLE IF NOT EXISTS `".TABLE_PREFIX."smm_settings` (
            `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `api_url` TEXT NOT NULL,
            `api_key` TEXT NOT NULL,
            `status` TINYINT(1) NOT NULL DEFAULT 1,
            `default_service` TEXT DEFAULT NULL,
            `default_quantity` INT DEFAULT NULL,
            `auto_order` TINYINT(1) NOT NULL DEFAULT 0,
            `expairy_day_before` INT NOT NULL DEFAULT 0,
            `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
            `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

        $stmt1 = $pdo->prepare($sql1);
        $stmt1->execute();
        $stmt1->closeCursor();

        // Create table for SMM orders
        $sql2 = "CREATE TABLE IF NOT EXISTS `".TABLE_PREFIX."smm_orders` (
                `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `service_name` VARCHAR(255) NOT NULL,
                `service_id` INT NOT NULL,
                `order_id` INT NOT NULL,
                `user_id` INT NOT NULL,
                `account_id` INT NOT NULL,
                `link` VARCHAR(255) NOT NULL,
                `quantity` INT DEFAULT NULL,
                `runs` VARCHAR(100) DEFAULT NULL,
                `interval` VARCHAR(100) DEFAULT NULL,
                `order_type` VARCHAR(100) NOT NULL,
                `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

        $stmt2 = $pdo->prepare($sql2);
        $stmt2->execute();
        $stmt2->closeCursor();

        // Create table for SMM refill requests
        $sql3 = "CREATE TABLE IF NOT EXISTS `".TABLE_PREFIX."smm_refill_requests` (
        `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `refill_id` INT NOT NULL,
        `order_id` INT NOT NULL,
        `service_id` INT NOT NULL,
        `user_id` INT NOT NULL,
        `link` TEXT NOT NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

        $stmt3 = $pdo->prepare($sql3);
        $stmt3->execute();
        $stmt3->closeCursor();

    
        return true;
    }
    

// Bind the install function to plugin installation event
\Event::bind("plugin.install", __NAMESPACE__ . '\install');


function activate($Plugin)
{
    $pdo = \DB::pdo();
    
    // Create table for plugin settings
    $sql1 = "CREATE TABLE IF NOT EXISTS `".TABLE_PREFIX."smm_settings` (
                `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `api_url` TEXT NOT NULL,
                `api_key` TEXT NOT NULL,
                `status` TINYINT(1) NOT NULL DEFAULT 1,
                `default_service` TEXT DEFAULT NULL,
                `default_quantity` INT DEFAULT NULL,
                `auto_order` TINYINT(1) NOT NULL DEFAULT 0,
                `expairy_day_before` INT NOT NULL DEFAULT 0,
                `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    $stmt1 = $pdo->prepare($sql1);
    $stmt1->execute();
    $stmt1->closeCursor();

    // Create table for SMM orders
    $sql2 = "CREATE TABLE IF NOT EXISTS `".TABLE_PREFIX."smm_orders` (
                `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                `service_name` VARCHAR(255) NOT NULL,
                `service_id` INT NOT NULL,
                `order_id` INT NOT NULL,
                `user_id` INT NOT NULL,
                `account_id` INT NOT NULL,
                `link` VARCHAR(255) NOT NULL,
                `quantity` INT DEFAULT NULL,
                `runs` VARCHAR(100) DEFAULT NULL,
                `interval` VARCHAR(100) DEFAULT NULL,
                `order_type` VARCHAR(100) NOT NULL,
                `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute();
    $stmt2->closeCursor();

    // Create table for SMM refill requests
    $sql3 = "CREATE TABLE IF NOT EXISTS `".TABLE_PREFIX."smm_refill_requests` (
        `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `refill_id` INT NOT NULL,
        `order_id` INT NOT NULL,
        `service_id` INT NOT NULL,
        `user_id` INT NOT NULL,
        `link` TEXT NOT NULL,
        `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
        `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    $stmt3 = $pdo->prepare($sql3);
    $stmt3->execute();
    $stmt3->closeCursor();


    return true;
}
// Bind the install function to plugin activation event
\Event::bind("plugin.activate", __NAMESPACE__ . '\activate');
    


function uninstall($Plugin)
{
    $sql = "DROP TABLE IF EXISTS `".TABLE_PREFIX."smm_settings`;";

    $pdo = \DB::pdo();
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $stmt->closeCursor();
	return true;
}
\Event::bind("plugin.remove", __NAMESPACE__ . '\uninstall');


function add_module_option($package_modules)
{
    ?>
        <div class="mt-15">
            <label>
                <input type="checkbox" 
                       class="checkbox" 
                       name="modules[]" <?php // input name must be modules[] ?>
                       value="management"
                       <?= in_array("smm-manager", $package_modules) ? "checked" : "" ?>>
                <span>
                    <span class="icon unchecked">
                        <span class="mdi mdi-check"></span>
                    </span>
                    <?= __('SMM Manager') ?>
                </span>
            </label>
        </div>
    <?php
}
\Event::bind("package.add_module_option", __NAMESPACE__ . '\add_module_option');




function route_maps($global_variable_name)
{
    $GLOBALS[$global_variable_name]->map("GET|POST", "/e/smm-manager/?", [
        PLUGINS_PATH . "/smm-manager/controllers/IndexController.php",
        __NAMESPACE__ . "\IndexController"
    ]);
    $GLOBALS[$global_variable_name]->map("GET|POST", "/e/smm-manager/settings?", [
        PLUGINS_PATH . "/smm-manager/controllers/SettingsController.php",
        __NAMESPACE__ . "\SettingsController"
    ]);

    $GLOBALS[$global_variable_name]->map("GET|POST", "/e/smm-manager/actions?", [
        PLUGINS_PATH . "/smm-manager/controllers/ActionsController.php",
        __NAMESPACE__ . "\ActionsController"
    ]);
    $GLOBALS[$global_variable_name]->map("GET|POST", "/e/smm-manager/search?", [
        PLUGINS_PATH . "/smm-manager/controllers/SearchController.php",
        __NAMESPACE__ . "\SearchController"
    ]);

}
\Event::bind("router.map", __NAMESPACE__ . '\route_maps');


function navigation($Nav, $AuthUser)
{
    $idname = IDNAME;
    include __DIR__."/views/fragments/navigation.fragment.php";
}
\Event::bind("navigation.add_menu", __NAMESPACE__ . '\navigation');