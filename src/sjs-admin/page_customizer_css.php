<?php 

	global $db;

	if (isset($_POST['cssarea'])) {

		escape($_POST);
	
		$sql = 'UPDATE '.DB_PREFIX.'customizer SET custom_css="' . $cssarea . '" WHERE id=1';
		$result = $db->query($sql);
		$smarty->assign('updated', true);

		clear_tpl_cache_admin('default');
		clear_main_cache();

	}

	$sql = 'SELECT custom_css FROM '.DB_PREFIX.'customizer WHERE id=1';
	$result = $db->query($sql);
	$row = $result->fetch_assoc();
	$smarty->assign('data', $row['custom_css']);

	$template = 'customizer-css.tpl';
?>