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
	
	/**
	 * MAIN CONFIGURATION FILE
	 */

	define('APP_PATH', dirname(dirname(__FILE__)).'/');

	// Environments setup
	require_once APP_PATH . '_config/config.envs.php';
	require_once APP_PATH . '_config/version.php';
	require_once APP_PATH . '_config/constants.php';

	if (defined('CRON_JOB')) {
		define('PROTOCOL_URL', $__instance['protocol'] . $__instance['prefix'] . $append);
	} else {
		define('PROTOCOL_URL', PROTOCOL . MAIN_URL);
	}

	if(isset($_SERVER['SCRIPT_NAME'])) 
	{
		// on Windows _APP_MAIN_DIR becomes \ and abs url would look something like HTTP_HOST\/restOfUrl, so \ should be trimed too
		// @modified Chis Florinel <chis.florinel@candoo.ro>
		$app_main_dir = rtrim(dirname($_SERVER['SCRIPT_NAME']),'/\\');	
		define('_APP_MAIN_DIR', $app_main_dir);
  	} 
	else 
	{
		die('[config.php] Cannot determine APP_MAIN_DIR, please set manual and comment this line');
  	}
	
	// Function and classes includes
	require_once APP_PATH . '_lib/class.Updater.php';
	require_once APP_PATH . '_lib/class.Installer.php';
	require_once APP_PATH . '_lib/class.Translator.php';
	require_once APP_PATH . '_lib/function.redirect_to.php';
	require_once APP_PATH . '_lib/function.escape.php';
	require_once APP_PATH . '_lib/functions.php';
	require_once APP_PATH . '_lib/recaptchalib.php';
	require_once APP_PATH . '_lib/CacheLite/Lite.php';
	require_once APP_PATH . '_lib/class.Cache.php';
	require_once APP_PATH . '_lib/class.Sanitizer.php';
	require_once APP_PATH . '_lib/class.Subscriber.php';
	require_once APP_PATH . '_lib/class.Db.php';
	// comment the previous line and uncomment the next line if you get a Class 'mysqli' not found error
	// require_once APP_PATH . '_lib/class.Db.MySql.php';
	require_once APP_PATH . '_lib/class.Job.php';
	require_once APP_PATH . '_lib/class.Paginator.php';
	require_once APP_PATH . '_lib/class.PaginatorAdmin.php';
	require_once APP_PATH . '_lib/class.Feed.php';
	require_once APP_PATH . '_lib/class.SpamReport.php';
	// API can be used, just test it for your purpose
	//require_once APP_PATH . '_lib/class.Api.php';
	require_once APP_PATH . '_lib/class.Maintenance.php';
	require_once APP_PATH . '_lib/class.JobApplication.php';
	require_once APP_PATH . '_lib/class.SearchKeywords.php';
	require_once APP_PATH . '_lib/class.SimpleJobscriptSettings.php';
	require_once APP_PATH . '_lib/class.SeoSettings.php';
	require_once APP_PATH . '_lib/class.PaymentSettings.php';
	require_once APP_PATH . '_lib/class.FormValidator.php';
	require_once APP_PATH . '_lib/smarty/libs/Smarty.class.php';
	require_once APP_PATH . '_lib/class.Company.php';
	require_once APP_PATH . '_lib/class.Mailer.php';
	require_once APP_PATH . '_lib/class.Employer.php';
	require_once APP_PATH . '_lib/class.Applicant.php';
	require_once APP_PATH . '_lib/class.HashTables.php';
	require_once APP_PATH . '_lib/ImageManipulator.php';
	require_once APP_PATH . '_lib/Newsletter.php';
	require_once APP_PATH . '_lib/external/swiftmailer/lib/swift_required.php';
	require_once APP_PATH . '_lib/external/captcha/simple-php-captcha.php';

	// Setup database connection
	try 
	{
		$db =  Db::getInstance(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
		$db->Execute('SET NAMES UTF8');
	}
	catch(ConnectException $exception) 
	{
		if (ENVIRONMENT == 'dev')
		{
			echo "Database Connection Error:<br />";
			print_r($exception->getMessage());	
		}
	}

	// Setup cache
    define('USE_CACHE', true);
    define('CACHE_SITE_SETTINGS', 'SITE_SETTINGS');
    define('CACHE_SEO_SETTINGS', 'SEO_SETTINGS');
    define('PAYMENT_SETTINGS', 'PAYMENT_SETTINGS');
    define('CACHE_CATEGORIES', 'CATEGORIES');
    define('CACHE_NAVIGATION', 'NAVIGATION');
    define('CACHE_TYPES', 'TYPES');
    define('CACHE_JOBS', 'JOBS');
    define('CACHE_TRANSLATIONS', 'CACHE_TRANSLATIONS');
    define('CACHE_IL', 'CACHE_IL');

    $cache = new Cache(APP_PATH . '_cache/', null, USE_CACHE);

     // customizer web color
     $cpColor = '';

     if ($cache->testCache('cp_color')) 
     {
         $cpColor = $cache->loadCache('cp_color');
     } 
     else 
     {
		$sql = 'SELECT website_color FROM customizer WHERE id = 1';
		$r = $db->query($sql);
		$arr = $r->fetch_assoc();
		$cpColor = $arr['website_color'];

       	$cache->saveCache($cpColor, 'cp_color');
     }	

     // CUSTOMIZER CSS settings
     $logo_settings = array();
     if ($cache->testCache('logo_settings')) 
     {
         $logo_settings = $cache->loadCache('logo_settings');
     } 
     else 
     {
		$sql = 'SELECT jobs_logo_width, jobs_logo_width_mobile, jobs_logo_padding, jobs_candidates_on_flag, jobs_subheader_bg_path, custom_css FROM customizer';
		$r = $db->query($sql);
		$logo_settings = $r->fetch_assoc();

       	$cache->saveCache($logo_settings, 'logo_settings');
     }	

     $links_settings = array();

     if ($cache->testCache('link_settings')) 
     {
         $links_settings = $cache->loadCache('link_settings');
     } 
     else 
     {
		$sql = 'SELECT url FROM pages WHERE id = 53';
		$r = $db->query($sql);
		$res = $r->fetch_assoc();
		$links_settings["about_url"] = $res['url'];

		$sql = 'SELECT url FROM pages WHERE id = 14';
		$r = $db->query($sql);
		$res = $r->fetch_assoc();
		$links_settings["tcs_url"] = $res['url'];

       	$cache->saveCache($links_settings, 'link_settings');
     }
 
     define('ABOUT_URL', $links_settings["about_url"]);
     define('TERMS_CONDITIONS_URL', $links_settings["tcs_url"]);

	 // Setup settings
     $sjs_settings = new SimpleJobscriptSettings();

     if ($cache->testCache(CACHE_SITE_SETTINGS)) 
     {
         $settings = $cache->loadCache(CACHE_SITE_SETTINGS);
     } 
     else 
     {
        $settings = $sjs_settings->GetSettings();
        if ($settings['cache_activated'] == 'activated')
       	 $cache->saveCache($settings, CACHE_SITE_SETTINGS);
     }	

     //SEO manager
     $seo_settings = new SeoSettings();
     if ($cache->testCache(CACHE_SEO_SETTINGS)) 
     {
         $seoSettings = $cache->loadCache(CACHE_SEO_SETTINGS);
     } 
     else 
     {
        $seoSettings = $seo_settings->GetSettings();
        if ($settings['cache_activated'] == 'activated')
       	 $cache->saveCache($seoSettings, CACHE_SEO_SETTINGS);
     }

     // payment settings
     $payment_settings = new PaymentSettings();

     if ($cache->testCache(PAYMENT_SETTINGS)) 
     {
         $paymentSettings = $cache->loadCache(PAYMENT_SETTINGS);
     } 
     else 
     {
         $paymentSettings = $payment_settings->GetSettings();
        if ($settings['cache_activated'] == 'activated')
       	 $cache->saveCache($paymentSettings, PAYMENT_SETTINGS);
     }

	// Setup translations
	$translator = new Translator(LANG_CODE);
	//$translations = $translator->getTranslations();
	
     if ($cache->testCache(CACHE_TRANSLATIONS . '_' . LANG_CODE))
     {
         $translations = $cache->loadCache(CACHE_TRANSLATIONS . '_' . LANG_CODE);
     }
     else
     {
        $translations = $translator->getTranslations();
        if ($settings['cache_activated'] == 'activated')
       	 $cache->saveCache($translations, CACHE_TRANSLATIONS . '_' . LANG_CODE);
     }

    require_once APP_PATH . '_config/config.settings.php';

    // URL to path mapping
    $DASHBOARD_ROUTING = array(
    	URL_DASHBOARD_OVERVIEW => 'overview.tpl',
    	URL_DASHBOARD_EDIT_COMPANY => 'edit-company.tpl',
    	URL_DASHBOARD_SETTINGS => 'settings.tpl',
    	URL_DASHBOARD_DEACTIVATE_ACCOUNT => 'deactivate.tpl',
    	URL_DASHBOARD_CVDATABASE => 'cvdatabase.tpl',
    	URL_DASHBOARD_POST => 'post.tpl',
    	URL_DASHBOARD_DELETE_JOB => 'delete-job.tpl',
    	URL_DASHBOARD_EDIT_JOB => 'edit-job.tpl',
    	URL_DASHBOARD_JOBS => 'jobs.tpl',
    	URL_DASHBOARD_STATISTICS => 'statistics.tpl',
    	URL_DASHBOARD_APPLICATIONS => 'applications.tpl',
    	URL_DASHBOARD_INVOICES => 'invoices.tpl',
    	URL_DASHBOARD_ACCOUNT => 'account.tpl',
    	URL_DASHBOARD_ACCOUNT_ORDER => 'account-order.tpl'
    );

    $PROFILE_ROUTING = array(
    	URL_PROFILE_EDIT => 'edit',
    	URL_PROFILE_APPLICATIONS => 'applications',
    	URL_PROFILE_CHANGEPASSWORD => 'changepass',
    	URL_PROFILE_DELETE => 'delete'
    );

    // count VAT koeficient
    if (intval(VAT) == 0) {
    	$vat = 0;
    } else {
    	$vat = floatval(intval(VAT)/100);
    }

    define('VAT_KOEFICIENT', $vat);

	// Setup Smarty
	$smarty = new Smarty();
	$smarty->template_dir = APP_PATH . '_tpl' . DIRECTORY_SEPARATOR . THEME . DIRECTORY_SEPARATOR;
	$smarty->compile_dir = APP_PATH .'_tpl' . DIRECTORY_SEPARATOR . THEME . DIRECTORY_SEPARATOR . '_cache';

	if (ENVIRONMENT == 'dev') {
		$smarty->caching = 0;
		$smarty->force_compile = true;
	}

	// Split URL - get parameters
	$_app_info['params'] = array();
	
	if (isset($_SERVER['HTTP_X_ORIGINAL_URL']))
	{
		$_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_ORIGINAL_URL'];
	}
	if (isset($_SERVER['HTTP_X_REWRITE_URL']))
	{
		$_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_REWRITE_URL'];
	}		

	//if server is Apache / Nginx	
	if(REWRITE_MODE == 'apache_mod_rewrite' || REWRITE_MODE == 'iis_isapi_rewrite')
	{
		$newUrl = str_replace('/', '\/', _APP_MAIN_DIR);
	    $pattern = '/'.$newUrl.'/';   
	    $_url = preg_replace($pattern, '', $_SERVER['REQUEST_URI'], 1);
		$_tmp = explode('?', $_url);
		$_url = $_tmp[0];	

		if ($_url = explode('/', $_url))
		{
			foreach ($_url as $tag)
			{
				if ($tag)
				{
					$_app_info['params'][] = $tag;
				}
			}
		}
	}
	// iis
	elseif(REWRITE_MODE == 'iis_url_rewrite')
	{
		if(isset($_GET['page']))
			$_app_info['params'][]  = $_GET['page'];
		if(isset($_GET['id']))
			$_app_info['params'][]  = $_GET['id'];
		if(isset($_GET['extra']))
			$_app_info['params'][]  = $_GET['extra'];
	}

	 // get logo invoice dimensions
  	 $il_dimensions = array();

     if ($cache->testCache(CACHE_IL)) 
     {
         $il_dimensions = $cache->loadCache(CACHE_IL);
     } 
     else 
     {
        // get logo dimensions
		try {
			$is = getimagesize(PROTOCOL . MAIN_URL . INVOICE_LOGO_PATH);
			$IL_W = $is[0];
			$IL_H = $is[1];

			$ext = end(explode("/", $is['mime']));

			if ($ext == "png" || $ext == "PNG") {
				$logo_ext = 'PNG';
			} else {
				$logo_ext = 'JPG';
			}

			$IL_EXT = $logo_ext;

		} catch (Exception $e) {
			$IL_W = 250;
	 		$IL_H = 100;

			// get logo extension
			$ext = end(explode(".", INVOICE_LOGO_PATH));

			if ($ext == "png" || $ext == "PNG") {
				$logo_ext = 'PNG';
			} else {
				$logo_ext = 'JPG';
			}
			
			$IL_EXT = $logo_ext;
		}

		$il_dimensions = array('il_w' => $IL_W, 'il_h' => $IL_H, 'il_ext' => $IL_EXT);

        if ($settings['cache_activated'] == 'activated')
       	  $cache->saveCache($il_dimensions, CACHE_IL);
     }

	define('INVOICE_LOGO_W', $il_dimensions['il_w']);
	define('INVOICE_LOGO_H', $il_dimensions['il_h']);
	define('INVOICE_LOGO_EXT', $il_dimensions['il_ext']);

	$page = (isset($_app_info['params'][0]) ? $db->getConnection()->real_escape_string($_app_info['params'][0]) : '');
	$id = (isset($_app_info['params'][1]) ? $db->getConnection()->real_escape_string($_app_info['params'][1]) : 0);
	$extra = (isset($_app_info['params'][2]) ? $db->getConnection()->real_escape_string($_app_info['params'][2]) : '');
	$last = (isset($_app_info['params'][3]) ? $db->getConnection()->real_escape_string($_app_info['params'][3]) : '');

	date_default_timezone_set(TIMEZONE);
	header('Content-Type: text/html; charset=UTF-8');
	session_start();

	if (count($_SESSION['favourites']) < 1) {
 		$_SESSION['favourites'] = array();
 	}

 	$smarty->assign("VAT_KOEFICIENT", $vat);
 	$smarty->assign('SJS_VERSION', SIMPLEJOBSCRIPT_VERSION);
	$smarty->assign('SJS_PRODUCT', SIMPLEJOBSCRIPT_PRODUCT);

	// DATE strings translation
	define('DATE_STR_YEAR', $translations['date']['year']);
	define('DATE_STR_YEARS', $translations['date']['years']);
	define('DATE_STR_MONTH', $translations['date']['month']);
	define('DATE_STR_MONTHS', $translations['date']['months']);
	define('DATE_STR_DAY', $translations['date']['day']);
	define('DATE_STR_DAYS', $translations['date']['days']);
	define('DATE_STR_HOUR', $translations['date']['hour']);
	define('DATE_STR_HOURS', $translations['date']['hours']);
	define('DATE_STR_MINUTE', $translations['date']['minute']);
	define('DATE_STR_MINUTES', $translations['date']['minutes']);
	define('DATE_STR_SECOND', $translations['date']['second']);
	define('DATE_STR_SECONDS', $translations['date']['seconds']);
	define('DATE_STR_ZERO_SECONDS', $translations['date']['zero_seconds']);
	define('DATE_STR_AGO', $translations['date']['ago']);

	// general translations needed
	define('GENERAL_AT', $translations['website_general']['at']);
	define('RSS_JOBS_TITLE', $translations['alljobs']['all_jobs']);
	define('RSS_APPLY', $translations['apply']['apply_btn']);

	define('REVIEW_LABEL', $translations['profile']['review_label']);

	$smarty->assign("CONTACT_FORM_HEADLINE", $translations['login']['contact_us']);
	$smarty->assign("EXPIRED_JOBS_ACTION", EXPIRED_JOBS_ACTION);

	// these constants needs settings to be initiated
	define('NUMBER_OF_LATEST_JOBS_TO_GET', $settings['latest_jobs']);

	// push settings from constants.php into Smarty
	$smarty->assign('EMAIL_CONFIRMATION_FLAG', EMAIL_CONFIRMATION_FLAG);
	$smarty->assign('MAX_CV_SIZE', MAX_CV_SIZE);
	$smarty->assign('MAX_LOCATIONS_IMPORT_FILE_SIZE', MAX_LOCATIONS_IMPORT_FILE_SIZE);

	$smarty->assign('GDPR_ENABLED', GDPR_ENABLED);

?>