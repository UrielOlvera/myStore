<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../../vendor/autoload.php';

AppFactory::setContainer(new \DI\Container());
$app = AppFactory::create();
$container = $app->getContainer();

require __DIR__."/Routes.php";
require __DIR__."/Config.php";
require __DIR__."/Dependencies.php";

$app->run();