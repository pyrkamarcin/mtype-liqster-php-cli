<?php

require_once __DIR__ . '/../vendor/autoload.php';

$firebase = \Joiner\Firebase::Factory();

$test = [
    'foo' => 'bar',
    'i_love' => 'lamp',
    'id' => 42
];

$dateTime = new DateTime();
$firebase->set('/' . $dateTime->format('c'), $test);
