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

class JobApplication
{
    var $mData = array();
	
	public function __construct($data = array())
	{ 
        $this->mData = $data;
	}
	
	public function getJobApplicationById($id) {
		global $db;
		$apps = array();
		$sql = 'SELECT b.id as "id", b.status as "status", a.fullname as "name", a.email as "email", a.phone as "phone", a.message as "message", a.website as "website", a.cv_path as "cv_path", UNIX_TIMESTAMP(b.created_on) as "created_on" FROM '.DB_PREFIX.'job_applications b, '.DB_PREFIX.'applicant a WHERE b.applicant_id=a.id AND b.id = ' . $id;
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		$row['date_formated'] = date(DATE_FORMAT, floatval(stripslashes($row['created_on'])));
		return $row;
	}

	public function hireApplicant($id) {
		global $db;

		// hire app query
		$sql = 'UPDATE ' . DB_PREFIX . 'job_applications SET status = 3 WHERE id = ' . $id;
		$db->query($sql);

	}

	public function reviewApplication($id) {
		global $db;

		// reject app query
		$sql = 'UPDATE ' . DB_PREFIX . 'job_applications SET status = 2 WHERE id = ' . $id;
		$db->query($sql);

	}

	public function rejectApplication($id) {
		global $db;

		// reject app query
		$sql = 'UPDATE ' . DB_PREFIX . 'job_applications SET status = 1 WHERE id = ' . $id;
		$db->query($sql);

	}

	public function getCandidateDataByJobApplicationId($id) {
		global $db;

		// get applicant ID
		$sql = 'SELECT applicant_id as "aID", job_id as "jID" FROM ' . DB_PREFIX . 'job_applications WHERE id = ' . $id;
		$result = $db->query($sql);	
		$ja = $result->fetch_assoc();

		// get applicant Email
		$s = 'SELECT email as "aEmail" FROM ' . DB_PREFIX . 'applicant WHERE id = ' . $ja['aID'];
		$r = $db->query($s);	
		$row = $r->fetch_assoc();

		$data = array("candidate_email" => $row['aEmail'], "job_id" => $ja['jID']);

		return $data;

	}
	
	public function deleteJobApplicationById($id) {
		global $db;

		//delete entry
		$sql = 'DELETE FROM ' . DB_PREFIX . 'job_applications where id = ' . $id;
		$db->query($sql);

	}

	public function Apply($applicant_id, $public)
	{
		global $db;
		
		// if (intval($public) == 1)
		// 	$ID = intval($_SESSION['applicant']);
		// else
		$ID = $applicant_id;

		$sql = 'INSERT INTO '.DB_PREFIX.'job_applications (id, job_id, applicant_id, created_on, ip, status)
		                    VALUES (NULL, ' . $this->mData['job_id'] . ',
		                    	 ' . $ID . ',
                                 NOW(), "' .  $this->mData['ip'] . '", 0)';

		$db->query($sql);

		//statistics table
		$today = date("Y-m-d");
		$sql = 'SELECT id FROM '.DB_PREFIX.'statistics
							 WHERE date = "' . $today . '" AND job_id =' . $this->mData['job_id'];
		$result = $db->query($sql);

		$row = $result->fetch_assoc();
		//update
		$sql = 'UPDATE '.DB_PREFIX.'statistics SET applications = applications + 1
	 					 WHERE id = ' . $row['id'];
	 	$result = $db->query($sql);
	}

