<?php
		session_start();

		$erantzuna = $_GET['erantzuna'];

		if(strcmp($erantzuna, $_SESSION['onePlayCorrect'])==0){
				echo '<br><font color="green">ZUZENA!</font><br>';
		}
		else{
				echo '<br><font color="red">OKERRA!</font><br>';
		}


?>
