<?php
include("include/database.php");

$active_session = isset($_SESSION['ID']);
if($active_session) $active_session = !empty($_SESSION['Name']);

if(!$active_session && isset($_COOKIE['SSID'])){
	
	if($stmt=$mysqli->prepare("SELECT ID, Name FROM users WHERE SSID = ?"))
	{
		$stmt->bind_param("s", $_COOKIE['SSID']);
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result($id, $name);
		$stmt->fetch();
		
		if($stmt->num_rows != 0)
		{
			$active_session=true;
			
			$_SESSION['ID'] = $id;
			$_SESSION['Name'] = $name;
		}
		unset($id);
		unset($name);
	}
}
?>