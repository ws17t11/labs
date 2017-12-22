<?php

		//Datu basearekin konexioa sortu
		include 'connect.php';

		$mode = $_GET['mode'];

		if (!is_numeric($mode) || $mode <= 0 || $mode > 5) {
			echo 'Errorea eskaera egitean...';
			exit();
		}

		//lortu datu baseko galderak
		$sql = "SELECT * FROM nicks";
		$galderak_result = $link->query($sql);
		
		if (!$galderak_result) {
			 echo "Errorea datu basea atzitzean";
			 exit();
		}

		$nrows = mysqli_num_rows($galderak_result);

		if ($nrows == 0){
			echo "Ez dago jokalaririk datu basean";
			exit();
		} else {
			
			switch ($mode) {
				// Erantzun zuzen kopurua
			    case 1:
			    	$query = "SELECT * FROM nicks ORDER BY (zuzen_rand + zuzen_gaia) DESC, (oker_rand + oker_gaia) ASC LIMIT 10";
			    	$table = $link->query($query);
			        break;

				// Erantzun oker kopurua
			    case 2:
			    	$query = "SELECT * FROM nicks ORDER BY (oker_rand + oker_gaia) DESC, (zuzen_rand + zuzen_gaia) ASC LIMIT 10";
			    	$table = $link->query($query);
			        break;

				// One-Play moduan ratio hoberena
			    case 3:
			    	$query = "SELECT * FROM nicks ORDER BY (zuzen_rand/(zuzen_rand+oker_rand)) DESC, zuzen_rand DESC LIMIT 10";
			    	$table = $link->query($query);
			        break;

				// Play-by-Subject moduan ratio hoberena
			    case 4:
			    	$query = "SELECT * FROM nicks ORDER BY (zuzen_gaia/(zuzen_gaia+oker_gaia)) DESC, zuzen_gaia DESC LIMIT 10";
			    	$table = $link->query($query);
			        break;

			    // Guztira moduan ratio hoberena
			    case 5:
			    	$query = "SELECT * FROM nicks ORDER BY ((zuzen_rand+zuzen_gaia)/(zuzen_rand+zuzen_gaia+oker_rand+oker_gaia)) DESC, (zuzen_gaia+zuzen_rand) DESC LIMIT 10";
			    	$table = $link->query($query);
			        break;

			  	default:
					echo 'Errorea eskaera egitean...';	  		
			  		exit();
			  		break;
			}

			echo "<table id='top10tabla' class='mytable' style='table-layout: fixed; margin-top: -25px; overflow-y: scroll;'>";
			echo "<tr> 
					<th> Pos </th>
					<th> Nick </th>"; 
			if ($mode != 1) {
				echo "<th onclick='aldatuModua(1)' onmouseover='' style='cursor: pointer;'> Zuzenak </th>";  
			} else {
				echo "<th onclick='aldatuModua(1)' onmouseover='' style='cursor: pointer; color: blue;'> Zuzenak </th>";  
			}
			
			if ($mode != 2) {
				echo "<th onclick='aldatuModua(2)' onmouseover='' style='cursor: pointer;'> Okerrak </th>";
			} else {
				echo "<th onclick='aldatuModua(2)' onmouseover='' style='cursor: pointer; color: blue;'> Okerrak </th>";
			}
			
			if ($mode != 3) {
				echo "<th onclick='aldatuModua(3)' onmouseover='' style='cursor: pointer;'> One-play </th>";  
			} else {
				echo "<th onclick='aldatuModua(3)' onmouseover='' style='cursor: pointer; color: blue;'> One-play </th>";  
			}

			if ($mode != 4) {
				echo "<th onclick='aldatuModua(4)' onmouseover='' style='cursor: pointer;'> Play-by-subject </th>";  
			} else {
				echo "<th onclick='aldatuModua(4)' onmouseover='' style='cursor: pointer; color: blue;'> Play-by-subject </th>";  
			}
		
			if ($mode != 5) {
				echo "<th onclick='aldatuModua(5)' onmouseover='' style='cursor: pointer;'> Guztira </th>";
			} else {
				echo "<th onclick='aldatuModua(5)' onmouseover='' style='cursor: pointer; color: blue;'> Guztira </th>";
			}	

			echo "</tr>";

			$i = 1;

			while ($row = $table->fetch_assoc()) {
				$zuzen = $row['zuzen_rand'] + $row['zuzen_gaia'];
				$oker = $row['oker_rand'] + $row['oker_gaia'];
				
				if ($row['zuzen_rand'] + $row['oker_rand'] == 0) {
					$op_ratio = 0.0;
				} else {
					$op_ratio = 100 * $row['zuzen_rand'] / ($row['zuzen_rand'] + $row['oker_rand']);	
				}
				
				if ($row['zuzen_gaia'] + $row['oker_gaia'] == 0) {
					$pbs_ratio = 0.0;
				} else {
					$pbs_ratio = 100 * $row['zuzen_gaia'] / ($row['zuzen_gaia'] + $row['oker_gaia']);
				}

				if ($zuzen + $oker == 0) {
					$guztira = 0.0;
				} else {
					$guztira = 100 * $zuzen / ($zuzen+$oker);
				}

				$op_str = number_format($op_ratio, 2);
				$pbs_str = number_format($pbs_ratio, 2);
				$guztira_str = number_format($guztira, 2);

				$op_tot = $row['zuzen_rand'] + $row['oker_rand'];
				$pbs_tot = $row['zuzen_gaia'] + $row['oker_gaia']; 
				echo "<tr> 
					<td> $i </td>
					<td> <strong> $row[nick] </strong> </td> 
					<td> $zuzen </td>  
					<td> $oker </td> 
					<td> $op_str % &emsp; <font size='1'>$row[zuzen_rand]/$op_tot</font> </td>  
					<td> $pbs_str % &emsp; <font size='1'>$row[zuzen_gaia]/$pbs_tot</font></td>  
					<td> <strong> $guztira_str % </strong> </td> 
				</tr>";

				$i = $i + 1;
			}

			echo '</table>';
		}

		mysqli_close($link);
?>