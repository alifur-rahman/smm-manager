<?php

namespace Plugins\SmmManagerModule;

// Disable direct access
if (!defined('APP_VERSION'))
    die("Yo, what's up?");

/**
 * Index Controller
 */
class IndexController extends \Controller
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
        $this->setVariable("baseUrl", APPURL . "/e/" . $this->getVariable('idname'));
        $action = \Input::get("a");
        $action = $action ? $action : 'services';
        $this->setVariable('action', $action);
        $this->setVariable('ajaxUrl', $this->getVariable('baseUrl') . "?a=" . $action."Ajax");
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

        require_once PLUGINS_PATH . "/" . self::IDNAME . "/core/providers/CrescitalyApi.php";
        $services = [];
        try {
            $api = new \Plugins\SmmManagerModule\CrescitalyApi();
            $balance = $api->balance();
          
        } catch (\Exception $e) {
            error_log("SMM API error: " . $e->getMessage());
        }

        $this->setVariable("balance", $balance);
 
        

        //define action
        switch ($action) {
            case 'servicesAjax':
                header('Content-Type: application/json');
                echo json_encode($this->getServices());
                exit;
                break;
            case 'ordersAjax':
                header('Content-Type: application/json');
                echo json_encode($this->getOrders());
                exit;
                break;
            case "refills-historyAjax":
                header('Content-Type: application/json');
                echo json_encode($this->getRefillsHistory());
                exit;
                break;
        }


        $this->view(PLUGINS_PATH."/".self::IDNAME."/views/index.php", null);
    }

    protected function getServices($ajaxData = false) {

     
        require_once PLUGINS_PATH . "/" . self::IDNAME . "/core/providers/CrescitalyApi.php";
    
        $services = [];
        try {
            $api = new \Plugins\SmmManagerModule\CrescitalyApi();
            $response = $api->services();

            if (is_array($response) || is_object($response)) {
                $services = is_array($response) ? $response : (array)$response;
            }
        } catch (\Exception $e) {
            error_log("SMM API error: " . $e->getMessage());
        }
    
        // Optional: Filter by search term
        if (!empty($search)) {
            $services = array_filter($services, function ($service) use ($search) {
                return stripos($service->name, $search) !== false ||
                       stripos($service->category, $search) !== false;
            });
        }
    
        $total = count($services);
        // $services = array_slice($services, $offset, $limit);

     
    
        // Format rows for DataTables
        $data = [];
        foreach ($services as $s) {
            $actionBtns = "<a href='javascript:void(0)' data-all='" . json_encode($s) . "' class='al_expand_button al_js_expand'><i class='mdi mdi-arrow-expand-all'></i></a>";
            $data[] = [
                htmlspecialchars($s->service),
                htmlspecialchars($s->category),
                htmlspecialchars($s->name),
                htmlspecialchars($s->type),
                "$" . number_format($s->rate, 2),
                $s->min,
                $s->max,
                // $s->refill ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-info">No</span>',
                // $s->cancel ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-info">No</span>',
               $actionBtns
            ];
        }
    
        return [
            'data' => $data
        ];
    }
    

    
    protected function getOrders($ajaxData = false)
    {
        require_once PLUGINS_PATH . "/" . self::IDNAME . "/models/OrdersModel.php";
    
        $ordersModel = new SmmOrdersModel();
        $orders = $ordersModel->fetchData()->getData();

        $data = [];
    
        foreach ($orders as $o) {

            $User = \Controller::model("User", $o->user_id);
            if($User->isAvailable()){
                $UserEmail = $User->get("email");
            }else{
                $UserEmail = 'Not Found';
            }
      

            $popupData = (array) $o;
            unset($popupData['status'], $popupData['updated_at'], $popupData['user_id']);
            $popupData['user_email'] = $UserEmail;
        
            // Encode only the filtered popup data
            $orderBtn = "<a href='javascript:void(0)' data-all='" 
            . htmlspecialchars(json_encode($popupData), ENT_QUOTES) 
            . "' class=' al_js_expand'>" . $o->order_id . "</a>";
          
            $serviceIDBtn = "<a href='" . APPURL . "/e/smm-manager?a=services&tbsearch=" . $o->service_id . "' target='_blank' >" . $o->service_id . "</a>";
            $servicesBtn = "<a href='" . APPURL . "/e/smm-manager?a=services&tbsearch=" . $o->service_name . "' target='_blank' >" . $o->service_name . "</a>";
            $userBtn = "<a href='" . APPURL . "/e/management?a=users&tbsearch=" . $UserEmail . "' target='_blank' >" . $UserEmail . "</a>";
            $linkBtn = "<a titile='see on instagram' href='https://www.instagram.com/" . $o->link . "' target='_blank' > ".$o->link."</a>";
            $actionBtns = "<a href='javascript:void(0)' data-all='" 
            . htmlspecialchars(json_encode($popupData), ENT_QUOTES) 
            . "' class='al_expand_button al_js_expand'><i class='mdi mdi-arrow-expand-all'></i></a>";
    
            $data[] = [
                $orderBtn,
                $serviceIDBtn,
                $servicesBtn,
                $userBtn,
                $linkBtn,
                $o->quantit,
                $actionBtns
            ];
        }
    
        return [
            "data" => $data
        ];
    }

    protected function getRefillsHistory() {
        require_once PLUGINS_PATH . "/" . self::IDNAME . "/models/RefillsModel.php";
    
        $refillsModel = new SmmRefillsModel();
        $refills_history = $refillsModel->fetchData()->getData();

        $data = [];
    
        foreach ($refills_history as $o) {

            $User = \Controller::model("User", $o->user_id);
            if($User->isAvailable()){
                $UserEmail = $User->get("email");
            }else{
                $UserEmail = 'Not Found';
            }
      

            $popupData = (array) $o;
            unset($popupData['updated_at'], $popupData['user_id']);
            $popupData['user_email'] = $UserEmail;
        
            // Encode only the filtered popup data
            $refillBtn = "<a href='javascript:void(0)' data-all='" 
            . htmlspecialchars(json_encode($popupData), ENT_QUOTES) 
            . "' class=' al_js_expand'>" . $o->refill_id . "</a>";
          
            $orderIDBtn = "<a href='" . APPURL . "/e/smm-manager?a=orders&tbsearch=" . $o->order_id . "' target='_blank' >" . $o->order_id . "</a>";

            $servicesBtn = "<a href='" . APPURL . "/e/smm-manager?a=services&tbsearch=" . $o->service_id . "' target='_blank' >" . $o->service_id . "</a>";
            
            $userBtn = "<a href='" . APPURL . "/e/management?a=users&tbsearch=" . $UserEmail . "' target='_blank' >" . $UserEmail . "</a>";

            $LinkBtn = "<a titile='see on instagram' href='https://www.instagram.com/" . $o->link . "' target='_blank' >".$o->link."</a>";

            $actionBtns = "<a href='javascript:void(0)' data-all='" 
            . htmlspecialchars(json_encode($popupData), ENT_QUOTES) 
            . "' class='al_expand_button al_js_expand'><i class='mdi mdi-arrow-expand-all'></i></a>";
    
            $data[] = [
                $refillBtn,
                $orderIDBtn,
                $servicesBtn,
                $userBtn,
                $LinkBtn,
                $actionBtns
            ];
        }
    
        return [
            "data" => $data
        ];
    }
    
    
    

}