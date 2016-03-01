<?php
		require_once('classes/person.php');
		
		$headers = getallheaders();
		try
		{
			//create object
			$per = new Person($_GET['id']);
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
				}, "payments" : [';
				$first = true;
				foreach($per->get_payments() as $p)
				{
					if($first) $first = false; else $json .= ',';
					$json .= '{
						"id" : "'.$p->get_id().'",
						"date" : "'.$p->get_date().'",
						"amount" : '.$p->get_amount().',
						"receiver" : {
							"id" : "'.$p->get_receiver()->get_id().'",
							"firstName" : "'.$p->get_receiver()->get_lastname().'",
							"lastName": "'.$p->get_receiver()->get_firstname().'",
							"photo" : "'.$p->get_receiver()->get_photo().'",
							"email" : "'.$p->get_receiver()->get_email().'",
							"phone" : "'.$p->get_receiver()->get_phone().'",
							"house" : "'.$p->get_receiver()->get_house().'",
							"role" : "'.$p->get_receiver()->get_role().'"
						}
					}';
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
