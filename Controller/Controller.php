<?php

namespace Elevator\Controller;

use Elevator\Model\System;
use Exception;

class Controller
{
    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function indexAction()
    {
        try {
            $data = json_decode(file_get_contents("php://input"));

            $system = new System($this->config['elevators']);
            $result = $system->processRequests($data);

            echo json_encode(['result' => 'ok', 'data' => $result], JSON_FORCE_OBJECT);
        } catch (Exception $e) {
            echo json_encode(['result' => 'error', 'error' => $e->getMessage()]);
        }
    }
}