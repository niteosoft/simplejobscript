<?php
	
	global $db;

	// Check if a valid category id is given
	$settings_category_id = $sjs_settings->GetSettingsCategoryIdByVarname($id);
	
	// Get setting names from a category OR show available categories
	if (isset($settings_category_id) && is_numeric($settings_category_id))
	{
		$settings_form = $sjs_settings->GetSettingsByCategory($settings_category_id, true);
		$smarty->assign('category_name', $sjs_settings->GetSettingsCategoryNameById($settings_category_id));
		$smarty->assign('settings_form', $settings_form);
	}
	else 
	{
		//$smarty->assign('settings_categories', $sjs_settings->GetSettingsCategories());
	}

	// Process a form (if given) to save the settings
	if (!empty($_POST))
	{
		escape($_POST);
		
		$fv = new FormValidator();
		$setting_array = array();

		// Looping all given fields and values
		foreach ($settings_form as $setting)
		{

			// if a file was uploaded for this setting, add it in the db (extradata field)
			$sn = $setting['name'];
			if (isset($_FILES) && isset($_FILES[$sn]) && file_exists($_FILES[$sn]['tmp_name'][0]))
			{
				$fp = fopen($_FILES[$sn]['tmp_name'][0], 'r');
				$extradata = fread($fp, filesize($_FILES[$sn]['tmp_name'][0]));
				$extradata = addslashes($extradata);
				fclose($fp);
			}

			$DIR_CONST = '';
			if (defined('__DIR__'))
				$DIR_CONST = __DIR__;
			else
				$DIR_CONST = dirname(__FILE__);

			////////////////////////////// WEBSITE LOGO ------------------------------------
			if (!empty($_FILES["site_logo_pathFile"]['tmp_name']) && $setting['name'] == 'site_logo_path') {

				try {
					$manipulator = new ImageManipulator($_FILES['site_logo_pathFile']['tmp_name']);

					$size = getimagesize($_FILES["site_logo_pathFile"]['tmp_name']);
					$fileType = $size[2];
					if ($size[0] > 285) {
						//needs a resize
				        $newImage = $manipulator->resample(285, 285);		        
					}
					$final_path = $DIR_CONST . '/../uploads/logos/'  . $_FILES['site_logo_pathFile']['name'];
					$db_file_path = 'uploads/logos/' . $_FILES['site_logo_pathFile']['name'];
					$manipulator->save($final_path, $fileType);

				} catch (Exception $e) {
					var_dump($e);
				}
				$GLOBALS[$setting['name']] = $db_file_path;
			}

			////////////////////////////// DEFAULT COMPANY LOGO ------------------------------------
			if (!empty($_FILES["default_logo_pathFile"]['tmp_name']) && $setting['name'] == 'default_logo_path') {

				try {
					$manipulator = new ImageManipulator($_FILES['default_logo_pathFile']['tmp_name']);

					$size = getimagesize($_FILES["default_logo_pathFile"]['tmp_name']);
					$fileType = $size[2];
					if ($size[0] > 285) {
						//needs a resize
				        $newImage = $manipulator->resample(285, 285);		        
					}
					$final_path = $DIR_CONST . '/../uploads/logos/'  . $_FILES['default_logo_pathFile']['name'];
					$db_file_path = 'uploads/logos/' . $_FILES['default_logo_pathFile']['name'];
					$manipulator->save($final_path, $fileType);

				} catch (Exception $e) {
					var_dump($e);
				}
				$GLOBALS[$setting['name']] = $db_file_path;
			}

			////////////////////////////// INVOICES LOGO ------------------------------------
			if (!empty($_FILES["invoice_logo_pathFile"]['tmp_name']) && $setting['name'] == 'invoice_logo_path') {

				try {
					$manipulator = new ImageManipulator($_FILES['invoice_logo_pathFile']['tmp_name']);

					$size = getimagesize($_FILES["invoice_logo_pathFile"]['tmp_name']);
					$fileType = $size[2];
					if ($size[0] > 285) {
						//needs a resize
				        $newImage = $manipulator->resample(285, 285);		        
					}
					$final_path = $DIR_CONST . '/../uploads/logos/'  . $_FILES['invoice_logo_pathFile']['name'];
					$db_file_path = 'uploads/logos/' . $_FILES['invoice_logo_pathFile']['name'];
					$manipulator->save($final_path, $fileType);

				} catch (Exception $e) {
					var_dump($e);
				}
				$GLOBALS[$setting['name']] = $db_file_path;
			}

			// If field value is an array, convert it to a string for DB storage
			if (isset($GLOBALS[$setting['name']]) && is_array($GLOBALS[$setting['name']]))
			{
				$a = 0; 
				$new_value = '';
				$count = count($GLOBALS[$setting['name']]);
				while ($a < $count)
				{
					if ($GLOBALS[$setting['name']][$a] != '_hidden' && $new_value == '') 
					{
						$new_value .= $GLOBALS[$setting['name']][$a];
					}
					elseif ($GLOBALS[$setting['name']][$a] != '_hidden' ) 
					{
						$new_value .= '|' . $GLOBALS[$setting['name']][$a];
					}
					$a++;
				}

				$GLOBALS[$setting['name']] = $new_value;
			}
			
			// Validate the fields if needed
			if (!empty($setting['validation']))
			{
				$count = count($setting['validation']);
				$a = 0; while($a < $count)
				{
					if ($setting['validation'][$a] == 'not_empty')
						$fv->isEmpty($setting['name']);
					if ($setting['validation'][$a] == 'is_number' || $setting['data_type'][$a] == 'integer')
						$fv->isNumber($setting['name']);
					if ($setting['validation'][$a] == 'is_url_string')
						$fv->isUrlString($setting['name']);
					if ($setting['validation'][$a] == 'is_email')
						$fv->isEmailAddress($setting['name']);
					$a++;
				}
			}
			if ($setting['data_type'] == 'integer') 
			{
				$fv->isNumber($setting['name']);
			}

			$setting_array[] = array('name'=> $setting['name'], 'value' => (isset($GLOBALS[$setting['name']]) ? $GLOBALS[$setting['name']] : null), 'extradata' => (isset($extradata) ? $extradata : ''));
			$extradata = '';
		}
		
		if ($fv->isError())
		{
			// Give the fields their changed input, so the user doesn't need to type it in again
			foreach ($settings_form as $setting)
			{

				if ($setting['input_type'] == 'checkbox')
				{
					$new_value = explode('|', $GLOBALS[$setting['name']]);
					$settings_form[$setting['name']]['value'] = $new_value;
				}
				else
				{
					$settings_form[$setting['name']]['value'] = $GLOBALS[$setting['name']];
				}
			}

			// Assign error list to SMARTY and load template
			$errors = $fv->getErrorList();
			$smarty->assign('errors', $errors);
			$smarty->assign('settings_form', $settings_form);
			$template = 'settings.tpl';
		}
		else
		{

			$sjs_settings->UpdateSettings($setting_array);
		
			// cache clearing -----------------------------------------------------------------
			$DIR_CONST = '';
			if (defined('__DIR__'))
			    $DIR_CONST = __DIR__;
			else
			    $DIR_CONST = dirname(__FILE__);

			//delete website templates
			$path = $DIR_CONST . '/../_tpl/' . $settings['theme']. '/_cache/';

			if ($handle = opendir(  $path ))
			{
			    while (false !== ($file = readdir($handle)))
			    {
					if ($file != '.' && $file != '..' && $file != '.gitignore') {
					  if( is_file( $path . $file) )
			            {
			                unlink($path . $file);
			            }
					}
			    }
			    closedir($handle);
			}

			//delete settings from db cache
			$target = $DIR_CONST . '/../_cache/';

			if ($handle = opendir(  $target ))
			{
			    while (false !== ($file = readdir($handle)))
			    {
				  if( is_file( $target . $file) )
			        {
			            unlink($target . $file);
			        }
			    }
			    closedir($handle);
			}
			clear_admin_cache();
			// cache clearing END -----------------------------------------------------------------

			redirect_to(BASE_URL.'settings/'. $id . '/');
		}
	} 

	$smarty->assign('current_category', 'settings');
	$template = 'settings.tpl';
	
?>
