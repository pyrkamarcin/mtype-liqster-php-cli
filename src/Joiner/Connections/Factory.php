<?php

namespace Joiner\Connections;

use Instaxer\Instaxer;
use Maxer\Maxer;

/**
 * Class Factory
 * @package Joiner\Connections
 */
class Factory
{
    /**
     * @param $username
     * @param $password
     * @return Instaxer
     * @throws \Exception
     */
    public static function createInstaxer($username, $password): Instaxer
    {

        $instaxer = new Instaxer((new Path($username))->getPath());
        $instaxer->login($username, $password);

        return $instaxer;
    }

    /**
     * @param $username
     * @param $password
     * @return Maxer
     * @throws \Exception
     */
    public static function createMaxer($username, $password): Maxer
    {
        $maxer = new Maxer();
        $maxer->login($username, $password);

        return $maxer;
    }
}
