<?php 

	$AID = intval($id);
	global $db;
	$sql = 'SELECT fullname FROM applicant WHERE id=' . $AID;
	$result = $db->query($sql);
	$row = $result->fetch_assoc();
	
	// close the old session of there is any
	unset($_SESSION['applicant']); $_SESSION['applicant'] = null;
	unset($_SESSION['applicant_name']); $_SESSION['applicant_name'] = null;

	$_SESSION['applicant'] = $AID ;
	$_SESSION['applicant_name'] = $row['fullname'];
	redirect_to(BASE_URL_ORIG . URL_PROFILE);
?>