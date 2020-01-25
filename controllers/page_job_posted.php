<?php 

$DIR_CONST = '';
if (defined('__DIR__'))
	$DIR_CONST = __DIR__;
else
	$DIR_CONST = dirname(__FILE__);

if (isset($_POST))
	escape($_POST);

//add creation
if ($step == "1") {

	$HOW_TO_APPLY = $db->getConnection()->real_escape_string($_POST['howtoapply']);

	if (strpos($HOW_TO_APPLY, "http://") !== false)
		$HOW_TO_APPLY = substr($HOW_TO_APPLY, 7, strlen($HOW_TO_APPLY) - 1);
	else if (strpos($HOW_TO_APPLY, "https://") !== false)
		$HOW_TO_APPLY = substr($HOW_TO_APPLY, 8, strlen($HOW_TO_APPLY) - 1);
	else if (strpos($HOW_TO_APPLY, "www.") !== false)
		$HOW_TO_APPLY = substr($HOW_TO_APPLY, 4, strlen($HOW_TO_APPLY) - 1);

	$job = new Job();
	$class = new Company();
	$em = new Employer();

	$companyData = $class->getCompanyByEmployerId($employer_id);

	if (REMOTE_PORTAL == 'deactivated')
		$city_id = intval($location_select);
	else
		$city_id = 1;

	$apply_online = (isset($apply_online_switch)) ? 1 : 0;

	if (PAYMENT_MODE == '2')
		$spotlight = intval($premium_select);
	else
		$spotlight = 0;

	$data = array(
		"type_id" => intval($type_select),
		"employer_id" => intval($employer_id),
		"category_id" => intval($cat_select),
		"title" => $db->getConnection()->real_escape_string($title),
		"spotlight" => $spotlight,
		"salary" => $db->getConnection()->real_escape_string($salary),
		"description" => $db->getConnection()->real_escape_string($_POST['description']), //keed the tinymce characters. replaceTinyMceBreaks(
		"is_active" => JOB_POSTED_IS_ACTIVE,
		"city_id" => $city_id,
		"apply_online" => $apply_online,
		"apply_desc" => $HOW_TO_APPLY,
		"company" => $db->getConnection()->real_escape_string($companyData["name"]),
		"job_period" => $job_period,
		"is_tmp" => "1"
	);

	$result = $job->Create($data);
	redirect_to(BASE_URL . URL_DASHBOARD .'/' . URL_DASHBOARD_POST . '/2');

} else if ($step == "2") {
	$em = new Employer();
	$class = new Company();
	$job = new Job();
	//// ######### PAID PUBLISHING #########
	if (isset($_POST['price'])) {
		if (defined('PAYPAL_PLUGIN')) {
			try {
				include($DIR_CONST . '../../plugins/Paypal/paypal_snippet.php');
			} catch (Exception $e) {}
		}
	}
	//// ######### FREE PUBLISHING #########
	if (isset($pblish)) {
		$result = $job->publishTheJOb($job_id);
		clear_main_cache();
	}
	else if (isset($goback)) {
		 $_SESSION['JOB_EDITED_ID'] = $job_id;
		 redirect_to(BASE_URL . URL_DASHBOARD . '/' . URL_DASHBOARD_POST . '/draft');
	}
	// ######### FINAL STEP FOR FREE FLOW #########
	if ($result){

		$mailer = new Mailer();
		$j = new Job($job_id);

		if (JOB_POSTED_IS_ACTIVE == "0")
			$mailer->jobModerationAlert($j->GetInfo(), ADMIN_EMAIL);

		//substract job count from the account of this employer - future functionality planed

		if (PAYMENT_MODE == '3') {
			$em->substractJobCount($employer_id);
		}

		unset($_SESSION['TMP_JOB_ID']);
		$_SESSION['TMP_JOB_ID'] = null;
		$_SESSION['STEP_3_VALID'] = 1;
		redirect_to(BASE_URL . URL_DASHBOARD . '/' . URL_DASHBOARD_POST . '/3');
	}
	else {
		if (defined('PAYPAL_PLUGIN')) {
			$smarty->assign('msg', 'Paypal plugin missing or misconfigured. Include it and set correct settings. If you continue having problems, contact our support team.');
		} else {
			$smarty->assign('msg', $translations['dashboard_recruiter']['general_err']);
		}

	 	$smarty->assign('view', 'error.tpl');
		$template = URL_DASHBOARD . '/dashboard.tpl';
	}
	
} else {
	redirect_to(BASE_URL . URL_DASHBOARD . '/' . URL_DASHBOARD_POST);
}

?>
