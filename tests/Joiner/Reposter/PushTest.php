<?php

use Instagram\API\Response\ConfigureMediaResponse;
use Joiner\Connections\Factory;
use Joiner\Repository\Images;
use Joiner\Reposter\Push;
use PHPUnit\Framework\TestCase;

class PushTest extends TestCase
{
    public function testRepostPhotoByURL()
    {
        $instaxer = Factory::createInstaxer('jiwacut@matchpol.net', '(X:\]{v(Y.77?La)');

        $maxer = Factory::createMaxer('jiwacut@matchpol.net', '(X:\]{v(Y.77?La)');
        $images = new Images($maxer);

        $data = $images->get();

        $sigleData = $data[0];

        $response = Push::repostPhotoByURL($sigleData->getUrl(), $instaxer);

        $this->assertInstanceOf(ConfigureMediaResponse::class, $response);
    }
}