	public function getJobApplicationsUnderReviewByJobId($id, $emp_id) {
		global $db;
		$apps = array();

		// make sure to get only reviewed candidates for a job that belongs to this employer

		$tmpSQL = 'SELECT id as "job_id", title as "job_title" FROM jobs WHERE employer_id = ' . intval($emp_id);
		$tmpRES = $db->query($tmpSQL);
		$emp_jobs_arr = array();

		while ($R = $tmpRES->fetch_assoc()) {
			$emp_jobs_arr[] = $R['job_id'];
		}

		$emp_jobs_arr = "'" . implode("','", $emp_jobs_arr) . "'";

		$sql = 'SELECT DISTINCT b.id as "id", b.job_id as "job_id", b.status as "status", a.fullname as "name", a.occupation as "occupation", a.email as "email", a.phone as "phone", a.message as "message", a.weblink as "website", a.cv_path as "cv_path", UNIX_TIMESTAMP(b.created_on) as "created_on", a.location as "location", a.skills as "skills", a.sm_link_1, a.sm_link_2, a.sm_link_3, a.sm_link_4 FROM '.DB_PREFIX.'job_applications b, '.DB_PREFIX.'applicant a WHERE b.status = 2 AND b.applicant_id=a.id AND b.job_id IN (' . $emp_jobs_arr . ')';
		$result = $db->query($sql);
		while ($row = $result->fetch_assoc()){

			$sm_links = array();

			if (!empty($row['sm_link_1']) && $row['sm_link_1'] != "-") {
				$sm_links["first"] = deconstructSMlink($row['sm_link_1']);
			}

			if (!empty($row['sm_link_2']) && $row['sm_link_2'] != "-") {
				$sm_links["second"] = deconstructSMlink($row['sm_link_2']);
			}

			if (!empty($row['sm_link_3']) && $row['sm_link_3'] != "-") {
				$sm_links["third"] = deconstructSMlink($row['sm_link_3']);
			}

			if (!empty($row['sm_link_4']) && $row['sm_link_4'] != "-") {
				$sm_links["fourth"] = deconstructSMlink($row['sm_link_4']);
			}

			$row['sm_links'] = $sm_links;
			
			$row['date_formated'] = date(DATE_FORMAT, floatval(stripslashes($row['created_on'])));

			if (empty($row['skills']) || strlen($row['skills']) < 1) {
				$row['skills_formated'] = "<li class=\"jat\"><a href=\"\" onclick=\"return false;\" class=\"tag\">-</a></li>";
			} else {
				$se = explode(",", $row['skills']);
				$skills_formated = '';
				foreach ($se as $skill) {
					$skills_formated .= "<li class=\"jat\"><a href=\"\" onclick=\"return false;\" class=\"tag\">" . $skill . "</a></li>";
				}
				$row['skills_formated'] = $skills_formated;	
			}

			// get job info
			$job = new Job($row['job_id']);
			$jData = $job->GetInfo();

			$row['job_name'] = $jData["title"];
			$row['job_url'] = PROTOCOL_URL . URL_JOB .'/' . $jData["url_title"] . '-' . $jData["location_asci"] . '/' . $row['job_id'];

			array_push($apps, $row);
		}

		return $apps;	
	}

	public function getJobApplicationsByJobId($id) {
		global $db;
		$apps = array();

		$sql = 'SELECT b.id as "id", b.status as "status", a.fullname as "name", a.occupation as "occupation", a.email as "email", a.phone as "phone", a.message as "message", a.weblink as "website", a.cv_path as "cv_path", UNIX_TIMESTAMP(b.created_on) as "created_on", a.location as "location", a.skills as "skills", a.sm_link_1, a.sm_link_2, a.sm_link_3, a.sm_link_4 FROM '.DB_PREFIX.'job_applications b, '.DB_PREFIX.'applicant a WHERE b.status = 0 AND b.applicant_id=a.id AND b.job_id = ' . $id;
		$result = $db->query($sql);
		while ($row = $result->fetch_assoc()){

			$sm_links = array();

			if (!empty($row['sm_link_1']) && $row['sm_link_1'] != "-") {
				$sm_links["first"] = deconstructSMlink($row['sm_link_1']);
			}

			if (!empty($row['sm_link_2']) && $row['sm_link_2'] != "-") {
				$sm_links["second"] = deconstructSMlink($row['sm_link_2']);
			}

			if (!empty($row['sm_link_3']) && $row['sm_link_3'] != "-") {
				$sm_links["third"] = deconstructSMlink($row['sm_link_3']);
			}

			if (!empty($row['sm_link_4']) && $row['sm_link_4'] != "-") {
				$sm_links["fourth"] = deconstructSMlink($row['sm_link_4']);
			}

			$row['sm_links'] = $sm_links;

			$row['date_formated'] = date(DATE_FORMAT, floatval(stripslashes($row['created_on'])));

			if (empty($row['skills']) || strlen($row['skills']) < 1) {
				$row['skills_formated'] = "<li class=\"jat\"><a href=\"\" onclick=\"return false;\" class=\"tag\">-</a></li>";
			} else {
				$se = explode(",", $row['skills']);
				$skills_formated = '';
				foreach ($se as $skill) {
					$skills_formated .= "<li class=\"jat\"><a href=\"\" onclick=\"return false;\" class=\"tag\">" . $skill . "</a></li>";
				}
				$row['skills_formated'] = $skills_formated;	
			}

			array_push($apps, $row);
		}

		return $apps;
	}



