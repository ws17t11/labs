<?php

	//nusoap.php klasea gehitzen dugu
	require_once('lib/nusoap.php');
	require_once('lib/class.wsdlcache.php');

	//name of the service
	$ns = "http://localhost/lab07/getQuestionWZ.php?wsdl";
	$server = new soap_server;
	$server->configureWSDL('getQuestion',$ns);
	$server->wsdl->schemaTargetNamespace = $ns;

	$server->wsdl->addComplexType(
		'Question',
		'complexType',
		'struct',
		'all',
		'',
		array(
		    'gal' => array('name' => 'gal', 'type' => 'xsd:string'),
		    'ema' => array('name' => 'ema', 'type' => 'xsd:string'),
		    'zai' => array('name' => 'zai', 'type' => 'xsd:int'),
			'err' => array('name' => 'err', 'type' => 'xsd:int') // errore kodea
	));

	//inplementatu nahi dugun funtzioa erregistratzen dugu
	$server->register('getQuestion', array('id'=>'xsd:int'), array('result'=>'tns:Question'), $ns);

	//funtzioa inplementatzen dugu
	function getQuestion($id) {

		$result['gal'] = "";
		$result['ema'] = "";
		$result['zai'] = 0;
		$result['err'] = 1;

		include 'connect.php';

		$galdera = $link->query("SELECT * FROM questions WHERE id = $id LIMIT 1");

		if(mysqli_num_rows($galdera) > 0) {
			// berez ezinezkoa da bitan sartzea iterazio honetan...
			while ($row = mysqli_fetch_array($galdera)) {
				$result['gal'] = $row['galdera'];
				$result['ema'] = $row['zuzena'];
				$result['zai'] = $row['zailtasuna'];
				$result['err'] = 0;
			}
	    }

	    mysqli_free_result($galdera);
    	mysqli_close($link);

    	return $result;
	}

	//nusoap klaseko service metodoari dei egiten diogu
	if (!isset( $HTTP_RAW_POST_DATA)) $HTTP_RAW_POST_DATA = file_get_contents('php://input');
	$server->service($HTTP_RAW_POST_DATA);

?>
