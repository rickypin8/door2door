<?php
	header('Access-Control-Allow-Origin: *');//todos
	header('Access-Control-Allow-Headers: person, token');//especificar cuales

	//use files
	require_once('classes/payment.php');
	require_once('classes/generatetoken.php');

	$headers = getallheaders();

		if(
		  isset($_POST['resident'])
    & isset($_POST['amount'])
		& isset($_POST['receiver']))
		{
			if($headers['token'] == generate_token($headers['person']))
			{
				try
				{
					$p = new Payment();
					$p->set_person($_POST['resident']);
					$p->set_amount($_POST['amount']);
					$p->set_receiver($_POST['receiver']);

					if($p->add())
					{
						echo '{ "status" : 0,
										"message" : "Payment added successfully"
										}';
					}
					else
						echo '{ "status" : 3, "errorMessage" : "Person not added" }';
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
