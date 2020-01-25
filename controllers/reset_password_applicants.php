<?php

	//if post
	if (isset($_POST['forget_pass'])){
		escape($_POST);
		$newPass = md5($forget_pass);
		$class = new Applicant();

		if (isset($_POST['userid']) && $_POST['userid'] != "") {
			$result = $class->updatePassword($_POST['userid'], $newPass);
		} else {
			$result = false;
		}

		if ($result) {
			$smarty->assign('response', 'positive-feedback');
			$update_msg =  str_replace("{signin}", "<a class=\"themeLink\" href=\"/" . URL_LOGIN_APPLICANTS ."\">" . $translations['login']['login_submit'] . "</a>", $translations['login']['update_win']);
			$smarty->assign('update_msg', $update_msg);

		}
		else {
			$smarty->assign('response', 'negative-feedback');
			$update_msg =  str_replace("{contactus}", $translations['login']['contact_us'], $translations['login']['update_fail']);
			$smarty->assign('update_msg', $update_msg);
		}
			
	} else {
		//update users password
		$class = new HashTables();
		$result = $class->checkForPassRecoveryHashApplicants($id); //id=hash
		$userid = $class->getUserId();

		$useremail = $class->getUserEmailApplicant($userid);
		if (!empty($useremail))
			$headline = $msg = str_replace('{ACCOUNT}', $useremail, $translations['login']['newpass_headline']);
		else
			$headline = "Password recovery";
		//set status
		$smarty->assign('result', $result);
		$smarty->assign('user_id', $userid);
		$smarty->assign('recovery_headline', $headline);
		$template = 'auth/reset-password.tpl';
	}
	
	$smarty->assign('result', 1);
	$smarty->assign('FORM_URL', URL_RESET_PASSWORD_APPLICANTS);
	$template = 'auth/reset-password.tpl';
?>