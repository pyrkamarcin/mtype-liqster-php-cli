<?php

namespace Joiner\Repository;

use Maxer\Maxer;

class Images
{
    private $maxer;

    public function __construct(Maxer $maxer)
    {
        $this->maxer = $maxer;
    }

    public function get(): array
    {
        return $this->maxer->getLastPhotos(10);
    }
}
