<?php 

namespace Plugins\SmmManagerModule;

require_once __DIR__ . '/../SmmApiInterface.php'; 

class CrescitalyApi implements \Plugins\SmmManagerModule\SmmApiInterface
{
    private $apiUrl;
    private $apiKey;
    const IDNAME = 'smm-manager';

    public function __construct()
    {
        require_once PLUGINS_PATH . "/" . self::IDNAME . "/models/SettingModel.php";
        $Settings = new SettingModel();

        if($Settings->isAvailable()) {
            $this->setCredentials($Settings->get("api_url"), $Settings->get("api_key"));
        }
    }


    public function setCredentials(string $apiUrl, string $apiKey)
    {
        $this->apiUrl = $apiUrl;
        $this->apiKey = $apiKey;
    }

    public function order(array $data)
    {
        return $this->request(array_merge(['action' => 'add'], $data));
    }

    public function status($orderId)
    {
        return $this->request(['action' => 'status', 'order' => $orderId]);
    }

    public function multiStatus(array $orderIds)
    {
        return $this->request(['action' => 'status', 'orders' => implode(",", $orderIds)]);
    }

    public function services()
    {
        return $this->request(['action' => 'services']);
    }
    public function balance()
    {
        return $this->request(['action' => 'balance']);
    }

    public function refill(int $orderId)
    {
        return $this->request(['action' => 'refill', 'order' => $orderId]);
    }

    public function multiRefill(array $orderIds)
    {
        return $this->request(['action' => 'refill', 'orders' => implode(",", $orderIds)]);
    }

    public function refillStatus(int $refillId)
    {
        return $this->request(['action' => 'refill_status', 'refill' => $refillId]);
    }

    public function multiRefillStatus(array $refillIds)
    {
        return $this->request(['action' => 'refill_status', 'refills' => implode(",", $refillIds)]);
    }

    public function cancel(array $orderIds)
    {
        return $this->request(['action' => 'cancel', 'orders' => implode(",", $orderIds)]);
    }

    private function request(array $params)
    {
        $params['key'] = $this->apiKey;

        $ch = curl_init($this->apiUrl);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_USERAGENT => 'Mozilla/5.0'
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response);
    }
}
