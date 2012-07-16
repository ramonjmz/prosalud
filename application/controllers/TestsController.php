<?php

class TestsController extends Zend_Controller_Action {

	public function init(){
	$options = array( 'layout'   => 'interno');
		Zend_Layout::startMvc($options);
		 
	}
	
    public function deleteAction() {

        if (!$this->_hasParam('id')) {
            return $this->_redirect('/tests/');
        }

        $tests = new Application_Model_Tests();
        $row = $tests->getRow($this->_getParam('id'));

        if ($row) {
            $row->delete();
        }
        return $this->_redirect('/tests/');
    }

    public function verAction() {

        if (!$this->_hasParam('id')) {
            return $this->_redirect('/');
        }

        $tests = new Application_Model_Tests();
        $test = $tests->getRow($this->_getParam('id'));

        if (!$test) {
            return $this->_redirect('/');
        }

        $this->view->test = $test;
    }

    public function updateAction() {

        if (!$this->_hasParam('id')) {
            return $this->_redirect('/tests/');
        }


        $form = new Application_Form_Test();
        $tests = new Application_Model_Tests();

        if ($this->getRequest()->isPost()) {

            if ($form->isValid($this->_getAllParams())) {
                $model = new Application_Model_Tests();
                $model->save($form->getValues(), $this->_getParam('id'));
                return $this->_redirect('/tests/');
            }
        } else {

            $row = $tests->getRow($this->_getParam('id'));
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

        $model = new Application_Model_Tests();
        $tests = $model->getAll();

        Zend_View_Helper_PaginationControl::setDefaultViewPartial('paginator/items.phtml');
        $paginator = Zend_Paginator::factory($tests);

        if ($this->_hasParam('page')) {
            $paginator->setCurrentPageNumber($this->_getParam('page'));
                        $paginator->setItemCountPerPage(5);
            
        }

        $this->view->paginator = $paginator;
    }

    public function agregarAction() {

        $form = new Application_Form_Test();

        if ($this->getRequest()->isPost()) {

            if ($form->isValid($this->_getAllParams())) {
                $model = new Application_Model_Tests();
                $model->save($form->getValues());
                return $this->_redirect('/tests/');
            }
        }


        $this->view->form = $form;
    }
    
 	public function listAction()
    {
        
        if( !$this->_hasParam('id')){
            return $this->_redirect('/tests/');
        }
        
        $especialidad = new Application_Model_Tests();
        
        $news = $especialidad->getAllNewsBySpecialtyId($this->_getParam('id'));
        
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('paginator/items.phtml');
        $paginator = Zend_Paginator::factory($news);

        if ($this->_hasParam('page')) {
            $paginator->setCurrentPageNumber($this->_getParam('page'));
        }

        $this->view->paginator = $paginator;

    }

    public function listJsonAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();
        $json = array(
            "results" => array(
                array(
                    "id" => "1",
                    "name" => "x"

                ),
                array(
                    "id" => "2",
                    "name" => "y"

                ),
                array(
                    "id" => "3",
                    "name" => "z"

                ),
                array(
                    "id" => "4",
                    "name" => "yo"

                )
            )
        );
        $this->getResponse()
            ->setHeader('Content-Type', 'application/json')
            ->setBody(json_encode($json));
    }

}
