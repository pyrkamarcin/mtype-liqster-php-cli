<?php

namespace Maxer\API\Request;

use Maxer\API\Request\Base\PageRequest;

class RankedPhotosRequest extends PageRequest
{
    /**
     * LastPhotosRequest constructor.
     * @throws \InvalidArgumentException
     */
    public function __construct()
    {
        parent::__construct('https://www.maxmodels.pl/ranking-zdjec-24h.html');
    }
}
