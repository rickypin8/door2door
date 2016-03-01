<?php
	
	require_once('classes/service.php');
		$headers = getallheaders();
		try
		{
			//create object
			$s = new Service($_GET['id']);
			//start json
			$json = '{"status" : 0,
						"id" : "'.$s->get_id().'",
            "name": "'.$s->get_name().'",
						"description" : "'.$s->get_description().'",
            "price" : "'.$s->get_price().'"
						}';
			//display json
			echo $json;
		}
		catch (RecordNotFoundException $ex)
		{
			echo '{ "status" : 2, "errorMessage" : "'.$ex->get_message().'" }';
		}

?>
