<?php
	class Installer
	{
		private $m_szNeededPhpVersion = "5.0.0";
		private $m_szNeededMySQLVersion = "4.1";
		private $m_szLastError;
		private $_mysqlVersion;
		private $_db;
		
		function __construct()
		{
		}

		public function getDb() {
			return $this->_db;
		}
		
		public function CheckPhpVersion()
		{
			return phpversion() >= $this->m_szNeededPhpVersion;
		}
		
		public function CheckMySQLiInterface($szDbHost, $szDbName, $szDbUser, $szDbPass, $szDbPort)
		{
			//Let's try MySQLi first
			require_once '_lib/class.Db.php';
			try 
			{
				$db = Db::getInstance($szDbHost, $szDbUser, $szDbPass, $szDbName, $szDbPort);
				$this->_mysqlVersion = $db->GetServerInfo();
				$db->Execute('SET CHARSET UTF8');
				$this->_db = $db;
			}
			catch(ConnectException $exception) 
			{
				//The server doesn't support the mysqli extension, try again with mysql
				$this->m_szLastError = $exception->getMessage();
				return false;
			}

			return true;
		}
		
		/*public function CheckMySQLInterface($szDbHost, $szDbName, $szDbUser, $szDbPass, $szDbPort)
		{
				//The server doesn't not have the MySQLi extension installed. Fall back to MySQL
				require_once '_lib/class.Db.MySql.php';
			
			try
			{
				$db = new DbMysql($szDbHost, $szDbUser, $szDbPass, $szDbName, $szDbPort);
				$this->_mysqlVersion = $db->GetServerInfo();
				$db->Execute('SET CHARSET UTF8');
			}
			catch(ConnectException $exception) 
			{
				$this->m_szLastError = $exception->getMessage();
				return false;
			}
			return true;
		}*/
		
		public function CheckMySQLVersion()
		{
			global $db;
			
			preg_match('@[0-9]+\.[0-9]+\.[0-9]+@', $db->GetServerInfo(), $szVerArray);
			$szMySQLVersion = $szVerArray[0];
			
			return $szMySQLVersion >= $this->m_szNeededMySQLVersion;
		}
		
		//Check to see whether the cache folder has write rights
		public function CheckCachePermissions()
		{
			return (fileperms('_tpl/default/_cache') & 0x0002) != 0;
		}
		
		//Check to see if the uploads folder has write rights
		public function CheckUploadPermissions()
		{
			return (fileperms('uploads') & 0x0002) != 0;
		}
		
		public function GetLastError()
		{
			return $this->m_szLastError;
		}

		public function GetMysqlVersion()
		{
			return $this->_mysqlVersion;
		}
	}
?>
