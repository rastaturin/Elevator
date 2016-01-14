<?php

namespace Elevator\Model;

class Elevator
{
    const DIRECTION_UP = 'up';
    const DIRECTION_DOWN = 'down';
    const DIRECTION_STAND = 'stand';
    const DIRECTION_MAINTENANCE = 'maintenance';

    protected $direction;
    protected $floor;
    protected $target;
    protected $id;
    protected $request;

    public function __construct($id, $floor = 1)
    {
        $this->id = $id;
        $this->direction = self::DIRECTION_STAND;
        $this->floor = $floor;
    }

    public function sendRequest(Request $request)
    {
        $this->request = $request;
        $this->target = $request->getTarget();
    }

    public function getFloor()
    {
        return $this->floor;
    }

    /**
     * @param $floor
     * @return bool
     */
    public function isStandingAtFloor($floor)
    {
        return $this->atFloor($floor) && $this->isStanding();
    }

    public function isGoingTo($floor)
    {
        return $this->target == $floor && $this->isGoing();
    }

    /**
     * @return bool
     */
    public function isGoing()
    {
        return $this->direction == self::DIRECTION_DOWN || $this->direction == self::DIRECTION_UP;
    }

    public function atFloor($floor)
    {
        return $this->floor == $floor;
    }

    public function isStanding()
    {
        return $this->direction = self::DIRECTION_STAND;
    }


    public function goingToFloor()
    {
        $this->target;
    }
}
