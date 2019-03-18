<?php
	$companies = array();
	$sql = 'SELECT DISTINCT company FROM '.DB_PREFIX.'jobs ORDER BY company ASC';
	$result = $db->query($sql);

	$comps = array();
	while ($row = $result->fetch_assoc()) {
		$companies[] = $row['company'];
	}

	echo json_encode($companies);
	exit;
?>
