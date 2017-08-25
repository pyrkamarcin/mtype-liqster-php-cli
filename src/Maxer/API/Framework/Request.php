<?php

namespace Maxer\API\Framework;

use Psr\Http\Message\ResponseInterface;

/**
 * Class Request
 * @package Maxer\API\Framework
 */
class Request
{
    /**
     * @var
     */
    private $body;
    /**
     * @var
     */
    private $path;
    /**
     * @var
     */
    private $method;
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;
    /**
     * @var
     */
    private $response;
    private $raw;

    /**
     * Request constructor.
     * @throws \InvalidArgumentException
     */
    public function __construct()
    {
        $this->client = Jar::getInstance()->getJar();
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param mixed $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * @return ResponseInterface
     */
    public function execute(): ResponseInterface
    {
        switch ($this->getMethod()) {
            case 'get': {
                $this->response = $this->client->request(
                    'GET',
                    $this->getPath()
                );
                break;
            }
            case 'post': {
                $this->response = $this->client->request(
                    'POST',
                    $this->getPath(),
                    $this->getBody(),
                    $this->getRaw()
                );
                break;
            }
        }

        return $this->response;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    public function getRaw()
    {
        return $this->raw;
    }

    /**
     * @param mixed $raw
     */
    public function setRaw($raw)
    {
        $this->raw = $raw;
    }

    /**
     * @param \GuzzleHttp\Client $client
     */
    public function setClient(\GuzzleHttp\Client $client)
    {
        $this->client = $client;
    }

}
