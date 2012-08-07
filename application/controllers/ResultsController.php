<?php
class ResultsController extends Zend_Controller_Action
{
	public function init(){
		$options = array( 'layout' => 'interno');
		Zend_Layout::startMvc($options);

	}
	
	public function restAction(){
		$this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();
        $responseJson = array();
        $resultsModel = new Application_Model_Results();
		if($this->getRequest()->isPost()){
			$result = $resultsModel->getRow($resultsModel->save($_POST["result"], $_POST["result"]["id"]));
			$responseJson["result"] =  $result;			
		}
		
        $this->getResponse()
            ->setHeader('Content-Type', 'application/json')
            ->setBody(json_encode($responseJson));
	}

	public function listJsonAction()
	{
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();

		$resultModel = new Application_Model_Results();
		$wheres = array();
		foreach ($_GET as $key => $value) {
			if($key === 'url'){
				continue;
			}
			$campoComparacion = explode("__", $key);
			$comparacion = count($campoComparacion) == 2 ? $campoComparacion[1] : "=";
			$wheres[$campoComparacion[0] . " ". $comparacion . " ?"] = $value;
		}

		$results = $resultModel->getBy($wheres);
		$json = array("result" => $results->toArray());
		$this->getResponse()
		->setHeader('Content-Type', 'application/json')
		->setBody(json_encode($json));
	}
}