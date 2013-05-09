<?php

namespace Adduc\AMvc;
use Adduc\ARoute\Request;
use Doctrine\Common\Inflector\Inflector;

class Controller {

    protected
        $request,
        $view,
        $layout,
        $matched = array(),
        $viewVars = array();

    /**
     * @param string action
     * @param Request|null $request
     * @param array|null $match
     * @return void
     */
    public function run($action, Request $request = null, $matched = null) {
        $callable = array(
            get_called_class(),
            Inflector::camelize($action) . "Action"
        );

        $rc = new \ReflectionClass(get_called_class());
        $rm = $rc && $rc->hasMethod($callable[0])
            ? $rc->getMethod($callable[0]) : false;

        if(!$rm) {
            throw new Exception\ActionDoesNotExist($callable);
        } elseif(!$rm->isPublic() || $rm->isStatic() || $rm->isAbstract()) {
            throw new Exception\ActionIsNotCallable($callable);
        }

        $this->request = $request ?: new Request();
        $this->matched = $matched;


        $class = explode('\\', get_called_class() . "/{$action}");
        $this->view = new View(end($class));
        $rc->invoke($this);
        $this->render($this->view, $this->layout);
    }

    public function render(View $view = null, View $layout = null, array $data = null) {
        $data = is_null($data) ? $this->viewVars : $data;
        $data['view'] = $view->render($data);
        echo $layout ? $layout->render($data) : $data;
        $this->view = $this->layout = null;
    }

}
