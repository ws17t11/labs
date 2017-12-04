<?php
		session_start();

		if(isset($_GET['erantzuna1'])){
			 $erantzunak = array($_GET['erantzuna1']);
		}
		if(isset($_GET['erantzuna2'])){
			 $erantzunak[] = $_GET['erantzuna2'];
		}
		if(isset($_GET['erantzuna3'])){
			 $erantzunak[] = $_GET['erantzuna3'];
		}

		$zuzenak = 0;
		$okerrak = 0;

		echo "<br>";
		
		for ($i = 1; $i <= count($_SESSION['subjectCorrect']); $i++) {
			if(strcmp($erantzunak[$i-1], $_SESSION['subjectCorrect'][$i-1])==0){
					$zuzenak++;
					echo '<font color="green">'. $i .'. erantzuna: ZUZENA!</font><br>';
			}
			else{
					$okerrak++;
					echo '<font color="red">'. $i .'. erantzuna: OKERRA!</font><br>';
			}
		}

		echo "<br>Asmatze tasa: ". $zuzenak . "/" . ($zuzenak+$okerrak) . "<br>";
		echo "Galderen batazbesteko zailtasuna: " . $_SESSION['playBySubjectZailtasuna'];



?>
