<?php 

if (!defined('PROFILES_PLUGIN')) {
	require_once CONTROLLERS_PATH . '/page_more_content.php';
	$smarty->assign('error_msg', 'Application profiles plugin is missing');
	$template = 'err/err-general.tpl';
} else {

	// process form
	if (isset($_POST['apply_name'])) {
		escape($_POST);

		//captcha validation
		$captcha_enabled = ENABLE_RECAPTCHA;

		if ($captcha_enabled) {
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

		// URL
		$url = '';
		if (strpos($portfolio, "http://") !== false)
			$url = substr($portfolio, 7, strlen($portfolio) - 1);
		else if (strpos($portfolio, "https://") !== false)
			$url = substr($portfolio, 8, strlen($portfolio) - 1);
		else if (strpos($portfolio, "www.") !== false)
			$url = substr($portfolio, 4, strlen($portfolio) - 1);
		else
			$url = $portfolio;

		$password = md5($pass1);
		$skills = tagglesToString($taggles);
		$public_profile = 1;

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
			"name" => $apply_name,
			"occupation" => $occupation,
			"email" => $apply_email,
			"phone" => $apply_phone,
			"location" => $apply_location,
			"message" => stripLineBreaks($apply_msg), 
			"website" => $url,
			"skills" => $skills,
			"cv_path" => $cv_path,
			"public_profile" => $public_profile,
			"password" => $password,
			"sm_links" => $sm_links,
			"confirmed" => EMAIL_CONFIRMATION_FLAG
		);	

		// create profile
		$class = new Applicant();

		$status = $class->checkIfUserExistsAndIsConfirmed($apply_email);

		$APPLICANT_ID = $class->getId();
		// 2 = candidate does not exist, create entry
		// 1 = exists and is confirmed, show error
		// 0 = exists but not confirmed, update
		
		switch ($status) {
			case 0:
				$class->updateExistingApplicant($data, $APPLICANT_ID, false, $public_profile);
				
				if (intval(EMAIL_CONFIRMATION_FLAG) == 0) {
					// send verification email
					$confirmHash = $class->getConfirmHash();
					$mailer = new Mailer();
					$mailer->applicantVerificationEmail($apply_email, $confirmHash);

					//show message
					redirect_to(BASE_URL . URL_ACCOUNT_NOT_CONFIRMED . '/app');
					break;	
				} else {
					$_SESSION['applicant'] = $APPLICANT_ID;
					$_SESSION['applicant_name'] = $data['apply_name'];
					//log in
					redirect_to(BASE_URL . URL_PROFILE);
					break;
				}

			case 1:
				$class->updateExistingApplicant($data, $APPLICANT_ID, false, $public_profile);

				$_SESSION['applicant'] = $APPLICANT_ID;
				$_SESSION['applicant_name'] = $data['apply_name'];
				//log in
				redirect_to(BASE_URL . URL_PROFILE);
				break;

			case 2:
				$class->createCandidateProfile($data);
				$APPLICANT_ID = $class->getId();

				if (intval(EMAIL_CONFIRMATION_FLAG) == 0) {
					// send verification email
					$confirmHash = $class->getConfirmHash();
					$mailer = new Mailer();
					$mailer->applicantVerificationEmail($apply_email, $confirmHash);

					//show message
					redirect_to(BASE_URL . URL_ACCOUNT_NOT_CONFIRMED . '/app');
					break;	
				} else {
					$_SESSION['applicant'] = $APPLICANT_ID;
					$_SESSION['applicant_name'] = $data['apply_name'];

					//log in
					redirect_to(BASE_URL . URL_PROFILE);
					break;
				}

			default:
				# code...
				break;
		}

	}

	if (!$skipTpl) {
		$sanitizer = new Sanitizer();
		// CAPTCHA ######################################
		$captcha_enabled = ENABLE_RECAPTCHA;
		if ($captcha_enabled) {
			$pattern = "1234567890abcdefghijklmnopqrstuvwxyz";
			$token  = "";	
			for( $i = 1; $i <= 6 ; $i++ ) {
				$token .= $pattern{rand( 0, 35 )};
			}
			$encryptedToken = sha1( $token );

			// save the $encryptedToken in the session
			$_SESSION['encryptedToken'] = $encryptedToken;
			$rawCaptchaBytes =  base64_encode(simple_php_captcha($token));

			$the_captcha = str_replace('{RAW}', $rawCaptchaBytes, recaptcha_get_html());
			$the_captcha = str_replace('{CAPTCHA_LABEL}', $translations['captcha']['captcha_label'], $the_captcha);
			$smarty->assign('captcha_html', $the_captcha);
		}
		$smarty->assign('ENABLE_RECAPTCHA', $captcha_enabled);
		// CAPTCHA ######################################

		$hint = str_replace("{SIZE}", formatBytes(MAX_CV_SIZE), $translations['apply']['cv_hint']);
		$smarty->assign('cv_hint', $hint);
		$smarty->assign('MAX_CV_SIZE', MAX_CV_SIZE);

		$smarty->assign('LOAD_TAGL', true);
		$smarty->assign('TAGL_INIT_JOB_DETAIL', true);

		$sm_profiles = $job->getSMprofiles();
		$smarty->assign('SM_PROFILES', $sm_profiles);

		$template = 'auth/register-applicants.tpl';
	}
	
}

?>