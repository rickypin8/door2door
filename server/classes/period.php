<?php

	require_once('connection.php');
	require_once('exceptions.php');
	require_once('spending.php');

	class Period extends Connection
	{
		//attributes
		private $id;
		private $pdate;
		private $amount;
		private $debtRate;

		//properties
		public function get_id() { return $this->id; }
		public function get_pdate() { return $this->pdate; }
		public function set_pdate($value) { $this->pdate = $value; }
		public function get_amount() { return $this->amount; }
		public function set_amount($value) { $this->amount = $value; }
		public function get_debtRate() { return $this->debtRate; }
		public function set_debtRate($value) { $this->debtRate = $value; }

		//constructor
		public function __construct()
		{
			if(func_num_args() == 0)
			{
				$this->id = 0;
				$this->pdate = date_create();
				$this->amount = 0.0;
				$this->debtRate = 0.0;
			}
			if(func_num_args() == 1)
			{
				$args = func_get_args();
				$id = $args[0];
				parent::open_connection();
				$query = "select prd_id, prd_date, prd_amount, prd_debtRate from periods where prd_id = ?";
				$command = parent::$connection->prepare($query);
				$command->bind_param('s', $id);
				$command->execute();
				$command->bind_result($this->id, $this->pdate, $this->amount, $this->debtRate);
				$found = $command->fetch();
				mysqli_stmt_close($command);
				parent::close_connection();
				if(!$found) throw(new RecordNotFoundException());
			}
		}
		
		public function add()
		{
			parent::open_connection();
			$query = "insert into periods (prd_id, prd_date, prd_amount, prd_debtRate) values (0, ?, ?, ?)";
			$command = parent::$connection->prepare($query);
			$command->bind_param('sss', $this->pdate, $this->amount, $this->debtRate);
			$done = $command->execute();
			mysqli_stmt_close($command);
			parent::close_connection();
			if($done)
			{
				parent::open_connection();
				$query = "select prd_id from periods where prd_date = ? and prd_amount = ? and prd_debtRate = ?";
				$command = parent::$connection->prepare($query);
				$command->bind_param('sss', $this->pdate, $this->amount, $this->debtRate);
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
			$query = "update periods set prd_date = ?, prd_amount = ?, prd_debtRate = ? where prd_id = ?";
			$command = parent::$connection->prepare($query);
			$command->bind_param('ssss', $this->pdate, $this->amount, $this->debtRate, $this->id);
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
			$query = 'select spn_id from spendings where spn_period = ?';
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
