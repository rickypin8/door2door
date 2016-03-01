<?php
		require_once('classes/person.php');
		require_once('classes/catalogs.php');
		
		$headers = getallheaders();
		try
		{
			//create object
			$per = new Person($_GET['id']);
			//get funds for calculations (and to not double the DB connection)
			$funds = 0.0;
			foreach($per->get_payments() AS $pay)
				$funds += $pay->get_amount();
			//start json
			$json = '{
				"status" : 0,
				"person" : {
					"id" : "'.$per->get_id().'",
					"firstName" : "'.$per->get_lastname().'",
					"lastName": "'.$per->get_firstname().'",
					"photo" : "'.$per->get_photo().'",
					"email" : "'.$per->get_email().'",
					"phone" : "'.$per->get_phone().'",
					"house" : "'.$per->get_house().'",
					"role" : "'.$per->get_role().'",
					"balance" : "'.$per->get_funds().'"
				}, "periods" : [';
				$periodStartDate = substr($per->get_entryDate(), 0, 7);
				$periodStartDate .= '-01';
				$first = true;
				$enoughFunds = true; //variable to prevent later funds to be set as paid because former payments had more cost
				foreach(Catalogs::get_periods(null) as $p)
				{
					$isPaid = -1;
					if($p->get_pdate() >= $periodStartDate)
					{
						if($enoughFunds & $funds >= $p->get_amount())
						{
							$isPaid = 1;
							$funds -= $p->get_amount();
						}
						else
						{
							$enoughFunds = false;
							$isPaid  = 0;
						}
					}
					if($first) $first = false; else $json .= ',';
					$json .= '{
						"id" : "'.$p->get_id().'",
						"date" : "'.$p->get_pdate().'",
						"amount" : '.$p->get_amount().',
						"debtRate" : '.$p->get_debtRate().',
						"isPaid" : "'.$isPaid.'"
					}'; //isPaid: 0 = no, 1 = yes, -1 = not applicable
				}
			$json .= ']}';
			//display json
			echo $json;
		}
		catch (RecordNotFoundException $ex)
		{
			echo '{ "status" : 2, "errorMessage" : "'.$ex->get_message().'" }';
		}

?>
