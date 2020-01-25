<?php 
	
	if (isset($id)) {

		if ($id === "delete") {
			$cid = intval($extra);
			//remove all job applications
			$sql = 'DELETE FROM job_applications WHERE applicant_id = ' . $cid;
	    	$db->query($sql);

			//send notification email
		    $sql = 'SELECT * FROM applicant WHERE id = ' . $cid;
	        $data = $db->query($sql);
	        $candidateInfo = $data->fetch_assoc();

			$mailer = new Mailer();
			$mailer->notifyDeletedCandidate($candidateInfo['email'], $candidateInfo['fullname']);

			try {
				$DIR = '';
				if (defined('__DIR__'))
					$DIR = __DIR__;
				else
					$DIR = dirname(__FILE__);

				if (strlen($candidateInfo['cv_path']) > 1 && file_exists($DIR . '/../' . $candidateInfo['cv_path'])) {
					unlink($DIR . '/../' . $candidateInfo['cv_path']);
				}
			} catch (Exception $e) {}

			//remove candidate
			$sql = 'DELETE FROM applicant WHERE id = ' . $cid;
	    	$db->query($sql);

	    	//remove from subscribers
	    	$sql = 'DELETE FROM subscribers WHERE email = "' . $candidateInfo['email'] . '"';
	    	$db->query($sql);

	    	$sql = 'DELETE FROM subscriptions WHERE email = "' . $candidateInfo['email'] . '"';
	    	$db->query($sql);
	    	
	    	redirect_to(BASE_URL . 'candidates/deleted');
		}

		if ($id === "confirm") {
			$cid = intval($extra);
			$sql = 'UPDATE applicant SET confirmed = 1 WHERE id = ' . $cid;
			$db->query($sql);
		} else if ($id === "unconfirm") {
			$cid = intval($extra);
			$sql = 'UPDATE applicant SET confirmed = 0 WHERE id = ' . $cid;
			$db->query($sql);
		}

		if ($id === "confirm" || $id === "unconfirm") {
			$ID = intval($extra);
		} else {
			$ID = intval($id);
		}
		
	    $sql = 'SELECT * FROM applicant WHERE id = ' . $ID;
	    $data = $db->query($sql);

	} else {
		$data = null;
	}

	 $info = $data->fetch_assoc();

	 $sm_links = array();

     if (!empty($info['sm_link_1']) && $info['sm_link_1'] != "-") {
        $sm_links["first"] = deconstructSMlink($info['sm_link_1']);
     }

     if (!empty($info['sm_link_2']) && $info['sm_link_2'] != "-") {
        $sm_links["second"] = deconstructSMlink($info['sm_link_2']);
     }

     if (!empty($info['sm_link_3']) && $info['sm_link_3'] != "-") {
        $sm_links["third"] = deconstructSMlink($info['sm_link_3']);
     }

     if (!empty($info['sm_link_4']) && $info['sm_link_4'] != "-") {
        $sm_links["fourth"] = deconstructSMlink($info['sm_link_4']);
     }

     $info['sm_links'] = $sm_links;

	$se = explode(",", $info['skills']);
	$skills = '';
	foreach ($se as $skill) {
		$skills .=  "#" . $skill . " ";
	}

	$info['skills_formated'] = $skills;

    if ($info['cv_path'] != "") {
        $var = explode(".", $info['cv_path']);
        $ext = end($var);
        if (strcmp($ext, "pdf") == 0){
            $imgPath = 'fa fa-file-pdf-o fa-lg pdf-el';
        }
        else {
            $imgPath = 'fa fa-file-word-o fa-lg word-el';
        }  
    }

    $smarty->assign("data", $info);
    $smarty->assign("imgPath", $imgPath);
	$template = 'candidate.tpl';

?>