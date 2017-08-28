<?php

namespace Joiner\ML;

use Instagram\API\Response\Model\FeedItem;

/**
 * Class Tags
 * @package Joiner\ML
 */
class Tags
{
    /**
     * @var FeedItem
     */
    private $feedItem;

    /**
     * Tags constructor.
     * @param FeedItem $item
     */
    public function __construct(FeedItem $item)
    {
        $this->feedItem = $item;
    }

    /**
     * @return array
     */
    public function parse(): array
    {
        preg_match_all("/(#\w+)/", $this->feedItem->getCaption()->getText(), $samples);
        $array[] = $samples;

        $array = array_merge(...array_merge(...$array));
        $array = array_count_values($array);

        $arrayNew = [];
        foreach ($array as $key => $value) {
            $arrayNew[] = strtolower(str_replace('#', '', $key));
        }

        return $arrayNew;
    }
}
