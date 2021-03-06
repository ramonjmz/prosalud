<?php
class AnalysisController extends Zend_Controller_Action
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

	public function save( $bind, $id = null )
	{
		if( is_null( $id )){
			$row = $this->createRow();
		}else{
			$row = $this->getRow( $id );
		}

		$row->setFromArray( $bind );
		return $row->save();
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

		$auth = Zend_Auth::getInstance();

		if (!$this->_hasParam('id')) {
			return $this->_redirect('/analysis/index/page/1');
		}


		$form = new Application_Form_Analysis();
		$datos = new Application_Model_Analysis();
		$row = null;
		if ($this->getRequest()->isPost()) {

			if ($form->isValid($this->_getAllParams())) {
				$datos->save($form->getValues(), $this->_getParam('id'));

				$upload = $form->archivo->getTransferAdapter();

				$upload->addFilter('Rename', array('target' => APPLICATION_PATH . '/../public/files/'.$this->_getParam('id').'.pdf', 'overwrite' => true));

				var_dump( $upload->receive() );

				return $this->_redirect('/analysis/index/page/1');
			}



		} else {

			$row = $datos->getRowc($this->_getParam('id'));
			if ($row) {
				$form->populate($row->toArray());
				$this->view->headScript()->appendFile("/js/libs/ember-0.9.5.min.js");
				$this->view->headScript()->appendFile("/js/libs/ember-rest.js");
				$this->view->headScript()->appendFile("/js/Store.js");
				$this->view->headScript()->appendFile("/js/Prosalud.js");
				$this->view->headScript()->appendFile("/js/fields/TextField.js");
				$this->view->headScript()->appendFile("/js/models/ResultModel.js");
				$this->view->headScript()->appendFile("/js/models/AnalysisModel.js");
				$this->view->headScript()->appendFile("/js/models/TestModel.js");
				$this->view->headScript()->appendFile("/js/controllers/ResultsController.js");
				$this->view->headScript()->appendFile("/js/views/Result/ListView.js");
				$this->view->headScript()->appendFile("/js/views/Result/EditListView.js");
				$this->view->headScript()->appendFile("/js/controllers/TestsController.js");
				$this->view->headScript()->appendFile("/js/views/Tests/ListFilterResultView.js");

				$this->view->analysis = $row;
			}
		}

		$estudio = new Application_Model_Tests();
		$estudios = $estudio->getAll();

		Zend_View_Helper_PaginationControl::setDefaultViewPartial('paginator/items.phtml');
		///$paginator = Zend_Paginator::factory($datos->BySpecialties($this->_getParam('id')));

		/*	if ($this->_hasParam('page')) {
			$paginator->setCurrentPageNumber($this->_getParam('page'));
			$paginator->setItemCountPerPage(5);
			}

			$this->view->paginator = $paginator;
			*/

		$this->view->estudios = $estudios;

		if ($auth->getIdentity()->role === 'Paciente'){
			$form->setAction('');
			$form->removeElement('applicant_id');
			$form->getElement('status')->setAttrib('disabled', 'disabled');
			$form->getElement('medic_id')->setAttrib('disabled', 'disabled');
			$form->removeElement('Guardar');
		}

		$this->view->form = $form;
	}

	public function pdfAction()
	{
		require_once '/Zend/Pdf.php';
		require_once '/PS/utils.php';


		if (!$this->_hasParam('id')) {
			return $this->_redirect('/analysis/index/page/1');
		}

		$datos = new Application_Model_Analysis();

		$row = $datos->getRow($this->_getParam('id'));
		if($row){

			$data =$row->toArray();

			$contact = new Application_Model_Contacts();

			$results = new Application_Model_Results();


			$exa =$datos->BySpecialties($this->_getParam('id'));

			$customer = $contact->getRow($data['applicant_id'])->toArray();
			$medico = $contact->getRow($data['medic_id'])->toArray();



			$this->_helper->layout->disableLayout();
			$this->_helper->viewRenderer->setNoRender();


			//$pdf = new Zend_Pdf();
			if($data['name']==1)
			$pdf = Zend_Pdf::load('img/2.pdf');
			else
			$pdf = Zend_Pdf::load('img/1.pdf');
				
			$page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);
			//$pdf->pages[] = $page;

			$page=$pdf->pages[0];

			/*
			 //specify color
			 $color = new Zend_Pdf_Color_HTML("navy");
			 $page->setFillColor($color);
			 */
			$fontT = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
			$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 10);

			$page->drawText($customer['first_name'].' '.$customer['last_name'],125,712);
			$page->drawText(date('Y-m-d',strtotime ($data['date_entered'])),455,712);
			$page->drawText(birthday($customer['birthdate']),125,700);
			$page->drawText($customer['gender'],455,700);
			$page->drawText($medico['first_name'].' '.$medico['last_name'],125,685);

				
			$posY = 670;

			foreach($exa as $key) {

				$posY -= 50;

				$page->setLineWidth(0.5);
				$page->drawLine(50, $posY+15, 530, $posY+15);
				$page->setLineWidth(0.5);
				$page->drawLine(50, $posY-10, 530, $posY-10);
					
				$page->drawText('Examen', 50, $posY);
				$page->drawText('Resultado', 280, $posY);
				$page->drawText('U.M.', 360, $posY);
				$page->drawText('Valores de Referencia', 400, $posY);

				$page->drawText($key['name'], 50, $posY - 25);
				$res = $results->getBy(
				array(
				'analysis_id =?'=>$key['analysis_id'],
				'test_id =?'=>$key['itest_id']
				))->toArray();

				$posY -= 38.4;
					
				foreach ($res as $keyd){

					$page->drawText($keyd['item_name'], 60, $posY);
					$page->drawText($keyd['result'],280,$posY);
					$page->drawText($keyd['ref_val_unit'],350,$posY);
					$page->drawText($keyd['ref_val_value'],420,$posY);
					$posY -= 14.2;
				}
				$posY -= 20.2;
				$page->drawText('MUESTRA:',280,$posY);
				$page->drawText('METODO DE PROCESO:',280,$posY-14);
			}


			if($posY < 400){
				$page2 = new Zend_Pdf_Page($page);


				$pdf->pages[] = $page2;
			}

			$page->drawText('OBSERVACIONES:',50,170);
			$page->drawText($data['note'],50,155);
				

			$this->getResponse()
			->setHeader('Content-Disposition', 'attachment; filename=result.pdf')
			->setHeader('Content-type', 'application/x-pdf');

			echo $pdf->render();
		}


	}

	public function restAction(){
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout->disableLayout();
		$responseJson = array();
		$analysisModel = new Application_Model_Analysis();
		if($this->getRequest()->isPost()){
			$analysis = $analysisModel->getRow($analysisModel->save($_POST["analysis"], $_POST["analysis"]["id"]));

			$responseJson["analysis"] = $analysis->toArray();
		}

		$this->getResponse()
		->setHeader('Content-Type', 'application/json')
		->setBody(json_encode($responseJson));
	}

	public function downloadAction()
	{

		if (!$this->_hasParam('id')) {
			return $this->_redirect('/analysis/index/page/1');
		}

		$ids= $this->_hasParam('id');
		header('Content-type', 'application/x-pdf');
		header('Content-Disposition: attachment; filename="/../public/files/analysis'.$ids.'.pdf"');
		readfile('/../public/files/analysis'.$ids.'.pdf"');
			

		$this->view->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
	}


}