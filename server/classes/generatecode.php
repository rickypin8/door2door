<?php
	function generate_code()
	{
		$code = 'Unavailible';
		if(func_num_args() == 1)
		{
			//get usr_id
			$today = date_create();
			$args = func_get_args();
			$user_id = $args[0];
			//Codigo checar si persona cumplio con pago
			$keyword = 'waza';
			$code = substr((sha1($keyword.(date_format($today, 'Ymd')))), 0, 4);
		}
		return $code;
	}
?>

