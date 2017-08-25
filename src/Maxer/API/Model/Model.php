<?php

namespace Maxer\API\Model;

/**
 * Class Model
 * @package Maxer\API\Model
 */
class Model
{
    /**
     * Model constructor.
     * @param array $properties
     */
    public function __construct(array $properties = array())
    {
        if ($properties !== null) {
            foreach ($properties as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }
}
