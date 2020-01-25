<?php 

	$smarty->assign('dashboard_footer_flag', 1);

	$DIR_CONST = '';
	if (defined('__DIR__'))
		$DIR_CONST = __DIR__;
	else
		$DIR_CONST = dirname(__FILE__);

	//is user confirmed?
	$class = new Employer();
	$result = $class->userIsConfirmed($_SESSION['user']);
	$smarty->assign('remote_portal', REMOTE_PORTAL);

	if (!$result) {
		if (isset($_SESSION['user']))	{
			unset($_SESSION['user']);
			unset($_SESSION['name']);
		}		
		redirect_to(BASE_URL . URL_ACCOUNT_NOT_CONFIRMED);
	} else {

		if (defined('PAYPAL_PLUGIN')) {
			try {
				include($DIR_CONST . '../../plugins/Paypal/invoice_notifications.php');
			} catch (Exception $e) {}
		}

		//check for notification
		$result = $class->checkForNotification($_SESSION['user']);
		if ($result)
			$smarty->assign('NOTIFICATION', true);
		else
			$smarty->assign('NOTIFICATION', false);

		if (isset($_SESSION['TMP_JOB_ID']) && $extra != "draft" && $extra != "2") {
			$tmpJob = new Job($_SESSION['TMP_JOB_ID']);
			$tmpJob->deleteById($_SESSION['TMP_JOB_ID']);
			unset($_SESSION['TMP_JOB_ID']);
			$_SESSION['TMP_JOB_ID'] = null;
		}

		$smarty->assign('name', $_SESSION['name']);
		$smarty->assign('ID', $_SESSION['user']);
		//here, switch dashboard page
		$smarty->assign('project_name', SITE_NAME);
		//$smarty->assign('EMAIL', $class->getEmployerEmail($_SESSION['user']));

		//does view exist?
		if (!empty($DASHBOARD_ROUTING[$id])) {
			$path = $DIR_CONST . '/../_tpl/' . $settings['theme'] . '/' . 'dashboard' . '/views/' . $DASHBOARD_ROUTING[$id];

			if (!file_exists($path)) {
				$smarty->assign('view', 'dashboard-404.tpl');
			} else {
				$smarty->assign('view', $DASHBOARD_ROUTING[$id]);   
				if ($id == URL_DASHBOARD_SETTINGS)
					$smarty->assign('JS_ID', 'settings-li');
				else if ($id == URL_DASHBOARD_EDIT_COMPANY) {
					$class = new Company();
					$data = $class->getCompanyByEmployerId($_SESSION['user']);
					if (empty($data)) {
						//registration failure. user does not have a company associate with him
						//unconfirm him and log him out
						$class->unconfirmAndLogout($_SESSION['user']);
					} else {
						$smarty->assign('company', $data);
					}
					$smarty->assign('JS_ID', 'company-li');
				}
				else if ($id == URL_DASHBOARD_DEACTIVATE_ACCOUNT) {
					$smarty->assign('JS_ID', 'account-li');

				} else if ($id == URL_DASHBOARD_INVOICES) {

					if (defined('PAYPAL_PLUGIN')) {
						try {
							include($DIR_CONST . '../../plugins/Paypal/invoices.php');
						} catch (Exception $e) {}
					}
				}
				else if ($id == URL_DASHBOARD_OVERVIEW) {
					$overview = new Employer();
					$data = $overview->getEmployerOverview($_SESSION['user']);
					$news = $overview->getNews();
					$smarty->assign('news', $news);

					$smarty->assign('overview_data', $data);
					$smarty->assign('JS_ID', 'dashboard-li');
				} else if ($id == URL_DASHBOARD_APPLICATIONS){

					$smarty->assign('applications_modal_init', '1');
					$class->notificationSeen($_SESSION['user']);

					//get jobs
					$apps_job = new Job();
					$data = $apps_job->getJobTitlesByEmployerId($_SESSION['user']);

					$empClass = new Employer();
					$job_ids = $empClass->getJobsByEmployerId($_SESSION['user']);

					if (isset($_SESSION['JOB_ID']))
						$smarty->assign('select_job_id', $_SESSION['JOB_ID']);

					$smarty->assign('APP_PAGE', 1);
					$smarty->assign('jobs_select', $data);

					//get hired candidates
					$ja = new JobApplication();
					$hired_apps = $ja->getHiredJobApplications($_SESSION['user'], $job_ids);

					if ($hired_apps[0] == NULL) {
						$smarty->assign('HIRED_APPS', false);
					} else {
						$smarty->assign('HIRED_APPS', true);
						$smarty->assign('HIRED_APPS_DATA', $hired_apps);
					}

				}
				else if ($id == URL_DASHBOARD_STATISTICS) {
					$job = new Job();
					$params = explode("-", $last);
					$views = $params[0];
					$applications = $params[1];

					if (intval($views) != 0)
						$conversion_rate = round(($applications/$views)*100, 2);
					else 
						$conversion_rate = 0;

					$smarty->assign('conversion_rate', round($conversion_rate));
					$conversion_title = str_replace("{RATE}", round($conversion_rate), $translations['statistics']['gauge_title']);
					$smarty->assign('conversion_title', $conversion_title);

					$smarty->assign('barchart_headline', $translations['statistics']['barchart_headline']);
					$smarty->assign('barchart_x_title', $translations['statistics']['barchart_x_title']);
					$smarty->assign('barchart_y_title', $translations['statistics']['barchart_y_title']);

					$smarty->assign('views', $views);
					$smarty->assign('applications', $applications);
					$smarty->assign('graph_headline', $translations['statistics']['piechart_title']);

					$stats = $job->getJobStatisticsById($extra);

					if (count($stats) < 2)
						$stats = array();

					$smarty->assign('stats', $stats);
					//prepare data for javascript
					$statsDate = array();
					foreach ($stats as $stat) {
						$exp = explode("-", $stat['date']);
						$obj = new stdClass;
						$obj->year = $exp[0];
						$obj->month = ltrim($exp[1], "0");
						$obj->day = ltrim($exp[2], "0");
						$statsDate[$stat['id']] = $obj;
					}

					//for small data do not need to strech graph to 100%
					if (count($stats) <= 3)
						$smarty->assign('firstGraphWidth', "75%");
					else
						$smarty->assign('firstGraphWidth', "100%");

					$smarty->assign('statsDate', $statsDate);
					
				}
				else if ($id == URL_DASHBOARD_JOBS) {
					$smarty->assign('init_modal_popup_jobs', '1');
					//get list of jobs
					$dash_job = new Job();
					$app = new JobApplication();

					$dash_jobs = $dash_job->getEmployerJobs($_SESSION['user']);
					$apps_array = array();

					//get job applications count
					foreach ($dash_jobs as $j) {
						$apps_array[$j['id']] = $app->getJobApplicationsCount($j['id']);
					}
					 $smarty->assign('apps_array', $apps_array);
					 $smarty->assign('dash_jobs', $dash_jobs);

				}
				else if ($id == URL_DASHBOARD_DELETE_JOB) {
					$job = new Job();
					$job->deleteById($extra);
					clear_main_cache();
					redirect_to(BASE_URL . URL_DASHBOARD . '/' . URL_DASHBOARD_JOBS);
				}
				else if ($id == URL_DASHBOARD_EDIT_JOB) {
					//does this job belongs to employer?
					$job = new Job($extra);
					$result = $job->checkOwner($_SESSION['user']);
					if (!$result)
						redirect_to("/" . URL_DASHBOARD . "/" . URL_DASHBOARD_JOBS);

					$data = $job->GetInfo();
					$smarty->assign('job', $data);
					$cats = $job->getCategoriesWithIds();
					$job_types = $job->getJobTypesWithIds();
					if (REMOTE_PORTAL == 'deactivated') {
						//get cities
						$cities = $job->getCitiesWithId();
						$smarty->assign('cities', $cities);
					}
					$smarty->assign('cats', $cats);
					$smarty->assign('types', $job_types);
				} 
				else if ($id == URL_DASHBOARD_CVDATABASE) {
				
					$smarty->assign('TAGL_RESTYLE', true);

					if (isset($extra) && intval($extra) == 2){
						$smarty->assign('view', 'cvdatabase-unlock.tpl');  
					}

					if (defined('PROFILES_PLUGIN')) {
						try {
							include($DIR_CONST . '../../plugins/Profiles/cv_database.php');
						} catch (Exception $e) {}
					}
				}
				else if ($id == URL_DASHBOARD_ACCOUNT) {

					if (PAYMENT_MODE != '3') {
						redirect_to(BASE_URL . URL_DASHBOARD . '/' . URL_DASHBOARD_OVERVIEW);
					}

					$package_data = $class->getEmployerAccount($_SESSION['user']);
					$no_resources_msg = false;

					// show out of credit msg
					if (intval($package_data['jobs_left']) < 1 && intval($package_data['cv_downloads_left']) < 1) {
							$no_resources_msg = $translations['post_step1']['out_of_credit'];
					}

					// wording
					if (intval($package_data['jobs_left']) == 0 || intval($package_data['jobs_left']) > 1) {
						$suffix = $translations['post_step1']['jobs_left'];
					} else {
						$suffix = $translations['post_step1']['job_left'];
					}

					if (intval($package_data['cv_downloads_left']) == 0 || intval($package_data['cv_downloads_left']) > 1) {
						$suf = $translations['post_step1']['cvs_left'];
					} else {
						$suf = $translations['post_step1']['cv_left'];
					}

					$smarty->assign('no_resources_msg', $no_resources_msg);

					$smarty->assign('jobs_left_msg', rtrim($suffix, "."));
					$smarty->assign('cvs_left_msg', rtrim($suf, "."));

					$smarty->assign('acc_data', $package_data);
					$smarty->assign('JS_ID', 'account-li');

				} else if ($id == URL_DASHBOARD_ACCOUNT_ORDER) {

					if (isset($extra) && $extra == URL_DASHBOARD_ACCOUNT_ORDER_COMPLETED) {
						$smarty->assign('order_completed', true);
					} else {
							$sql = 'SELECT id, name, jobs_left, job_period, cv_downloads, price FROM packages';
							$result = $db->query($sql);
							$data = array();

							while ($row = $result->fetch_assoc()) {
								$data[$row['id']] = $row['name'];
							}

							$package_data = $class->getEmployerAccount($_SESSION['user']);

							$sql = 'SELECT id, name, jobs_left, job_period, cv_downloads, price FROM packages WHERE id =' . intval($package_data['package_id']);
							$result = $db->query($sql);
							$row = $result->fetch_assoc();

							$price = intval($row['price']);

							if (VAT_KOEFICIENT != 0) {
								$smarty->assign('VAT', true);
								$price_vat_total = format_currency(WEBSITE_CURRENCY, $price + ($price * VAT_KOEFICIENT));
								$price_vat = format_currency(WEBSITE_CURRENCY, $price * VAT_KOEFICIENT);

								$smarty->assign('PRICE_VAT_TOTAL', $price_vat_total);
								$smarty->assign('PRICE_VAT', $price_vat);

							} 

							$smarty->assign('PRICE', format_currency(WEBSITE_CURRENCY, $price));

							$smarty->assign('packages', $data);
							$smarty->assign('active_mode_id', $package_data['package_id']);
							$smarty->assign('pd', $row);	
					}

					$smarty->assign('JS_ID', 'account-li');
				}
				else if ($id == URL_DASHBOARD_POST) {
						if ($extra != "" && $extra != "draft") {
							$step = intval($extra);
							if (!is_numeric($extra) || $step < 1 || $step > 3 || $extra == "0")
								redirect_to(BASE_URL . URL_DASHBOARD . '/' . URL_DASHBOARD_POST);
							else
								$step = intval($extra);
						} else {
							$step = 1;

							if ($extra == "draft") {
								$tmpJob = new Job($_SESSION['JOB_EDITED_ID']);
								$draft_data = $tmpJob->GetInfo();
								$tmpJob->deleteById($_SESSION['JOB_EDITED_ID']);
								unset($_SESSION['JOB_EDITED_ID']);
								$_SESSION['JOB_EDITED_ID'] = null;
								$smarty->assign('draft_data', $draft_data);
								$smarty->assign('DRAFT', true);
							}
						}

						$job = new Job();
						$package_data = $class->getEmployerAccount($_SESSION['user']);
						$smarty->assign('job_period', $package_data['job_period']);

						if (PAYMENT_MODE == "3") {
							$smarty->assign('jobs_left', $package_data['jobs_left']);
						}

						// ***************** STEP 1 ============================
						if ($step == 1) {
							//show user how many jobs he has left and when does the job expire
							$cats = $job->getCategoriesWithIds();
							$job_types = $job->getJobTypesWithIds();

							if (PAYMENT_MODE == "3") {

								if (intval($package_data['jobs_left']) < 1) {
									$msg = $translations['post_step1']['nojobs_left_msg'];
									$smarty->assign('lock_post', true);
								}
								else {

									if (intval($package_data['jobs_left']) == 0 || intval($package_data['jobs_left']) > 1) {
										$suffix = $translations['post_step1']['jobs_left'];
									} else {
										$suffix = $translations['post_step1']['job_left'];
									}

									$msg = $translations['post_step1']['account_plan'] . " " . $package_data['jobs_left'] . " " . $suffix;
								}	
								$smarty->assign('msg', $msg);
							}

							if (REMOTE_PORTAL == 'deactivated') {
								//get cities
								$cities = $job->getCitiesWithId();
								$smarty->assign('cities', $cities);
							}

							$smarty->assign('cats', $cats);
							$smarty->assign('types', $job_types);
							//does this user have any tmp jobs? if yes he clicked back

						} else if ($step == 2) {
							$smarty->assign('init_modal_popup_preview', '1');
							// ***************** STEP 2 ============================
							$job_data = $job->getTmpJobInfoByEmployerId($_SESSION['user']);

							$_SESSION['TMP_JOB_ID'] = $job_data["id"];

							$package_data = $class->getEmployerAccount($_SESSION['user']);

							if (intval($package_data['jobs_left']) == 0 || intval($package_data['jobs_left']) > 1) {
								$suffix = $translations['post_step1']['jobs_left'];
							} else {
								$suffix = $translations['post_step1']['job_left'];
							}

							$smarty->assign('jobs_left_msg', $package_data['jobs_left'] . " " . rtrim($suffix, "."));

							if (PAYMENT_MODE == '2'){

								if (intval($job_data["spotlight"]) == 1){
									$price = intval(PREMIUM_LISTING_PRICE) + intval(JOB_POSTED_PRICE);
									$smarty->assign('SPOTLIGHT', true);
								}
								else
									$price = intval(JOB_POSTED_PRICE);

								if (VAT_KOEFICIENT != 0) {
									$smarty->assign('VAT', true);
									$price_vat_total = format_currency(WEBSITE_CURRENCY, $price + ($price * VAT_KOEFICIENT));
									$price_vat = format_currency(WEBSITE_CURRENCY, $price * VAT_KOEFICIENT);

									$smarty->assign('PRICE_VAT_TOTAL', $price_vat_total);
									$smarty->assign('PRICE_VAT', $price_vat);

								} 

								$smarty->assign('PRICE', format_currency(WEBSITE_CURRENCY, $price));
								if ($price > 0)
									$smarty->assign('PAY', true);
								else
									$smarty->assign('PAY', false);
							}
							else {
								$smarty->assign('PAY', false);
							}

							if (!$job_data)
								redirect_to(BASE_URL . URL_DASHBOARD . '/' . URL_DASHBOARD_POST);

							$smarty->assign('job_data', $job_data);
						} else if ($step == 3) {

							if (isset($_SESSION['STEP_3_VALID'])) {
								unset($_SESSION['STEP_3_VALID']); $_SESSION['STEP_3_VALID'] = null;
								if (JOB_POSTED_IS_ACTIVE == "0")
									$smarty->assign('published_msg', $translations['dashboard_recruiter']['published_wait_aproval']);
								else
									$smarty->assign('published_msg', $translations['dashboard_recruiter']['published_online']);	

								if (isset( $_SESSION['PAYPAL_RESULT_MESSAGE'])) {
									$smarty->assign('paypal_result_message', $_SESSION['PAYPAL_RESULT_MESSAGE']);
									unset($_SESSION['PAYPAL_RESULT_MESSAGE']); $_SESSION['PAYPAL_RESULT_MESSAGE'] = null;
								}

							} else {
								redirect_to(BASE_URL . URL_DASHBOARD . '/' . URL_DASHBOARD_POST);
							}
						}

						$smarty->assign('step', $step);
						$smarty->assign('employer_id', $_SESSION['user']);
				}
			}
		 } else {

				if (($DASHBOARD_ROUTING[$id] == NULL || $DASHBOARD_ROUTING[$id] == "NULL") && $id != 0){
					$smarty->assign('view', 'dashboard-404.tpl');
				} else {
					$overview = new Employer();
					$data = $overview->getEmployerOverview($_SESSION['user']);
					$news = $overview->getNews();
					$smarty->assign('news', $news);
					$smarty->assign('overview_data', $data);

			 		$smarty->assign('view', 'overview.tpl');
			 		$smarty->assign('JS_ID', 'dashboard-li');
				}

		 }
		$template = 'dashboard/dashboard.tpl';
	}

	
?>
