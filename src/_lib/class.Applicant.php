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

class Applicant {

	private $id = null;
	private $fullname = null;
	private $occupation = null;
	private $email = null;
	private $phone = null;
	private $message = null;
	private $weblink = null;
	private $cv_path = null;
	private $last_activity = null;
	private $confirmHash = null;
	private $sm_links = array();

	function __construct() {}

	public function getId() {
		return $this->id;
	}

	public function getEmail() {
 		return $this->email;
 	}

	public function getConfirmHash(){ return $this->confirmHash; }

	public function getData() {
		$data = array("id" => $this->id, "fullname" => $this->fullname, "occupation" => $this->occupation, "email" => $this->email, "phone" => $this->phone, "message" => $this->message, "weblink" => $this->weblink, "cv_path" => $this->cv_path, "last_activity" => $last_activity, "sm_links" => $this->sm_links);
		return $data;
	}

	public function register($smarty) { 

		$DIR_CONST = '';
		if (defined('__DIR__'))
			$DIR_CONST = __DIR__;
		else
			$DIR_CONST = dirname(__FILE__);
		
		$tpl = $DIR_CONST . '/../plugins/Profiles/modal.tpl';
		if (!file_exists($tpl)) {
			$smarty->assign('modal_snippet','err/plugin-missing.tpl');
		} else {
			$smarty->assign('modal_snippet','../../../plugins/Profiles/modal.tpl');
		}
	}

	public function confirmUser($hash) {
 		global $db;
 
 		$sql = 'SELECT user_id
                FROM '.DB_PREFIX.'confirmed_applicants
                WHERE hash = "' . $hash . '"';
 
         $result = $db->query($sql);
 
 	    if (($result->num_rows > 0)) {
 	     	$assoc = $result->fetch_assoc();
 	     	$user_id = $assoc['user_id'];
 	     	//delete hash
 	     	$sql = 'DELETE FROM '.DB_PREFIX.'confirmed_applicants WHERE user_id = ' . $user_id;
 	        $result = $db->query($sql);
 	     	
 	         // set email for the welcome email
 			 $sql = 'SELECT email FROM '.DB_PREFIX.'applicant WHERE id = ' . $user_id;
 
 	         $result = $db->query($sql);
 	         $rowData = $result->fetch_assoc();
 	         $this->email = $rowData['email'];
 
 	     	//set user active
 	     	$sql = 'UPDATE '.DB_PREFIX.'applicant SET
 	            confirmed = 1 WHERE id = ' . $user_id;
 
 	        $result = $db->query($sql);
 	        return $result;
 
 	    } else {
 	     	//activation failed
 	     	return false;
 	    }
 
 	}

 	public function updateSubscription($email, $subs_status) {
 		global $db;
 		$sql = 'UPDATE subscriptions SET confirmed=' . $subs_status . ' WHERE email= "' . $email . '"';
 		$db->query($sql);
 	}

 	public function getSubscriptionDetailsByEmail($email) {
 		global $db;
 		$sql = 'SELECT confirmed FROM subscriptions WHERE email="' . $email . '"';
 		$result = $db->query($sql);
 		if ($result){
 			$row = $result->fetch_assoc();
 			return intval($row['confirmed']);
 		}
 		else {
 			return false;
 		}
 	}
 
 	public function getIdByEmail($email) {
 		global $db;
 		$sql = 'SELECT id FROM applicant WHERE email="' . $email . '"';
 		$result = $db->query($sql);
 		if ($result) {
 	 		$row = $result->fetch_assoc();
 			return $row['id'];		
 		} else 
 			return 0;
 	}

 	public function isConfirmed($user_id) {
 		global $db;
 		$sql = 'SELECT confirmed FROM applicant WHERE id =' . intval($user_id);
 		$result = $db->query($sql);
 		$row = $result->fetch_assoc();
 		return (intval($row['confirmed']) == 1) ? true : false;
 	}

	public function removeJobApplicationsById($applicant_id) {
		global $db;
		$sql = 'DELETE FROM '.DB_PREFIX.'job_applications WHERE applicant_id = ' . $applicant_id;
		$result = $db->query($sql);
	}

