<?php

	//nusoap.php klasea gehitzen dugu
	require_once('lib/nusoap.php');
	require_once('lib/class.wsdlcache.php');

	if (isset($_GET['id'])){

		$soapclient = new nusoap_client('http://localhost/lab7/getQuestionWZ.php?wsdl', true);
		$ema = $soapclient->call('getQuestion', array('id'=>$_GET['id']));
		echo "<br/>";
		if($ema['err'] == 1){
			echo '<em> Ez dago galderarik ID horrekin.</em> <br/>';
		} 
		echo('<table id="xmlQuestionById" class="mytable" style="display: block; height: 200px;" align="center">
		   <tr> <th>Galdera</th><th>Emaitza</th><th>Zailtasuna</th> </tr>');
		echo('<tr> <td>' . $ema['gal'] . '</td> <td>' . $ema['ema'] . '</td> <td>' . $ema['zai'] . '</td></tr> </table>');
	}
?>