<div style="width: 500px; margin: 0 auto; margin-top: 100px;padding: 30px; background-color: #f2f2f2;">

<img class="logo" src="/uploads/logos/invoice-logo.png" alt="Installer logo" />  &nbsp;<span style="position: absolute; font-size: 17px; font-weight: bold; margin-top: 10px;">|&nbsp;Installation</span><br />
<span style="opacity: 0.75; font-size: 12px;">1. Tech environment check -> 2. Permissions -> 3. DB creation and connection -> 4. Done</span>
<br /><br />

<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$DIR_CONST = '';
if (defined('__DIR__'))
	$DIR_CONST = __DIR__;
else
	$DIR_CONST = dirname(__FILE__);

$CONFIG_FILE = $DIR_CONST . '/_config/config.envs.php';

//CHECK TECH ENVIRONMENT
if (PHP_MAJOR_VERSION < 5) {
	echo "<span style=\"color: #b30000\">Php version is outdated! Software requires PHP > 5.0. Please, update</span>"; die();
}

//CHECK FOLDER PERMISSIONS
if (!is_writable($CONFIG_FILE)) {
	echo "<span style=\"color: #b30000\">Main configuration file is not writable. Please set the permissions</span><br />";
	echo "HINT filesystem: chmod 777 /_config/config.envs.php" . "<br />";
	echo "HINT owners: user/group: chown user:group /_config/config.envs.php" . "<br />";
	echo "After installation it is suggested to put the permissions back to 755. As this configuration is a single process.";
	die();
}

if (!is_writable($DIR_CONST . '/uploads')) {
	echo "<span style=\"color: #b30000\">Uploads folder is not writable. Please set recursive permissions for \"/uploads\" folder </span><br />";
	echo "HINT filesystem: chmod -R 777 /uploads" . "<br />";
	echo "HINT owners: chown -R user:group /uploads";
	die();
}

if (!is_writable($DIR_CONST . '/_cache') 
	|| !is_writable($DIR_CONST . '/_tpl/default/_cache') || !is_writable($DIR_CONST . '/sjs-admin/_tpl/_cache')) {
	echo "<span style=\"color: #b30000\">Cache folder is not writable. Please set recursive permissions for \"/_cache\", \"/_tpl/default/_cache\" and  \"/sjs-admin/_tpl/_cache\"  folders </span><br />";
	echo "HINT filesystem: chmod -R 777 /folder" . "<br />";
	echo "HINT owners: chown -R user:group /folder";
	die();
}

if (!is_writable($DIR_CONST . '/blog/content')) {
	echo "<span style=\"color: #b30000\">Blog content folder is not writable. Please set recursive permissions for \"/blog/content\" folder </span><br />";
	echo "HINT filesystem: chmod -R 777 /blog/content" . "<br />";
	echo "HINT owners: chown -R user:group /blog/content";
	die();
}

$step = 1;

