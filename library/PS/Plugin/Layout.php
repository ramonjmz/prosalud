<?php
class PS_Plugin_Layout extends Zend_Controller_Plugin_Abstract
{
	public function preDispatch()
	{
		$user = Zend_Auth::getInstance();
		if($user->hasIdentity()){
			$role = $user->getIdentity()->role;
			$layout = Zend_Layout::getMvcInstance();

		//echo "hodffdafasdfasdfasfaa";
			switch ($role) {
				case 'Paciente':
				$layout->setLayout('paciente');
				break;
				case 'Medico':
				$layout->setLayout('medico');
				break;
				case 'Administrador':
				$layout->setLayout('interno');
				break;
				default:
				$layout->setLayout('layout');
				break;
			}
		}
	}
}