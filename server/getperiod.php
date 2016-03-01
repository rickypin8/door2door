<?php
	
	require_once('classes/period.php');
		$headers = getallheaders();
		try
		{
			//create object
			$p = new Period($_GET['id']);
			//start json
			$json = '{"status" : 0,
						"id" : "'.$p->get_id().'",
            "date": "'.$p->get_pdate().'",
						"amount" : "'.$p->get_amount().'",
            "debtRate" : "'.$p->get_debtRate().'"
						}';
			//display json
			echo $json;
		}
		catch (RecordNotFoundException $ex)
		{
			echo '{ "status" : 2, "errorMessage" : "'.$ex->get_message().'" }';
		}

?>
