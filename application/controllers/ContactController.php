<?php
class ContactController extends Zend_Controller_Action
{

	public function init(){

		$options = array( 'layout' => 'interno');
		Zend_Layout::startMvc($options);


	}

	public function addAction() {


		$options = array( 'layout' => 'layout');
		Zend_Layout::startMvc($options);


		$form = new Application_Form_Person();

		if ($this->getRequest()->isPost()) {

			if ($form->isValid($this->_getAllParams())) {
				$model = new Application_Model_Contacts();
				$model->save($form->getValues());
				
				return $this->_redirect('/contact/index/page/1');
			}
		}
		
		
		$this->view->form = $form;
	}

	public function newAction() {


		$options = array( 'layout' => 'interno');
		Zend_Layout::startMvc($options);


		$form = new Application_Form_Contact();

		if ($this->getRequest()->isPost()) {

			if ($form->isValid($this->_getAllParams())) {
				$model = new Application_Model_Contacts();
				$model->save($form->getValues());
				return $this->_redirect('/contact/index/page/1');
			}
		}


		$this->view->form = $form;
	}


	public function deleteAction() {

		if (!$this->_hasParam('id')) {
			return $this->_redirect('/contact/index/page/1');
		}

		$posts = new Application_Model_Contacts();
		$row = $posts->getRow($this->_getParam('id'));

		if ($row) {
			$row->delete();
		}
		return $this->_redirect('/contact/index/page/1');
	}

	public function verAction() {

		if (!$this->_hasParam('id')) {
			return $this->_redirect('/');
		}

		$posts = new Application_Model_Contacts();
		$post = $posts->getRow($this->_getParam('id'));

		if (!$post) {
			return $this->_redirect('/');
		}

		$this->view->post = $post;
	}

	public function updateAction() {

		if (!$this->_hasParam('id')) {
			return $this->_redirect('/contact/index/page/1');
		}


		$form = new Application_Form_Contact();
		$persons = new Application_Model_Contacts();

		if ($this->getRequest()->isPost()) {

			if ($form->isValid($this->_getAllParams())) {
				$model = new Application_Model_Contacts();
				$model->save($form->getValues(), $this->_getParam('id'));
				return $this->_redirect('/contact/index/page/1');
			}
		} else {

			$row = $persons->getRow($this->_getParam('id'));
			if ($row) {
				$form->populate($row->toArray());
			}
		}

		$this->view->form = $form;
	}

	public function indexAction() {

		$auth = Zend_Auth::getInstance();
		if (! $auth->hasIdentity()) {
			return $this->_redirect('/auth/login');
		}

		$model = new Application_Model_Contacts();

		Zend_View_Helper_PaginationControl::setDefaultViewPartial('paginator/items.phtml');
		$paginator = Zend_Paginator::factory($model->getAll());

		if ($this->_hasParam('page')) {
			$paginator->setCurrentPageNumber($this->_getParam('page'));
			$paginator->setItemCountPerPage(5);
		}

		$this->view->paginator = $paginator;


	}

	public function listJsonAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();

		$contacsModel = new Application_Model_Contacts();
		$wheres = array();
		$orWheres = array();
		foreach ($_GET as $key => $value) {
			if($key === 'url'){
				continue;
			}
			$campoComparacion = explode("__", $key);

			$comparacion = count($campoComparacion) > 1 ? $campoComparacion[1] : "=";
			if(count($campoComparacion) === 3){
				if($campoComparacion[2] === "or")
				$orWheres[$campoComparacion[0] . " ". $comparacion . " ?"] = $value;
			}else{
				$wheres[$campoComparacion[0] . " ". $comparacion . " ?"] = $value;
			}
		}
		//echo print_r($wheres, true);
		$contacts = $contacsModel->getBy($wheres, $orWheres);
		$json = array("result" => $contacts->toArray());
		$this->getResponse()
		->setHeader('Content-Type', 'application/json')
		->setBody(json_encode($json));
	}
	
	

}




