<?php
	//$id ~ hash
	$result = Subscriber::confirmSubscriber($id);
	if ($result) {
		//success
		$smarty->assign('success', true);
	} else {
		//this hash doesnt exist, show link to subscribe page
		$msg = $translations['subscriptions']['confirmed_msg_fail'];
		$msg_rep = str_replace("{URL}", BASE_URL . URL_SUBSCRIBE , $msg);

		$smarty->assign('success', false);
		$smarty->assign('msg', $msg_rep);
	}

	//assign additional content
	require_once 'page_more_content.php';

	$template = 'subscription/subscribed-confirmed.tpl';

?>