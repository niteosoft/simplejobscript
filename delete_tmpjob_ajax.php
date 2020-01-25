<?php 
	
require_once '_config/config.php';

if (isset($_POST['job_id'])) {
	$class = new Job();
	$class->deleteById($_POST['job_id']);
} 

exit;
?>