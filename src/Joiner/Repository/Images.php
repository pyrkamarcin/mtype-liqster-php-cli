<?php

namespace Joiner\Repository;

use Maxer\Maxer;

/**
 * Class Images
 * @package Joiner\Repository
 */
class Images
{
    /**
     * @var Maxer
     */
    private $maxer;

    /**
     * Images constructor.
     * @param Maxer $maxer
     */
    public function __construct(Maxer $maxer)
    {
        $this->maxer = $maxer;
    }

    /**
     * @return array
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function get(): array
    {
        return $this->maxer->getRankedPhotos(25);
    }
}
