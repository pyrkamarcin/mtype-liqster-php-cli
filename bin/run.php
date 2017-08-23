<?php

use Joiner\Connections\Factory;
use Joiner\Sleep;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

try {
    $username = $array[$argv[1]]['username'];
    $password = $array[$argv[1]]['password'];
    $instaxer = Factory::createInstaxer($username, $password);

    $counter = 2;
    $long = 4;

    $itemRepository = new \Instaxer\Domain\Model\ItemRepository($array[$argv[1]]['tags']);

    for ($c = 0; $c < $counter; $c++) {

        $item = $itemRepository->getRandomItem();

        echo sprintf('#%s: ' . "\r\n", $item->getItem());

        $hashTagFeed = $instaxer->instagram->getTagFeed($item->getItem());
        $items = array_slice($hashTagFeed->getItems(), 0, $long);

        foreach ($items as $hashTagFeedItem) {

            $id = $hashTagFeedItem->getId();
            $user = $instaxer->instagram->getUserInfo($hashTagFeedItem->getUser())->getUser();
            $followRatio = $user->getFollowerCount() / $user->getFollowingCount();

            echo sprintf('User: %s; ', $user->getUsername());
            echo sprintf('id: %s,  ', $id);
            echo sprintf('followers: %s,  ratio: %s, ', $user->getFollowerCount(), round($followRatio, 1));

            $likeCount = $hashTagFeedItem->getLikeCount();
            $commentCount = $hashTagFeedItem->getCommentCount();

            echo sprintf('photo: %s/%s ', $likeCount, $commentCount);

            if ($user->getFollowingCount() > 100) {
                $instaxer->instagram->likeMedia($hashTagFeedItem->getID());
                echo sprintf('[liked] ');
            }

            Sleep::run(20, true);
            echo sprintf("\r\n");
        }

        Sleep::run(20, true);
    }
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
