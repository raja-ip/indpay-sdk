<?php

namespace primeinduss\IndusspayClient;

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

