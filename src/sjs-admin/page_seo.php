<?php 

$smarty->assign('ACTIVE', 11);
$HOMEPAGE = "1";
global $db;

if ($id != "") {

		if ($extra != "" && $extra == "update"){

			if (isset($_POST)) {
				foreach ($_POST as $key => $value) {
					try {
						$sql = 'UPDATE '.DB_PREFIX.'seo SET `value` = "' .  $value . '" WHERE `key` = "' . $key . '"';
						$db->query($sql);
					} catch (Exception $e) {
						var_dump($e);
					}
				}	
				clear_main_cache();
			}
		}
	
		$sql = 'SELECT * FROM '.DB_PREFIX.'seo WHERE category_id = ' . $id .' ORDER BY category_id ASC';
		$result = $db->query($sql);
		
		$fields = array();

		while ($row = $result->fetch_assoc())
		{
			$title = str_replace("_", " ", $row['key']);
			$fields[$row['key']] = array($row['key'], $row['value'], $row['description'], $title);
		}

		$smarty->assign('fields', $fields);
		$smarty->assign('CURRENT_ID', $id);
		$template = 'seo-edit.tpl';return;
}

$template = 'seo.tpl';

?>