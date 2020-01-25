<?php 

require_once '_config/config.php';
global $db;

if (isset($_POST['cp_color'])) {

	$sql = 'UPDATE '.DB_PREFIX.'customizer SET website_color="' . $_POST['cp_color'] . '" WHERE id = 1'; 
	$result = $db->query($sql);
	clear_main_cache();
	exit;
}
exit;

?>