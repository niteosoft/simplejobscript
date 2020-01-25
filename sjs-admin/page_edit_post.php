<?php

if ($id != 0)
	{
		$job = new Job($id);
	}
	else
	{
		$job = new Job();
	}

	$data = $job->GetInfo();
	$smarty->assign('job', $data);
	$cats = $job->getCategoriesWithIds();
	$job_types = $job->getJobTypesWithIds();
	if (REMOTE_PORTAL == 'deactivated') {
		//get cities
		$cities = $job->getCitiesWithId();
		$smarty->assign('cities', $cities);
	}

	
	if (strpos($_SERVER['HTTP_REFERER'], "inactive") !== false) {
		//inactive
		$smarty->assign('referer', 'inactive');
	} else {
		$smarty->assign('referer', 'active');
	}

	$smarty->assign('cats', $cats);
	$smarty->assign('types', $job_types);
	$smarty->assign('remote_portal', REMOTE_PORTAL);
	
	$smarty->assign('editor', true);
	$html_title = 'Edit job / ' . SITE_NAME;
	
	$template = 'edit-post.tpl';
?>
