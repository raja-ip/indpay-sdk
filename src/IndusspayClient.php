<?php

namespace Primeinduss\Common;

use Primeinduss\Common\DataElements;
use Primeinduss\Common\CollectsClient;
use Primeinduss\Common\PayoutsClient;

class IndusspayClient {
    public $collects;
    public $payouts;

    public function __construct($clientId, $secretKey, $signatureKey, $baseUrl) {
        DataElements::addKeys($clientId, $secretKey, $signatureKey, $baseUrl);
        $this->collects = new CollectsClient();
        $this->payouts = new PayoutsClient();
    }
}

