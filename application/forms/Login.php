<?php

class Application_Form_Login extends Zend_Form 
{

    public function init() 
    {

        $this->addElement(
            'text', 'username', array(
                'label' => 'Usuario:',
                'required' => true
            )
        );

        $this->addElement(
            'password', 'password', array(
                'label' => 'Password:',
                'required' => true
            )
        );

        $this->addElement(
                'submit', 'Ingresar', array()
        );
    }

}