<?php

namespace Maxer\API\Model;

/**
 * Class Photo
 * @package Maxer\API\Model
 */
class Photo extends Model
{
    /**
     * @var
     */
    protected $id;

    /**
     * @var
     */
    protected $url;

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}
