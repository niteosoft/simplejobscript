<?php

	/**
	*  Simplejobscript Copyright (©) 2019 Niteosoft s.r.o. (ltd)
	*
	*  @author     Niteosoft s.r.o. (ltd)
	*  @license    MIT
	*  @website    simplejobscript.com
	*
	*  There are no license limitations, modifications nor restrictions placed upon 
	*  and no rights have been transfered to all third-party software parts of this product. You are granted to use these libraries
	*  and sub-parts while following their individual license specifications and terms of service
	*
	*/

// a user's visit on a job post is only counted once per hour
define('MAX_VISITS_PER_HOUR', 1);

class Job
{
	public $mId = false;
	public $mTypeId = false;
	public $mTypeVarName = false;
	public $mTypeName = false;
	public $mCategoryId = false;
	public $mTitle = false;
	public $mDescription = false;
	public $mCompany = false;
	public $mLocation = false;
	public $mLocationName = false;
	public $mUrl = false;
	public $mCreatedOn = false;
	public $mCreatedOnTimestamp = false;
	public $mIsActive = false;
	public $mViewsCount = false;
	public $mCityId = false;
	public $mUrlTitle = false;
	public $mApplyOnline = false;
	public $mCategoryName = false;
	public	$mClosedOn = false;
	public	$mDaysOld = false;
	//new attrs
	public $mEmployerId = false;
	public $mCategoryVarName = false;
	public $mCompanyHq = false;
	public $mApplyDesc = false;
	public $mCompanyDesc = false;
	public $mCompanyLogoPath = false;
	public $mExpires = false;
	public $mSpotlight = false;
	public $mSalary = false;
	public $containsAdminTitle = false;
	public $mCompanyDetailUrl = false;
	public $mCompanyPublicProfileFlag = false;

	function __construct($job_id = false)
	{

		global $db;
		if (is_numeric($job_id))
		{	/* , "' . DATE_FORMAT . '" */
			$sanitizer = new Sanitizer;
			$sql = 'SELECT a.type_id AS type_id, a.employer_id as employer_id, a.category_id AS category_id, 
						   a.title AS title, a.description AS description, 
			               UNIX_TIMESTAMP(a.created_on) AS created_on, UNIX_TIMESTAMP(a.expires) AS expires, a.is_active AS is_active,
			               a.views_count AS views_count, a.city_id AS city_id, a.apply_online AS apply_online, a.apply_desc AS apply_desc, a.spotlight AS spotlight, a.salary AS salary, b.name AS category_name, b.var_name AS category_varname,
			               c.var_name AS type_var_name, c.name as type_name,
			               UNIX_TIMESTAMP(a.expires) AS closed_on, DATEDIFF(NOW(), created_on) AS days_old, cit.name AS city_name, cit.ascii_name AS city_asci,
			               company.name AS company_name, company.id as "company_id", company.description AS company_desc, company.hq AS company_hq, company.url AS company_url, company.logo_path AS company_logo_path, company.public_page AS company_public_profile_flag
			               FROM '.DB_PREFIX.'jobs a LEFT JOIN '.DB_PREFIX.'cities cit on a.city_id = cit.id, '.DB_PREFIX.'company company, ' .DB_PREFIX.'categories b, '.DB_PREFIX.'types c
			               WHERE a.category_id = b.id AND c.id = a.type_id AND company.employer_id=a.employer_id AND a.id = ' . $job_id;


			$result = $db->query($sql);
			$row = $result->fetch_assoc();

			if (!empty($row))
			{

				// admin causing troubles with routing
				if (strpos(strtolower($row['title']), "admin") !== false) {
					$this->containsAdminTitle = "1";
				} else {
					$this->containsAdminTitle = "0";
				}

				$this->mId = $job_id;
				$this->mTypeId = $row['type_id'];
				$this->mEmployerId = $row['employer_id'];
				$this->mCategoryId = $row['category_id'];
				$this->mCategoryName = $row['category_name'];
				$this->mCategoryVarName = $row['category_varname'];
				$this->mTitle = mb_substr(str_replace('&', '&amp;', $row['title']), 0, 50, "UTF8");
				$this->mDescription = $row['description'];
				$this->mCompany = $row['company_name'];
				$this->mCompanyHq = $row['company_hq'];

				if (strpos($row['company_url'], "http") !== false) {
					$this->mUrl = $row['company_url'];
				} else {
					$this->mUrl = 'http://' . $row['company_url'];
				}

				$this->mCompanyDesc = $row['company_desc'];
				$this->mCompanyLogoPath = $row['company_logo_path'];
				$this->mCreatedOn = time_elapsed_string($row['created_on']);
				$this->mCreatedOnTimestamp = $row['created_on'];
				$this->mExpires = $row['expires'];
				$this->mClosedOn = $row['closed_on'];
				$this->mIsActive = $row['is_active'];
				$this->mViewsCount = $row['views_count'];
				$this->mCityId = $row['city_id'];
				$this->mLocation = $this->GetLocation($row);
				$this->mLocationName = $row['city_asci'];
				$this->mUrlTitle = $sanitizer->sanitize_title_with_dashes($this->mTitle . ' ' . GENERAL_AT . ' ' . $this->mCompany);
				$this->mApplyOnline = $row['apply_online'];
				$this->mApplyDesc = $row['apply_desc'];
				$this->mDaysOld = $row['days_old'];
				$this->mTypeName = $row['type_name'];
				$this->mTypeVarName = $row['type_var_name'];
				$this->mSpotlight = $row['spotlight'];
				$this->mSalary = $row['salary'];
				$this->mCompanyDetailUrl = BASE_URL . URL_JOBS_AT_COMPANY . '/' . $sanitizer->sanitize_title_with_dashes($row['company_name']) . '/' . $row['company_id'];
				$this->mCompanyPublicProfileFlag = $row['company_public_profile_flag'];

			}
		}
	}
	
	// Get a job post's information
	public function GetInfo()
	{
		global $db;

		$fullUrl = '';
		// admin causing troubles with routing
		if (strpos(strtolower($this->mUrlTitle), "admin") !== false) {
			$fullUrl = BASE_URL . URL_JOB . '/' . $this->mId;
		} else {
			$fullUrl = BASE_URL . URL_JOB . '/' . $this->mId . '/' .stripslashes($this->mUrlTitle);
		}

		$job = array('id' => $this->mId,
					 'employer_id' => $this->mEmployerId,
		             'job_type' => $this->GetJobTypeName($this->mTypeId),
		             'category_id' => $this->mCategoryId,
		             'category_name' => $this->mCategoryName,
 					 'category_varname' => $this->mCategoryVarName,
					 'company' => $this->getOptionalColumn(stripslashes($this->mCompany)),
					 'company_hq' => $this->getOptionalColumn(stripslashes($this->mCompanyHq)),
					 'url' => $this->getOptionalColumn(stripslashes($this->mUrl)),
					 'company_desc' => $this->mCompanyDesc,
					 'company_desc_excerpt' =>  (strlen($this->mCompanyDesc) > 300) ? strip_tags(substr($this->mCompanyDesc, 0, 300) . "...") : strip_tags($this->mCompanyDesc),
					 'company_logo_path' => $this->getLogoPath($this->mCompanyLogoPath),
					 'title' => stripslashes($this->mTitle),
					 'adminTitleFlag' => $this->containsAdminTitle,
					 'url_title' => stripslashes($this->mUrlTitle),
					 'full_url' => $fullUrl,
					 'location' => $this->mLocation,
					 'location_asci' => $this->mLocationName,
					 'is_location_anywhere' => $this->IsLocationAnywhere(),
					 'description' => stripslashes($this->mDescription),
					 'description_short' =>  $this->limitDescription(strip_tags(stripslashes($this->mDescription))),
					 'description_listing' =>  $this->limitDescriptionListing(strip_tags(stripslashes($this->mDescription))),
					 'created_on' => stripslashes($this->mCreatedOn),
					 'created_on_ts' => stripslashes($this->mCreatedOnTimestamp),
					 'new_flag' => $this->isJobNew($this->mCreatedOnTimestamp),
					 'expires' => stripslashes($this->mExpires),
					 'post_date' => date(DATE_FORMAT, floatval(stripslashes($this->mCreatedOnTimestamp))), 
					 'expires_date' => date(DATE_FORMAT, floatval(stripslashes($this->mExpires))), 
					 'closed_on' => stripslashes($this->mClosedOn),
					 'views_count' => $this->mViewsCount,
					 'city_id' => $this->mCityId,
					 'apply_online' => $this->mApplyOnline,
					 'apply_desc' => $this->mApplyDesc,
					 'is_active' => $this->mIsActive,
					 'days_old' => $this->mDaysOld,
					 'type_name' => $this->mTypeName,
					 'type_var_name' => $this->mTypeVarName,
					 'spotlight' => $this->mSpotlight,
					 'company_detail_url' => $this->mCompanyDetailUrl,
					 'salary' => $this->mSalary,
					 'public_profile_flag' => $this->mCompanyPublicProfileFlag);
		
		return $job;
	}
	
