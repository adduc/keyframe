<?php

namespace Adduc\AMvc;
use Doctrine\Common\Inflector\Inflector;

class Controller {

    protected
        $request,
        $view,
        $layout,
        $matched = array(),
        $viewVars = array();

    public function __construct() {
        $this->layout = new View('layouts/default');
    }

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
        $rm = $rc && $rc->hasMethod($callable[1])
            ? $rc->getMethod($callable[1]) : false;

        if(!$rm) {
            throw new Exception\ActionDoesNotExist($callable);
        } elseif(!$rm->isPublic() || $rm->isStatic() || $rm->isAbstract()) {
            throw new Exception\ActionIsNotCallable($callable);
        }

        $this->request = $request ?: new Request();
        $this->matched = $matched;


        $class = explode('\\', get_called_class() . "/{$action}");
        $this->view = new View(end($class));
        $rm->invoke($this);
        $this->render();
    }

    public function render(View $view = null, View $layout = null, array $data = null) {
        $view = is_null($view) ? $this->view : $view;
        $layout = is_null($layout) ? $this->layout : $layout;
        $data = is_null($data) ? $this->viewVars : $data;
        $data['view'] = $view->render($data);
        echo $layout ? $layout->render($data) : $data['view'];
        $this->view = $this->layout = null;
    }

}
