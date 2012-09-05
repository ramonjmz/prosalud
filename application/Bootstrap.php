<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	/*protected function _init()
	{
		$this->bootstrap('layout');
		$layout = $this->getResource('layout');
		
		$auth = Zend_Auth::getInstance();
		$options = null;
		$usuario = $auth->getIdentity();
		//echo print_r($usuario, true);
		
		//echo print_r($options, true);
		//Zend_Layout::startMvc($options);
	}*/

	public function _initPlugins()
	{
		//include_once('PS/Plugin/Layout.php');
		$front = Zend_Controller_Front::getInstance();
		$front->registerPlugin(new PS_Plugin_Layout());
	}

}

