<?php

use Joiner\Connections\Factory;
use Joiner\Sleep;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

try {
    $username = $array[$argv[1]]['username'];
    $password = $array[$argv[1]]['password'];
    $instaxer = Factory::createInstaxer($username, $password);

    $locations = $instaxer->instagram->searchFacebookPlacesByLocation(53.431831, 14.553599);

    foreach ($locations->getItems() as $location) {

        $items = $instaxer->instagram->getLocationFeed($location->getLocation());

        echo sprintf('#%s: ' . "\r\n", $location->getTitle());

        foreach ($items->getItems() as $hashTagFeedItem) {

            $id = $hashTagFeedItem->getId();
            $user = $instaxer->instagram->getUserInfo($hashTagFeedItem->getUser())->getUser();
            $followRatio = $user->getFollowerCount() / $user->getFollowingCount();

            echo sprintf('User: %s; ', $user->getUsername());
            echo sprintf('id: %s,  ', $id);
            echo sprintf('followers: %s,  ratio: %s, ', $user->getFollowerCount(), round($followRatio, 1));

            $instaxer->instagram->likeMedia($hashTagFeedItem->getId());
            echo sprintf('[liked] ');

            echo sprintf("\r\n");
            Sleep::run(20, true);
        }
    }

} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
