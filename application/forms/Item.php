<?php

class Application_Form_Item extends Zend_Form {

    public function init() {

        $this->addElement(
                'text', 'name', array(
            'label' => 'Nombre',
            'required' => true
                )
        );

        $this->addElement(
                'text', 'description', array(
            'label' => 'descripcion'
                 )
        );        
        $this->addElement( 'select', 'test_id',array(
            'label' => 'Examen'
            
        )
                
        );
        
        $especialidad = new Application_Model_Tests();
        
        $this->test_id->addMultiOptions( 
                $especialidad->getAsKeyValue()
        );
        
        $this->addElement(
                'submit', 'Guardar', array()
        );
    }

}