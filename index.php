<?php

session_start();

include 'app/Router.php';

$controller = new Router();
$controller->handleRequest();

