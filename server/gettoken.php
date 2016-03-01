<?php
	//allow access to API
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: user, password');
	//use files
	require_once('classes/person.php');
	require_once('classes/generatetoken.php');
	//read headers
	$headers = getallheaders();
	//check if headers were received
	if (isset($headers['user']) & isset($headers['password']))
	{
		try
		{
			//create object
			$u = new User($headers['user'], $headers['password']);
			//display json
			echo '{ "status" : 0,
							"user" :"'.$u->get_id().'",
							"name" : "'.$u->get_firstName().' '.$u->get_lastName().'",
							"role" : '.$u->get_role().',
							"token" : "'.generate_token($u->get_id()).'",
							"photo" : "'.$u->get_photo().'"
						}';
		}
		catch(RecordNotFoundException $ex)
		{
			echo '{ "status" : 1, "errorMessage" : "'.$ex->get_message().'" }';
		}
	}
	else
		echo '{ "status" : 2, "errorMessage" : "Invalid Headers" }';
?>
