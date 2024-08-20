<?php

require_once 'Credentials.php';

class BodyInterceptor {
    private $auth;

    public function __construct($clientId, $secretKey) {
        $this->auth = createCredentials($clientId, $secretKey);
    }

    public function intercept($url, $options = []) {
        if (!isset($options['headers'])) {
            $options['headers'] = [];
        }
        $options['headers']['Authorization'] = $this->auth;

        return [$url, $options];
    }

    public function interceptResponse($response) {
        if (isset($response['headers']['entity'])) {
            $response['headers']['Entity'] = $response['headers']['entity'];
        }
        return $response;
    }
}