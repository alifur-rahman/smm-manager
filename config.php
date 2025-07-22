<?php 

if (!defined('APP_VERSION')) die("Yo, what's up?"); 


// Return the config array
return [
    "idname" => "smm-manager",
    "plugin_name" => "SMM Manager",
    "author" => "KodeX Srl",
    "author_uri" => "mailto:kodex@pec.it",
    "version" => "1.0.0",
    "desc" => "A integration tool that connects your platform with external SMM panel APIs, allowing you to automate the delivery of social media services, manage user accounts, track order statuses, and streamline overall service operations directly from your admin interface.",
    "icon_style" => "font-size: 18px;",
    "settings_page_uri" => APPURL . "/e/smm-manager/settings",
    
];
    