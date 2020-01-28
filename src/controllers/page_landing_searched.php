<?php 

    // INDEED == deactivated OR BOTH_JOBS == activated
	//if ((INDEED_ACTIVATED != 'activated') || (INDEED_BOTH_JOBS_FLAG == '1' )) {
	global $db;

	$smarty->assign('SIDEBAR_CHEVRON', "activated");
	escape($_POST);

	$landing_location = (int) $landing_location;

	if (INDEED_ACTIVATED == 'activated' && INDEED_BOTH_JOBS_FLAG != '1') { 
		$smarty->assign('IndeedLandingSearch', true);

		if (!$_SESSION['CURRENT_PAGE']) {
			$_SESSION['CURRENT_PAGE'] = URL_LANDING_SEARCHED;
		}

		// pagination or form submission? 
		if (isset($_GET['p'])) {
			$smarty->assign('IndeedPage', $_GET['p']);
			$smarty->assign('IndeedLocation', $id);
			$smarty->assign('IndeedLocationFullName', getIndeedFilterNameByVar($id));
			$smarty->assign('IndeedTitle', $extra);
		} else {

			$smarty->assign('IndeedLocationFullName', getIndeedFilterNameByVar($landing_location));
			$smarty->assign('IndeedLocation', $landing_location);
			$smarty->assign('IndeedTitle', $db->getConnection()->real_escape_string($landing_title));		
		}

	} else {

		if (isset($_GET['p'])) {

			if (!empty($extra) && $extra != "")
				$landing_title = $extra;
			else
				$landing_title = "";

			$qsql = 'SELECT id FROM cities WHERE ascii_name = "' . $id . '"'; 
			$qr = $db->query($qsql);
			$qrow = $qr->fetch_assoc();

			$landing_location = $qrow['id'];

			if (INDEED_BOTH_JOBS_FLAG == '1')
				$smarty->assign('IndeedPage', $_GET['p']);
		}

		$landing_title = $db->getConnection()->real_escape_string($landing_title);

		$q = 'SELECT ascii_name as "code" FROM cities WHERE id =' . intval($landing_location);
		$res = $db->query($q);
		$data = $res->fetch_assoc();

		if (INDEED_BOTH_JOBS_FLAG == '1') {

			$smarty->assign('IndeedLandingSearch', true);
			$smarty->assign('IndeedLocation', $data['code']);
			$smarty->assign('IndeedTitle', $landing_title);
		}

		$jobsCount = $job->countSearchedJobs($landing_title, $landing_location);

		$search_msg = '';
		if (!empty($landing_title))
			$search_msg .= $translations['searchbar']['search_results_for'] . ' <span class="searched">' . $landing_title . '</span>';

		if (!empty($landing_location)){

			$s = 'SELECT name FROM cities WHERE id =' . intval($landing_location); 
			$result = $db->query($s);
			$row = $result->fetch_assoc();
			$LOC_NAME = $row['name'];

			if (empty($landing_title)) {
				$search_msg .= $translations['searchbar']['search_results_for_jobs_in'] . ' <span class="searched">' . $LOC_NAME . '</span>' . ' <span class="sc">(' . $jobsCount . ')</span>';
			} else {
				$search_msg .= ' '. $translations['searchbar']['in'] .' <span class="searched">' . $LOC_NAME . '</span>' . ' <span class="sc">(' . $jobsCount . ')</span>';
			}
		}

		$smarty->assign('landing_searched', true);
		$smarty->assign('landing_searched_msg', $search_msg);

		$smarty->assign('jobs_count', $jobsCount);

		if (!empty($landing_title)) {
			$paginatorLink = BASE_URL . URL_LANDING_SEARCHED . '/' . $data['code'] . '/' . $landing_title;
		} else {
			$paginatorLink = BASE_URL . URL_LANDING_SEARCHED . '/' . $data['code'];
		}		
		

		$paginator = new Paginator($jobsCount, JOBS_PER_PAGE, @$_REQUEST['p']);
		$paginator->setLink($paginatorLink);
		$paginator->paginate();
		
		$firstLimit = $paginator->getFirstLimit();
		$lastLimit = $paginator->getLastLimit();

	 	$the_jobs = $job->GetSearchedPaginatedJobs($firstLimit, JOBS_PER_PAGE, $landing_title, $landing_location);	

		$smarty->assign("pages", $paginator->pages_link);

		$smarty->assign('jobs', $the_jobs);
		$smarty->assign('types', get_types());
		$smarty->assign('current_category_id', 0); //all categories here

		// get categories
		$cats = $job->getCategoriesForHeader();
		$smarty->assign('dropdown_cats', $cats);

		//get cities / countries
		$countries = $job->getCountriesForHeader();
		$smarty->assign('dropdown_countries', $countries);

		if (!$type_id)
		{	
			$smarty->assign('seo_title', SEO_JOBS_ALL_TITLE);
			$smarty->assign('seo_desc', SEO_JOBS_ALL_DESCRIPTION);
			$smarty->assign('seo_keys', SEO_JOBS_ALL_KEYWORDS);
		}
		$smarty->assign('subscribe_msg', $translations['subscriptions']['subscribe_message']);
	}
		

	$template = 'jobs/all-jobs.tpl';

?>
