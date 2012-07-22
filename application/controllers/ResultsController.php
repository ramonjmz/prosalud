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
			$responseJson["result"] =  $resultsModel->save($_POST["result"], $_POST["result"]["id"]);			
		}
		
		//$json = array("result" => $contacts->toArray());
        $this->getResponse()
            ->setHeader('Content-Type', 'application/json')
            ->setBody(json_encode($responseJson));
	}
}