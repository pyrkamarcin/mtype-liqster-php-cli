<?php

namespace Maxer\API\Request;

use Maxer\API\Request\Base\PageRequest;

/**
 * Class LastPhotosRequest
 * @package Maxer\API\Request
 */
class SinglePhotoRequest extends PageRequest
{
    /**
     * LastPhotosRequest constructor.
     * @throws \InvalidArgumentException
     */
    public function __construct(string $url)
    {
        parent::__construct($url);
    }
}
