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

class SpamReport
{
	private $mIp = false;
	private $mJobId = false;
	private $mCount = false;
	private $update = false;
	
	public function __construct($job_id)
	{
		global $db;
		$this->mJobId = $job_id;
		$sql = 'SELECT count
           FROM '.DB_PREFIX.'spam_reports
           WHERE job_id= ' . $job_id;
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		if (empty($row)) 
			$this->mCount = 0;
		else {
			$this->update = true;
			$this->mCount = $row['count'];
		}		
	}
	
	// Report a job post as spam
	public function insertNewReport($msg)
	{
		global $db;
		$count = $this->mCount + 1;
		$ip = get_client_ip();

		if ($this->update) {
			$sql = 'UPDATE '.DB_PREFIX.'spam_reports SET count="'.$count.'" WHERE job_id="'.$this->mJobId.'"';
			return ($db->query($sql)) ? true : false;
		} else {

			$sql = 'INSERT INTO '.DB_PREFIX.'spam_reports (job_id, date, msg, count, ip)
				                    VALUES ("' . $this->mJobId . '", NOW(), "' . $msg . '", "' . $count.'", "' . $ip . '")';
			return ($db->query($sql)) ? true : false;
		}
	}
	
}
?>
