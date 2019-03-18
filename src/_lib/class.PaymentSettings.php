<?php 

class PaymentSettings
{
	var $mSettings = false;
		
	public function __construct()
	{
		global $db;

		$sql = 'SELECT * FROM '.DB_PREFIX.'payment_settings_fees ORDER BY ordering ASC';
		$result = $db->query($sql);
		
		$settings = array();
		
		while ($row = $result->fetch_assoc())
		{
			$settings[$row['name']] = $row['value'];
		}
		
		$this->mSettings = $settings;
	}

	public function GetSettings()
	{
		return $this->mSettings;
	}

}

?>