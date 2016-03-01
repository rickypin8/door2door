<?php

	require_once('connection.php');
	require_once('exceptions.php');
	require_once('payment.php');
	require_once('period.php');
	require_once('catalogs.php');

	class Person extends Connection
	{
		//attributes
		private $email;
		private $firstname;
		private $id;
		private $lastname;
		private $phone;
		private $photo;
		private $role;
		private $house;
		private $active;
		private $entryDate;

		//properties
		public function get_email() { return $this->email; }
		public function set_email($value) { $this->email = $value; }
		public function get_firstname() { return $this->firstname; }
		public function set_firstname($value) { $this->firstname = $value; }
		public function get_fullname() { return $this->firstname.' '.$this->lastname; }
		public function get_id() { return $this->id; }
		public function get_lastname() { return $this->lastname; }
		public function set_lastname($value) { $this->lastname = $value; }
		public function get_phone() { return $this->phone; }
		public function set_phone($value) { $this->phone = $value; }
		public function get_photo() { return $this->photo; }
		public function set_photo($value) { $this->photo = $value; }
		public function get_house() { return $this->house; }
		public function set_role($value) { $this->role = $value; }
		public function get_entryDate() { return $this->entryDate; }
		public function get_role() { return $this->role; }
		
		public function get_funds() {
			$funds = 0.0;
			foreach($this->get_payments() as $pay)
			{ $funds += $pay->get_amount(); }
			foreach(Catalogs::get_periods($this->entryDate) as $per)
			{ $funds -= $per->get_amount(); }
			return $funds;
		}
		
		//constructor
		public function __construct()
		{
			if(func_num_args() == 0)
			{
				$this->email = '';
				$this->firstname = '';
				$this->id = 0;
				$this->lastname = '';
				$this->phone = '';
				$this->photo = '';
				$this->role = 0;
				$this->house = 0;
			}
			if(func_num_args() == 1)
			{
				$this->house = '';
				$args = func_get_args();
				$id = $args[0];
				parent::open_connection();
				$query = "select per_id, per_first_name, per_last_name, per_phone, per_email, per_photo from persons where per_id = ?";
				$command = parent::$connection->prepare($query);
				$command->bind_param('i', $id);
				$command->execute();
				$command->bind_result($this->id, $this->firstname, $this->lastname, $this->phone, $this->email, $this->photo);
				$found = $command->fetch();
				mysqli_stmt_close($command);
				parent::close_connection();
				if(!$found) throw(new RecordNotFoundException());
				else
					$this->getRole();
			}
		}
		
		private function searchResidentDetails()
		{
			parent::open_connection();
			$query = "select res_house, res_entryDate from residents where res_id = ?";
			$command = parent::$connection->prepare($query);
			$command->bind_param('i', $this->id);
			$command->execute();
			$command->bind_result($this->house, $this->entryDate);
			$found = $command->fetch();
			mysqli_stmt_close($command);
			parent::close_connection();
			if(!$found) throw(new RecordNotFoundException());
		}
		
		//role related functions
		
		//roles: 
		//0 = resident
		//1 = admin
		//2 = guard
		//-1 = error
		
		private function getRole()
		{
			parent::open_connection();
			$query = "select func_getRole(?) as Role";
			$command = parent::$connection->prepare($query);
			$command->bind_param('i', $this->id);
			$command->execute();
			$command->bind_result($this->role);
			$command->fetch(); //no '$found' because not found = -1
			mysqli_stmt_close($command);
			parent::close_connection();
			if($this->role == -1) throw(new RecordNotFoundException());
			if($this->role != 2)
				$this->searchResidentDetails();
		}
		
		private function addRole()
		{
			//roles: 0 = resident, 1 = admin, 2 = guard
			parent::open_connection();
			
			//change query depending on person's role
			$query = '';
			switch($this->role)
			{
				case 0:
					$query = "insert into residents (res_id, res_house, res_active) values (?, ?, ?)";
					break;
				case 1:
					$query = "insert into administrators (adm_id, adm_active) values (?, ?)";
					break;
				case 2:
					$query = "insert into guards (guard_id, guard_active) values (?, ?)";
					break;
			}
			
			$command = parent::$connection->prepare($query);
			
			//exclusive parameter binding for resident (due to house)
			if($this->role == 0)
				$command->bind_param('iii', $this->id, $this->house, $this->active);
			else
				$command->bind_param('ii', $this->id, $this->active);
			
			$done = $command->execute();
			mysqli_stmt_close($command);
			parent::close_connection();
			
			//if person is admin, must register both at admin and resident tables
			if($done & $this->role == 1)
			{
				$this->role = 0;
				$done = addRole();
				$this->role = 1;
			}
			return done;
		}
		
		public function changeRole($role)
		{
			
			parent::open_connection();
								//params: personId, pastRole, newRole
			$query = "select func_switchRole(?, ?, ?) as Role";
			$command = parent::$connection->prepare($query);
			$command->bind_param('iii', $this->id, $this->role, $role);
			$command->execute();
			$command->bind_result($this->role);
			$found = $command->fetch();
			mysqli_stmt_close($command);
			parent::close_connection();
			if($this->role == -1 | !$found) throw(new RecordNotFoundException());
			
			
			if($this->role == $role)
				$done = true;
			else
			{
				
			}
			
			if($done)
				$this->role = $role;
			return $done; //valor booleano
		}
		
		//methods

		public function add()
		{
			parent::open_connection();
			$query = "insert into persons (per_id, per_first_name, per_last_name, per_phone, per_email, per_photo) values (0, ?, ?, ?, ?, ?)";
			$command = parent::$connection->prepare($query);
			$command->bind_param('sssss', $this->firstname, $this->lastname, $this->phone, $this->email, $this->photo);
			$done = $command->execute();
			mysqli_stmt_close($command);
			parent::close_connection();
			if($done)
			{
				parent::open_connection();
				$query = "select per_id from persons where per_phone = ? and per_email = ? and per_photo = ?";
				$command = parent::$connection->prepare($query);
				$command->bind_param('sss', $this->phone, $this->email, $this->photo);
				$command->execute();
				$command->bind_result($this->id);
				$found = $command->fetch();
				mysqli_stmt_close($command);
				parent::close_connection();
				if(!$found) throw(new RecordNotFoundException());
				addRole();
			}
			return $done;
		}
		
		public function delete()
		{
			parent::open_connection();
			$query = '';
			switch($this->role)
			{
				case 0:
					$query = "update residents set res_active = 0 where res_id = ?";
					break;
				case 1:
					$query = "update administrators set adm_active = 0 where adm_id = ?";
					break;
				case 2:
					$query = "update guards set guard_active = 0 where guard_id = ?";
					break;
			}
			$command = parent::$connection->prepare($query);
			$command->bind_param('i', $this->id);
			$done = $command->execute();
			mysqli_stmt_close($command);
			parent::close_connection();
			return $done;
		}

		public function update()
		{
			parent::open_connection();
			$query = "update persons set per_first_name = ?, per_last_name = ?, per_phone = ?, per_email = ?, per_photo = ? where per_id = ?";
			$command = parent::$connection->prepare($query);
			$command->bind_param('sssssi', $this->firstname, $this->lastname, $this->phone, $this->email, $this->photo, $this->id);
			$done = $command->execute();
			mysqli_stmt_close($command);
			parent::close_connection();
			if($done && $this->role <= 1)
			{
				parent::open_connection();
				$query = "update residents set res_house = ? where res_id = ?";
				$command = parent::$connection->prepare($query);
				$command->bind_param('ii', $this->house, $this->id);
				$done = $command->execute();
				mysqli_stmt_close($command);
				parent::close_connection();
			}
			return $done;
		}
		
		public function get_payments()
		{
			$payments = array();
			$ids = array();
			parent::open_connection();
			$query = "select pay_id from payments where pay_person = ? order by pay_date asc";
			$command = parent::$connection->prepare($query);
			$command->bind_param('s', $this->id);
			$command->execute();
			$command->bind_result($id);
			while($command->fetch()) array_push($ids, $id);
			mysqli_stmt_close($command);
			parent::close_connection();
			for ($i=0; $i < count($ids); $i++) array_push($payments, new Payment($ids[$i]));
			return $payments;
		}
	}
?>
