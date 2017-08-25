<?php

namespace Maxer\API\Request\Base;

use Maxer\API\Framework\Request;

/**
 * Class PageRequest
 * @package Maxer\API\Request\Base
 */
class PageRequest extends Request
{
    /**
     * PageRequest constructor.
     * @param string $path
     * @throws \InvalidArgumentException
     */
    public function __construct(string $path)
    {
        parent::__construct();

        $this->setPath($path);
        $this->setMethod('get');
        $this->setBody(array());
    }
}
