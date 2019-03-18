<?php


	/**
	*  Simplejobscript Copyright (©) 2019 Niteosoft s.r.o. (ltd)
	*
	*  @author     Niteosoft s.r.o. (ltd)
	*  @license    MIT
	*  @website    simplejobscript.com
	*
	*  There are no license limitations, modifications nor restrictions placed upon 
	*  and no rights have been transfered to all third-party software parts of this product. You are granted to use these libraries
	*  and sub-parts while following their individual license specifications and terms of service
	*
	*/

	require_once '../_config/config.php';
	require_once '../_lib/class.Types.php';
	
	$smarty->assign('SJS_VERSION', SIMPLEJOBSCRIPT_VERSION);
	$smarty->assign('SJS_PRODUCT', SIMPLEJOBSCRIPT_PRODUCT);
	
	$DIR_CONST = '';
	if (defined('__DIR__'))
		$DIR_CONST = __DIR__;
	else
		$DIR_CONST = dirname(__FILE__);

	$currentDirectoryNames = explode('/', dirname($_SERVER['PHP_SELF']));

	define('CURRENT_DIRECTORY', end($currentDirectoryNames));
	$smarty->template_dir = APP_PATH . '/sjs-admin/_tpl';
	$smarty->compile_dir = APP_PATH . '/sjs-admin/_tpl/_cache/';
	
	$page = (isset($_app_info['params'][0]) ? $db->getConnection()->real_escape_string($_app_info['params'][0]) : '');
	$id = (isset($_app_info['params'][1]) ? $db->getConnection()->real_escape_string($_app_info['params'][1]) : 0);
	$extra = (isset($_app_info['params'][2]) ? $db->getConnection()->real_escape_string($_app_info['params'][2]) : '');
	
	//////////////////////////////////////////////////////////

	$js = array();
	if(!isset($_SERVER['HTTP_REFERER'])) {
	   $_SERVER['HTTP_REFERER'] = '';
	}

	$job = new Job();

	//register plugins
	if (in_array("Adsense", $plugins)) {
		//register adsense plugin
		define('ADSENSE', true);

		$quickSQL = 'SELECT count from adsense_count';
		$result = $db->query($quickSQL);
		$row = $result->fetch_assoc();

		define('ADSENSE_LISTING_COUNT', $row['count']); // after XY jobs there will be adsense displayed
		try {
			require_once APP_PATH . '_lib/class.Adsense.php';
		} catch (Exception $e) {
			define('ADSENSE', false);
		}
	}

	if (in_array("Banners", $plugins)) {
		//register banner manager
		define('BANNER_MANAGER', true);
		try {
			require_once APP_PATH . '_lib/class.Campaign.php';
		} catch (Exception $e) {
			define('BANNER_MANAGER', false);
		}
	}

	if (in_array("Paypal", $plugins)) {
		//register paypal
		define('PAYPAL_PLUGIN', true);
		$smarty->assign('PAYPAL_PLUGIN', 1);

		try {
			include($DIR_CONST . '/../plugins/Paypal/paypal_settings.php');
		} catch (Exception $e) {}

		$smarty->assign('PAYMENT_MODE', PAYMENT_MODE);

	}

	if (in_array("Indeed", $plugins)) {
		//register Indeed
		define('INDEED_PLUGIN', true);
		try {
			require_once APP_PATH . '_lib/class.Indeed.php';
		} catch (Exception $e) {
			define('INDEED_PLUGIN', false);
		}
	}

 	if (in_array("Profiles", $plugins)) {
 		$smarty->assign('PROFILE_PLUGIN', 1);
 	} else {
 		$smarty->assign('PROFILE_PLUGIN', 0);
 	}

 	$smarty->assign("EXPIRED_JOBS_ACTION", EXPIRED_JOBS_ACTION);

	switch($page)
	{
		// home		
		case '':
			#show login page only if the admin is not logged in
			#else show homepage
			if(!isset($_SESSION['AdminId']))
			{
				$smarty->assign('BASE_URL_ORIG', BASE_URL_ORIG);
				$smarty->assign('SITE_LOGO_PATH', SITE_LOGO_PATH);
				require_once 'page_login.php';			
			}
			else
			{				
				//$id = "inactive";
				require_once 'page_stats.php';
			}
			break;

		case 'updates':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_updates.php';
			break;

		case 'clear-cache':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_clear_cache.php';
			break;
		case 'customizer':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_customizer.php';
			break;

		case 'customize-colors':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_customizer_colors.php';
			break;

		case 'customize-homepage':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_customizer_homepage.php';
			break;
		case 'customize-jobs':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_customizer_jobs.php';
			break;

		case 'customize-css':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_customizer_css.php';
			break;

		case 'cleaner':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_cleaner.php';
			break;
		case 'feeder':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_feeder.php';
			break;
		case 'feeder-settings':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_feeder_settings.php';
			break;
		case 'news':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_news.php';
			break;

		case 'subscribers-csv':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_csv.php';
			break;

		case 'companies':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_companies.php';
			break;
		case 'candidates':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_candidates.php';
			break;
		case 'candidate':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_candidate.php';
			break;

		case 'company':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_company.php';
			break;

		case 'advertisement':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_advertisement.php';
			break;

		case 'indeed':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_admin_indeed.php';
			break;

		case 'payment-settings':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_payment_settings.php';
			break;

		case 'adsense':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_adsense.php';
			break;

		case 'subscribers':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_subscribers.php';
			break;

		case 'login-as':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_login_as.php';
			break;

		case 'login-as-candidate':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_login_as_candidate.php';
			break;

		case 'logout':
			if (isset($_SESSION['AdminId']))
			{			
				unset($_SESSION['AdminId']);
				redirect_to(BASE_URL);
				exit;
			}
			break;
			
		case 'home':
			#show login page only if the admin is not logged in
			#else show homepage
			if(!isset($_SESSION['AdminId']))
			{
				require_once 'page_login.php';			
			}
			else
			{				
				//$id = "inactive";
				require_once 'page_stats.php';
			}
			break;

		case 'job-applications':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_applicants.php';
			break;

		case 'translations':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_translations.php';
			break;
		case 'seo':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_seo.php';
			break;

		case 'activate':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_activate.php';
			break;

		case 'deactivate':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_deactivate.php';
			break;


		case 'cvdb-deactivate':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_cvdb_deactivate.php';
			break;

		case 'cvdb-activate':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_cvdb_activate.php';
			break;

		case 'delete':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_delete.php';
			break;

		case URL_JOB:
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}		
			require_once 'page_job.php';
			break;

		case URL_JOBS:
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_category.php';
			break;

		case 'stats':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_stats.php';
			break;

		case 'pages':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_pages.php';
			break;
		case 'categories':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_categories.php';
			break;
		case 'types':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_types.php';
			break;
		case 'password':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_password.php';
			$html_title = 'Change password / ' . SITE_NAME;
			$template = 'password.tpl';
			break;

		case 'settings':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_settings.php';
			break;
		case 'post-edited':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_post_edited.php';
			break;
		case 'edit-post':
			if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
			require_once 'page_edit_post.php';
			break;
		case 'activate-spotlight':
            require_once 'page_activate_spotlight.php';
            break;
   		case 'deactivate-spotlight':
            require_once 'page_deactivate_spotlight.php';
            break;
   		case 'cities':
            if(!isset($_SESSION['AdminId']))
			{
				redirect_to(BASE_URL);
			}
   			require_once 'page_cities.php';
   			$citiesPage = new CitiesPage();
   			$template = $citiesPage->processRequest($id, $extra, $smarty);
   			break;
		default:
			header("HTTP/1.1 404 Not Found");
			$html_title = 'Page unavailable / ' . SITE_NAME;
			$template = 'error.tpl';
			break;
	}

	// list of available languages
	$smarty->assign('languages', $translator->getLanguages());

	// translations
	$smarty->assign('translations', $translations);
	// create a JSON string from the translations array, but only for the "js" section
	$smarty->assign('translationsJson', iniSectionsToJSON(array('js' => $translations['js'])));
	
	// get job categories and cities
	$smarty->assign('categories', get_categories());
	$smarty->assign('settings_categories', $sjs_settings->GetSettingsCategories());

	// get menus
	$smarty->assign('EMAIL_CONFIRMATION_FLAG', EMAIL_CONFIRMATION_FLAG);

	//Add the dynamic URL defitions to SMARTY
	$smarty->assign('URL_JOB', URL_JOB);
	$smarty->assign('URL_JOBS', URL_JOBS);
	$smarty->assign('URL_COMPANIES', URL_COMPANIES);
	$smarty->assign('URL_JOBS_IN_CITY', URL_JOBS_IN_CITY);
	$smarty->assign('URL_JOBS_AT_COMPANY', URL_JOBS_AT_COMPANY);
	$smarty->assign('SITE_NAME', SITE_NAME);
	
	$smarty->assign('THEME', $settings['theme']);
	$smarty->assign('CURRENT_PAGE', $page);
	$smarty->assign('CURRENT_ID', $id);
	$smarty->assign('CURRENT_DIRECTORY', CURRENT_DIRECTORY);
	$smarty->assign('BASE_URL', BASE_URL_ORIG);
	$smarty->assign('BASE_URL_ADMIN', BASE_URL);
	$smarty->assign('MAIN_URL', MAIN_URL);

	$smarty->assign('HTTP_REFERER', $_SERVER['HTTP_REFERER']);
	if(isset($_SESSION['AdminId']))
		$smarty->assign('isAuthenticated', 1);
	else
		$smarty->assign('isAuthenticated', 0);
	$smarty->assign('js', $js);
	$smarty->error_reporting = E_ALL & ~E_NOTICE;

	if (isset($template) && $template != '')
		$smarty->display($template);
?>
