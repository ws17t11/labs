<?php
		session_start();

		$gaia = $_GET['gaia'];

		echo "<h1> $gaia-ko galderak </h1> <br/>";

		//Datu basearekin konexioa sortu
		include 'connect.php';

		//lortu ausazko galdera bat
		$sql = "SELECT * FROM questions WHERE gaia='$gaia' ORDER BY RAND() LIMIT 3";

		$galderak_result = $link->query($sql);
		if(! $galderak_result){
			 echo "Errorea datu basea atzitzean";
		}

		if(isset($_SESSION['subjectCorrect'])){
				unset($_SESSION['subjectCorrect']);
		}

		$kont = 1;
		$zailtasun_bb = 0;
		while($row = $galderak_result->fetch_assoc()){
				//shuffle randomly the options for the selected question
				$aukerak = array($row['zuzena'], $row['okerra1'], $row['okerra2'], $row['okerra3']);
				shuffle($aukerak);



				echo 	"" . $kont . ") $row[galdera]<br>";

				if(strcmp($row['irudia'], "")!=0){
						echo "<img src=" . '"data:image/jpeg;base64,'.base64_encode( $row['irudia'] ).'" width="100"/><br>';
				}

				echo 	'<input type="radio" name="erantzuna' . $kont . '" value="'. $aukerak[0] . '"> ' . $aukerak[0] . '<br>';
				echo 	'<input type="radio" name="erantzuna' . $kont . '" value="'. $aukerak[1] . '"> ' . $aukerak[1] . '<br>';
				echo 	'<input type="radio" name="erantzuna' . $kont . '" value="'. $aukerak[2] . '"> ' . $aukerak[2] . '<br>';
				echo 	'<input type="radio" name="erantzuna' . $kont . '" value="'. $aukerak[3] . '"> ' . $aukerak[3] . '<br>';
				echo '<br>';

				//gorde erantzun zuzena sesioan
				$_SESSION['subjectCorrect'][] = $row['zuzena'];

				//batazbesteko zailtasuna eguneratu
				$zailtasun_bb += $row['zailtasuna'];

				$kont++;
		}

		$_SESSION['playBySubjectZailtasuna'] = round($zailtasun_bb/($kont-1));


?>
