<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Joiner\Connections\Factory;
use Joiner\Repository\Profile;
use Joiner\Reposter\Push;
use Maxer\API\Model\User;

$instaxer = Factory::createInstaxer('maxmodels.insta', '(X:\]{v(Y.77?La)');
$maxer = Factory::createMaxer('jiwacut@matchpol.net', '(X:\]{v(Y.77?La)');

$user = new User();
$user->setName($argv[1]);

$images = new Profile($maxer);
$data = $images->get($user);

try {
    foreach ($data as $singleData) {

        dump($singleData);
        $response = Push::repostPhotoByURL($singleData->getUrl(), $instaxer);

        print 'ok' . "\r\n";
        sleep(random_int(2, 15));
    }
} catch (\Exception $exception) {
    print 'error: ' . $exception->getMessage() . "\r\n";
}
