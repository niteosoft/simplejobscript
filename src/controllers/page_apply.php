<?php
//error_reporting(1);
$ERROR = FALSE;

if (!isset($_POST['job_id']))
	redirect_to(BASE_URL);

//assign additional content
require_once 'page_more_content.php';

$DIR_CONST = '';
if (defined('__DIR__'))
	$DIR_CONST = __DIR__;
else
	$DIR_CONST = dirname(__FILE__);

escape($_POST);
$ip = get_client_ip();

//captcha validation
$captcha_enabled = ENABLE_RECAPTCHA;

if ($captcha_enabled && intval($new_user) != 0) {
	//check captcha code
	if (!strcmp(sha1($_POST['captcha']), $_SESSION['encryptedToken']) == 0)  {
		//generate new captcha and destroy old one
		unset($_SESSION['encryptedToken']);
		$msg = str_replace("{LINK}", " <a href=\"" . $_SERVER['HTTP_REFERER'] . "\">here</a> ", $translations['apply']['captcha_err_redirect']);
		$smarty->assign('error_msg', $msg);
		$template = 'err/err-general.tpl';
		return;
	}
}
// ################### captcha

$public_profile = (isset($public_profile)) ? 1 : 0;

$ERROR = FALSE;

if (intval($new_user) == 1) {

		// CV
		if (!empty($_FILES["cv"]['tmp_name'])) {

			$f = pathinfo($_FILES['cv']['name']);
			$f_rename = pathinfo(cleanString($_FILES['cv']['name']));

			$UID = uniqid();
			$basefilename = $f_rename['filename'] . '_' . $UID;
			$filename = $basefilename . '.' . $f['extension'];

			if ($f['extension'] == "pdf" || $f['extension'] == "doc" || $f['extension'] == "docx") {

				$suffix = 0;
				while (file_exists(FILE_UPLOAD_DIR . $filename)) {
					$suffix++;
					$filename = $basefilename . '_' . $suffix . '.' . $f['extension'];
				}

				if (move_uploaded_file($_FILES['cv']['tmp_name'], FILE_UPLOAD_DIR . $filename))
				{
					$cv_path = FILE_UPLOAD_DIR . $filename;
				}
				else
				{
					$cv_path = '';
				}

				if (!empty($_FILES['cv']['error'])) {
					$cv_path = '';
				}	

			} else {
				$smarty->assign('error_msg', $translations['applications']['cv'] . " error. " . $translations['apply']['cv_err']);
				$template = 'err/err-general.tpl';
				return;
			}

		} else {
			$cv_path = '';
		}

	chmod($cv_path, 0777);

	$url = '';
	if (strpos($portfolio, "http://") !== false)
		$url = substr($portfolio, 7, strlen($portfolio) - 1);
	else if (strpos($portfolio, "https://") !== false)
		$url = substr($portfolio, 8, strlen($portfolio) - 1);
	else if (strpos($portfolio, "www.") !== false)
		$url = substr($portfolio, 4, strlen($portfolio) - 1);
	else
		$url = $portfolio;

	$password = (!empty($xuser_password) && $xuser_password != "" && intval($public_profile) == 1) ? md5(trim($xuser_password)) : md5("123");

	// parse skills
	$skills = tagglesToString($taggles);

	$sm_links = array();

	if (isset($sm_url_1) && $sm_url_1 != "") {
		$obj1 = constructSMlink($sm_url_1, $sm_select_1);
		$sm_links["first"] = $obj1;
	} else {
		$sm_links["first"] = "-";
	}

	if (isset($sm_url_2) && $sm_url_2 != "") {
		$obj2 = constructSMlink($sm_url_2, $sm_select_2);
		$sm_links["second"] = $obj2;
	} else {
		$sm_links["second"] = "-";
	}

	if (isset($sm_url_3) && $sm_url_3 != "") {
		$obj3 = constructSMlink($sm_url_3, $sm_select_3);
		$sm_links["third"] = $obj3;
	} else {
		$sm_links["third"] = "-";
	}

	if (isset($sm_url_4) && $sm_url_4 != "") {
		$obj4 = constructSMlink($sm_url_4, $sm_select_4);
		$sm_links["fourth"] = $obj4;
	} else {
		$sm_links["fourth"] = "-";
	}

	$data = array(
		"job_id" => $job_id,
		"name" => $apply_name,
		"occupation" => $occupation,
		"email" => $apply_email,
		"phone" => $apply_phone,
		"location" => $apply_location,
		"message" => stripLineBreaks($apply_msg), 
		"shell_message" => strip_tags($apply_msg), 
		"website" => $url,
		"skills" => $skills,
		"cv_path" => $cv_path,
		"public_profile" => $public_profile,
		"password" => $password,
		"ip" => $ip,
		"sm_links" => $sm_links,
		"confirmed" => EMAIL_CONFIRMATION_FLAG
	);	

	$cl = new Applicant();
	$status = $cl->checkIfUserExistsAndIsConfirmed($apply_email);
	$APPLICANT_ID = $cl->getId();

	// 2 = candidate does not exist, create entry
	// 1 = exists and is confirmed, update
	// 0 = exists but not confirmed, update
	switch ($status) {
		case 0:
			$cl->updateExistingApplicant($data, $APPLICANT_ID, $job_id, $public_profile);
			break;
		case 1:
			$cl->updateExistingApplicant($data, $APPLICANT_ID, $job_id, $public_profile);
			break;

		case 2:
			$APPLICANT_ID = $cl->createEntry($data, $job_id, $public_profile);
			break;

		default:
			break;
	}

	if (intval($public_profile) == 1)
		$confirmHash = $cl->getConfirmHash();	

	//if ($ERROR !== "multiple_accounts_err")
	//	$ERROR = FALSE;

} else {

	// existing candidate plugin
	if (defined('PROFILES_PLUGIN')) {
		try {
			include($DIR_CONST . '../../plugins/Profiles/application_snippet.php');
		} catch (Exception $e) {}
	}
}

