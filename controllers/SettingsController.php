<?php

namespace Plugins\SmmManagerModule;

// Disable direct access
if (!defined('APP_VERSION'))
    die("Yo, what's up?");

/**
 * Settings Controller
 */
class SettingsController extends \Controller
{
    const IDNAME = 'smm-manager';

    /**
     * Process
     */
    public function process()
    { 


        $AuthUser = $this->getVariable("AuthUser");
        $EmailSettings = \Controller::model("GeneralData", "email-settings");
        $this->setVariable("idname", self::IDNAME);

        // Auth
        if (!$AuthUser){
            header("Location: ".APPURL."/login");
            exit;
        } else if (!$AuthUser->isAdmin() && !$AuthUser->isEmailVerified() && $EmailSettings->get("data.email_verification")) {
            header("Location: ".APPURL."/profile?a=true");
            exit;
        } else if ($AuthUser->isExpired()) {
            header("Location: ".APPURL."/expired");
            exit;
        }

        require_once PLUGINS_PATH . "/" . self::IDNAME . "/models/SettingModel.php";
        $Settings = new SettingModel();

  
    
        // Set as a view variable (optional)
        $this->setVariable("SmmSettings", $Settings);
    

        	// Actions
		if (\Input::post("action") == "save") {
			$this->save();
		} 

        if (\Input::post("action") == "set_default_service") {
            $this->set_default_service();
		} 



        
        $this->view(PLUGINS_PATH."/".self::IDNAME."/views/settings.php", null);


    }

    /**
     * Save plugin settings
     * @return boolean 
     */
    private function save()
    {  
        $AuthUser = $this->getVariable("AuthUser");
        $Settings = $this->getVariable("SmmSettings");

        if (!$AuthUser || !$AuthUser->isAdmin()) {
            $this->resp->result = 0;
            $this->resp->msg = __("You do not have permission to perform this action.");
            $this->resp->redirect = null;
            return $this->jsonecho();
        }

        try {
            if (!$Settings->isAvailable()) {
                // Settings not available yet, create default settings key
                $Settings->set("name", "plugin-" . self::IDNAME . "-settings");
            }

            // Save submitted plugin settings
            $Settings->set("api_key", \Input::post("api_key"))
                    ->set("api_url", \Input::post("api_url"))
                    ->set("auto_order", \Input::post("auto_order") ? 1 : 0) 
                    ->set("default_quantity", \Input::post("default_quantity"))
                    ->save();

            $this->resp->result = 1;
            $this->resp->msg = __("Settings have been successfully saved.");
            $this->resp->redirect = null;
            return $this->jsonecho();

        } catch (\Exception $e) {
            // Handle any error during saving
            $this->resp->result = 0;
            $this->resp->msg = __("Failed to save settings") . ": " . $e->getMessage();
            $this->resp->redirect = null;
            return $this->jsonecho();
        }
    }

    private function set_default_service()
    {
        $AuthUser = $this->getVariable("AuthUser");
    
        if (!$AuthUser || !$AuthUser->isAdmin()) {
            echo json_encode([
                "result" => 0,
                "message" => "Unauthorized access."
            ]);
            exit;
        }
    
        $postData = \Input::post("data");
    
        // Decode the JSON string into an array
        if (is_string($postData)) {
            $postData = json_decode($postData, true);
        }
    
        // Validate data
        if (!is_array($postData) || !isset($postData["service"])) {
            echo json_encode([
                "result" => 0,
                "message" => "Invalid or missing service data."
            ]);
            exit;
        }

    
    
        // Load Setting model
        require_once PLUGINS_PATH . "/" . self::IDNAME . "/models/SettingModel.php";
        $Settings = new \Plugins\SmmManagerModule\SettingModel();
        

        if($postData["service"] !== $Settings->get("default_service.service")) {
            $Settings->set("default_quantity",null);
         
            $redirect = APPURL . "/e/" . self::IDNAME . "/settings?msg=default_service_updated";
        }
    
        // Save as JSON string in `default_service`
        $Settings->set("default_service", json_encode($postData))->save();
    
        echo json_encode([
            "result" => 1,
            "message" => "Default service updated successfully.",
            "redirect" => $redirect ? $redirect : null
        ]);
        exit;
    }
    

}