	public function deleteApplicant($id) {
		global $db;
		$sql = 'DELETE FROM '.DB_PREFIX.'applicant WHERE id = ' . $id;
		$result = $db->query($sql);
	}

	public function getDataById($id) {
		global $db;
		$sql = 'SELECT * FROM '.DB_PREFIX.'applicant WHERE id = ' . $id;
		$result = $db->query($sql);
		$row = $result->fetch_assoc();

		$se = explode(",", $row['skills']);
		$skills = '';
		foreach ($se as $skill) {
			$skills .=  "#" . $skill . " ";
		}

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

		$data = array("id" => $row['id'], "fullname" => $row['fullname'], "occupation" => $row['occupation'], "email" => $row['email'], "phone" => $row['phone'], "location" => $row['location'], "message" => $row['message'], "weblink" => $row['weblink'], "skills" => $skills, "cv_path" => $row['cv_path'], "public_profile" => $row['public_profile'], "last_activity" => $row['last_activity'], "sm_links" => $sm_links);
		return $data;
	}

	public function getDataByIdForProfile($id) {
		global $db;
		$sql = 'SELECT * FROM '.DB_PREFIX.'applicant WHERE id = ' . $id;
		$result = $db->query($sql);
		$row = $result->fetch_assoc();

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

		$data = array("id" => $row['id'], "fullname" => $row['fullname'], "occupation" => $row['occupation'], "email" => $row['email'], "phone" => $row['phone'], "location" => $row['location'], "message" => $row['message'], "weblink" => $row['weblink'], "skills" => $row['skills'], "cv_path" => $row['cv_path'], "public_profile" => $row['public_profile'], "last_activity" => $row['last_activity'], "sm_links" => $sm_links);
		return $data;
	}

	public function updatePassword($id, $newpass) {
		global $db;
		$sql = 'UPDATE '.DB_PREFIX.'applicant SET password="'.$newpass.'" WHERE id="'.$id.'"';
		$result = $db->query($sql);
		if ($result) {
			return true;
		} else {
			return false;
		}
	}

	public function updateApplicant($p, $id) {
		global $db;

		$sql = 'UPDATE '.DB_PREFIX.'applicant SET fullname = "' . $p['fullname'] . '", occupation = "' . $p['occupation'] . '",
		phone = "' .  $p['phone']. '", message = "' .  $p['message'] . '", weblink = "' .  $p['weblink'] . '", cv_path = "' .  $p['cv_path'] . '", public_profile = ' .  $p['public_profile'] . ', location = "' . $p['location'] . '", skills = "' . $p['skills'] . '", sm_link_1 = "' . $p["sm_links"]["first"]->linkToSave . '", sm_link_2 = "' . $p["sm_links"]["second"]->linkToSave . '", sm_link_3 = "' . $p["sm_links"]["third"]->linkToSave . '", sm_link_4 = "' . $p["sm_links"]["fourth"]->linkToSave . '" WHERE id = ' . $id;

		$result = $db->query($sql);
	}

	public function getJobApplicationsById($id) {
		global $db;
		$sanitizer = new Sanitizer;
		$sql = 'SELECT UNIX_TIMESTAMP(a.created_on) as "created_on", a.status as "status", b.title as "job_title", b.salary as "job_salary", b.id as "job_id", b.company as "job_company", b.city_id as "job_location_id" FROM '.DB_PREFIX.'job_applications a, '.DB_PREFIX.'jobs b WHERE a.job_id = b.id AND a.applicant_id = "' . $id . '"';
		$result = $db->query($sql);
		$final = array();
		while ($row = $result->fetch_assoc()) {
			$row['created_on'] = date(DATE_FORMAT, floatval(stripslashes($row['created_on'] )));


			$citySql = 'SELECT ascii_name
	               FROM '.DB_PREFIX.'cities
	               WHERE id = "' . $row['job_location_id'] . '"';
	        $cityRes = $db->query($citySql);
	        $locationRow = $cityRes->fetch_assoc();
	        $location = $locationRow['ascii_name'];

			// admin causing troubles with routing
			if (strpos(strtolower($row['job_title']), "admin") !== false) {
				$row['url_title'] = "";
			} else {
				$row['url_title'] = $sanitizer->sanitize_title_with_dashes($row['job_title'] . ' at ' . $row['job_company'] . '-' . $location);
			}

			$final[] = $row;
		}
		return $final;
	}

