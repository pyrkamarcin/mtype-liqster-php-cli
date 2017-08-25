<?php

namespace Maxer\API\Response;

use Psr\Http\Message\ResponseInterface;

/**
 * Class TokenResponse
 * @package Maxer\API\Response
 */
final class TokenResponse extends BaseResponse implements Response
{
    /**
     * @param ResponseInterface $response
     * @return string
     * @throws \RuntimeException
     */
    public static function parse(ResponseInterface $response): string
    {
        $json = json_decode($response->getBody()->getContents(), true);
        return (string)$json['t'];
    }
}
