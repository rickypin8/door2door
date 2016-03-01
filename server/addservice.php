<?php
	header('Access-Control-Allow-Origin: *');//todos
	header('Access-Control-Allow-Headers: person, token');//especificar cuales

	//use files
	require_once('classes/service.php');
	require_once('classes/generatetoken.php');

	$headers = getallheaders();

		if(
		  isset($_POST['txtname'])
    & isset($_POST['txtdescription'])
    & isset($_POST['txtprice']))
		{
			if($headers['token'] == generate_token($headers['person']))
			{
				try
				{
					$s = new Service();
					$s->set_name($_POST['txtname']);
					$s->set_description($_POST['txtdescription']);
					$s->set_price($_POST['txtprice']);

					if($s->add())
					{
						echo '{ "status" : 0,
										"message" : "Service added successfully",
										"id" : "'.$s->get_id().'"
										}';
					}
					else
						echo '{ "status" : 3, "errorMessage" : "Service not added" }';
				}
				catch (RecordNotFoundException $ex)
				{ echo '{ "status" : 2, "errorMessage" : "'.$ex->get_message().'" }'; }
			}
			else
				echo '{ "status" : 2, "errorMessage" : "Invalid Token" }';
		}
		else
			echo '{ "status" : 1, "errorMessage" : "Invalid Parameters" }';


?>
