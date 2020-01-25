<?php 

$smarty->assign('ACTIVE', 68);

if (strcmp(SIMPLEJOBSCRIPT_PRODUCT, "full") == 0) {

	$SITE_URL = MAIN_URL; 

	$url = '';
	if (strpos($SITE_URL, "http://") !== false)
		$url = substr($SITE_URL, 7, strlen($SITE_URL) - 1);
	else if (strpos($SITE_URL, "https://") !== false)
		$url = substr($SITE_URL, 8, strlen($SITE_URL) - 1);
	else if (strpos($SITE_URL, "www.") !== false)
		$url = substr($SITE_URL, 4, strlen($SITE_URL) - 1);
	else
		$url = $SITE_URL;

	$smarty->assign('PR_VERSION', 'SJS ' . '&nbsp;&nbsp;' .SIMPLEJOBSCRIPT_VERSION . ' &nbsp;-&nbsp; Complete');

	// check the license key
	$sql = 'SELECT value as license_key FROM license';
    $result = $db->query($sql);
    $row = $result->fetch_assoc();

    // ****************************************************************
    if (intval($result->num_rows) > 0 && $row['license_key'] != NULL) {
    	$smarty->assign('LICENSE_EXISTS', '1');
    	//License key is set
    	$LICENSE_KEY = $row['license_key'];
    	$smarty->assign('LICENSE_KEY', $LICENSE_KEY);

		try {

			$smarty->assign('LICENSE_ERR_STATUS', '0');

			$updater = new Updater($LICENSE_KEY, $url);
			$url_ld = $updater->getUrl('check_license');
			$url_vd = $updater->getUrl('get_version');

			// LICENSE DATA
			$ld = json_decode(requestSjsApi($url_ld));

			if ($ld->license_limit > 1) {
				$smarty->assign('MULTI_LICENSE', 'true');
				$smarty->assign('MULTI_LICENSE_ACTIVATIONS_LEFT', $ld->activations_left);

				if ($ld->activations_left == 1)
					$smarty->assign('SINGULAR_FLAG', 'true');

				$smarty->assign('MULTI_LICENSE_LICENSE_LIMIT', $ld->license_limit);
			}


			if ($ld) {
				switch ($ld->license) {
					case 'valid':
						$smarty->assign('LS', '1');
						break;
					case 'inactive':
						$smarty->assign('LS', '0');
						$smarty->assign('RENEW_BTN', 'true');
						$smarty->assign('RENEW_URL', $updater->getRenewUrl());
						break;
					case 'expired':
						$smarty->assign('LS', '2');
						$smarty->assign('RENEW_BTN', 'true');
						$smarty->assign('RENEW_URL', $updater->getRenewUrl());
						break;
					case 'site_inactive':
						$smarty->assign('LS', '3');
						break;
					
					default:
						break;
				}	
			} else {
				$smarty->assign('LICENSE_ERR_STATUS', '1');
				$smarty->assign('LICENSE_ERR', 'Could not verify the license key. Please check your internet connection');
			}

			if (!$ld->success) {
				$smarty->assign('LICENSE_ERR', 'License key seems to be: ' . $ld->license);
				$smarty->assign('LICENSE_ERR_STATUS', '1');
			}

			// VERSION DATA
			$vd = json_decode(requestSjsApi($url_vd));
			$exp_date = explode(" ", $ld->expires);
			$smarty->assign('l_expiry', $exp_date[0]);

			if (SIMPLEJOBSCRIPT_VERSION != $vd->new_version) {

				$url_update = $updater->getUpdateUrl($LICENSE_KEY, $url);
				$smarty->assign('VERSION_UPDATE_URL', $url_update);
			} 

			$smarty->assign('license_data', $ld);
			$smarty->assign('version_data', $vd);

		    }  catch (Exception $e) {
				var_dump('An error of:' . $e->getMessage() . ' ocurred when fetching the product status');
			}
	}
    // ****************************************************************
     else {
     	// License key needs to be added
     	$smarty->assign('LICENSE_EXISTS', '0');

     	if (!empty($id) && $id == "activation") {
			if (isset($_POST['license_key'])) {
				escape($_POST);

				$updater = new Updater($license_key, $url);
				$url_activate = $updater->getUrl('activate_license');

				// LICENSE DATA
				$response = json_decode(requestSjsApi($url_activate));

				if ($response->success) {

					// save the correct key
					$sql = 'INSERT INTO '.DB_PREFIX.'license (value) VALUES ("' . $license_key . '")';
					$db->query($sql);

					$smarty->assign('license_added_popup', true);
					$smarty->assign('populate_lk', $license_key);
				} else {
					$smarty->assign('err_msg', 'License activation failed to complete. Your key seems to be not valid.');
				}

			}
		} 
    	
    }
    // ****************************************************************
	
} else {
	$smarty->assign('PR_VERSION', 'SJS ' . '&nbsp;&nbsp;' .SIMPLEJOBSCRIPT_VERSION . ' &nbsp;-&nbsp; Base (free)');
}

$template = 'updates.tpl';

?>