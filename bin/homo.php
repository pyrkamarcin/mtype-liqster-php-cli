<?php

use Joiner\Connections\Factory;
use Joiner\Sleep;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

try {
    $username = $array[$argv[1]]['username'];
    $password = $array[$argv[1]]['password'];
    $instaxer = Factory::createInstaxer($username, $password);

    $account = $instaxer->instagram->getCurrentUserAccount()->getUser();

    $userFeed = $instaxer->instagram->getUserFeed($account);

    foreach ($userFeed->getItems() as $item) {

        echo $item->getLikeCount() . ' ' . $item->getCommentCount();

        $instaxer->instagram->editMedia($item->getId(), '#portrait #beauty #portrait_perfection #mood #excellent_portraits #portraitpage #excellent_portraits #love #moodportrait #simple #bw #bwmasters #bwphoto #fitnessapparel #fitnessfun #fitnessforlife #fitnessguru #fitnessphysique #fitnesslover #fitnesstips #fitnessworld #fitnessfreaks #fitnesstime #fitnesslove #fitnessaddicted #fitnesstrainer #fitnesschick ');

        echo "\r\n";

        Sleep::run(10, true);
    }
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
