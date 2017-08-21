<?php

namespace Joiner\Repository;

use Maxer\API\Model\User;
use Maxer\Maxer;

class Profile
{
    private $maxer;

    public function __construct(Maxer $maxer)
    {
        $this->maxer = $maxer;
    }

    public function get(User $user): array
    {
        return $this->maxer->getUserPhotos($user, 10);
    }
}
