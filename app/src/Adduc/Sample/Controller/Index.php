<?php

namespace Adduc\Sample\Controller;
use Adduc\AMvc\Controller;

class Index extends Controller {

    public function sampleAction() {}

    public function error() {
        if(!$this->match['error']) {
            throw new Exception("Not directly accessible.");
        }

        $this->layout['template'] = false;
        $this->view['template'] = false;

        echo "An error occurred. <br />";
        echo nl2br($this->match['error']->getMessage());
    }
}
