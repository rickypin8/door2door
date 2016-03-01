<?php
	header('Access-Control-Allow-Origin: *');//todos
	header('Access-Control-Allow-Headers: person, token');//especificar cuales

	//use files
	require_once('classes/user.php');
	require_once('classes/generatetoken.php');

	$headers = getallheaders();

		if(
		  isset($_POST['txtuser'])
    & isset($_POST['txtpass'])
    & isset($_POST['person']))
		{
			try
			{
				$u = new User();
				$u->set_person($_POST['person']);
				$u->set_username($_POST['txtuser']);
				$u->set_password($_POST['txtpass']);

				if($u->add())
				{
					echo '{ "status" : 0,
					"message" : "Person added successfully" }';
				}
				else
					echo '{ "status" : 3, "errorMessage" : "Person not added" }';
			}
			catch (RecordNotFoundException $ex)
			{ echo '{ "status" : 2, "errorMessage" : "'.$ex->get_message().'" }'; }
		}
		else
			echo '{ "status" : 1, "errorMessage" : "Invalid Parameters" }';


?>
