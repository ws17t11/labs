<?php

	include 'connect.php';

	$taula = $link->query("SELECT * FROM questions");
	$n = mysqli_num_rows($taula);

	echo('<table class="mytable" style="  display: block; height: 200px; overflow-y: scroll;">
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
		echo("<tr>
			<td> <input type='button' id='gal$row[id]' value='$row[id]' onclick='aldatuGaldera($row[id])'/> </td>
			<td>$row[eposta]</td>
			<td>$row[galdera]</td>
			<td>$row[zuzena]</td>
			<td>$row[okerra1]<br/>$row[okerra2]<br/>$row[okerra3]</td>
			<td>$row[zailtasuna]</td>
			<td>$row[gaia]</td>
		</tr>");
	}
	echo '</table>';

	mysqli_close($link);
?>