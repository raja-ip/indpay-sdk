<?php

namespace Primeinduss\Common;


class Obj {
    public string $clientTxnId;

    public function __construct(string $clientTxnId) {
        $this->clientTxnId = $clientTxnId;
    }
}