<?php 

global $db;

$smarty->assign('editor', true);
$smarty->assign('ACTIVE', 50);

if ($id === "candidates") {

	if (isset($_POST['apply_email'])) {

		escape($_POST);

		// CV
		if (!empty($_FILES["cv"]['tmp_name'])) {

			$f = pathinfo($_FILES['cv']['name']);
			$basefilename = $f['filename'] . '_' . uniqid();
			$filename = $basefilename . '.' . $f['extension'];
			$suffix = 0;
			while (file_exists(FILE_UPLOAD_DIR . $filename)) {
				$suffix++;
				$filename = $basefilename . '_' . $suffix . '.' . $f['extension'];
			}

			if (move_uploaded_file($_FILES['cv']['tmp_name'], '../' . FILE_UPLOAD_DIR . $filename))
			{
				$cv_path = FILE_UPLOAD_DIR . $filename;
			}
			else
			{
				$cv_path = '';
			}

			if (!empty($_FILES['cv']['error'])) {
				$cv_path = '';
			}

		} else {
			$cv_path = '';
		}

		// URL
		$url = '';
		if (strpos($portfolio, "http://") !== false)
			$url = substr($portfolio, 7, strlen($portfolio) - 1);
		else if (strpos($portfolio, "https://") !== false)
			$url = substr($portfolio, 8, strlen($portfolio) - 1);
		else if (strpos($portfolio, "www.") !== false)
			$url = substr($portfolio, 4, strlen($portfolio) - 1);
		else
			$url = $portfolio;

		$password = md5($pass1);
		$skills = tagglesToString($taggles);
		$public_profile = 1;

		$sm_links = array();

		if (isset($sm_url_1) && $sm_url_1 != "") {
			$obj1 = constructSMlink($sm_url_1, $sm_select_1);
			$sm_links["first"] = $obj1;
		} else {
			$sm_links["first"] = "-";
		}

		if (isset($sm_url_2) && $sm_url_2 != "") {
			$obj2 = constructSMlink($sm_url_2, $sm_select_2);
			$sm_links["second"] = $obj2;
		} else {
			$sm_links["second"] = "-";
		}

		if (isset($sm_url_3) && $sm_url_3 != "") {
			$obj3 = constructSMlink($sm_url_3, $sm_select_3);
			$sm_links["third"] = $obj3;
		} else {
			$sm_links["third"] = "-";
		}

		if (isset($sm_url_4) && $sm_url_4 != "") {
			$obj4 = constructSMlink($sm_url_4, $sm_select_4);
			$sm_links["fourth"] = $obj4;
		} else {
			$sm_links["fourth"] = "-";
		}

		$data = array(
			"name" => $apply_name,
			"occupation" => $occupation,
			"email" => $apply_email,
			"phone" => $apply_phone,
			"location" => $apply_location,
			"message" => stripLineBreaks($apply_msg), 
			"website" => $url,
			"skills" => $skills,
			"cv_path" => $cv_path,
			"public_profile" => $public_profile,
			"password" => $password,
			"sm_links" => $sm_links
		);	

		// create profile
		$class = new Applicant();
		$res = $class->createCandidateProfileFromAdmin($data);
		if ($res)	
			$smarty->assign('CANDIDATE_ADDED', true);

	}

	$sm_profiles = $job->getSMprofiles();
	$smarty->assign('SM_PROFILES', $sm_profiles);

	$smarty->assign('LOAD_TAGL', true);
	$smarty->assign('TAGL_INIT_ADD_JOBSEEKERS', true);
	$hint = str_replace("{SIZE}", formatBytes(MAX_CV_SIZE), $translations['apply']['cv_hint']);
	$smarty->assign('MAX_CV_SIZE', MAX_CV_SIZE);
	$smarty->assign('cv_hint', $hint);
	$template = 'feeder-jobseekers.tpl';
	return;
} else if ($id === "employers") {

	if (isset($_POST['register_name'])) {
				$class = new Employer();
				$ip = get_client_ip();

				$name = $db->getConnection()->real_escape_string(trim($_POST['register_name']));
				$email = $db->getConnection()->real_escape_string(trim($_POST['register_email']));
				$password = md5(trim($_POST['register_pass1']));

				$data = array('name' => $name, 'email' => $email, 'password' => $password,
				'confirmed' => 1, 'ip' => $ip);

				$EMP_ID = $class->createEntryFromAdmin($data);

				if (!empty($_FILES["company_logo"]['tmp_name'])) {
					$newNamePrefix = time() . '_';
					$manipulator = new ImageManipulator($_FILES['company_logo']['tmp_name']);

					$size = getimagesize($_FILES["company_logo"]['tmp_name']);
					$fileType = $size[2];
					if ($size[0] > 200) {
						//needs a resize
				        $newImage = $manipulator->resample(200, 200);		        
					}
					$final_path = COMPANIES_UPLOAD_FOLDER . $newNamePrefix . $_FILES['company_logo']['name'];
					$manipulator->save('../' . $final_path, $fileType);
				} else {
					$final_path = DEFAULT_LOGO_PATH;
				}

				//also if error use default image
				if (!empty($_FILES['company_logo']['error'])) {
					$final_path = DEFAULT_LOGO_PATH;
				}

				escape($_POST);
				$EMPLOYER_ID = $EMP_ID;
				$company = new Company();

				$data = array('company_name' => $company_name, 'company_desc' => $db->getConnection()->real_escape_string($_POST['company_desc']), 
						  'company_hq' => $company_hq,  'company_url' => $company_url, 
						   'employer_id' => $EMPLOYER_ID, 'logo_path' => $final_path, 'company_street' => $company_street,
						   'company_citypostcode' => $company_citypostcode);
		
				$company->createCompany($data);
				$smarty->assign('COMPANY_ADDED', true);

	}

	$template = 'feeder-employers.tpl';
	return;
} else if ($id === "jobs") {

	$job = new Job();
	$class = new Company();
	$data = $class->getAdminCompanyData();

	if (isset($_POST['title'])) {
		escape($_POST);
		$companyData = $data;

		if (REMOTE_PORTAL == 'deactivated')
			$city_id = intval($location_select);
		else
			$city_id = 1;

		$apply_online = (isset($apply_online_switch)) ? 1 : 0;

		$spotlight = intval($premium_select);

		$emp = new Employer();
		$package_data = $emp->getEmployerAccount($data['employer_id']);

		$HOW_TO_APPLY = $db->getConnection()->real_escape_string($_POST['howtoapply']);
		
		if (strpos($HOW_TO_APPLY, "http://") !== false)
			$HOW_TO_APPLY = substr($HOW_TO_APPLY, 7, strlen($HOW_TO_APPLY) - 1);
		else if (strpos($HOW_TO_APPLY, "https://") !== false)
			$HOW_TO_APPLY = substr($HOW_TO_APPLY, 8, strlen($HOW_TO_APPLY) - 1);
		else if (strpos($HOW_TO_APPLY, "www.") !== false)
			$HOW_TO_APPLY = substr($HOW_TO_APPLY, 4, strlen($HOW_TO_APPLY) - 1);

		$data = array(
			"type_id" => intval($type_select),
			"employer_id" => intval($data['employer_id']),
			"category_id" => intval($cat_select),
			"title" => $title,
			"spotlight" => $spotlight,
			"salary" => $salary,
			"description" => $db->getConnection()->real_escape_string($_POST['description']), //keed the tinymce characters. replaceTinyMceBreaks(
			"is_active" => 1,
			"city_id" => $city_id,
			"apply_online" => $apply_online,
			"apply_desc" => $HOW_TO_APPLY,
			"company" => $data["company_name"],
			"job_period" => $package_data['job_period'],
			"is_tmp" => "0"
		);

		$result = $job->Create($data);
		clear_main_cache();
		$smarty->assign('JOB_ADDED', true);
	}

	$cats = $job->getCategoriesWithIds();
	$job_types = $job->getJobTypesWithIds();
	$cities = $job->getCitiesWithId();

	$smarty->assign('cities', $cities);
	$smarty->assign('cats', $cats);
	$smarty->assign('types', $job_types);

	$smarty->assign('DATA', $data);
	if (empty($data) || $data == NULL) {
		$smarty->assign('EMP_MISSING_ERR', true);
	}

	$template = 'feeder-jobs.tpl';
	return;
} else if ($id === "import") {

		global $db;

		$base = log(MAX_LOCATIONS_IMPORT_FILE_SIZE, 1024);
		$suffixes = array('', 'KB', 'MB', 'GB', 'TB');   
		$fSize = round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
		
		$smarty->assign('MAX_FILE_SIZE', MAX_LOCATIONS_IMPORT_FILE_SIZE);
		$smarty->assign('MAX_FILE_SIZE_TEXT', $fSize);

		$smarty->assign('ERR_IMPORT', false);

		if (!empty($_FILES["cv"]['tmp_name'])) {
			$err = false;
			$job = new Job();
			$class = new Company();

			$data = array();
			$index = 0;
			$i = 0;
			// parse the document
			try {
				$csv = array_map('str_getcsv', file($_FILES['cv']['tmp_name']));

				if (count($csv) > 20000) {
					var_dump("Too many jobs for import at once. Please upload at once no more than 20 000 jobs. If you need more, split these into multiple imports.");
					die();
				}

				foreach ($csv as $line) {

					// skip formating desc columns
					$index++;
					if ($index == 1)
						continue;

					foreach ($line as $entry) {
						$i++;

						if ($entry != "")
							array_push($data, trim($entry));

							if ($i % 6 == 0) {
		
								    // import job
									$title = $data[0];
									$description = $db->getConnection()->real_escape_string($data[1]);

									// import location

									$sql = "SELECT id as 'location_id' FROM cities WHERE name like '%" . $data[2] . "%'";
									$row = $db->query($sql);

									if (intval($row->num_rows) > 0) {
										// location exists, get id
										$res = $row->fetch_assoc();
										$location_id = $res['location_id'];
									} else {
										// location does not exist, create it and get id
										$locationPerma = strtolower(str_replace(' ', '-', $data[2]));
										$sql = "INSERT INTO cities(name, ascii_name) VALUES ('" . $data[2] . "', '" . $locationPerma . "')";
										$row = $db->query($sql);

										if ($row)
											$location_id = $db->getConnection()->insert_id;
										else
											$location_id = 112; // if import goes wrong, set default location to Georgia

									}

									// import employer
									$sql = "SELECT id as 'employer_id' FROM employer WHERE email like '%" . $data[5] . "%'";
									$row = $db->query($sql);

									if (intval($row->num_rows) > 0) {
										$res = $row->fetch_assoc();
										$employer_id = $res['employer_id'];
									} else {
										// HDA jobs default account
										$employer_id = 144;

									}

									// company
									$sql = "SELECT name as 'company_name' FROM company WHERE employer_id =" . $employer_id;
									$row = $db->query($sql);

									if (intval($row->num_rows) > 0) {
										$res = $row->fetch_assoc();
										$comp_name = $res['company_name'];
									} else {
										$comp_name = "HDA MD Staff";
									}

									// category
									$sql = "SELECT id as 'category_id' FROM categories WHERE name like '%" . $data[3] . "%'";
									$row = $db->query($sql);

									if (intval($row->num_rows) > 0) {
										$res = $row->fetch_assoc();
										$cat_id = $res['category_id'];
									} else {
										// HDA jobs default account
										$catPerma = strtolower(str_replace(' ', '-', $data[3]));
										$sql = "INSERT INTO categories(name, var_name, title, description, keywords, category_order) VALUES ('" . $data[3] . "', '" . $catPerma . "', '" . $data[3] . "',
											'" . $data[3] . "', '" . $data[3] . "', 1)";
										$row = $db->query($sql);

										if ($row)
											$cat_id = $db->getConnection()->insert_id;
										else
											$cat_id = 116; // Other

									}


									// type
									$sql = "SELECT id as 'type_id' FROM types WHERE name like '%" . $data[4] . "%'";
									$row = $db->query($sql);

									if (intval($row->num_rows) > 0) {
										$res = $row->fetch_assoc();
										$type_id = $res['type_id'];
									} else {
										// HDA jobs default account
										$typePerma = strtolower(str_replace(' ', '-', $data[4]));
										$sql = "INSERT INTO types(name, var_name) VALUES ('" . $data[4] . "', '" . $typePerma . "')";
										$row = $db->query($sql);

										if ($row)
											$type_id = $db->getConnection()->insert_id;
										else
											$type_id = 1; // Full time

									}

									$import_data = array(
										"type_id" => intval($type_id),
										"employer_id" => intval($employer_id),
										"category_id" => intval($cat_id),
										"title" => $title,
										"spotlight" => 0,
										"salary" => "",
										"description" => $description,
										"is_active" => 1,
										"city_id" => $location_id,
										"apply_online" => 1,
										"apply_desc" => "",
										"company" => $comp_name,
										"job_period" => JOB_EXPIRES,
										"is_tmp" => "0"
									);

									$result = $job->Create($import_data);

								// clear the data array
								$data = array();

							}

					}
	
				} // end of job line


		 		$err = false;
			} catch (Exception $e) {
				$err = true;
			}

			clear_main_cache();
			$smarty->assign('IMPORT_SUCCESS', true);

		} else {
			$err = true;
		}


	$template = 'feeder-import-jobs.tpl';
	return;
}

$template = 'feeder.tpl';

?>
