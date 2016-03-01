<?php

	require_once('classes/user.php');
		$headers = getallheaders();
		try
		{
			//create object
			$u = new User($_POST['person']);
			//start json
			$json = '{
				"status" : 0,
				"username" : "'.$u->get_username().'",
				"person" : 
				{
					"id" : "'.$u->get_person()->get_id().'",
					"firstName" : "'.$u->get_person()->get_lastname().'",
					"lastName": "'.$u->get_person()->get_firstname().'",
					"photo" : "'.$u->get_person()->get_photo().'",
					"email" : "'.$u->get_person()->get_email().'",
					"phone" : "'.$u->get_person()->get_phone().'",
					"house" : "'.$u->get_person()->get_house().'",
					"role" : "'.$u->get_person()->get_role().'"
				}
			}';
			//display json
			echo $json;
		}
		catch (RecordNotFoundException $ex)
		{
			echo '{ "status" : 2, "errorMessage" : "'.$ex->get_message().'" }';
		}
?>
