<?php

namespace Adduc\AMvc;
use Adduc\ARoute;

class Controller {

    protected
		/**
		 * @var ARoute\Request
		 */
        $request,

		/**
		 * @var array
		 */
        $match,

        /**
         * @var array
         */
        $view = array(
			'data' => array(),
			'template' => null
        ),

        /**
         * @var array
         */
        $layout = array(
			'data' => array('view' => false),
			'template' => 'default'
        );

    /**
     * @param string action
     * @param ARoute\Request|null $request
     * @param array|null $match
     * @return void
     */
    public function run($action, ARoute\Request $request = null, $match = null) {
        $this->request = $request;
        $this->match = $match;
        $class = explode('\\', get_called_class());
        $this->view['template'] = strtolower(end($class)) . "/" . $action;

        $this->$action();

        $this->render($this->view['template'], $this->layout['template']);
    }

    public function render($view_template, $layout_template) {
        $view = new View();

        if($view_template) {
            $this->layout['data']['view']
				= $view->render($view_template, $this->view['data']);
        }

        if($layout_template) {
            echo $view->render("templates/{$layout_template}", $this->layout['data']);
        } else {
            echo $this->layout['data']['view'];
        }

        $this->view['template'] = $this->layout['template'] = false;
    }

}
