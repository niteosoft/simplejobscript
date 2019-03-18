<?php

	$captcha_enabled = ENABLE_RECAPTCHA;
	if ($captcha_enabled) {
		$pattern = "1234567890abcdefghijklmnopqrstuvwxyz";
		$token  = "";	
	}
	$smarty->assign('ENABLE_RECAPTCHA', $captcha_enabled);
	//------------------------------------------------------


	if (isset($_POST['contact_name'])) {
		$contact_name = $_POST['contact_name'];
		$contact_email = $_POST['contact_email'];
		$contact_msg = $_POST['contact_msg'];

		if ($captcha_enabled) {
			//check captcha code
			if (strcmp(sha1($_POST['captcha']), $_SESSION['encryptedToken']) == 0) {
				$smarty->assign('response_class', 'pos-feedback');
				$smarty->assign('response_msg', $translations['contact']['success_msg']); //succes msg

				//send email
				$class = new Mailer();
				$class->sendContactEmail($contact_name, $contact_email, $contact_msg);
				$smarty->assign('response', true);
			} else {
				$smarty->assign('response_msg', $translations['contact']['captcha_err']);
				$smarty->assign('response_class', 'neg-feedback');

				$smarty->assign('captcha_err', true);
				//generate new captcha and destroy old one
				unset($_SESSION['encryptedToken']);
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
		} else {
			//captcah not enabled in backoffice - send email without captcha validation
			$smarty->assign('response_class', 'pos-feedback');
			$smarty->assign('response_msg', $translations['contact']['success_msg']); //succes msg
			$smarty->assign('response', true);

			$class = new Mailer();
			$class->sendContactEmail($contact_name, $contact_email, $contact_msg);
		}	

	} else {
		
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
	}

	if ($pageData['id'] == "2" || strpos($pageData['url'], "contact") !== false) {
		$smarty->assign('INIT_GOOGLE_MAPS', 1);
	}

	// get data for pricing tables
	if ($pageData['id'] == "55") {

			$sql = 'SELECT * FROM packages';
			$result = $db->query($sql);
			$data = array();

			while ($row = $result->fetch_assoc()) {
				$row['price_formatted'] = format_currency(WEBSITE_CURRENCY, $row['price']);
				$data[] = $row;
			}

			$smarty->assign('package_data', $data);
	}

	if ($pageData['id'] != "2" && $pageData['id'] != "21" && $pageData['id'] != "19") {
		$smarty->assign('WYSIWYG_PAGE', 1);
	}

	// var_dump(htmlspecialchars_decode($pageData["content"])); die();

	$smarty->assign('page', $pageData);
	$smarty->assign('PAGE_CONTENT', htmlspecialchars_decode($pageData["content"]));
	$smarty->assign('tpl', 'static/static_' .$pageData['url'] . '.tpl');

?>
