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

		Zend_View_Helper_PaginationControl::setDefaultViewPartial('paginator/items.phtml');
		$paginator = Zend_Paginator::factory($model->getBy($wheres));

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

		if (!$this->_hasParam('id')) {
			return $this->_redirect('/analysis/index/page/1');
		}


		$form = new Application_Form_Analysis();
		$datos = new Application_Model_Analysis();
		$row = null;
		if ($this->getRequest()->isPost()) {

			if ($form->isValid($this->_getAllParams())) {
				$datos->save($form->getValues(), $this->_getParam('id'));
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

			$customer = $contact->getRow($data['applicant_id'])->toArray();
			$medico = $contact->getRow($data['medic_id'])->toArray();
				

			$this->_helper->layout->disableLayout();
			$this->_helper->viewRenderer->setNoRender();

			$pdf = new Zend_Pdf();

			$page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);
			$pdf->pages[] = $page;


			$fontT = Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_TIMES);
			$page->setFont($fontT, 16)
			->drawText('PROMOSERVICIOS DE SALUD S.A. DE C.V.', 145, 780);
			$page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 12);
			$page->drawText('Q.F.B. MICHAIA ELIAN RAMIREZ SANCHEZ', 180, 765);
			$page->drawText('CED. PROF. 4060358',240,750);

			$page->drawText('Calle Sur 15 No. 489',60,715);
			$page->drawText('Orizaba, Ver',60,700);
			$page->drawText('01 272 72 5 42 69',400,715);
			$page->drawText('prosalud2012@hotmail.com',400,700);

			$page->setLineWidth(0.5);
			$page->drawLine(60, 688, 550, 688);
			$page->setLineWidth(0.5);
			$page->drawLine(60, 690, 550, 690);

			$page->drawText('RESULTADOS DE LABORATORIO',200,670);


			$page->drawText('Nombre:',60,640);
			$page->drawText($customer['first_name'].' '.$customer['last_name'],110,640);
			$page->drawText('Fecha: '.date("d M Y"),400,640);

			$page->drawText('Edad:',60,625);
			$page->drawText(birthday($customer['birthdate']),100,625);

			$page->drawText('Genero:',400,625);
			$page->drawText($customer['gender'],450,625);

			$page->drawText('Medico:',60,610);
			$page->drawText($medico['first_name'].' '.$medico['last_name'],110,610);

			$page->drawText('Diagnostico:',60,590);

			$page->setLineWidth(0.5);
			$page->drawLine(60, 550, 550, 550);

			$page->drawText('Prueba',60,535);
			$page->drawText('Resultado',250,535);
			$page->drawText('U.M.',350,535);
			$page->drawText('Valores de Referencia',420,535);


			$page->setLineWidth(0.5);
			$page->drawLine(60, 530, 550, 530);



			$page->drawText('ATENTAMENTE',255,120);
			$page->setLineWidth(0.5);
			$page->drawLine(180, 65, 425, 65);
			$page->drawText('Q.F.B. MICHAIA ELIAN RAMIREZ SANCHEZ', 180, 50);


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

}