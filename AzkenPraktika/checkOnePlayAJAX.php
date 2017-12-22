<?php
		session_start();

		$erantzuna = $_GET['erantzuna'];
		$nick = $_GET['nick'];

		//Datu basearekin konexioa sortu
    	include 'connect.php';

		$nick_query = "SELECT * FROM nicks WHERE nick='$nick'";

		$zuzen_rand = 0;
		$oker_rand = 0;

		$nick_response = $link->query($nick_query);

		while($row = $nick_response->fetch_assoc()){
			$zuzen_rand = $row["zuzen_rand"] + 1;
			$oker_rand = $row["oker_rand"] + 1;
		} 

		$update_right_query = "UPDATE nicks SET zuzen_rand='$zuzen_rand' WHERE nick='$nick'";
		$update_wrong_query = "UPDATE nicks SET oker_rand='$oker_rand' WHERE nick='$nick'";

		if (mysqli_num_rows($nick_response) === 1) {
			if (strcmp($erantzuna, $_SESSION['onePlayCorrect'])==0) {
				$link->query($update_right_query);
				echo '<font color="green">ZUZENA!</font><br>';
			} else {
				$link->query($update_wrong_query);
				echo '<font color="red">OKERRA!</font><br>';
			}
		} else {
			if (strcmp($erantzuna, $_SESSION['onePlayCorrect'])==0) {
				echo '<font color="green">ZUZENA!</font><br> Baina zure emaitza ez da datu basean gehitu, nicka ez baita aurkitu.';
			} else {
				echo '<font color="red">OKERRA!</font><br> Baina zure emaitza ez da datu basean gehitu, nicka ez baita aurkitu.';
			}
		}
    
		mysqli_close($link);

?>
