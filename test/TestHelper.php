<?php

echo "defined APPLICATION_PATH:    " . defined('APPLICATION_PATH')."\n";
$realpath = realpath(dirname(__FILE__));
echo "realpath:    " . $realpath."\n";
//Define path to application directory
defined('APPLICATION_PATH') || define('APPLICATION_PATH', $realpath);

echo "defined APPLICATION_PATH:    " . defined('APPLICATION_PATH')."\n";
// Define application environment
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'testing'));

// Ensure library/ is on include_path
echo "APPLICATION_PATH:    " . APPLICATION_PATH."\n";
echo "include_path:    " . get_include_path()."\n";

set_include_path(implode(PATH_SEPARATOR, array(
	realpath(APPLICATION_PATH . '/../library'),
	get_include_path()
)));

echo "include_path:    " . get_include_path()."\n";
/** 
 * Register autoloader
 */

require_once 'Zend/Loader/Autoloader.php';
$autoloader = Zend_Loader_Autoloader::getInstance();

require_once APPLICATION_PATH . '/../test/application/ControllerTestCase.php';

?>