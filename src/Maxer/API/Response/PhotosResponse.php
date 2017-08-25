<?php

namespace Maxer\API\Response;

use Maxer\API\Model\Photo;
use Psr\Http\Message\ResponseInterface;

/**
 * Class PhotosResponse
 * @package Maxer\API\Response
 */
final class PhotosResponse extends BaseResponse implements Response
{
    /**
     * @param ResponseInterface $response
     * @param int $limit
     * @return array
     * @throws \RuntimeException
     */
    public static function parse(ResponseInterface $response, int $limit = 51)
    {
        $end = explode('data-id="', $response->getBody()->getContents());
        $end = array_slice($end, 1, $limit + 1);

        $dataids = [];

        foreach ($end as $key => $node) {
            $rest = substr($node, 0, 7);
            $rest = str_replace(array('\'', '<!'), '', $rest);
            $dataids[$key]['id'] = $rest;

            $text = explode('_thumb.jpg" alt="', $node);
            if (count($text) > 1) {

                $text = explode('//', $text[0]);
                $rest = $text[1];
            } else {
                $rest = null;
            }
            $dataids[$key]['url'] = $rest . '.jpg';
        }

        $newDataids = [];
        foreach ($dataids as $dataid) {
            if ($dataid['url'] !== '.jpg') {
                $newDataids[] = $dataid;
            }
        }

        $newDataids = array_map('unserialize', array_unique(array_map('serialize', $newDataids)));
        $newDataids = array_slice($newDataids, 1, $limit + 1);

        return $newDataids;
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
