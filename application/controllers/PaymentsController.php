<?php

class PaymentsController extends Zend_Controller_Action
{

	 
	public function init(){


	}

	public function indexAction()
	{
		/* Initialize action controller here */
	}

	public function detailAction(){
		 
	}

	public function addAction(){
		 
		if (!$this->_hasParam('id')) {
			return $this->_redirect('/analysis/index/page/1');
			
		}

		$convert = new Application_Model_Letras();
		
		$model = new Application_Model_Payments();
				
		$datos = new Application_Model_Analysis();

		$row = $datos->getRow($this->_getParam('id'));
		if($row){

			$data =$row->toArray();
			$exa =$datos->BySpecialties($this->_getParam('id'));
			$monto =0;
 			foreach($exa as $key) {
		 
 				 $monto = $monto +$key['amount'];
			}
			
			$model->save();
			

			$this->view->paginator = $exa;

			$this->view->letras =$convert->num2letras($monto) ;
			$this->view->monto = $monto;
			

		}
		 
	}
}

