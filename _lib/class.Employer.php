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

class Employer {

	private $userId = null;
	private $userEmail = null;
	private $userName = null;
	private $mIp = null;

	function __construct() {}

	public function authenticate($e, $mdpass) {
		global $db;
		$sql = 'SELECT id, name FROM '.DB_PREFIX.'employer WHERE email="'.$e.'" AND password="'.$mdpass.'"';

		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		if (!empty($row))
		{
			$this->userId = $row['id']; 
			$this->userName = $row['name'];
			return true;
		}
		return false;
	}

	public function grantCvdbAccess($eid) {
		global $db;
		$sql = 'UPDATE employer SET cvdb_access = 1 WHERE id=' . $eid;
		$db->query($sql);
	}

	public function removeCvdbAccess($eid) {
		global $db;
		$sql = 'UPDATE employer SET cvdb_access = 0 WHERE id=' . $eid;
		$db->query($sql);	
	}

	public function checkCvDbAccess($eid) {
		global $db;
		$sql = 'SELECT cvdb_access FROM employer WHERE id=' . $eid;
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		return (intval($row['cvdb_access']) == 1) ? true : false;
	}

	public function renewAccountPackage($p_id, $emp_id) {
		global $db;

		// get package data
		$sql = 'SELECT * FROM packages WHERE id = ' . intval($p_id);
		$result = $db->query($sql);
		$row = $result->fetch_assoc();

		// renew emp account
		$s = 'UPDATE employer SET package_id=' . $row['id'] . ', job_period = ' . $row['job_period'] . ', jobs_left =' . $row['jobs_left'] . ', cv_downloads_left = ' . $row['cv_downloads'] . ' WHERE id = ' . intval($emp_id);
		$db->query($s);

	}

	public function notificationSeen($eid) {
		global $db;
		$sql = 'DELETE FROM '.DB_PREFIX.'notification WHERE employer_id = ' . $eid;
		$result = $db->query($sql);
	}

	public function checkForNotification($eid) {
		global $db;
		$sql = 'SELECT id FROM '.DB_PREFIX.'notification WHERE employer_id = ' . $eid;
		$result = $db->query($sql);
        return ($result->num_rows > 0) ? true : false;
	}

	public function createNotification($eid) {
		global $db;
		$sql = 'INSERT INTO '.DB_PREFIX.'notification (employer_id)
         VALUES (' . $eid . ')';

		$result = $db->query($sql);
	}

	public function getEmployerEmail($id) {
		global $db;
		$sql = 'SELECT email FROM '.DB_PREFIX.'employer WHERE id=' . $id;
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		return $row['email'];
	}

	public function getNews() {
		global $db;
		$sql = 'SELECT UNIX_TIMESTAMP(a.date) as date_created, a.message, a.id FROM '.DB_PREFIX.'news a';
		$result = $db->query($sql);
		$news = array();
		while ($row = $result->fetch_assoc()){	
			$obj = new stdClass;
			$obj->date = date("d/M/Y", $row['date_created']);
			$obj->msg = $row['message'];
			$news[$row['id']] = $obj;
		}
		return $news;
	}

	public function getEmployerOverview($id) {
		//jobs posted
		global $db;
		$sql = 'SELECT id, views_count FROM '.DB_PREFIX.'jobs WHERE is_tmp = 0 AND employer_id = ' . $id;
		$result = $db->query($sql);
		$jobCount = 0;
		$jobAppsCount = 0;
		$viewsCount = 0;
		// $row['count']
		while ($row = $result->fetch_assoc()){
			$jobCount++;
			$viewsCount += $row['views_count'];
			// count job applications
			$sql = 'SELECT COUNT(id) as count FROM '.DB_PREFIX.'job_applications WHERE job_id = ' . $row['id'];
			$inner_result = $db->query($sql);
			$inner_row = $inner_result->fetch_assoc();

			$jobAppsCount += $inner_row['count'];
		}
		if ($viewsCount == 0)
			$performance = 0;
		else
			$performance = round(($jobAppsCount/$viewsCount)*100, 2);
		return array("jobs_posted" => $jobCount, "applications" => $jobAppsCount, "performance" => $performance);
	}

	public function getEmployerById($id) {
		global $db;
		$sql = 'SELECT email FROM '.DB_PREFIX.'employer WHERE id = ' . $id;
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		return $row;
	}

	public function getEmployerByEmail($email) {
		global $db;
		$sql = 'SELECT * FROM '.DB_PREFIX.'employer WHERE email = "' . $email . '"';
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		return $row;
	}

