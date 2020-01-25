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

class Stats
{
	const MAKE_STATS_ON_MAX_NUMBER_OF_APPLICATIONS = 50;
	const MAKE_STATS_ON_MAX_NUMBER_OF_SEARCHES = 50;
	 
	function __construct()
	{ }

	public function Applications()
	{
		global $db;
		
		$sql = 'SELECT count(a.job_id) AS totalNumberOfApplications
		                        FROM '.DB_PREFIX.'job_applications a, '.DB_PREFIX.'jobs b
		                        WHERE a.job_id = b.id';
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		
		$totalNumberOfApplications = $row['totalNumberOfApplications'];
		
		$sql = 'SELECT DATE_FORMAT(a.created_on, "' . DATE_TIME_FORMAT . '") AS date, b.title AS title, b.company AS company, a.job_id AS job_id
		                        FROM '.DB_PREFIX.'job_applications a, '.DB_PREFIX.'jobs b
		                        WHERE a.job_id = b.id
		                        ORDER BY a.created_on DESC limit ' . self::MAKE_STATS_ON_MAX_NUMBER_OF_APPLICATIONS;
		$result = $db->query($sql);
		
		$stats = '';
		while ($row = $result->fetch_assoc())
			$stats .= '<div>' . $row['date'] . ' <a href="' . BASE_URL . URL_JOB .'/' . $row['job_id'] . '/">' . $row['title'] . ' la ' . $row['company'] . '</a></div>';
		
		$apps_per_day = array();
		$sql = 'SELECT count(id) AS nr FROM '.DB_PREFIX.'job_applications WHERE created_on > DATE_SUB(NOW(), INTERVAL 8 DAY) GROUP BY DATE_FORMAT(created_on, "%Y-%m-%d")';
		$result = $db->query($sql);
		
		while ($row = $result->fetch_assoc())
			$apps_per_day[] = $row['nr'];
		
		$avg = 0;	
		$maxNumberOfApplications = 0;
		$numberOfApplications = array_sum($apps_per_day);
		$numberOfDaysWithApplications = count($apps_per_day);
		
		if ($numberOfDaysWithApplications > 0)
		{
			$avg = ceil(array_sum($apps_per_day) / count($apps_per_day));
			$maxNumberOfApplications = max($apps_per_day);
		}
		
		return array('stats' => $stats, 'count' => $totalNumberOfApplications, 'avg' => $avg, 'max' => $maxNumberOfApplications);
	}

	public function GetPaymentReports() {
		global $db;

		$sql = 'SELECT count(transaction_id) as count FROM '.DB_PREFIX.'payment WHERE mysql_timestamp > DATE_SUB(NOW(), INTERVAL 7 DAY)';
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		$this_week = $row['count'];

		$sql = 'SELECT count(transaction_id) as count FROM '.DB_PREFIX.'payment WHERE mysql_timestamp > DATE_SUB(NOW(), INTERVAL 30 DAY)';
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		$this_month = $row['count'];

		$sql = 'SELECT SUM(amount) as revenue FROM '.DB_PREFIX.'payment WHERE mysql_timestamp > DATE_SUB(NOW(), INTERVAL 30 DAY)';
		$result = $db->query($sql);
		$row = $result->fetch_assoc();

		$monthly_revenue = ($row['revenue'] == NULL) ?  WEBSITE_CURRENCY . "0" . $row['revenue'] : WEBSITE_CURRENCY . " " . $row['revenue'];

		return array('this_week' => $this_week, 'this_month' => $this_month, 'monthly_revenue' => $monthly_revenue);
	}

	public function getUserStats() {
		global $db;

		$sql = 'SELECT count(id) as companies_count FROM company';
		$result = $db->query($sql);
		$row = $result->fetch_assoc();

		$companies_total = $row['companies_count'];

		$sql = 'SELECT count(id) as candidates_count FROM applicant WHERE public_profile = 1';
		$result = $db->query($sql);
		$row = $result->fetch_assoc();

		$candidates_total = $row['candidates_count'];

		$sql = 'SELECT count(email) as subscribers_count FROM subscriptions WHERE confirmed = 1';
		$result = $db->query($sql);
		$row = $result->fetch_assoc();

		$subscribers_total = $row['subscribers_count'];

		return array('companies' => $companies_total, 'candidates' => $candidates_total, 'subscribers' => $subscribers_total);

	}

	
	public function getJobStats() {
		global $db;

		$sql = 'SELECT count(id) as count FROM '.DB_PREFIX.'jobs WHERE created_on > DATE_SUB(NOW(), INTERVAL 1 DAY)';
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		$today = $row['count'];

		$sql = 'SELECT count(id) as count FROM '.DB_PREFIX.'jobs WHERE created_on > DATE_SUB(NOW(), INTERVAL 7 DAY)';
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		$this_week = $row['count'];

		$sql = 'SELECT count(id) as count FROM '.DB_PREFIX.'jobs WHERE created_on > DATE_SUB(NOW(), INTERVAL 30 DAY)';
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		$this_month = $row['count'];

		return array('today' => $today, 'this_week' => $this_week, 'this_month' => $this_month);
	}

