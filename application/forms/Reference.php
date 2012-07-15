<?php

class Application_Form_Reference extends Zend_Form {

    public function init() {

        $this->addElement(
                'text', 'value', array(
            'label' => 'Valor de referencia',
            'required' => true
                )
        );

        $this->addElement(
                'text', 'unit', array(
            'label' => 'Unidad de medida'
                )
        );
        
  
        		 $this->addElement( 'select', 'gender', array(
		'label' => 'Tipo',
		 'required' => true,
		'multiOptions' => array('A'=> 'Ambos','M' => 'Masculino','F'
		=> 'Femenino')
		)
		);
		
		       $this->addElement(
                'text', 'description', array(
            'label' => 'Descripcion'
                )
        );
        
          $this->addElement(
                'text', 'item_id', array(
            'label' => 'id de prueba',
            		 'required' => true,
            
                )
        );
        
               $this->addElement(
                'text', 'type', array(
            'label' => 'Tipo de Prueba'            
                )
        );
        

        /*
        $this->addElement( 'select', 'item_id',array(
            'label' => 'Prueba'
            
        )
                
        );
		
		
        
        $especialidad = new Application_Model_Specialties();
        
        $this->specialty_id->addMultiOptions( 
                $especialidad->getAsKeyValue()
        );
        */
        $this->addElement(
                'submit', 'Guardar', array()
        );
    }

}