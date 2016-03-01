<?php
	header('Access-Control-Allow-Origin: *');//todos
	header('Access-Control-Allow-Headers: person, token');//especificar cuales

	//use files
	require_once('classes/spending.php');
	require_once('classes/generatetoken.php');

	$headers = getallheaders();

		if(
		  isset($_POST['period'])
    & isset($_POST['service'])
    & isset($_POST['buyer']))
		{
			if($headers['token'] == generate_token($headers['person']))
			{
				try
				{
					$s = new Spending();
					$s->set_service($_POST['service']);
					$s->set_period($_POST['period']);
					$s->set_buyer($_POST['buyer']);
					if(isset($_POST['txtamount'])) $s->set_amount($_POST['txtamount']);
					else $s->set_amount($s->get_service()->get_price());

					if($s->add())
					{
						echo '{ "status" : 0,
										"message" : "Spending added successfully",
										"id" : "'.$s->get_id().'"
										}';
									}
					else
						echo '{ "status" : 3, "errorMessage" : "Spending not added" }';
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
