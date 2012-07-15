<?php

class ItemsController extends Zend_Controller_Action {

	public function init(){
	
		$options = array( 'layout'   => 'interno');
		Zend_Layout::startMvc($options);
		 
	}
	
 	public function listAction()
    {
        
        if( !$this->_hasParam('id')){
            return $this->_redirect('/items/');
        }
        
        $examen = new Application_Model_Items();
        
        $items = $examen->getAllNewsGroupById($this->_getParam('id'));
        
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('paginator/items.phtml');
        $paginator = Zend_Paginator::factory($items);

        if ($this->_hasParam('page')) {
            $paginator->setCurrentPageNumber($this->_getParam('page'));
        }

        $this->view->paginator = $paginator;

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


        $form = new Application_Form_Item();
        $items = new Application_Model_Items();

        if ($this->getRequest()->isPost()) {

            if ($form->isValid($this->_getAllParams())) {
                $model = new Application_Model_Items();
                $model->save($form->getValues(), $this->_getParam('id'));
                return $this->_redirect('/items');
            }
        } else {

            $row = $items->getRow($this->_getParam('id'));
            if ($row) {
                $form->populate($row->toArray());
            }
        }

        $this->view->form = $form;
    }

    public function indexAction() {

        $auth = Zend_Auth::getInstance();
        if (! $auth->hasIdentity()) {
            return $this->_redirect('/Auth/login');
        }

        $model = new Application_Model_Items();
        $items = $model->getAll();

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

}
