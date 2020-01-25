<?php

	require_once '_config/config.php';
	global $db;

	if (isset($_POST['msg_id'])) {
		 $explode = explode("|", $_POST['msg_id']);
		 $id = $explode[1];
		 $msg = $db->getConnection()->real_escape_string($explode[0]);

		 $class = new SpamReport($id);
		 $result = $class->insertNewReport($msg);

		 if ($result)
		 	echo json_encode(array('result' => '1'));
		 else 
		 	echo json_encode(array('result' => '0'));
	} else {
		echo json_encode(array('result' => '0'));
	}
	exit;

?>