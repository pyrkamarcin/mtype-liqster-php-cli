<?php

namespace Maxer\API\Framework;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\ChainCache;
use Doctrine\Common\Cache\FilesystemCache;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Kevinrob\GuzzleCache\Storage\DoctrineCacheStorage;
use Kevinrob\GuzzleCache\Strategy\PrivateCacheStrategy;

/**
 * Class Jar
 * @package Maxer\API\Framework
 */
final class Jar
{
    /**
     * @var bool
     */
    private static $oInstance = false;

    /**
     * @var Client
     */
    private $jar;

    /**
     * Jar constructor.
     * @throws \InvalidArgumentException
     */
    protected function __construct()
    {
        $stack = HandlerStack::create();

        $stack->push(new CacheMiddleware(
            new PrivateCacheStrategy(
                new DoctrineCacheStorage(
                    new ChainCache([
                        new ArrayCache(),
                        new FilesystemCache(__DIR__ . '/../../../../tmp/'),
                    ])
                )
            )
        ), 'cache');

        $this->jar = new Client([
            'base_uri' => 'http://maxmodels.pl',
            'allow_redirects' => true,
            'debug' => false,
            'verify' => false,
            'cookies' => true,
            'handler' => $stack
        ]);


    }

    /**
     * @return bool|Jar
     * @throws \InvalidArgumentException
     */
    public static function getInstance()
    {
        if (self::$oInstance === false) {
            self::$oInstance = new Jar();
        }
        return self::$oInstance;
    }

    /**
     * @return Client
     */
    public function getJar(): Client
    {
        return $this->jar;
    }
}
