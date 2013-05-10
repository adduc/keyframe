<?php

namespace Adduc\MVC\Exception;

class ActionIsNotCallable extends Exception {
    public function __construct($callable, $code = 0, \Exception $previous = null) {
        $msg = "Action is not callable: {$callable[0]}::{$callable[1]}";
        parent::__construct($msg, $code, $previous);
    }

    public function friendlyMessage() {

    }
}
