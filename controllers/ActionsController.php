<?php

namespace Plugins\SmmManagerModule;

class ActionsController extends \Controller
{
    const IDNAME = 'smm-manager';
    public function process()
    {

        $AuthUser = $this->getVariable("AuthUser");
        $EmailSettings = \Controller::model("GeneralData", "email-settings");
        $this->setVariable("idname", self::IDNAME);

        // Auth Checks
        if (!$AuthUser){
            header("Location: " . APPURL . "/login");
            exit;
        } else if (!$AuthUser->isAdmin() && !$AuthUser->isEmailVerified() && $EmailSettings->get("data.email_verification")) {
            header("Location: " . APPURL . "/profile?a=true");
            exit;
        } else if ($AuthUser->isExpired()) {
            header("Location: " . APPURL . "/expired");
            exit;
        }

        $action = \Input::post("action");
        switch ($action) {
            case "check_status":
                header("Content-Type: application/json");
                echo json_encode($this->get_order_status());
                exit;
                break;
            
            case "check_refill_status" :
                header("Content-Type: application/json");
                echo json_encode($this->get_refill_status());
                exit;
                break;
            
            case "create_refill":
                header("Content-Type: application/json");
                echo json_encode($this->create_refill());
                exit;
                break;
            case "cancel_order":
                header("Content-Type: application/json");
                echo json_encode($this->cancel_order());
                exit;
                break;

            case "create_order":
                header("Content-Type: application/json");
                echo json_encode($this->create_order());
                exit;
                break;

           default:
                break;

           
        }
    }

    /**
     * Gets the status of a specific order from the SMM API
     *
     * @return array
     * @throws \Exception
     */
    private function get_order_status()
    {
        require_once PLUGINS_PATH . "/" . self::IDNAME . "/core/providers/CrescitalyApi.php";
    
        $orderId = \Input::post("id");
    
        if (!$orderId) {
            return [
                "result" => 0,
                "message" => "Order ID is missing."
            ];
        }
    
        try {
            $api = new \Plugins\SmmManagerModule\CrescitalyApi();
            $response = $api->status($orderId);
            return [
                "result" => 1,
                "message" => "Current status of the order.",
                "data" => $response
            ];
        } catch (\Exception $e) {
            error_log("SMM API error (get_order_status): " . $e->getMessage());
    
            return [
                "result" => 0,
                "message" => "An unexpected error occurred. Please try again later."
            ];
        }
    }

    /**
     * Gets the status of a specific refill from the SMM API
     *
     * @return array
     * @throws \Exception
     */
    private function get_refill_status()
    {
        require_once PLUGINS_PATH . "/" . self::IDNAME . "/core/providers/CrescitalyApi.php";
    
        $refillId = \Input::post("id");
    
        if (!$refillId) {
            return [
                "result" => 0,
                "message" => "Refill ID is missing."
            ];
        }
    
        try {
            $api = new \Plugins\SmmManagerModule\CrescitalyApi();
            $response = $api->refillStatus($refillId);
            return [
                "result" => 1,
                "message" => "Current status of the refill.",
                "data" => $response
            ];
        } catch (\Exception $e) {
            error_log("SMM API error (get_refill_status): " . $e->getMessage());
    
            return [
                "result" => 0,
                "message" => "An unexpected error occurred. Please try again later."
            ];
        }
    }
    
    /**
     * Creates a new refill for the given order ID.
     *
     * @return array [
     *     "result" => int,
     *     "message" => string,
     *     "data" => object|null
     * ]
     */

