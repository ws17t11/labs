<?php

	//nusoap.php klasea gehitzen dugu
	require_once('lib/nusoap.php');
	require_once('lib/class.wsdlcache.php');

	if (isset($_GET['pass'])){

		$soapclient = new nusoap_client('http://localhost/lab07/egiaztatuPasahitza.php?wsdl', true);
		$erantzuna = $soapclient->call('egiaztatuPass', array('pass'=>$_GET['pass']));

		if($erantzuna == "BALIOZKOA"){
			echo 'BALIOZKOA';
		} elseif ($erantzuna == "BALIOGABEA"){
			echo 'BALIOGABEA';
		} else {
			echo 'UPSI';
		}
	}
?>
