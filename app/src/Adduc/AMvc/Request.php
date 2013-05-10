<?php

namespace Adduc\AMvc;

class Request {
    public
        /**
         * Request Method
         * @var string
         */
        $method,
        /**
         * Request URI
         * @var string
         */
        $uri,
        /**
         * Request Data
         * @var array
         */
        $data;

    public function is($method) {
        return strtolower($this->method) == strtolower($method);
    }

    public function __construct($autoload = true) {
        if($autoload) {
            $this->load();
        }
    }

    public function load() {

        $uri = $_SERVER['DOCUMENT_ROOT'];
        $uri = dirname(substr($_SERVER['SCRIPT_FILENAME'], strlen($uri)));
        $uri = substr($_SERVER['REQUEST_URI'], strlen($uri));
        $uri = "/" . ltrim($uri, "/");
        $uri = current(explode("?", $uri, 2));

        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->uri = $uri;
        $this->data->request = &$_REQUEST;
        $this->data->post = &$_POST;
        $this->data->get = &$_GET;

    }

}
