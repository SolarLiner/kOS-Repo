Rainbow.extend('kos', [
	{
		'name':'comment',
		
		'pattern': /\/\/.*/g
	},
	
	{
		'name':'string',
		'pattern': /\"[\s\S]*?\"/g		
	},
	
	{
		'name':'keyword',
		'pattern': /\b(set|print|until|if|switch|copy|from|delete|declare|edit|list|lock|on|off|rename|run|toggle|unlock|wait|when|to)\b/g
	},
	
	{
		'name':'entity',
		'pattern': /\b(sin|cos|tan|arcsin|arccos|arctan|arctan2|abs|R)\b/g
	},
	
	{
		'name':'constant',
		'pattern': /\b(target|stage|all|vesselname|altitude|radar|missiontime|velocity|then|abort|ag1|ag2|ag3|ag4|ag5|ag6|ag7|ag8|ag9|ag10|volume|volumes|file|files|parts|resources|engines|targets|bodies|parameter|at|VESSEL|landed|splashed|flying|sub_orbital|orbiting|escaping|docked|liquidfuel|oxidizer|electriccharge|intakeair|solidfuel|major|minor|throttle|steering|wheelthrottle|wheelsteering|brakes|gear|legs|chutes|lights|rcs|sas|altitude|alt|apoapsis|periapsis|eta|sessiontime|warp|angularmomentum|angularvel|surfacespeed|verticalspeed|facing|geoposition|heading|latitude|longitude|mag|node|north|prograde|retrograde|up|body|mass|maxthrust|status|commrange|incommrange|inlight|version)\b/g
	}
]);