    private function create_refill()
    {
        require_once PLUGINS_PATH . "/" . self::IDNAME . "/core/providers/CrescitalyApi.php";
    
        $orderId = \Input::post("id");
    
        if (!$orderId) {
            return [
                "result" => 0,
                "message" => "Order ID is missing."
            ];
        }

        try {
            $api = new \Plugins\SmmManagerModule\CrescitalyApi();
            $response = $api->refill($orderId);
            // $response = (object) ["refill" => rand(10000, 99999)];
            // Ensure response is valid and has a refill ID
            if (!empty($response->refill)) {
                require_once PLUGINS_PATH . "/" . self::IDNAME . "/models/OrderModel.php";
                $order = new SmmOrderModel($orderId);
                $order->select(["order_id" => $orderId]);
               
                require_once PLUGINS_PATH . "/" . self::IDNAME . "/models/RefillModel.php";
                $refillModel = new SmmRefillModel();
                // // Populate refill data from the order
                $refillModel->set("refill_id", $response->refill);
                $refillModel->set("order_id", $orderId);
                $refillModel->set("service_id", $order->get("service_id"));
                $refillModel->set("user_id", $order->get("user_id"));
                $refillModel->set("link", $order->get("link"));
                $refillModel->insert();
        
                return [
                    "result" => 1,
                    "message" => "Refill request created successfully.",
                    "data" => $response
                ];
            } else {
                return [
                    "result" => 1,
                    "message" => "The refill API did not return a valid refill ID.",
                    "data" => $response
                ];
            }
        } catch (\Exception $e) {
            error_log("SMM API error (create_refill): " . $e->getMessage());
        
            return [
                "result" => 0,
                "message" => "An unexpected error occurred. Please try again later."
            ];
        }

    }

    /**
     * Creates a new order based on the provided service ID, service name, user ID, link, account ID, and quantity.
     *
     * @return array
     *     result: 1 on success, 0 on failure
     *     msg: a message describing the result
     *     data: the response from the API on success, an empty object on failure
     */
    private function create_order(){
        require_once PLUGINS_PATH . "/" . self::IDNAME . "/core/providers/CrescitalyApi.php";
    
        $serviceId = \Input::post("service_id");
        $serviceName = \Input::post("service_name");
        $userId = \Input::post("user_id");
        $link = \Input::post("link");
        $accountId = \Input::post("account_id");
        $quantity = \Input::post("quantity");

    
        if (!$serviceId) {
            return [
                "result" => 0,
                "msg" => "Service ID is missing."
            ];
        }

        if (!$serviceName) {
            return [
                "result" => 0,
                "msg" => "Service name is missing."
            ];
        }

        if (!$userId) {
            return [
                "result" => 0,
                "msg" => "Please select an account."
            ];
        }

        if (!$link) {
            return [
                "result" => 0,
                "msg" => "Please select an account."
            ];
        }

        if (!$quantity) {
            return [
                "result" => 0,
                "msg" => "Quantity is missing."
            ];
        }

        try {
            $api = new \Plugins\SmmManagerModule\CrescitalyApi();

            $postData = [
                "service" => $serviceId,
                "link" => $link,
                "quantity" => $quantity
            ];
            $response = $api->order($postData);
            // $response = (object) ["order" => rand(10000, 99999)];

            // Ensure response is valid and has a refill ID
            if (!empty($response->order)) {
                require_once PLUGINS_PATH . "/" . self::IDNAME . "/models/OrderModel.php";
                $order = new SmmOrderModel();

                // // Populate refill data from the order
                $order->set("service_name", $serviceName);
                $order->set("service_id", $serviceId);
                $order->set("order_id", $response->order);
                $order->set("user_id", $userId);
                $order->set("account_id", $userId);
                $order->set("link", $link);
                $order->set("quantity", $quantity);
                $order->set("order_type", 'custom');
                $order->insert();
        
                return [
                    "result" => 1,
                    "msg" => "Order created successfully.",
                    "data" => $response
                ];
            } else {
                return [
                    "result" => 1,
                    "msg" => "Order API did not return a valid service ID.",
                    "data" => $response
                ];
            }
        } catch (\Exception $e) {
            error_log("SMM API error (create_order): " . $e->getMessage());
        
            return [
                "result" => 0,
                "msg" => "An unexpected error occurred. Please try again later."
            ];
        }


    }

    /**
     * Cancels a specific order using the SMM API.
     *
     * @return array [
     *     "result" => int,
     *     "message" => string,
     *     "data" => object|null
     * ]
     * @throws \Exception
     */

