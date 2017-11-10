
<html>
	<head>
		<title>Show XML Questions</title>
		<meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
		<link rel='stylesheet' type='text/css' href='stylesPWS/style.css' />
	</head>

	<body>
 		<h1> XML fitxategian dauden galderak </h1> <br/>
 		<?php
 			$xml = simplexml_load_file('xml/questions.xml');
 			if (!$xml) {
 				echo "<p> Ezin izan da XML fitxategia ireki. </p>";
 			} else {
 				echo('<table class="mytable">
		            <tr>
						<th>Galdera</th>
						<th>Zailtasuna</th>
						<th>Gaia</th>
		            </tr>');
	 			foreach ($xml->assessmentItem as $question){
	 				echo('<tr>
							<td>' . $question->itemBody->p . '</td>
							<td>' . $question['complexity'] . '</td>
							<td>' . $question['subject'] . '</td>
		                </tr>');
	 			}
 			}
 		?>
 	</body>
</html>
