<?php 

namespace primeinduss\IndusspayClient;


use primeinduss\IndusspayClient\Utils;
use primeinduss\IndusspayClient\PathConstants;
use primeinduss\IndusspayClient\IndusspayException;

class ApiUtils extends DataElements {
    private static $interceptor;
    private static $utils;
    private static $auth;
    private static $credentials;

    public function __construct() {
        self::$interceptor = new BodyInterceptor(self::$clientId, self::$secretKey);
        self::$utils = new Utils(self::$signatureKey);
        self::$credentials = new Credentials();
        self::$auth = self::$credentials->createCredentials(self::$clientId, self::$secretKey);
    }

    public static function postRequest($path, $obj) {
        $url = self::getBaseUrl($path);
        $requestContent = self::processBody($obj);
        $request = self::createRequest(Methods::POST, $url, $requestContent);
        return self::processRequest($request);
    }

    public static function getRequest($path) {
        $url = self::getBaseUrl($path);
        $request = self::createRequest(Methods::GET, $url, null);
        return self::processRequest($request);
    }

    public static function putRequest($path, $obj) {
        $url = self::getBaseUrl($path);
        $requestContent = self::processBody($obj);
        $request = self::createRequest(Methods::PUT, $url, $requestContent);
        return self::processRequest($request);
    }

    public static function postAsFormRequest($path, $obj) {
        $url = self::getBaseUrl($path);
        $requestContent = self::processBody($obj);
        $request = self::createRequest(Methods::POST, $url, $requestContent);
        return self::processRequest($request);
    }

    private static function getBaseUrl($path) {
        $url = PathConstants::SCHEME. ".//" . self::$baseUrl . "/" . ltrim($path, '/');
        return $url;
    }

    private static function processBody($req) {
        if(empty(self::$signatureKey)) {
            throw new IndusspayException("Signature key is not set");
        }

        return $req != null ? self::$utils->generateChecksum($req) : "";
    }

    private static function createRequest($method, $url, $requestBody){
        if(empty(self::$clientId) || empty(self::$secretKey)) {
            throw new IndusspayException("Client id or secret key is not set");
        }

        $headers = [
            "Content-Type: " . PathConstants::MEDIA_TYPE_JSON,
            PathConstants::AUTH_HEADER_KEY . ": " . self::$auth,
        ];

        return [
            'method' => $method,
            'url' => $url,
            'data' => $requestBody,
            'headers' => $headers,
        ];
    }

    private static function processRequest($request) {
        $rq = curl_init();

        curl_setopt($rq, CURLOPT_URL, $request['url']);
        curl_setopt($rq, CURLOPT_CUSTOMREQUEST, $request['method']);
        curl_setopt($rq, CURLOPT_RETURNTRANSFER, true);

        if(isset($request['data'])) {
            curl_setopt($rq, CURLOPT_POSTFIELDS, json_encode($request['data']));
        }

        if (isset($config['headers'])) {
            curl_setopt($rq, CURLOPT_HTTPHEADER, $request['headers']);
        }

        // SSL settings
        curl_setopt($rq, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($rq, CURLOPT_SSL_VERIFYHOST, false); 

        // execute request
        $response = curl_exec($rq);

        if(curl_errno($rq)) {
            throw new IndusspayException(curl_error($rq));
        }

        curl_close($rq);

        // Decode JSON response
        $responseData = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
             throw new IndusspayException("Failed to decode JSON response");
        }
 
        return $responseData;
    }
}