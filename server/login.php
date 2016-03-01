<?php

	require_once('classes/user.php');
	require_once('classes/generatetoken.php');
	
	try
	{
		//create object
		$u = new User($_POST['user'], $_POST['pass']);
		//start json
		$json = '{
			"status" : 0,
			"person" : {
				"id" : "'.$u->get_person()->get_id().'",
				"firstName" : "'.$u->get_person()->get_lastname().'",
				"lastName": "'.$u->get_person()->get_firstname().'",
				"fullName": "'.$u->get_person()->get_fullname().'",
				"photo" : "'.$u->get_person()->get_photo().'",
				"email" : "'.$u->get_person()->get_email().'",
				"phone" : "'.$u->get_person()->get_phone().'",
				"house" : "'.$u->get_person()->get_house().'",
				"role" : "'.$u->get_person()->get_role().'"
			},
			"username" : "'.$u->get_username().'",
			"token" : "'.generate_token($u->get_username()).'"
		}';
		//display json
		echo $json;
	}
	catch (RecordNotFoundException $ex)
	{
		echo '{ "status" : 2, "errorMessage" : "'.$ex->get_message().'" }';
	}
?>
