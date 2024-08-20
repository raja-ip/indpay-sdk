<?php

require_once "../utils/ApiUtils.php";
require_once "../response/CommonResponse.php";
require_once "./IndusspayException.php";
require_once "../utils/utils.php";

class ApiClient {
    public function get($path, $data) {
        $response = ApiUtils::getRequest($path);
        return $this->processResponse($response);
    }

    public function post($path, $data) {
        $response = ApiUtils::postRequest($path, $data);
        return $this->processResponse($response);
    }

    public function put($path, $data) {
        $response = ApiUtils::putRequest($path, $data);
        return $this->processResponse($response);
    }

    public function postAsForm($path, $data) {
        $response = ApiUtils::postAsFormRequest($path, $data);
        return $this->processResponse($response);
    }

    private function processResponse($response) {
        if (!$response || !isset($response->data)) {
            throw new IndusspayException("Invalid Response from the server");
        }

        try {
            return toObject($response->data, 'CommonResponse');
        } catch (Exception $e) {
            throw new IndusspayException($e->getMessage());
        }
    }
}
