<?php

class Car
{
    private $color;
    private $name;

    /**
     * Car constructor.
     * @param $color
     * @param $name
     */
    public function __construct($color, $name)
    {
        $this->color = $color;
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color): void
    {
        $this->color = $color;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }
}

$lambda = function (Car $car) {
    return ucfirst($car->getName());
};

echo $lambda(new Car('red', 'small car'));
