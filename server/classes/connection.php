<?php
	class Connection
	{
		private static $server = 'localhost';
		private static $database = 'door2door';
		private static $user = 'root';
		private static $password = ''; 

		protected static $connection;

		protected static function open_connection()
		{
			self::$connection = new mysqli(self::$server, self::$user, self::$password, self::$database);
			if (self::$connection->connect_errno)
			{
				echo 'Cannot connect to MySQL server : '.self::$connection->connect_error;
				die;
			}
		}

		//close connection
		protected static function close_connection()
		{
			self::$connection->close();
		}
		
		
	}
?>