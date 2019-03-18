<?php
	$job = new Job($id);

	if ($job->Exists())
	{
		$info = $job->GetInfo();
		
		$app = new JobApplication();
		$info['applicants'] = $app->getAllForJob($id);

		$smarty->assign('job', $info);
		$apply_dates = array();
		$cvs = array();

		//format date
		foreach ($info['applicants'] as $applicant) {

	 		if ($applicant['cv_path'] != "") {
	            $var = explode(".", $applicant['cv_path']);
	            $ext = end($var);
	            if (strcmp($ext, "pdf") == 0){
	                $cvs[$applicant['id']] = 'fa fa-file-pdf-o fa-lg pdf-el';
	            }
	            else {
	                $cvs[$applicant['id']] = 'fa fa-file-word-o fa-lg word-el';
	            }  
	        }

			$test = DateTime::createFromFormat(DATE_FORMAT, $applicant['created_on']);
			$obj = new DateTime($test);
			$apply_dates[$applicant['id']] = date(DATE_FORMAT, floatval(stripslashes($obj->getTimestamp())));
		}

		$smarty->assign('applicants', $info['applicants']);
		$smarty->assign('apply_dates', $apply_dates);
		$smarty->assign('cvs', $cvs);

		$smarty->assign('cv_path', '/' . FILE_UPLOAD_DIR);
		
		$category = get_category_by_id($info['category_id']);
		$category_var_name = $category['var_name'];
		
		$html_title = stripslashes($info['title']) . ' la ' . stripslashes($info['company']) . ' / ' . SITE_NAME;
		
		if(isset($_SERVER['HTTP_REFERER']))
		{
			$currentLinksPage = explode('/', rtrim($_SERVER['HTTP_REFERER'], '/')); 
			
			if(strcmp(end($currentLinksPage), 'home') == 0)
			{
				$smarty->assign('back_link', BASE_URL . 'home/');
			}
			else
			{
				if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], "edited") !== false) {
					$smarty->assign('back_link', BASE_URL . URL_JOBS . '/all');
				} else {
					$smarty->assign('back_link', (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : BASE_URL . URL_JOBS . '/' . $category_var_name . '/'));
				}
				
			}
		}
		else
		{   
				if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], "edited") !== false) {
					$smarty->assign('back_link', BASE_URL . URL_JOBS);
				} else {
					$smarty->assign('back_link', (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : BASE_URL . URL_JOBS . '/' . $category_var_name . '/'));
				}
		}
		
		$smarty->assign('current_category', $category_var_name);
		
		$template = 'job.tpl';
	}
	else
	{
		redirect_to(BASE_URL . 'job-unavailable/');
		exit;
	}
?>
