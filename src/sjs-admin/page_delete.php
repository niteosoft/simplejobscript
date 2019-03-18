<?php
	$j = new Job($_POST['job_id']);
	clear_main_cache();
	clear_tpl_cache_admin('default');
	if($j->DeleteJobAdmin())
		echo 1;
	else
		echo "0";
	exit;
?>