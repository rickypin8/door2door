<?php
		require_once('classes/service.php');
		
		$headers = getallheaders();
		try
		{
			$srv = new Service($_GET['id']);
			
			//start json
			$json = ' {
				"status" : 0,
				"service" : {
					"id" : "'.$srv->get_id().'",
					"name" : "'.$srv->get_name().'",
					"description" : "'.$srv->get_description().'",
					"price" : '.$srv->get_price().'
				}, 
				"spendings" : [';
				$first = true;
				foreach($srv->get_spendings() as $s)
				{
					if($first) $first = false; else $json .= ',';
					$json .= ' {
						"id" : "'.$s->get_id().'",
						"amount" : '.$s->get_amount().',
						"period" : {
							"id" : "'.$s->get_period()->get_id().'",
							"date": "'.$s->get_period()->get_pdate().'",
							"amount" : '.$s->get_period()->get_amount().',
							"debtRate" : '.$s->get_period()->get_debtRate().'
						},
						"buyer" : {
							"id" : "'.$s->get_buyer()->get_id().'",
							"firstName" : "'.$s->get_buyer()->get_lastname().'",
							"lastName": "'.$s->get_buyer()->get_firstname().'",
							"photo" : "'.$s->get_buyer()->get_photo().'",
							"email" : "'.$s->get_buyer()->get_email().'",
							"phone" : "'.$s->get_buyer()->get_phone().'",
							"house" : "'.$s->get_buyer()->get_house().'",
							"role" : "'.$s->get_buyer()->get_role().'"
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
