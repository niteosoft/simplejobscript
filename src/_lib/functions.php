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

function hex2rgb( $colour ) {
        if ( $colour[0] == '#' ) {
                $colour = substr( $colour, 1 );
        }
        if ( strlen( $colour ) == 6 ) {
                list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
        } elseif ( strlen( $colour ) == 3 ) {
                list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
        } else {
                return false;
        }
        $r = hexdec( $r );
        $g = hexdec( $g );
        $b = hexdec( $b );
        return array( 'red' => $r, 'green' => $g, 'blue' => $b );
}

function requestSjsApi($url) {

	$data = file_get_contents($url);

	// in case file_get_cont is not supported in hosting use curl
	if ($data === false) {
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    $data = curl_exec($ch);
	    curl_close($ch);	
	}

	return $data;
}


function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}


function deconstructSMlink($link) {
		
		$exp = explode("_", $link);
		$SM_ID = intval($exp[0]);
		$SM_URL = $exp[1];

		$obj = new stdClass();
		$obj->linkToSave = $link;
		
		$sm_data = getSMdataById($SM_ID);
		$obj->smId = $sm_data['id'];

		if (intval($sm_data['id']) == 11){
			$obj->whatsapp = true;
			$obj->whatsapp_numb = $SM_URL;
			$obj->linkToShow = $SM_URL;
		} else {
			$obj->whatsapp = false;
			$obj->linkToShow = 'http://' . $SM_URL;
		}

		$obj->smName = $sm_data['name'];
		$obj->icon = $sm_data['icon'];

		return $obj;
}

function constructSMlink($url, $id) {
		// take SM link and SM id
		if (strpos($url, "http://") !== false)
			$url = substr($url, 7, strlen($url) - 1);
		else if (strpos($url, "https://") !== false)
			$url = substr($url, 8, strlen($url) - 1);
		else if (strpos($url, "www.") !== false)
			$url = substr($url, 4, strlen($url) - 1);
		else
			$url = $url;

		$link = $id . '_' .$url;

		$obj = new stdClass();
		$obj->linkToSave = $link;
		$obj->linkToShow = 'http://' . $link;
		$sm_data = getSMdataById($id);
		$obj->smName = $sm_data['name'];
		$obj->icon = $sm_data['icon'];

		return $obj;
}


