<?php

$config = include('config.php');

$controller = new \Elevator\Controller\Controller($config);
$controller->indexAction();

function __autoload($class)
{
    $parts = explode('\\', $class);
    array_shift($parts);
    require join('/', $parts) . '.php';
}
