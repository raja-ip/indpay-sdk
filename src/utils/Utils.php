<?php

namespace primeinduss\IndusspayClient;

use Defuse\Crypto\Crypto;
use Defuse\Crypto\Exception\CryptoException;
use Defuse\Crypto\Key;

require_once 'vendor/autoload.php';

class Utils
{
    private $signatureKey;

    public function __construct($signatureKey = null)
    {
        $this->signatureKey = $signatureKey;
    }

    public function toObject($jsonData, $type)
    {
        if ($jsonData === null || $type === null) {
            throw new \InvalidArgumentException("Input parameters cannot be null or undefined");
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
        } catch (\Exception $error) {
            throw new \Exception("Failed to parse JSON: " . $error->getMessage());
        }
    }

    public function encryptCheckSum($data)
    {
        try {
            $decodedKey = base64_decode($this->signatureKey);
            if ($decodedKey === false) {
                throw new \Exception("Invalid base64-encoded key");
            }
            $key = Key::loadFromAsciiSafeString($decodedKey);

            $encrypted = Crypto::encrypt($data, $key);
            return base64_encode($encrypted);
        } catch (CryptoException $error) {
            throw new IndusspayException($error->getMessage());
        }
    }

    public function generateChecksum($obj)
    {
        $json = null;
        try {
            $json = json_encode($obj);
        } catch (\Exception $e) {
            $json = $this->serializeWithCustomHandling($obj);
        }

        $data = $this->generateChecksumFromJson($json);
        $signature = $this->encryptCheckSum("{$data}|{$this->signatureKey}");

        $jsonObject = null;
        try {
            $jsonObject = json_decode($json, true);
            $jsonObject['signature'] = $signature;
        } catch (\Exception $e) {
            throw new IndusspayException($e->getMessage());
        }
        return json_encode($jsonObject);
    }

    private function generateChecksumFromJson($json)
    {
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
                    $i = $this->concatArray($sb, $i, $json);
                    $isValue = false;
                    continue;
                }
                $sb[] = $json[$i];
                $isValue = true;
            }
            return str_replace(',', '', implode('', $sb));
        } catch (\Exception $e) {
            throw new IndusspayException($e->getMessage());
        }
    }

    private function concatArray(&$sb, $index, $json)
    {
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

    private function serializeWithCustomHandling($obj)
    {
        try {
            return json_encode($obj);
        } catch (\Exception $e) {
            throw new IndusspayException("Serialization error: " . $e->getMessage());
        }
    }
}

