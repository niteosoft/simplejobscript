<?php 

	$the_jobs = $job->GetPaginatedJobs(0, RELATED_JOBS_PER_PAGE, 0, false);	
	$smarty->assign('more_jobs', $the_jobs);
?>