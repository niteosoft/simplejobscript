<?php
	$id = $_POST['job_id'];
	$j = new Job($id);
	$deactivator = $j->Deactivate($id);
	echo 1;
	exit;
?>