<?php
/** Zend_Application */
require_once 'Zend_Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
	APPLICATION_ENV,
	APPLICATION_PATH.'/configs/application.ini'
);

$application->bootstrap();
?>