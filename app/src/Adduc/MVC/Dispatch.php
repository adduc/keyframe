<?php

namespace Adduc\MVC;

class Dispatch {

    protected $router;
    public
        $controller_namespace,
        $view_path;

    public function __construct(Router $router = null) {
        $this->router($router);
    }

    public function dispatch(Request $request = null) {
        if(is_null($request)) {
            $request = new Request();
        }

        try {
            $match = $this->router->matches($request);
            $this->runMatch($request, $match);
        } catch(\Exception $e) {
            try {
                $match = $this->router->matches($request, 'error');
                if($match) {
					$match['error'] = $e;
				}
                $this->runMatch($request, $match);
            } catch(\Exception $e) {
                error_log($e);
                $msg = "An error occurred while running error handler.";
                $msg.= " Request Aborted.";
                die($msg);
            }
        }

    }

    public function runMatch($request, $match) {

        if(!is_array($match)) {
            throw new \Exception("No match found.");
        }

        $match['class'] = $this->controller_namespace . "\\" . ucfirst($match['class']);

        if(!class_exists($match['class'])) {
            if(!class_exists(__NAMESPACE__ . '\\' . $match['class'])) {
                throw new \Exception("Class ({$match['class']}) not found.");
            } else {
                $match['class'] = __NAMESPACE__ . '\\' . $match['class'];
            }

        } elseif(!is_a($match['class'], __NAMESPACE__ . "\\Controller", true)) {

            throw new \Exception("Class not instance of Controller.");

        }

        $rc = new \ReflectionClass($match['class']);
        $constructor = $rc->getConstructor();
        if(!is_null($constructor) && $constructor->getNumberOfRequiredParameters()) {
            throw new \Exception("Class constructor requires parameters.");
        }

        $class = new $match['class']();
        $class->viewPath = $this->view_path;
        $class->run($match['method'], $request, $match);
    }

    public function router(Router $router = null) {
        if(is_null($router)) {
            return $this->router;
        }
        $this->router = $router;
    }

}

