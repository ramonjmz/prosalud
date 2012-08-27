<?php

class EspecialidadesController extends Zend_Controller_Action
{

    public function init()
    {
		 
    }

    public function publicAction()
    {
             $options = array( 'layout'   => 'layout');
		Zend_Layout::startMvc($options);
    }
    
    public function indexAction(){
    	
    	$specialtiesModel = new Application_Model_Specialties();
        
        
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('paginator/items.phtml');
        $paginator = Zend_Paginator::factory($specialtiesModel->fetchAll(null, array('name')));

        if ($this->_hasParam('page')) {
            $paginator->setCurrentPageNumber($this->_getParam('page'));
			$paginator->setItemCountPerPage(5);
                        
        }

        $this->view->paginator = $paginator;
    }

    public function updateAction() {

        if (!$this->_hasParam('id')) {
            return $this->_redirect('/especialidades/index');
        }


        $form = new Application_Form_Specialty();
        $data = new Application_Model_Specialties();

        if ($this->getRequest()->isPost()) {

            if ($form->isValid($this->_getAllParams())) {
                $model = new Application_Model_Specialties();
                $model->save($form->getValues(), $this->_getParam('id'));
                return $this->_redirect('/especialidades/');
            }
        } else {

            $row = $data->getRow($this->_getParam('id'));
            if ($row) {
                $form->populate($row->toArray());
            }
        }

        $this->view->form = $form;
    }
    
      public function deleteAction() {

        if (!$this->_hasParam('id')) {
            return $this->_redirect('/especialidades');
        }

        $items = new Application_Model_Specialties();
        $row = $items->getRow($this->_getParam('id'));

        if ($row) {
            $row->delete();
        }
        return $this->_redirect('/especialidades');
    }
    
 public function addAction() {

        $form = new Application_Form_Specialty();

        if ($this->getRequest()->isPost()) {

            if ($form->isValid($this->_getAllParams())) {
                $model = new Application_Model_Specialties();
                $model->save($form->getValues());
                return $this->_redirect('/especialidades');
            }
        }


        $this->view->form = $form;
    }
}

