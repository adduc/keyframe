<?php
namespace Adduc\MVC\Exception;

class ControllerDoesNotExist extends Exception {

    public function friendlyMessage() {
        $path = str_replace("\\", "/", $this->getMessage());
        list($ns, $class) = str_split($this->getMessage(), strrpos($path, "/"));

        $msg[] = $this->getMessage() . " does not exist. <br />";
        $msg[] = "Create a file at APP/src/{$path}.php with the following:";
        $msg[] = "<pre><code>";
        $msg[] = "&lt;?php";
        $msg[] = "namespace {$ns};";
        $msg[] = "class " . substr($class, 1) . " {";
        $msg[] = "}";
        $msg[] = "</code></pre>";
        return implode("\n", $msg);
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
