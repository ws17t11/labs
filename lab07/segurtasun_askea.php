<?php //sesio hasiera 
	session_start();
	if (isset($_SESSION["eposta"]) && isset($_SESSION["SID"]) && isset($_SESSION["mota"]) && isset($_SESSION["image"])) {
		if ($_SESSION["SID"] != session_id()) {
			header("Location: logOut.php");  
			exit(); 
		} 
	}
?> 