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

    $userFeed = $instaxer->instagram->getUserFeed($account);

    foreach (array_reverse($userFeed->getItems()) as $item) {

        if ($item->getLikeCount() <= 100) {
            $instaxer->instagram->deleteMedia($item, $item->getMediaType());
            echo $item->getLikeCount() . ' ' . $item->getCommentCount();
            echo "\r\n";

            Sleep::run(5, true);
        } else {
            echo 'skip: ' . $item->getLikeCount() . ' ' . $item->getCommentCount();
            echo "\r\n";
        }
    }
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
