<?php

require_once __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

use Joiner\Connections\Factory;
use Joiner\Sleep;

$firebase = \Joiner\Firebase::Factory();

$username = $array[$argv[1]]['username'];
$password = $array[$argv[1]]['password'];
$instaxer = Factory::createInstaxer($username, $password);
$user = $instaxer->instagram->getUserByUsername($argv[2]);
$userStats = $instaxer->instagram->getUserInfo($user);

try {
    $followers = \Joiner\Fall\Factory::getFollowers($instaxer, $user);
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
    exit(255);
}

echo '' . "\r\n";
echo '+-----------------------------------------------------------------------------------------------------+' . "\r\n";
echo '|                                  Followers\'s analize                                               |' . "\r\n";
echo '+-----------------------------------------------------------------------------------------------------+' . "\r\n";
echo '' . "\r\n";

try {
    $response = json_decode($firebase->get('/' . $user->getUsername() . '/followers/'));


    $userStored = [];

    foreach ($response as $item) {

        $itemArray = (array)$item;
        $itemElement = (array)$itemArray['user'];

        $userStored[] = $itemElement['username'];
    }

    echo 'Stored: ' . count($userStored) . "\r\n";

    foreach ($followers as $key => $follower) {

        if (!in_array($follower->getUsername(), $userStored)) {
            $firebase->set(
                '/' . $user->getUsername() . '/followers/' . $follower->getUsername(),
                $instaxer->instagram->getUserInfo($follower)->getUser()
            );
            echo $follower->getUsername() . ' [saved] ';

            Sleep::run(10, true);
        } else {
            echo $follower->getUsername() . ' [acctualy stored] ' . "\r\n";
        }
    }
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
    exit(255);
}
