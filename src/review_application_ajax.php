<?php 
	
require_once '_config/config.php';

if (isset($_POST['app_id'])) {
	$class = new JobApplication();
	$mailer = new Mailer();

	$APP_ID = $_POST['app_id'];

	// change application status to rejected
	$class->reviewApplication($APP_ID);

	// get candidate email and job id
	$data = $class->getCandidateDataByJobApplicationId($APP_ID);

	$job = new Job($data['job_id']);
	$job_data = $job->GetInfo();

	// notify him
	$mailer->reviewCandidateApplication($data['candidate_email'], $job_data);

	echo json_encode(array('result' => '1'));
} else {
	echo json_encode(array('result' => '0'));
}
exit;
?>