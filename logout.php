<?php
    $_SESSION = array();
    session_destroy();
	
	if(isset($_COOKIE['SSID']))
	{
		unset($_COOKIE['SSID']);
		setcookie('SSID', null, time()-3600);
		setcookie('PHPSESSID', null, time()-3600);
	}
	
	header("Refresh: 0;url=index.php?refer=logout");
?>