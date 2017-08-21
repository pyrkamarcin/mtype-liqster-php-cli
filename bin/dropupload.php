<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Joiner\Connections\Factory;
use Joiner\Repository\Images;
use Joiner\Reposter\Push;

$instaxer = Factory::createInstaxer('maxmodels.insta', '(X:\]{v(Y.77?La)');
$maxer = Factory::createMaxer('jiwacut@matchpol.net', '(X:\]{v(Y.77?La)');
$images = new Images($maxer);
$data = $images->get();

try {
    foreach ($data as $singleData) {

        dump($singleData);
        $response = Push::downloadPhotoByURLToDropbox($singleData->getUrl());

        print 'ok' . "\r\n";
        sleep(random_int(2, 5));
    }
} catch (\Exception $exception) {
    print 'error: ' . $exception->getMessage() . "\r\n";
}
