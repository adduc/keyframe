<?php

namespace Adduc\MVC\Exception;

abstract class Exception extends \Exception {
    abstract function friendlyMessage();
}
