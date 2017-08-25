<?php

namespace Maxer\API\Request;

use Maxer\API\Request\Base\PageRequest;

/**
 * Class UserRequest
 * @package Maxer\API\Request
 */
class UserRequest extends PageRequest
{
    /**
     * UserRequest constructor.
     * @throws \InvalidArgumentException
     */
    public function __construct()
    {
        parent::__construct('https://www.maxmodels.pl/modelka.html?filter%5Bsort%5D=active');
    }
}