    private function cancel_order(){
        require_once PLUGINS_PATH . "/" . self::IDNAME . "/core/providers/CrescitalyApi.php";
    
        $orderId = \Input::post("id");
    
        if (!$orderId) {
            return [
                "result" => 0,
                "message" => "Order ID is missing."
            ];
        }
    
        try {
            $api = new \Plugins\SmmManagerModule\CrescitalyApi();
            $response = $api->cancel([$orderId]);
            return [
                "result" => 1,
                "message" => "Order cancelation.",
                "data" => $response
            ];
        } catch (\Exception $e) {
            error_log("SMM API error (cancel_order): " . $e->getMessage());
    
            return [
                "result" => 0,
                "message" => "An unexpected error occurred. Please try again later."
            ];
        }
    }

    public function smm__create_auto_order($params = [])
    {
        require_once PLUGINS_PATH . "/" . self::IDNAME . "/core/providers/CrescitalyApi.php";
        require_once PLUGINS_PATH . "/" . self::IDNAME . "/models/OrderModel.php";
        require_once PLUGINS_PATH . "/" . self::IDNAME . "/models/SettingModel.php";

        $Settings = new SettingModel();
        $autoCreateOrder = $Settings->get("auto_order");

        if (!$autoCreateOrder) {
            error_log("SMM API error (auto_create_order): Auto order is disabled.");
            return [
                "result" => 0,
                "msg" => "Auto order is disabled."
            ];
        }

        $defaultService = $Settings->get("default_service");

        if (!$defaultService) {
            error_log("SMM API error (auto_create_order): Default service is not set.");
            return [
                "result" => 0,
                "msg" => "Default service is not set."
            ];
        }
        $defaultService = json_decode($defaultService, true);
        $defaultQuantity = $Settings->get("default_quantity");

        if (!$defaultQuantity) {
            error_log("SMM API error (auto_create_order): Default quantity is not set.");
            return [
                "result" => 0,
                "msg" => "Default quantity is not set."
            ];
        }

        $serviceId = $defaultService["service"];
        $serviceName = $defaultService["name"];
        $quantity = $defaultQuantity;


        $userId = $params["user_id"] ?? null;
        $username = $params["username"] ?? null;
        $accountId = $params["account_id"] ?? null;


        if (!$serviceId || !$serviceName || !$userId || !$username || !$quantity) {
            error_log("SMM API error (auto_create_order): Missing required parameters.");
            return [
                "result" => 0,
                "msg" => "Missing required parameters."
            ];
        }
        $link = 'https://www.instagram.com/' . $username;

        try {
            $api = new \Plugins\SmmManagerModule\CrescitalyApi();
            $postData = [
                "service" => $serviceId,
                "link" => $link,
                "quantity" => $quantity
            ];

            $response = $api->order($postData);
            // $response = (object) ["order" => rand(10000, 99999)]; // Fake fallback

            if (!empty($response->order)) {
                $order = new SmmOrderModel();
                $order->set("service_name", $serviceName);
                $order->set("service_id", $serviceId);
                $order->set("order_id", $response->order);
                $order->set("user_id", $userId);
                $order->set("account_id", $accountId ?? $userId);
                $order->set("link", $link);
                $order->set("quantity", $quantity);
                $order->set("order_type", 'auto');
                $order->insert();
                error_log("SMM API error (auto_create_order): Order created successfully.");
                return [
                    "result" => 1,
                    "msg" => "Automatic order created successfully.",
                    "data" => $response
                ];
            } else {
                error_log("SMM API error (auto_create_order): Failed to get a valid order ID from API.");
                return [
                    "result" => 0,
                    "msg" => "Failed to get a valid order ID from API.",
                    "data" => $response
                ];
            }
        } catch (\Exception $e) {
            error_log("SMM API error (auto_create_order): " . $e->getMessage());
            return [
                "result" => 0,
                "msg" => "Unexpected error occurred while auto-creating order.",
            ];
        }
    }

}
