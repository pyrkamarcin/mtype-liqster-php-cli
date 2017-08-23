<?php

namespace Joiner\Repository;

use Maxer\API\Model\User;
use Maxer\Maxer;

/**
 * Class Profile
 * @package Joiner\Repository
 */
class Profile
{
    /**
     * @var Maxer
     */
    private $maxer;

    /**
     * Profile constructor.
     * @param Maxer $maxer
     */
    public function __construct(Maxer $maxer)
    {
        $this->maxer = $maxer;
    }

    /**
     * @param User $user
     * @return array
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function get(User $user): array
    {
        return $this->maxer->getUserPhotos($user, 10);
    }
}
