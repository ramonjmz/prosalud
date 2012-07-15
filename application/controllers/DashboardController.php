<?php
class DashboardController extends Zend_Controller_Action
{

	public function init()
	{
		$auth = Zend_Auth::getInstance();
		if (! $auth->hasIdentity()) {
			return $this->_redirect('/usuarios/login');
		}

		$options = array( 'layout'   => 'interno');
		
		Zend_Layout::startMvc($options);
		 
	}

	public function indexAction()
	{
		 
		// action body
	}


}
