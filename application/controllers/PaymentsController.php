<?php

class PaymentsController extends Zend_Controller_Action
{

   
	public function init(){

		$options = array( 'layout'   => 'interno');
		Zend_Layout::startMvc($options);
			

	}

	 public function indexAction()
    {
        /* Initialize action controller here */
    }
	
    public function detailAction(){
    	
    }
}

