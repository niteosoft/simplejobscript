<?php

require_once '_config/config.php';

escape($_POST);

$class = new Applicant();
$exists = $class->checkIfUserExists($email);

if (!$exists) {
	echo json_encode(array('result' => '0'));
	exit;
} else {
	//send an email
	$user_id = $class->getId();
	$resetHash = md5(time() . $email . $user_id);

	$class->createResetPasswordEntry($user_id, $resetHash);

	$mailer = new Mailer();
	$result = $mailer->sendPasswordRecoveryEmail($email, $resetHash, URL_RESET_PASSWORD_APPLICANTS);

	echo json_encode(array('result' => '1'));
	exit;
}


?>
