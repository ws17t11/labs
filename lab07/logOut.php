<?php
	$xml = simplexml_load_file('xml/counter.xml');
	if ($xml && $xml->counter > 0) {
		$xml->counter = $xml->counter - 1;
		$xml->asXML('xml/counter.xml');
	} else if (!$xml) {
		echo "<p> Ezin izan da XML fitxategia ireki online erabiltzaile kopurua gehitzeko.</p>";
	}
	// Sesioa itxi
	session_start();
	unset($_SESSION["eposta"]); // badaezpada ere...
	unset($_SESSION["mota"]);
	unset($_SESSION["SID"]);
	session_destroy();
	// Main orrira joan
	echo "<script>location.href='layout.php';</script>";
	die();
?>