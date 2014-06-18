<?php
    $_SESSION = array();
    session_destroy();
	
	header("Refresh: 0;url=index.php?refer=logout");
?>