function cleanString($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

function tagglesToString($taggles) {
	$numItems = count($taggles);
	$i = 0;
	$skills = '';
	foreach ($taggles as $tag) {
		if(++$i === $numItems) {
			$skills .= $tag;
		} else {
			$skills .= $tag . ',';
		}
	}
	return $skills;
}

function replaceTinyMceBreaks($text) { 
   return strtr($text, array("<p>&nbsp;</p>" => '')); 
} 

function stripLineBreaks($text) { 
   return strtr($text, array("\r\n" => '<br />', "\r" => '<br />', "\n" => '<br />', "\\r\\n" => '<br />')); 
} 

function convertLineBreaks($text) { 
   return strtr($text, array("<br />" => '&#13;&#10;')); 
} 

function formatBytes($bytes, $precision = 2) { 
    $units = array('B', 'KB', 'MB', 'GB', 'TB'); 

    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 

    // Uncomment one of the following alternatives
    // $bytes /= pow(1024, $pow);
    $bytes /= (1 << (10 * $pow)); 

    return round($bytes, $precision) . ' ' . $units[$pow]; 
} 

function add_single_quotes($arg) 
{
	/* single quote and escape single quotes and backslashes */ 
	return "'" . addcslashes($arg, "'\\") . "'"; 
}

function format_currency($currency_sign, $amount) {
	if (strcmp(strtolower(CURRENCY_PLACEMENT), "before amount") == 0)
		return $currency_sign . $amount;
	else
		return $amount . $currency_sign;
}

function time_elapsed_string($ptime)
{
    $etime = time() - $ptime;

    if ($etime < 1)
    {
        return DATE_STR_ZERO_SECONDS;
    }

    $a = array( 365 * 24 * 60 * 60  =>  DATE_STR_YEAR,
                 30 * 24 * 60 * 60  =>  DATE_STR_MONTH,
                      24 * 60 * 60  =>  DATE_STR_DAY,
                           60 * 60  =>  DATE_STR_HOUR,
                                60  =>  DATE_STR_MINUTE,
                                 1  =>  DATE_STR_SECOND
                );
    $a_plural = array( DATE_STR_YEAR   => DATE_STR_YEARS,
                       DATE_STR_MONTH  => DATE_STR_MONTHS,
                       DATE_STR_DAY    => DATE_STR_DAYS,
                       DATE_STR_HOUR   => DATE_STR_HOURS,
                       DATE_STR_MINUTE => DATE_STR_MINUTES,
                       DATE_STR_SECOND => DATE_STR_SECONDS
                );

    foreach ($a as $secs => $str)
    {
        $d = $etime / $secs;
        if ($d >= 1)
        {
            $r = round($d);
            return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ' . DATE_STR_AGO;
        }
    }
}

function getSMdataById($id) {
	global $db;

	$sql = 'SELECT * FROM '.DB_PREFIX.'social_media WHERE id = ' . intval($id);
	$result = $db->query($sql);
	$row = $result->fetch_assoc();

	return $row;
}

function get_cities_cloud()
{
	global $db;
	$city_array = array();
 
	$sql = 	'SELECT c.id, c.name, c.ascii_name, COUNT(*) AS nr
			 FROM '.DB_PREFIX.'cities c 
			 INNER JOIN '.DB_PREFIX.'jobs j ON (j.city_id = c.id ) 
			 WHERE j.is_active = 1 
			 GROUP BY c.name';
 
	$cities = $db->QueryArray($sql);
 
	foreach ($cities as $city)
	{
		$numberOfJobs = $city['nr'];
 
		$city_array[] = array('name' => $city['name'],
		                     'varname' => $city['ascii_name'],
		                     'count' => $numberOfJobs,
		                     'tag_height' => get_cloud_tag_height($numberOfJobs));
	}
 
	return $city_array;
}

function get_cloud_tag_height($numberOfItems)
{
	if ($numberOfItems < 2)
	{
		$tag_height = 1;
	}
	else if ($numberOfItems >= 2 && $numberOfItems < 3)
	{
		$tag_height = 2;
	}
	else if ($numberOfItems >= 3 && $numberOfItems < 4)
	{
		$tag_height = 3;
	}
	else if ($numberOfItems >= 4 && $numberOfItems < 5)
	{
		$tag_height = 4;
	}
	else if ($numberOfItems >= 5 && $numberOfItems < 6)
	{
		$tag_height = 5;
	}
	else if ($numberOfItems >= 6)
	{
		$tag_height = 6;
	}
	
	return $tag_height;
}

function get_categories()
{
    global $db;
    $categories = array();
    $sql = 'SELECT *
                   FROM '.DB_PREFIX.'categories
                   ORDER BY category_order ASC';
    $result = $db->query($sql);
    while ($row = $result->fetch_assoc())
    {
        $categories[] = array('id' => $row['id'], 'name' => $row['name'], 'var_name' => $row['var_name'], 'title' => $row['title'], 'description' => $row['description'], 'keywords' => $row['keywords']);
    }
    return $categories;
}

function get_articles()
{
	global $db;
	$articles = array();
	$sql = 'SELECT id, title, page_title, url 
	               FROM '.DB_PREFIX.'pages
	               ORDER BY title ASC';
	$result = $db->query($sql);
	while ($row = $result->fetch_assoc())
	{
		$articles[$row['url']] = $row;
	}
	return $articles;
}

function get_navigation($menu = null)
{
	global $db;

	$navigation = array();

	$sql = '
		SELECT id, url, page_title, description, is_external, external_url
		FROM '.DB_PREFIX.'pages
		ORDER BY link_order ASC';

	$result = $db->query($sql);
	while ($row = $result->fetch_assoc())
	{
		$o = new stdClass;
		$o->page_id = $row['id'];
		$o->url = $row['url'];
		$o->name = $row['page_title'];
		$o->title = $row['description'];
		$o->is_external = $row['is_external'];
		$o->external_url = $row['external_url'];
		array_push($navigation, $o);
	}
	return $navigation;
}

function get_cities()
{
	global $db;
	
	$cities = array();
	
	$sql = 'SELECT id, name, ascii_name
	               FROM '.DB_PREFIX.'cities
	               ORDER BY name ASC';
	
	$result = $db->query($sql);
	
	while ($row = $result->fetch_assoc())
	{
		$cities[] = array('id' => $row['id'], 'name' => $row['name'], 'ascii_name' => $row['ascii_name']);
	}
	
	return $cities;
}

function get_categ_id_by_varname($var_name)
{
	global $db;
	$sql = 'SELECT id FROM '.DB_PREFIX.'categories WHERE var_name = "' . $var_name . '"';
	$result = $db->query($sql);
	$row = $result->fetch_assoc();
	return $row['id'];
}

function get_categ_name_by_varname($var_name)
{
    global $db;
    $sql = 'SELECT name FROM '.DB_PREFIX.'categories WHERE var_name = "' . $var_name . '"';
    $result = $db->query($sql);
    $row = $result->fetch_assoc();
    return $row['name'];
}

function getIndeedFilterNameByVar($var_name) {
	global $db;
	
	$city = null;
	
	$sql = 'SELECT name
	               FROM '.DB_PREFIX.'indeed_search_options
	               WHERE value = "' . $var_name . '"';

	$result = $db->query($sql);
	$row = $result->fetch_assoc();
		
	return $row['name'];
}

function get_city_id_by_asciiname($ascii_name)
{
	global $db;
	
	$city = null;
	
	$sql = 'SELECT id, name
	               FROM '.DB_PREFIX.'cities
	               WHERE ascii_name = "' . $ascii_name . '"';

	$result = $db->query($sql);
	$row = $result->fetch_assoc();
	
	if ($row)
		$city = array('id' => $row['id'], 'name' => $row['name']);
		
	return $city;
}

/**
* Converts the multidimensional array that results after calling parse_ini_file (filePath, processSections = true)
* to a JSON string.
* The resulting JSON string will look something like this:
* {"sectionOne": {"messageKeyOne": "messageTextOne", "messageKeyTwo": "messageTextTwo"}, "sectionTwo": {....},....}
*
* @author putypuruty
*/
function iniSectionsToJSON($iniSections)
{
	$translationsJson = "{";
	$sectionsCount = 0;
		
	foreach ($iniSections as $section => $sectionMessages)
	{
		$translationsJson = $translationsJson . "\"" . $section . "\": {";
		$sectionMessagesCount = 0;
		
		foreach ($sectionMessages as $messageKey => $messageText)
		{
			$translationsJson = $translationsJson . "\"".$messageKey . "\":\"" . preg_replace("/\r?\n/", "\\n", addslashes($messageText)) . "\"";
			
			$sectionMessagesCount++;
			
			if ($sectionMessagesCount < count($sectionMessages))
				$translationsJson .= ",";
		}
		$translationsJson .= "}";
		
		$sectionsCount++;

		if ($sectionsCount < count($iniSections))
			$translationsJson .= ",";
	}
	
	$translationsJson = $translationsJson."}";
	
	return $translationsJson;
}

/**
 * Returns the city with the specified ID or null
 * if the city was not found.
 *
 * @param $cityID
 * @return 
 */
function get_city_by_id($cityID)
{
	global $db;
	
	$city = null;
	
	$sql = 'SELECT id, name
	               FROM '.DB_PREFIX.'cities
	               WHERE id = ' . $cityID;
	$result = $db->query($sql);
	
	$row = $result->fetch_assoc();
	
	if ($row)
		$city = array('id' => $row['id'], 'name' => $row['name']);
		
	return $city;  
}

function clear_main_cache() {
	$DIR_CONST = '';
	if (defined('__DIR__'))
	    $DIR_CONST = __DIR__;
	else
	    $DIR_CONST = dirname(__FILE__);

	$target = $DIR_CONST . '/../_cache/';

	if ($handle = opendir(  $target ))
	{
	    while (false !== ($file = readdir($handle)))
	    {
		  if( is_file( $target . $file) )
	        {
	            unlink($target . $file);
	        }
	    }
	    closedir($handle);
	}
}

function clear_tpl_cache() {
	$DIR_CONST = '';
	if (defined('__DIR__'))
	    $DIR_CONST = __DIR__;
	else
	    $DIR_CONST = dirname(__FILE__);

	$target = $DIR_CONST . '/../_tpl/' . $settings['theme'] .'/_cache/';

	if ($handle = opendir(  $target ))
	{
	    while (false !== ($file = readdir($handle)))
	    {
		  if( is_file( $target . $file) )
	        {
	            unlink($target . $file);
	        }
	    }
	    closedir($handle);
	}
}

function clear_tpl_cache_admin($theme) {
	$DIR_CONST = '';
	if (defined('__DIR__'))
	    $DIR_CONST = __DIR__;
	else
	    $DIR_CONST = dirname(__FILE__);

	$target = $DIR_CONST . '/../_tpl/' . $theme .'/_cache/';

	if ($handle = opendir(  $target ))
	{
	    while (false !== ($file = readdir($handle)))
	    {
		  if( is_file( $target . $file) )
	        {
	            unlink($target . $file);
	        }
	    }
	    closedir($handle);
	}
}

function clear_admin_cache() {
	$DIR_CONST = '';
	if (defined('__DIR__'))
	    $DIR_CONST = __DIR__;
	else
	    $DIR_CONST = dirname(__FILE__);

	$target = $DIR_CONST . '/../sjs-admin/_tpl/_cache/';

	if ($handle = opendir(  $target ))
	{
	    while (false !== ($file = readdir($handle)))
	    {
		  if( is_file( $target . $file) )
	        {
	            unlink($target . $file);
	        }
	    }
	    closedir($handle);
	}
}

function get_types()
{
	global $db;
	$types = array();
	$cache = new Cache(APP_PATH . '_cache/', null, USE_CACHE);

	if ($cache->testCache('SIDEBAR_JOBTYPES_CACHE')) 
	{
	   $types = $cache->loadCache('SIDEBAR_JOBTYPES_CACHE');
	} else {
		$sql = 'SELECT id, name, var_name
				FROM '.DB_PREFIX.'types ';
		$result = $db->query($sql);
		
		while($row = $result->fetch_assoc())
		{
			$s = 'SELECT COUNT(id) as job_count FROM jobs WHERE is_active = 1 AND UNIX_TIMESTAMP(expires) > UNIX_TIMESTAMP(NOW()) AND type_id = ' . $row['id'];
			$r = $db->query($s);
			$innerRow = $r->fetch_assoc();

			if (intval($innerRow['job_count']) > 0) {
				$types[] = array('id' => $row['id'], 'name' => $row['name'], 'var_name' => $row['var_name'], 'job_count' => $innerRow['job_count']);
			}

		}
		// save types in cache
		$cache->saveCache($types, 'SIDEBAR_JOBTYPES_CACHE');
	}

	return $types;
}

function get_types_admin()
{
	global $db;
	$types = array();

	$sql = 'SELECT id, name, var_name
			FROM '.DB_PREFIX.'types ';
	$result = $db->query($sql);
	
	while($row = $result->fetch_assoc())
	{
		$s = 'SELECT COUNT(id) as job_count FROM jobs WHERE is_active = 1 AND UNIX_TIMESTAMP(expires) > UNIX_TIMESTAMP(NOW()) AND type_id = ' . $row['id'];
		$r = $db->query($s);
		$innerRow = $r->fetch_assoc();

		$types[] = array('id' => $row['id'], 'name' => $row['name'], 'var_name' => $row['var_name'], 'job_count' => $innerRow['job_count']);
	}
	
	return $types;
}

function get_type_id_by_varname($var_name)
{
	global $db;
	$sql = 'SELECT id FROM '.DB_PREFIX.'types WHERE 
		var_name = "'.$var_name.'"';
	$result = $db->query($sql);
	$row = $result->fetch_assoc();
	
	if ($row)
		return $row['id'];
	return false;
}

function get_type_varname_by_id($id)
{
	global $db;
	$sql = 'SELECT var_name FROM '.DB_PREFIX.'types WHERE 
		id = '.$id;
	$result = $db->query($sql);
	$row = $result->fetch_assoc();
	
	if ($row)
		return $row['var_name'];
	return false;
}

function get_category_by_var_name($var_name)
{
	global $db;
	$category = null;
	
	$sql = 'SELECT *
	               FROM '.DB_PREFIX.'categories
	               WHERE var_name = "' . $var_name . '"';
	
	$result = $db->query($sql);
	$row = $result->fetch_assoc();
	
	if ($row)
		$category = build_category_from_result_set_row($row);
	
	return $category;
}

function get_category_by_id($id)
{
	global $db;
	$category = null;
	
	$sql = 'SELECT *
	               FROM '.DB_PREFIX.'categories
	               WHERE id = ' . $id;
	
	$result = $db->query($sql);
	$row = $result->fetch_assoc();
	
	if ($row)
		$category = build_category_from_result_set_row($row);
	
	return $category;
}

function processUrlForEmail($url) 
{

	if (strpos($url, "http://") !== false)
		return substr($url, 7, strlen($url));

	if (strpos($url, "https://") !== false)
		return substr($url, 8, strlen($url));

	return $url;
}

function processUrlForEmailTrimEnd($url) 
{

	if (strpos($url, "http://") !== false)
		return substr($url, 7, strlen($url));

	if (strpos($url, "https://") !== false)
		return substr($url, 8, strlen($url));

	return rtrim($url, "/");
}

function build_category_from_result_set_row($row)
{
	return array('id' => $row['id'], 'name' => $row['name'], 'var_name' => $row['var_name'], 
			     'title' => $row['title'], 'description' => $row['description'],
			     'keywords' => $row['keywords'], 'category_order' => $row['category_order']);
}

function generate_indeed_feed()
{
	$type = "xml";
	$DATE_FORMAT = 'D, d M y H:i:s O';
    global $db;
    $sanitizer = new Sanitizer;

	$jobs = array();
	
	$sql = 'SELECT id
	               FROM '.DB_PREFIX.'jobs
	               WHERE UNIX_TIMESTAMP(expires) > UNIX_TIMESTAMP(NOW()) AND is_tmp = 0  AND is_active = 1 ORDER BY created_on DESC';

	$result = $db->query($sql);

    header('Content-Type: text/xml; charset="utf-8"');
    echo '<?xml version="1.0" encoding="utf-8"?>';
    echo '<source>';
	echo '<publisher>' . SITE_NAME . '</publisher>';
	echo '<publisherurl> ' . PROTOCOL . MAIN_URL . '</publisherurl>';
	echo '<lastBuildDate>'. date($DATE_FORMAT) .'</lastBuildDate>';

	while ($row = $result->fetch_assoc())
	{
	 	$current_job = new Job($row['id']);
		$JOB = $current_job->GetInfo();

		$cityname = $db->query('SELECT name FROM '.DB_PREFIX.'cities where id=' . $JOB["city_id"]);
		$cityname = $cityname->fetch_assoc();

	    $url = PROTOCOL . MAIN_URL . 'job/' . $sanitizer->sanitize_title_with_dashes($JOB['title']) . '/' . $row['id'];

		echo '<job>'; 
		echo '<title><![CDATA[' . $JOB["title"] . ']]></title>';
        echo '<date><![CDATA[' . date($DATE_FORMAT, $JOB["created_on_ts"]) . ']]></date>';
		echo '<referencenumber><![CDATA['. 'dj_' . $row['id'] . ']]></referencenumber>';
		echo '<url><![CDATA[' . $url . ']]></url>';
        echo '<company><![CDATA['. $JOB["company"] . ']]></company>';
        echo '<country><![CDATA[' . $cityname["name"] . ']]></country>';			
		echo '<description><![CDATA[' . $JOB["description"] . ']]></description>';
		echo '<salary><![CDATA[' . $JOB["salary"] . ']]></salary>';
		echo '<jobtype><![CDATA[' . $JOB["type_name"]. ']]></jobtype>';
		echo '<category><![CDATA['.$JOB["category_name"].']]></category>';
        echo '</job>';
    }
    echo '</source>';
   
}

function generate_sitemap($type)
{
    global $db;
    $sanitizer = new Sanitizer;

    // Get all links
    //$result = $db->query('SELECT url FROM '.DB_PREFIX.'links');
    //while ($row = $result->fetch_assoc()) if (!strstr($row['url'], 'http://')) $sitemap[BASE_URL . $row['url'] . '/'] = 1;

    // Get all custom pages
    $result = $db->query('SELECT url FROM '.DB_PREFIX.'pages');
    while ($row = $result->fetch_assoc()) $sitemap[$row['url'] . '/'] = 1; 
    
    //my custom routes
    $sitemap[URL_COMPANIES] = 1;
    $sitemap[URL_LOGIN_RECRUITERS] = 1;
    $sitemap[URL_REGISTER_RECRUITERS] = 1;

    // Get all categories
    $categories = get_categories();
    $i = 0; while($i < count($categories)) { $sitemap[URL_JOBS . '/' . $categories[$i]['var_name'] . '/'] = 1; $i++; }

    if (REMOTE_PORTAL == 'deactivated'){
	    // Get all cities
	    $cities = get_cities();
	    $i = 0; while($i < count($cities)) { $sitemap[URL_JOBS_IN_CITY . '/' . $cities[$i]['ascii_name'] . '/'] = 1; $i++; }
    }

    // Get all companies
    $result = $db->query('SELECT c.id as "company_id", j.company FROM '.DB_PREFIX.'jobs j, company c WHERE j.is_active = 1 AND c.name = j.company');
    while ($row = $result->fetch_assoc()) $sitemap[URL_JOBS_AT_COMPANY . '/' . $sanitizer->sanitize_title_with_dashes($row['company']) . '/' . $row['company_id']] = 1;
        
    // Get all active Jobs
    $result = $db->query('SELECT j.id as "jid", j.title as "jtitle", j.company as "jcompany", c.ascii_name as "cascii" FROM '.DB_PREFIX.'jobs j, cities c WHERE j.is_active = 1 AND j.city_id=c.id');
    while ($row = $result->fetch_assoc()) $sitemap[URL_JOB .'/' . $sanitizer->sanitize_title_with_dashes($row['jtitle']) . '-' . $row['cascii'] . '/' . $row['jid']] = 1;


    // Generate output
    if ($type == 'xml')
    {
        header('Content-Type: text/xml; charset="utf-8"');
        
        echo '<?xml version="1.0" encoding="UTF-8"?>';
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        
        foreach ($sitemap as $url => $value)
        {
            echo '<url><loc>'. PROTOCOL . MAIN_URL . $url.'</loc></url>';
        }
        echo '</urlset>';
    }
    else
    {
        foreach ($sitemap as $url => $value)
        {
            echo PROTOCOL . MAIN_URL . $url.'<br />';
        }        
    }

}
?>
