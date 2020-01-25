<?php

	/**
	*  Simplejobscript Copyright (©) 2019 Niteosoft s.r.o. (ltd)
	*
	*  @author     Niteosoft s.r.o. (ltd)
	*  @license    MIT
	*  @website    simplejobscript.com
	*
	*  There are no license limitations, modifications nor restrictions placed upon 
	*  and no rights have been transfered to all third-party software parts of this product. You are granted to use these libraries
	*  and sub-parts while following their individual license specifications and terms of service
	*
	*/

class SearchKeywords
{
	var $mKeywords = false;
	
	function __construct($keywords)
	{ 
		$this->mKeywords = $keywords;
	}
	
	// save recorded keywords, if available
	public function Save()
	{
		global $db;
		$sql = 'INSERT INTO '.DB_PREFIX.'searches (keywords, created_on) VALUES ("' . $this->mKeywords . '", NOW())';
		$db->query($sql);
	}
}
?>
