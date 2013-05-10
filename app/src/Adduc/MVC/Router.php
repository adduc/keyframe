<?php

namespace Adduc\MVC;

class Router {

    protected $routes = array(
        'content' => array(),
        'error' => array()
    );

    /**
     * Add route to stored collection.
     */
    public function add(Route $route, $context='content'){
        $this->routes[$context][] = $route;
    }

    /**
     * Identify what matches request
     */
    public function matches(Request $request, $context='content') {
        foreach($this->routes[$context] as $route) {
            if($match = $route->match($request->uri)) {
                return $match;
            }
        }
        return false;
    }

}
