<?php
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: person, token');

	//use files
	require_once('classes/person.php');
	require_once('classes/generatetoken.php');

	$headers = getallheaders();

		if(isset($_POST['txtid'])
    & isset($_POST['txtfirstname'])
    & isset($_POST['txtlastname'])
    & isset($_POST['txtphone'])
    & isset($_POST['txtemail'])
    & isset($_POST['photo'])
		& isset($_POST['role']))
		{
			//if($headers['token'] == generate_token($headers['person']))
			//{
				try
				{
					$p = new Person($_POST['id']);
					$p->set_firstname($_POST['txtfirstname']);
					$p->set_lastname($_POST['txtlastname']);
					$p->set_phone($_POST['txtphone']);
					$p->set_email($_POST['txtemail']);
					$p->set_photo($_POST['photo']);

					if($p->update() & $p->changeRole($_POST['role']))
					{
						echo '{ "status" : 0,
										"message" : "Person updated successfully"
										}';
					}
					else
						echo '{ "status" : 3, "errorMessage" : "Person not updated" }';
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
