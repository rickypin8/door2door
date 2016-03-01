<?php
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Headers: person, token');

	//use files
	require_once('classes/user.php');
	require_once('classes/generatetoken.php');

	$headers = getallheaders();

		if(
		  isset($_POST['txtuser'])
    & isset($_POST['txtoldpass'])
    & isset($_POST['txtnewpass']))
		{
			//if($headers['token'] == generate_token($headers['person']))
			//{
				try
				{
					$u = new User($_POST['txtuser'], $_POST['txtoldpass']);
					$u->set_password($_POST['txtnewpass']);

					if($u->update())
					{
						echo '{ "status" : 0,
							"message" : "Password updated succesfully" }';
					}
					else
						echo '{ "status" : 3, "errorMessage" : "Password not updated" }';
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
