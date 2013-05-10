<?php
namespace Adduc\MVC\Exception;

class ControllerDoesNotExist extends Exception {

    public function friendlyMessage() {

    }

}

/*
    $msg = "
        Could not find controller.
        Create file at APP/src/DomainTracker/Controller/{$classified}.php
        with the following code:

        <?php
        namespace Adduc\\DomainTracker\\Controller;
        class {$classified} {
        }
    ";
*/
