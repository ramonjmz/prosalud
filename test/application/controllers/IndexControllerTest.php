<?php
class IndexControllerTest extends ControllerTestCase
{
	public function testIndexAction()
	{
		$this->dispatch('/');
		$this->assertController('index');
		$this->assertAction('index');
	}

	/*public function testErrorURL()
	{
		$this->dispatch('foo');
		$this->assertController('error');
		$this->assertAction('error');
	}

	public function testViewObjectContainsStringProperty()
	{
		$this->dispatch('/');

		$controller = new IndexController(
			$this->request,
			$this->response,
			$this->request->getParams()
			);

		$controller->indexAction();

		$this->assertTrue(isset($controller->view->string));
	}*/
}