
<?php

		//nusoap.php klasea gehitzen dugu
		require_once('lib/nusoap.php');
		require_once('lib/class.wsdlcache.php');

		$soapclient = new nusoap_client('http://ehusw.es/rosa/webZerbitzuak/egiaztatuMatrikula.php?wsdl', true);
		if (isset($_GET['eposta'])){
			$erantzuna = $soapclient->call('egiaztatuE', array('x'=>$_GET['eposta']));
			if($erantzuna=="BAI"){
				echo 'BAI';
			}
			else{
				echo 'EZ';
				//echo "<script language='javascript'>alert(document.getElementById('bidali').disabled=true);</script>";
			}
		}
?>
