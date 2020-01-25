<?php

	$smarty->assign('LOAD_TAGL', true);
	$smarty->assign('TAGL_INIT_JOB_DETAIL', true);
	//unset($_SESSION['applicant_name']);
	//unset($_SESSION['applicant']);

	$sanitizer = new Sanitizer();
	// CAPTCHA ######################################
	$captcha_enabled = ENABLE_RECAPTCHA;
	if ($captcha_enabled) {
		$pattern = "1234567890abcdefghijklmnopqrstuvwxyz";
		$token  = "";	
		for( $i = 1; $i <= 6 ; $i++ ) {
			$token .= $pattern{rand( 0, 35 )};
		}
		$encryptedToken = sha1( $token );

		// save the $encryptedToken in the session
		$_SESSION['encryptedToken'] = $encryptedToken;
		$rawCaptchaBytes =  base64_encode(simple_php_captcha($token));

		$the_captcha = str_replace('{RAW}', $rawCaptchaBytes, recaptcha_get_html());
		$the_captcha = str_replace('{CAPTCHA_LABEL}', $translations['captcha']['captcha_label'], $the_captcha);
		$smarty->assign('captcha_html', $the_captcha);
	}
	$smarty->assign('ENABLE_RECAPTCHA', $captcha_enabled);
	// CAPTCHA ######################################

	$hint = str_replace("{SIZE}", formatBytes(MAX_CV_SIZE), $translations['apply']['cv_hint']);
	$smarty->assign('cv_hint', $hint);
	$smarty->assign('MAX_CV_SIZE', MAX_CV_SIZE);

	$job_flag = false;
	//get JOB
	$job = new Job($extra);

	if (isset($_SESSION['applicant'])) {
		$cl = new Applicant();
		$applicant = $cl->getDataById($_SESSION['applicant']);

		$smarty->assign('SESSION_APPLICANT', true);
		if (!empty($applicant['fullname']))
			$smarty->assign('SESSION_APPLICANT_NAME', $applicant['fullname']);

		if (!empty($applicant['occupation']))
			$smarty->assign('SESSION_APPLICANT_OCCUPATION', $applicant['occupation']);

		$smarty->assign('SESSION_APPLICANT_EMAIL', $applicant['email']);

		if (!empty($applicant['phone']))
			$smarty->assign('SESSION_APPLICANT_PHONE', $applicant['phone']);

		$smarty->assign('SESSION_APPLICANT_MESSAGE', $applicant['message']);

		if (!empty($applicant['location']))
			$smarty->assign('SESSION_APPLICANT_LOCATION', $applicant['location']);

		if (!empty($applicant['skills']))
			$smarty->assign('SESSION_APPLICANT_SKILLS', $applicant['skills']);

		if (!empty($applicant['weblink'])) {
			$smarty->assign('SESSION_APPLICANT_PORTFOLIO', $applicant['weblink']);
			$smarty->assign('SESSION_APPLICANT_PORTFOLIO_LINK', 'http://' . $applicant['weblink']);
		}

		$smarty->assign('SESSION_APPLICANT_SM_LINKS', $applicant['sm_links']);

		if ($applicant['cv_path'] != "")
			$smarty->assign('SESSION_APPLICANT_CVTEXT', $translations['apply']['cv_check']);
		else
			$smarty->assign('SESSION_APPLICANT_CVTEXT', $translations['apply']['cv_cross']);

	}

	if ($job->Exists() && $job->GetActiveStatus() == 1)
	{

		// bottom navigation tree items

		// get job types
		$smarty->assign('types', get_types());

		//get cities / countries
		$countries = $job->getCountriesForHeader();
		$smarty->assign('dropdown_countries', $countries);

		// get categories
		$cats = $job->getCategoriesForHeader();
		$smarty->assign('dropdown_cats', $cats);

		$info = $job->GetInfo(); 

		// count only if the user has viewed the page in the lats hour
		$job->IncreaseViewCount();
		
		$job_flag = true;

		//$url = MAIN_URL . URL_JOB .'/' . $id . '/' . $info['url_title'] . '/';
		$url = PROTOCOL_URL . URL_JOB .'/' . $info['url_title'] . '-' . $info['location_asci'] . '/' . $extra;

		$smarty->assign('job_url', $url);
		$current_url = PROTOCOL . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
		
		//if ($current_url != $url) redirect_to($url);
		
		$related_jobs = $job->getRelatedJobs($info['id'], $info['title'], $info['category_id'], RELATED_JOBS_PER_PAGE);
		$smarty->assign('related_jobs_count', count($related_jobs));
		$smarty->assign('related_jobs', $related_jobs);
		// ######### list other jobs by the same company #########

		// get SM profiles
		$sm_profiles = $job->getSMprofiles();
		$smarty->assign('SM_PROFILES', $sm_profiles);

		$smarty->assign('job', $info);
		
		$category = get_category_by_id($info['category_id']);
		
		$title = stripslashes($info['title']) . " " . $translations['website_general']['at'] . " " . stripslashes($info['company'] . ' in ' . $info['location']);
		$keywords = stripslashes($info['title']) . ", " . $translations['website_general']['at'] . " " . stripslashes($info['company'] . ", " . $info['location']);
		$smarty->assign('seo_title', $title);
	
		$smarty->assign('meta_description', $title);
		$smarty->assign('meta_keywords', $keywords);
		$smarty->assign('current_url', $current_url);

		$smarty->assign('current_category', $category['var_name']);
		$smarty->assign('back_link', BASE_URL . URL_JOBS . '/' . $category['var_name'] . '/');
		$smarty->assign('header_clamp', true);

		$template = 'jobs/job.tpl';
	}
	else
	{
		redirect_to(BASE_URL . URL_JOB_UNAVAILABLE);
		exit;
	}
?>
