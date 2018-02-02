<?php

use Instaxer\Domain\Model\ItemRepository;
use Joiner\Connections\Factory;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

try {
    echo date('H:i:s') . " INIT \r\n";
    $username = $array[2]['username'];
    $password = $array[2]['password'];
    echo date('H:i:s') . " INIT | CREATE INSTAXER \r\n";
    $instaxer = Factory::createInstaxer($username, $password);
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}

$loop = React\EventLoop\Factory::create();

$loop->addPeriodicTimer(5, function () {
    $memory = memory_get_usage() / 1024 / 1024;
    $formatted = number_format($memory, 1) . 'M';
    echo date('H:i:s') . " SYSTEM | IDLE | Current memory usage: {$formatted}\n";
});

$loop->addPeriodicTimer(random_int(20, 60), function () use ($instaxer, $array) {
    try {
        $counter = random_int(1, 2);
        $long = random_int(1, 6);

        echo date('H:i:s') . " RUN | READ REPOSITORY \r\n";
        $itemRepository = new \Instaxer\Domain\Model\ItemRepository($array[2]['tags']);

        for ($c = 0; $c < $counter; $c++) {

            echo date('H:i:s') . " RUN | READ ITEM \r\n";
            $item = $itemRepository->getRandomItem();
            echo date('H:i:s') . " RUN | ";
            echo sprintf('#%s: ' . "\r\n", $item->getItem());

            $hashTagFeed = $instaxer->instagram->getTagFeed($item->getItem());
            $items = array_slice($hashTagFeed->getItems(), 0, $long);

            foreach ($items as $hashTagFeedItem) {

                $id = $hashTagFeedItem->getId();
                $user = $instaxer->instagram->getUserInfo($hashTagFeedItem->getUser())->getUser();
                $followRatio = $user->getFollowerCount() / $user->getFollowingCount();
                echo date('H:i:s') . " RUN | ";
                echo sprintf('user: %s; ', $user->getUsername());
                echo sprintf('id: %s,  ', $id);
                echo sprintf('followers: %s,  ratio: %s, ', $user->getFollowerCount(), round($followRatio, 1));

                $likeCount = $hashTagFeedItem->getLikeCount();
                $commentCount = $hashTagFeedItem->getCommentCount();

                echo sprintf('photo: %s/%s ', $likeCount, $commentCount);

                if ($user->getFollowingCount() > 100) {
                    $instaxer->instagram->likeMedia($hashTagFeedItem->getID());
                    echo sprintf('[liked] ');
                }
                echo sprintf("\r\n");
            }
        }

        unset($itemRepository);
    } catch (Exception $e) {
        echo $e->getMessage() . "\n";
    }
});

$loop->addPeriodicTimer(random_int(80, 100), function () use ($instaxer, $array) {
    try {
        $account = $instaxer->instagram->getCurrentUserAccount()->getUser();

        echo date('H:i:s') . " FOLLOWER | READ Factory::Following \r\n";
        $following = \Joiner\Fall\Factory::getFollowing($instaxer, $account);

        $itemRepository = new ItemRepository($array[2]['tags']);

        echo date('H:i:s') . " FOLLOWER | READ ITEM \r\n";
        $item = $itemRepository->getRandomItem();
        $hashTagFeed = $instaxer->instagram->getTagFeed($item->getItem());

        $elements = $hashTagFeed->getItems();
        $elements = array_slice($elements, 0, random_int(3, 8));

        echo date('H:i:s') . " FOLLOWER | READ FEED \r\n";
        foreach ($elements as $hashTagFeedItem) {
            $id = $hashTagFeedItem->getId();
            $user = $instaxer->instagram->getUserInfo($hashTagFeedItem->getUser())->getUser();

            $userFollow = false;

            foreach ($following as $followingUser) {
                if ($followingUser->getUsername() === $user->getUsername()) {
                    $userFollow = true;
                }
            }
            $file = file_get_contents(__DIR__ . '/../var/storage/' . $array[2]['username'] . '.tmp');
            $haystack = explode(';', $file);
            if (!in_array($user->getUsername(), $haystack, true)) {
                if ($userFollow !== true) {

                    echo date('H:i:s') . " FOLLOWER | ";
                    echo $user->getUsername() . ' do not following me yet' . "\r\n";
                    $response = $instaxer->instagram->followUser($user);

                    file_put_contents(__DIR__ . '/../var/storage/' . $array[2]['username'] . '.tmp', $user->getUsername() . ';', FILE_APPEND);
                }
            }
        }

        unset($itemRepository);
        unset($following);
        unset($elements);
    } catch (Exception $e) {
        echo $e->getMessage() . "\n";
    }
});

$loop->addPeriodicTimer(random_int(80, 200), function () use ($instaxer, $array) {
    try {
        $account = $instaxer->instagram->getCurrentUserAccount()->getUser();

        echo date('H:i:s') . " UNFOLLOWER | READ Factory::Following \r\n";
        $following = \Joiner\Fall\Factory::getFollowing($instaxer, $account);

        shuffle($following);
        $following = array_slice($following, 0, random_int(1, 4));

        foreach ($following as $user) {

            echo date('H:i:s') . " UNFOLLOWER | ";
            /**
             * @var \Instagram\API\Response\Model\User $user
             */
            $status = $instaxer->instagram->unfollowUser($user);
            echo ' User: ' . $user->getUsername();
            echo ' RES: ' . ($status->getMessage() ? ' OK' : " NO");
            echo sprintf("\r\n");
        }

        unset($account);
        unset($following);
    } catch (Exception $e) {
        echo $e->getMessage() . "\n";
    }
});


$loop->addPeriodicTimer(1000, function () use ($array) {
    try {
        $maxer = new \Maxer\Maxer();

        $username = $array[3]['username'];
        $password = $array[3]['password'];
        $maxer->login($username, $password);

        $users = new \Maxer\API\Request\UserRequest();
        $users = \Maxer\API\Response\UserResponse::toObjects(\Maxer\API\Response\UserResponse::parse($users->execute(), 15));

        foreach ($users as $user) {

            $photos = $maxer->getUserPhotos($user, 20);

            echo date('H:i:s') . " MAXER | User: " . $user->getName() . "\r\n";

            foreach ($photos as $photo) {
                $vouteResults = $maxer->setPhotoVoute($photo, 6);
            }
        }

        unset($maxer);
        unset($username);
        unset($password);
        unset($users);
    } catch (Exception $e) {
        echo $e->getMessage() . "\n";
    }
});
$loop->run();
