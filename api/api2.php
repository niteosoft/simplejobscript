<?php
	require_once '../_config/config.php';
	require_once '../_lib/class.Api2.php';

	define('SJS_URL', str_replace('api/', '', BASE_URL));

	///////////////////////////////////////////////////////

	
	if (isset($_GET) && !empty($_GET))
	{
		$params = $_GET;

		$api = new Api2($params);
		echo $api->show();
	}
	else
	{
		echo 'not enough parameters...';
	}

	exit;
