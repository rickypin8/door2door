<?php

	require_once('connection.php');
	require_once('exceptions.php');
	require_once('spending.php');

	class Service extends Connection
	{
		//attributes
		private $id;
		private $name;
		private $description;
		private $price;

		//properties
		public function get_id() { return $this->id; }
		public function get_name() { return $this->name; }
		public function set_name($value) { $this->name = $value; }
		public function get_description() { return $this->description; }
		public function set_description($value) { $this->description = $value; }
		public function get_price() { return $this->price; }
		public function set_price($value) { $this->price = $value; }
		
		//constructor
		public function __construct()
		{
			if(func_num_args() == 0)
			{
				$this->id = 0;
				$this->name = '';
				$this->description = '';
				$this->price = 0.0;
			}
			if(func_num_args() == 1)
			{
				$args = func_get_args();
				$id = $args[0];
				parent::open_connection();
				$query = "select ser_id, ser_name, ser_description, ser_price from services where ser_id = ?";
				$command = parent::$connection->prepare($query);
				$command->bind_param('s', $id);
				$command->execute();
				$command->bind_result($this->id, $this->name, $this->description, $this->price);
				$found = $command->fetch();
				mysqli_stmt_close($command);
				parent::close_connection();
				if(!$found) throw(new RecordNotFoundException());
			}
		}
		
		public function add()
		{
			parent::open_connection();
			$query = "insert into services (ser_id, ser_name, ser_description, ser_price) values (0, ?, ?, ?)";
			$command = parent::$connection->prepare($query);
			$command->bind_param('sss', $this->name, $this->description, $this->price);
			$done = $command->execute();
			mysqli_stmt_close($command);
			parent::close_connection();
			if($done)
			{
				parent::open_connection();
				$query = "select ser_id from services where ser_name = ? and ser_description = ? and ser_price = ?";
				$command = parent::$connection->prepare($query);
				$command->bind_param('sss', $this->name, $this->description, $this->price);
				$command->execute();
				$command->bind_result($this->id);
				$found = $command->fetch();
				mysqli_stmt_close($command);
				parent::close_connection();
				if(!$found) throw(new RecordNotFoundException());
			}
			return $done;
		}
		
		public function update()
		{
			parent::open_connection();
			$query = "update services set ser_name = ?, ser_description = ?, ser_price = ? where ser_id = ?";
			$command = parent::$connection->prepare($query);
			$command->bind_param('ssss', $this->name, $this->description, $this->price, $this->id);
			$done = $command->execute();
			mysqli_stmt_close($command);
			parent::close_connection();
			return $done;
		}
		
		public function get_spendings()
		{
			parent::open_connection();
			$ids = array();
			$list = array();
			$query = 'select spn_id from spendings where spn_service = ?';
			$command = parent::$connection->prepare($query);
			$command->bind_param('s', $this->id);
			$command->execute();
			$command->bind_result($id);
			while ($command->fetch()) array_push($ids, $id);
			mysqli_stmt_close($command);
			parent::close_connection();
			for ($i=0; $i < count($ids); $i++) array_push($list, new Spending($ids[$i]));
			return $list;	
		}
	}
?>
