<?php

require_once __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

use Joiner\Connections\Factory;

$firebase = \Joiner\Firebase::Factory();

$username = $array[$argv[1]]['username'];
$password = $array[$argv[1]]['password'];

$instaxer = Factory::createInstaxer($username, $password);

$user = $instaxer->instagram->getUserByUsername($argv[2]);
$userStats = $instaxer->instagram->getUserInfo($user);

echo '' . "\r\n";
echo '+------------------------------------------------------------------------------+' . "\r\n";
echo '|                                                                              |' . "\r\n";
echo '|                           Followers\'s analize                                |' . "\r\n";
echo '|                                                                              |' . "\r\n";
echo '+------------------------------------------------------------------------------+' . "\r\n";
echo '' . "\r\n";

$followers = json_decode($firebase->get('/' . $user->getUsername() . '/following/'));

dump((int)$userStats->getUser()->getFollowerCount());

$count = 0;
foreach ($followers as $follower) {
    $count++;
}

dump($count);
dump(round($count / (int)$userStats->getUser()->getFollowerCount(), 2));

$value = 0;
foreach ($followers as $follower) {
    $value += $follower->follower_count;
}
dump($value / $count);

$ratio = 0;
foreach ($followers as $follower) {
    $ratio = $follower->follower_count / $follower->following_count;
    dump($ratio);
}
