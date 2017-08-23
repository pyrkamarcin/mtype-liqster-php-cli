<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

use Instaxer\Downloader;
use Instaxer\Request\Followers;
use Instaxer\Request\Following;
use Joiner\Connections\Factory;
use Joiner\Sleep;

try {
    $username = $array[$argv[1]]['username'];
    $password = $array[$argv[1]]['password'];
    $instaxer = Factory::createInstaxer($username, $password);

    $profile = $instaxer->instagram->getCurrentUserAccount()->getUser();

    $following = new Following($instaxer);
    $followers = new Followers($instaxer);

    $following = $following->getFollowing($profile);
    $followers = $followers->getFollowers($profile);

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
