<?php
class Application_Form_Contact extends Zend_Form {

	public function init(){
		
		$this->setAttrib('id', 'contact-form');
		
		
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
		'text','email',array(
				'label'=>'email',
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
		'text','birthdate',array(
				'label'=>'Fecha de Nacimiento'
								)
		);
		
		        // Add the comment element
        
		 $this->addElement( 'select', 'title', array(
		'label' => 'Tipo',
		 'required' => true,
		'multiOptions' => array(''=>'','Administrador' => 'Administrador', 'Paciente'
		=> 'Paciente','Medico'=> 'Medico')
		)
		);
		
		$this->addElement( 'select', 'gender', array(
		'label' => 'Seleccion el Genero',
		 'required' => true,
		'multiOptions' => array('A'=>'','M'=>'Masculino','F' => 'Femenino')
		)
		);
			 
		$this->addElement(
		'submit','Guardar',array()
		);
		
	}
}