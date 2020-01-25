<?php 

	// close the old session of there is any
	unset($_SESSION['user']); $_SESSION['user'] = null;
	unset($_SESSION['name']); $_SESSION['name'] = null;

	$_SESSION['user'] = intval($id);
	$_SESSION['name'] = urldecode($extra);
	redirect_to(BASE_URL_ORIG . URL_DASHBOARD);
?>