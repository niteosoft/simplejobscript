<?php 

	global $db;

	if (isset($_POST['header_title'])) {

		escape($_POST);
		
		// get default bg
		$innerSQL = 'SELECT general_homepage_bgimage_path FROM customizer';
		$iq = $db->query($innerSQL);
		$ir = $iq->fetch_assoc();

		// process image
		if (!empty($_FILES["general_homepage_bgimage_path"]['tmp_name'])) {
			$newNamePrefix = time() . '_';
			$manipulator = new ImageManipulator($_FILES['general_homepage_bgimage_path']['tmp_name']);

			$size = getimagesize($_FILES["general_homepage_bgimage_path"]['tmp_name']);
			$fileType = $size[2];
			if ($size[0] > 2000) {
				//needs a resize
		        $newImage = $manipulator->resample(1800, 800);		        
			}
			$final_path = 'uploads/images/' . $newNamePrefix . $_FILES['general_homepage_bgimage_path']['name'];
			$manipulator->save('../' . $final_path, $fileType);
		} else {
			$final_path = $ir["general_homepage_bgimage_path"]; // default
		}

		if (!empty($_FILES['general_homepage_bgimage_path']['error'])) {

			$final_path = $ir["general_homepage_bgimage_path"];
		}

		// get default bg for partners
		$iii = 'SELECT partners_bgimage_path FROM customizer';
		$qqq = $db->query($iii);
		$rrr = $qqq->fetch_assoc();

		// process image
		if (!empty($_FILES["partners_bgimage_path"]['tmp_name'])) {
			$newNamePrefix = time() . '_';
			$manipulator = new ImageManipulator($_FILES['partners_bgimage_path']['tmp_name']);

			$size = getimagesize($_FILES["partners_bgimage_path"]['tmp_name']);
			$fileType = $size[2];
			if ($size[0] > 2000) {
				//needs a resize
		        $newImage = $manipulator->resample(1200, 300);		        
			}
			$partners_final_path = 'uploads/images/' . $newNamePrefix . $_FILES['partners_bgimage_path']['name'];
			$manipulator->save('../' . $partners_final_path, $fileType);
		} else {
			$partners_final_path = $rrr["partners_bgimage_path"];; // default
		}

		if (!empty($_FILES['partners_bgimage_path']['error'])) {
			$partners_final_path = $rrr["partners_bgimage_path"];;
		}

		$candidates_on_flag = (isset($candidates_on_flag)) ? 1 : 0;
		$employers_on_flag = (isset($employers_on_flag)) ? 1 : 0;
		$about_on_flag = (isset($about_on_flag)) ? 1 : 0;
		$test_on_flag = (isset($test_on_flag)) ? 1 : 0;
		$partners_on_flag = (isset($partners_on_flag)) ? 1 : 0;
		$ta_on_flag = (isset($ta_on_flag)) ? 1 : 0;
		$stats_on_flag = (isset($stats_on_flag)) ? 1 : 0;
		$listings_on_flag = (isset($listings_on_flag)) ? 1 : 0;

		$sql = 'UPDATE '.DB_PREFIX.'customizer SET 
			general_homepage_bgimage_path="' . $final_path . '",
			general_homepage_logo_w="' . $general_homepage_logo_w . '",
			general_homepage_logo_margin="' . $general_homepage_logo_margin . '",
 			header_title="' . $header_title . '",
 			header_subtitle="' . $header_subtitle . '",
 			header_what_title="' . $header_what_title . '",
 			header_what_placeholder="' . $header_what_placeholder . '",
 			header_where_title="' . $header_where_title . '",
 			header_search_btn_title="' . $header_search_btn_title . '",

			candidates_headline="' . $candidates_headline . '",
			candidates_subheadline="' . $candidates_subheadline . '",
			candidates_firstcol_headline="' . $candidates_firstcol_headline . '",
			candidates_firstcol_subheadline="' . $candidates_firstcol_subheadline . '",
			candidates_secondcol_headline="' . $candidates_secondcol_headline . '",
			candidates_secondcol_subheadline="' . $candidates_secondcol_subheadline . '",
			candidates_thirdcol_headline="' . $candidates_thirdcol_headline . '",
			candidates_thirdcol_subheadline="' . $candidates_thirdcol_subheadline . '",
			candidates_strip_headline="' . $candidates_strip_headline . '",
			candidates_strip_subheadline="' . $candidates_strip_subheadline . '",
			candidates_strip_btn_title="' . $candidates_strip_btn_title . '",
			candidates_on_flag="' . $candidates_on_flag . '",

			employers_headline="' . $employers_headline . '",
			employers_subheadline="' . $employers_subheadline . '",
			employers_firstcol_headline="' . $employers_firstcol_headline . '",
			employers_firstcol_subheadline="' . $employers_firstcol_subheadline . '",
			employers_secondcol_headline="' . $employers_secondcol_headline . '",
			employers_secondcol_subheadline="' . $employers_secondcol_subheadline . '",
			employers_thirdcol_headline="' . $employers_thirdcol_headline . '",
			employers_thirdcol_subheadline="' . $employers_thirdcol_subheadline . '",
			employers_strip_headline="' . $employers_strip_headline . '",
			employers_strip_subheadline="' . $employers_strip_subheadline . '",
			employers_strip_btn_title="' . $employers_strip_btn_title . '",
			employers_on_flag="' . $employers_on_flag . '",

			about_on_flag="' . $about_on_flag . '",
			about_headline="' . $about_headline . '",
			about_subheadline="' . $about_subheadline . '",
			about_leftcol="' . $about_leftcol . '",
			about_rightcol="' . $about_rightcol . '",
			about_readmore_btn_title="' . $about_readmore_btn_title . '",

			test_on_flag="' . $test_on_flag . '",
			test_headline="' . $test_headline . '",

			partners_on_flag="' . $partners_on_flag . '",
			partners_headline="' . $partners_headline . '",
			partners_bgimage_path="' . $partners_final_path . '",

			ta_on_flag="' . $ta_on_flag . '",
			ta_emp_headline="' . $ta_emp_headline . '",
			ta_emp_subheadline="' . $ta_emp_subheadline . '",
			ta_emp_btn_label="' . $ta_emp_btn_label . '",
			ta_can_headline="' . $ta_can_headline . '",
			ta_can_subheadline="' . $ta_can_subheadline . '",
			ta_can_btn_label="' . $ta_can_btn_label . '",

			stats_on_flag="' . $stats_on_flag . '",
			stats_headline="' . $stats_headline . '",
			stats_first_col="' . $stats_first_col . '",
			stats_sec_col="' . $stats_sec_col . '",
			stats_third_col="' . $stats_third_col . '",
			stats_fourth_col="' . $stats_fourth_col . '",
			stats_first_numb="' . $stats_first_numb . '",
			stats_second_numb="' . $stats_second_numb . '",
			stats_third_numb="' . $stats_third_numb . '",
			stats_fourth_numb="' . $stats_fourth_numb . '",

			listings_on_flag="' . $listings_on_flag . '"

 			WHERE id = 1';
		$result = $db->query($sql);
		$smarty->assign('updated', true);

	}

	$sql = 'SELECT * FROM customizer';
	$r = $db->query($sql);
	$data = $r->fetch_assoc();

	$smarty->assign('customizer_data', $data);

	$template = 'customizer-homepage.tpl';
?>