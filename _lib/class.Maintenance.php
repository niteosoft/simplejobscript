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

class Maintenance
{
	
	function __construct()
	{ }

	public function getNumberOfOldHits() {
		global $db;
	
		$sql = 'SELECT COUNT(job_id) as "total" FROM `hits` WHERE created_on < DATE_SUB(NOW(), INTERVAL ' . '6' . ' MONTH)';
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		return $row['total'];
	}

	public function getTmpJobs() {
		global $db;
		$sql = 'SELECT COUNT(id) as "total" FROM '.DB_PREFIX.'jobs WHERE is_tmp = 1';
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		return $row['total'];
	}

	public function getExpiredJobs() {
		global $db;
		$sql = 'SELECT COUNT(id) as "total" FROM '.DB_PREFIX.'jobs WHERE NOW() > expires';
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		return $row['total'];
	}

	public function getActiveExpiredJobs() {
		global $db;
		$sql = 'SELECT COUNT(id) as "total" FROM '.DB_PREFIX.'jobs WHERE NOW() > expires AND is_active = 1';
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		return $row['total'];
	}

	public function deleteTmpJobs() {
		global $db;
		$sql = 'DELETE FROM '.DB_PREFIX.'jobs WHERE is_tmp = 1';
		$result = $db->query($sql);
	}

	public function deleteOldHits() {

		global $db;
		$sql = 'DELETE FROM `hits` WHERE created_on < DATE_SUB(NOW(), INTERVAL ' . '6' . ' MONTH)';
		$result = $db->query($sql);
	}

	public function deleteExpiredJobs() {
		
		global $db;

		$sql = 'SELECT id as "job_id" FROM '.DB_PREFIX.'jobs WHERE NOW() > expires';
		$result = $db->query($sql);

		while ($row = $result->fetch_assoc()) {

			$JOB_ID = $row['job_id'];
			$job = new Job();
			$job->deleteById($JOB_ID);
		}

	}

	public function deactivateExpiredJobs() {
		global $db;
		$sql = 'SELECT id as "job_id" FROM '.DB_PREFIX.'jobs WHERE NOW() > expires';
		$result = $db->query($sql);

		while ($row = $result->fetch_assoc()) {
			$sql = 'UPDATE '.DB_PREFIX.'jobs SET is_active = 0 WHERE id =' . intval($row['job_id']);
			$db->query($sql);
		}

	}

}
?>
