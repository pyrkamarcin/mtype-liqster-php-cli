<?php

use Joiner\Connections\Factory;
use Joiner\Sleep;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';


function lick_feed($user, $items, $instaxer)
{
    echo sprintf("\n\t" . 'lick_feed:');

    /**
     * @var Instagram\API\Response\UserFeedResponse $items
     */

    $array = $items->getItems();
    shuffle($array);
    $array = array_slice($array, 0, random_int(3, 9));

    foreach ($array as $item) {

        try {
            $id = $item->getId();

            echo sprintf("\n\t\t" . 'User: %s,  ', $item->getUser()->getUsername());
            echo sprintf('Feed id: %s,  ', $id);

            $likeCount = $item->getLikeCount();
            $commentCount = $item->getCommentCount();

            echo sprintf('Photo: %s/%s ', $likeCount, $commentCount);

            if ($item->isHasLiked()) {
                throw new \RuntimeException('Feed is actual liked');
            }

            $instaxer->instagram->likeMedia($item->getId());
            echo sprintf("\t" . ' [liked] ');

            Sleep::run(40, true);

        } catch (Exception $e) {
            echo $e->getMessage() . "\n";

            Sleep::run(10);
        }
    }
}


try {
    $ownUsername = $array[$argv[1]]['username'];
    $password = $array[$argv[1]]['password'];
    $instaxer = Factory::createInstaxer($ownUsername, $password);

    $account = $instaxer->instagram->getCurrentUserAccount()->getUser();

    try {
        $myFollowing = \Joiner\Fall\Factory::getFollowing($instaxer, $account);
        $myFollowers = \Joiner\Fall\Factory::getFollowers($instaxer, $account);
    } catch (Exception $e) {
        echo $e->getMessage() . "\n";
        exit(255);
    }

    shuffle($myFollowing);
    shuffle($myFollowers);

    foreach ($myFollowing as $followingUser) {
        echo sprintf("\r\n" . 'Main User: %s; ', $followingUser->getUsername());

        $followingListedUser = $instaxer->instagram->getUserInfo($followingUser)->getUser();

        try {
            $userFeed = $instaxer->instagram->getUserFeed($followingListedUser);
            echo 'Feed download. Elements: ' . $userFeed->getNumResults();
        } catch (Exception $e) {
            echo $e->getMessage() . "\n";
            exit(255);
        }

        /**
         * @var \Instagram\API\Response\Model\User $userFeed
         */

        foreach ($userFeed->getItems() as $feedItem) {
            $comments = $feedItem->getComments();

            shuffle($comments);
            foreach ($comments as $comment) {
                try {
                    $user = $comment->getUser();

                    if ($user->getPk() !== $account->getPk()) {
                        $items = $instaxer->instagram->getUserFeed($user);
                        $items = array_slice($items->getItems(), 0, random_int(3, 12));

                        echo sprintf("\r\n" . 'User: %s; ', $user->getUsername());

                        shuffle($items);
                        $items = array_slice($items, 0, random_int(1, 4));
                        foreach ($items as $nextLevelItem) {
                            $nextLevelUser = $nextLevelItem->getUser();
                            $heavy_feed = $instaxer->instagram->getUserFeed($nextLevelUser);
                            $heavyFuckingFollowers = \Joiner\Fall\Factory::getFollowing($instaxer, $nextLevelUser);


                            shuffle($heavyFuckingFollowers);
                            $heavyFuckingFollowers = array_slice($heavyFuckingFollowers, 0, random_int(4, 8));
                            foreach ($heavyFuckingFollowers as $fuckingFollower) {

                                if (!empty($nextLevelUser)) {
                                    echo sprintf("\r\n\t" . 'HEAVY USER STALKING: %s; ', $nextLevelUser->getUsername());
                                }

                                $heavyStalkingDeepFeed = $instaxer->instagram->getUserFeed($fuckingFollower);
                                lick_feed($nextLevelUser, $heavyStalkingDeepFeed, $instaxer);
                            }
                        }
                    }
                } catch (Exception $e) {
                    echo $e->getMessage() . "\n";
                    Sleep::run(5);
                } catch (\Psr\Cache\InvalidArgumentException $e) {
                }
            }
        }
    }
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
