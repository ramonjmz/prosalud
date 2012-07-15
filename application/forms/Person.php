<?php
class Application_Form_Person extends Zend_Form {

	public function init(){
		
		$this->addElement(
		'text','first_name',array(
		'label'=>'Nombre',
            'required' => true
				)
		);
		
				$this->addElement(
		'text','last_name',array(
		'label'=>'Apellidos',
            'required' => true
				)
		);
		
		
			$this->addElement(
		'text','phone_home',array(
				'label'=>'Telefono de casa',
            'required' => true
				)
		);
		$this->addElement(
		'text','email',array(
				'label'=>'email',
            'required' => true
				)
		);
		$this->addElement(
		'submit','Guardar',array()
		);
		
	}
}