	public function getApplicationStats() {
		global $db;

		$sql = 'SELECT count(id) as count FROM '.DB_PREFIX.'job_applications WHERE created_on > DATE_SUB(NOW(), INTERVAL 1 DAY)';
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		$today = $row['count'];

		$sql = 'SELECT count(id) as count FROM '.DB_PREFIX.'job_applications WHERE created_on > DATE_SUB(NOW(), INTERVAL 7 DAY)';
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		$this_week = $row['count'];

		$sql = 'SELECT count(id) as count FROM '.DB_PREFIX.'job_applications WHERE created_on > DATE_SUB(NOW(), INTERVAL 30 DAY)';
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		$this_month = $row['count'];

		return array('today' => $today, 'this_week' => $this_week, 'this_month' => $this_month);
	}

	public function GetSpamReports(){
		global $db;
		$stats = array();
		$sql = 'SELECT a.job_id, a.date, a.msg, a.count, b.title FROM '.DB_PREFIX.'spam_reports a LEFT JOIN ' .DB_PREFIX.'jobs b ON a.job_id=b.id ORDER BY a.count DESC limit 20';
		$result = $db->query($sql);

		while ($row = $result->fetch_assoc())
			array_push($stats, $row);

		return $stats;
	}

	public function Keywords()
	{
		global $db;
		
		$sql = 'SELECT count(id) AS totalNumberOfSearches FROM '.DB_PREFIX.'searches';
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		
		$totalNumberOfSearches = $row['totalNumberOfSearches'];
		
		$sql = 'SELECT created_on, keywords
		                        FROM '.DB_PREFIX.'searches
		                        ORDER BY created_on DESC limit ' . self::MAKE_STATS_ON_MAX_NUMBER_OF_SEARCHES;
		$result = $db->query($sql);
		
		$stats = '';
		while ($row = $result->fetch_assoc()){
			$stats .= '<div>' . $row['created_on'] . ' <strong>' . htmlspecialchars($row['keywords']) . '</strong></div>';
		}

		$numberOfSearchesPerDay = array();
		$sql = 'SELECT count(id) AS nr FROM '.DB_PREFIX.'searches WHERE created_on > DATE_SUB(NOW(), INTERVAL 8 DAY) GROUP BY DATE_FORMAT(created_on, "%Y-%m-%d")';
		$result = $db->query($sql);

		while ($row = $result->fetch_assoc())
			$numberOfSearchesPerDay[] = $row['nr'];
		
		$avg = 0;
		$maxNumberOfSearches = 0;
		$numberOfSearches = array_sum($numberOfSearchesPerDay);
		$numberOfDaysWithSearches = count($numberOfSearchesPerDay);
		
		if ($numberOfDaysWithSearches > 0)
		{
			$avg = ceil($numberOfSearches / $numberOfDaysWithSearches);
			$maxNumberOfSearches = max($numberOfSearchesPerDay);
		}	

		// remove any entries above 50 to keep the DB clean
		$sql = 'SELECT id, keywords, created_on
		                        FROM '.DB_PREFIX.'searches
		                        ORDER BY created_on DESC';

		$result = $db->query($sql);
		$i = 0;

		while ($row = $result->fetch_assoc()){
			$i++;
			if ($i > self::MAKE_STATS_ON_MAX_NUMBER_OF_SEARCHES) {
				$sql = 'DELETE FROM '.DB_PREFIX.'searches WHERE id =' . $row['id'];
				$db->query($sql);
			}
		}

		return array('stats' => $stats, 'count' => $totalNumberOfSearches, 'avg' => $avg, 'max' => $maxNumberOfSearches);
	}
}
?>
