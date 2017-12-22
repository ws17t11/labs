<h1> Datu basean dauden galderak </h1> <br/>
<?php

		//Datu basearekin konexioa sortu
		include 'connect.php';

		//lortu datu baseko galderak
		$sql = "SELECT * FROM questions";
		$galderak_result = $link->query($sql);
		if(! $galderak_result){
			 echo "Errorea datu basea atzitzean";
			 exit();
		}

		$nrows = mysqli_num_rows($galderak_result);

		if ($nrows==0){
			echo "Errorea datu baseko galderak lortzean".
			exit();
		}
		else{
				echo('<table id="xmlQuestions" class="mytable" style="  display: block; height: 200px; overflow-y: scroll;">
					 <tr> <th>Enuntziatua</th> </tr>');

				while($row = $galderak_result->fetch_assoc()){
					echo("<tr><td> $row[galdera] </td></tr>");
				}
				echo "</table>";
		}

		mysqli_close($link);
?>