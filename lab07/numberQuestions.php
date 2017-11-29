<?php
	$xml = simplexml_load_file('xml/questions.xml');
	if ($xml && isset($_SESSION['eposta'])) {
		$n = 0;
    	$erab = 0;
		foreach ($xml->assessmentItem as $question){
			$n = $n + 1;
			if ($question['author'] == $_SESSION['eposta']) {
				$erab = $erab + 1;
			}
		}
		echo "<p> <strong> XML fitxategian $n galdera daude, zureak $erab izanik. </strong> </p>";
	} else {
		echo "<p> Ezin izan da XML fitxategia ireki zure galdera kopuruak erakusteko. </p>";
	}
?>
