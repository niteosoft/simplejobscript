<?php 

	$class = new Employer();
	$smarty->assign('project_name', SITE_NAME);
	if (isset($_POST['forget_pass2'])) {
		escape($_POST);
		$newPass = md5($forget_pass2);
		$result = $class->updatePasswordFromBackoffice($employer_id, $newPass);
		if ($result) {
			$smarty->assign('msg', $translations['dashboard_recruiter']['change_password_success']);
			$smarty->assign('view', 'success.tpl');
		} else {
			$smarty->assign('msg', $translations['dashboard_recruiter']['change_password_fail']);
			$smarty->assign('view', 'error.tpl');
		}

		$smarty->assign('JS_ID', 'settings-li');
		$template = URL_DASHBOARD . '/dashboard.tpl';
	} else if (isset($_POST['name'])) {
		escape($_POST);

		$result = $class->updateName($employer_id, $name);
		if ($result) {
			unset($_SESSION['name']);
			$_SESSION['name'] = $name;
			$smarty->assign('msg', $translations['dashboard_recruiter']['change_name_success']);
			$smarty->assign('view', 'success.tpl');
		} else {
			$smarty->assign('msg', $translations['dashboard_recruiter']['change_name_fail']);
			$smarty->assign('view', 'error.tpl');
		}
		$smarty->assign('JS_ID', 'settings-li');
		$template = 'dashboard/dashboard.tpl';
	}
?>