	// Get a job post's basic information for admin
	public function GetBasicInfoAdmin()
	{
		$job = array('id' => $this->mId,
					 'employer_id' => $this->mEmployerId,
			         'type_id' => $this->mTypeId,
			         'category_id' => $this->mCategoryId,
 			         'category_name' => $this->mCategoryName,
 			         'category_varname' => $this->mCategoryVarName,
					 'company' => stripslashes($this->mCompany),
					 'company_hq' => stripslashes($this->mCompanyHq),
					 'url' => stripslashes($this->mUrl),
					 'title' => stripslashes($this->mTitle),
					 'url_title' => stripslashes($this->mUrlTitle),
					 'location' => $this->mLocation,
					 'location_asci' => $this->mLocationName,
					 'is_location_anywhere' => $this->IsLocationAnywhere(),
					 'description' => stripslashes($this->mDescription),
					 'created_on' => stripslashes($this->mCreatedOn),
					 'post_date' => date(DATE_FORMAT, floatval(stripslashes($this->mCreatedOnTimestamp))), 
					 'closed_on' => stripslashes($this->mClosedOn),
					 'city_id' => $this->mCityId,
					 'days_old' => $this->mDaysOld,
					 'is_active' => $this->mIsActive,
					 'apply_desc' => $this->mApplyDesc,
					 'views_count' => $this->mViewsCount,
					 'type_name' => $this->mTypeName,
					 'type_var_name' => $this->mTypeVarName,
					 'spotlight' =>$this->mSpotlight,
					 'company_detail_url' => $this->mCompanyDetailUrl,
					 'salary' =>$this->mSalary);
		
		return $job;
	}

	private function limitDescription($desc) {
		return (strlen($desc) <= DESCRIPTION_LIMIT) ? $desc : mb_substr($desc, 0, DESCRIPTION_LIMIT, "UTF8") . "...";
	}

	private function limitDescriptionListing($desc){
		return (strlen($desc) <= JOB_DESCRIPTION_LIMIT) ? $desc : mb_substr($desc, 0, JOB_DESCRIPTION_LIMIT, "UTF8");
	}

	private function isJobNew($timestamp) {
		$threeDaysAgo = strtotime("-72 hours");
		$jobDate = date("d F Y", floatval(stripslashes($timestamp)));
		if (strtotime($jobDate) >= $threeDaysAgo) {
			return true;
		} else return false;
	}

	private function getLogoPath($path) {
		//$absolute = dirname(__FILE__)  . $path;
		return (file_exists($path)) ? $path : $path; //'/uploads/companies/default-logo.jpg'
	}

	private function getOptionalColumn($col) {
		if ($col == '' || $col == NULL || count($col) < 1)
			return false;
		else
			return $col;
	}

	public function checkOwner($employer_id) {
		if (intval($this->mEmployerId) !== intval($employer_id))
			return false;
		else
			return true;
	}

	public function getTmpJobInfoByEmployerId($id) {
		global $db;

		$sql = 'SELECT id AS job_id FROM '.DB_PREFIX.'jobs WHERE is_tmp = 1 AND employer_id = ' . $id . ' ORDER BY created_on DESC';
		$result = $db->query($sql);
		$row = $result->fetch_assoc();

		if (!$result)
			return false;
		else {
			$job = new Job($row['job_id']);
			return $job->GetInfo();
		}
	}

	private function GetLocation($resultSetRow)
	{
		$location = '';
		
		if ($resultSetRow['city_id'] != NULL) 
		{
			$location = $resultSetRow['city_name'];
		} 
		
		return $location;
	}
	
	private function IsLocationAnywhere()
	{	//hook this up from admin settings. jobs with location or remote
		return $this->mCityId == 0;
	}
	
	// Get all job posts (optionally from a specific type and/or category)
	// $type_id: freelance/fulltime/parttime
	// $categ_id: programmers/designers/etc
	// $limit: (int) how many results
	// $random: (1/0) randomize results?
	// $days_behind: (int) only get results from last N days
	// $for_feed: (boolean) is this request from rss feed?
	// $poster_email: (string) poster email
	public function GetJobs($type_id = false, $categ_id = false, $limit = false, $random, $days_behind, $for_feed = false, $city_id = false, $spotlight = false, $poster_email = false)
	{
		global $db;
		$jobs = array();
		$conditions = '';
		
		// if $categ_id is, in fact, the category's var_name, 
		// get the categs id
		if (!is_numeric($categ_id))
		{
			$categ_id = $this->GetCategId($categ_id);
		}
		// if $type_id is, in fact, the type's var_name, 
		// get the type's id
		if (!is_numeric($type_id))
		{
			$type_id = $this->GetTypeId($type_id);
		}
		
		if (is_numeric($type_id) && $type_id != 0)
		{
			$conditions .= ' AND type_id = ' . $type_id;
		}
		if (is_numeric($categ_id) && $categ_id != 0)
		{
			$conditions .= ' AND category_id = ' . $categ_id;
		}

		if ($days_behind > 0)
		{
			$conditions .=' AND created_on >= DATE_SUB(NOW(), INTERVAL ' . $days_behind . ' DAY)';
		}
		
		if ($for_feed)
		{
			// job was posted more than 10 minutes ago
			$conditions .= ' AND DATE_SUB(NOW(), INTERVAL 10 MINUTE) > created_on';
		}
		
		if ($city_id && is_numeric($city_id))
		{
			$conditions .= ' AND city_id = ' . $city_id;
		}
		
		if ($type_id && is_numeric($type_id))
		{
			$conditions .= ' AND type_id = ' . $type_id;
		}
		
		if ($spotlight &&  is_numeric($spotlight))
		{
			$conditions .= ' AND spotlight = ' . $spotlight;
		}

		if ($random == 1)
		{
			$order = ' ORDER BY RAND() ';
		}
		else
		{
			$order = ' ORDER BY spotlight DESC , created_on DESC ';
		}
		
		if ($limit != false && $limit > 0)
		{
			$sql_limit = 'LIMIT ' . $limit;
		}
		else
		{
			$sql_limit = '';
		}
		
		$sql = 'SELECT id
		               FROM '.DB_PREFIX.'jobs
		               WHERE UNIX_TIMESTAMP(expires) > UNIX_TIMESTAMP(NOW()) AND 1 ' . $conditions . ' AND is_tmp = 0 AND is_active = 1
		               ' . $order . ' ' . $sql_limit;
		$result = $db->query($sql);
		while ($row = $result->fetch_assoc())
		{
			$current_job = new Job($row['id']);
			$jobs[] = $current_job->GetInfo();
		}
		return $jobs;
	}
	
