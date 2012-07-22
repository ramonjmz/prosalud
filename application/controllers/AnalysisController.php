<?php
class AnalysisController extends Zend_Controller_Action
{
	public function init(){

		$options = array( 'layout' => 'interno');
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
		$cform =new Application_Form_Person();


		$especialidad = new Application_Model_Specialties();
		$especialidades = $especialidad->getAll();

		$this->view->form =$form;
		$this->view->especialidades = $especialidades;

		$this->view->cform =$cform;
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

		$estudio = new Application_Model_Tests();
		$estudios = $estudio->getAll();

		$this->view->estudios = $estudios;
			
		$this->view->form = $form;
	}

	public function pdfAction()
	{
		require_once '/Zend/Pdf.php';

		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender();

		$pdf = new Zend_Pdf();

		// Add new page to the document
		$page = $pdf->newPage(Zend_Pdf_Page::SIZE_A4);
		$pdf->pages[] = $page;

		// Set font

		// Draw text
		/*	$page->setFillColor(Zend_Pdf_Color_Html::color('#990000'))
		 ->drawText('Hello world (in red)!', 60, 700);*/

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

		$page->drawText('Nombre:',60,640);
		$page->drawText('Fecha: '.date("d M Y"),400,640);

		$page->drawText('Edad:',60,625);
		$page->drawText('Sexo:',400,625);

		$page->drawText('Domicilio:',60,610);
		$page->drawText('Medico:',60,595);

		$page->drawText('Diagnostico:',60,565);

		$page->setLineWidth(0.5);
		$page->drawLine(60, 550, 550, 550);

		$page->drawText('EXAMENES REALIZADOS:',60,535);

		$page->setLineWidth(0.5);
		$page->drawLine(60, 530, 550, 530);


		$page->drawText('Prueba:',60,475);
		$page->drawText('Resultado:',250,475);
		$page->drawText('Valores de Referencia:',400,475);

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