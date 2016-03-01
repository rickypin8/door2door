<?php
		require_once('classes/catalogs.php');
		
		$headers = getallheaders();
		try
		{
			//get objects
			$srvs = Catalogs::get_services();
			
			//start json
			$json = '{"status" : 0,
				"periods" : [';
				$first = true;
				foreach($srvs as $s)
				{
					if(!$first) $json .= ','; else $first = false;
					$json .= '{
							"id" : "'.$s->get_id().'",
							"name" : "'.$s->get_name().'",
							"description" : "'.$s->get_description().'",
							"price" : '.$s->get_price().'
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
