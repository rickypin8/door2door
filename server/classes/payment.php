<?php

	require_once('connection.php');
	require_once('exceptions.php');
	require_once('person.php');

	class Payment extends Connection
	{
		//attributes
		private $id;
		private $person;
		private $amount;
		private $_date;
		private $receiver;

		//properties
		public function get_id() { return $this->id; }
		public function get_person() { return $this->person; }
		public function set_person($value) { $this->person = new Person($value); }
		public function get_date() { return $this->_date; }
		public function get_amount() { return $this->amount; }
		public function set_amount($value) { $this->amount = $value; }
		public function get_receiver() { return $this->receiver; }
		public function set_receiver($value) { $this->receiver = new Person($value); }

		//constructor
		public function __construct()
		{
			if(func_num_args() == 0)
			{
				$this->id = 0;
				$this->person = new Person();
				$this->_date = '';
				$this->amount = 0;
				$this->receiver = new Person();
			}
			if(func_num_args() == 1)
			{
				$args = func_get_args();
				$id = $args[0];
				parent::open_connection();
				$query = "select pay_id, pay_person, pay_date, pay_amount, pay_receiver from payments where pay_id = ?";
				$command = parent::$connection->prepare($query);
				$command->bind_param('i', $id);
				$command->execute();
				$command->bind_result($this->id, $person, $this->_date, $this->amount, $receiver);
				$found = $command->fetch();
				mysqli_stmt_close($command);
				parent::close_connection();
				if(!$found) throw(new RecordNotFoundException());
				else
				{
					$this->person = new Person($person);
					$this->receiver = new Person($receiver);
				}
			}
		}
		
		public function add()
		{
			parent::open_connection();
			$query = "insert into payments (pay_id, pay_person, pay_amount, pay_receiver) values (0, ?, ?, ?)";
			$command = parent::$connection->prepare($query);
			$command->bind_param('iii', $this->person->get_id(), $this->amount, $this->receiver->get_id());
			$done = $command->execute();
			mysqli_stmt_close($command);
			parent::close_connection();
			//NOTA: código para conseguir ID eliminado por 2 razones
			//	1 - La fecha fue automatizada y los campos restantes para calificar una búsqueda sin ID son repetibles
			//	2 - Al agregar un pago, se puede avisar que fue realizado satisfactoriamente sin avisar el ID resultante (se refrescan todos en su lugar)
			return $done;
		}
		
		public function update()
		{
			parent::open_connection();
			$query = "update payments set pay_person = ?, pay_date = ?, pay_amount = ?, pay_receiver = ? where pay_id = ?";
			$command = parent::$connection->prepare($query);
			$command->bind_param('isiii', $this->person->get_id(), $this->_date, $this->amount, $this->receiver->get_id(), $this->id);
			$done = $command->execute();
			mysqli_stmt_close($command);
			parent::close_connection();
			return $done;
		}

	}
?>
