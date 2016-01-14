<?php

$elevators = 5;

use Elevator\Model\System;

$system = new System($elevators);

$request = new \Elevator\Model\Request(5, 7);