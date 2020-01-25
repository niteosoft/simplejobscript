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

	class Newsletter {

		const NEW_LINE = "\r\n";

		public function __construct(){}

		public function createQueue() {
			global $db;
			$sql = 'SELECT email, categories FROM '.DB_PREFIX.'subscriptions WHERE confirmed = 1';
			$result = $db->query($sql);
			while ($row = $result->fetch_assoc()){
				//create mail sending queue
				$s = 'INSERT INTO '.DB_PREFIX.'email_queue (email, categories, created_on)
			                    VALUES ("' . $row['email'] . '", "' . $row['categories'] . '", NOW())';

			    $res = $db->query($s);

			}

		}

		public function sendNewsletter($limit) {
			global $db;
			$sql = 'SELECT email, categories FROM '.DB_PREFIX.'email_queue limit ' . $limit;
			$result = $db->query($sql);
			$emails = array();

			//ad recepients get jobs an
			while ($row = $result->fetch_assoc()) {
					
				$cats = explode(",", $row['categories']);

				//if cats contain 0 get all
				// sending the latest 10 jobs to keep the job alert brief
				if (in_array("0", $cats)) {
					$isql = 'SELECT id FROM '.DB_PREFIX.'jobs WHERE UNIX_TIMESTAMP(expires) > UNIX_TIMESTAMP(NOW()) AND
						     created_on between now() - interval 1 week and now() AND is_tmp = 0 AND is_active = 1 limit 10';
				} else {
					// get specific categories
					$isql = 'SELECT id FROM '.DB_PREFIX.'jobs WHERE category_id in (' .$row['categories'] . ') AND
							 UNIX_TIMESTAMP(expires) > UNIX_TIMESTAMP(NOW()) AND
						     created_on between now() - interval 1 week and now() AND is_tmp = 0 AND is_active = 1 limit 10';
				}
				//UNIX_TIMESTAMP(a.expires) AS closed_on, DATEDIFF(NOW(), created_on)

				$iresult = $db->query($isql);
				$jobs = array();

				while ($irow = $iresult->fetch_assoc()) {
					//if no new jobs to send skip the job do not send anything
					if (empty($irow)) {
						echo "THERE ARE NO NEW JOBS IN THE CATEGORIES: " . $row['categories'] . " that are active and 1 week old" . self::NEW_LINE;
						return;
					}
					array_push($jobs, $irow['id']);
				}

				$emails[$row['email']] = $jobs;
			}

			//send
			$mailer = new Mailer();
			$mailer->sendBulkEmail($emails);

		}


	}
?>
