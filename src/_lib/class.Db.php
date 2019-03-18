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
	
/* Create custom exception classes */
class ConnectException extends Exception {}
class QueryException extends Exception {}

class Db extends mysqli
{
	private $_connection;
	private static $_instance; //The single instance

	public static function getInstance($host, $username, $passwd, $dbname, $port) {
		if(!self::$_instance) { // If no instance then make one
			self::$_instance = new self($host, $username, $passwd, $dbname, $port);
		}
		return self::$_instance;
	}

	// Get mysqli connection
	public function getConnection() {
		return $this->_connection;
	}

	private function __clone() { }

	function __construct($host, $username, $passwd, $dbname, $port)
	{
		parent::__construct($host, $username, $passwd, $dbname, $port);
		$this->_connection = new parent($host, $username, $passwd, $dbname, $port);

	    /* Throw an error if the connection fails */ 
		if(mysqli_connect_error() && ENVIRONMENT == 'dev')
		{
			throw new ConnectException(mysqli_connect_error(), mysqli_connect_errno()); 
		} 
	}
	
	public function query($query)
	{
		//$result = parent::query($query); 
		$result = $this->_connection->query($query);
	    if(mysqli_error($this->_connection))
		{
			throw new QueryException(mysqli_error($this->_connection), mysqli_errno($this->_connection)); 
		}
		return $result;
	}
	
	public function q($query)
	{
		//$result = parent::query($query); 
		$result = $this->_connection->query($query);
		if (mysqli_error($this->_connection))
		{
			throw new Exception(mysqli_error($this->_connection), mysqli_errno($this->_connection));
		}
		
		$array_result = array();
		while ($line = mysqli_fetch_array($result, MYSQL_ASSOC))
		{
			$NewLine = array();
			foreach($line as $key=>$val)
				$NewLine[$key] = stripslashes($val);
			$array_result[] = $NewLine;
		}
		unset($result, $line);
		return $array_result;
	}
	
	public function QueryArray($query)
	{
		//$result = parent::query($query); 
		$result = $this->_connection->query($query);
		$array_result = array();
		while ($line = mysqli_fetch_array($result, MYSQL_ASSOC))
		{
			$array_result[] = $line;
		}
		unset($result, $line);
		return $array_result;
	}
	
	public function QueryRow($query)
	{
		//$result = parent::query($query);
		$result = $this->_connection->query($query);
		$line = mysqli_fetch_array($result, MYSQL_ASSOC);
		if (empty($line))
			return false;
		$NewLine = array();
		foreach($line as $key=>$val)
			$NewLine[$key] = stripslashes($val);
		return $NewLine;
	}

	// Runs a query and returns result as a single variable
	public function QueryItem($query)
	{
		//$result = parent::query($query);
		$result = $this->_connection->query($query);
		if (!$result)
		{
			return false;
		}
		$line = mysqli_fetch_array($result, MYSQL_NUM);
		if ($line)
		{
			return stripslashes($line[0]);
		}
		return false;
	}
	
	public function Execute($query)
	{
		//$result = parent::query($query); 
		$result = $this->_connection->query($query);
		if(mysqli_error($this->_connection))
		{
			throw new Exception(mysqli_error($this->_connection), mysqli_errno($this->_connection));
			return false;
		}
		else
		{
			return true;
		}
	}
	
	public function GetServerInfo()
	{
		return $this->_connection->server_info;
	}
	
	public function ExecuteMultiple($query)
	{
		//$result = parent::multi_query($query); 
		$result = $this->_connection->multi_query($query);
		if(mysqli_error($this->_connection) && ENVIRONMENT == 'dev')
		{
			throw new QueryException(mysqli_connect_error(), mysqli_connect_errno()); 
			return false;
		}
		else
		{
			return true;
		}
	}
}
?>
