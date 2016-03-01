<?php

	require_once('connection.php');
	require_once('exceptions.php');
	require_once('period.php');
	require_once('service.php');
	require_once('person.php');

	class Spending extends Connection
	{
		//attributes
		private $id;
		private $period;
		private $service;
		private $amount;
		private $buyer;

		//properties
		public function get_id() { return $this->id; }
		public function get_service() { return $this->service; }
		public function set_service($value) { $this->service = new Service($value); }
		public function get_period() { return $this->period; }
		public function set_period($value) { $this->period = new Period($value); }
		public function get_amount() { return $this->amount; }
		public function set_amount($value) { $this->amount = $value; }
		public function get_buyer() { return $this->buyer; }
		public function set_buyer($value) { $this->buyer = new Person($value); }

		//constructor
		public function __construct()
		{
			if(func_num_args() == 0)
			{
				$this->id = 0;
				$this->period = new Period();
				$this->service = new Service();
				$this->amount = 0.0;
				$this->buyer = new Person();
			}
			if(func_num_args() == 1)
			{
				$args = func_get_args();
				$id = $args[0];
				parent::open_connection();
				$query = "select spn_id, spn_service, spn_period, spn_amount, spn_buyer from spendings where spn_id = ?";
				$command = parent::$connection->prepare($query);
				$command->bind_param('i', $id);
				$command->execute();
				$command->bind_result($this->id, $service, $period, $this->amount, $buyer);
				$found = $command->fetch();
				mysqli_stmt_close($command);
				parent::close_connection();
				if(!$found) throw(new RecordNotFoundException());
				else
				{
					$this->service = new Service($service);
					$this->period = new Period($period);
					$this->buyer = new Person($buyer);
				}
			}
		}
		
		public function add()
		{
			parent::open_connection();
			$query = "insert into spendings (spn_id, spn_service, spn_period, spn_amount, spn_buyer) values (0, ?, ?, ?, ?)";
			$command = parent::$connection->prepare($query);
			$command->bind_param('iis', $this->service->get_id(), $this->period->get_id(), $this->amount, $this->buyer->get_id());
			$done = $command->execute();
			mysqli_stmt_close($command);
			parent::close_connection();
			if($done)
			{
				parent::open_connection();
				$query = "select spn_id from spendings where spn_service = ? and spn_period = ? and spn_amount = ?";
				$command = parent::$connection->prepare($query);
				$command->bind_param('iis', $this->service->get_id(), $this->period->get_id(), $this->amount);
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
			$query = "update spendings set spn_service = ?, spn_period = ?, spn_amount = ? where spn_id = ?";
			$command = parent::$connection->prepare($query);
			$command->bind_param('ssss', $this->service->get_id(), $this->period->get_id(), $this->amount, $this->id);
			$done = $command->execute();
			mysqli_stmt_close($command);
			parent::close_connection();
			return $done;
		}
	}
?>
