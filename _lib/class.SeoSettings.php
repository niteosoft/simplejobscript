<?php 

class SeoSettings
{
	var $mSettings = false;
		
	public function __construct()
	{
		global $db;

		$sql = 'SELECT * FROM '.DB_PREFIX.'seo ORDER BY category_id ASC';
		$result = $db->query($sql);
		
		$settings = array();
		
		while ($row = $result->fetch_assoc())
		{
			$settings[$row['key']] = $row['value'];
		}
		
		$this->mSettings = $settings;
	}

	public function GetSettings()
	{
		return $this->mSettings;
	}

}

?>