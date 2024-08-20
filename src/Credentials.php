<?php 

namespace Primeinduss\Common;

class Credentials
{
    public static function createCredentials($username, $password)
    {
        $usernameAndPassword = "{$username}:{$password}";
        $encoded = base64_encode($usernameAndPassword);
        return "Basic {$encoded}";
    }
}