if (isset($_POST['url']) && isset($_POST['host'])  && isset($_POST['port']) && isset($_POST['username']) 
	&& isset($_POST['password']) && isset($_POST['db_name'])) {

	$url = preg_replace( '/[^a-zA-Z0-9:_\.\-\/]/', '', $_POST['url']  );

	$host = $_POST['host'];
	$port = $_POST['port'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$dbname = $_POST['db_name'];

	//test here the connection, if OK, write to config
	require_once('_lib/class.Installer.php');
	$install = new Installer();
	$result = $install->CheckMySQLiInterface($host, $dbname, $username, $password, $port);

	if (!$result) {
		echo "<pre>" . $install->GetLastError() . "</pre>";
		echo "<span style=\"color: #b30000\">Mysqli extension is not installed. Please make installation of this. For any problems please try to see FAQ and Documentation at simplejobscript.com</span>";
		die();
	} 
	
	//check Mysql version
	$ver = $install->GetMysqlVersion();

	if (strpos($ver, '.') !== false) {

		if (intval(substr($ver, 0, strpos($ver, '.'))) < 4) {
			echo "<br /><span style=\"color: #b30000\">You have entered invalid DB connection details or Mysqli is outdated. Try to update it and make sure DB entries exist. Then try again navigating to homepage.</span><br /><br />"; die();
		} else {
			echo "<span style=\"color: #2d862d\">Database connection has been set up successfully. Details are stored in \"_config/config.envs.php\" file. If you need to change settings again, manually edit this file on server. If database import did not run, import it manually from the \"db\" folder.</span> <br /><br />"; 
		}	

	} else {

		if (intval(substr($ver, 0, 1)) < 4) {
			echo "<br /><span style=\"color: #b30000\">You have entered invalid DB connection details or Mysqli is outdated. Try to update it and make sure DB entries exist. Then try again navigating to homepage.</span><br /><br />"; die();
		} else {
			echo "<span style=\"color: #2d862d\">Database connection has been set up successfully. Details are stored in \"_config/config.envs.php\" file. If you need to change settings again, manually edit this file on server. If database import did not run, import it manually from the \"db\" folder.</span> <br /><br />"; 
		}	
	}
	
    // mysql is ok, lets change the default URLS
    $db = $install->getDb();

    $selectDbResult = $db->select_db($dbname);

	$dbFile = $DIR_CONST . '/db/simplejobscript_default.sql';

	$templine = '';
	// Read in entire file
	$lines = file($dbFile); 
	// Loop through each line
	foreach ($lines as $line)
	{
		// Skip it if it's a comment
		if (substr($line, 0, 2) == '--' || $line == '')
		    continue;

		// Add this line to the current segment
		$templine .= $line;
		// If it has a semicolon at the end, it's the end of the query
		if (substr(trim($line), -1, 1) == ';')
		{
		    // Perform the query
		    $db->query($templine);
		    // Reset temp variable to empty
		    $templine = '';
		}
	}

    $sql = 'UPDATE settings SET value = "' . $url . '" WHERE name = "site_name"';
	$db->query($sql);

	$sql = 'UPDATE pages SET external_url = "http://' . $url . "/blog" . '" WHERE id = 40';
	$db->query($sql);

	$sql = 'UPDATE pages SET external_url = "http://' . $url . "/feed" . '" WHERE id = 41';
	$db->query($sql);

	//config
	$str = file_get_contents($CONFIG_FILE);

	$str = str_replace("{DB_URL}", $url, $str);
	$str = str_replace("{DB_HOST}", $host, $str);
	$str = str_replace("{DB_PORT}", $port, $str);
	$str = str_replace("{DB_USER}", $username, $str);
	$str = str_replace("{DB_PASSWORD}", $password, $str);
	$str = str_replace("{DB_NAME}", $dbname, $str);

	file_put_contents($CONFIG_FILE, $str);

	echo "<h2>INSTALLATION  COMPLETED SUCCESSFULLY!</h2>";
	echo "<span>Visit the <a href=\"/\" target=\"_blank\">job board</a> homepage, manage content in the <a href=\"/sjs-admin\" target=\"_blank\">admin section</a> or manage the <a href=\"/blog/admin.php\" target=\"_blank\">blog</a>. For access use \"admin/admin\" login credentials.</span>";
	exit;

	$step = 2;
}

if ($step == 1) {
?>

	<label style="color: #00b386;">Environment is set up correctly. Create new database for this project and put connection details below:</label><br /><br />
	<form name="install_form" method="post" action="installer.php" role="form" style="width: 420px; ">
	<fieldset style="border: solid 1px #d9d9d9; padding: 10px;">
		App Url: &nbsp;<input style="float: right;font-size: 12px; padding: 4px;" type="text" name="url" value="example.com" required /><br /><br />
		Database host: &nbsp;<input style="float: right;font-size: 12px; padding: 4px;" type="text" name="host" value="127.0.0.1" required /><br /><br />
		Database port: &nbsp;<input style="float: right;font-size: 12px; padding: 4px;" type="text" name="port" value="3306" required /><br /><br />
		Database username: &nbsp;<input style="float: right;font-size: 12px; padding: 4px;" name="username" type="text" required /><br /><br />
		Database password: &nbsp;<input style="float: right;font-size: 12px; padding: 4px;" name="password" type="password" required /><br /><br />
		Database name (should exist): &nbsp;<input style="float: right;font-size: 12px; padding: 4px;" name="db_name" type="text" required /><br /><br />
		<input style="width: 80px; height: 30px;" type="submit" name="submit" id="submit" value="Save" />
	</fieldset>
	</form>
<?php } else { ?>

DB import

<?php } ?>


</div>

