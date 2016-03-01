<?php
	
	require_once('classes/person.php');
		$headers = getallheaders();
		try
		{
			//create object
			$p = new Person($_GET['id']);
			//start json
			$json = '{"status" : 0,
						"id" : "'.$p->get_id().'",
						"firstName" : "'.$p->get_lastname().'",
            "lastName": "'.$p->get_firstname().'",
						"photo" : "'.$p->get_photo().'",
            "email" : "'.$p->get_email().'",
            "phone" : "'.$p->get_phone().'",
						"house" : "'.$p->get_house().'",
						"role" : "'.$p->get_role().'"
						}';
			//display json
			echo $json;
		}
		catch (RecordNotFoundException $ex)
		{
			echo '{ "status" : 2, "errorMessage" : "'.$ex->get_message().'" }';
		}

?>