	public function getRelatedJobs($jobID, $title, $categoryID, $limit) {
		global $db;
		$jobs = array();

		$title_parts = explode(" ", $title);

		$sql = 'SELECT *
	               FROM '.DB_PREFIX.'jobs
	               WHERE UNIX_TIMESTAMP(expires) > UNIX_TIMESTAMP(NOW()) AND id <> ' .$jobID. ' AND category_id = ' . $categoryID . ' AND is_tmp = 0  AND is_active = 1 AND (';

	     $count = count($title_parts);

		for ($i=0; $i < $count; $i++) { 
			if ($i == $count - 1)
				$sql .= 'title LIKE "%' . $db->getConnection()->real_escape_string($title_parts[$i]) . '%") ';
			else 
				$sql .= 'title LIKE "%' . $db->getConnection()->real_escape_string($title_parts[$i]) . '%" OR ';
				
		}

	   $sql .= ' ORDER BY spotlight DESC, created_on DESC limit ' . $limit;

        $result = $db->query($sql);


		 while ($row = $result->fetch_assoc())
		{
			$current_job = new Job($row['id']);
			$jobs[] = $current_job->GetInfo();
		}

		return $jobs;
	}

	public function getEmployerJobs($id) {
		global $db;
		$jobs = array();

		$sql = 'SELECT id, UNIX_TIMESTAMP(expires) as "expires"
		               FROM '.DB_PREFIX.'jobs WHERE employer_id = ' . $id . ' AND is_tmp = 0 ORDER BY spotlight DESC, created_on DESC';

		$result = $db->query($sql);

		while ($row = $result->fetch_assoc())
		{
			//prevent to fetch expired jobs with active = 1 flag still set
			if (intval($row['expires']) < time()) {
				$this->Deactivate($row['id']);
			}

			$current_job = new Job($row['id']);
			$jobs[] = $current_job->GetInfo();
		}
		return $jobs;
	}

	public function GetPaginatedJobsForCategory($categoryID, $startIndex, $numberOfJobsToGet, $jobTypeID)
	{
		global $db;
		$jobs = array();
		
		if (!empty($categoryID))
			$sql = 'SELECT id
		               FROM '.DB_PREFIX.'jobs
		               WHERE UNIX_TIMESTAMP(expires) > UNIX_TIMESTAMP(NOW()) AND category_id = ' . $categoryID . ' AND is_tmp = 0  AND is_active = 1';
		else
			$sql = 'SELECT id
		               FROM '.DB_PREFIX.'jobs
		               WHERE UNIX_TIMESTAMP(expires) > UNIX_TIMESTAMP(NOW()) AND is_tmp = 0 AND is_active = 1';

		if ($jobTypeID != 0)
		{
			$sql .= ' AND type_id = ' . $jobTypeID;
		}
		
		$sql .= ' ORDER BY spotlight DESC, created_on DESC limit ' . $startIndex . ',' . $numberOfJobsToGet;
		
		$result = $db->query($sql);
		
		while ($row = $result->fetch_assoc())
		{
			$current_job = new Job($row['id']);
			$jobs[] = $current_job->GetInfo();
		}
		
		return $jobs;
	}

	public function GetInactivePaginatedJobsForCategory($categoryID, $startIndex, $numberOfJobsToGet, $jobTypeID)
	{
		global $db;
		$jobs = array();
		
		if (!empty($categoryID))
			$sql = 'SELECT id
		               FROM '.DB_PREFIX.'jobs
		               WHERE category_id = ' . $categoryID . ' AND is_tmp = 0  AND is_active = 0';
		else
			$sql = 'SELECT id
		               FROM '.DB_PREFIX.'jobs
		               WHERE  is_active = 0 AND is_tmp = 0';

		if ($jobTypeID != 0)
		{
			$sql .= ' AND type_id = ' . $jobTypeID;
		}
		
		$sql .= ' ORDER BY spotlight DESC, created_on DESC limit ' . $startIndex . ',' . $numberOfJobsToGet;
		
		$result = $db->query($sql);
		
		while ($row = $result->fetch_assoc())
		{
			$current_job = new Job($row['id']);
			$jobs[] = $current_job->GetInfo();
		}
		
		return $jobs;
	}
	
	public function GetPaginatedJobsForCity($cityID, $startIndex, $numberOfJobsToGet, $jobTypeID)
	{
		global $db;
		$jobs = array();
		
		$sql = 'SELECT id
		               FROM '.DB_PREFIX.'jobs
		               WHERE UNIX_TIMESTAMP(expires) > UNIX_TIMESTAMP(NOW()) AND city_id = ' . $cityID . ' AND is_tmp = 0  AND is_active = 1';
		
		if ($jobTypeID != 0)
		{
			$sql .= ' AND type_id = ' . $jobTypeID;
		}
		
		$sql .= ' ORDER BY spotlight DESC, created_on DESC limit ' . $startIndex . ',' . $numberOfJobsToGet;
		
		$result = $db->query($sql);
		
		while ($row = $result->fetch_assoc())
		{
			$current_job = new Job($row['id']);
			$jobs[] = $current_job->GetInfo();
		}
		
		return $jobs;
	}

	public function getJobTitlesByEmployerId($id) {
		global $db;
		$sql = 'SELECT id, title FROM '.DB_PREFIX.'jobs
		               WHERE is_tmp = 0 AND is_active = 1 AND UNIX_TIMESTAMP(expires) > UNIX_TIMESTAMP(NOW()) AND employer_id = ' . $id;
		$result = $db->query($sql);

		// are there any applications under REVIEW ?

		$tmpSQL = 'SELECT id as "job_id" FROM jobs WHERE employer_id = ' . intval($id);
		$tmpRES = $db->query($tmpSQL);
		$emp_jobs_arr = array();

		while ($R = $tmpRES->fetch_assoc()) {
			$emp_jobs_arr[] = $R['job_id'];
		}

		$emp_jobs_arr = "'" . implode("','", $emp_jobs_arr) . "'";

		$xSQL = 'SELECT id FROM job_applications WHERE status = 2 AND job_id IN (' . $emp_jobs_arr . ')';
		$xR = $db->query($xSQL);

		if ($xR->num_rows > 0 && $xR->fetch_assoc()) {
			$jobs = array("0" => "-", "1" => REVIEW_LABEL);
		} else {
			$jobs = array("0" => "-");
		}

		while ($row = $result->fetch_assoc()) {

		    $inner_sql = 'SELECT id FROM '.DB_PREFIX.'job_applications
		               WHERE job_id = ' . $row['id'] . ' AND status = 0';
		    $res = $db->query($inner_sql);

		    $test = $res->fetch_assoc();

		    //save only jobs with undecided applications
		    if (!empty($test))
				$jobs[$row['id']] = $row['title'];
		}
		return $jobs;

	}

	public function GetSearchedPaginatedJobs($startIndex, $numberOfJobsToGet, $job_title, $job_location)
	{
		global $db;
		$jobs = array();
		
		$sql = 'SELECT id
		               FROM '.DB_PREFIX.'jobs
		               WHERE UNIX_TIMESTAMP(expires) > UNIX_TIMESTAMP(NOW()) AND is_tmp = 0  AND is_active = 1';
		
		// conditions
		$condition = '';
		if ($job_title && !empty($job_title)) {
			$condition .= ' AND title LIKE "%' . $job_title . '%"';
		}

		if ($job_location && !empty($job_location)) {
			$condition .= ' AND city_id = ' . $job_location;
		}

		$sql .= $condition;

		$sql .= ' ORDER BY spotlight DESC, created_on DESC limit ' . $startIndex . ',' . $numberOfJobsToGet;
		
		$result = $db->query($sql);
		
		while ($row = $result->fetch_assoc())
		{

			$current_job = new Job($row['id']);
			$jobs[] = $current_job->GetInfo();
 			
		}
		
		return $jobs;
	}

	public function GetPaginatedJobs($startIndex, $numberOfJobsToGet, $jobTypeID = 0, $favourites = false)
	{
		global $db;
		$jobs = array();
		
		$sql = 'SELECT id
		               FROM '.DB_PREFIX.'jobs
		               WHERE UNIX_TIMESTAMP(expires) > UNIX_TIMESTAMP(NOW()) AND is_tmp = 0  AND is_active = 1';
		
		if ($jobTypeID != 0)
		{
			$sql .= ' AND type_id = ' . $jobTypeID;
		}
		
		$sql .= ' ORDER BY spotlight DESC, created_on DESC limit ' . $startIndex . ',' . $numberOfJobsToGet;
		
		$result = $db->query($sql);
		
		while ($row = $result->fetch_assoc())
		{
			if ($favourites) {
 				if (count($_SESSION['favourites']) < 1)
 					return $jobs;
 				else {
 					if (in_array($row['id'], $_SESSION['favourites'])) {
 						$current_job = new Job($row['id']);
 						$jobs[] = $current_job->GetInfo();
 					}
 				}
 			} else {
 				$current_job = new Job($row['id']);
 				$jobs[] = $current_job->GetInfo();
 			}
		}
		
		return $jobs;
	}
	
	public function GetInactivePaginatedJobs($startIndex, $numberOfJobsToGet, $jobTypeID = 0)
	{
		global $db;
		$jobs = array();
		
		$sql = 'SELECT id
		               FROM '.DB_PREFIX.'jobs
		               WHERE is_active = 0 AND is_tmp = 0 ';
		
		if ($jobTypeID != 0)
		{
			$sql .= ' AND type_id = ' . $jobTypeID;
		}
		
		$sql .= ' ORDER BY spotlight DESC, created_on DESC limit ' . $startIndex . ',' . $numberOfJobsToGet;
		
		$result = $db->query($sql);
		
		while ($row = $result->fetch_assoc())
		{
			$current_job = new Job($row['id']);
			$jobs[] = $current_job->GetInfo();
		}
		
		return $jobs;
	}

	//Get all inactive jobs for admin 
	public function GetInactiveJobs($offset, $rowCount)
	{
		global $db;
		$jobs = array();
		
		$sql = 'SELECT id
		               FROM '.DB_PREFIX.'jobs
		               is_tmp = 0  AND is_active = 0
		               ORDER BY spotlight DESC, created_on DESC LIMIT ' . $offset .' , ' . $rowCount;
		
		$result = $db->query($sql);
		while ($row = $result->fetch_assoc())
		{
			$current_job = new Job($row['id']);
			$jobs[] = $current_job->GetBasicInfoAdmin();
		}
		return $jobs;
	}
	
	public function getInactiveJobCount()
	{
		global $db;
		$sql = 'SELECT COUNT(id) AS total FROM '.DB_PREFIX.'jobs WHERE is_active = 0 AND is_tmp = 0 ';
	
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		return $row['total'];	
	}
	
	//Get all inactive/active jobs for a specific category for admin
	// $type_id: freelance/fulltime/parttime
	// $categ_id: programatori/designeri/etc.
	// $limit: (int) how many results
	public function GetAllForCategoryJobsAdmin($type_id, $categ_id = false, $limit = false)
	{
		global $db;
		$jobs = array();
		$conditions = '';
		
		// if $categ_id is, in fact, the category's var_name, 
		// get the categs id
		if (!is_numeric($categ_id))
		{
			$categ_id = $this->GetCategId($categ_id);
		}
		// if $type_id is, in fact, the type's var_name, 
		// get the type's id
		if (!is_numeric($type_id))
		{
			$type_id = $this->GetTypeId($type_id);
		}
		
		if (is_numeric($type_id) && $type_id != 0)
		{
			$conditions .= ' AND type_id = ' . $type_id;
		}
		if (is_numeric($categ_id) && $categ_id != 0)
		{
			$conditions .= ' AND category_id = ' . $categ_id;
		}

		if ($type_id && is_numeric($type_id))
		{
			$conditions .= ' AND type_id = ' . $type_id;
		}

		$sql_limit = 'LIMIT ' . $limit;
			
		$sql = 'SELECT id
		               FROM '.DB_PREFIX.'jobs
		               WHERE 1 ' . $conditions . ' 
		               ' . $sql_limit;
		$result = $db->query($sql);
		while ($row = $result->fetch_assoc())
		{
			$current_job = new Job($row['id']);
			$jobs[] = $current_job->GetBasicInfoAdmin();
		}
		return $jobs;
	}
	
	
	// get jobs for API
	public function ApiGetJobs($type_id = false, $categ_id = false, $limit = false, $random, $days_behind, $for_feed = false, $city_id = false)
	{
		global $db;
		
		$jobs = array();
		$conditions = '';
		
		// if $categ_id is, in fact, the category's var_name, 
		// get the categs id
		if (!is_numeric($categ_id))
		{
			$categ_id = $this->GetCategId($categ_id);
		}
		// if $type_id is, in fact, the type's var_name, 
		// get the type's id
		if (!is_numeric($type_id))
		{
			$type_id = $this->GetTypeId($type_id);
		}
		
		if (is_numeric($type_id) && $type_id != 0)
		{
			$conditions .= ' AND type_id = ' . $type_id;
		}
		if (is_numeric($categ_id) && $categ_id != 0)
		{
			$conditions .= ' AND category_id = ' . $categ_id;
		}
		
		if ($days_behind > 0)
		{
			$conditions .=' AND created_on >= DATE_SUB(NOW(), INTERVAL ' . $days_behind . ' DAY)';
		}
		
		if ($for_feed)
		{
			// job was posted more than 10 minutes ago
			$conditions .= ' AND DATE_SUB(NOW(), INTERVAL 10 MINUTE) > created_on';
		}
		
		if ($city_id && is_numeric($city_id))
		{
			$conditions .= ' AND city_id = ' . $city_id;
		}

		if ($random == 1)
		{
			$order = ' ORDER BY RAND() ';
		}
		else
		{
			$order = ' ORDER BY spotlight DESC, created_on DESC ';
		}

		if($limit > 0)
			$sql_limit = 'LIMIT ' . $limit;
		else
			$sql_limit = '';
		
		$sql = 'SELECT id
		               FROM '.DB_PREFIX.'jobs
		               WHERE UNIX_TIMESTAMP(expires) > UNIX_TIMESTAMP(NOW()) AND 1 ' . $conditions . ' AND is_tmp = 0  AND is_active = 1  AND created_on > DATE_SUB(NOW(), INTERVAL 31 DAY)
		               ' . $order . ' ' . $sql_limit;
		$result = $db->query($sql);
		while ($row = $result->fetch_assoc())
		{
			$current_job = new Job($row['id']);
			$job = $current_job->GetInfo();
			unset($job['poster_email']);
			unset($job['auth']);
			$jobs[] = $job;
		}
		return $jobs;
	}

	// Get all jobs published by a company
	public function ApiGetJobsByCompany($company = false, $limit = false, $for_feed = false)
	{
		global $db;
		
		$jobs = array();
		$conditions = '';
		
		if ($company !== false)
		{
			$conditions .= ' AND company LIKE "' . $db->getConnection()->real_escape_string($company) . '"';
		}
		
		if ($for_feed)
		{
			// job was posted more than 10 minutes ago
			$conditions .= ' AND DATE_SUB(NOW(), INTERVAL 10 MINUTE) > created_on';
		}
		
		if($limit > 0)
			$sql_limit = 'LIMIT ' . $limit;
		else
			$sql_limit = '';
		
		$sql = 'SELECT id
		               FROM '.DB_PREFIX.'jobs
		               WHERE UNIX_TIMESTAMP(expires) > UNIX_TIMESTAMP(NOW()) AND 1 ' . $conditions . ' AND is_tmp = 0  AND is_active = 1
		               ORDER BY spotlight DESC, created_on DESC ' . $sql_limit;
		$result = $db->query($sql);
		while ($row = $result->fetch_assoc())
		{
			$current_job = new Job($row['id']);
			$job = $current_job->GetInfo();
			$jobs[] = $job;
		}
		return $jobs;
	}
		
	public function getJobsByCompanyEmployerId($emp_id) {
		global $db;
		
		$jobs = array();
		$conditions = '';
		
		// if($limit > 0)
		// 	$sql_limit = 'LIMIT ' . $limit;
		// else
		// 	$sql_limit = '';
		
		$sql = 'SELECT id
		               FROM '.DB_PREFIX.'jobs
		               WHERE UNIX_TIMESTAMP(expires) > UNIX_TIMESTAMP(NOW()) AND is_tmp = 0  AND is_active = 1
		               AND employer_id = ' . $emp_id . ' ORDER BY spotlight DESC, created_on DESC ' . $sql_limit;
		$result = $db->query($sql);
		while ($row = $result->fetch_assoc())
		{
			$current_job = new Job($row['id']);
			$job = $current_job->GetInfo();
			$jobs[] = $job;
		}
		return $jobs;
	}
	
	public function SearchSimplified($keywords, $url_query, $start_page = 1)
	{
	    global $db;
	   	$jobs = array();
		$conditions = '';
		$_SESSION['keywords_array'] = array();
		  
		  	$kw1 = $kw2 = $extra_conditions = '';
			$found_city = false;
			
			if (strstr($keywords, ',') || strstr($keywords, ', '))
			{
				$tmp = explode(',', $keywords);
				$kw1 = trim($tmp[0]);
				$kw2 = trim($tmp[1]);
				if ($kw1 == '')
				{
					$kw1 = $kw2;
					$kw2 = '';
				}
			}
			else if (strstr($keywords, ' ') || strstr($keywords, '  '))
			{
				// filter out empty strings (can happen if there are many whitespaces between two words in the search string)
				$tmp = array_filter(explode(' ', $keywords));
				foreach ($tmp as $word)
				{
					//try to find city based on city_id
					$sql = 'SELECT id FROM '.DB_PREFIX.'cities WHERE name LIKE "%' . $word . '%"';
					$result = $db->query($sql);
					$row = $result->fetch_assoc();
					if ($row['id'] != '')
					{
						if ($found_city)
						{
							$conditions .= ' OR';
						}
 
						$conditions .= ' city_id = ' . $row['id'];
						$found_city = true;
						$keywords = trim(str_replace($word, '', $keywords));
					}
 
				}
				if ($found_city)
				{
					$conditions .= ' AND (title LIKE "%' . $keywords . '%" OR company LIKE "%' . $keywords . '%")';	
				}
			}

			if (!$found_city)
			{ 
				if ($kw1 != '')
				{
					//there is no 2 sylables companies, redirect to unexisting condition
					if (strlen($kw1) < 3)
						$kw1 = 'xyzw';

					$conditions .= ' (title LIKE "%' . $kw1 . '%" OR company LIKE "%' . $kw1 . '%")';
					$_SESSION['keywords_array'][] = $kw1;
				}
				if ($kw2 != '')
				{
					//there is no 2 sylables cities, redirect to unexisting condition
					if (strlen($kw2) < 3)
						$kw2 = 'xyzw';

					$sql = 'SELECT id FROM '.DB_PREFIX.'cities WHERE name LIKE "%' . $kw2 . '%"';
					$result = $db->query($sql);
					$row = $result->fetch_assoc();
					if ($row['id'] != '')
					{
						$extra_conditions .= ' city_id = ' . $row['id'];
						$conditions .= ' AND ' . $extra_conditions;
					}
					
					$_SESSION['keywords_array'][] = $kw2;
				}

				if ($kw1 == '' && $kw2 == '')
				{
					$sql = 'SELECT id FROM '.DB_PREFIX.'cities WHERE name LIKE "%' . $keywords . '%"';
					$result = $db->query($sql);
					$row = $result->fetch_assoc();
					if ($row['id'] != '')
					{
						$extra_conditions .= ' OR city_id = ' . $row['id'];
					}

					$conditions = 'title LIKE "%' . $keywords . '%" OR company LIKE "%' . $keywords . '%"' . $extra_conditions;
 
					$_SESSION['keywords_array'][] = $keywords;
				}
			}

			$sql = 'SELECT id
		               FROM '.DB_PREFIX.'jobs
		               WHERE UNIX_TIMESTAMP(expires) > UNIX_TIMESTAMP(NOW()) AND is_tmp = 0  AND is_active = 1 AND (' . $conditions . ')
		               ORDER BY spotlight DESC, created_on DESC';
		  
		$result = $db->query($sql);
		while ($row = $result->fetch_assoc())
		{
			$current_job = new Job($row['id']);
			$jobs[] = $current_job->GetInfo();
		}
		$_SESSION['search_results'] = $jobs;
		return $jobs;
		
	}

	// Search for jobs
	public function Search($keywords, $url_query, $start_page = 1)
	{
		global $db;
		$jobs = array();
		$conditions = '';
		$_SESSION['keywords_array'] = array();

		if (SEARCH_METHOD == 'classic')
		{
			$kw1 = $kw2 = $extra_conditions = '';
			$found_city = false;
			
			if (strstr($keywords, ',') || strstr($keywords, ', '))
			{
				$tmp = explode(',', $keywords);
				$kw1 = trim($tmp[0]);
				$kw2 = trim($tmp[1]);
				if ($kw1 == '')
				{
					$kw1 = $kw2;
					$kw2 = '';
				}
			}
			else if (strstr($keywords, ' ') || strstr($keywords, '  '))
			{
				// filter out empty strings (can happen if there are many whitespaces between two words in the search string)
				$tmp = array_filter(explode(' ', $keywords));
				foreach ($tmp as $word)
				{
					//try to find city based on city_id
					$sql = 'SELECT id FROM '.DB_PREFIX.'cities WHERE name LIKE "%' . $word . '%"';
					$result = $db->query($sql);
					$row = $result->fetch_assoc();
					if ($row['id'] != '')
					{
						if ($found_city)
						{
							$conditions .= ' OR';
						}
 
						$conditions .= ' city_id = ' . $row['id'];
						$found_city = true;
						$keywords = trim(str_replace($word, '', $keywords));
					}
 
				}
				if ($found_city)
				{
					$conditions .= ' AND (title LIKE "%' . $keywords . '%" OR company LIKE "%' . $keywords . '%")';	
				}
			}

			if (!$found_city)
			{ 
				if ($kw1 != '')
				{
					//there is no 2 sylables companies, redirect to unexisting condition
					if (strlen($kw1) < 3)
						$kw1 = 'xyzw';

					$conditions .= ' (title LIKE "%' . $kw1 . '%" OR company LIKE "%' . $kw1 . '%")';
					$_SESSION['keywords_array'][] = $kw1;
				}
				if ($kw2 != '')
				{
					//there is no 2 sylables cities, redirect to unexisting condition
					if (strlen($kw2) < 3)
						$kw2 = 'xyzw';

					$sql = 'SELECT id FROM '.DB_PREFIX.'cities WHERE name LIKE "%' . $kw2 . '%"';
					$result = $db->query($sql);
					$row = $result->fetch_assoc();
					if ($row['id'] != '')
					{
						$extra_conditions .= ' city_id = ' . $row['id'];
						$conditions .= ' AND ' . $extra_conditions;
					}
					
					$_SESSION['keywords_array'][] = $kw2;
				}

				if ($kw1 == '' && $kw2 == '')
				{
					$sql = 'SELECT id FROM '.DB_PREFIX.'cities WHERE name LIKE "%' . $keywords . '%"';
					$result = $db->query($sql);
					$row = $result->fetch_assoc();
					if ($row['id'] != '')
					{
						$extra_conditions .= ' OR city_id = ' . $row['id'];
					}

					$conditions = 'title LIKE "%' . $keywords . '%" OR company LIKE "%' . $keywords . '%"' . $extra_conditions;
 
					$_SESSION['keywords_array'][] = $keywords;
				}
			}

			$sql = 'SELECT id
		               FROM '.DB_PREFIX.'jobs
		               WHERE UNIX_TIMESTAMP(expires) > UNIX_TIMESTAMP(NOW()) AND is_tmp = 0  AND is_active = 1 AND (' . $conditions . ')
		               ORDER BY spotlight DESC, created_on DESC';

			$result = $db->query($sql);
		}
		/* no need for alternate search at the moment keep it simple*/
		/*else
		{
			$cities = array();
			$check_cities = '';
 
		    $keywords = str_replace(","," ", $keywords);
		    $keywords = str_replace("  "," ", $keywords);
		    $keywords = rtrim($keywords);
 
		    $keywords_a = preg_split( "/[\s,]*\\'([^\\\"]+)\\'[\s,]*|[\s,]+/", $keywords, 0, PREG_SPLIT_DELIM_CAPTURE );
		    function array_trim($a) { $j = 0; for ($i = 0; $i < count($a); $i++) { if ($a[$i] != "") { $b[$j++] = $a[$i]; } } return $b; }
		    $keywords_r = array_trim($keywords_a);
 
		    //Search in Cities
		    for ($i=0; $i < count($keywords_r); $i++)
		    {
		      $sql = 'SELECT id
		                     FROM '.DB_PREFIX.'cities
		                     WHERE name LIKE "%'. $keywords_r[$i] .'%"
		                     ORDER BY spotlight DESC, ID ASC';
		      $result = $db->query($sql);
		      $cities_line = '';
 
		      while ($row = $result->fetch_assoc())
		      {
		        $cities_line .= $row['id'].' ';
		      }
		      $cities[$i] = $cities_line;
		    }
 
		    //Search in Jobs
		    for ($i=0; $i < count($keywords_r); $i++)
		    {
		        if ($cities[$i] != "") {
		          $cities[$i] = rtrim($cities[$i]);
		          $cities_r = explode(' ', $cities[$i]);
 
		          for ($a=0; $a < count($cities_r); $a++)
		          {
		            $check_cities .= 'OR city_id = "'.$cities_r[$a].'" ';
		          }
		        }
		        $conditions .= 'AND (title LIKE "%' . $keywords_r[$i] . '%" OR company LIKE "%' . $keywords_r[$i] . '%" OR description LIKE "%' . $keywords_r[$i] . '%" '.$check_cities.' ) ';
		    }
 
			$sql = 'SELECT id
					FROM '.DB_PREFIX.'jobs
					WHERE UNIX_TIMESTAMP(expires) > UNIX_TIMESTAMP(NOW()) AND is_tmp = 0  AND is_active = 1 '. $conditions .'
					ORDER BY spotlight DESC, created_on DESC';

			$result = $db->query($sql);
		}*/
 
		$pages = '';
		$id_array = '';
		//$max_loop = SEARCH_RESULTS_PER_PAGE;
		//$max_visible_pages = SEARCH_AMOUNT_PAGES;



		/* !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! */
		/* NO PAGINATION IN SEARCH RESULTS FOR THE MOMENT. DONE IN NEXT RELEASE */
		/* there wont be more than 100 results anyway */
		$max_loop = 100; //JOBS_PER_PAGE
		/* #####################################################################*/

		$max_visible_pages = 10;
 
		while ($row = $result->fetch_assoc()) $id_array[] = $row['id'];
 
		$start_count = (($start_page - 1) * $max_loop) ;
		$current_loop = 0;
 
		$total_results = count($id_array);
		$total_loop = ($total_results ) - $start_count;
 
		$total_pages = ceil($total_results / $max_loop);
 
		if ($total_pages > 1)
		{
 
			$pagination_loop = $start_page - ($max_visible_pages / 2);
 
			if ($pagination_loop < 1) $pagination_loop = 1;
			elseif (($pagination_loop - 1) > 0) $pages .= "&nbsp;<a href='".BASE_URL."search/".$url_query."/?p=".($pagination_loop - 1)."'>&laquo;</a>&nbsp;";
 
			$pagination_top = $pagination_loop + $max_visible_pages + 1;
 
			while (($pagination_loop < ($total_pages+1)) && ($pagination_loop < $pagination_top))
			{
				if ($pagination_loop == $start_page) $pages .= "&nbsp;<a class='current_page' href='".BASE_URL."search/".$url_query."/?p=$pagination_loop'>$pagination_loop</a>&nbsp;";
				else $pages .= "&nbsp;<a href='".BASE_URL."search/".$url_query."/?p=$pagination_loop'>$pagination_loop</a>&nbsp;";
				$pagination_loop++;	
			}
 
			if ($pagination_loop == $pagination_top) $pages .= "&nbsp;<a href='".BASE_URL."search/".$url_query."/?p=".($pagination_loop)."'>&raquo;</a>&nbsp;";
 
		}
 
		if ($id_array != '')
		{
			while (($current_loop < $total_loop) && ($current_loop < ($max_loop )))
			{
				$current_job = new Job($id_array[$start_count]);
				$jobs[] = $current_job->GetInfo();
				$current_loop++;
				$start_count++;
			}
		}

		$_SESSION['search_results'] = $jobs;
		$_SESSION['search_pagination'] = $pages;
		return $jobs;
	}
	
	public function publishTheJOb($id) {
		global $db;
		$sql = 'UPDATE '.DB_PREFIX.'jobs SET is_tmp = 0 WHERE id = ' . $id;
		$result = $db->query($sql);
		return $result;
	}

	public function GetCategId($var_name)
	{
		global $db;
		$sql = 'SELECT id
		               FROM '.DB_PREFIX.'categories
		               WHERE var_name = "' . $var_name . '"';
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		return $row['id'];
	}
	
	public function GetTypeId($var_name)
	{
		global $db;
		$sql = 'SELECT id
		               FROM '.DB_PREFIX.'types
		               WHERE var_name = "' . $var_name . '"';
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		return $row['id'];
	}
    
    public function GetLocationId($var_name)
    {
        global $db;
        $sql = 'SELECT id
                       FROM '.DB_PREFIX.'cities
                       WHERE ascii_name = "' . $var_name . '"';
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        return $row['id'];
    }
    
    public function CountJobsOfTypeCategoryId($cat_id)
    {
        global $db;
        $totalcountid = count($cat_id);
        for( $i=0; $i<$totalcountid; $i++)
        {
           $catttidd[] = $cat_id[$i]; 
        }
        $res_idss = implode(",", $catttidd);

        $sql = 'SELECT COUNT(id) AS total FROM '.DB_PREFIX.'jobs WHERE is_tmp = 0 AND is_active = 1 AND category_id in (' . $res_idss.')';
        
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    
    public function CountJobsOfTypeLocationId($loc_id)
    {
        global $db;
        $totalcountid = count($loc_id);
        for( $i=0; $i<$totalcountid; $i++)
        {
           $catttidd[] = $loc_id[$i]; 
        }
        $res_idss = implode(",", $catttidd);

        $sql = 'SELECT COUNT(id) AS total FROM '.DB_PREFIX.'jobs WHERE is_tmp = 0 AND is_active = 1 AND city_id in (' . $res_idss.')';
        
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    
    public function CountJobsOfTypeId($type_id)
    {
        global $db;
        $totalcountid = count($type_id);
        for( $i=0; $i<$totalcountid; $i++)
        {
           $typid[] = $type_id[$i]; 
        }
        $res_idss = implode(",", $typid);
        
        $sql = 'SELECT COUNT(id) AS total FROM '.DB_PREFIX.'jobs WHERE is_tmp = 0 AND is_active = 1 AND type_id in (' . $res_idss.')';
        
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    
    public function GetPaginatedJobsFilter($startIndex, $numberOfJobsToGet, $jobTypeID, $catTypeID, $location_id, $favourites)
    {
        global $db;
        $jobs = array();
        
        // type id start here
        $totalcountid_type = count($jobTypeID);
        for( $i=0; $i<$totalcountid_type; $i++)
        {
           $typee_idd[] = $jobTypeID[$i]; 
        }
        $res_type_idss = implode(",", $typee_idd);
        
        //category id start here
        $totalcountid_cat = count($catTypeID);
        for( $i=0; $i<$totalcountid_cat; $i++)
        {
           $cattt_idd[] = $catTypeID[$i]; 
        }
        $res_cat_idss = implode(",", $cattt_idd);
        // Location id start here
        $totalcountid_lctn = count($location_id);
        for( $i=0; $i<$totalcountid_lctn; $i++)
        {
           $location_idd[] = $location_id[$i]; 
        }
        $res_location_idss = implode(",", $location_idd);            
        
        if(($jobTypeID) || ($catTypeID) || ($location_id))
        {
         if($jobTypeID){
             $jobqry = 'type_id in (' . $res_type_idss.') OR ';
         }else{
             $jobqry = 'type_id in ("") OR ';
         }
         if($catTypeID){
             $catqry = 'category_id in (' . $res_cat_idss.') OR ';
         }else{
             $catqry = 'category_id in ("") OR ';
         }
         if($location_id){
             $locationqry = 'city_id in (' . $res_location_idss.')';
         }else{
             $locationqry = 'city_id in ("")';
         }
        $sql = 'SELECT id
                       FROM '.DB_PREFIX.'jobs WHERE UNIX_TIMESTAMP(expires) > UNIX_TIMESTAMP(NOW()) AND is_tmp = 0  AND is_active = 1 AND ('.$jobqry.''.$catqry.''.$locationqry.') ORDER BY spotlight DESC, created_on DESC limit ' . $startIndex . ',' . $numberOfJobsToGet;
                //exit;

        }else{
            $sql = 'SELECT id
                       FROM '.DB_PREFIX.'jobs
                       WHERE UNIX_TIMESTAMP(expires) > UNIX_TIMESTAMP(NOW()) AND is_tmp = 0  AND is_active = 1 ORDER BY spotlight DESC, created_on DESC limit ' . $startIndex . ',' . $numberOfJobsToGet;
        }

        $result = $db->query($sql);
        
        while ($row = $result->fetch_assoc())
        {
            if ($favourites) {
                 if (count($_SESSION['favourites']) < 1)
                     return $jobs;
                 else {
                     if (in_array($row['id'], $_SESSION['favourites'])) {
                         $current_job = new Job($row['id']);
                         $jobs[] = $current_job->GetInfo();
                     }
                 }
             } else {
                 $current_job = new Job($row['id']);
                 $jobs[] = $current_job->GetInfo();
             }
        }
        
        return $jobs;
    }
    

	public function GetJobTypeName($id)
	{
		global $db;
		$sql = 'SELECT name
		               FROM '.DB_PREFIX.'types
		               WHERE id = "' . $id . '"';
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		return $row['name'];
	}

	public function GetJobTypeVarName($id)
	{
		global $db;
		$sql = 'SELECT var_name
		               FROM '.DB_PREFIX.'types
		               WHERE id = "' . $id . '"';
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		return $row['var_name'];
	}
	
	public function GetActiveStatus()
	{
		return $this->mIsActive;
	}

	public function IncreaseViewCount()
	{
		global $db;
		// check if user has hit this page in the past hour
		$ip = $_SERVER['REMOTE_ADDR'];
    //extract number of hits on last hour
    $sql = 'SELECT count(*) AS hits_last_hour '.
           'FROM '.DB_PREFIX.'hits WHERE job_id = ' . $this->mId . ' AND ip = "' . $ip . '" AND '.
           'created_on >= DATE_ADD(NOW(),INTERVAL -1 HOUR)';
		$result = $db->QueryItem($sql);

		// ok to increase view count
		if ($result < MAX_VISITS_PER_HOUR)
		{
			// update hits table
			$sql = 'INSERT INTO '.DB_PREFIX.'hits (job_id, created_on, ip)
			                    VALUES (' . $this->mId . ', NOW(), "' . $ip . '")';
			$db->query($sql);
			
			// update jobs table
			$sql = 'UPDATE '.DB_PREFIX.'jobs SET views_count = views_count + 1
										 WHERE id = ' . $this->mId;
			$db->query($sql);	

			//statistics table

			//is there already entry for today?
			$today = date("Y-m-d");
			$sql = 'SELECT id FROM '.DB_PREFIX.'statistics
								 WHERE date = "' . $today . '" AND job_id = ' . $this->mId;
			$result = $db->query($sql);

			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				//update
				$sql = 'UPDATE '.DB_PREFIX.'statistics SET views = views + 1
			 					 WHERE id = ' . $row['id'];
			 	$result = $db->query($sql);
			} else {
				//create
				$sql = 'INSERT INTO '.DB_PREFIX.'statistics (date, job_id, views, applications)
	                         VALUES ("' . $today . '",
	                         		 ' . $this->mId . ',
	                         		 1,
	                         		 0)';

				$result = $db->query($sql);


			}
			// ############################### statistics

		}
	}

	// Create a new job post
	public function Create($params)
	{
		global $db;
		
		$sql = 'INSERT INTO '.DB_PREFIX.'jobs (type_id, employer_id, category_id, title, description, created_on, expires, is_active, 
			                       views_count, city_id, apply_online, apply_desc, company, spotlight, salary, is_tmp)
		                         VALUES (' . $params['type_id'] . ',
		                         		 ' . $params['employer_id'] . ',
		                                 ' . $params['category_id'] . ',
		                                 "' . $params['title'] . '",
		                                 "' . $params['description'] . '",
		                                 NOW(), NOW() + INTERVAL '. $params['job_period'] .' DAY,
		                                 '. $params['is_active'] .',
		                                 0,
		                                 '. $params['city_id'] .',
		                                 ' . $params['apply_online'] . ',
		                                 "' . $params['apply_desc'] . '",
		                                 "' . $params['company'] . '",
		                                 '. $params['spotlight'] .',
		                                 "' . $params['salary'] . '",
		                                 '. $params['is_tmp'] .')';
		$result = $db->query($sql);
		return $result;
	}
	
	// Edit an existing job post
	public function Edit($params)
	{
		global $db;

		$sql = 'UPDATE '.DB_PREFIX.'jobs SET type_id = ' . $params['type_id'] . ',
        										category_id = ' . $params['category_id'] . ',
										        title = "' . $params['title'] . '",
										        description = "' . $params['description'] . '",
										        city_id = ' . $params['city_id'] . ',
												apply_online = ' . $params['apply_online'] . ',
												salary = "' . $params['salary'] . '",
												apply_desc = "' . $params['apply_desc'] . '"
										        WHERE id = ' . $params['job_id'];

		//	is_tmp = 1
		$result = $db->query($sql);
		return $result;
	}
	
	// Publishes a newly created job post (is_temp => 0)
	public function Publish()
	{
		global $db;
		
		$sql = 'UPDATE '.DB_PREFIX.'jobs SET is_tmp = 0, is_active = 1 WHERE id = ' . $this->mId;
		
		$db->query($sql);
	}
	
	// Activate an inactive job post
	public function Activate()
	{
		global $db;
		$sql = 'UPDATE '.DB_PREFIX.'jobs SET is_active = 1, expires = NOW() + INTERVAL ' . JOB_EXPIRES . ' DAY WHERE id = ' . $this->mId;
		$db->query($sql);
	}
	
	// Deactivate an active job post
	public function Deactivate($id)
	{
		global $db;
		$sql = 'UPDATE '.DB_PREFIX.'jobs SET is_active = 0 WHERE id = ' . $id;
		$db->query($sql);
	}
	
	//Activate spotlight-feature for a job post
    public function SpotlightActivate()
    {
        global $db;
        $sql = 'UPDATE '.DB_PREFIX.'jobs SET spotlight = 1 WHERE id = ' . $this->mId;
        $db->query($sql);
    }
    
    // Deactivate spotlight-feature for a job post
    public function SpotlightDeactivate()
    {
        global $db;
        $sql = 'UPDATE '.DB_PREFIX.'jobs SET spotlight = 0 WHERE id = ' . $this->mId;
        $db->query($sql);
    }
	
	// Extend a post for 30 days
	public function Extend()
	{
		global $db;
		$sql = 'UPDATE '.DB_PREFIX.'jobs SET created_on = NOW(), is_active = 1 WHERE id = ' . $this->mId;
		if ($db->query($sql))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	// Make a post temporary
	public function MarkTemporary()
	{
		global $db;
		$sql = 'UPDATE '.DB_PREFIX.'jobs SET is_temp = 1 WHERE id = ' . $this->mId;
		$db->query($sql);
	}

	public function deleteById($id) {

		if ($id != NULL) {
			global $db;
			$sql = 'DELETE FROM '.DB_PREFIX.'jobs WHERE id = ' . $id;
			$db->query($sql);

			$sql = 'DELETE FROM '.DB_PREFIX.'job_applications WHERE job_id = ' . $id;
			$db->query($sql);

			$sql = 'DELETE FROM '.DB_PREFIX.'statistics WHERE job_id = ' . $id;
			$db->query($sql);

			$sql = 'DELETE FROM '.DB_PREFIX.'hits WHERE job_id = ' . $id;
			$db->query($sql);

			$sql = 'DELETE FROM '.DB_PREFIX.'spam_reports WHERE job_id = ' . $id;
			$db->query($sql);

		}
	}
	
	// Delete a job post
	public function Delete()
	{
		global $db;
		$sql = 'DELETE FROM '.DB_PREFIX.'jobs WHERE id = ' . $this->mId;
		$db->query($sql);

		$sql = 'DELETE FROM '.DB_PREFIX.'job_applications WHERE job_id = ' . $this->mId;
		$db->query($sql);

		$sql = 'DELETE FROM '.DB_PREFIX.'statistics WHERE job_id = ' . $this->mId;
		$db->query($sql);

		$sql = 'DELETE FROM '.DB_PREFIX.'hits WHERE job_id = ' . $this->mId;
		$db->query($sql);

		$sql = 'DELETE FROM '.DB_PREFIX.'spam_reports WHERE job_id = ' . $this->mId;
		$db->query($sql);

	}
	
	// Delete a job post and all aditional information
	public function DeleteJobAdmin()
	{
		global $db;

		$sql = 'DELETE FROM '.DB_PREFIX.'hits WHERE job_id  = ' . $this->mId;
		$res = $db->query($sql);

		$sql = 'DELETE FROM '.DB_PREFIX.'job_applications WHERE job_id  = ' . $this->mId;
		$res = $res && $db->query($sql);

		$sql = 'DELETE FROM '.DB_PREFIX.'spam_reports WHERE job_id  = ' . $this->mId;
		$res = $res && $db->query($sql);

		$sql = 'DELETE FROM '.DB_PREFIX.'statistics WHERE job_id  = ' . $this->mId;
		$res = $res && $db->query($sql);

		$sql = 'DELETE FROM '.DB_PREFIX.'jobs WHERE id  = ' . $this->mId;
		$res = $res && $db->query($sql);

		//foreach ($cvs as $row) {
		//	@unlink(APP_PATH . FILE_UPLOAD_DIR . $row['cv_path']);
		//}

		return ($res==false)?$res:true;
	}
	public function MakeValidUrl($string)
	{
		$string = urlencode($string);
		return $string;
	}
	
	public function Exists()
	{
		if ($this->mCreatedOn != '')
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function GenerateAuthCode()
	{
		$auth = md5($this->mId . uniqid() . time());
		return $auth;
	}
	
	public function GetInActiveJobsCount() {
		global $db;
		$sql = 'SELECT COUNT(id) AS total FROM '.DB_PREFIX.'jobs WHERE is_active = 0 AND is_tmp = 0 ';
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		return $row['total'];
	}


	public function countSearchedJobs($job_title, $job_location) {
		global $db;

		$condition = '';

		if ($job_title && !empty($job_title)) {
			$condition .= ' AND title LIKE "%' . $job_title . '%"';
		}

		if ($job_location && !empty($job_location)) {
			$condition .= ' AND city_id = ' . $job_location;
		}

		$sql = 'SELECT COUNT(id) as total FROM '.DB_PREFIX.'jobs WHERE UNIX_TIMESTAMP(expires) > UNIX_TIMESTAMP(NOW()) AND is_tmp = 0  AND is_active = 1' . $condition;
		$result = $db->query($sql);

		$row = $result->fetch_assoc();
		return $row['total'];
	}

	public function CountJobs($categ = false, $type = false)
	{
		global $db;
		$condition = '';

		if ($categ)
		{
			if (!is_numeric($categ))
			{
				$categ_id = $this->GetCategId($categ);
			}
			else
			{
				$categ_id = $categ;
			}
			if (!empty($categ_id))
				$condition .= ' AND category_id = ' . $categ_id;
		}

		if ($type)
		{
			if (!is_numeric($type))
			{
				$type_id = $this->GetTypeId($type);
			}
			else
			{
				$type_id = $type;
			}
			
			$condition .= ' AND type_id = ' . $type_id;
		}


		$sql = 'SELECT COUNT(id) AS total FROM '.DB_PREFIX.'jobs WHERE UNIX_TIMESTAMP(expires) > UNIX_TIMESTAMP(NOW()) AND is_tmp = 0  AND is_active = 1' . $condition;

		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		return $row['total'];
	}
	
	public function CountJobsOfType($type_id)
	{
		global $db;

		$sql = 'SELECT COUNT(id) AS total FROM '.DB_PREFIX.'jobs WHERE is_tmp = 0 AND is_active = 1 AND type_id = ' . $type_id;
		
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		return $row['total'];
	}

	public function getSMprofiles() {
		global $db;

		$sql = 'SELECT * FROM '.DB_PREFIX.'social_media'; 
		$result = $db->query($sql);
		$data = array();

		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}
	
	public function GetJobsCountForAllCategs()
	{
		global $db;
		$jobsCountPerCategory = array();
		
		$sql = 'SELECT category_id, COUNT(id) AS total FROM '.DB_PREFIX.'jobs WHERE is_tmp = 0 AND is_active = 1 GROUP BY category_id'; 
		$result = $db->query($sql);
		
		while ($row = $result->fetch_assoc())
			$jobsCountPerCategory[$row['category_id']] = $row['total'];
			
		$categs = get_categories();
		$result = array();
		foreach ($categs as $categ)
		{
			$count = 0;
			
			// this check is needed because we don't have an entry if there are no jobs for a category
			if (isset($jobsCountPerCategory[$categ['id']]))
				$count = $jobsCountPerCategory[$categ['id']];
				
			$result[] = array('categ_name' => $categ['name'], 'UTF-8', 'categ_count' => $count, 'categ_varname' => $categ['var_name']);
		}
		return $result;
	}
	
	public function GetJobsCountForCity($city_id, $type)
	{
		global $db;
		
		$condition = '';
		
		if ($city_id)
		{
			$condition = ' AND city_id = ' . $city_id;
		}
		else
		{
			$condition = ' AND city_id IS NULL';
		}
		
		if ($type)
		{
			if (!is_numeric($type))
			{
				$type_id = $this->GetTypeId($type);
			}
			else
			{
				$type_id = $type;
			}
			
			$condition .= ' AND type_id = ' . $type_id;
		}
		
		$sql = 'SELECT COUNT(id) AS total FROM '.DB_PREFIX.'jobs WHERE is_tmp = 0  AND is_active = 1'. $condition;

		$result = $db->query($sql);
		
		$row = $result->fetch_assoc();
		
		return $row['total'];
	}
	

	public function getCountriesForHeader() {
		global $db;
		$countries = array();
		$cache = new Cache(APP_PATH . '_cache/', null, USE_CACHE);

		if ($cache->testCache('SIDEBAR_COUNTRIES_CACHE')) 
		{
		   $countries = $cache->loadCache('SIDEBAR_COUNTRIES_CACHE');
		} else {
			$sql = '
				SELECT id, name, ascii_name
				FROM '.DB_PREFIX.'cities ORDER BY name';
			$result = $db->query($sql);

			
			while ($country = $result->fetch_assoc()) { 
				$name = $country['name'];
				$isql = '
						SELECT COUNT(id) as "' . $name .'" FROM jobs WHERE city_id = "' .$country['id'] . '"' . ' AND is_active = 1 AND UNIX_TIMESTAMP(expires) > UNIX_TIMESTAMP(NOW())';
				$inner_result = $db->query($isql);
				$entry = $inner_result->fetch_assoc();

				if ($entry[$name] > 0) {
					$t = new stdClass;
					$t->url = $country["ascii_name"];
					$t->jobs_count = $entry[$name];
					$countries[$name] = $t;
				}
			}
			$cache->saveCache($countries, 'SIDEBAR_COUNTRIES_CACHE');
		}

		return $countries;
	}

	/*
      JOB TYPES ARE FETCHED FROM _lib/functions.php get_types() function
	*/

	public function getCategoriesForHeader() {
		global $db;
		//final array
		$cats = array();
		$cache = new Cache(APP_PATH . '_cache/', null, USE_CACHE);

		if ($cache->testCache('SIDEBAR_CATEGORIES_CACHE')) 
		{
		   $cats = $cache->loadCache('SIDEBAR_CATEGORIES_CACHE');
		} else {
			$sql = '
					SELECT id, name, var_name
					FROM '.DB_PREFIX.'categories 
					ORDER BY category_order';
			$result = $db->query($sql);

			
			//for each category get number of jobs
			while ($category = $result->fetch_assoc()) {
				$cname = $category["name"];
				$inner_sql = '
							SELECT COUNT(id) as "' . $cname .'" FROM jobs WHERE category_id="' . $category["id"] . '" AND is_active = 1 AND UNIX_TIMESTAMP(expires) > UNIX_TIMESTAMP(NOW())';
				$inner_result = $db->query($inner_sql);
				$entry = $inner_result->fetch_assoc();
				//only cats with existing jobs
				if ((int)$entry[$cname] > 0) {
					$cl = new stdClass;
					$cl->url = $category["var_name"];
					$cl->jobs = (int)$entry[$cname];
					$cats[$cname] = $cl;
				}
			}
			$cache->saveCache($cats, 'SIDEBAR_CATEGORIES_CACHE');
		}

		return $cats;
	}

	public function getCitiesWithId() {
		global $db;
		$sql = '
				SELECT id, name
				FROM '.DB_PREFIX.'cities 
				ORDER BY name';

		$result = $db->query($sql);
		$cities = array();
		while ($category = $result->fetch_assoc()) {
			$cities[$category['id']] = $category['name'];
		}
		return $cities;
	}

	public function getCitiesWithJobs() {
		global $db;
		$sql = '
				SELECT id, name
				FROM '.DB_PREFIX.'cities 
				ORDER BY name';

		$result = $db->query($sql);
		$cities = array();
		while ($category = $result->fetch_assoc()) {

			$isql = '
				SELECT id
				FROM '.DB_PREFIX.'jobs 
				WHERE is_active = 1 AND UNIX_TIMESTAMP(expires) > UNIX_TIMESTAMP(NOW()) AND city_id =' . $category['id'];
			$r = $db->query($isql);

			if ($r->num_rows > 0)
				$cities[$category['id']] = $category['name'];

		}
		return $cities;
	}

	function getIndeedLocations() {

		if (INDEED_HOMEPAGE_DROPDOWN == 'cities')
			$ICAT_ID = 3;
		else
			$ICAT_ID = 2;

		global $db;

		$sql = '
				SELECT name, value
				FROM '.DB_PREFIX.'indeed_search_options WHERE category_id = ' . $ICAT_ID . ' ORDER BY name';

		$result = $db->query($sql);
		$cities = array();
		while ($category = $result->fetch_assoc()) {

			$cities[$category['value']] = $category['name'];

		}
		return $cities;
	}

	public function getJobTypesWithIds(){
		global $db;

		$sql = '
				SELECT id, name
				FROM '.DB_PREFIX.'types 
				ORDER BY id';

		$result = $db->query($sql);
		$types = array();
		while ($category = $result->fetch_assoc()) {
			$types[$category['id']] = $category['name'];
		}
		return $types;
	}

	public function getCategoriesWithIds() {
		global $db;

		$sql = '
				SELECT id, name
				FROM '.DB_PREFIX.'categories 
				ORDER BY category_order';

		$result = $db->query($sql);
		$cats = array();
		while ($category = $result->fetch_assoc()) {
			$cats[$category['id']] = $category['name'];
		}
		return $cats;
	}


	
	public function GetPaginatedJobsForOtherCities($type_id = false, $firstLimit = false, $lastLimit = false)
	{
		global $db;
		$jobs = array();
		$conditions = '';
		
		// if $type_id is, in fact, the type's var_name, 
		// get the type's id
		if (!is_numeric($type_id))
		{
			$type_id = $this->GetTypeId($type_id);
		}
		
		if (is_numeric($type_id) && $type_id != 0)
		{
			$conditions .= ' AND type_id = ' . $type_id;
		}

		if ($firstLimit >= 0 && $lastLimit >= 0)
		{
			$sql_limit = 'LIMIT ' . $firstLimit .', ' . $lastLimit;
		}
		else
		{
		        $sql_limit = '';        
		}
		
		$sql = 'SELECT id
		               FROM '.DB_PREFIX.'jobs
		               WHERE UNIX_TIMESTAMP(expires) > UNIX_TIMESTAMP(NOW()) AND city_id = 0 ' . $conditions . ' AND is_active = 1
		               ORDER BY spotlight DESC, created_on DESC ' . $sql_limit;
		
		$result = $db->query($sql);
		while ($row = $result->fetch_assoc())
		{
			$current_job = new Job($row['id']);
			$jobs[] = $current_job->GetInfo();
		}
		return $jobs;
	}

	public function getJobStatisticsById($id) {
		global $db;

		$statisticalData = array();
		$sql = 'SELECT * FROM '.DB_PREFIX.'statistics 
				WHERE job_id = ' . $id . ' ORDER BY date';

		$result = $db->query($sql);

		while ($row = $result->fetch_assoc()) {
			$statisticalData[$row['id']] = $row;
		}

		return $statisticalData;
	}
	
	public function GetSpamReportStatistics($jobIDs)
	{
		global $db;
		
		$statisticalData = array();
		
		$sql = 'SELECT job_id, count(id) numberOfSpamReports, DATE_FORMAT(max(the_time), "' . DATE_TIME_FORMAT . '") lastSpamReportOn 
				FROM '.DB_PREFIX.'spam_reports 
				WHERE job_id in (' . $this->buildCommaSeparatedIDsString($jobIDs) . ') GROUP BY job_id'; 
		$result = $db->query($sql);
		
		while ($row = $result->fetch_assoc())
			$statisticalData[$row['job_id']] = $row;
			
		return $statisticalData;
	}

	public function GetInactiveJobByTitle($startIndex, $numberOfJobsToGet, $category_serach = ''){
		global $db;
		$jobs = array();
		
		$sql = "SELECT id
		               FROM ".DB_PREFIX."jobs
		               WHERE `title` LIKE '%".$category_serach."%' AND is_active = 0 AND is_tmp = 0 ";	
		
		$sql .= ' ORDER BY spotlight DESC, created_on DESC limit ' . $startIndex . ',' . $numberOfJobsToGet;
		
		$result = $db->query($sql);
		
		while ($row = $result->fetch_assoc())
		{
			$current_job = new Job($row['id']);
			$jobs[] = $current_job->GetInfo();
		}
		
		return $jobs;
	}
	
	public function GetInactiveJobsForCategoryByTitle($categoryID, $startIndex, $numberOfJobsToGet, $category_serach){
		
		global $db;
		$jobs = array();
		if (!empty($categoryID))
			$sql = "SELECT id
		               FROM ".DB_PREFIX."jobs
		               WHERE category_id = " . $categoryID . " AND `title` LIKE '%".$category_serach."%' AND is_tmp = 0  AND is_active = 0";			
		else
			$sql = "SELECT id
		               FROM ".DB_PREFIX."jobs
		               WHERE  `title` LIKE '%".$category_serach."%' AND is_active = 0 AND is_tmp = 0";

		$sql .= ' ORDER BY spotlight DESC, created_on DESC limit ' . $startIndex . ',' . $numberOfJobsToGet;
		
		$result = $db->query($sql);
		
		while ($row = $result->fetch_assoc())
		{
			$current_job = new Job($row['id']);
			$jobs[] = $current_job->GetInfo();
		}
		
		return $jobs;


	}

	public function GetPaginatedJobsByTitle($startIndex, $numberOfJobsToGet, $category_serach = '', $favourites = false){
		global $db;
		$jobs = array();	

		$sql = "SELECT id FROM `jobs` WHERE `title` LIKE '%".$category_serach."%' AND UNIX_TIMESTAMP(expires) > UNIX_TIMESTAMP(NOW()) AND is_tmp = 0  AND is_active = 1 ";
		
		$result = $db->query($sql);
		while ($row = $result->fetch_assoc())
		{
			$current_job = new Job($row['id']);
			$jobs[] = $current_job->GetInfo();
		}
		return $jobs;

	}

	public function GetJobsForCategoryByTitle($categoryID, $startIndex, $numberOfJobsToGet, $category_serach){

		global $db;
		$jobs = array();
		
		if (!empty($categoryID))
			$sql = "SELECT id
		               FROM ".DB_PREFIX."jobs
		               WHERE UNIX_TIMESTAMP(expires) > UNIX_TIMESTAMP(NOW()) AND category_id = " . $categoryID . " AND `title` LIKE '%".$category_serach."%' AND is_tmp = 0  AND is_active = 1";
		else
			$sql ="SELECT id
		               FROM ".DB_PREFIX."jobs
		               WHERE UNIX_TIMESTAMP(expires) > UNIX_TIMESTAMP(NOW()) AND `title` LIKE '%".$category_serach."%' AND is_tmp = 0  AND is_active = 1";
 
		$sql .= ' ORDER BY spotlight DESC, created_on DESC limit ' . $startIndex . ',' . $numberOfJobsToGet;          

		$result = $db->query($sql);
		while ($row = $result->fetch_assoc())
		{			
			$current_job = new Job($row['id']);
			$jobs[] = $current_job->GetInfo();
		}
		return $jobs;
	}


	public function countJobByTitle($categ = false,$con){
		global $db;
		if ($categ)
		{
			if (!is_numeric($categ))
			{
				$categ_id = $this->GetCategId($categ);
			}
			else
			{
				$categ_id = $categ;
			}
			if (!empty($categ_id))
				$condition .= ' AND category_id = ' . $categ_id;
		}
		$sql = "SELECT COUNT(id) AS total FROM ".DB_PREFIX."`jobs` WHERE UNIX_TIMESTAMP(expires) > UNIX_TIMESTAMP(NOW()) AND `is_tmp` = '0' AND `is_active` = '1' AND `title` LIKE '%".$con."%'" . $condition;


		$result = $db->query($sql);
		$row = $result->fetch_assoc();	
		
		return $row['total'];
	}

	private function buildCommaSeparatedIDsString($numbersArray)
	{
		$string = '';
		
		for ($i = 0; $i < count($numbersArray); $i++)
		{
			$string .= $numbersArray[$i];

			if ($i < count($numbersArray) - 1)
				$string .= ',';
		}
		
		return $string;
	}

}
?>
