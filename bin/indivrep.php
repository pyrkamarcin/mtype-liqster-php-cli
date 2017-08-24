<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Joiner\Connections\Factory;
use Joiner\Repository\Profile;
use Joiner\Reposter\Push;
use Joiner\Sleep;
use Maxer\API\Model\User;

$instaxer = Factory::createInstaxer('maxmodels.insta', '(X:\]{v(Y.77?La)');
$maxer = Factory::createMaxer('jiwacut@matchpol.net', '(X:\]{v(Y.77?La)');

$user = new User();
$user->setName($argv[1]);

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