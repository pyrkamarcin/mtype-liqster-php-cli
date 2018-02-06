<?php

namespace Maxer\API\Response;

use Maxer\API\Model\Photo;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class PhotosResponse
 * @package Maxer\API\Response
 */
final class SinglePhotoResponse extends BaseResponse implements Response
{
    /**
     * @param ResponseInterface $response
     * @return Crawler
     * @throws \RuntimeException
     */
    public static function parse(ResponseInterface $response)
    {
        $crawler = new Crawler($response);
        return $crawler->filter('.photocontainer');
    }

    /**
     * @param array $dataids
     * @return array
     */
    public static function toObjects(array $dataids): array
    {
        $array = [];
        foreach ($dataids as $dataid) {
            $array[] = new Photo([
                'id' => $dataid['id'],
                'url' => $dataid['url']
            ]);
        }

        return $array;
    }
}
