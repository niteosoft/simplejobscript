<?php

	$captcha_enabled = ENABLE_RECAPTCHA;
	if ($captcha_enabled) {
		$pattern = "1234567890abcdefghijklmnopqrstuvwxyz";
		$token  = "";	
	}
	$smarty->assign('ENABLE_RECAPTCHA', $captcha_enabled);

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

	if ($captcha_enabled) {
		
		for( $i = 1; $i <= 6 ; $i++ )
		{
			$token .= $pattern{rand( 0, 35 )};
		}
		$encryptedToken = sha1( $token );

		// save the $encryptedToken in the session
		$_SESSION['encryptedToken'] = $encryptedToken;
		$rawCaptchaBytes =  base64_encode(simple_php_captcha($token));

		$the_captcha = str_replace('{RAW}', $rawCaptchaBytes, recaptcha_get_html());
		$the_captcha = str_replace('{CAPTCHA_LABEL}', $translations['captcha']['captcha_label'], $the_captcha);
		$smarty->assign('captcha_html', $the_captcha);
	}

	$smarty->assign('cats', $cats);

	$template = 'subscription/subscribe.tpl';

?>
