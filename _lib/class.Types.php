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

	 
	class Types{
		private $id;
		private $varName;
		private $cost;
		private $name;
		private $typeArray = array();
		
		public function __construct()
		{
			
		}
		
		public function getId()
		{
			return $this->id;
		}
		public function getName()
		{
			return $this->name;
		}
		public function getVarName()
		{
			return $this->varName;
		}
		
		
		public function setId($id)
		{
			$this->id = $id;
		}
		public function setVarName($varName)
		{
			$this->varName = $varName;
		}
		
		public function setName($name)
		{
			$this->name = $name;
		}
		
		public function getAllTypes()
		{
			global $db;
			$sql = 'SELECT * FROM '.DB_PREFIX.'types';
			$result = $db->query($sql);
			$i=0;
			while($row = $result->fetch_assoc())
			{
				$this->typeArray[$i] = new Types();
				$this->typeArray[$i]->id = $row['id'];
				$this->typeArray[$i]->varName = $row['var_name'];
				$this->typeArray[$i]->name = $row['name'];
				$i++;
			}
		}
		
		public function getTypesArray()
		{
			return $this->typeArray;
		}
		public function insertType()
		{
			global $db;
			$sql = 'INSERT INTO '.DB_PREFIX.'types VALUES(null, "'.$this->name.'", "'.$this->varName.'")';
			$db->query($sql);
			$this->id = $db->getConnection()->insert_id;
		}
		
		public function updateType()
		{
			global $db;
			$sql = 'UPDATE '.DB_PREFIX.'types SET var_name =  "'.$this->varName.'",
				name = "'.$this->name.'"
				WHERE id='.$this->id;
			$db->query($sql);
		}
		
		public function deleteType()
		{
			global $db;
			$sql = 'DELETE FROM '.DB_PREFIX.'types
				WHERE id='.$this->id;
			$result = $db->query($sql);
		}
		
		public function verifyAreJobs($typeId)
		{
			global $db;
			$sql = 'SELECT count(id) AS nr FROM '.DB_PREFIX.'jobs 
				WHERE type_id = '.$typeId.' AND  UNIX_TIMESTAMP(expires) > UNIX_TIMESTAMP(NOW())  AND is_active = 1 GROUP BY 
				type_id';
			$result = $db->query($sql);
			
			if($row = $result->fetch_assoc())
			{
				return $row['nr'];
			}
			return false;
		}
	}
?>
