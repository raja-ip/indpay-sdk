<?php

use Defuse\Crypto\Crypto;
use Defuse\Crypto\Exception\CryptoException;
use Defuse\Crypto\Key;

require_once 'vendor/autoload.php'; 

function toObject($jsonData, $type) {
    if ($jsonData === null || $type === null) {
        throw new InvalidArgumentException("Input parameters cannot be null or undefined");
    }

    try {
        $parsedData = json_decode($jsonData, true);
        $instance = new $type();
        foreach ($parsedData as $key => $value) {
            if (property_exists($instance, $key)) {
                $instance->$key = $value;
            }
        }
        return $instance;
    } catch (Exception $error) {
        throw new Exception("Failed to parse JSON: " . $error->getMessage());
    }
}

function encryptCheckSum($data, $key) {
    try {
        $decodedKey = base64_decode($key);
        if ($decodedKey === false) {
            throw new Exception("Invalid base64-encoded key");
        }
        $key = Key::loadFromAsciiSafeString($decodedKey);

        $encrypted = Crypto::encrypt($data, $key);
        return base64_encode($encrypted);
    } catch (CryptoException $error) {
        throw new IndusspayException($error->getMessage());
    }
}

function generateChecksum($obj, $signatureKey) {
    $json = null;
    try {
        $json = json_encode($obj);
    } catch (Exception $e) {
        $json = serializeWithCustomHandling($obj);
    }

    $data = generateChecksumFromJson($json);
    $signature = encryptCheckSum("{$data}|{$signatureKey}", $signatureKey);

    $jsonObject = null;
    try {
        $jsonObject = json_decode($json, true);
        $jsonObject['signature'] = $signature;
    } catch (Exception $e) {
        throw new IndusspayException($e->getMessage());
    }
    return json_encode($jsonObject);
}

function generateChecksumFromJson($json) {
    try {
        $sb = [];
        $isValue = false;
        $i = 0;
        $length = strlen($json);
        while ($i < $length) {
            if ($json[$i++] !== ":") {
                if (!$isValue) continue;
            } else if ($json[$i] === '"') $i++;

            if ($i >= $length) break;

            if ($json[$i] === '"') {
                $isValue = false;
                continue;
            }
            if ($json[$i] === "[" || $json[$i] === "{") {
                $i = concatArray($sb, $i, $json);
                $isValue = false;
                continue;
            }
            $sb[] = $json[$i];
            $isValue = true;
        }
        return str_replace(',', '', implode('', $sb));
    } catch (Exception $e) {
        throw new IndusspayException($e->getMessage());
    }
}

function concatArray(&$sb, $index, $json) {
    $chr = ($json[$index] === '[') ? ']' : '}';
    $stringBuilder = "";
    $index++;
    $length = strlen($json);
    while ($index < $length) {
        if ($json[$index] === $chr) break;
        $stringBuilder .= $json[$index];
        ++$index;
    }
    $sb[] = preg_replace('/[^a-zA-Z0-9]/', '', $stringBuilder);
    return $index;
}

function serializeWithCustomHandling($obj) {
    try {
        return json_encode($obj);
    } catch (Exception $e) {
        throw new IndusspayException("Serialization error: " . $e->getMessage());
    }
}

