<?php

namespace Adduc\ARoute;

class Dispatch {

    protected
        $router;

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

        $match['class'] = ucfirst($match['class']);

        if(!class_exists($match['class'])) {
            throw new \Exception("Class ({$match['class']}) not found.");

        } elseif(is_callable(array($match['class'], $match['method']))) {
            $obj = new $match['class']();
            return call_user_method($match['method'], $obj, $request, $match);

        } else {
            throw new \Exception("Unexpected match data.");
        }

    }

    public function router(Router $router = null) {
        if(is_null($router)) {
            return $this->router;
        }
        $this->router = $router;
    }

}

