<?php



namespace Plugins\SmmManagerModule;

interface SmmApiInterface
{
    public function setCredentials(string $apiUrl, string $apiKey);
    public function order(array $data);
    public function status($orderId);
    public function multiStatus(array $orderIds);
    public function services();
    public function balance();
    public function refill(int $orderId);
    public function multiRefill(array $orderIds);
    public function refillStatus(int $refillId);
    public function multiRefillStatus(array $refillIds);
    public function cancel(array $orderIds);
}
