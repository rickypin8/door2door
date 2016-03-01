<?php
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: person, token');

	//use files
	require_once('classes/person.php');
	require_once('classes/generatetoken.php');

	$headers = getallheaders();

	//make
		if(isset($_POST['txtid']))
		{
			if($headers['token'] == generate_token($headers['person']))
			{
				try
				{
					$p = new Person($_POST['txtid']);
					if($p->delete())
						echo '{ "status" : 0, "message" : "Person deleted successfully" }';
					else
						echo '{ "status" : 3, "errorMessage" : "Person not deleted" }';
				}
				catch (RecordNotFoundException $ex){
					echo '{ "status" : 3, "errorMessage" : "'.$ex->get_message().'" }';
				}
			}
			else
				echo '{ "status" : 2, "errorMessage" : "Invalid Token" }';
		}
		else
			echo '{ "status" : 1, "errorMessage" : "Invalid Parameters" }';

	?>
