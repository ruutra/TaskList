<?php

session_start();

include 'app/Controller.php';

$controller = new Controller();
$controller->handleRequest();

