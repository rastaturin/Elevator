<?php

namespace Elevator\Model;


class System
{
    /**
     * @var Elevator[]
     */
    protected $elevators = [];

    /**
     * @param $elevatorsCount
     */
    public function __construct($elevatorsCount)
    {
        for ($i = 0; $i < $elevatorsCount; $i++) {
            $this->elevators[] = new Elevator($i);
        }
    }

    /**
     * Pick an elevator end send the request.
     * Return the Elevator or null if no elevator is available at the moment.
     *
     * @param Request $request
     * @return Elevator
     */
    public function sendRequest(Request $request)
    {
        if ($elevator = $this->pickAnElevator($request)) {
            $elevator->sendRequest($request);
            return $elevator;
        }
    }

    /**
     * @param Request $request
     * @return Elevator
     */
    protected function pickAnElevator(Request $request)
    {
        return $this->getElevatorAtFloor($request->getFloor())
            ?: $this->getElevatorGoingToFloor($request->getFloor())
            ?: $this->getStandingElevator();
    }

    /**
     * @param $floor
     * @return Elevator
     */
    protected function getElevatorAtFloor($floor)
    {
        foreach ($this->elevators as $elevator) {
            if ($elevator->isStandingAtFloor($floor)) {
                return $elevator;
            }
        }
    }

    protected function getStandingElevator()
    {
        foreach ($this->elevators as $elevator) {
            if ($elevator->isStanding()) {
                return $elevator;
            }
        }
    }

    /**
     * @param $floor
     * @return Elevator
     */
    protected function getElevatorGoingToFloor($floor)
    {
        foreach ($this->elevators as $elevator) {
            if ($elevator->isGoingTo($floor)) {
                return $elevator;
            }
        }
    }

    public function getElevators()
    {
        return $this->elevators;
    }
}
