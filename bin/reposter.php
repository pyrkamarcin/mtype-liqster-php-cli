<?php

/**
 * reposter.php
 *
 * php bin/reposter.php 2 polish.body
 *
 * Reposts instagram feeds into instagram acc.
 *
 */

use Joiner\Connections\Factory;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

try {
    $username = $array[$argv[1]]['username'];
    $password = $array[$argv[1]]['password'];
    $instaxer = Factory::createInstaxer($username, $password);

    $userName = $argv[2];

    $account = $instaxer->instagram->getUserByUsername($userName);
    $userFeed = $instaxer->instagram->getUserFeed($account);

    $sumArray = 0;

    foreach ($userFeed->getItems() as $item) {
        $sumArray += $item->getLikeCount();
    }

    $avrg = $sumArray / count($userFeed->getItems());

    foreach ($userFeed->getItems() as $item) {

        if ($item->getLikeCount() > $avrg * 0.99) {

            $image = $item->getImageVersions2()->getCandidates();
            $downloader = new \Instaxer\Downloader();
            $downloader->drain($image[0]->getUrl());
            $requestPublishPhoto = new Instaxer\Request\PublishPhoto($instaxer);

            $response = $requestPublishPhoto
                ->pull(
                    __DIR__ . '/../var/storage/test.jpg', ''

                );

            $editResponse = $instaxer
                ->instagram
                ->editMedia(
                    $response->getMedia()->getId(),
                    '#portrait #beauty #portrait_perfection #mood #excellent_portraits #portraitpage #excellent_portraits #love #moodportrait #simple #bw #bwmasters #bwphoto #fitnessapparel #fitnessfun #fitnessforlife #fitnessguru #fitnessphysique #fitnesslover #fitnesstips #fitnessworld #fitnessfreaks #fitnesstime #fitnesslove #fitnessaddicted #fitnesstrainer #fitnesschick '
                );

            echo '.' . "\r\n";
        }
    }
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
