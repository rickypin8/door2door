<?php
	header('Access-Control-Allow-Origin: *');//todos
	header('Access-Control-Allow-Headers: person, token');//especificar cuales

	//use files
	require_once('classes/period.php');
	require_once('classes/generatetoken.php');

	$headers = getallheaders();

		if(
		  isset($_POST['txtdate'])
    & isset($_POST['txtamount'])
    & isset($_POST['txtdebtRate']))
		{
			if($headers['token'] == generate_token($headers['person']))
			{
				try
				{
					$p = new Period();
					$p->set_pdate($_POST['txtdate']);
					$p->set_amount($_POST['txtamount']);
					$p->set_debtRate($_POST['txtdebtRate']);

					if($p->add())
					{
						echo '{ "status" : 0,
										"message" : "Period added successfully",
										"id" : "'.$p->get_id().'"
										}';
					}
					else
						echo '{ "status" : 3, "errorMessage" : "Period not added" }';
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
