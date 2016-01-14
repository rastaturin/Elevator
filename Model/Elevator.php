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
    protected $requests = [];
    /**
     * @var Request
     */
    protected $request;
    protected $goingTarget = false;

    /**
     * @param $id
     * @param int $floor
     */
    public function __construct($id, $floor = 1)
    {
        $this->id = $id;
        $this->direction = self::DIRECTION_STAND;
        $this->floor = $floor;
    }

    /**
     * Send request
     * @param Request $request
     */
    public function sendRequest(Request $request)
    {
        $this->addRequest($request);
    }

    public function step()
    {
        $this->processRequest();
        $this->processStep();
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Request $request
     */
    protected function addRequest(Request $request)
    {
        if (!is_null($request)) {
            array_push($this->requests, $request);
        }
    }

    protected function processRequest()
    {
        if (is_null($this->request)) {
            $this->request = $this->getNextRequest();
        }

        if (!is_null($this->request)) {
            if ($this->atFloor($this->request->getFloor())) {
                $this->goingTarget = true;
                $this->go($this->request->getTarget());
            } elseif ($this->goingTarget) {
                if ($this->atFloor($this->request->getTarget())) {
                    $this->stop();
                    $this->request = null;
                    $this->goingTarget = false;
                }
            } else {
                $this->goingTarget = false;
                $this->go($this->request->getFloor());
            }
        }
    }

    /**
     * @return Request
     */
    protected function getNextRequest()
    {
        if (!empty($this->requests)) {
            return array_shift($this->requests);
        }
    }

    protected function goingUp()
    {
        return $this->direction == self::DIRECTION_UP;
    }

    protected function goingDown()
    {
        return $this->direction == self::DIRECTION_DOWN;
    }

    protected function stop()
    {
        $this->direction = self::DIRECTION_STAND;
    }

    /**
     * @param $floor
     * @return bool
     */
    protected function go($floor)
    {
        if ($floor == $this->floor) {
            $this->direction = self::DIRECTION_STAND;
            return false;
        } else {
            $this->direction = $floor > $this->floor ? self::DIRECTION_UP : self::DIRECTION_DOWN;
            return true;
        }
    }


    /**
     * @return int
     */
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

    /**
     * @param $floor
     * @return bool
     */
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
        return $this->direction == self::DIRECTION_STAND;
    }

    /**
     * @return array
     */
    public function getState()
    {
        return [
            'id' => $this->id,
            'floor' => $this->floor,
            'direction' => $this->direction
        ];
    }

    protected function processStep()
    {
        if ($this->goingUp()) {
            $this->floor++;
        }
        if ($this->goingDown()) {
            $this->floor--;
        }
    }

}
