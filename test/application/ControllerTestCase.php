<?php
class ControllerTestCase extends Zend_Test_PHPUnit_ControllerTestCase
{
	public $_application;

	public function setUp()
	{
		$this->bootstrap = array($this, 'appBootstrap');
        parent::setUp();

		

	}

	public function tearDown()
	{
			//Zend_Db_Table::getDefaultAdapter()->closeConnection();
			parent::tearDown();
	}

	public function appBootstrap()
	{
		$this->_application = new Zend_Application(
			APPLICATION_ENV,
			APPLICATION_PATH.'/configs/application.ini'
			);


		$this->_application->bootstrap();

		$front = Zend_Controller_Front::getInstance();
        if($front->getParam('bootstrap') === null) {
            $front->setParam('bootstrap', $this->_application->getBootstrap());
        }
	}
}