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

        echo 'Liczba "following": ' . count($following) . "\r\n";

        foreach ($following as $user) {

            /**
             * @var \Instagram\API\Response\Model\User $user
             */
            $status = $instaxer->instagram->unfollowUser($user);
            echo "\r\n" . 'User: ' . $user->getUsername();
            echo ' RES: ' . ($status->getMessage() ? ' OK' : " NO");

            Sleep::run(30, true);
        }
    } catch (\Psr\Cache\InvalidArgumentException $e) {
        echo $e->getMessage() . "\n";
        exit(255);
    }

} catch (Exception $e) {
    echo $e->getMessage() . "\n";
    exit(255);
}
exit(0);
