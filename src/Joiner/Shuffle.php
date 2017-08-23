<?php

namespace Joiner;

/**
 * Class Shuffle
 * @package Joiner
 */
class Shuffle
{
    /**
     * @param $tags
     * @return string
     */
    public static function go($tags): string
    {
        $array = explode(' ', $tags);
        shuffle($array);
        return implode(' ', $array);
    }
}
