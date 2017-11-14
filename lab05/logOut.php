<?php
	$xml = simplexml_load_file('xml/counter.xml');
	if ($xml && $xml->counter > 0) {
		$xml->counter = $xml->counter - 1;
		$xml->asXML('xml/counter.xml');
	} else if (!$xml) {
		echo "<p> Ezin izan da XML fitxategia ireki online erabiltzaile kopurua gehitzeko.</p>";
	}
	echo "<script>location.href='layout.php';</script>";
	die();
?>