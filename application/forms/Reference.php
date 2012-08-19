<?php

class Application_Form_Reference extends Zend_Form {

    public function init() {
    	
    	$this->setAttrib('id', 'references-form');
    	
    	
    	$this->addElement(
                'text', 'name', array(
            'label' => 'Nombre',
            'required' => false
                )
        );

        $this->addElement(
                'text', 'value', array(
            'label' => 'Referencia',
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
		
		      		$this->addElement('textarea', 'description', array(
            'label'      => 'Escriba un comentario:',
         		'rows' => '5', 
             'validators' => array(
                array('validator' => 'StringLength', 'options' => array(0, 100))
                )
        ));
        
        
        
               	 $this->addElement( 'select', 'type', array(
		'label' => 'Tipo de prueba',
		 'required' => true,
		'multiOptions' => array('A'=> 'Valor Absoluto','R'=> 'Referencia','D' => 'Descripcion')
		)
		);
        
 
        $this->addElement(
                'submit', 'Guardar', array()
        );
    }

}