<?php

use Joiner\Connections\Factory;
use Joiner\Sleep;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

try {
    $username = $array[$argv[1]]['username'];
    $password = $array[$argv[1]]['password'];
    $instaxer = Factory::createInstaxer($username, $password);

//    $itemRepository = $instaxer->instagram->getUserFeed(
//        $instaxer->instagram->getUserByUsername('instagram')
//    );
    $itemRepository = $instaxer->instagram->getMyUserFeed();

//    dump($itemRepository);

    foreach ($itemRepository->getItems() as $hashTagFeedItem) {

//        dump($hashTagFeedItem->getLikers());
//        dump($hashTagFeedItem->getComments());

        $id = $hashTagFeedItem->getId();
        $user = $instaxer->instagram->getUserInfo($hashTagFeedItem->getUser())->getUser();
        $followRatio = $user->getFollowerCount() / $user->getFollowingCount();

        echo sprintf('User: %s; ', $user->getUsername());
        echo sprintf('id: %s,  ', $id);
        echo sprintf('followers: %s,  ratio: %s, ', $user->getFollowerCount(), round($followRatio, 1));

        $likeCount = $hashTagFeedItem->getLikeCount();
        $commentCount = $hashTagFeedItem->getCommentCount();

        foreach ($hashTagFeedItem->getLikers() as $activeUser) {
//            dump($instaxer->instagram->getUserInfo($activeUser));
        }

        echo sprintf('photo: %s/%s ', $likeCount, $commentCount);

        Sleep::run(20, true);
        echo sprintf("\r\n");
    }
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
