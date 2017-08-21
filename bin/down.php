<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

use Instaxer\Instaxer;
use Instaxer\Request\Followers;
use Instaxer\Request\Following;

try {
    $path = __DIR__ . '/var/cache/instaxer/profiles/' . $array[$argv[1]]['username'] . '.dat';

    $instaxer = new Instaxer($path);
    $instaxer->login($array[$argv[1]]['username'], $array[$argv[1]]['password']);

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
                $downloader = new \Instaxer\Downloader();
                $downloader->drain($image[0]->getUrl());

                echo '.';
                sleep(random_int(1, 2));
            }
        }
    }

} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
exit();
