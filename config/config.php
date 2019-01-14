<?php
 	define("ORGID", "a0C550000001a0tEAA");
 	define("USERNAME", "widadsaghir1993@gmail.com");
 	define("PASSWORD", "ahgifrhehdejd1!");
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