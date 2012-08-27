<?php
class DashboardController extends Zend_Controller_Action
{

	public function init()
	{
		
		/*
			 $date = new Zend_Date();
			$date->add('3', Zend_Date::HOUR);
			$this->headMeta()->appendHttpEquiv('expires',
			$date->get(Zend_Date::RFC_1123));
		 */
		$auth = Zend_Auth::getInstance();
		if (! $auth->hasIdentity()) {
			return $this->_redirect('/usuarios/login');
		}
		 
	}

	public function indexAction()
	{
		 
		// action body
	}


}