	public function substractJobCount($id) {
		global $db;
		$sql = 'SELECT jobs_left FROM ' . DB_PREFIX . 'employer WHERE id = ' . $id;
		$result = $db->query($sql);
		$row = $result->fetch_assoc();

		if (intval($row['jobs_left']) != 0)
			$newCount = intval($row['jobs_left']) - 1;
		else
			$newCount = 0;

		$sql = 'UPDATE ' . DB_PREFIX . 'employer SET jobs_left = ' . $newCount . ' WHERE id = ' . $id;
		$result = $db->query($sql);
	}

	public function getEmployerAccount($id) {
		global $db;
		$sql = 'SELECT e.package_id, e.job_period, e.jobs_left, e.cv_downloads_left, p.name FROM ' . DB_PREFIX . 'employer e JOIN ' . DB_PREFIX . 'packages p ON p.id=e.package_id WHERE e.id = '.$id;
		$result = $db->query($sql);
		if ($result)
			return $result->fetch_assoc();
		else 
			return null;
	}

	public function deactivateAccount($account_id) {
		
		global $db;

		//delete jobs
		 $sql = 'SELECT id as "job_id" FROM '.DB_PREFIX.'jobs WHERE employer_id = ' . $account_id;
	     $res = $db->query($sql);

		while ($row = $res->fetch_assoc()) {
			$JOB_ID = $row['job_id'];
			$job = new Job();
			$job->deleteById($JOB_ID);
		}

		//delete account
		$sql = 'DELETE FROM '.DB_PREFIX.'employer WHERE id = ' . $account_id;
		$db->query($sql);

	}

	public function updateName($id, $name) {
		global $db;
		$sql = 'UPDATE '.DB_PREFIX.'employer SET name="'.$name.'" WHERE id="'.$id.'"';
		$result = $db->query($sql);
		return $result;
	}

	public function updatePasswordFromBackoffice($id, $newpass) {
		global $db;
		$sql = 'UPDATE '.DB_PREFIX.'employer SET password="'.$newpass.'" WHERE id="'.$id.'"';
		$result = $db->query($sql);
		return $result;
	}

	public function updatePassword($id, $newpass) {
		global $db;
		//check if user has not keep changing his passowrd too many times
		$sql = 'SELECT count FROM '.DB_PREFIX.'passrecovery_recruiters WHERE user_id="'.$id.'"';
		$result = $db->query($sql);

		 $row = $result->fetch_assoc();
		 
		if (empty($row)){
			$count = 0;
		} else {
			$count = $row['count'];
		}
		$count += 1;
		//update table
		if (empty($row)){
			$sql = 'INSERT INTO '.DB_PREFIX.'passrecovery_recruiters (user_id, count)
	                 VALUES (' . $id . ',
	                         ' . $count . ')';
		} else {
			$sql = 'UPDATE '.DB_PREFIX.'passrecovery_recruiters SET count="'.$count.'" WHERE user_id="'.$id.'"';
		}
		$result = $db->query($sql);

		if ($count > PASSRECOVERY_LIMIT)
			return false;

		$sql = 'UPDATE '.DB_PREFIX.'employer SET password="'.$newpass.'" WHERE id="'.$id.'"';
		$result = $db->query($sql);
		if ($result) {
			return true;
		} else {
			return false;
		}
	}

	//we need to check if user has not been already registered with different email address
	public function userIpIsAlreadyRegistered($ip) {
		global $db;

		$sql = 'SELECT email, ip FROM '.DB_PREFIX.'employer WHERE ip="'.$ip.'"';
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		if (!empty($row))
		{
			$this->userEmail = $row['email'];
			return true;
		}
		return false;
	}

	public function getId() { return $this->userId; }
	public function getEmail() { return $this->userEmail; }
	public function getIp() { return $this->mIp; }
	public function getName() { return $this->userName; }

	public function checkIfUserExists($email) {
		global $db;
		$sql = 'SELECT id
               FROM '.DB_PREFIX.'employer
               WHERE email = "' . $email . '"';
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
        	$assoc = $result->fetch_assoc();
        	$this->userId = $assoc['id'];
        }

