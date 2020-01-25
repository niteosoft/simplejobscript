<?php

/* MAIN WEBSITE CONFIGURATION. */
$__instance = array(
		'protocol' => 'http://', // "http://" or "https://"
		'prefix' => '{DB_URL}', // main url of the app "domainname.com", without "http://" or "www"
		'db_host' => '{DB_HOST}',	//change localhost only if you connect to a remote database server
		'db_port' => '{DB_PORT}',
		'db_user' => '{DB_USER}',
		'db_password' => '{DB_PASSWORD}',
		'db_name' => '{DB_NAME}',
		// language to use
		'lang_code' => 'en',
		'plugins' => array('', '', '', '', '', ''), // list your plugins HERE, separated by comma ['plugin A', 'plugin B']
		'ini_error_reporting' => 0, /*1*/
		'ini_display_errors' => 'Off', /*On*/
		'location' => 'online', // change to "local" for development
		'environment' => 'prod', //change to "dev" for development
		'rewrite_mode' => 'apache_mod_rewrite' //works for nginx too
	);

/* DEFAULT TEMPLATE FOR INSTALLER
	'prefix' => '{DB_URL}', // main url of the app "domainname.com", without "http://" or "www"
	'db_host' => '{DB_HOST}',	//change localhost only if you connect to a remote database server
	'db_port' => '{DB_PORT}',
	'db_user' => '{DB_USER}',
	'db_password' => '{DB_PASSWORD}',
	'db_name' => '{DB_NAME}',
*/

/* ########################### CONSTANTS - DATABASE CONNECTIONS. PHP ENVIRONMENT AND URLS ################################## */

/* in case user puts slash at the end skip it */
if (substr($__instance['prefix'], -1) !== "/") 
	$append = "/";
else 
	$append = "";

/* in case there is no protocol set default */
if (strlen($__instance['protocol']) < 5)
	$__instance['protocol'] = "http://";

/* in case of www */
if (strpos($__instance['prefix'], "www.") !== false)
	$__instance['prefix'] = substr($__instance['prefix'], 4, strlen($__instance['prefix']));

ini_set('error_reporting', $__instance['ini_error_reporting']);
ini_set('display_errors', $__instance['ini_display_errors']);

$plugins = array();
$plugins =  $__instance['plugins'];

/* =========== WEBSITE ROUTING SETTINGS ======== */
// CRONJOB 
// 1. BASE_URL ("http://website.com") - used in templates and classes
// 2. PROTOCOL_URL ("http://website.com") - used in newsletter
// 3. MAIN_URL - for background emails
/*#######################################*/
// ADMIN
// 1. BASE_URL_ORIG ("website.com/") - used in links to frontend
// 2. BASE_URL ("website.com/sjs-admin/") - admin routing
/*#######################################*/
// MAIN APPLICATION
// 1. BASE_URL ("/") - used with assets, in templates
// 2. MAIN_URL ("website.com/") - used in emails, links to web
/*#######################################*/

$DIR_CONST = '';
if (defined('__DIR__'))
	$DIR_CONST = __DIR__;
else
	$DIR_CONST = dirname(__FILE__);

if (defined('CRON_JOB')) {
	define('PROTOCOL_URL', $__instance['protocol'] . $__instance['prefix'] . $append);
	define('BASE_URL', PROTOCOL_URL); // outlook and some browsers do not render links properly without http(s)://
	define('MAIN_URL', PROTOCOL_URL);
	return;
} else {

	if (strpos($_SERVER['REQUEST_URI'], "sjs-admin") === false) {
		define('BASE_URL', '/');
	}
	else {
		define('BASE_URL_ORIG', '/'); 
		define('BASE_URL', '/sjs-admin/'); 
	}
	define('MAIN_URL', $__instance['prefix'] . $append);
}

//installer
if( strpos($__instance['db_host'], "DB_HOST") ==! false)
{
	require_once('installer.php');
	exit;
}

?>
