<html>

	<head>
		<title>Show Questions</title>
		<meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
		<link rel='stylesheet' type='text/css' href='stylesPWS/style.css' />
	</head>

	<body>
 		<h1> Datu basean dauden galderak </h1> <br/>
 		<?php

 			include 'connect.php';

			$taula = $link->query("SELECT * FROM questions");
			$n = mysqli_num_rows($taula);

			echo('<table class="mytable">
                <tr>
					<th>Id</th>
					<th>Eposta</th>
					<th>Galdera</th>
					<th>Zuzena</th>
					<th>Okerra1</th>
					<th>Okerra2</th>
					<th>Okerra3</th>
					<th>Zailtasuna</th>
					<th>Gaia</th>
                </tr>');
			while($row = $taula->fetch_assoc()){
				echo("<tr>
				    <td>$row[id]</td>
					<td>$row[eposta]</td>
					<td>$row[galdera]</td>
					<td>$row[zuzena]</td>
					<td>$row[okerra1]</td>
					<td>$row[okerra2]</td>
					<td>$row[okerra3]</td>
					<td>$row[zailtasuna]</td>
					<td>$row[gaia]</td>
				</tr>");
			}
			echo '</table>';

			mysqli_close($link);
		?>
 	</body>
</html>
