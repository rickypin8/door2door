<?php
	
	require_once('classes/payment.php');
	
		$headers = getallheaders();
		try
		{
			//create object
			$p = new Payment($_GET['id']);
			//start json
			$json = '{ 
				"status" : 0,
				"id" : "'.$p->get_id().'",
				"amount" : "'.$p->get_amount().'",
				"date" : "'.$p->get_date().'",
				"resident" : {
					"id" : "'.$p->get_person()->get_id().'",
					"firstName" : "'.$p->get_person()->get_lastname().'",
					"lastName": "'.$p->get_person()->get_firstname().'",
					"photo" : "'.$p->get_person()->get_photo().'",
					"email" : "'.$p->get_person()->get_email().'",
					"phone" : "'.$p->get_person()->get_phone().'",
					"house" : "'.$p->get_person()->get_house().'",
					"role" : "'.$p->get_person()->get_role().'"
				},
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
			//display json
			echo $json;
		}
		catch (RecordNotFoundException $ex)
		{
			echo '{ "status" : 2, "errorMessage" : "'.$ex->get_message().'" }';
		}

?>
