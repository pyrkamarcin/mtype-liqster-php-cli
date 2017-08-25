<?php

use Joiner\Connections\Factory;
use Joiner\Sleep;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

try {
    $username = $array[$argv[1]]['username'];
    $password = $array[$argv[1]]['password'];
    $instaxer = Factory::createInstaxer($username, $password);

    $account = $instaxer->instagram->getCurrentUserAccount()->getUser();

    try {
        $following = \Joiner\Fall\Factory::getFollowing($instaxer, $account);
        $followers = \Joiner\Fall\Factory::getFollowers($instaxer, $account);
    } catch (Exception $e) {
        echo $e->getMessage() . "\n";
        exit(255);
    }

    $whiteList = new \Instaxer\Domain\WhiteList(__DIR__ . '/../config/whitelist.dat');

    echo 'Current count: ' . count($followers) . "\r\n";
    echo 'White list count: ' . $whiteList->count() . "\r\n";

    for ($c = 1; $c <= 200; $c++) {
        $profile = $followers[$c];

        $user = $instaxer->instagram->getUserByUsername($profile->getUserName());

        $userMostImportantStat = $user->getFollowerCount();

        if (!$whiteList->check($profile->getUserName())) {

            if ($userMostImportantStat < 10000) {
                echo $c . ": \t";

                dump($instaxer->instagram->unfollowUser($user));

                echo $user->getUsername() . ' ' . $userMostImportantStat . ' [ out ] ' . "\r\n";

                Sleep::run(20, true);

                dump($instaxer->instagram->showFriendship($user));
                Sleep::run(5, true);
            } else {
                echo $c . ": \t";
                echo $user->getUsername() . ' ' . $userMostImportantStat . ' [ skip - too preaty ! ] ' . "\r\n";

                Sleep::run(20, true);
            }
        } else {
            echo $c . ": \t";
            echo $user->getUsername() . ' [ skip - whitelist member ] ' . "\r\n";

            Sleep::run(20, true);
        }
    }
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
