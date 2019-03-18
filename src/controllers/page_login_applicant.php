<?php

	$smarty->assign('PLAIN_SITE', true);

	if (isset($_POST['signin_email']) && isset($_POST['signin_pass'])) {
		$class = new Applicant();
		$email = $db->getConnection()->real_escape_string(trim($_POST['signin_email']));
		$password = md5(trim($_POST['signin_pass']));

		if ($class->authenticate($email, $password)) {
			//set session
			$applicant = $class->getData();
			$_SESSION['applicant'] = $applicant['id'];
			$_SESSION['applicant_name'] = $applicant['fullname'];

			//log in
			redirect_to(BASE_URL . URL_PROFILE);
		} else {
			$smarty->assign('login_failed', 1);
			$smarty->assign('relogin_email', $email);
			$template = 'auth/login-applicants.tpl';
		}
	} else {
		redirect_to(BASE_URL . URL_LOGIN_APPLICANTS);
	}
	
?>