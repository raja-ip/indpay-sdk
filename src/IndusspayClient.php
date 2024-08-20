<?php

namespace primeinduss\IndusspayClient;

require_once "./class/DataElements.php";
require_once "./class/CollectsClient.php";
require_once "./class/PayoutsClient.php";

use primeinduss\IndusspayClient\DataElements;
use primeinduss\IndusspayClient\CollectsClient;
use primeinduss\IndusspayClient\PayoutsClient;

class IndusspayClient {
    public $collects;
    public $payouts;

    public function __construct($clientId, $secretKey, $signatureKey, $baseUrl) {
        DataElements::addKeys($clientId, $secretKey, $signatureKey, $baseUrl);
        $this->collects = new CollectsClient();
        $this->payouts = new PayoutsClient();
    }
}

