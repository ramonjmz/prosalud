<?php

class Application_Form_Test extends Zend_Form {

    public function init() {
    	
    	    	$this->setAttrib('id', 'test-form');
    	

        $this->addElement(
                'text', 'name', array(
            'label' => 'Nombre',
            'required' => true
                )
        );

        $this->addElement(
                'text', 'amount', array(
            'label' => 'Monto'
                )
        );
        
         $this->addElement(
                'text', 'process_time', array(
            'label' => 'Tempo de Proceso'
                )
        );
        
        
        $this->addElement( 'select', 'specialty_id',array(
            'label' => 'Especialidad'
            
        )
                
        );
		
		
        
        $especialidad = new Application_Model_Specialties();
        
        $this->specialty_id->addMultiOptions( 
                $especialidad->getAsKeyValue()
        );
        
        $this->addElement(
                'submit', 'Guardar', array()
        );
    }

}