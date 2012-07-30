<?php

class ItemsController extends Zend_Controller_Action {

	public function init(){

		$options = array( 'layout' => 'interno');
		Zend_Layout::startMvc($options);

	}

	public function deleteAction() {

		if (!$this->_hasParam('id')) {
			return $this->_redirect('/items');
		}

		$items = new Application_Model_Items();
		$row = $items->getRow($this->_getParam('id'));

		if ($row) {
			$row->delete();
		}
		return $this->_redirect('/items');
	}

	public function verAction() {

		if (!$this->_hasParam('id')) {
			return $this->_redirect('/');
		}

		$tests = new Application_Model_Items();
		$item = $tests->getRow($this->_getParam('id'));

		if (!$item) {
			return $this->_redirect('/');
		}

		$this->view->test = $item;
	}

	public function updateAction() {

		if (!$this->_hasParam('id')) {
			return $this->_redirect('/items');
		}


		
		$items = new Application_Model_Items();

		if ($this->getRequest()->isPost()) {

			if ($form->isValid($this->_getAllParams())) {
				$model = new Application_Model_Items();
				$model->save($form->getValues(), $this->_getParam('id'));
				return $this->_redirect('/items');
			}
		} else {

			$row = $items->getRow($this->_getParam('id'));			

			$this->view->headScript()->appendFile("/js/libs/ember-0.9.5.min.js");
			$this->view->headScript()->appendFile("/js/libs/ember-rest.js");
			$this->view->headScript()->appendFile("/js/Store.js");
			$this->view->headScript()->appendFile("/js/Prosalud.js");
			$this->view->headScript()->appendFile("/js/models/ItemModel.js");
			$this->view->headScript()->appendFile("/js/models/TestModel.js");
			$this->view->headScript()->appendFile("/js/controllers/ItemsController.js");
			$this->view->headScript()->appendFile("/js/controllers/TestsController.js");
			$this->view->headScript()->appendFile("/js/views/Items/EditView.js");

			$this->view->item = $row;
		}
				
		
	}

	public function indexAction() {

		$auth = Zend_Auth::getInstance();
		if (! $auth->hasIdentity()) {
			return $this->_redirect('/Auth/login');
		}

		$model = new Application_Model_Items();

		if(!$this->_hasParam('id')){
			$items = $model->getAll();
		}else{
			$items = $model->getAllNewsGroupById($this->_getParam('id'));
		}
		
		Zend_View_Helper_PaginationControl::setDefaultViewPartial('paginator/items.phtml');
		$paginator = Zend_Paginator::factory($items);

		if ($this->_hasParam('page')) {
			$paginator->setCurrentPageNumber($this->_getParam('page'));
			$paginator->setItemCountPerPage(5);

		}

		$this->view->paginator = $paginator;
	}
	 
	public function agregarAction() {

		$form = new Application_Form_Item();

		if ($this->getRequest()->isPost()) {

			if ($form->isValid($this->_getAllParams())) {
				$model = new Application_Model_Items();
				$model->save($form->getValues());
				return $this->_redirect('/items');
			}
		}


		$this->view->form = $form;
	}

	public function listJsonAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();

		$itemModel = new Application_Model_Items();
		$wheres = array();
		foreach ($_GET as $key => $value) {
			$campoComparacion = explode("__", $key);
			$comparacion = count($campoComparacion) == 2 ? $campoComparacion[1] : "=";
			$wheres[$campoComparacion[0] . " ". $comparacion . " ?"] = $value;
		}

		$items = $itemModel->getBy($wheres);
		$json = array("result" => $items->toArray());
		$this->getResponse()
		->setHeader('Content-Type', 'application/json')
		->setBody(json_encode($json));
	}
}