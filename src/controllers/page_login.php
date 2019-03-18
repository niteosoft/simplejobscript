<?php

	if (isset($_POST['signin_email']) && isset($_POST['signin_pass'])) {
		$class = new Employer();
		$email = $db->getConnection()->real_escape_string(trim($_POST['signin_email']));
		$password = md5(trim($_POST['signin_pass']));

		if ($class->authenticate($email, $password)) {
			//set session
			$_SESSION['user'] = $class->getId();
			$_SESSION['name'] = $class->getName();
			//log in
			redirect_to(BASE_URL . URL_DASHBOARD);
		} else {
			$smarty->assign('login_failed', 1);
			$smarty->assign('relogin_email', $email);
			$template = 'auth/login-recruiters.tpl';
		}
	} else {
		redirect_to(BASE_URL . URL_LOGIN_RECRUITERS);
	}
	
?>
