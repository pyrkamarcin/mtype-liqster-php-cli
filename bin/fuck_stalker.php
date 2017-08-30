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

    foreach ($following as $user) {

        $user = $instaxer->instagram->getUserInfo($user)->getUser();

        try {
            $userFeed = $instaxer->instagram->getUserFeed($user);
            echo 'Feed download. Elements: ' . $userFeed->getNumResults() . "\r\n";
        } catch (Exception $e) {
            echo $e->getMessage() . "\n";
            exit(255);
        }

        foreach ($userFeed->getItems() as $feedItem) {
            $comments = $feedItem->getComments();

            foreach ($comments as $comment) {

                try {
                    $items = $instaxer->instagram->getUserFeed($comment->getUser());

                    if ($comment->getUser()->getUsername() !== $argv[2]) {

                        $items = array_slice($items->getItems(), 0, random_int(3, 12));

                        echo sprintf('User: %s; ', $comment->getUser()->getUsername());
                        echo sprintf('followers: %s, ' . "\r\n", $user->getFollowerCount());

                        $file = file_get_contents(__DIR__ . '/../var/storage/' . $array[$argv[1]]['username'] . '.tmp');
                        $haystack = explode(';', $file);

                        $userFollow = false;

                        foreach ($following as $followingUser) {
                            if ($followingUser->getUsername() === $user->getUsername()) {
                                $userFollow = true;
                            }
                        }
                        if (!in_array($user->getUsername(), $haystack, true)) {
                            if ($userFollow !== true) {
                                echo $user->getUsername() . ' [do not following me] ' . "\r\n";
                                $response = $instaxer->instagram->followUser($user);

                                file_put_contents(__DIR__ . '/../var/storage/' . $array[$argv[1]]['username'] . '.tmp', $user->getUsername() . ';', FILE_APPEND);
                            }
                        }

                        foreach ($items as $hashTagFeedItem) {

                            try {
                                if ($hashTagFeedItem->isHasLiked()) {
                                    throw new \RuntimeException('Feed is acctual liked' . "\r\n");
                                }

                                $id = $hashTagFeedItem->getId();

                                echo sprintf('Feed id: %s,  ', $id);

                                $likeCount = $hashTagFeedItem->getLikeCount();
                                $commentCount = $hashTagFeedItem->getCommentCount();

                                echo sprintf('photo: %s/%s ', $likeCount, $commentCount);

                                if ($user->getFollowerCount() > 100) {
                                    $instaxer->instagram->likeMedia($hashTagFeedItem->getId());
                                    echo sprintf(' [liked] ');
                                } else {
                                    echo sprintf(' [low power - skip] ');
                                }
                            } catch (Exception $e) {
                                echo $e->getMessage() . "\n";
                            }
                            Sleep::run(10, true);
                        }
                    }
                } catch (Exception $e) {
                    echo $e->getMessage() . "\n";
                    Sleep::run(5, true);
                }
            }
        }
    }
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
