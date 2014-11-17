<?php

/**
 * Index controller
 *
 * Controlador "start" da aplicação
 *
 * @uses       Zend_Controller_Action
 * @subpackage Controller
 */
class IndexController extends Zend_Controller_Action{

	public function indexAction(){
		
		// remove o render
		$this->_helper->viewRenderer->setNoRender(true);
		
		/*// redireciona para sistema
		$this->_redirect('/entrega/');*/
	}
}