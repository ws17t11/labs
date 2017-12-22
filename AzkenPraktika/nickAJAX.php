<?php
	
	if (isset($_GET["nick"])) {
		
		$nick = trim($_GET["nick"]);

        if (strlen($nick) <= 5) {
			echo "Zure izengoitiak ezin ditu 6 baino karaktere gutxiago izan.";
			exit();
        }

        if (strcmp($nick, "anonimoa") === 0) {
			echo "2,anonimoa"; // ANONIMO BEZALA LOGEATUTA
			exit();
        }
        
        //Datu basearekin konexioa sortu
    	include 'connect.php';
    
		//sartu balioak questions taulan
		$nick_query = "SELECT * FROM nicks WHERE nick='$nick'";
		$nick_save = "INSERT INTO nicks (nick, zuzen_rand, oker_rand, zuzen_gaia, oker_gaia) VALUES ('$nick', '0', '0', '0', '0')";
		
		$nick_response = $link->query($nick_query); 

		if ($nick_response) {
			$nick_n = mysqli_num_rows($nick_response);
			if ($nick_n === 0) {
				$nick_response_2 = $link->query($nick_save);
				if ($nick_response_2) {
					echo "0,$nick"; // ZURE NICKA SORTU DA
				} else {
					echo "Errorea zure nicka datu basean gordetzean";
				}
			} else {
				echo "1,$nick"; // ZURE NICKA EXISTITZEN DA
			}
		} else {
			echo "Errorea datu basearekin konektatzerakoan";
		}

		mysqli_close($link);

	} else {
		echo "Errorea zure nicka eskuratzean...";
	}

?>