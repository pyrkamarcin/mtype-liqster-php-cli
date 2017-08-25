<?php

namespace Maxer\API\Request;

use Maxer\API\Request\Base\PageRequest;

/**
 * Class ObservedPhotosRequest
 * @package Maxer\API\Request
 */
class ObservedPhotosRequest extends PageRequest
{
    /**
     * ObservedPhotosRequest constructor.
     * @throws \InvalidArgumentException
     */
    public function __construct()
    {
        parent::__construct('https://www.maxmodels.pl/obserwowane,0.html');
    }
}
