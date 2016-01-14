<?php

namespace Elevator\Model;

use Elevator\Exception\IncorrectRequestException;

class Request
{
    const DIRECTION_UP = 'up';
    const DIRECTION_DOWN = 'down';

    protected $floor, $target;
    protected $direction;

    public function __construct($floor, $target)
    {
        $this->floor = $floor;
        $this->target = $target;
        $this->direction = $this->calcDirection();
    }

    public function getFloor()
    {
        return $this->floor;
    }

    public function getTarget()
    {
        return $this->target;
    }

    public function getDirection()
    {
        return $this->direction;
    }

    protected function calcDirection()
    {
        if ($this->floor > $this->target) {
            return self::DIRECTION_DOWN;
        } else if ($this->floor < $this->target) {
            return self::DIRECTION_UP;
        } else {
            throw new IncorrectRequestException("Incorrect request $this->floor -> $this->target");
        }
    }

    public function __toString()
    {
        return sprintf("%s -> %s", $this->floor, $this->target);
    }

}
