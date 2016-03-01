<?php
	//use files
	require_once('classes/catalogs.php');
	//check if headers were received
	try
	{
		$p = Catalogs::get_newestPayment();
		echo '{"status" : 0, "id" : "'.$p->get_id().'", "periodDate" : "'.$p->get_pdate().'", "amount" : '.$p->get_amount().' }';
	}
	catch(RecordNotFoundException $ex)
	{
		echo '{ "status" : 1, "errorMessage" : "'.$ex->get_message().'" }';
	}
?>
