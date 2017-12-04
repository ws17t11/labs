<?php
		session_start();

		echo "<h1> Ausazko galdera </h1> <br/>";

		//Datu basearekin konexioa sortu
		include 'connect.php';

		//lortu ausazko galdera bat
		$sql_guztiak = "SELECT * FROM questions";

		$guztiak_result = $link->query($sql_guztiak);
		if(! $guztiak_result){
			 echo "Errorea datu basea atzitzean";
			 exit();
		}

		$nrows_guztira = mysqli_num_rows($guztiak_result);

		if(isset($_SESSION['onePlayRepeated'])){
				if(count($_SESSION['onePlayRepeated'])==$nrows_guztira){
						echo "Dagoeneko galdera guztiak erantzun dituzu!";
						exit();
				}
		}


		//lortu ausazko galdera bat
		$sql = "SELECT * FROM questions ORDER BY RAND() LIMIT 1";

		$galdera_result = $link->query($sql);
		if(! $galdera_result){
			 echo "Errorea datu basea atzitzean";
		}

		$galdera_info = $galdera_result->fetch_assoc();

		if (! isset($_SESSION['onePlayRepeated'])){
				//$s = array($galdera_info['id']); //create an array to store the repeated questions
				$_SESSION['onePlayRepeated'][] = $galdera_info['id']; //save the array in the current SESSION
		}
		else{
				$aurkituta = 0;
				while($aurkituta==0){
						if(! in_array($galdera_info['id'], $_SESSION['onePlayRepeated'])){
							 	$aurkituta = 1;
						}
						else{
								//lortu ausazko galdera bat
								$sql = "SELECT * FROM questions ORDER BY RAND() LIMIT 1";
								$galdera_result = $link->query($sql);
								if(! $galdera_result){
									 echo "Errorea datu basea atzitzean";
									 exit();
								}
								$galdera_info = $galdera_result->fetch_assoc();
						}
				}
				$_SESSION["onePlayRepeated"][] = $galdera_info['id']; //sartu errepikatuen bektorera
		}

		//shuffle randomly the options for the selected question
		$aukerak = array($galdera_info['zuzena'], $galdera_info['okerra1'], $galdera_info['okerra2'], $galdera_info['okerra3']);
		shuffle($aukerak);

		echo 	"Enuntziatua: $galdera_info[galdera] <br>";
		echo 	'<input type="radio" name="erantzuna" value="'. $aukerak[0] . '">' . $aukerak[0] . '<br>';
		echo 	'<input type="radio" name="erantzuna" value="'. $aukerak[1] . '">' . $aukerak[1] . '<br>';
		echo 	'<input type="radio" name="erantzuna" value="'. $aukerak[2] . '">' . $aukerak[2] . '<br>';
		echo 	'<input type="radio" name="erantzuna" value="'. $aukerak[3] . '">' . $aukerak[3] . '<br>';

		//gorde erantzun zuzena sesioan
		$_SESSION['onePlayCorrect'] = $galdera_info['zuzena'];


?>
