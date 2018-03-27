<?php

use Instaxer\Domain\Model\ItemRepository;
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

    $itemRepository = new ItemRepository($array[$argv[1]]['tags']);

    for ($a = 0; $a < 5; $a++) {
        for ($c = 0; $c < 5; $c++) {
            $item = $itemRepository->getRandomItem();
            $hashTagFeed = $instaxer->instagram->getTagFeed($item->getItem());

            $elements = $hashTagFeed->getItems();

            foreach ($elements as $hashTagFeedItem) {
                $id = $hashTagFeedItem->getId();
                $user = $instaxer->instagram->getUserInfo($hashTagFeedItem->getUser())->getUser();

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
                        echo $user->getUsername() . ' do not following me' . "\r\n";
                        $response = $instaxer->instagram->followUser($user);

                        file_put_contents(__DIR__ . '/../var/storage/' . $array[$argv[1]]['username'] . '.tmp', $user->getUsername() . ';', FILE_APPEND);

                        Sleep::run(70, true);
                    }
                }
            }
        }
    }
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
    exit(255);
}
exit(0);
