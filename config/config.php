<?php
 	define("ORGID", "");
 	define("USERNAME", "");
 	define("PASSWORD", "");
 	define('SERVICEURL', 'hipaadev.us'); 	
 	define("CLIENTID", "kXpy8tUuC6S2n0fE7cDd5xmLPha3BRGs");
 	define("CLIENTSECURITY", "MqHKRbJDkEgSGXscwmor");

 	function CurPage(){
 		$path = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
 		$names = explode(".",$path); 		
 		$_SESSION['page'] = $names[0]; 		
 	}
 	CurPage();
 ?>
