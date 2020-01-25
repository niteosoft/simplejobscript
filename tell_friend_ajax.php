<?php

	require_once '_config/config.php';
	global $db;

	if (isset($_POST['data'])) {

		$explode = explode("|", $_POST['data']);
		$emailfrom = $db->getConnection()->real_escape_string($explode[0]);
		$emailto = $db->getConnection()->real_escape_string($explode[1]);
		$url = $explode[2];
		$mail = new Mailer();
		$result = $mail->tellAFriend($emailfrom, $emailto, $url);
		if ($result)
			echo json_encode(array('result' => '1'));
		else 
			echo json_encode(array('result' => '0'));
	} else {
		echo json_encode(array('result' => '0'));
	}
	exit;

?>