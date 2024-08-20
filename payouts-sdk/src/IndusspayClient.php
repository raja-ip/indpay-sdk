<?php

require_once "./class/DataElements.php";
require_once "./class/PayoutsClient.php";

class IndusspayClient {
    public $payouts;

    public function __construct($clientId, $secretKey, $signatureKey, $baseUrl) {
        DataElements::addKeys($clientId, $secretKey, $signatureKey, $baseUrl);
        $this->payouts = new PayoutsClient();
    }
}

