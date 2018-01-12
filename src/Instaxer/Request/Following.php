<?php

namespace Instaxer\Request;

use Joiner\Sleep;

class Following
{
    private $instaxer;

    public function __construct($instaxer)
    {
        $this->instaxer = $instaxer;
    }

    public function getFollowing($user)
    {
        $followingCount = $this->instaxer->instagram->getUserInfo($user)->getUser()->getFollowingCount();

        $array = [];
        $counter = ceil($followingCount / 200);

        $lastId = $user;

        for ($i = 1; $i <= $counter; $i++) {
            $fall = $this->instaxer->instagram->getUserFollowing($user, $lastId);
            $lastId = $fall->getNextMaxId();
            $array = array_merge($array, $fall->getFollowers());
            // echo '.';
            Sleep::run(4, false);
        }

        return $array;
    }
}
