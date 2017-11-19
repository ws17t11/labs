<?php 
	
	//nusoap.php klasea gehitzen dugu 
	require_once('lib/nusoap.php'); 
	require_once('lib/class.wsdlcache.php');

	//name of the service 
	$ns = "http://localhost/lab6/egiaztatuPasahitza.php?wsdl";   
	$server = new soap_server; 
	$server->configureWSDL('egiaztatuPass',$ns); 
	$server->wsdl->schemaTargetNamespace = $ns;
	
	//inplementatu nahi dugun funtzioa erregistratzen dugu 
	$server->register('egiaztatuPass', array('pass'=>'xsd:string'), array('ema'=>'xsd:string'), $ns);
	
	//funtzioa inplementatzen dugu 
	function egiaztatuPass($pass) { 
		$file = file_get_contents("./pass/toppasswords.txt");
		if(strpos($file, $pass) === false) {
			// balio du
    		return "BALIOZKOA";
    	} else {
    		// ez du balio
			return "BALIOGABEA";
    	}
	} 

	//nusoap klaseko service metodoari dei egiten diogu 
	if (!isset( $HTTP_RAW_POST_DATA)) $HTTP_RAW_POST_DATA = file_get_contents('php://input');
	$server->service($HTTP_RAW_POST_DATA); 

?> 