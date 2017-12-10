<?php

	if (isset($_GET['id'])) {
		
		$id = trim($_GET['id']);

		if (!is_numeric($id) || $id <= 0) {
			echo 'ID parametroak zenbaki arrunt positibo bat izan behar du';
			exit();
		}

		include 'connect.php';

		$galdera = $link->query("SELECT * FROM questions WHERE id=$id");
		$taula = $link->query("DELETE FROM questions WHERE id=$id");

		if ($taula === true) {
			$n = mysqli_num_rows($galdera); 
			if ($n == 0) {
				echo "Galdera ez da datu basean aurkitu!";
			}  else {
				echo "Galdera ezabatu da!";
			}
		} else {
			echo "Errorea galdera datubasetik ezabatzean";
		}
		mysqli_close($link);
	} else {
		echo 'Eskaera ezin izan da bete.';
	}
?>