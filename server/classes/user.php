<?php

	require_once('connection.php');
	require_once('exceptions.php');
	require_once('person.php');

	class User extends Connection
	{
		//attributes
		private $person;
		private $username;
		private $password;

		//properties
		public function get_person() { return $this->person; }
		public function set_person($value) { $this->person = new Person($value); }
		public function get_username() { return $this->username; }
		public function set_username($value) { $this->username = $value; }
		public function set_password($value) { $this->password = $value; }

		//constructor
		public function __construct()
		{
			if(func_num_args() == 0)
			{
				$this->person = new Person();
				$this->username = '';
				$this->password = '';
			}
			if(func_num_args() == 2)
			{
				$args = func_get_args();
				$username = $args[0];
				$password = $args[1];
				parent::open_connection();
				$query = "select user_person, user_name, user_password from users where user_name = ? and user_password = sha1(?)";
				$command = parent::$connection->prepare($query);
				$command->bind_param('ss', $username, $password);
				$command->execute();
				$command->bind_result($person, $this->username, $this->password);
				$found = $command->fetch();
				mysqli_stmt_close($command);
				parent::close_connection();
				if(!$found) throw(new RecordNotFoundException());
				else $this->person = new Person($person);
			}
		}

		//methods
		public function add()
		{
			parent::open_connection();
			$query = "insert into users (user_person, user_name, user_password) values (?, ?, sha1(?))";
			$command = parent::$connection->prepare($query);
			$command->bind_param('sss', $this->person->get_id(), $this->username, $this->password);
			$done = $command->execute();
			mysqli_stmt_close($command);
			parent::close_connection();
			return $done;
		}

		public function update()
		{
			parent::open_connection();
			$query = "update users set user_password = sha1(?) where user_name = ?";
			$command = parent::$connection->prepare($query);
			$command->bind_param('ss', $this->password, $this->username);
			$done = $command->execute();
			mysqli_stmt_close($command);
			parent::close_connection();
			return $done;
		}
	}
?>
