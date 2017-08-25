<?php

namespace Maxer\API\Request;

use Maxer\API\Framework\Token;
use Maxer\API\Model\Photo;
use Maxer\API\Request\Base\PageRequest;

/**
 * Class VoutePhotoRequest
 * @package Maxer\API\Request
 */
class VoutePhotoRequest extends PageRequest
{
    /**
     * VoutePhotoRequest constructor.
     * @param Token $token
     * @param Photo $photo
     * @param int $rate
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function __construct(Token $token, Photo $photo, int $rate = 6)
    {
        parent::__construct('https://www.maxmodels.pl/photo/vote/t/' . $token->getValue());

        $this->setMethod('post');
        $this->setBody([
            'form_params' => [
                'rate' => $rate,
                'id' => $photo->getId(),
            ]
        ]);
    }
}
