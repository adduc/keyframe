<?php

namespace Adduc\AMvc;

class View {

    function render($view, $data) {
        $path = dirname(dirname(dirname(__DIR__))) . "/views/{$view}.php";
        if(is_file($path) && is_readable($path)) {
            $this->path = $path;
            ob_start();
            extract($data);
            include($this->path);
            $view = ob_get_contents();
            ob_end_clean();
            return $view;
        } else {
            $msg = "View {$view} does not exist.";
            $msg.= "\nExpected location: {$path}";
            throw new \Exception($msg);
        }
    }

}
