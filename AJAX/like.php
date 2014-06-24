<?php
if (isset($_POST['rate']))
{
	$rating = $_POST['rate']*2;

	include ("/include/database.php");

	if ($stmt = $mysqli -> prepare("INSERT INTO likes(ID, sID, Rank) VALUES(null, ?, ?)"))
	{
		$stmt -> bind_param("ii", $_GET['ID'], $rating);
		$stmt->execute();
		$stmt->close();
		
		$msg = "Rated !";
	} else $msg = "Oh noes !";
} else $msg = "Oh noes !";

echo $msg;
?>