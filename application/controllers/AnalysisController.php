<?php
class AnalysisController extends Zend_Controller_Action
{
    public function init(){
    	
    	$options = array( 'layout'   => 'interno');
		Zend_Layout::startMvc($options);
		 
    }
	
	public function indexAction()
    {
    	
    	$auth = Zend_Auth::getInstance();
        if (! $auth->hasIdentity()) {
            return $this->_redirect('/auth/login');
        }
  
        $model = new Application_Model_Analysis();

          Zend_View_Helper_PaginationControl::setDefaultViewPartial('paginator/items.phtml');
        $paginator = Zend_Paginator::factory($model->getAll());

        if ($this->_hasParam('page')) {
            $paginator->setCurrentPageNumber($this->_getParam('page'));
            $paginator->setItemCountPerPage(5);
        }
        
        $this->view->paginator = $paginator;
        
    }
    
    public function testsbyanalysis(){
    	
    }
    
    public function addAction(){
    	$form =new Application_Form_Analysis();
        $especialidad = new Application_Model_Specialties();
        $especialidades = $especialidad->getAll();
    	$this->view->form =$form;
        $this->view->headScript()->appendFile("/js/libs/ember-0.9.5.min.js");
        $this->view->headScript()->appendFile("/js/libs/ember-rest.js");
        $this->view->headScript()->appendFile("/js/models/Prueba.js");
        $this->view->especialidades = $especialidades;
    	
    }
    
    public function save(){
    	
    }
    
 	public function deleteAction() {

        if (!$this->_hasParam('id')) {
            return $this->_redirect('/analysis/index/page/1');
        }

        $data = new Application_Model_Analysis();
        $row = $data->getRow($this->_getParam('id'));

        if ($row) {
            $row->delete();
        }
        return $this->_redirect('/analysis/index/page/1');
    }
    
  	public function updateAction() {

        if (!$this->_hasParam('id')) {
            return $this->_redirect('/analysis/index/page/1');
        }


        $form = new Application_Form_Analysis();
        $datos = new Application_Model_Analysis();

        if ($this->getRequest()->isPost()) {

            if ($form->isValid($this->_getAllParams())) {
                $model = new Application_Model_Analysis();
                $model->save($form->getValues(), $this->_getParam('id'));
                return $this->_redirect('/analysis/index/page/1');
            }
        } else {

            $row = $datos->getRow($this->_getParam('id'));
            if ($row) {
                $form->populate($row->toArray());
            }
        }

        $this->view->form = $form;
    }
}