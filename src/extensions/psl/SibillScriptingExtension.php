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

class SibillScriptingExtension extends Extension {

    /**
     * Simple error output
     * 
     * @param string $cUrl
     * @return string|null
     */
    public static function error(string $err):?string {
        if (PHP_SAPI === 'cli') {
          echo $err;
        }
        return $err;
    }
    
    /**
     * Sleep in milliseconds
     * 
     * @param int $ms
     */
    public static function sleep(int $ms=100){
        usleep($ms*1000);
    }
    
    /**
     * Get value 
    * 
     * @param string $json
     * @param string $key
     * @param mixed|null $default
     * @return mixed|null
     */
    public static function get_json_data(string $json, string $key, ?mixed $default = NullValue::TYPE):?mixed{
        $a = json_decode($json,true);
        return $a[$key] ?: $default;
    }
    
    

}