if (is_null($APPLICANT_ID)) {
	$template = 'err/err-general.tpl';
	$smarty->assign('error_msg', $translations['apply']['apply_err_msg']);
} else {
	
	if ($ERROR == FALSE) {

		 $app = new JobApplication($data);
		 $app->Apply($APPLICANT_ID, $public_profile);

		 $mailer = new Mailer();
		 $job = new Job($job_id);
		 $employer = new Employer();

		 $job_info = $job->GetInfo();
		 $employer_data = $employer->getEmployerById($job_info['employer_id']);

		 //create new dashboard notification for employer
		 $employer->createNotification($job_info['employer_id']);

		 //send notification to the person who applied
		 $mailer->sendAppliedEmail($job_info, $data['email']);

		if (intval($public_profile) == 1 && intval($status) != 1) { 

			if (intval(EMAIL_CONFIRMATION_FLAG) == 0) {
				$mailer->applicantVerificationEmail($data['email'], $confirmHash);
			}

		}

		//send notification to employer
		$mailer->sendEmployerNewApplicationEmail($data, $job_info, $employer_data['email']);
	}

	if (strcmp($ERROR, "multiple_accounts_err") == 0) {
		$template = 'err/err-general.tpl';
	} else {
		//show messsage that this happened
		if ($ERROR == TRUE) {
			$template = 'err/err-general.tpl';
			$smarty->assign('error_msg', $translations['apply']['apply_err_msg']);
		} else {

			if (intval($public_profile) == 1 && intval(EMAIL_CONFIRMATION_FLAG) == 1) {
				$_SESSION['applicant'] = $APPLICANT_ID;
				$_SESSION['applicant_name'] = $data['apply_name'];

				redirect_to(BASE_URL . URL_PROFILE);
				exit;
			}

			$template = 'success/success.tpl';
			$smarty->assign('success_msg', $translations['apply']['apply_success_msg']);
		}
	}
}
?>
