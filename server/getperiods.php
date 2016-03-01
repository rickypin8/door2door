<?php
		require_once('classes/catalogs.php');
		
		$headers = getallheaders();
		try
		{
			//get objects
			$prds = Catalogs::get_periods(null);
			
			//start json
			$json = '{"status" : 0,
				"periods" : [';
				$first = true;
				foreach($prds as $p)
				{
					if(!$first) $json .= ','; else $first = false;
					$json .= '{
							"id" : "'.$p->get_id().'",
							"date" : "'.$p->get_pdate().'",
							"amount" : '.$p->get_amount().',
							"debtRate" : '.$p->get_debtRate().'
						}';
				}
			$json .= ']}';
			//display json
			echo $json;
		}
		catch (RecordNotFoundException $ex)
		{
			echo '{ "status" : 2, "errorMessage" : "'.$ex->get_message().'" }';
		}

?>
