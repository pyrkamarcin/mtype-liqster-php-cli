<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

$maxer = new \Maxer\Maxer();

$username = $array[$argv[1]]['username'];
$password = $array[$argv[1]]['password'];
$maxer->login($username, $password);

$photos = $maxer->getObservedPhotos(12);

foreach ($photos as $photo) {
    $vouteResults = $maxer->setPhotoVoute($photo, 6);
    sleep(10);
}
