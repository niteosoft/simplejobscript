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

	
/* Because we needed to separate employer and applicant users
we also need to prevent confirmation tables to clash IDs. Thats why we have 4 tables (pass recovery + confirmation) for 
both types */
class HashTables {
	
	public $user_id = null;
	public $hash = null;

	function __construct() {}

	public function getUserId() {
		return $this->user_id;
	}

	public function getUserEmail($id){
		global $db;

		$sql = 'SELECT email
           FROM '.DB_PREFIX.'employer
           WHERE id = "' . $id . '"';
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        return $row['email'];
	}

	public function getUserEmailApplicant($id){
		global $db;

		$sql = 'SELECT email
           FROM '.DB_PREFIX.'applicant
           WHERE id = "' . $id . '"';
        $result = $db->query($sql);
        $row = $result->fetch_assoc();
        return $row['email'];
	}

	public function createEntryForConfirmation($params = array()) {
		global $db;

		$sql = 'INSERT INTO '.DB_PREFIX.'confirmed_recruiters (user_id, hash)
                         VALUES (' . $params['user_id'] . ',
                         		 "' . $params['hash'] . '")';

		$result = $db->query($sql);
	}

	public function checkForPassRecoveryHash($hash) {
		global $db;

		$sql = 'SELECT user_id
               FROM '.DB_PREFIX.'forgotten_password_recruiters
               WHERE hash = "' . $hash . '"';

         $result = $db->query($sql);

         if (($result->num_rows > 0)) {
         	$row = $result->fetch_assoc();
         	$this->user_id = $row['user_id'];

			$sql = 'DELETE FROM '.DB_PREFIX.'forgotten_password_recruiters
               WHERE hash = "' . $hash . '"';

            $result = $db->query($sql);
         	return true; 
         }
         else 
         	return false;
	}

	public function checkForPassRecoveryHashApplicants($hash) {
		global $db;

		$sql = 'SELECT user_id
               FROM '.DB_PREFIX.'forgotten_password_applicants
               WHERE hash = "' . $hash . '"';

         $result = $db->query($sql);

         if (($result->num_rows > 0)) {
         	$row = $result->fetch_assoc();
         	$this->user_id = $row['user_id'];

			$sql = 'DELETE FROM '.DB_PREFIX.'forgotten_password_applicants
               WHERE hash = "' . $hash . '"';

            $result = $db->query($sql);
         	return true; 
         }
         else 
         	return false;
	}

	public function createEntryForPassrecoveryRecruiters($params = array()) {
		global $db;

		$sql = 'SELECT user_id
               FROM '.DB_PREFIX.'forgotten_password_recruiters
               WHERE user_id = "' . $params['user_id'] . '"';

         $result = $db->query($sql);
         $row = $result->fetch_assoc();
         if (!empty($row)) {
         	//there are some old hashes user already requested new password but have not used the recovery from email
			$sql = 'DELETE FROM '.DB_PREFIX.'forgotten_password_recruiters
	               WHERE user_id = "' . $params['user_id'] . '"';
	        $result = $db->query($sql); //delete
         }

         //insert new hash
		$sql = 'INSERT INTO '.DB_PREFIX.'forgotten_password_recruiters (user_id, hash)
                         VALUES (' . $params['user_id'] . ',
                         		 "' . $params['hash'] . '")';

		$result = $db->query($sql);
	}

	public function createEntryForPassrecoveryApplicants($params = array()) {
		global $db;

		$sql = 'SELECT user_id
               FROM '.DB_PREFIX.'forgotten_password_applicants
               WHERE user_id = "' . $params['user_id'] . '"';

         $result = $db->query($sql);
         $row = $result->fetch_assoc();
         if (!empty($row)) {
         	//there are some old hashes user already requested new password but have not used the recovery from email
			$sql = 'DELETE FROM '.DB_PREFIX.'forgotten_password_applicants
	               WHERE user_id = "' . $params['user_id'] . '"';
	        $result = $db->query($sql); //delete
         }

         //insert new hash
		$sql = 'INSERT INTO '.DB_PREFIX.'forgotten_password_applicants (user_id, hash)
                         VALUES (' . $params['user_id'] . ',
                         		 "' . $params['hash'] . '")';

		$result = $db->query($sql);	
	}

} ?>
