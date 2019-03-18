<?php
	require_once APP_PATH . '_lib/class.CityDAO.php';

	$smarty->assign('ACTIVE', 5);

	class CitiesPage
	{
		private $template = '';
		private $smarty;
		
		private $cityDAO;
		
		public function __construct()
		{
			$this->cityDAO = CityDAO::getInstance();	
		}
			
		public function processRequest($action, $cityID, $smarty)
		{
			$this->smarty = $smarty;
			
			$this->smarty->assign('current_category', 'cities');
			
			switch ($action)
			{
				case '':
					
					$this->prepareDisplayCities();
					break;
					
				case 'prepare-add':
					
					$city = array('name' => '', 'ascii_name' => '');
					
					$this->smarty->assign('action', 'add');
					$this->smarty->assign('city', $city);
					
					$this->template = 'city_edit.tpl';
					
					break;
					
				case 'add':
					
					escape($_POST);
					
					$errors = array();
					
					if (isset($GLOBALS['name']) && isset($GLOBALS['ascii_name']))
					{
						$name = trim($GLOBALS['name']);
						$asciiName = trim($GLOBALS['ascii_name']);
						
						$this->validateCity($name, $asciiName, $errors);
						
						if (count($errors) == 0)
						{
							$cityByAsciiName = $this->getCityByAsciiName($asciiName);
							
							if ($cityByAsciiName)
								$errors['asciiName'] = 'Ascii name not unique';
							else
							{
								$this->createCity($name, $asciiName);
								clear_main_cache();
								
								$this->prepareDisplayCities();
								$this->smarty->assign('cityAdded', true);
							}
						}
						
						// there are errors
						if (count($errors))
						{
							$city['name'] = $_POST['name'];
							$city['ascii_name'] = $_POST['ascii_name'];
							
							$this->smarty->assign('action', 'add');
							$this->smarty->assign('city', $city);
							$this->smarty->assign('errors', $errors);
							
							$this->template = 'city_edit.tpl';
						}
					}
					else
						$this->prepareDisplayCities();
					
					break;
					
				case 'prepare-edit':
					
					if (isset($cityID) && $cityID != '')
					{
						$city = $this->getCityByID($cityID);
						
						if ($city)
						{
							$this->smarty->assign('action', 'edit');
							$this->smarty->assign('city', $city);
							
							$this->template = 'city_edit.tpl';
						}
						else
							$this->prepareDisplayCities();
					}
					else
						$this->prepareDisplayCities();
						
					break;
					
				case 'edit':
					
					escape($_POST);
					
					$errors = array();
					
					if (isset($GLOBALS['name']) && isset($GLOBALS['ascii_name']))
					{
						$name = trim($GLOBALS['name']);
						$asciiName = trim($GLOBALS['ascii_name']);
						
						$cityID = $GLOBALS['id'];
						$city = $this->getCityByID($cityID);	
						
						$this->validateCity($name, $asciiName, $errors);
						
						if (count($errors) == 0)
						{
							// if the user has changed the ascii name
							if (strcasecmp($city['ascii_name'], $asciiName))
							{
								$cityByAsciiName = $this->getCityByAsciiName($asciiName);
								
								if ($cityByAsciiName)
									$errors['asciiName'] = 'Ascii name not unique';
							}
							
							if (count($errors) == 0)
							{
								$city['name'] = $name;
								$city['ascii_name'] = $asciiName;
								
								$this->updateCity($city);
								clear_main_cache();
								$this->smarty->assign('cityEdited', true);
								$this->prepareDisplayCities();
							}
						}
						
						// there are errors
						if (count($errors))
						{
							$city['name'] = $_POST['name'];
							$city['ascii_name'] = $_POST['ascii_name'];
							
							$this->smarty->assign('action', 'edit');
							$this->smarty->assign('city', $city);
							$this->smarty->assign('errors', $errors);
							
							$this->template = 'city_edit.tpl';
						}
					}
					else
						$this->prepareDisplayCities();
					
					break;
					
				case 'delete':
					if (isset($_POST['cityID']))
					{
						$cityID = $_POST['cityID'];
						$city = $this->getCityByID($cityID);

						if ($city)
						{
							//$this->updateJobsForCityDeletion($city);
							if ($this->verifyIfHasJobs($city)) {
								echo json_encode(array('result' => '0'));
								exit;
							} else {
								$this->deleteCity($city);
								clear_main_cache();
								echo json_encode(array('result' => '1'));
								exit;
							}

						}
						else {
							echo json_encode(array('result' => '0'));
							exit;
						}
					}
					else
						$this->prepareDisplayCities();
						
					break;

					case 'import':
						if (!empty($_FILES["cv"]['tmp_name'])) {
							
							if (!empty($_FILES['cv']['error'])){
								$err = 1;
							} else {

								// correct
								try {
									$csv = array_map('str_getcsv', file($_FILES['cv']['tmp_name']));
									$locations = array();

									foreach ($csv as $line) {
										foreach ($line as $entry) {
											if ($entry !== "")
												array_push($locations, trim($entry));
										}
									}
							 		
							 		// import
							 		$this->importLocations($locations);

							 		$err = 0;
								} catch (Exception $e) {
									$err = 1;
								}
							}
						} else {
							$err = 1;
						}

					if ($err == 1)
						$this->smarty->assign('IMPORT_POPUP_ERR', 'true');
					else
						$this->smarty->assign('IMPORT_POPUP', 'true');
						
					$this->prepareDisplayCities();
					break;
					
				case 'list': ; // do nothing, just fall through 
				default:
					$this->prepareDisplayCities();
			}
			
			return $this->template;
		}
		
		private function getCityByID($cityID)
		{
			return $this->cityDAO->getCityByID($cityID);
		}
		
		private function prepareAddCity()
		{
			$city = array('name' => '', 'ascii_name' => '');
					
			$this->smarty->assign('action', 'add');
			$this->smarty->assign('city', $city);
		}
		
		private function prepareDisplayCities()
		{
			$cities = $this->getCities();
				
			$this->smarty->assign('cities', $cities);

			$this->smarty->assign('REMOTE_PORTAL', REMOTE_PORTAL);
								
			$this->template = 'cities.tpl';
		}
		
		private function getCities()
		{
			return $this->cityDAO->getCities();
		}
		
		private function getCityByAsciiName($asciiName)
		{
			return $this->cityDAO->getCityByAsciiName($asciiName);
		}
		
		private function updateCity($city)
		{
			$this->cityDAO->updateCity($city);
		}
		
		/**
		 * Validates the name and asciiName and puts the error messages (if any)
		 * in the $errors array.
		 * @param $name
		 * @param $asciiName
		 * @param $errors
		 * @return void
		 */
		private function validateCity($name, $asciiName, &$errors)
		{
			if ($name == '')
				$errors['name'] = 'City name';
			
			if ($asciiName == '')
				$errors['asciiName'] = 'Ascii name';
			else
				if (preg_match('/([^a-z0-9\-_]+?)/i', $asciiName))
					$errors['asciiName'] = 'Ascii name must contain only alphanumerical characters, dashes and underscores';
		}
		
		private function importLocations($data) {
			$this->cityDAO->importCsv($data);
		}

		private function createCity($name, $asciiName)
		{
			$city = array('name' => $name, 'ascii_name' => $asciiName);
			
			$this->cityDAO->insertCity($city);
		}

		private function verifyIfHasJobs($city)
		{
			global $db;
			
			$sql = 'SELECT count(id) AS count FROM '.DB_PREFIX.'jobs WHERE city_id = ' . $city['id'] . ' AND  UNIX_TIMESTAMP(expires) > UNIX_TIMESTAMP(NOW())  AND is_active = 1';
			$result = $db->query($sql);
			$row = $result->fetch_assoc();
			return ($row['count'] == 0) ? false : true;
		}
		
		private function updateJobsForCityDeletion($city)
		{
			global $db;
			
			$query = 'UPDATE '.DB_PREFIX.'jobs SET
					  city_id = NULL WHERE city_id = ' . $city['id'];
			
			$db->query($query);
		}
		
		private function deleteCity($city)
		{
			$this->cityDAO->deleteCity($city);
		}
	}
?>