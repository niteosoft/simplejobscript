<?php 

global $db;

if ($id == 'delete') {
	$sql = 'DELETE FROM '.DB_PREFIX.'news WHERE id = ' . intval($extra);
	$result = $db->query($sql);
	sleep(0.1);
} else if ($id == 'add') {
	if (isset($_POST['msg'])) {
		escape($_POST);
		$sql = 'INSERT INTO '.DB_PREFIX.'news (date, message) VALUES (NOW(), "' . $msg . '")';
		$result = $db->query($sql);
		sleep(0.3);
	}
}

$sql = 'SELECT UNIX_TIMESTAMP(date) as date_formated, message, id  FROM '.DB_PREFIX.'news';
$result = $db->query($sql);
$news = array();

while ($row = $result->fetch_assoc())
{
	$row['date_formated'] = date(DATE_FORMAT, floatval(stripslashes($row['date_formated'])));
	$news[] = $row;
}

$smarty->assign('news', $news);
$smarty->assign('count', count($news));
$template = 'news.tpl';

?>
