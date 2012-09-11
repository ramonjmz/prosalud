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
				'label'=>'email'
						)
		);

		$this->addElement(
		'text','phone_home',array(
				'label'=>'Telefono de casa'		)
		);

		$this->addElement(
		'text','birthdate',array(
				'label'=>'Fecha de Nacimiento',
			 'required' => true
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
		'multiOptions' => array('M'=>'Masculino','F' => 'Femenino')
		)
		);
         
		  
        $this->addElement( 'select', 'reports_to_id',array(
            'label' => 'Asignado a'
            
        )
                
        );
                $asignado = new Application_Model_Contacts();
        
		
        
        $this->reports_to_id->addMultiOptions( 
                $asignado->getAsKeyValue()
        );
        
    
		$this->addElement(
		'submit','Guardar',array()
		);

	}
}