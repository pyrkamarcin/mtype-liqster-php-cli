<?php

require_once __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

use Joiner\Connections\Factory;
use Joiner\Repository\Images;
use Joiner\Reposter\Push;
use Joiner\Sleep;

$username = $array[$argv[1]]['username'];
$password = $array[$argv[1]]['password'];
$instaxer = Factory::createInstaxer($username, $password);

$maxer = Factory::createMaxer('jiwacut@matchpol.net', '(X:\]{v(Y.77?La)');
$images = new Images($maxer);
$data = $images->get();

try {
    foreach ($data as $singleData) {

//        dump($singleData);
        $response = Push::repostPhotoByURLMulti($singleData->getUrl(), $instaxer);

        print 'ok' . "\r\n";

        Sleep::run(20, true);
    }
} catch (\Exception $exception) {
    echo 'error: ' . $exception->getMessage() . "\r\n";
}
