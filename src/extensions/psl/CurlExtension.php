<?php

declare(strict_types=1);

namespace Smuuf\Primi\Psl;

use Smuuf\Primi\ErrorException;
use \Smuuf\Primi\Extension;
use Smuuf\Primi\ISupportsLength;
use \Smuuf\Primi\Structures\Value;
use \Smuuf\Primi\Structures\NullValue;
use \Smuuf\Primi\Structures\BoolValue;
use Smuuf\Primi\Structures\NumberValue;
use \Smuuf\Primi\Structures\StringValue;

class CurlExtension extends Extension {

    /**
     * Fetches content from $cUrl
     * 
     * @param string $cUrl
     * @param str $header   Optional header
     * @return string|null
     */
    public static function curl_get(string $cUrl, array $header = []): ?string {
        $ch = curl_init($cUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        if (!empty($header)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        $result = curl_exec($ch);
        if (PHP_SAPI === 'cli') {
            echo $result . "\n";
            return null;
        } else {
            return $result;
        }
    }

    public static function curl_get_jwt(string $cUrl, string $token, string $key = 'App-Key') {
        $header = [
            "Accept: application/json",
            $key . ": " . $token,            
        ];
        return self::curl_get($cUrl, $header);
    }

}
