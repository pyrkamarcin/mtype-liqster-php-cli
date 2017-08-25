<?php

use Instaxer\Request\Followers;
use Instaxer\Request\Following;
use Joiner\Connections\Factory;
use Joiner\Sleep;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

try {
    $username = $array[$argv[1]]['username'];
    $password = $array[$argv[1]]['password'];
    $instaxer = Factory::createInstaxer($username, $password);

    $account = $instaxer->instagram->getCurrentUserAccount()->getUser();

    $following = new Following($instaxer);
    $following = $following->getFollowing($account);

    $followers = new Followers($instaxer);
    $followers = $followers->getFollowers($account);

    $user = $instaxer->instagram->getUserByUsername($argv[2]);
    $userFeed = $instaxer->instagram->getUserFeed($user);

    foreach ($userFeed->getItems() as $feedItem) {
        $comments = $feedItem->getComments();

        foreach ($comments as $comment) {

            try {
                $items = $instaxer->instagram->getUserFeed($comment->getUser());

                if ($comment->getUser()->getUsername() !== $argv[2]) {

                    $items = array_slice($items->getItems(), 0, 3);

                    foreach ($items as $hashTagFeedItem) {

                        if ($hashTagFeedItem->isHasLiked()) {
                            throw new \RuntimeException(' [is acctual liked]');
                        }

                        $id = $hashTagFeedItem->getId();
                        $user = $instaxer->instagram->getUserInfo($hashTagFeedItem->getUser())->getUser();
                        $followRatio = $user->getFollowerCount() / $user->getFollowingCount();

                        $userFollow = false;

                        foreach ($following as $followingUser) {
                            if ($followingUser->getUsername() === $user->getUsername()) {
                                $userFollow = true;
                            }
                        }

                        $file = file_get_contents(__DIR__ . '/../var/storage/' . $array[$argv[1]]['username'] . '.tmp');
                        $haystack = explode(';', $file);
                        if (!in_array($user->getUsername(), $haystack, true)) {
                            if ($userFollow !== true) {
                                echo $user->getUsername() . ' [do not following me] ' . "\r\n";
                                $response = $instaxer->instagram->followUser($user);

                                file_put_contents(__DIR__ . '/../var/storage/' . $array[$argv[1]]['username'] . '.tmp', $user->getUsername() . ';', FILE_APPEND);
                            }
                        }

                        echo sprintf('User: %s; ', $user->getUsername());
                        echo sprintf('id: %s,  ', $id);
                        echo sprintf('followers: %s,  ratio: %s, ', $user->getFollowerCount(), round($followRatio, 1));

                        $likeCount = $hashTagFeedItem->getLikeCount();
                        $commentCount = $hashTagFeedItem->getCommentCount();

                        echo sprintf('photo: %s/%s ', $likeCount, $commentCount);

                        if ($user->setFollowerCount() > 100) {
                            $instaxer->instagram->likeMedia($hashTagFeedItem->getId());
                            echo sprintf(' [liked] ');
                        } else {
                            echo sprintf(' [low power - skip] ');
                        }

                        Sleep::run(10, true);
                    }

                    echo "\n";
                    Sleep::run(10, true);
                }
            } catch (Exception $e) {
                echo $e->getMessage() . "\n";
                Sleep::run(60, true);
            }
        }
    }
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
