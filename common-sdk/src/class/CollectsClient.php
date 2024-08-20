<?php

require_once "./ApiClient.php";
require_once "../types/PathConstants.php";
require_once "../response/CommonResponse.php";

class CollectsClient {
    private $apiClient;

    public function __construct() {
        $this->apiClient = new ApiClient();
    }

    public function verifyVpa($data) {
        return $this->apiClient->post(PathConstants::VPA_VERIFY, $data);
    }

    public function raiseCollect($data) {
        return $this->apiClient->post(PathConstants::RAISE_COLLECT, $data);
    }

    public function collectStatus($data) {
        return $this->apiClient->post(PathConstants::COLLECT_STATUS, $data);
    }

    public function qrDynamic($data) {
        return $this->apiClient->post(PathConstants::QR_DYNAMIC, $data);
    }

    public function qrStatic($data) {
        return $this->apiClient->post(PathConstants::QR_STATIC, $data);
    }

    public function qrStatus($data) {
        return $this->apiClient->post(PathConstants::QR_STATUS, $data);
    }

    public function rrnStatus($data) {
        return $this->apiClient->post(PathConstants::RRN_STATUS, $data);
    }

    public function intent($data) {
        return $this->apiClient->post(PathConstants::INTENT, $data);
    }

    public function createOrder($data) {
        return $this->apiClient->postAsForm(PathConstants::CREATE_ORDER, $data);
    }
}