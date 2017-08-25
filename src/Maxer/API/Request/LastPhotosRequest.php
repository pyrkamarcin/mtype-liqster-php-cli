<?php

namespace Maxer\API\Request;

use Maxer\API\Request\Base\PageRequest;

/**
 * Class LastPhotosRequest
 * @package Maxer\API\Request
 */
class LastPhotosRequest extends PageRequest
{
    /**
     * LastPhotosRequest constructor.
     * @throws \InvalidArgumentException
     */
    public function __construct()
    {
        parent::__construct('https://www.maxmodels.pl/wszystkie-zdjecia,0.html');
    }
}
