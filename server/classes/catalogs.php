<?php
	require_once('person.php');
	require_once('payment.php');
	require_once('period.php');
	require_once('service.php');
	
	class Catalogs extends Connection
	{
		public static function get_vacantHouses()
		{
			parent::open_connection();
			$ids = array();
			$query = 'select hou_id from houses left join residents on hou_id = res_house where res_id is null';
			$command = parent::$connection->prepare($query);
			$command->execute();
			$command->bind_result($id);
			while ($command->fetch()) array_push($ids, $id);
			mysqli_stmt_close($command);
			parent::close_connection();
			return $ids;
		}
		
		public static function get_occupiedHouses()
		{
			parent::open_connection();
			$ids = array();
			$list = array();
			$query = 'select hou_id, res_id from houses inner join residents on hou_id = res_house';
			$command = parent::$connection->prepare($query);
			$command->execute();
			$command->bind_result($id);
			while ($command->fetch()) array_push($ids, $id);
			mysqli_stmt_close($command);
			parent::close_connection();
			for ($i=0; $i < count($ids); $i++) array_push($list, new Person($ids[$i]));
			return $list;
		}
		
		public static function get_activeResidents()
		{
			parent::open_connection();
			$ids = array();
			$list = array();
			$query = 'select res_id from residents where res_active = 1';
			$command = parent::$connection->prepare($query);
			$command->execute();
			$command->bind_result($id);
			while ($command->fetch()) array_push($ids, $id);
			mysqli_stmt_close($command);
			parent::close_connection();
			for ($i=0; $i < count($ids); $i++) array_push($list, new Person($ids[$i]));
			return $list;
		}
		
		public static function get_guards()
		{
			parent::open_connection();
			$ids = array();
			$list = array();
			$query = 'select guard_id from guards where guard_active = 1';
			$command = parent::$connection->prepare($query);
			$command->execute();
			$command->bind_result($id);
			while ($command->fetch()) array_push($ids, $id);
			mysqli_stmt_close($command);
			parent::close_connection();
			for ($i=0; $i < count($ids); $i++) array_push($list, new Person($ids[$i]));
			return $list;	
		}
		
		public static function get_newestPayment()
		{
			parent::open_connection();
			$query = "select prd_id from view_newestpayment";
			$command = parent::$connection->prepare($query);
			$command->execute();
			$command->bind_result($period);
			$found = $command->fetch();
			mysqli_stmt_close($command);
			parent::close_connection();
			return new Period($period);
		}
		
		public static function get_periods($date)
		{
			parent::open_connection();
			$ids = array();
			$list = array();
			$command;
			if($date == null)
			{
				$query = 'select prd_id from periods order by prd_date asc';
				$command = parent::$connection->prepare($query);
			}
			else
			{
				//get year and month from date
				$date = substr($date, 0, 7);
				//turn into first day from month
				$date .= '-01';
				$query = 'select prd_id from periods where prd_date >= ? order by prd_date asc';
				$command = parent::$connection->prepare($query);
				$command->bind_param('s', $date);
				
			}
			
			$command->execute();
			$command->bind_result($id);
			while ($command->fetch()) array_push($ids, $id);
			mysqli_stmt_close($command);
			parent::close_connection();
			for ($i=0; $i < count($ids); $i++) array_push($list, new Period($ids[$i]));
			return $list;	
		}
		
		public static function get_services()
		{
			parent::open_connection();
			$ids = array();
			$list = array();
			$query = 'select ser_id from services';
			$command = parent::$connection->prepare($query);
			$command->execute();
			$command->bind_result($id);
			while ($command->fetch()) array_push($ids, $id);
			mysqli_stmt_close($command);
			parent::close_connection();
			for ($i=0; $i < count($ids); $i++) array_push($list, new Service($ids[$i]));
			return $list;	
		}
		
		public static function get_persons()
		{
			parent::open_connection();
			$ids = array();
			$list = array();
			$query = 'select per_id from persons';
			$command = parent::$connection->prepare($query);
			$command->execute();
			$command->bind_result($id);
			while ($command->fetch()) array_push($ids, $id);
			mysqli_stmt_close($command);
			parent::close_connection();
			for ($i=0; $i < count($ids); $i++) array_push($list, new Person($ids[$i]));
			return $list;	
		}
		
		public static function get_residents()
		{
			parent::open_connection();
			$ids = array();
			$list = array();
			$query = 'select res_id from residents where res_active = 1';
			$command = parent::$connection->prepare($query);
			$command->execute();
			$command->bind_result($id);
			while ($command->fetch()) array_push($ids, $id);
			mysqli_stmt_close($command);
			parent::close_connection();
			for ($i=0; $i < count($ids); $i++) array_push($list, new Person($ids[$i]));
			return $list;	
		}
	}
?>