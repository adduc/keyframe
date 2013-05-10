<?php

namespace Adduc\MVC;

class View {

    protected $file;

    public function __construct($file = null) {
        $file && $this->setFile($file);
    }

    public function setFile($file) {
        $file = "{$file}.php";
        if(is_readable($file) && is_file($file)) {
            $this->file = $file;
        } else {
            throw new \Exception("View does not exist: {$file}");
        }
    }

    function render($data) {
        if(is_null($this->file)) {
            throw new \Exception("File must be set before View can render.");
        }

        ob_start();
        extract($data);
        include($this->file);
        $view = ob_get_contents();
        ob_end_clean();
        return $view;
    }

}
