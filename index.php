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

	// Main config
	if(!file_exists('_config/config.php')) 
	{
	   die('[index.php] _config/config.php not found');
	}
	
	require_once '_config/config.php';
	
	// color customizer

	$res = hex2rgb($cpColor);
	// used for hovering. Making the color more bright by shifting the values a bit
	$color_rgba = '(' . intval(intval($res["red"]) - 51) . ',' . intval(intval($res["green"]) - 25) . ',' . $res["blue"] . ', 1' . ')';

	define('CUSTOMIZER_COLOR', $cpColor);
	define('CUSTOMIZER_COLOR_RGBA', $color_rgba);

	$DIR_CONST = '';
	if (defined('__DIR__'))
		$DIR_CONST = __DIR__;
	else
		$DIR_CONST = dirname(__FILE__);

	$SUCCESS_TPL_JOBS = FALSE;

	//logout if inactive
	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
	    // last request was more than 30 minutes ago
	    session_unset();     // unset $_SESSION variable for the run-time 
	    session_destroy();   // destroy session data in storage
	}
	$_SESSION['LAST_ACTIVITY'] = time();

	$job = new Job();

	$meta_description = '';
	$meta_keywords = '';

	if(!isset($_SERVER['HTTP_REFERER'])) 
	{
	   $_SERVER['HTTP_REFERER'] = '';
	} 
	 // #### EMAIL DEBUGGING TOOLS, uncomment to test emails / email templates - just change email delivery address for tests
	 //require_once '_tools/email_debug.php';

		// ============= PLUGINS ============================
	if (in_array("Adsense", $plugins)) { //ADSENSE
		//register adsense plugin
		define('ADSENSE', true);

		$quickSQL = 'SELECT count from adsense_count';
		$result = $db->query($quickSQL);
		$row = $result->fetch_assoc();

		define('ADSENSE_LISTING_COUNT', $row['count'] + 1); // after XY jobs there will be adsense displayed
		try {
			require_once APP_PATH . '_lib/class.Adsense.php';
			$adsense = new Adsense();
			$adsense->register($smarty);
		} catch (Exception $e) {
			define('ADSENSE', false);
		}
	} else {
		define('ADSENSE_LISTING_COUNT', 6); // define a default number for banners
	}

	if (in_array("Banners", $plugins)) { //BANNER MANAGER

		define('BANNER_MANAGER', true);
		try {
			require_once APP_PATH . '_lib/class.Campaign.php';
			$campaign = new Campaign();
			$campaign->register($smarty);

		} catch (Exception $e) {
			define('BANNER_MANAGER', false);
		}
	}

	if (in_array("Profiles", $plugins)) { //BANNER MANAGER
		define('PROFILES_PLUGIN', true);
		$smarty->assign('PROFILES_PLUGIN', true);
		try {
			$cls = new Applicant();
			$cls->register($smarty);
		} catch (Exception $e) {
			define('PROFILES_PLUGIN', false);
			$smarty->assign('PROFILES_PLUGIN', false);
		}
	}

	if (in_array("Paypal", $plugins)) { //PAYPAL + INVOICES
		define('PAYPAL_PLUGIN', true);

		$smarty->assign('INVOICE_LOGO_PATH', INVOICE_LOGO_PATH);

		// =============================== Paypal settings ================================
		try {
			include($DIR_CONST . '/plugins/Paypal/paypal_settings.php');
		} catch (Exception $e) {}
		// ================================================================================
		// main class ----------------------------------------------------------------------
		try {
			require_once APP_PATH . '_lib/paypal.class.php';
			require_once APP_PATH . '_lib/class.MYPDF.php';
			
		} catch (Exception $e) {
			define('PAYPAL_PLUGIN', false);
			define('PAYMENT_MODE', "0");
			$smarty->assign('PAYMENT_MODE', "0");
		}

		$smarty->assign('PAYMENT_MODE', PAYMENT_MODE);
		// --------------------------------------------------------------------------------
	} else {
		define('PAYPAL_PLUGIN', false);
		$smarty->assign('PAYMENT_MODE', "0");
		define('PAYMENT_MODE', "0");
	}

	// check for favourites plugin
	try {

		$file = $DIR_CONST . '/../add_favourites_ajax.php';
		
		if (!file_exists($file)) {
			$smarty->assign('FAVORITES_PLUGIN', 'false');
		} else {
			$smarty->assign('FAVORITES_PLUGIN', 'true');
		}

	} catch (Exception $e) {
		$smarty->assign('FAVORITES_PLUGIN', "false");
	}

    if (in_array("Indeed", $plugins)) { 
		define('INDEED_PLUGIN', true);

		 // ############ INDEED MAIN SETTINGS ######################
	     if ($cache->testCache('INDEED_CACHE')) 
	     {
	         $indeedSettings = $cache->loadCache('INDEED_CACHE');
	     } 
	     else 
	     {
	        // get and save Indeed settings
			$sql = 'SELECT * FROM indeed_settings WHERE id = 1';
			$result = $db->query($sql);
			if ($result->num_rows > 0) {
				$indeedSettings = $result->fetch_assoc();
	       		$cache->saveCache($indeedSettings, 'INDEED_CACHE');
			} else {
				$indeedSettings['activate_select'] = "deactivated";
			}

	     }

		// register Indeed templates
		try {
			$f = APP_PATH . '_lib/class.IndeedHook.php';
			if (file_exists($f)) {
				require_once $f;
				$indeed = new IndeedHook();
				$indeed->register($smarty);
			} else {
				$indeedSettings['activate_select'] = 'deactivated';
			}

		} catch (Exception $e) {
			$indeedSettings['activate_select'] = 'deactivated';
		}

		if ($indeedSettings['activate_select'] == 'activated') {

					// set Indeed settings
					define('INDEED_PUBLISHER_ID', $indeedSettings['publisher_id']);
				    define('INDEED_DEFAULT_QUERY', $indeedSettings['query']);
				    define('INDEED_LOCATION', $indeedSettings['location']);
				    define('INDEED_JOB_TYPE', $indeedSettings['jobtype']);
				    define('INDEED_COUNTRY', $indeedSettings['country']);
				    define('INDEED_DAYS_BACK', $indeedSettings['jobs_old']);
				    define('INDEED_ACTIVATED', $indeedSettings['activate_select']);
				    define('INDEED_HOMEPAGE_DROPDOWN', $indeedSettings['homepage_dropdown']);
				    define('INDEED_BOTH_JOBS_FLAG', $indeedSettings['show_both_jobs_flag']);

				    if (intval($indeedSettings['show_both_jobs_flag']) == 1)
				    	$smarty->assign('INDEED_BOTH_JOBS_FLAG', 'activated');
					$smarty->assign('INDEED', 'activated');
					// paginate Indeed jobs
					if (isset($_GET['p'])) {
						$smarty->assign('IndeedPage', $_GET['p']);
					} else {
						$smarty->assign('IndeedPage', 0);
					}

					// ############ INDEED SEARCH SETTINGS ######################
				     if ($cache->testCache('INDEED_SEARCH_SETTINGS')) 
				     {
				         $indeedSearchData = $cache->loadCache('INDEED_SEARCH_SETTINGS');
				     } 
				     else 
				     {
				        // get and save Indeed settings
						$sql = 'SELECT * FROM indeed_search_options';
						$result = $db->query($sql);
						$jobtypes = array();
						$countries = array();
						$cities = array();
						while ($row = $result->fetch_assoc()){

							if (intval($row['category_id']) == 1)
								$jobtypes[] = $row;
							if (intval($row['category_id']) == 2)
								$countries[] = $row;
							if (intval($row['category_id']) == 3)
								$cities[] = $row;
							
						} 
						$indeed_final = array(
							"jobtypes" => $jobtypes,
							"countries" => $countries,
							"cities" => $cities
						);

						$indeedSearchData = $indeed_final;
				       	$cache->saveCache($indeedSearchData, 'INDEED_SEARCH_SETTINGS');

				     }

				     $indeedFilterNames = array("", "", "");

				     $smarty->assign('indeedJobtypes', $indeedSearchData["jobtypes"]);
				     $smarty->assign('indeedJobtypesCount', count($indeedSearchData["jobtypes"]) - 1);
					 $smarty->assign('indeedCountries', $indeedSearchData["countries"]);
					 $smarty->assign('indeedCountriesCount', count($indeedSearchData["countries"]) - 1);
					 $smarty->assign('indeedCities', $indeedSearchData["cities"]);
					 $smarty->assign('indeedCitiesCount', count($indeedSearchData["cities"]) - 1);

					 if ($page !== "location" && $page !== "area") {
					 	$smarty->assign('IndeedJobType', $id);
					 	$indeedFilterNames[0] = getIndeedFilterNameByVar($id);
					 }

					 // sidebar panel opening
					 if ($page !== "location" && $page !== "area" && $id !== 0) {
					 	$smarty->assign('show_indeed_type', true);

					 } else if ($page === "location") {
					 	$smarty->assign('show_indeed_location', true);
					 } else if ($page === "area") {
					 	$smarty->assign('show_indeed_area', true);
					 } 

					 if ($id !== 0)
					 	$smarty->assign('indeed_type', $id);
					 else
					 	$smarty->assign('indeed_type', 'default');

		} else {
			define('INDEED_PLUGIN', false);
    	  	$smarty->assign('INDEED', 'deactivated');
    	  	$smarty->assign('INDEED_BOTH_JOBS_FLAG', 'deactivated');
		}

    } else {
    	  define('INDEED_PLUGIN', false);
    	  $smarty->assign('INDEED', 'deactivated');
    	  $smarty->assign('INDEED_BOTH_JOBS_FLAG', 'deactivated');
    }

	// assign footer social network links
	$smarty->assign('FB_URL', FB_URL);
	$smarty->assign('TWITTER_URL', TWITTER_URL);
	$smarty->assign('LINKEDIN_URL', LINKEDIN_URL);
	$smarty->assign('GPLUS_URL', GPLUS_URL);

	$smarty->assign('favourites_job_ids', $_SESSION['favourites']);
	$smarty->assign('landing_page', 0);

	// CUSTOM ROUTING REDIRECTING TO CONTROLLERS
	switch($page)
	{
		case 'index':
			$smarty->assign('landing_page', 1);
			require_once  CONTROLLERS_PATH . '/page_home.php';
			break;

		// custom plugin url
		case 'indeed-landing':
				require_once  CONTROLLERS_PATH . '/page_indeed_landing.php';
			break;
		// custom plugin url
		case 'indeed':
				require_once  CONTROLLERS_PATH . '/page_indeed.php';
			break;
		// query indeed by query
		case 'indeed-query':
			require_once  CONTROLLERS_PATH . '/page_indeed_query.php';
			break;
		// custom Indeed plugin functionality
		case 'location':
			if ($id !== 0){
				$smarty->assign('IndeedLocation', $id);
				$indeedFilterNames[1] = getIndeedFilterNameByVar($id);
			}
			else {
				$smarty->assign('IndeedLocation', 'all');
				$indeedFilterNames[1] = "";
			}
			require_once  CONTROLLERS_PATH . '/page_indeed_location_jobs.php';
			break;
		case 'area':
			if ($id !== 0){
				$smarty->assign('IndeedCity', $id);
				$indeedFilterNames[2] = getIndeedFilterNameByVar($id);

			}
			else {
				$smarty->assign('IndeedCity', 'all');
				$indeedFilterNames[2] = "";
			}
			require_once  CONTROLLERS_PATH . '/page_indeed_location_jobs.php';
			break;

		case 'feed':
				require_once  CONTROLLERS_PATH . '/page_indeed_feed.php';
			break;

	    case URL_APPLICANT_ACCOUNT_CONFIRMATION:
 		 require_once  CONTROLLERS_PATH . '/applicant_hash_confirmation.php';
 		break;

		// homepage is listing
		case URL_HOME:
			$smarty->assign('landing_page', 1);
			require_once  CONTROLLERS_PATH . '/page_home.php';
			break;

		case '':
			if (HOMEPAGE_LANDING == 'yes') {
				$smarty->assign('landing_page', 1);
				require_once  CONTROLLERS_PATH . '/page_home.php';
			}
			else {
				require_once  CONTROLLERS_PATH . '/page_jobs.php';
			}
			break;
	    // jobs
		case URL_JOBS:
			if ($_SESSION['CURRENT_PAGE']) {
				$_SESSION['CURRENT_PAGE'] = null;
				unset($_SESSION['CURRENT_PAGE']);	
			}

			require_once  CONTROLLERS_PATH . '/page_jobs.php';
			break;
			
		// jobs @ company
		case URL_JOBS_AT_COMPANY:
			require_once  CONTROLLERS_PATH . '/page_company.php';
			break;
			
		// jobs in city
		case URL_JOBS_IN_CITY:

			if (INDEED_ACTIVATED == 'activated' && INDEED_BOTH_JOBS_FLAG == '1') {
				$_SESSION['indeed_jobs_in_city'] = 1;
			}

			require_once  CONTROLLERS_PATH . '/page_city.php';
			break;

		case URL_PROFILE:
			if (isset($_SESSION['applicant'])) {
				if (defined('PROFILES_PLUGIN')) {
					$profilesController = 'plugins/Profiles/page_profile.php';
					if (file_exists($profilesController))
						include $profilesController;
					else {
						$html_title = SEO_HOMEPAGE_PAGE_UNAVAILABLE . ' / ' . SITE_NAME;
						$meta_keywords = SEO_HOMEPAGE_PAGE_UNAVAILABLE;
						$meta_description = SEO_HOMEPAGE_PAGE_UNAVAILABLE;
						$template = 'err/error.tpl';
					}
				} else {
					$template = 'err/plugin-missing.tpl';
				}
			} else {
				$smarty->assign('PLAIN_SITE', true);
				$smarty->assign('seo_title', SEO_APPLICANT_LOGIN_TITLE);
				$smarty->assign('seo_desc', SEO_APPLICANT_LOGIN_DESCRIPTION);
				$smarty->assign('seo_keys', SEO_APPLICANT_LOGIN_KEYWORDS);
				$template = 'auth/login-applicants.tpl';
			}
		break;
		case URL_LOGIN_APPLICANTS:
			if (isset($_SESSION['applicant'])) {
				if (defined('PROFILES_PLUGIN')) {
					$profilesController = 'plugins/Profiles/page_profile.php';
					if (file_exists($profilesController))
						include $profilesController;
					else {
						$html_title = SEO_HOMEPAGE_PAGE_UNAVAILABLE . ' / ' . SITE_NAME;
						$meta_keywords = SEO_HOMEPAGE_PAGE_UNAVAILABLE;
						$meta_description = SEO_HOMEPAGE_PAGE_UNAVAILABLE;
						$template = 'err/error.tpl';
					}
				} else {
					$template = 'err/plugin-missing.tpl';
				}
			} else {
				$smarty->assign('PLAIN_SITE', true);
				$smarty->assign('seo_title', SEO_APPLICANT_LOGIN_TITLE);
				$smarty->assign('seo_desc', SEO_APPLICANT_LOGIN_DESCRIPTION);
				$smarty->assign('seo_keys', SEO_APPLICANT_LOGIN_KEYWORDS);
				$template = 'auth/login-applicants.tpl';
			}
		break;

		// login for companies
		case URL_LOGIN_RECRUITERS:
			if (isset($_SESSION['user'])) {
				require_once  CONTROLLERS_PATH . '/page_dashboard.php';
			} else {
				$smarty->assign('PLAIN_SITE', true);
				$smarty->assign('seo_title', SEO_RECRUITERS_LOGIN_TITLE);
				$smarty->assign('seo_desc', SEO_RECRUITERS_LOGIN_DESCRIPTION);
				$smarty->assign('seo_keys', SEO_RECRUITERS_LOGIN_KEYWORDS);
				$template = 'auth/login-recruiters.tpl';
			}
			break;
		// not a direct visible route. login processing
		case 'login':
			require_once CONTROLLERS_PATH . '/page_login.php';
			break;
		case 'login-applicant':
			if (defined('PROFILES_PLUGIN')) {
				$profilesPage = 'plugins/Profiles/page_login_applicant.php';
				if (file_exists($profilesPage))
					include $profilesPage;
				else {
					$html_title = SEO_HOMEPAGE_PAGE_UNAVAILABLE . ' / ' . SITE_NAME;
					$meta_keywords = SEO_HOMEPAGE_PAGE_UNAVAILABLE;
					$meta_description = SEO_HOMEPAGE_PAGE_UNAVAILABLE;
					$template = 'err/error.tpl';
				}
			} else {
				$template = 'err/plugin-missing.tpl';
			}

			break;
        // company registration
		case URL_REGISTER_RECRUITERS:
			require_once CONTROLLERS_PATH . '/register_recruiters.php';
			$smarty->assign('seo_title', SEO_RECRUITERS_REGISTER_TITLE);
			$smarty->assign('seo_desc', SEO_RECRUITERS_REGISTER_DESCRIPTION);
			$smarty->assign('seo_keys', SEO_RECRUITERS_REGISTER_KEYWORDS);
			break;

		case URL_REGISTER_APPLICANTS:
			require_once CONTROLLERS_PATH . '/register_applicants.php';
			$smarty->assign('seo_title', SEO_APPLICANT_REGISTER_TITLE);
			$smarty->assign('seo_desc', SEO_APPLICANT_REGISTER_DESCRIPTION);
			$smarty->assign('seo_keys', SEO_APPLICANT_REGISTER_KEYWORDS);
			break;

        // logout
		case URL_LOGOUT:
			if (isset($_SESSION['user']))
			{			
				//delete any tmp jobs if he clicked away in the middle of posting
				if (isset($_SESSION['TMP_JOB_ID'])) {
					$tmpJob = new Job($_SESSION['TMP_JOB_ID']);
					$tmpJob->deleteById($_SESSION['TMP_JOB_ID']);
					unset($_SESSION['TMP_JOB_ID']);
					$_SESSION['TMP_JOB_ID'] = null;
				}

				unset($_SESSION['user']);
				unset($_SESSION['name']);
				redirect_to(BASE_URL);
				exit;
			} else {
				redirect_to(BASE_URL);
			}
			break;

		case URL_RESET_PASSWORD_RECRUITERS:
			require_once  CONTROLLERS_PATH . '/reset_password_recruiters.php';
			break;
		case URL_RESET_PASSWORD_APPLICANTS:
			require_once  CONTROLLERS_PATH . '/reset_password_applicants.php';
			break;
		//fixed routes
		case 'premium':
			$template = 'premium.tpl';
			break;

		case 'deactivation-successful':
				require_once CONTROLLERS_PATH . '/page_more_content.php';
				$smarty->assign('success_msg', $translations['website_general']['deactivation_successful']);
				$SUCCESS_TPL_JOBS = TRUE;
				$template = 'success/success.tpl';
			break;

		//package selection for recruiters
		case 'register-recruiters-packages' :
			require_once CONTROLLERS_PATH.'/register_recruiters_packages.php';
			break;

		case URL_RECRUITER_ACCOUNT_CONFIRMATION:
			require_once  CONTROLLERS_PATH . '/rec_hash_confirmation.php';
			break;
        // companies administration area
		case URL_DASHBOARD:
			if (isset($_SESSION['user'])) {
				require_once  CONTROLLERS_PATH . '/page_dashboard.php';
			} else {
				$smarty->assign('PLAIN_SITE_POST', true);
				$template = 'auth/login-recruiters.tpl';
			}
			break;
		//not a direct route
		case 'dashboard-settings':
			require_once  CONTROLLERS_PATH . '/page_dashboard_settings.php';
			break;
		//not a direct route
		case 'dashboard-company': 
			require_once  CONTROLLERS_PATH . '/page_dashboard_company.php';
			break;

		case URL_DASHBOARD_DEACTIVATE_ACCOUNT:
		    require_once  CONTROLLERS_PATH . '/page_dashboard_deactivate_account.php';
			break;

		case URL_ACCOUNT_NOT_CONFIRMED:

			if ($id === "app") {
				$smarty->assign('APPLICANT_FLOW', true);
			} else {
				$smarty->assign('APPLICANT_FLOW', false);
			}
			require_once CONTROLLERS_PATH . '/page_more_content.php';
			$template = 'auth/account-not-confirmed.tpl';
			break;

		case URL_JOB_POSTED:
			require_once  CONTROLLERS_PATH . '/page_job_posted.php';
			break;
		case 'cvdb-payment':
			require_once  CONTROLLERS_PATH . '/page_cvdb_posted.php';
			break;

		case 'account-payment':
			require_once  CONTROLLERS_PATH . '/page_account_order_posted.php';
			break;

		case URL_JOB_EDITED:
			require_once  CONTROLLERS_PATH . '/page_job_edited.php';
		break;

		// search results. not a visible route
		case 'search':
			require_once  CONTROLLERS_PATH . '/page_search.php';
			break;
		// case 'jobapi':
		// 	require_once  'api/api.php';
		// 	break;
		case URL_LANDING_SEARCHED:
			require_once  CONTROLLERS_PATH . '/page_landing_searched.php';
			break;
		// banners / ads routing / statistics
		case 'redir':
			require_once  CONTROLLERS_PATH . '/page_redir.php';
			break;

		case URL_SUBSCRIBE:
			$result = $db->query('
				SELECT 
					* 
				FROM 
					'.DB_PREFIX.'pages 
				WHERE 
					url = "' . $db->getConnection()->real_escape_string($page) . '"
			');
			$pageData = $result->fetch_assoc();

			if (is_array($pageData)) {
				$smarty->assign('seo_title', $pageData['page_title'] . ' - ' . SITE_NAME);
				$smarty->assign('seo_desc', $pageData['keywords']);
				$smarty->assign('seo_keys', $pageData['description']);
			} 
			require_once  CONTROLLERS_PATH . '/page_subscribe.php';
			break;

		case URL_UNSUBSCRIBE:
			require_once CONTROLLERS_PATH . '/page_unsubscribe.php';
			break;

		// job detail
		case URL_JOB:
			require_once  CONTROLLERS_PATH . '/page_job.php';
			break;
			
		case URL_APPLY:
			require_once  CONTROLLERS_PATH . '/page_apply.php';
			break;

		case URL_SUBSCRIBE_CONFIRMATION:
			require_once CONTROLLERS_PATH . '/subscribe_confirmation.php';
			break;

		case 'rss':
			require_once  CONTROLLERS_PATH . '/page_rss.php';
			$html_title = SEO_RSS_TITLE . ' ' . SITE_NAME;
			$meta_keywords = SEO_RSS_KEYWORDS;
			$meta_description = RSS_SEO . ' ' .  SITE_NAME;
			break;	
		
		// companies
		case URL_COMPANIES:
			require_once CONTROLLERS_PATH . '/page_companies.php';
				$html_title = SITE_NAME . ' / ' . SEO_COMPANIES_TITLE;
				$meta_keywords = SEO_COMPANIES_DESCRIPTION;
				$meta_description = SEO_COMPANIES_KEYWORDS;
			break;

		case URL_SIGN_UP:
			require_once CONTROLLERS_PATH . '/page_signup.php';
			break;

		case 'process_paypal_err':
			require_once CONTROLLERS_PATH . '/process_paypal_err.php';
			break;

		case 'process_paypal':
			require_once CONTROLLERS_PATH . '/process_paypal.php';
			break;

		case 'process_paypal_cvdb':
			require_once CONTROLLERS_PATH . '/process_paypal_cvdb.php';
			break;

		case 'process_paypal_account':
			require_once CONTROLLERS_PATH . '/process_paypal_account.php';
			break;

		case 'cancel_paypal':
			require_once CONTROLLERS_PATH . '/cancel_paypal.php';
			break;

		// not visible route
		case 'get-companies':
			require_once CONTROLLERS_PATH . '/page_getcompanies.php';
			break;
			
		case URL_JOB_UNAVAILABLE:

			 header("HTTP/1.1 404 Not Found");
			//assign additional content
			$html_title = SEO_HOMEPAGE_JOB_UNAVAILABLE . ' / ' . SITE_NAME;
			$template = 'err/no-job.tpl';
			break;

        case 'sitemap.xml':
            generate_sitemap('xml');
            break;
        case 'sitemap':
            generate_sitemap('xml');
            break;

        case 'sitemap.txt':
            generate_sitemap('txt');
            break;
		
		// custom pages, with fallback to the 404 error page
		default: 
			$result = $db->query('
				SELECT 
					* 
				FROM 
					'.DB_PREFIX.'pages 
				WHERE 
					url = "' . $db->getConnection()->real_escape_string($page) . '"
			');
			$pageData = $result->fetch_assoc();
			if (is_array($pageData)) {
				require_once  CONTROLLERS_PATH . '/page_page.php';
				$html_title = $pageData['page_title'] . ' - ' . SITE_NAME;
				$meta_keywords = $pageData['keywords'];
				$meta_description = $pageData['description'];
				$smarty->assign('CONTACT_PAGE_URL', $pageData['url']);
				$template = 'static/page.tpl';
			} else {
				header("HTTP/1.1 404 Not Found");
				// TO-DO: add suggestion if no trailing slash supplied
				$html_title = SEO_HOMEPAGE_PAGE_UNAVAILABLE . ' / ' . SITE_NAME;
				$meta_keywords = SEO_HOMEPAGE_PAGE_UNAVAILABLE;
				$meta_description = SEO_HOMEPAGE_PAGE_UNAVAILABLE;
				$template = 'err/error.tpl';
			}
			break;
	}
	$smarty->assign('CUSTOMIZER_COLOR', CUSTOMIZER_COLOR);
	$smarty->assign('CUSTOMIZER_COLOR_RGBA', CUSTOMIZER_COLOR_RGBA);
	
	// job listing CMS settings
	$smarty->assign('jobs_logo_width', $logo_settings['jobs_logo_width']);
	$smarty->assign('jobs_logo_width_mobile', $logo_settings['jobs_logo_width_mobile']);
	$smarty->assign('jobs_logo_padding', $logo_settings['jobs_logo_padding']);
	$smarty->assign('jobs_candidates_on_flag', $logo_settings['jobs_candidates_on_flag']);
	$smarty->assign('jobs_subheader_bg_path', $logo_settings['jobs_subheader_bg_path']);
	$smarty->assign('custom_css', $logo_settings['custom_css']);
	
	$smarty->assign('SEO_LATITUDE', LATITUDE);
	$smarty->assign('SEO_LONGITUDE', LONGITUDE);

	$smarty->assign('indeedFilterNames', $indeedFilterNames);

	$smarty->assign('navigation', get_navigation());
	
	// remote portal switch
	$smarty->assign('REMOTE_PORTAL', REMOTE_PORTAL);

	// list of available languages
	$smarty->assign('languages', $translator->getLanguages());

	// translations
	$smarty->assign('translator', $translator);

	$smarty->assign('translations', $translations);
	// create a JSON string from the translations array, but only for the "js" section
	$smarty->assign('translationsJson', iniSectionsToJSON(array('js' => $translations['js'])));
	
	//website theme
	$smarty->assign('TERMS_CONDITIONS_URL', TERMS_CONDITIONS_URL);
	$smarty->assign('ABOUT_URL', ABOUT_URL);
	$smarty->assign('MAIN_URL', MAIN_URL);
	$smarty->assign('PROTOCOL_URL', PROTOCOL_URL);
	$smarty->assign('THEME', $settings['theme']);
	$smarty->assign('CURRENT_PAGE', $page);
	$smarty->assign('CURRENT_ID', $id);
	$smarty->assign('BASE_URL', BASE_URL);
	$smarty->assign('HTTP_REFERER', $_SERVER['HTTP_REFERER']);
	$smarty->assign('SITE_LOGO_PATH', SITE_LOGO_PATH);

	//Add the dynamic URL defitions to SMARTY
	$smarty->assign('URL_FAVOURITES', URL_FAVOURITES);
	$smarty->assign('URL_JOB', URL_JOB);
	$smarty->assign('URL_JOBS', URL_JOBS);
	$smarty->assign('URL_COMPANIES', URL_COMPANIES);
	$smarty->assign('URL_JOBS_IN_CITY', URL_JOBS_IN_CITY);
	$smarty->assign('URL_JOBS_AT_COMPANY', URL_JOBS_AT_COMPANY);
	$smarty->assign('URL_LOGIN_RECRUITERS', URL_LOGIN_RECRUITERS);
	$smarty->assign('URL_LOGIN_APPLICANTS', URL_LOGIN_APPLICANTS);
	$smarty->assign('URL_PROFILE', URL_PROFILE);
	$smarty->assign('URL_PROFILE_EDIT', URL_PROFILE_EDIT);
	$smarty->assign('URL_PROFILE_APPLICATIONS', URL_PROFILE_APPLICATIONS);
	$smarty->assign('URL_PROFILE_CHANGEPASSWORD', URL_PROFILE_CHANGEPASSWORD);
	$smarty->assign('URL_PROFILE_DELETE', URL_PROFILE_DELETE);
	$smarty->assign('PROFILE_ROUTING_ARR', $PROFILE_ROUTING);
 
	$smarty->assign('URL_REGISTER_RECRUITERS', URL_REGISTER_RECRUITERS);
	$smarty->assign('URL_REGISTER_APPLICANTS', URL_REGISTER_APPLICANTS);
	$smarty->assign('URL_SIGN_UP', URL_SIGN_UP);

	$smarty->assign('URL_LOGOUT', URL_LOGOUT);
	$smarty->assign('URL_RESET_PASSWORD_RECRUITERS', URL_RESET_PASSWORD_RECRUITERS);
	$smarty->assign('URL_RESET_PASSWORD_APPLICANTS', URL_RESET_PASSWORD_APPLICANTS);
	$smarty->assign('URL_RECRUITER_ACCOUNT_CONFIRMATION', URL_RECRUITER_ACCOUNT_CONFIRMATION);
	$smarty->assign('URL_DASHBOARD', URL_DASHBOARD);
	$smarty->assign('URL_DASHBOARD_SETTINGS', URL_DASHBOARD_SETTINGS);
	$smarty->assign('URL_DASHBOARD_CVDATABASE', URL_DASHBOARD_CVDATABASE);
	$smarty->assign('URL_DASHBOARD_JOBS', URL_DASHBOARD_JOBS);
	$smarty->assign('URL_DASHBOARD_EDIT_JOB', URL_DASHBOARD_EDIT_JOB);
	$smarty->assign('URL_DASHBOARD_DELETE_JOB', URL_DASHBOARD_DELETE_JOB);
	$smarty->assign('URL_DASHBOARD_STATISTICS', URL_DASHBOARD_STATISTICS);
	$smarty->assign('URL_DASHBOARD_APPLICATIONS', URL_DASHBOARD_APPLICATIONS);
	$smarty->assign('URL_DASHBOARD_INVOICES', URL_DASHBOARD_INVOICES);
	$smarty->assign('URL_DASHBOARD_POST', URL_DASHBOARD_POST);
	$smarty->assign('URL_LANDING_SEARCHED', URL_LANDING_SEARCHED);

	$smarty->assign('URL_DASHBOARD_OVERVIEW', URL_DASHBOARD_OVERVIEW);
	$smarty->assign('URL_DASHBOARD_EDIT_COMPANY', URL_DASHBOARD_EDIT_COMPANY);
	$smarty->assign('URL_DASHBOARD_DEACTIVATE_ACCOUNT', URL_DASHBOARD_DEACTIVATE_ACCOUNT);
	$smarty->assign('URL_DASHBOARD_ACCOUNT', URL_DASHBOARD_ACCOUNT);
	$smarty->assign('URL_DASHBOARD_ACCOUNT_ORDER', URL_DASHBOARD_ACCOUNT_ORDER);

	$smarty->assign('URL_ACCOUNT_NOT_CONFIRMED', URL_ACCOUNT_NOT_CONFIRMED);
	$smarty->assign('URL_JOB_POSTED', URL_JOB_POSTED);
	$smarty->assign('URL_JOB_EDITED', URL_JOB_EDITED);
	$smarty->assign('URL_SUBSCRIBE', URL_SUBSCRIBE);	
	$smarty->assign('URL_UNSUBSCRIBE', URL_UNSUBSCRIBE);	
	$smarty->assign('URL_APPLY', URL_APPLY);	
	$smarty->assign('URL_SUBSCRIBE_CONFIRMATION', URL_SUBSCRIBE_CONFIRMATION);	
	$smarty->assign('URL_JOB_UNAVAILABLE', URL_JOB_UNAVAILABLE);	
	$smarty->assign('URL_HOME', URL_HOME);	
	$smarty->assign('SITE_NAME', SITE_NAME);
	$smarty->assign('BLOG_STATUS', BLOG_STATUS);

	$smarty->assign('PREMIUM_LISTING_PRICE', PREMIUM_LISTING_PRICE);
	$smarty->assign('JOB_POSTED_PRICE', JOB_POSTED_PRICE);
	$smarty->assign('WEBSITE_CURRENCY', WEBSITE_CURRENCY);
	$smarty->assign('FORMATED_CURRENCY', format_currency(WEBSITE_CURRENCY, PREMIUM_LISTING_PRICE));
	$smarty->assign('FORMATED_CURRENCY_JOBPOSTED', format_currency(WEBSITE_CURRENCY, JOB_POSTED_PRICE));

	//assign current year
	$smarty->assign('YEAR', date("Y"));
	
	//sessions
	if (isset($_SESSION['user'])) {
		$smarty->assign('SESSION_USERNAME', $_SESSION['name']);
	}

	if (isset($_SESSION['applicant'])) {
		$smarty->assign('SESSION_APPLICANT', true);
	}

	//SEO
	if (isset($html_title) && $html_title != '')
		$smarty->assign('html_title', $html_title);
	if (isset($meta_description) && $meta_description != '')
		$smarty->assign('meta_description', $meta_description);
	if (isset($meta_keywords) && $meta_keywords != '')
		$smarty->assign('meta_keywords', $meta_keywords);

	$smarty->error_reporting = E_ALL & ~E_NOTICE;
	if (isset($template) && $template != '')
		$smarty->display($template);

?>
