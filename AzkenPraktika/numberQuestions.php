<?php
	session_start();
	//Datu basearekin konexioa sortu
	include 'connect.php';

	//lortu datu baseko galderak
	$sql = "SELECT * FROM questions WHERE eposta='$_SESSION[eposta]'";
	$nireak_result = $link->query($sql);
	if(! $nireak_result){
		 echo "Errorea datu basea atzitzean";
	}

	$nrows_nireak = mysqli_num_rows($nireak_result);

	//lortu datu baseko galderak
	$sql2 = "SELECT * FROM questions";
	$guztira_result = $link->query($sql2);
	if(! $guztira_result){
		 echo "Errorea datu basea atzitzean";
	}

	$nrows_guztira = mysqli_num_rows($guztira_result);

	echo "<p>Datu basean $nrows_guztira galdera dadude, zureak $nrows_nireak direlarik.</p>";

?>
