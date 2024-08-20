<?php

class DataElements {
    public static $clientId;
    public static $secretKey;
    public static $signatureKey;
    public static $baseUrl;

    public static function addKeys($clientId, $secretKey, $signatureKey, $baseUrl) {
        self::$clientId = $clientId;
        self::$secretKey = $secretKey;
        self::$signatureKey = $signatureKey;
        self::$baseUrl = $baseUrl;
    }
}
