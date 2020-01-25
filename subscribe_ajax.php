<?php

	require_once '_config/config.php';
	global $db;

	if (isset($_POST['data'])) {

		 $explode = explode("|", $_POST['data']);
		 $email = $db->getConnection()->real_escape_string($explode[0]);
		 $category_id = $explode[1];
		 //create entries, send intro message + subscribe confirmation
		 $class = new Subscriber($email, $category_id, false, true);
	 	 echo json_encode(array('result' => '1'));

	} else {
		echo json_encode(array('result' => '0'));
	}
	exit;
?>