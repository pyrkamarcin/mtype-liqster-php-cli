<?php

namespace Joiner;

/**
 * Class Sleep
 * @package Joiner
 */
class Sleep
{
    /**
     * @param $range
     * @param bool $debug
     */
    public static function run($range, $debug = false)
    {
        $value = random_int(1, $range);

        for ($a = 1; $a <= $value; $a++) {
            sleep(1);
        }

        if ($debug === true) {
        }
    }
}
