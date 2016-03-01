<?php
	
	require_once('classes/catalogs.php');
		$headers = getallheaders();
		try
		{
			//create object
			$persons = Catalogs::get_persons();
			//start json
			$json = '{"status" : 0,
			"persons" : [';
			$first = true;
			foreach($persons as $p)
			{
				if($first) $first = false; else $json .= ',';
				$json .= '{ "id" : "'.$p->get_id().'", 
				"firstName" : "'.$p->get_lastname().'",
				"lastName": "'.$p->get_firstname().'",
				"photo" : "'.$p->get_photo().'",
				"email" : "'.$p->get_email().'",
				"phone" : "'.$p->get_phone().'",
				"house" : "'.$p->get_house().'",
				"role" : "'.$p->get_role().'" }';
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
