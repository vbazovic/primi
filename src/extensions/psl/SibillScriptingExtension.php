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
    public static function error(string $err): ?string {
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
    public static function sleep(int $ms = 100) {
        usleep($ms * 1000);
    }

    /**
     * Get value 
     * 
     * @param string $json
     * @param string $key
     * @param mixed|null $default
     * @return mixed|null
     */
    public static function get_json_data(string $json, string $key, $default = NullValue::TYPE) {
        $a = json_decode($json, true);
        return $a[$key] ?: $default;
    }

    /**
     * Extract bit ranges.
     * 
     * @param int $value
     * @param int $start_pos
     * @param int $end_pos
     * @return int
     */
    public static function extract_bits($value, $start_pos, $end_pos) {
        $mask = (1 << ($end_pos - $start_pos)) - 1;
        return ($value >> $start_pos) & $mask;
    }
    
    /**
     * Extract bit .
     * 
     * @param int $value
     * @param int $bit_pos     
     * @return int
     */
    public static function extract_bit($value, $bit_pos) {        
        return self::extract_bits($value, $bit_pos, $bit_pos+1);
    }
    
    /**
     * Set n-th 
     * 
     * @param int $value
     * @param int $bit_pos
     * @param int $bit_val
     * @return int
     */
    public static function set_bit($value, $bit_pos, $bit_val) {
        $mask = 1 << $bit_pos;
        return ($value & ~$mask) | (($bit_val << $bit_pos) & $mask);
    }
}
