<?php //sesio hasiera 
	session_start();
	if (!isset($_SESSION["eposta"]) || !isset($_GET["eposta"]) || !isset($_SESSION["SID"]) || !isset($_SESSION["mota"])) {
		header("Location: login.php");  
		exit(); 
	} else if ($_SESSION["eposta"] != $_GET["eposta"]) { 
		header("Location: login.php");  
		exit(); 
	} else if ($_SESSION["SID"] != session_id()) {
		header("Location: login.php");  
		exit(); 
	}
?> 
