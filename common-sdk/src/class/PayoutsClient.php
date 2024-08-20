<?php

require_once "./ApiClient.php";
require_once "../types/PathConstants.php";
require_once "../response/CommonResponse.php";

class PayoutsClient {
    private $apiClient;

    public function __construct() {
        $this->apiClient = new ApiClient();
    }

    public function bulkTransfer($data) {
        return $this->apiClient->post(PathConstants::PO_BULK, $data);
    }

    public function singleTransfer($data) {
        return $this->apiClient->post(PathConstants::PO_SINGLE, $data);
    }

    public function addBene($data) {
        return $this->apiClient->post(PathConstants::ADD_BENE, $data);
    }

    public function fetchBeneList($data) {
        return $this->apiClient->post(PathConstants::BENE_LIST, $data);
    }

    public function status($data) {
        return $this->apiClient->post(PathConstants::PO_STATUS, $data);
    }
}