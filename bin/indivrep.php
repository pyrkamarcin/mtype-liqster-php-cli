<?php

require_once __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

use Joiner\Connections\Factory;
use Joiner\Repository\Profile;
use Joiner\Reposter\Push;
use Joiner\Sleep;
use Maxer\API\Model\User;

$username = $array[$argv[1]]['username'];
$password = $array[$argv[1]]['password'];
$instaxer = Factory::createInstaxer($username, $password);

$maxer = Factory::createMaxer('jiwacut@matchpol.net', '(X:\]{v(Y.77?La)');

$user = new User();
$user->setName($argv[2]);

$images = new Profile($maxer);
$datam = $images->get($user);

foreach ($datam as $data) {

    try {
        foreach ($data as $singleData) {
            $response = Push::repostPhotoByURL($singleData->getUrl(), $instaxer, $user);

            print ' [ok] ';
            Sleep::run(10, true);
        }
    } catch (\Exception $exception) {
        print 'error: ' . $exception->getMessage() . "\r\n";
    }
}
