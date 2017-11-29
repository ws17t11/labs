<?php

	if (isset($_GET['mota']) && isset($_GET['param'] )) {
		
		if ($_GET['mota'] != 0 && $_GET['mota'] != 1 && $_GET['mota'] != 2) {
			echo 'Mota gaizki ezarrita';
			exit();
		}

		if ($_GET['mota'] == 0) {
			if (!is_numeric($_GET['param']) || $_GET['param'] <= 0) {
				echo 'ID parametroak zenbaki arrunt positibo bat izan behar du';
				exit();
			}
		} else if ($_GET['mota'] == 1) {
			if (!is_numeric($_GET['param']) || $_GET['param'] <= 0 || $_GET['param'] > 5) {
				echo 'Zailtasunak zenbaki arrunt positibo bat izan behar du, 1 eta 5 artean';
				exit();
			}
		} else {
			if(strlen($_GET['param'])==0  || preg_match('/^[a-zA-Z0-9]+$/', $_GET['param']) != 1) {
				echo "Gaiak ezin du hutsik egon";
				exit();
			}
		}

		include 'connect.php';

		$param = trim($_GET['param']);

		if ($_GET['mota'] == 0) {
			$taula = $link->query("SELECT * FROM questions WHERE id=" . $param);
		} else if ($_GET['mota'] == 1) {
			$taula = $link->query("SELECT * FROM questions WHERE zailtasuna=" . $param);
		} else {
			$taula = $link->query("SELECT * FROM questions WHERE gaia='$param'");
		}

		$n = mysqli_num_rows($taula);

		if ($n == 0) {
			echo 'Ez dira galderarik aurkitu zure eskaerako parametroekin.';
		} else {
			echo('<table class="mytable" style="  display: block; max-height: 200px; overflow-y: scroll;" id="galTaula">
		        <tr>
					<th>Id</th>
					<th>Eposta</th>
					<th>Galdera</th>
					<th>Zuzena</th>
					<th>Okerrak</th>
					<th>Zailtasuna</th>
					<th>Gaia</th>
		        </tr>');
			while($row = $taula->fetch_assoc()){
				echo("<tr id='galdera$row[id]' onclick='aldatuGaldera($row[id])' onmouseover='' style='cursor: pointer;'>
					<td>$row[id]</td>
					<td>$row[eposta]</td>
					<td>$row[galdera]</td>
					<td>$row[zuzena]</td>
					<td>$row[okerra1]<br/>$row[okerra2]<br/>$row[okerra3]</td>
					<td>$row[zailtasuna]</td>
					<td>$row[gaia]</td>
				</tr>");
			}
			echo '</table>';
		}
		mysqli_close($link);
	} else {
		echo 'AJAX eskaera ezin izan da bete.';
	}
?>