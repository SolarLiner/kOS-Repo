<?php
$category = array(  "Launch",
					"Orbital Maneuvers",
					"Landing", 
					"Atmosphere Autopilot",
					"I/O Operations",
					"Utility",
					"Other");
					
function GetCatIndex($text)
{
	foreach ($category as $key => $entry)
	{
		if($entry == $text) return $key;
	}
	
	return 6;
}

$type = array(  "One-Time run script",
				"Function",
				"Utility script",
				"Other");
				
function GetTypeIndex($text)
{
	foreach ($type as $key => $entry)
	{
		if($entry == $text) return $key;
	}
	
	return 3;
}

$CSSclass = array(  "launch",
					"orb-mnv",
					"landing",
					"atm-ap",
					"io",
					"utils",
					"other");
				
?>