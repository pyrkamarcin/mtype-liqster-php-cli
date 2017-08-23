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

        if ($debug === true) {
            echo 'Sleeping: ' . $value . ' s: ';

            for ($a = 1; $a <= $value; $a++) {
                echo '.';
                sleep(1);
            }
            echo "\r\n";

        }
    }
}
