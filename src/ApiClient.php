<?php

namespace Primeinduss\Common;

use Exception;
use Primeinduss\Common\ApiUtils;
use Primeinduss\Common\IndusspayException;
use Primeinduss\Common\CommonResponse;
use Primeinduss\Common\Utils;

class ApiClient {
    private static $utils;

    public function __construct() {
        self::$utils = new Utils();
    }

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
            return self::$utils->toObject($response->data, CommonResponse::class);
        } catch (Exception $e) {
            throw new IndusspayException($e->getMessage());
        }
    }
}
