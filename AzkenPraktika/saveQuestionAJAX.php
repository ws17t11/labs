<?php

	if (isset($_POST['id']) && isset($_POST['galdera']) && isset($_POST['ema']) && isset($_POST['oker1']) && isset($_POST['oker2']) && isset($_POST['oker3']) && isset($_POST['zail']) && isset($_POST['gaia'])) {
		
		$id = trim($_POST['id']);
		$gal = trim($_POST['galdera']);
		$ema = trim($_POST['ema']);
		$oker1 = trim($_POST['oker1']);
		$oker2 = trim($_POST['oker2']);
		$oker3 = trim($_POST['oker3']);
		$zail = $_POST['zail'];
		$gaia = trim($_POST['gaia']);

		if (!is_numeric($id) || $id <= 0) {
			echo 'ID parametroak zenbaki arrunt positibo bat izan behar du';
			exit();
		}
		if(strlen($gal) < 10) {
			echo "Galderak 10 karaktere baino gehiago izan behar ditu.";
			exit();
		}
		if(strlen($ema)==0){
			echo "Erantzun zuzena ezin daiteke hutsik egon!";
			exit();
		}
		if(strlen($oker1)==0 || strlen($oker2)==0 || strlen($oker3)==0){
			echo "Erantzun okerren bat hutsik dago";
			exit();
		}
		if (!is_numeric($zail) || $zail <= 0 || $zail > 5) {
			echo 'Zailtasunak zenbaki arrunt positibo bat izan behar du, 1 eta 5 artean';
			exit();
		}
		if(strlen($gaia)==0  || preg_match('/^[a-zA-Z0-9]+$/', $gaia) != 1) {
			echo "Gaiak ezin du hutsik egon";
			exit();
		}

		include 'connect.php';

		$taula = $link->query("UPDATE questions SET galdera='$gal', zuzena='$ema', okerra1='$oker1', okerra2='$oker2', okerra3='$oker3', zailtasuna='$zail', gaia='$gaia' WHERE id='$id'");

		if ($taula === true) {
			echo "Galdera eguneratu da!";
		} else {
			echo "Errorea galdera datubasean eguneratzean";
		}
		mysqli_close($link);
	} else {
		echo 'Parametroak betetzeko falta dira: ' . $_POST['id'] . $_POST['galdera'] . $_POST['ema'] . $_POST['oker1'] . $_POST['oker2'] . $_POST['oker3'] . $_POST['zail'] . $_POST['gaia'];
	}
?>