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

    foreach ($userFeed->getItems() as $item) {

        echo $item->getLikeCount() . ' ' . $item->getCommentCount();
        $instaxer->instagram->deleteMedia($item->getId(), $item->getMediaType());
        echo "\r\n";
        Sleep::run(10, true);
    }
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
