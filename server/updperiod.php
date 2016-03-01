<?php
	header('Access-Control-Allow-Origin: *');//todos
	header('Access-Control-Allow-Headers: person, token');//especificar cuales

	//use files
	require_once('classes/period.php');
	require_once('classes/generatetoken.php');

	$headers = getallheaders();

		if(
		  isset($_POST['txtdate'])
    & isset($_POST['id'])
    & isset($_POST['txtamount'])
    & isset($_POST['txtdebtrate']))
		{
			//if($headers['token'] == generate_token($headers['person']))
			//{
				try
				{
					$p = new Period($_POST['id']);
					$p->set_pdate($_POST['txtdate']);
					$p->set_amount($_POST['txtamount']);
					$p->set_debtRate($_POST['txtdebtrate']); // Fecha debe ser formato YYYY-mm-DD

					if($p->update())
					{
						echo '{ "status" : 0,
										"message" : "Period updated successfully"
										}';
					}
					else
						echo '{ "status" : 3, "errorMessage" : "Period not updated" }';
				}
				catch (RecordNotFoundException $ex)
				{ echo '{ "status" : 2, "errorMessage" : "'.$ex->get_message().'" }'; }
			//}
			//else
			//	echo '{ "status" : 2, "errorMessage" : "Invalid Token" }';
		}
		else
			echo '{ "status" : 1, "errorMessage" : "Invalid Parameters" }';


?>