	public function getHiredJobApplications($emp_id, $job_ids) {
		global $db;
		$apps = array();

		if (empty($job_ids))
			return NULL;

		$job_ids_str = implode (", ", $job_ids);

		$sql = 'SELECT b.id as "id", b.job_id as "job_id", b.status as "status", a.fullname as "name", a.occupation as "occupation", a.email as "email", a.phone as "phone", a.message as "message", a.weblink as "website", a.cv_path as "cv_path", UNIX_TIMESTAMP(b.created_on) as "created_on", a.location as "location", a.skills as "skills", a.sm_link_1, a.sm_link_2, a.sm_link_3, a.sm_link_4 FROM '.DB_PREFIX.'job_applications b, '.DB_PREFIX.'applicant a WHERE b.status = 3 AND b.applicant_id=a.id AND b.job_id IN (' . $job_ids_str . ')';
		$result = $db->query($sql);
		while ($row = $result->fetch_assoc()){

			$sm_links = array();

			if (!empty($row['sm_link_1']) && $row['sm_link_1'] != "-") {
				$sm_links["first"] = deconstructSMlink($row['sm_link_1']);
			}

			if (!empty($row['sm_link_2']) && $row['sm_link_2'] != "-") {
				$sm_links["second"] = deconstructSMlink($row['sm_link_2']);
			}

			if (!empty($row['sm_link_3']) && $row['sm_link_3'] != "-") {
				$sm_links["third"] = deconstructSMlink($row['sm_link_3']);
			}

			if (!empty($row['sm_link_4']) && $row['sm_link_4'] != "-") {
				$sm_links["fourth"] = deconstructSMlink($row['sm_link_4']);
			}

			$row['sm_links'] = $sm_links;

			$row['date_formated'] = date(DATE_FORMAT, floatval(stripslashes($row['created_on'])));

			if (empty($row['skills']) || strlen($row['skills']) < 1) {
				$row['skills_formated'] = "<li class=\"jat\"><a href=\"\" onclick=\"return false;\" class=\"tag\">-</a></li>";
			} else {
				$se = explode(",", $row['skills']);
				$skills_formated = '';
				foreach ($se as $skill) {
					$skills_formated .= "<li class=\"jat\"><a href=\"\" onclick=\"return false;\" class=\"tag\">" . $skill . "</a></li>";
				}
				$row['skills_formated'] = $skills_formated;	
			}

			// website
			$linkToShow = '';
			if ($row['website'] != '') {
				if (strlen($row['website']) > 30) 
					$linkToShow = substr($row['website'], 0, 30) . '...';
				else
					$linkToShow = $row['website'];
			}
			$row['link_to_show'] = $linkToShow;

			// CV
			if ($row['cv_path'] == ''){
				$row['cv_path'] = '-';
			} else {
				$explode = explode(".", $row['cv_path']);
				if (strcmp(end($explode), "pdf") == 0) {
					$row['fa_class'] = "fa fa-file-pdf-o fa-lg pdf-el";
				} else {
					$row['fa_class'] = "fa fa-file-word-o fa-lg word-el";
				}
			}

			// get job info
			$job = new Job($row['job_id']);
			$jData = $job->GetInfo();

			$row['job_name'] = $jData["title"];
			$row['job_url'] = PROTOCOL_URL . URL_JOB .'/' . $jData["url_title"] . '-' . $jData["location_asci"] . '/' . $row['job_id'];

			array_push($apps, $row);
		}

		return $apps;
	}




	public function getJobApplicationsCount($job_id){
		global $db;
		$jobs = array();

		$sql = 'SELECT COUNT(id) AS count
		               FROM '.DB_PREFIX.'job_applications WHERE job_id = ' . $job_id;


		$result = $db->query($sql);  
		$row = $result->fetch_assoc();
		return $row['count'];
	}
	
	public function getAllForJob($job_id)
	{
		global $db;
		$result = array();
		$sql = 'SELECT  b.id as "id", b.status as "status", a.fullname as "name", a.email as "email", a.phone as "phone", a.message as "message", a.weblink as "website", a.cv_path as "cv_path", UNIX_TIMESTAMP(b.created_on) as "created_on" FROM '.DB_PREFIX.'job_applications b, '.DB_PREFIX.'applicant a WHERE b.applicant_id=a.id AND job_id = ' . $job_id;
		$result = $db->query($sql);
		$apps = array();

		while ($row = $result->fetch_assoc()) {
			$apps[] = $row;
		}

		return $apps;
	}
	
	public function Count()
	{
		global $db;
		$sql = 'SELECT COUNT(id) AS count FROM '.DB_PREFIX.'job_applications WHERE job_id = ' . $this->mJobId;
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		return $row['count'];
	}
}
?>
