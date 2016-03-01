<?php
		require_once('classes/catalogs.php');
		
		$residents = Catalogs::get_residents();

		try
		{
			//create object
			//start json
			
			//period catalog as to not repeat it for each resident
			$periods = Catalogs::get_periods(null);
			
			$json = '{"status" : 0,
			"residents" : [';
			
			$first = true;
			foreach($residents as $r)
			{
				$funds = 0.0;
				foreach($r->get_payments() AS $pay)
					$funds += $pay->get_amount();
				if($first) $first = false; else $json .= ',';
				$json .= '{
					"id" : "'.$r->get_id().'",
					"firstName" : "'.$r->get_lastname().'",
					"lastName": "'.$r->get_firstname().'",
					"photo" : "'.$r->get_photo().'",
					"email" : "'.$r->get_email().'",
					"phone" : "'.$r->get_phone().'",
					"house" : "'.$r->get_house().'",
					"role" : "'.$r->get_role().'"
				';
				$json .=', "periods" : [';
				$periodStartDate = substr($r->get_entryDate(), 0, 7);
				$periodStartDate .= '-01';
				//echo $periodStartDate;
				$first = true;
				$enoughFunds = true; //variable to prevent later funds to be set as paid because former payments had more cost
				foreach($periods as $p)
				{
					$isPaid = -1;
					if($p->get_pdate() >= $periodStartDate)
					{
						if($enoughFunds & $funds >= $p->get_amount())
						{
							$isPaid = 1;
						}
						else
						{
							$enoughFunds = false;
							$isPaid  = 0;
						}
						$funds -= $p->get_amount();
					}
					if($first) $first = false; else $json .= ',';
					$json .= '{
						"id" : "'.$p->get_id().'",
						"date" : "'.$p->get_pdate().'",
						"amount" : '.$p->get_amount().',
						"debtRate" : '.$p->get_debtRate().',
						"isPaid" : "'.$isPaid.'"
					}'; //isPaid: 0 = no, 1 = yes, -1 = not applicable
				}
				$json .= '], "balance" : "'.$funds.'"}';
				//funds summed and placed here to lessen DB stress
			}
			$json .= ']
			
			}';
			//display json
			echo $json;
		}
		catch (RecordNotFoundException $ex)
		{
			echo '{ "status" : 2, "errorMessage" : "'.$ex->get_message().'" }';
		}

?>
