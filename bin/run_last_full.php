<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

$maxer = new \Maxer\Maxer();
$maxer->login('', '');

$users = new \Maxer\API\Request\UserRequest();
$users = \Maxer\API\Response\UserResponse::toObjects(\Maxer\API\Response\UserResponse::parse($users->execute(), 15));

foreach ($users as $user) {

    $photos = $maxer->getUserPhotos($user, 20);

    echo sprintf("\r\n" . 'User: %s: ' . "\r\n", $user->getName());

    foreach ($photos as $photo) {
        $vouteResults = $maxer->setPhotoVoute($photo, 6);

        dump($vouteResults->getStatusCode());
        dump($vouteResults->getBody()->getContents());
        sleep(10);
    }
}
