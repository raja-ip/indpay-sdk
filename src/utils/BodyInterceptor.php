<?php

namespace primeinduss\IndusspayClient;

use primeinduss\IndusspayClient\Credentials;

class BodyInterceptor {
    private static $auth;
    private static $credentials;

    public function __construct($clientId, $secretKey) {
        self::$credentials = new Credentials();
        self::$auth = self::$credentials->createCredentials($clientId, $secretKey);
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