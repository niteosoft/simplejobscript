<?php

	require_once '_config/config.php';
	global $db;

	if (isset($_POST['data'])) {

		$explode = explode("|", $_POST['data']);
		$cv = $db->getConnection()->real_escape_string($explode[0]);
		$emailto = $db->getConnection()->real_escape_string($explode[1]);
		$msg = $explode[2];

		$class = new Employer();
		$emailFrom = $class->getEmployerEmail($_SESSION['user']);

		$mail = new Mailer();
		$result = $mail->shareApplicant($emailFrom, $emailto, $msg, $cv);
		if ($result)
			echo json_encode(array('result' => '1'));
		else 
			echo json_encode(array('result' => '0'));
	} else {
		echo json_encode(array('result' => '0'));
	}
	exit;

?>