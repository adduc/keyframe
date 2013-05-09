<?php

namespace Adduc\AMvc\Exception;

abstract class Exception extends \Exception {
    abstract function friendlyMessage();
}