	public function createResetPasswordEntry($id, $hash) {
		$hashData = array('user_id' => $id, 'hash' => $hash);
		$class = new HashTables();
		$class->createEntryForPassrecoveryApplicants($hashData);
	}

	public function checkIfUserExistsAndIsConfirmed($email) {
		global $db;
		$sql = 'SELECT id, confirmed
               FROM '.DB_PREFIX.'applicant
               WHERE email = "' . $email . '"';
        $result = $db->query($sql);
        $assoc = $result->fetch_assoc();

        if ($result->num_rows > 0) {
        	$confirmed = $assoc['confirmed'];

        } else {
        	$confirmed = 2;
        }

        $this->id = $assoc['id'];

        return intval($confirmed);
	}

	public function checkIfUserExists($email) {
		global $db;
		$sql = 'SELECT id
               FROM '.DB_PREFIX.'applicant
               WHERE email = "' . $email . '"';
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
        	$assoc = $result->fetch_assoc();
        	
        }

        $this->id = $assoc['id'];

        return ($result->num_rows > 0) ? true : false;
	}

	public function isSubscribed($email) {
		global $db;
		$sql = 'SELECT id
               FROM '.DB_PREFIX.'subscriptions
               WHERE email = "' . $email . '"';
        $result = $db->query($sql);

        return ($result->num_rows > 0) ? true : false;
	}

	public function updateApplicantActivity($public, $id) {
		global $db;
		if (intval($public)){
			$sql = 'UPDATE '.DB_PREFIX.'applicant SET last_activity=NOW() WHERE id ='. $id;
			$result = $db->query($sql);	
		}
	}

	public function createCandidateProfileFromAdmin($params) {
		global $db;

		// get SM objects
		if (!empty($params['sm_links']["first"]) && $params['sm_links']["first"] != "-")
			$sm_link_1 = $params['sm_links']["first"]->linkToSave;
		else
			$sm_link_1 = '-';

		if (!empty($params['sm_links']["second"]) && $params['sm_links']["second"] != "-")
			$sm_link_2 = $params['sm_links']["second"]->linkToSave;
		else
			$sm_link_2 = '-';

		if (!empty($params['sm_links']["third"]) && $params['sm_links']["third"] != "-")
			$sm_link_3 = $params['sm_links']["third"]->linkToSave;
		else
			$sm_link_3 = '-';

		if (!empty($params['sm_links']["fourth"]) && $params['sm_links']["fourth"] != "-")
			$sm_link_4 = $params['sm_links']["fourth"]->linkToSave;
		else
			$sm_link_4 = '-';

		//new applicant
		$sql = 'INSERT INTO '.DB_PREFIX.'applicant (id, fullname, occupation, email, phone, message, weblink, cv_path, public_profile, password, last_activity, location, skills, confirmed, sm_link_1, sm_link_2, sm_link_3, sm_link_4)
         VALUES (NULL, 
         	"' . $params['name'] . '",
         	"' . $params['occupation'] . '",
         	"' . $params['email'] . '",
         	"' . $params['phone'] . '",
         	"' . $params['message'] . '",
         	"' . $params['website'] . '",
         	"' . $params['cv_path'] . '",
         	' . $params['public_profile'] . ',
         	"' . $params['password'] . '", NOW(),
         	"' . $params['location']  . '",
         	"' . $params['skills']  . '", 1,
         	"' . $sm_link_1  . '",
         	"' . $sm_link_2  . '",
         	"' . $sm_link_3  . '",
         	"' . $sm_link_4  . '")';

		 $result = $db->query($sql);
		 return $result;
	}

	public function createCandidateProfile($params) {
		global $db;

		// get SM objects
		if (!empty($params['sm_links']["first"]) && $params['sm_links']["first"] != "-")
			$sm_link_1 = $params['sm_links']["first"]->linkToSave;
		else
			$sm_link_1 = '-';

		if (!empty($params['sm_links']["second"]) && $params['sm_links']["second"] != "-")
			$sm_link_2 = $params['sm_links']["second"]->linkToSave;
		else
			$sm_link_2 = '-';

		if (!empty($params['sm_links']["third"]) && $params['sm_links']["third"] != "-")
			$sm_link_3 = $params['sm_links']["third"]->linkToSave;
		else
			$sm_link_3 = '-';

		if (!empty($params['sm_links']["fourth"]) && $params['sm_links']["fourth"] != "-")
			$sm_link_4 = $params['sm_links']["fourth"]->linkToSave;
		else
			$sm_link_4 = '-';

		//new applicant
		$sql = 'INSERT INTO '.DB_PREFIX.'applicant (id, fullname, occupation, email, phone, message, weblink, cv_path, public_profile, password, last_activity, location, skills, confirmed, sm_link_1, sm_link_2, sm_link_3, sm_link_4)
         VALUES (NULL, 
         	"' . $params['name'] . '",
         	"' . $params['occupation'] . '",
         	"' . $params['email'] . '",
         	"' . $params['phone'] . '",
         	"' . $params['message'] . '",
         	"' . $params['website'] . '",
         	"' . $params['cv_path'] . '",
         	' . $params['public_profile'] . ',
         	"' . $params['password'] . '", NOW(),
         	"' . $params['location']  . '",
         	"' . $params['skills']  . '", 
         	' . $params['confirmed'] . ',
         	"' . $sm_link_1  . '",
         	"' . $sm_link_2  . '",
         	"' . $sm_link_3  . '",
         	"' . $sm_link_4  . '")';

		 $result = $db->query($sql);
		 $APPLICANT_ID = $db->getConnection()->insert_id;
		 $this->id = $APPLICANT_ID;

		 if (intval($params['confirmed']) == 0) {
			 $hash = sha1($params['email'] . time());
			 $sql = 'INSERT INTO confirmed_applicants (user_id, hash) VALUES (' . $APPLICANT_ID  .', "' . $hash . '")';
			 $db->query($sql);
			 $this->confirmHash = $hash;
		 }

		 // subscribe him to all jobs
		 if (!$this->isSubscribed($params['email'])) {
		 	$subs = new Subscriber($params['email'], "0", false, false);
		 }
 			 
		return $APPLICANT_ID;
	}

	public function updateExistingApplicant($params, $applicant_id, $job_id, $public) {
		global $db;

		// get SM objects
		if (!empty($params['sm_links']["first"]) && $params['sm_links']["first"] != "-")
			$sm_link_1 = $params['sm_links']["first"]->linkToSave;
		else
			$sm_link_1 = '-';

		if (!empty($params['sm_links']["second"]) && $params['sm_links']["second"] != "-")
			$sm_link_2 = $params['sm_links']["second"]->linkToSave;
		else
			$sm_link_2 = '-';

		if (!empty($params['sm_links']["third"]) && $params['sm_links']["third"] != "-")
			$sm_link_3 = $params['sm_links']["third"]->linkToSave;
		else
			$sm_link_3 = '-';

		if (!empty($params['sm_links']["fourth"]) && $params['sm_links']["fourth"] != "-")
			$sm_link_4 = $params['sm_links']["fourth"]->linkToSave;
		else
			$sm_link_4 = '-';

		$sql = 'UPDATE applicant SET fullname = "' . $params['name'] . '", occupation = "' . $params['occupation'] . '", phone = "' . $params['phone'] . '", message = "' . $params['message']. '",
		        weblink = "' . $params['website'] . '", cv_path = "' . $params['cv_path'] . '", public_profile = ' . $params['public_profile'] . ', 
		        password = "' . $params['password'] . '", last_activity = NOW(), location = "' . $params['location'] . '", skills = "'. $params['skills'] . '", sm_link_1 = "' . $sm_link_1 . '", sm_link_2 = "' . $sm_link_2 . '", sm_link_3 = "' . $sm_link_3 . '", sm_link_4 = "' . $sm_link_4 . '" WHERE id =' . $applicant_id;

		$result = $db->query($sql);
		$this->id = $db->getConnection()->insert_id;

		if (intval($public) == 1){

			if (intval($params['confirmed']) == 0) {
				// confirmation & subscription
				$hash = sha1($params['email'] . time());
				$sql = 'INSERT INTO confirmed_applicants (user_id, hash) VALUES (' . $applicant_id  .', "' . $hash . '")';
				$db->query($sql);
				$this->confirmHash = $hash;
			}
			
			//susbcribe those who wish to have public profile
			//which category is applicant interested in ?
			if ($job_id !== false) {
				$s = 'SELECT category_id FROM '.DB_PREFIX.'jobs WHERE id = ' . $job_id;
				$r = $db->query($s);
				$row = $r->fetch_assoc();
			} else {
				$row = array();
				$row['category_id'] = 0;
			}

			//also subscribe him 
			if (!$this->isSubscribed($params['email'])) {
			 $subs = new Subscriber($params['email'], $row['category_id'], false, false);
			}
		}

	}

	public function createEntry($params, $job_id, $public) {
		global $db;

		// get SM objects
		if (!empty($params['sm_links']["first"]) && $params['sm_links']["first"] != "-")
			$sm_link_1 = $params['sm_links']["first"]->linkToSave;
		else
			$sm_link_1 = '-';

		if (!empty($params['sm_links']["second"]) && $params['sm_links']["second"] != "-")
			$sm_link_2 = $params['sm_links']["second"]->linkToSave;
		else
			$sm_link_2 = '-';

		if (!empty($params['sm_links']["third"]) && $params['sm_links']["third"] != "-")
			$sm_link_3 = $params['sm_links']["third"]->linkToSave;
		else
			$sm_link_3 = '-';

		if (!empty($params['sm_links']["fourth"]) && $params['sm_links']["fourth"] != "-")
			$sm_link_4 = $params['sm_links']["fourth"]->linkToSave;
		else
			$sm_link_4 = '-';

		//new applicant
		$sql = 'INSERT INTO '.DB_PREFIX.'applicant (id, fullname, occupation, email, phone, message, weblink, cv_path, public_profile, password, last_activity, location, skills, confirmed, sm_link_1, sm_link_2, sm_link_3, sm_link_4)
         VALUES (NULL, 
         	"' . $params['name'] . '",
         	"' . $params['occupation'] . '",
         	"' . $params['email'] . '",
         	"' . $params['phone'] . '",
         	"' . $params['message'] . '",
         	"' . $params['website'] . '",
         	"' . $params['cv_path'] . '",
         	' . $params['public_profile'] . ',
         	"' . $params['password'] . '", NOW(),
         	"' . $params['location']  . '",
         	"' . $params['skills']  . '", 
         	' . $params['confirmed'] . ',
         	"' . $sm_link_1  . '",
         	"' . $sm_link_2  . '",
         	"' . $sm_link_3  . '",
         	"' . $sm_link_4  . '")';

		 $result = $db->query($sql);
		 $APPLICANT_ID = $db->getConnection()->insert_id;
		 $this->id = $APPLICANT_ID;

		if (intval($public) == 1){

			 $hash = sha1($params['email'] . time());
 			 $sql = 'INSERT INTO confirmed_applicants (user_id, hash) VALUES (' . $APPLICANT_ID  .', "' . $hash . '")';
 			 $db->query($sql);
 			 $this->confirmHash = $hash;

			//susbcribe those who wish to have public profile
			//which category is applicant interested in ?
			$s = 'SELECT category_id FROM '.DB_PREFIX.'jobs WHERE id = ' . $job_id;
			$r = $db->query($s);
			$row = $r->fetch_assoc();

			//also subscribe him if his account does not exist yet
			if (!$this->isSubscribed($params['email'])) {
				$subs = new Subscriber($params['email'], $row['category_id'], false, false);
			}
				
		}

		return $APPLICANT_ID;
	}

	public function getApplicationsCount($occupation, $location, $skills) {
		global $db;

		$cond = '';

		if (!empty($occupation) && strlen($occupation) > 2) {
			$cond .= ' AND occupation like "%' . $occupation . '%" ';
		}

		if (!empty($location) && strlen($location) > 2) {
			$cond .= ' AND location like "%' . $location . '%" ';
		}

		if (!empty($skills) && strlen($skills) > 2) {
			$cond .= ' AND skills LIKE "%' . $skills . '%" ';
		}

		$sql = 'SELECT COUNT(id) as "total" FROM applicant WHERE public_profile = 1' . $cond;

		$result = $db->query($sql);
	    $row = $result->fetch_assoc();

	    return $row['total'];
	}
   
	public function getCvDatabase($offset, $theme, $occupation, $location, $skills) {
		global $db;

		$cond = '';

		if (!empty($occupation) && strlen($occupation) > 2) {
			$cond .= ' AND occupation like "%' . $occupation . '%" ';
		}

		if (!empty($location) && strlen($location) > 2) {
			$cond .= ' AND location LIKE "%' . $location . '%" ';
		}

		if (!empty($skills) && strlen($skills) > 2) {

			$exp = explode(",", $skills);
			$cond .= ' AND (';
			$last = count($exp);
			$i = 0;

			foreach ($exp as $skl) {
				if (++$i == $last)
					$cond .= ' skills LIKE "%' . $skl . '%"';
				else
					$cond .= ' skills LIKE "%' . $skl . '%" OR';
			}
			$cond .= ') ';
			//$cond .= ' AND skills LIKE "%' . $skills . '%" ';
		}

		$sql = 'SELECT id, fullname, occupation, email, phone, message, weblink, 
				cv_path, UNIX_TIMESTAMP(last_activity) as "created_on", location, skills, sm_link_1, sm_link_2, sm_link_3, sm_link_4  FROM '.DB_PREFIX.'applicant 
				WHERE public_profile = 1 ' . $cond . ' ORDER BY UNIX_TIMESTAMP(last_activity) DESC limit ' .$offset . ', ' . CANDIDATES_PER_PAGE;

		$result = $db->query($sql);
		$final = array();

		while($row = $result->fetch_assoc()) {
			//social media links

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

			//date change
			$row['created_on'] = date(DATE_FORMAT, floatval(stripslashes($row['created_on'] )));

			if ($row['phone'] == '')
				$row['phone'] = '-';

			if ($row['location'] == '')
				$row['location'] = '-';

			if ($row['weblink'] == '')
				$row['weblink'] = '-';

			if (strlen($row['weblink']) > 30) {
				$row['weblink_short'] = substr($row['weblink'], 0, 30) . "...";
			} else {
				$row['weblink_short'] = $row['weblink'];
			}

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

			if (empty($row['skills']) || strlen($row['skills']) < 1) {
				$row['skills_formated'] = "<li><a href=\"\" onclick=\"return false;\" class=\"tag\">-</a></li>";
			} else {
				$se = explode(",", $row['skills']);
				$skills_formated = '';
				foreach ($se as $skill) {
					$skills_formated .= "<li><a href=\"\" onclick=\"return false;\" class=\"tag\">" . $skill . "</a></li>";
				}
				$row['skills_formated'] = $skills_formated;	
			}

			$final[] = $row;
		}
		return $final;
	}

	public function authenticate($email, $mdpass) {
		global $db;
		$sql = 'SELECT * FROM '.DB_PREFIX.'applicant WHERE email="'.$email.'" AND password="'.$mdpass.'"';

		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		if (!empty($row))
		{
			$this->id = $row['id']; 
			$this->fullname = $row['fullname']; 
			$this->email = $row['email']; 
			$this->phone = $row['phone']; 
			$this->message = $row['message']; 
			$this->weblink = $row['weblink']; 
			$this->cv_path = $row['cv_path'];


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

			$this->sm_links = $sm_links;
			return true;
		}
		return false;
	}


} ?>
