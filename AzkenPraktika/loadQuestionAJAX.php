<?php

	include 'connect.php';

	$id = trim($_GET['id']);

	$taula = $link->query("SELECT * FROM questions WHERE id=$id");
	$n = mysqli_num_rows($taula);

	if ($n == 1) {
		while($row = $taula->fetch_assoc()){
			echo("$row[id],$row[eposta],$row[galdera],$row[zuzena],$row[okerra1],$row[okerra2],$row[okerra3],$row[zailtasuna],$row[gaia]");
		}
	} 

	mysqli_close($link);
?>