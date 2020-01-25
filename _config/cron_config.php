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
	 *  CONFIGURATION FILE USED BY CRONJOBS
	 */
	define('APP_PATH', dirname(dirname(__FILE__)).'/');
	define('CRON_JOB', 1);
	require_once APP_PATH . '_config/config.envs.php';
	require_once APP_PATH . '_config/version.php';
	require_once APP_PATH . '_config/constants.php';

	if(isset($_SERVER['SCRIPT_NAME'])) 
	{
		// on Windows _APP_MAIN_DIR becomes \ and abs url would look something like HTTP_HOST\/restOfUrl, so \ should be trimed too
		// @modified Chis Florinel <chis.florinel@candoo.ro>
		$app_main_dir = rtrim(dirname($_SERVER['SCRIPT_NAME']),'/\\');	
		define('_APP_MAIN_DIR', $app_main_dir);
  	} 
	else 
	{
		die('[cron_config.php] Cannot determine APP_MAIN_DIR, please set manual and comment this line');
  	}

	// Function and classes includes
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
	require_once APP_PATH . '_lib/class.Feed.php';
	require_once APP_PATH . '_lib/class.SpamReport.php';
	//require_once APP_PATH . '_lib/class.Api.php';
	require_once APP_PATH . '_lib/class.Maintenance.php';
	require_once APP_PATH . '_lib/class.JobApplication.php';
	require_once APP_PATH . '_lib/class.SearchKeywords.php';
	require_once APP_PATH . '_lib/class.SimpleJobscriptSettings.php';
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

	// Setup settings
    $sjs_settings = new SimpleJobscriptSettings();
    $settings = $sjs_settings->GetSettings();

	require_once APP_PATH . '_config/config.settings.php';
	
	// Setup translations
	$translator = new Translator(LANG_CODE);
    $translations = $translator->getTranslations();

?>
