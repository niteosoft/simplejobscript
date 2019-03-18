<?php
	$sanitizer = new Sanitizer();

	$sql = 'SELECT DISTINCT employer_id, name, description, hq, url, logo_path, profile_picture FROM '.DB_PREFIX.'company WHERE id =' . $extra;
	$result = $db->query($sql);
	$company = $result->fetch_assoc();

	if ($company)
	{

		$smarty->assign('jobs', $job->getJobsByCompanyEmployerId($company['employer_id']));
		$smarty->assign('company', $company);
		$smarty->assign('COMPANY_JOB_LISTING', 1);

		$html_title = SEO_JOBS_AT_COMPANY  . ' ' . $company['name'];
		$meta_description = SEO_JOBS_AT_COMPANY . ' ' . $company['name'];
		$meta_keywords =  SEO_JOBS_AT_COMPANY . ' ' . $company['name'];

		$template = 'jobs/company.tpl';
	}
	else
	{
		// Copied from index.php
		header("HTTP/1.1 404 Not Found");
		// TO-DO: add suggestion if no trailing slash supplied
		$html_title = 'Company unavailable / ' . SITE_NAME;
		$meta_keywords = 'company, unavailable';
		$meta_description = 'Company unavailable';

		$template = 'err/error.tpl';
	}
?>

