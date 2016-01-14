<?php

namespace Elevator\Model;

class System
{
    protected $step = 0;

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
     * @param $data
     * @return array
     */
    public function processRequests($data)
    {
        $steps = [$this->getState()];

        if (!is_array($data)) {
            throw new \InvalidArgumentException("Incorrect requests!");
        }

        foreach ($data as $req) {
            $request = new Request($req->from, $req->to);
            $this->step([$request]);
            $steps[] = $this->getState();
        }

        while (!$this->finished()) {
            $this->step();
            $steps[] = $this->getState();
        }

        return $steps;
    }

    /**
     * @param array $requests
     */
    public function step($requests = [])
    {
        $this->step++;
        foreach ($requests as $request) {
            $this->sendRequest($request);
        }
        foreach ($this->elevators as $elevator) {
            $elevator->step();
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
     * All the elevators finished requests.
     * @return bool
     */
    public function finished()
    {
        foreach ($this->elevators as $elevator) {
            if (!$elevator->isStanding()) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param Request $request
     * @return Elevator
     */
    protected function pickAnElevator(Request $request)
    {
        return $this->getElevatorAtFloor($request->getFloor())
            ?: (
                $this->getElevatorGoingToFloor($request->getFloor())
                    ?: $this->getStandingElevator()
            );
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

    /**
     * @return array
     */
    public function getState()
    {
        $result = [];
        foreach ($this->elevators as $elevator) {
            $result[] = $elevator->getState();
        }
        return $result;
    }
}
