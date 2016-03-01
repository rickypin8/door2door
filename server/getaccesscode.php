<?php
	//use files
	require_once('classes/person.php');
	require_once('classes/generatecode.php');
	
	//verify parameters
	try
	{
		$json = '{ "status" : 0';
		//create object
		$p = new Person($_GET['id']);
		//start json
		$json .= ', "person" : {
			"id" : "'.$p->get_id().'",
			"firstName" : "'.$p->get_lastname().'",
			"lastName": "'.$p->get_firstname().'",
			"photo" : "'.$p->get_photo().'",
			"email" : "'.$p->get_email().'",
			"phone" : "'.$p->get_phone().'"
		},
		"accessCode" : "'.generate_code($p->get_id()).'"';
		
		//display json
		$json .= '}';
		echo $json;
	}
	catch (RecordNotFoundException $ex)
	{
		echo '{ "status" : 1, "errorMessage" : "'.$ex->get_message().'" }';
	}
?>
