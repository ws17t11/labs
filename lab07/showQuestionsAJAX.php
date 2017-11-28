<h1> XML fitxategian dauden galderak </h1> <br/>
<?php
	$xml = simplexml_load_file('xml/questions.xml');
	if (!$xml) {
		echo "<p> Ezin izan da XML fitxategia ireki. </p>";
	}
  	else {
   	 	echo('<table id="xmlQuestions" class="mytable" style="  display: block; height: 200px; overflow-y: scroll;">
    		   <tr> <th>Enuntziatua</th> </tr>');
		foreach ($xml->assessmentItem as $question){
			echo('<tr> <td>' . $question->itemBody->p . '</td> </tr>');
		}
	}
?>
