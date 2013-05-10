<?php

namespace Adduc\MVC;

include(dirname(__DIR__) . '/debug.php');
include(dirname(__DIR__) . '/vendor/autoload.php');

$router = new Router();

// Standard routes
$router->add(new Route('/', ['method' => 'sample']));
$router->add(new Route('/:class/:method'));
$router->add(new Route('/:class'));

// Error route
$router->add(new Route('/.*?', ['method' => 'error']), 'error');

$dispatch = new Dispatch($router);
$dispatch->controller_namespace = "Adduc\\Sample\\Controller";
$dispatch->view_path = dirname(__DIR__) . '/views';
$dispatch->dispatch();

debug_panel();

