<?php

require_once "./class/DataElements.php";
require_once "./class/CollectsClient.php";

class IndusspayClient {
    public $collects;

    public function __construct($clientId, $secretKey, $signatureKey, $baseUrl) {
        DataElements::addKeys($clientId, $secretKey, $signatureKey, $baseUrl);
        $this->collects = new CollectsClient();
    }
}

