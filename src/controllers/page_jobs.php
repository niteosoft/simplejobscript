<?php
	$uri = '';
	
	if ($id)
	{
		$uri = $id;
	}
	
	$allJobsRequested = false;
	$jobsPerCategoryRequested = false;
	$cat = false;
	
	if ($uri == '' || $uri == URL_FAVOURITES)
	{
		$allJobsRequested = true;
		if ($uri == URL_FAVOURITES){
			$_SESSION['indeed_favourites'] = 1;
 			$FAVOURITES = true;
		}
 		else {
 			$FAVOURITES = false;
 		}
	}
	else
	{
		$category = get_category_by_var_name($uri);
		
		if ($category)
		{
			$jobsPerCategoryRequested = true;
			$cat = true;
		}
		else
		{
			$type_id = get_type_id_by_varname($uri);
			
			if ($type_id)
			{
				$allJobsRequested = true;
			}
		}
	}

	if (INDEED_ACTIVATED == 'activated') {
		$allJobsRequested = true;
	}

	if (INDEED_BOTH_JOBS_FLAG == '1' && $cat == 'true') {
		$allJobsRequested = false;
		$jobsPerCategoryRequested = true;
	}

	if ($allJobsRequested)
	{
		require_once 'page_all_jobs.php';
	}
	elseif ($jobsPerCategoryRequested)
	{
		require_once 'page_category.php';
	}
	else
	{
		redirect_to(BASE_URL . 'page-unavailable/');
		exit;
	}
?>
