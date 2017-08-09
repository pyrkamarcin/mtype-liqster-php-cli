<?php

use Joiner\Connections\Factory;
use Maxer\API\Framework\Token;

class FactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testCreateMaxer()
    {
        Factory::createMaxer('jiwacut@matchpol.net', '(X:\]{v(Y.77?La)');

        $token = new Token();
        $this->assertEquals(32, strlen($token->getValue()));
    }

    public function testCreateInstaxer()
    {
        $instaxer = Factory::createInstaxer('jiwacut@matchpol.net', '(X:\]{v(Y.77?La)');

        $this->assertEquals('jiwacut matchpol', $instaxer->instagram->getLoggedInUser()->getFullName());
    }
}
