<?php

namespace Maxer\API\Framework;

use Maxer\API\Request\TokenRequest;
use Maxer\API\Response\TokenResponse;

/**
 * Class Token
 * @package Maxer\API\Framework
 */
final class Token
{
    /**
     * Token constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return string
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function getValue(): string
    {
        $request = new TokenRequest();
        return TokenResponse::parse($request->execute());
    }
}
