<?php

namespace Adduc\AMvc;
use Adduc\ARoute;

include(dirname(__DIR__) . '/debug.php');
include(dirname(__DIR__) . '/vendor/autoload.php');

$router = new ARoute\Router();

// Standard routes
$router->add(new ARoute\Route('/', ['method' => 'sample']));
$router->add(new ARoute\Route('/:class/:method'));
$router->add(new ARoute\Route('/:class'));

// Error route
$router->add(new ARoute\Route('/.*?', ['method' => 'error']), 'error');

$dispatch = new Dispatch($router);
$dispatch->controller_namespace = "Adduc\\Sample\\Controller";
$dispatch->dispatch();

debug_panel();

