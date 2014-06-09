<?php
$mysqli = new mysqli("localhost", "SolarLiner", "CptGRNwRu2LQfThw", "kosrepo");
//$mysqli = new mysqli("mysql16.000webhost.com", "a4228718_sliner", "CptGRNwRu2LQfThw", "a4228718_kosrepo")

function FetchArray($stmt, $name)
{
	$metaResults = $stmt->result_metadata();
	$fields = $metaResults->fetch_fields();
	$statementParams='';
	 //build the bind_results statement dynamically so I can get the results in an array
	 foreach($fields as $field){
	     if(empty($statementParams)){
	         $statementParams.="\$$name['".$field->name."']";
	     }else{
	         $statementParams.=", \$$name['".$field->name."']";
	     }
	}
	$statment="\$stmt->bind_result($statementParams);";
	eval($statment);
}
?>
