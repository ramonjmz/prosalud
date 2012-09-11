<?php

class PaymentsController extends Zend_Controller_Action
{


	public function init(){

				Zend_Loader_Autoloader::getInstance()->suppressNotFoundWarnings(false);
		//$options = array( 'layout' => 'interno');
		//Zend_Layout::startMvc($options);

	}

	public function indexAction()
	{
	//include_once('PS/Filtrador.php');

		//display_errors("1");
		$auth = Zend_Auth::getInstance();
		if (! $auth->hasIdentity()) {
			return $this->_redirect('/auth/login');
		}

		$model = new Application_Model_Analysis();

		//echo print_r($this->_getAllParams());
		$filtrador = new PS_Filtrador($model, $this->_getAllParams());

		$wheres = $filtrador->getFiltros();
		if($auth->getIdentity()->role === 'Medico'){
			$wheres['medic_id = ?'] = $auth->getIdentity()->contact_id;
		}
		else if ($auth->getIdentity()->role === 'Paciente'){
			$wheres['applicant_id = ?'] = $auth->getIdentity()->contact_id;
		}


		Zend_View_Helper_PaginationControl::setDefaultViewPartial('paginator/items.phtml');
		$paginator = Zend_Paginator::factory($model->getBy($wheres));

		if ($this->_hasParam('page')) {
			$paginator->setCurrentPageNumber($this->_getParam('page'));
			$paginator->setItemCountPerPage(5);
		}

		$this->view->paginator = $paginator;

		$this->view->params = $this->_getAllParams();
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

			$contact = new Application_Model_Contacts();
				
			$customer = $contact->getRow($data['applicant_id'])->toArray();
			
			$paciente = $customer['first_name'].' '.$customer['last_name'];

			 
			$exa =$datos->BySpecialties($this->_getParam('id'));
			$monto =0;
			foreach($exa as $key) {
					
				$monto = $monto +$key['amount'];
			}

			$model->save();


			$this->view->paginator = $exa;

			$this->view->letras =$convert->num2letras($monto) ;
			$this->view->paciente =$paciente;
			$this->view->data=$data;
			$this->view->monto = $monto;


		}
			
	}
}

