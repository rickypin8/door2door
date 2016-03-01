<?php
	
	require_once('classes/spending.php');
		$headers = getallheaders();
		try
		{
			//create object
			$s = new Spending($_GET['id']);
			//start json
			$json = '{"status" : 0,
						"id" : "'.$s->get_id().'",
						"amount" : '.$s->get_amount().',
						"service" : {
							"id" : "'.$s->get_service()->get_id().'",
							"name": "'.$s->get_service()->get_name().'",
							"description" : "'.$s->get_service()->get_description().'",
							"price" : "'.$s->get_service()->get_price().'"
						},
						"period" : {
							"id" : "'.$s->get_period()->get_id().'",
							"date": "'.$s->get_period()->get_pdate().'",
							"amount" : '.$s->get_period()->get_amount().',
							"debtRate" : '.$s->get_period()->get_debtRate().'
						}
						}';
			//display json
			echo $json;
		}
		catch (RecordNotFoundException $ex)
		{
			echo '{ "status" : 2, "errorMessage" : "'.$ex->get_message().'" }';
		}

?>
