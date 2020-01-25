<?php
	global $db;

	$sql = 'SELECT * FROM customizer';
	$r = $db->query($sql);
	$data = $r->fetch_assoc();
	$smarty->assign('customizer_data', $data);

	$smarty->assign('general_homepage_logo_w', $data['general_homepage_logo_w']);
	$smarty->assign('general_homepage_logo_margin', $data['general_homepage_logo_margin']);
	$smarty->assign('general_homepage_bgimage_path', $data['general_homepage_bgimage_path']);

	if (INDEED_ACTIVATED == 'activated' && INDEED_BOTH_JOBS_FLAG != '1') {
		$cities = $job->getIndeedLocations();
	} else {
		$cities = $job->getCitiesWithJobs();
	}
	
	// get jobs 
	$job = new Job();
	$the_jobs = $job->GetPaginatedJobs(0, RELATED_JOBS_PER_PAGE, 0, false);
	$smarty->assign('more_jobs', $the_jobs);

	// get job types
	$smarty->assign('types', get_types());

	//get cities / countries
	$countries = $job->getCountriesForHeader();
	$smarty->assign('dropdown_countries', $countries);

	// get categories
	$cats = $job->getCategoriesForHeader();
	$smarty->assign('dropdown_cats', $cats);

	$smarty->assign('cities', $cities);

	$result = $db->query('SELECT url FROM '.DB_PREFIX.'pages WHERE url like "%contact%"');
	$data = $result->fetch_assoc();
	$smarty->assign('CONTACT_PAGE_URL', $data['url']);

	$smarty->assign('seo_title', htmlspecialchars(SEO_HOMEPAGE_TITLE));
	$smarty->assign('seo_desc', htmlspecialchars(SEO_HOMEPAGE_DESCRIPTION));
	$smarty->assign('seo_keys', htmlspecialchars(SEO_HOMEPAGE_KEYWORDS));

 	$smarty->assign('subscribe_msg', $translations['subscriptions']['subscribe_message']);
	
	$template = 'index.tpl';
?>
