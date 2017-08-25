<?php

namespace Maxer\API\Response;

use Psr\Http\Message\ResponseInterface;

/**
 * Interface Response
 * @package Maxer\API\Response
 */
interface Response
{
    /**
     * @param ResponseInterface $response
     * @return mixed
     */
    public static function parse(ResponseInterface $response);
}
