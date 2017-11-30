<?php //sesio hasiera
	session_start();
	if (!isset($_SESSION["eposta"]) || !isset($_SESSION["SID"]) || !isset($_SESSION["mota"])) {
		//header("Location: logIn.php");
		echo "<script>location.href='logIn.php';</script>";
		exit();
	} else if ($_SESSION["SID"] != session_id()) {
		//header("Location: logIn.php");  
		echo "<script>location.href='logIn.php';</script>";
		exit();
	}
?>
