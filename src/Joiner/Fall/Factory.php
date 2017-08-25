<?php

namespace Joiner\Fall;

use Instagram\API\Response\Model\User;
use Instaxer\Instaxer;
use Instaxer\Request\Followers;
use Instaxer\Request\Following;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class Factory
{
    public static function getFollowers(Instaxer $instaxer, User $account)
    {
        $cache = new FilesystemAdapter();

        $followersCache = $cache->getItem('instagram.followers');
        $followersCache->expiresAfter(60);

        if (!$followersCache->isHit()) {
            $followersObj = new Followers($instaxer);
            $followers = $followersObj->getFollowers($account);
            $followersCache->set($followers);

            $cache->save($followersCache);
        }

        return $followersCache->get();
    }

    public static function getFollowing(Instaxer $instaxer, User $account)
    {
        $cache = new FilesystemAdapter();

        $followingCache = $cache->getItem('instagram.following');
        $followingCache->expiresAfter(60);

        if (!$followingCache->isHit()) {
            $followingObj = new Following($instaxer);
            $following = $followingObj->getFollowing($account);
            $followingCache->set($following);

            $cache->save($followingCache);
        }

        return $followingCache->get();
    }
}
