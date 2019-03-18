<?php 

	global $db;

	if (isset($_POST['jobs_logo_width'])) {

		escape($_POST);
		
		// get default bg
		$innerSQL = 'SELECT jobs_subheader_bg_path FROM customizer';
		$iq = $db->query($innerSQL);
		$ir = $iq->fetch_assoc();

		// process image
		if (!empty($_FILES["jobs_subheader_bg_path"]['tmp_name'])) {
			$newNamePrefix = time() . '_';
			$manipulator = new ImageManipulator($_FILES['jobs_subheader_bg_path']['tmp_name']);

			$size = getimagesize($_FILES["jobs_subheader_bg_path"]['tmp_name']);
			$fileType = $size[2];
			if ($size[0] > 2000) {
				//needs a resize
		        $newImage = $manipulator->resample(1800, 800);		        
			}
			$jobs_subheader_bg_path = 'uploads/images/' . $newNamePrefix . $_FILES['jobs_subheader_bg_path']['name'];
			$manipulator->save('../' . $jobs_subheader_bg_path, $fileType);
		} else {
			$jobs_subheader_bg_path = $ir["jobs_subheader_bg_path"]; // default
		}

		if (!empty($_FILES['jobs_subheader_bg_path']['error'])) {
			$jobs_subheader_bg_path = $ir["jobs_subheader_bg_path"];
		}

		$jobs_candidates_on_flag = (isset($jobs_candidates_on_flag)) ? 1 : 0;


		$sql = 'UPDATE '.DB_PREFIX.'customizer SET 
	
			jobs_logo_width="' . $jobs_logo_width . '",
			jobs_logo_width_mobile="' . $jobs_logo_width_mobile . '",
			jobs_logo_padding="' . $jobs_logo_padding . '",
			jobs_candidates_on_flag="' . $jobs_candidates_on_flag . '",
			jobs_subheader_bg_path="' . $jobs_subheader_bg_path . '"

 			WHERE id = 1';
		$result = $db->query($sql);

		clear_tpl_cache_admin('default');
		clear_main_cache();
		$smarty->assign('updated', true);

	}

	$sql = 'SELECT * FROM customizer';
	$r = $db->query($sql);
	$data = $r->fetch_assoc();

	$smarty->assign('customizer_data', $data);

	$template = 'customizer-jobs.tpl';
?>