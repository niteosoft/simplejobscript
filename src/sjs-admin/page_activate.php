<?php
	$em = new Employer();
	$j = new Job($_POST['job_id']);
	$activator = $j->Activate();
	$data = $j->GetInfo();

	$mailer = new Mailer();
	$mailer->employerJobActivated($data, PROTOCOL_URL, $em->getEmployerEmail($data['employer_id']));
	echo 1;
	exit;
?>
