<?php

namespace Maxer\API\Response;

use Maxer\API\Model\User;
use Psr\Http\Message\ResponseInterface;

class UserResponse extends BaseResponse implements Response
{
    public static function parse(ResponseInterface $response, int $limit = 30)
    {
        $end = explode('data-usr_id="', $response->getBody()->getContents());
        $end = array_slice($end, 1, $limit);
        $dataids = [];

        foreach ($end as $key => $node) {
            $rest = substr($node, 0, 7);
            $rest = str_replace(array('\'', '<!'), '', $rest);
            $dataids[$key]['id'] = $rest;
        }

        foreach ($end as $key => $node) {
            $text = explode('<span class="username"><a href="/modelka-', $node);
            $text = explode('.html">', $text[1]);

            $rest = $text[0];
            $dataids[$key]['name'] = $rest;
        }

        foreach ($end as $key => $node) {
            $text = explode('html">', $node);
            $text = explode('</a>', $text[1]);
            $rest = $text[0];
            $dataids[$key]['full_name'] = $rest;
        }

        foreach ($end as $key => $node) {
            $text = explode('<span class="username"><a href="/', $node);
            $text = explode('">', $text[1]);
            $rest = $text[0];
            $dataids[$key]['url'] = 'http://maxmodels.pl/' . $rest;
        }

        $dataids = array_map('unserialize', array_unique(array_map('serialize', $dataids)));

        return $dataids;
    }

    /**
     * @param array $dataids
     * @return array
     */
    public static function toObjects(array $dataids): array
    {
        $array = [];
        foreach ($dataids as $data) {
            $array[] = new User([
                'id' => $data['id'],
                'name' => $data['name'],
                'fullName' => $data['full_name'],
                'url' => $data['url']
            ]);
        }

        return $array;
    }
}
