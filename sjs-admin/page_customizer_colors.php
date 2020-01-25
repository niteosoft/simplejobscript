<?php 

global $db;

$sql = 'SELECT website_color FROM '.DB_PREFIX.'customizer WHERE id=1';
$result = $db->query($sql);
$row = $result->fetch_assoc();
$smarty->assign('active_color', $row['website_color']);

$template = 'customizer-colors.tpl';

?>