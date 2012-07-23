<?php
class ReferencesController extends Zend_Controller_Action
{
	public function init(){
		
		$options = array( 'layout'   => 'interno');
		Zend_Layout::startMvc($options);
	}

	public function addAction() {
		
		$form = new Application_Form_Reference();

		if ($this->getRequest()->isPost()) {

			if ($form->isValid($this->_getAllParams())) {
				$model = new Application_Model_References();
				$model->save($form->getValues());
				return $this->_redirect('/references');
			}
		}


		$this->view->ref = $form;
	}


	    public function deleteAction() {

        if (!$this->_hasParam('id')) {
            return $this->_redirect('/references');
        }

        $reference = new Application_Model_References();
        $row = $reference->getRow($this->_getParam('id'));

        if ($row) {
            $row->delete();
        }
        return $this->_redirect('/references');
    }

    public function detailAction() {

        if (!$this->_hasParam('id')) {
            return $this->_redirect('/');
        }

        $reference = new Application_Model_References();
        $post = $reference->getRow($this->_getParam('id'));

        if (!$post) {
            return $this->_redirect('/');
        }

        $this->view->post = $post;
    }

    public function updateAction() {

        if (!$this->_hasParam('id')) {
            return $this->_redirect('/references');
        }


        $form = new Application_Form_Reference();
        $references = new Application_Model_References();

        if ($this->getRequest()->isPost()) {

            if ($form->isValid($this->_getAllParams())) {
                $model = new Application_Model_References();
                $model->save($form->getValues(), $this->_getParam('id'));
                return $this->_redirect('/references');
            }
        } else {

            $row = $references->getRow($this->_getParam('id'));
            if ($row) {
                $form->populate($row->toArray());
            }
        }

        $this->view->ref = $form;
    }

    public function indexAction() {
		
    	$auth = Zend_Auth::getInstance();
        if (! $auth->hasIdentity()) {
            return $this->_redirect('/auth/login');
        }
  
        $model = new Application_Model_References();

          Zend_View_Helper_PaginationControl::setDefaultViewPartial('paginator/items.phtml');
        $paginator = Zend_Paginator::factory($model->getAll());

        if ($this->_hasParam('page')) {
            $paginator->setCurrentPageNumber($this->_getParam('page'));
            $paginator->setItemCountPerPage(5);
        }
        
        $this->view->paginator = $paginator;
        
 
    }
    
	public function listAction()
    {
        
        if( !$this->_hasParam('id')){
            return $this->_redirect('/references/');
        }
        
        $items = new Application_Model_References();
        
        $item = $items->getAllNewsGroupById($this->_getParam('id'));
        
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('paginator/items.phtml');
        $paginator = Zend_Paginator::factory($item);

        if ($this->_hasParam('page')) {
            $paginator->setCurrentPageNumber($this->_getParam('page'));
        }

        $this->view->paginator = $paginator;

    }

    public function listJsonAction()
    {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();

        $referencesModel = new Application_Model_References();
        $wheres = array();
        $orWheres = array();
        $params = $this->_request->getParams();
        unset($params['controller']);
        unset($params['action']);
        unset($params['module']);
        //echo print_r($params) ;
        foreach ($params as $key => $value) {
            
            $campoComparacion = explode("__", $key);
            if($campoComparacion[1] === "or"){
                $orWheres[$campoComparacion[0] . " ". $comparacion . " ?"] = $value;
            }else{
                $comparacion = count($campoComparacion) > 1 ? $campoComparacion[1] : "=";
                if(count($campoComparacion) === 3){
                    if($campoComparacion[2] === "or")
                        $orWheres[$campoComparacion[0] . " ". $comparacion . " ?"] = $value;
                }else{                     

                    $wheres[$campoComparacion[0] . " ". $comparacion . (is_array($value)?" (?)": " ?")] = $value;
                }
            }
        }
        //echo print_r($wheres, true);
        $reference = $referencesModel->getBy($wheres, $orWheres);
        $json = array("references" => $reference->toArray());
        $this->getResponse()
            ->setHeader('Content-Type', 'application/json')
            ->setBody(json_encode($json));
    }
	
}




