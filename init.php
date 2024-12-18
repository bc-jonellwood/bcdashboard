<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

ob_start(); // output buffering is turned on
//session_start(); // turn on sessions
// Assign file paths to PHP constants
// __FILE__ returns the current path to this file
// dirname() returns the path to the parent directory

define("PRIVATE_PATH", dirname(__FILE__));
define("PROJECT_PATH", dirname(PRIVATE_PATH));
define("PUBLIC_PATH", PROJECT_PATH . '/public');
define("FUNCTION_PATH", PRIVATE_PATH . '/function/');
define("COMPONENT_PATH", PRIVATE_PATH . '/components/');
define("API_PATH", PRIVATE_PATH . '/API/');
define("CLASS_PATH", PRIVATE_PATH . '/classes/');
define("VENDOR_PATH", PRIVATE_PATH . '/vendor/');

// Assign the root URL to a PHP constant
// * Do not need to include the domain
// * Use same document root as webserver
// * Can set a hardcoded value:
// define("WWW_ROOT", '/~kevinskoglund/globe_bank/public');
// define("WWW_ROOT", '');
// * Can dynamically find everything in URL up to "/public"
$public_end = strpos($_SERVER['SCRIPT_NAME'], '/public') + 7;
$doc_root = substr($_SERVER['SCRIPT_NAME'], 0, $public_end);
define("WWW_ROOT", $doc_root);
// require_once(INCLUDE_PATH . 'allowed_params.inc.php');
// require_once(INCLUDE_PATH . 'functions.inc.php');
//require_once(INCLUDE_PATH . 'session.inc.php');
// require_once(INCLUDE_PATH . 'autoloader.inc.php');
require_once(VENDOR_PATH . 'autoload.php');
// require_once(CLASS_PATH . 'sanatize.class.php');


//Setting the current data and time
$date = new DateTime("now", new DateTimeZone('America/New_York'));

$currentDate = $date->format('m/d/yy h:i');
define("Current_Date",  $currentDate);


//$db = db_connect();
$errors = [];

// include_once 'include/session.inc.php';
// is_session_valid();
