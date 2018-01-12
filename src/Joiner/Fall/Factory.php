<?php

namespace Joiner\Fall;

use Instagram\API\Response\Model\User;
use Instaxer\Instaxer;
use Instaxer\Request\Followers;
use Instaxer\Request\Following;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

/**
 * Class Factory
 * @package Joiner\Fall
 */
class Factory
{
    /**
     * @param Instaxer $instaxer
     * @param User $account
     * @return mixed
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public static function getFollowers(Instaxer $instaxer, User $account)
    {
        // echo 'Get Followers: get cache: ';

        $cache = new FilesystemAdapter();

        $followersCache = $cache->getItem('instagram.followers.' . $account->getUsername());
        $followersCache->expiresAfter(36000);

        if (!$followersCache->isHit()) {

            // echo ' empty! Create request: ';

            $followersObj = new Followers($instaxer);
            $followers = $followersObj->getFollowers($account);
            $followersCache->set($followers);

            $cache->save($followersCache);
        }

        // echo ' ok! [loaded]' . "\r\n";

        return $followersCache->get();
    }

    /**
     * @param Instaxer $instaxer
     * @param User $account
     * @return mixed
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public static function getFollowing(Instaxer $instaxer, User $account)
    {
        // echo 'Get Following: check cache: ';

        $cache = new FilesystemAdapter();

        $followingCache = $cache->getItem('instagram.following.' . $account->getUsername());
        $followingCache->expiresAfter(36000);

        if (!$followingCache->isHit()) {

            // echo ' empty! Create request: ';

            $followingObj = new Following($instaxer);
            $following = $followingObj->getFollowing($account);
            $followingCache->set($following);

            $cache->save($followingCache);
        }

        // echo ' ok! [loaded]' . "\r\n";

        return $followingCache->get();
    }
}
