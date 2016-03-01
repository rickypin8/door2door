<?php
	function generate_token()
	{
		//date
		$today = date_create();
		//token
		$token = '';
		
		//if 0 args received, generate token with date only
		if(func_num_args() == 0)
		{
			$token = sha1(date_format($today, 'Ymd'));
		}
		
		//if 1 arg received, gen token with user and date
		if(func_num_args() == 1)
		{
			//get usr_id
			$args = func_get_args();
			$user_id = $args[0];
			$token = sha1($user_id.(date_format($today, 'Ymd')));
		}
		return $token;
	}
?>

