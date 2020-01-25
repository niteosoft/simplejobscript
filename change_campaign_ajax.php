<?php 

require_once '_config/config.php';

if (isset($_POST['data'])) {

	$result = explode(":", $_POST['data']);

	global $db;
	$sql = 'UPDATE '.DB_PREFIX.'campaign
           SET active = ' . $result[1] . ' WHERE id = ' . $result[0];
	$op = $db->query($sql);

	$msg = ($result[1] == "1") ? 'Campaign activated': 'Campaign deactivated';

	if ($op) {
		echo json_encode(array('result' => '1', 'msg' => $msg));
		exit;
	}
}

echo json_encode(array('result' => '0', 'Problem with operation. Create a new campaign and delete this one'));
exit;

?>