        return ($result->num_rows > 0) ? true : false;
	}

	public function checkIfEmailExists($email) {
		global $db;
		$sql = 'SELECT id
               FROM '.DB_PREFIX.'employer
               WHERE email = "' . $email . '"';
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
        	$assoc = $result->fetch_assoc();
        	$this->userId = $assoc['id'];
        }

        return ($result->num_rows > 0) ? true : false;
	}

	public function createResetPasswordEntry($id, $hash) {
		$hashData = array('user_id' => $id, 'hash' => $hash);
		$class = new HashTables();
		$class->createEntryForPassrecoveryRecruiters($hashData);
	}

	//confiramtion packages selection
	public function confirmUserPackage($id) {
		global $db;
		$user_id = $id;

		$sqli = 'SELECT id
               FROM '.DB_PREFIX.'employer
               WHERE id = "' . $user_id . '"';
        $result = $db->query($sqli);

        if (($result->num_rows > 0)) {
        	//set user active
	        $sql = 'UPDATE '.DB_PREFIX.'employer SET
	                confirmed = 1 WHERE id = ' . $user_id;
	        $result = $db->query($sql);
	        return $result; 
        }else{
        	return false;
        }        
	}

	public function confirmUser($hash) {
		global $db;

		$sql = 'SELECT user_id
               FROM '.DB_PREFIX.'confirmed_recruiters
               WHERE hash = "' . $hash . '"';

         $result = $db->query($sql);

         if (($result->num_rows > 0)) {
         	$assoc = $result->fetch_assoc();
         	$user_id = $assoc['user_id'];
         	//delete hash
         	$sql = 'DELETE FROM '.DB_PREFIX.'confirmed_recruiters WHERE user_id = ' . $user_id;
            $result = $db->query($sql);
         	
         	//set user active
         	$sql = 'UPDATE '.DB_PREFIX.'employer SET
                confirmed = 1 WHERE id = ' . $user_id;

            $result = $db->query($sql);
            return $result;

         } else {
         	//activation failed
         	return false;
         }

	}

	public function userIsConfirmed($id) {
		global $db;
		$sql = 'SELECT confirmed
               FROM '.DB_PREFIX.'employer
               WHERE id = "' . $id . '"';
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        return (strcmp($row['confirmed'], "1") == 0) ? true : false;
	}

	public function createEntryFromAdmin($params = array()) {
		global $db;

		// get default
		$package_id = 1;
		$s = 'SELECT * FROM packages WHERE id = ' . $package_id;
		$r = $db->getConnection()->query($s);
		$package = $r->fetch_assoc();

		// PAYMENT DEACTIVATED, FREE OR FEES
		if (PAYMENT_MODE == "0" || PAYMENT_MODE == "1" || PAYMENT_MODE == "2") {
			$mSQL = 'SELECT value FROM settings WHERE name="job_expires"';
			$mRes = $db->getConnection()->query($mSQL);
			$mRow = $mRes->fetch_assoc();
			$job_period = $mRow['value'];

		} else if (PAYMENT_MODE == "3") {
			$job_period = $package['job_period'];
		}

		$sql = 'INSERT INTO '.DB_PREFIX.'employer (package_id, name, email, password, ip, confirmed, cvdb_access, job_period, jobs_left, cv_downloads_left)
                         VALUES (' . $package_id . ',
                         		 "' . $params['name'] . '",
                         		 "' . $params['email'] . '",
                                 "' . $params['password'] . '",
                                 "' . $params['ip'] . '",
                                 ' . $params['confirmed'] . ', 
                                 0,
                                 ' . $job_period . ',
                                 ' . $package['jobs_left'] . ',
                                 ' . $package['cv_downloads'] . ')';

		$result = $db->getConnection()->query($sql);
		return $db->getConnection()->insert_id;
	}

	public function updateEntry($params = array(), $hash) {
		global $db;

		$sql = 'UPDATE ' .DB_PREFIX. 'employer SET name = "' . $params['name']. '", password = "' . $params['password'] . '", ip = "' . $params['ip'] . '"
		        WHERE id =' . $this->userId;

		$result = $db->getConnection()->query($sql);

		if (intval($params['confirmed']) == 0) {

			// remove any old hashes
			$miniSql = 'DELETE FROM ' .DB_PREFIX. 'confirmed_recruiters WHERE user_id = ' . $this->userId;
			$db->getConnection()->query($miniSql);

			//insert into hash table
			$hashData = array('user_id' => $this->userId, 'hash' => $hash);
			$class = new HashTables();
			$class->createEntryForConfirmation($hashData);	
		}

	}

	public function createEntry($params = array(), $hash) {
		global $db;

		// get default
		$package_id = 1;
		$s = 'SELECT * FROM packages WHERE id = ' . $package_id;
		$r = $db->getConnection()->query($s);
		$package = $r->fetch_assoc();

		// PAYMENT DEACTIVATED, FREE OR FEES
		if (PAYMENT_MODE == "0" || PAYMENT_MODE == "1" || PAYMENT_MODE == "2") {
			$mSQL = 'SELECT value FROM settings WHERE name="job_expires"';
			$mRes = $db->getConnection()->query($mSQL);
			$mRow = $mRes->fetch_assoc();
			$job_period = $mRow['value'];

		} else if (PAYMENT_MODE == "3") {
			$job_period = $package['job_period'];
		}

		if (array_key_exists("package_id",$params)){
	        if($params['package_id'] == 0){        	
				$package_id = $params['package_id'];
				$job_period = 0;
				$package['jobs_left'] = 0;
				$package['cv_downloads'] = 0;
			}        
	    }		

		$sql = 'INSERT INTO '.DB_PREFIX.'employer (package_id, name, email, password, ip, confirmed, cvdb_access, job_period, jobs_left, cv_downloads_left)
                          VALUES (' . $package_id . ',
                         		 "' . $params['name'] . '",
                         		 "' . $params['email'] . '",
                                 "' . $params['password'] . '",
                                 "' . $params['ip'] . '",
                                 ' . $params['confirmed'] . ', 
                                 0,
                                 ' . $job_period . ',
                                 ' . $package['jobs_left'] . ',
                                 ' . $package['cv_downloads'] . ')';


		$result = $db->getConnection()->query($sql);
		$id = $db->getConnection()->insert_id;

		$this->userId = $id;

		if (intval($params['confirmed']) == 0) {
			//insert into hash table
			$hashData = array('user_id' => $id, 'hash' => $hash);
			$class = new HashTables();
			$class->createEntryForConfirmation($hashData);
		}

	}

	/** INVOICING **/
	public function createInvoice($employer_id, $path) {
		global $db;
		$sql = 'INSERT INTO '.DB_PREFIX.'invoice (employer_id, path, date, seen)
         VALUES (' . $employer_id . ',
            "' . $path . '",
            NOW(), 0)';

		$db->query($sql);
	}

	/** PAYPAL PAYMENT ENTRY **/
	public function createPayment($data) {
		global $db;

		$sql = 'INSERT INTO '.DB_PREFIX.'payment (transaction_id, transaction_status, transaction_timestamp, mysql_timestamp, employer_id, job_id, payer_id, payer_status, payer_email, payer_name, payer_surname, amount, currency_code) 
			VALUES ("' . $data['transcation_id'] . '",
            		"' . $data['tr_status'] . '",
					"' . $data['tr_timestamp'] . '", 
					NOW(),
					' . intval($data['employer_id']) . ',
					' . intval($data['job_id']) . ',
					"' . $data['paypal_payer_id'] . '",
					"' . $data['payer_status'] . '",
					"' . $data['payer_email'] . '",
					"' . $data['payer_name'] . '",
					"' . $data['payer_surname'] . '",
					"' . $data['amount'] . '",
					"' . $data['currency'] . '")';

		$db->query($sql);
	}

	public function checkInvoiceNotifications($employer_id) {
		global $db;
		$sql = 'SELECT id FROM '.DB_PREFIX.'invoice WHERE employer_id = ' . $employer_id . ' AND seen = 0';
		$result = $db->query($sql);

		$sql = 'SELECT id FROM '.DB_PREFIX.'invoice WHERE employer_id = ' . $employer_id;
		$result_two = $db->query($sql);
		$outcome = array("new_invoices" => $result->num_rows, "any_invoices" => $result_two->num_rows);
		return $outcome;
	}

	public function invoicesSeen($employer_id){
		global $db;
		$sql = 'SELECT id FROM '.DB_PREFIX.'invoice WHERE employer_id = ' . $employer_id;
		$result = $db->query($sql);
		while ($row = $result->fetch_assoc()){
			$sql = 'UPDATE '.DB_PREFIX.'invoice SET seen = 1 WHERE id = ' . $row['id'];
			$db->query($sql);
		}
	}

	public function getInvoicesByEmployerId($employer_id) {
		global $db;
		$sql = 'SELECT a.path as "path", UNIX_TIMESTAMP(a.date) as "date" FROM '.DB_PREFIX.'invoice a WHERE employer_id = ' . $employer_id . ' ORDER BY date DESC';
		$result = $db->query($sql);
		$invoices = array();
		while ($row = $result->fetch_assoc()) {
			

			$row["date"] = date(DATE_FORMAT, floatval(stripslashes($row["date"])));
			array_push($invoices, $row);
		}
		return $invoices;
	}


	public function getJobsByEmployerId($employer_id){
		global $db;

		$sql = 'SELECT id FROM '.DB_PREFIX.'jobs
		               WHERE is_tmp = 0 AND employer_id = ' . $employer_id;
		$result = $db->query($sql);
		$ids = array();

		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()){
					array_push($ids, $row['id']);
				}
		} 

		return $ids;
	}


} ?>
