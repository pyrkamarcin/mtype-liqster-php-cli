<?php

use Joiner\Connections\Factory;
use Joiner\Repository\Images;

class ImagesTest extends \PHPUnit\Framework\TestCase
{

    public function testConstruct()
    {
        $maxer = Factory::createMaxer('jiwacut@matchpol.net', '(X:\]{v(Y.77?La)');
        $images = new Images($maxer);

        $data = $images->get();

        $this->assertEquals(true, is_array($data));
    }
}
