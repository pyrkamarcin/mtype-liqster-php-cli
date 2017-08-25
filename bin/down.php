<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

use Instaxer\Downloader;
use Joiner\Connections\Factory;
use Joiner\Sleep;

try {
    $username = $array[$argv[1]]['username'];
    $password = $array[$argv[1]]['password'];
    $instaxer = Factory::createInstaxer($username, $password);

    $profile = $instaxer->instagram->getCurrentUserAccount()->getUser();

    try {
        $following = \Joiner\Fall\Factory::getFollowing($instaxer, $account);
        $followers = \Joiner\Fall\Factory::getFollowers($instaxer, $account);
    } catch (Exception $e) {
        echo $e->getMessage() . "\n";
        exit(255);
    }

    foreach ($following as $account) {

        $userFeed = $instaxer->instagram->getUserFeed($account);

        foreach ($userFeed->getItems() as $item) {

            if ($item->getLikeCount()) {

                $image = $item->getImageVersions2()->getCandidates();
                $downloader = new Downloader();
                $downloader->drain($image[0]->getUrl());

                echo '.';
                Sleep::run(5, true);
            }
        }
    }

} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
