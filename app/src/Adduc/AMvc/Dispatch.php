<?php

namespace Adduc\AMvc;
use Adduc\ARoute;

class Dispatch extends ARoute\Dispatch {

    public $controller_namespace;

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

        } elseif(!is_callable(array($match['class'], $match['method']))) {
            throw new \Exception("Method not callable.");

        } elseif(!is_a($match['class'], __NAMESPACE__ . "\\Controller", true)) {

            throw new \Exception("Class not instance of Controller.");

        }

        $rc = new \ReflectionClass($match['class']);
        $constructor = $rc->getConstructor();
        if($constructor && $constructor->name == end(explode('\\', $rc->name))) {
            $constructor = null;
        }

        if(!is_null($constructor) && $constructor->getNumberOfRequiredParameters()) {
            throw new \Exception("Class constructor requires parameters.");
        }

        $class = new $match['class']();
        $class->run($match['method'], $request, $match);
    }

}
