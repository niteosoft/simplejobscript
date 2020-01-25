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

class Company {

	private $_name = null;
	private $_description = null;
	private $_hq = null;
	private $_url = null;
	private $_logopath = null;
	private $_employerid = null;

	function __construct() {}

	public function createCompany($params) {
		global $db;
		$sql = 'INSERT INTO '.DB_PREFIX.'company (name, description, hq, url, street, city_postcode, logo_path, employer_id, public_page, profile_picture)
                         VALUES ("' . $params['company_name'] . '",
                         		 "' . $params['company_desc'] . '",
                                 "' . $params['company_hq'] . '",
                                 "' . $params['company_url'] . '",
                                 "' . $params['company_street'] . '",
                                 "' . $params['company_citypostcode'] . '",
                                 "' . $params['logo_path'] . '",
                                 ' . $params['employer_id'] . ',
                                 1,
                                 "' . DEFAULT_PROFILE_PATH . '")';

		$result = $db->query($sql);
	}


	public function updateEntry($params) {
		global $db;

		$sql = 'UPDATE ' .DB_PREFIX. 'company SET name = "' . $params['company_name'] . '", description = "' . $params['company_desc'] . '",
			    hq = "' . $params['company_hq'] . '", url = "' . $params['company_url'] . '", street = "' . $params['company_street'] . '",
			    city_postcode = "' . $params['company_citypostcode'] . '", logo_path = "' . $params['logo_path'] . '"
			    WHERE employer_id = ' . $params['employer_id'];

		$result = $db->query($sql);
	}

	public function updateAdminEmployerData($eid, $email) {
		global $db;

		$sql = 'UPDATE employer SET email = "' . $email . '" WHERE id =' . $eid;
		$result = $db->query($sql);
	}

	public function getAdminCompanyData() {
		global $db;
		$sql = 'SELECT c.id as "company_id", c.name as "company_name", emp.id as "employer_id", emp.name as "employer_name", emp.email as "employer_email" FROM company c INNER JOIN 
		employer emp ON emp.id=c.employer_id WHERE emp.id=144';
		$result = $db->query($sql);
		if ($result) {
			$row = $result->fetch_assoc();
			return $row;
		} else {
			return array();
		}
	}

	public function updateCompanyByEmployerId($params) {
		global $db;

		$sql = 'UPDATE ' . DB_PREFIX . 'company SET 
				name="' . $params['company_name'] . '",
				description="' . $params['company_desc'] . '",
				hq="' . $params['company_hq'] . '",
				url="' . $params['company_url'] . '",
				street="' . $params['company_street'] . '",
				city_postcode="' . $params['company_citypostcode'] . '",
				logo_path="' . $params['logo_path'] . '",
				public_page=' . $params['public_page'] . ',
				profile_picture="' . $params['profile_picture'] . '"
				WHERE employer_id = ' . $params['employer_id'];

		$result = $db->query($sql);
		return $result;
	}

	public function deleteCompanyDataByEmployerId($employer_id) {
		global $db;

		$DIR_CONST = '';
		if (defined('__DIR__'))
			$DIR_CONST = __DIR__;
		else
			$DIR_CONST = dirname(__FILE__);

		//first get logo
		$sql = 'SELECT logo_path FROM '.DB_PREFIX.'company WHERE employer_id = ' . $employer_id;
		$result = $db->query($sql);
		$row = $result->fetch_assoc();

		$sql = 'DELETE FROM '.DB_PREFIX.'company WHERE employer_id = ' . $employer_id;
		$db->query($sql);

		if (!empty($row)) {
			try {
			   $path = $DIR_CONST . '/../' . $row['logo_path'];
			   if (strpos($row['logo_path'], "company-default") === false) {
			   		 unlink($path);
			   }
			  
			} catch (Exception $e) {}

			try {
 			   $path = __DIR__ . '/../' . $row['profile_picture'];
 			   	if (strpos($row['profile_picture'], "profile-picture-default") === false) {
 					unlink($path);
 				}
 			  
 			} catch (Exception $e) {}

		}
		
	}

	public function unconfirmAndLogout($id) {
		global $db;
		$sql = 'UPDATE ' . DB_PREFIX . 'employer SET confirmed = 0 WHERE id = ' . $id;
		$result = $db->query($sql);
		redirect_to('logout');
	}

	public function getCompanyByEmployerId($id) {
		global $db;
		$sql = 'SELECT * FROM ' . DB_PREFIX . 'company WHERE employer_id = ' . $id;
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		return $row;
	}

	public function getData() {
		$std = new stdClass;
		$std->name = $this->_name;
		$std->description = $this->_description;
		$std->hq = $this->_hq;
		$std->url = $this->_url;
		$std->logopath = $this->_logopath;
		$std->employerid = $this->_employerid;
		return $std;
	}


}
?>
