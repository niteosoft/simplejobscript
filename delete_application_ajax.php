<?php 
	
require_once '_config/config.php';

if (isset($_POST['app_id'])) {
	$class = new JobApplication();
	$mailer = new Mailer();

	$APP_ID = $_POST['app_id'];

	// change application status to hired
	$class->deleteJobApplicationById($APP_ID);

	echo json_encode(array('result' => '1'));
} else {
	echo json_encode(array('result' => '0'));
}
exit;
?>