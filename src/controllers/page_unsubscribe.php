<?php

	//assign additional content
	//require_once 'page_more_content.php';

	//yes i wanto to unsubscribe
	if (isset($_POST['unsubscribe'])) {
		$result = Subscriber::unsubscribe($_POST['unsubscribe']);
		if ($result)
			$smarty->assign('success', true);
		else
			$smarty->assign('fail', true);
	}
	$smarty->assign('auth', $id);
	$template = 'subscription/unsubscribe.tpl';

?>