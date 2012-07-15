<?php

class Application_Form_Specialty extends Zend_Form {

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
        
        $this->addElement(
                'submit', 'Guardar', array()
        );
    }

}