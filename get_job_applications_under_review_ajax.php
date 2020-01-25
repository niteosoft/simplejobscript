<?php

	require_once '_config/config.php';
	global $db;

	if (isset($_POST['job_id'])) {

		//remember the select state
		if (isset($_SESSION['JOB_ID'])) {
			unset($_SESSION['JOB_ID']);
			$_SESSION['JOB_ID'] = null;
		}
		$_SESSION['JOB_ID'] = $_POST['job_id'];

		$class = new JobApplication();
		$apps = $class->getJobApplicationsUnderReviewByJobId($_POST['job_id'], $_SESSION['user']);
		//$html = '';

		if (empty($apps)){
			echo json_encode(array('result' => '0'));
			exit;
		}

		echo json_encode(array('result' => $apps));
	} else {
		echo json_encode(array('result' => '0'));
	}
	exit;

?>