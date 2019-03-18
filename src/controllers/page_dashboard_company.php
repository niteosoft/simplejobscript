<?php 

	$DIR_CONST = '';
	if (defined('__DIR__'))
		$DIR_CONST = __DIR__;
	else
		$DIR_CONST = dirname(__FILE__);

	if (!empty($_FILES["company_logo"]['tmp_name'])) {
		//unset the old logo
		try {
			$path = $DIR_CONST . '/../' . $_POST['oldlogo-path'];
			//delete all files except the default one :-)
			if (strpos($_POST['oldlogo-path'], "company-default") === false) {
				unlink($path);
			}
			
		} catch (Exception $e) {}

		$newNamePrefix = time() . '_';
		$manipulator = new ImageManipulator($_FILES['company_logo']['tmp_name']);

		$size = getimagesize($_FILES["company_logo"]['tmp_name']);
		$fileType = $size[2];
		if ($size[0] > 200) {
			//needs a resize
	        $newImage = $manipulator->resample(200, 200);		        
		}
		$final_path = COMPANIES_UPLOAD_FOLDER . $newNamePrefix . $_FILES['company_logo']['name'];
		$manipulator->save($final_path, $fileType);
	} else {
		global $db;
		$sql = 'SELECT logo_path FROM company WHERE employer_id=' . $_POST['employer_id'];
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		// not changed. keep the current one
		$final_path = $row['logo_path'];
	}
	escape($_POST);
	
	$public_prof = (isset($profile_switch)) ? 1 : 0; 
 
 	if ($public_prof != 0) {
 		if (!empty($_FILES["pp_file"]['tmp_name'])) {
 			//unset the old logo
 			try {
 				$path = __DIR__ . '/../' . $_POST['oldPP'];
 				//delete all files except the default one :-)
 			   	if (strpos($_POST['oldPP'], "profile-picture-default") === false) {
 					unlink($path);
 				}
 				
 			} catch (Exception $e) {}
 
 			$newNamePrefix = 'pp_' . time() . '_';
 			$manipulator = new ImageManipulator($_FILES['pp_file']['tmp_name']);
 
 			$size = getimagesize($_FILES["pp_file"]['tmp_name']);
 			$fileType = $size[2];
 
 			$pp_path = COMPANIES_UPLOAD_FOLDER . $newNamePrefix . $_FILES['pp_file']['name'];
 			$manipulator->save($pp_path, $fileType);
 		} else {
 			global $db;
 			$sql = 'SELECT profile_picture FROM company WHERE employer_id=' . $_POST['employer_id'];
 			$result = $db->query($sql);
 			$row = $result->fetch_assoc();
 			// not changed. keep the current one
 			$pp_path = $row['profile_picture'];
 
 		}
 	} else {
 		global $db;
 		$sql = 'SELECT profile_picture FROM company WHERE employer_id=' . $_POST['employer_id'];
 		$result = $db->query($sql);
 		$row = $result->fetch_assoc();
 		// not changed. keep the current one
 		$pp_path = $row['profile_picture'];
 	}

	if (strpos($company_url, "http://") !== false)
		$company_url = substr($company_url, 7, strlen($company_url) - 1);
	else if (strpos($company_url, "https://") !== false)
		$company_url = substr($company_url, 8, strlen($company_url) - 1);
	else if (strpos($company_url, "www.") !== false)
		$company_url = substr($company_url, 4, strlen($company_url) - 1);

	$data = array('company_name' => $company_name, 'company_desc' => $db->getConnection()->real_escape_string($_POST['company_desc']), 
				  'company_hq' => $company_hq,  'company_url' => $company_url, 
				  'employer_id' => $employer_id, 'logo_path' => $final_path,'company_street' => $company_street,
				  'company_citypostcode' => $company_citypostcode, 'profile_picture' => $pp_path, 'public_page' => $public_prof);

	$class = new Company();
	$result = $class->updateCompanyByEmployerId($data);

	if ($result) {
		$smarty->assign('msg', $translations['dashboard_recruiter']['change_company_success']);
		$smarty->assign('view', 'success.tpl');
	} else {
		$smarty->assign('msg', $translations['dashboard_recruiter']['change_company_fail']);
		$smarty->assign('view', 'error.tpl');
	}

	$smarty->assign('JS_ID', 'company-li');
	$template =  'dashboard/dashboard.tpl';
?>
