<?php
		session_start();

		if (isset($_GET['erantzuna1'])) {
			 $erantzunak = array($_GET['erantzuna1']);
		}
		if (isset($_GET['erantzuna2'])) {
			 $erantzunak[] = $_GET['erantzuna2'];
		}
		if (isset($_GET['erantzuna3'])) {
			 $erantzunak[] = $_GET['erantzuna3'];
		}

		if (!isset($_GET['nick'])) {
			echo 'Errorea zure nick-a atzitzean';
			exit();
		}

		$nick = $_GET['nick'];

		//Datu basearekin konexioa sortu
    	include 'connect.php';

		$zuzenak = 0;
		$okerrak = 0;

		$zuzen_nick = 0;
		$oker_nick = 0;

		$nick_query = "SELECT * FROM nicks WHERE nick='$nick'";
		
		$nick_response = $link->query($nick_query); 

		while($row = $nick_response->fetch_assoc()){
			$zuzen_nick = $row['zuzen_gaia'];
			$oker_nick = $row['oker_gaia'];
		} 
		
		for ($i = 1; $i <= count($_SESSION['subjectCorrect']); $i++) {
			if(strcmp($erantzunak[$i-1], $_SESSION['subjectCorrect'][$i-1])==0){
				$zuzenak++;
				$zuzen_nick++;
				echo '<font color="green">'. $i .'. erantzuna: ZUZENA!</font><br>';
			} else {
				$okerrak++;
				$oker_nick++;
				echo '<font color="red">'. $i .'. erantzuna: OKERRA!</font><br>';
			}
		}
		
		if (!$nick_response) {
			echo 'Zure emaitzak ez dira datu basean eguneratu. <br>';
		} else {
			$update_query = "UPDATE nicks SET zuzen_gaia='$zuzen_nick', oker_gaia='$oker_nick' WHERE nick='$nick'";
			$update_response = $link->query($update_query);
			if (!$update_response) {
				echo 'Zure emaitzak ez dira datu basean eguneratu. <br>';
			}
		}

		echo "<br>Asmatze tasa: ". $zuzenak . "/" . ($zuzenak+$okerrak) . "<br>";
		echo "Galderen batazbesteko zailtasuna: " . $_SESSION['playBySubjectZailtasuna'];

		mysqli_close($link);

?>
