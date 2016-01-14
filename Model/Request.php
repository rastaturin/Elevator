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
        $this->direction = $this->getDirection();
    }

    public function getFloor()
    {
        return $this->floor;
    }

    public function getTarget()
    {
        return $this->target;
    }

    protected function getDirection()
    {
        if ($this->floor > $this->target) {
            return self::DIRECTION_DOWN;
        } else if ($this->floor < $this->target) {
            return self::DIRECTION_UP;
        } else {
            throw new IncorrectRequestException();
        }
    }


}
