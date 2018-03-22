<?php

require_once __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

use Joiner\Connections\Factory;
use Joiner\Reposter\Push;
use Maxer\API\Request\Base\PageRequest;
use Symfony\Component\DomCrawler\Crawler;

$username = $array[$argv[1]]['username'];
$password = $array[$argv[1]]['password'];

try {
    $instaxer = Factory::createInstaxer($username, $password);
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}

try {
    $maxer = Factory::createMaxer('jiwacut@matchpol.net', '(X:\]{v(Y.77?La)');
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}

try {
    $request = new PageRequest($argv[2]);
    $response = $request->execute();
    $html = $response->getBody()->getContents();

    $crawler = new Crawler($html);
    $url = $crawler->filter('.content')->filter('.photocontainer')->children()->getNode(0)->getAttribute('src');
    $url = substr($url, 2);
    var_dump($url);

    $user = $crawler->filter('.ctn')->filter('.username')->text();
    var_dump($user);

    $response = Push::repostPhotoByURL($url, $instaxer, $user);
    var_dump($response->getStatus());
} catch (Exception $e) {
    echo $e->getMessage() . "\n";
}
