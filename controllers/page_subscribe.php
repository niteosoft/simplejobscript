<?php

	$cats = get_categories();

	if (!empty($_POST))
	{
		$cats_final = "";
		$numItems = count($cats);
		$i = 0;
		foreach ($cats as $c) {
			if (isset($_POST['cat' . $c['id']])) {
				if(++$i === $numItems) {
				    $cats_final .= $c['id'];
				} else 
					$cats_final .= $c['id'] . ',';
			}

		}
		//single element caused troubles
		if (substr($cats_final, -1) == ',') {
			$cats_final = rtrim($cats_final, ",");
		}

		if (!empty($cats_final)) {
			//get email
			$email = filter_var($_POST['subscribe-email'], FILTER_VALIDATE_EMAIL);

			//update user and send him confirmation
			$class = new Subscriber($email, $cats_final, true, true);
			//return success
		}
		$smarty->assign('success',true);

	}

	$smarty->assign('cats', $cats);

	$template = 'subscription/subscribe.tpl';

?>
