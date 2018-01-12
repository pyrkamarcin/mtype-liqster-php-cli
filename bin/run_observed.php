<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

$maxer = new \Maxer\Maxer();

$maxer->login('', '');

$photos = $maxer->getObservedPhotos(12);

foreach ($photos as $photo) {
    $vouteResults = $maxer->setPhotoVoute($photo, 6);

    dump($vouteResults->getStatusCode());
    dump($vouteResults->getBody()->getContents());
    sleep(10);
}
