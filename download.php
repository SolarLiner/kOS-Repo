<?php
include("include/database.php");

if(!$mysqli->connect_errno)
{
	if($stmt=$mysqli->prepare("SELECT Name, Author, Code, DL FROM scripts WHERE ID=?"))
	{
		$stmt->bind_param("i", $_GET['id']);
		$stmt->execute();
		//$result = $stmt->get_result();
		//$script = $result->fetch_assoc();
		$script = array();
		$stmt->bind_result($script['Name'], $script['Author'], $script['Code'], $script['DL']);
		$stmt->fetch();
		$stmt->close();
	}
	
	if($stmt=$mysqli->prepare("UPDATE scripts SET DL=? WHERE ID=?"))
	{
		$new_dl = intval($script['DL']) + 1;
			
		$stmt->bind_param("ii", $new_dl, $script['ID']);
		$stmt->execute();
		$stmt->close();
	}
	$script['Name'] = trim($script['Name']);
	
	$content = "// " . $script['Name'] . " by " . $script['Author'] . "\r\n";
	$content .= $script['Code'];
	
	$fname = str_replace(" ", "_", $script['Name']) . ".txt";
	
	header("Cache-Control: public");
	header("Content-Description: File Transfer");
	header("Content-Length: ". strlen($content).";");
	header("Content-Disposition: attachment; filename=" . $fname);
	header("Content-Type: text/plain; "); 
	header("Content-Transfer-Encoding: binary");
	
	echo $content;
} 
else
{
	echo "Connection error";
	echo $mysqli->connect_error;
}?>