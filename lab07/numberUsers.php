<?php
	$xml = simplexml_load_file('xml/counter.xml');
	if ($xml) {
		echo "<p> Online users: <strong> $xml->counter </strong> </p>";
	} else {
		echo "<p> Online users: <strong> UNKNOWN </strong> </p>";
	}
?>
