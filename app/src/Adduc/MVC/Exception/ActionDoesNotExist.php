<?php

namespace Adduc\AMvc\Exception;

class ActionDoesNotExist extends Exception {
    public function __construct($callable, $code = 0, \Exception $previous = null) {
        $msg = "Action does not exist: {$callable[0]}::{$callable[1]}";
        parent::__construct($msg, $code, $previous);
    }

    public function friendlyMessage() {

    }
}
