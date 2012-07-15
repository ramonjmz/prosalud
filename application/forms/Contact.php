<?php
class Application_Form_Contact extends Zend_Form {

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
		
		        // Add the comment element
        $this->addElement('textarea', 'description', array(
            'label'      => 'Escriba un comentario:',
         		'rows' => '5', 
             'validators' => array(
                array('validator' => 'StringLength', 'options' => array(0, 100))
                )
        ));
        
		 $this->addElement( 'select', 'title', array(
		'label' => 'Tipo',
		 'required' => true,
		'multiOptions' => array(''=>'','Contacto' => 'Contacto', 'Paciente'
		=> 'Paciente','Medico'=> 'Medico','Usuario'=>'Usuario')
		)
		);
			 
		$this->addElement(
		'submit','Guardar',array()
		);
		
	}
}