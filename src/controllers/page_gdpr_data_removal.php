<?php

$captcha_enabled = ENABLE_RECAPTCHA;
if ($captcha_enabled) {
	$pattern = "1234567890abcdefghijklmnopqrstuvwxyz";
	$token  = "";	
}
$smarty->assign('ENABLE_RECAPTCHA', $captcha_enabled);

if (isset($_POST['gdpr_email'])) {
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

		// remove data according to the role from select

		switch ($gdpr_user_select) {
			case '1':
				// remove candidate
				$sql = 'SELECT id FROM '.DB_PREFIX.'applicant WHERE email="' . $gdpr_email.'"';
			
	            $result = $db->query($sql);

	            $row = $result->fetch_assoc();

	            if ($result->num_rows > 0) {

					 $sql = 'DELETE FROM '.DB_PREFIX.'applicant WHERE id=' . $row["id"];
					 $result = $db->query($sql);

					 $sql = 'DELETE FROM '.DB_PREFIX.'job_applications WHERE applicant_id=' . $row["id"] ;
   					 $result = $db->query($sql);

   					 $smarty->assign('gdpr_msg_neg', 1);
   					 $smarty->assign('gdpr_msg', $translations['profile']['op_success']);

	            } else {
	       	          $smarty->assign('gdpr_msg_neg', 0);
	           		  $smarty->assign('gdpr_msg', $translations['admin']['no_entry_err'] . " (" . $gdpr_email . ")");     	
	            }

				break;

			case '2':
				// remove employer
				$sql = 'SELECT id FROM '.DB_PREFIX.'employer WHERE email="' . $gdpr_email.'"';
			
	            $result = $db->query($sql);

	            $row = $result->fetch_assoc();

	            if ($result->num_rows > 0) {

					 $sql = 'DELETE FROM '.DB_PREFIX.'employer WHERE id=' . $row["id"];
					 $result = $db->query($sql);

					 $sql = 'DELETE FROM '.DB_PREFIX.'company WHERE employer_id=' . $row["id"] ;
   					 $result = $db->query($sql);

   					 $smarty->assign('gdpr_msg_neg', 1);
   					 $smarty->assign('gdpr_msg', $translations['profile']['op_success']);

	            } else {
	       	          $smarty->assign('gdpr_msg_neg', 0);
	           		  $smarty->assign('gdpr_msg', $translations['admin']['no_entry_err'] . " (" . $gdpr_email . ")");     	
	            }

				break;

			case '3':
				// remove subscriber
				$sql = 'SELECT id FROM '.DB_PREFIX.'subscriptions WHERE email="' . $gdpr_email.'"';
			
	            $result = $db->query($sql);
	            $row = $result->fetch_assoc();

	            if ($result->num_rows > 0) {

					 $sql = 'DELETE FROM '.DB_PREFIX.'subscriptions WHERE id=' . $row["id"];
					 $result = $db->query($sql);

					 $sql = 'DELETE FROM '.DB_PREFIX.'subscribers WHERE email="' . $gdpr_email . '"';
   					 $result = $db->query($sql);

   					 $smarty->assign('gdpr_msg_neg', 1);
   					 $smarty->assign('gdpr_msg', $translations['profile']['op_success']);

	            } else {
	       	          $smarty->assign('gdpr_msg_neg', 0);
	           		  $smarty->assign('gdpr_msg', $translations['admin']['no_entry_err'] . " (" . $gdpr_email . ")");     	
	            }

				break;
			
			default:
				break;
		}
		// success message
}

if ($captcha_enabled) {
	
	for( $i = 1; $i <= 6 ; $i++ )
	{
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


$gdpr_users = array('1' => 'Candidate', '2' => 'Employer', '3' => 'Subscriber');
$smarty->assign('gdpr_users', $gdpr_users);

$template = 'auth/gdpr.tpl';

?>