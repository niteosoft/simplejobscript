<?php 

    $smarty->assign('SIDEBAR_CHEVRON', "activated");
    // INDEED == deactivated OR BOTH_JOBS == activated
	if ((INDEED_ACTIVATED != 'activated') || (INDEED_BOTH_JOBS_FLAG == '1' )) {
		
        // mobile standard sidebar search
        $type_var_name = '';
        $AJAX = true;

        if ($id)
        {  
            $type_var_name = $id;
            $smarty->assign('type_name', $type_var_name);
            $AJAX = false;
        }

        if ($type_var_name != '')
        {
            $type_id = get_type_id_by_varname($type_var_name);

        }
        
        if ($type_id)
        {               
            $t = $job->GetJobTypeName($type_id);
            $smarty->assign('current_jobtype', $t);
            $smarty->assign('seo_title', $t . ' ' . $translations['alljobs']['jobs']);
            $smarty->assign('seo_desc', $t . ' ' . $translations['alljobs']['jobs']);
            $smarty->assign('seo_keys', $t . ',' . $translations['alljobs']['jobs']);

        } else {
            $smarty->assign('seo_title', SEO_JOBS_ALL_TITLE);
            $smarty->assign('seo_desc', SEO_JOBS_ALL_DESCRIPTION);
            $smarty->assign('seo_keys', SEO_JOBS_ALL_KEYWORDS);
        }
        // desktop search

		function ctype($var) { return (stripos($var, '_ctype') === false); }
        function catgry($var) { return (stripos($var, '_catgry') === false); }
        function loctn($var) { return (stripos($var, '_loctn') === false); }
        
        $jobtypesearch = $_REQUEST[job_type_value]; 
        if($jobtypesearch == ''){
        $jobtypesearch = $translations['alljobs']['all_jobs'];
        }
        $remove_id = $_REQUEST[remove_id];
        
        $all_array = $_REQUEST[srch_location_val];
        $remove_typee = array_filter($all_array, 'ctype');
        $get_type_array = array_diff($all_array, $remove_typee);
        $strng_type = implode('', $get_type_array);
        $replacedstring =  str_replace('_ctype', ' ', $strng_type);
        $array_type = explode(" ", $replacedstring);
        if(empty($array_type[count($array_type)-1])) {
            unset($array_type[count($array_type)-1]);
        }                                                     // type array
        
        $remove_catgry = array_filter($all_array, 'catgry');
        $get_catgry_array = array_diff($all_array, $remove_catgry);
        $strng_ctgry = implode('', $get_catgry_array);
        $replacedstring_ctgry =  str_replace('_catgry', ' ', $strng_ctgry);
        $array_category = explode(" ", $replacedstring_ctgry);  // category array
        if(empty($array_category[count($array_category)-1])) {
            unset($array_category[count($array_category)-1]);
        }
        
        $remove_locatn = array_filter($all_array, 'loctn');
        $get_loctn_array = array_diff($all_array, $remove_locatn);
        $strng_loctn = implode('', $get_loctn_array);
        $replacedstring_loctn =  str_replace('_loctn', ' ', $strng_loctn);
        $array_location = explode(" ", $replacedstring_loctn);    // location array
        if(empty($array_location[count($array_location)-1])) {
            unset($array_location[count($array_location)-1]);
        }
        
        $type_var_count = count($array_type);
        
        $type_catgry_count = count($array_category);

        $location_var_count = count($array_location);
        $jobsCount = '';
        
         // for Category type variables start here  
         if($type_catgry_count != '0')
         {
             $category_var_name = $array_category;
         }else{
             $category_var_name = '';
         }                
         foreach($category_var_name as $cat_rs)
         {
             $categry_idd[] .= $job->GetCategId($cat_rs);
         }
         
        // for fulltime, parttime etc type variables start here          
        if ($type_var_count != '0')
        {
            $type_var_nameee = $array_type;
        }else{
            $type_var_nameee = '';
        }
        foreach($type_var_nameee as $type_vr)
        {
            $type_id[] .= $job->GetTypeId($type_vr);
        }
        
        // for location type start here
        if($location_var_count != '0')
         {
             $location_varble_name = $array_location;
         }else{
             $location_varble_name = '';
         }       
         foreach($location_varble_name as $location_rs)
         {
             $loctn_idd[] .= $job->GetLocationId($location_rs);
         }
         $jobsCount_type = '0';
         $jobsCount_categry = '0';
         $jobsCount_location = '0';

        if ($type_id)
        {                
            $smarty->assign('current_jobtype_varname', $job->GetJobTypeVarName($type_id));
            $t = $job->GetJobTypeName($type_id);
            $smarty->assign('current_jobtype', $t);
            $jobsCount_type =  $job->CountJobsOfTypeId($type_id);
        }
        if($categry_idd)
        {
            $t = $job->GetJobTypeName($categry_idd);
            $smarty->assign('current_jobtype', $t);
            $jobsCount_categry =  $job->CountJobsOfTypeCategoryId($categry_idd);
            
        }
        if($loctn_idd)
        {
            $t = $job->GetJobTypeName($loctn_idd);
            $smarty->assign('current_jobtype', $t);
            $jobsCount_location =  $job->CountJobsOfTypeLocationId($loctn_idd);
            
        }
        if((!$type_id) && (!$categry_idd) && (!$loctn_idd))
        {
            $jobsCount =  $job->CountJobs();
        }else{
            $jobsCount =  $jobsCount_type+$jobsCount_categry+$jobsCount_location;
        }

		$smarty->assign('jobs_count', $jobsCount);
		
		$paginatorLink = BASE_URL . URL_JOBS;

		if (!empty($type_var_name))
			$paginatorLink .= "/$type_var_name";

        if ($FAVOURITES == NULL){
            $fav = false;
        }
        else {
            $jobsCount = count($_SESSION['favourites']);
            $fav = $FAVOURITES;
            $smarty->assign('favourites_jobs', 'true');
        }

		$paginator = new Paginator($jobsCount, JOBS_PER_PAGE, @$_REQUEST['p']);
		$paginator->setLink($paginatorLink);
		$paginator->paginate();
		
		$firstLimit = $paginator->getFirstLimit();
		$lastLimit = $paginator->getLastLimit();

        if ($AJAX) {
            $the_jobs = $job->GetPaginatedJobsFilter($firstLimit, JOBS_PER_PAGE, $type_id, $categry_idd, $loctn_idd, $fav); 
        } else {
            $the_jobs = $job->GetPaginatedJobs($firstLimit, JOBS_PER_PAGE, $type_id, $fav);   
        }

		$smarty->assign("pages", $paginator->pages_link);

		$smarty->assign('jobs', $the_jobs);
        
        $res = implode(" ", $jobtypesearch);

        if(!$_REQUEST){
            $smarty->assign('current_jobtype_search', $jobtypesearch);
        }else{
            $smarty->assign('current_jobtype_search', $res);
        }

        if(!$_REQUEST){
            $smarty->assign('remove_id', 'all');
        }else{
            $smarty->assign('remove_id', $remove_id);
        }

		$smarty->assign('types', get_types());
		$smarty->assign('current_category_id', 0); //all categories here

		//get cities / countries
		$countries = $job->getCountriesForHeader();
		$smarty->assign('dropdown_countries', $countries);

		// get categories
		$cats = $job->getCategoriesForHeader();
		$smarty->assign('dropdown_cats', $cats);

		$smarty->assign('subscribe_msg', $translations['subscriptions']['subscribe_message']);	
	}  else {
            $smarty->assign('seo_title', SEO_JOBS_ALL_TITLE);
            $smarty->assign('seo_desc', SEO_JOBS_ALL_DESCRIPTION);
            $smarty->assign('seo_keys', SEO_JOBS_ALL_KEYWORDS);
    }

	$template = 'jobs/all-jobs.tpl';

?>
