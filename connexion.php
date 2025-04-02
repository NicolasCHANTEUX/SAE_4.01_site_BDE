<?php
require_once './app/controllers/AuthController.php';

$controller = new AuthController();
echo $controller->login();