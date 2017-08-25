<?php

namespace Maxer\API\Request;

use Maxer\API\Request\Base\BaseRequest;

/**
 * Class LoginRequest
 * @package Maxer\API\Request
 */
final class LoginRequest extends BaseRequest
{
    /**
     * LoginRequest constructor.
     * @param string $username
     * @param string $password
     * @throws \InvalidArgumentException
     */
    public function __construct(string $username, string $password)
    {
        $this->setPath('https://www.maxmodels.pl/user/login');
        $this->setMethod('post');
        $this->setBody(
            [
                'form_params' => [
                    'email' => $username,
                    'password' => $password,
                    'referer' => '/']
            ]);

        parent::__construct();
    }
}
