<!DOCTYPE html>
<html>
	<head>
		<meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
		<title>Quizzes</title>
		<link rel='stylesheet' type='text/css' href='stylesPWS/style.css' />
		<link rel='stylesheet'
			  type='text/css'
			  media='only screen and (min-width: 530px) and (min-device-width: 481px)'
			  href='stylesPWS/wide.css' />
		<link rel='stylesheet'
			  type='text/css'
			  media='only screen and (max-width: 480px)'
			  href='stylesPWS/smartphone.css' />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	</head>
	<body>
		<div id='page-wrap'>

		<header class='main' id='h1'>
			<?php
		      if (isset($_GET["eposta"])) {
		          echo '<h2>Quiz: crazy questions</h2><br/>';
		          echo 'Kaixo, ' . $_GET["eposta"] . '<br/>';
		          //kargatu irudia
		          echo '<div id="logo">';
		          if (isset($_GET["image"])) {
		            echo '<img height="50" width="50" src="img/users/' . $_GET["image"] . '"><br>';
		          }else{
		            echo '<img height="50" width="50" src="img/users/default.png"><br>';
		          }
		          echo '<a href="logOut.php">LogOut</a>';
		          echo '</div>';
		        } else {
		          echo '<span class="right"> <a href="logIn.php">LogIn</a> </span>';
		          echo '<h2>Quiz: crazy questions</h2>';
		        }
		    ?>
		</header>

		<nav class='main' id='n1' role='navigation'>
			<?php
        $email = trim($_GET["eposta"]);
			  $image = trim($_GET["image"]);
				$urlparams = 'eposta=' . $email .'&image=' . $image;
				echo('<span><a href="layout.php?' . $urlparams . '">Home</a></span>');
				echo('<span><a href="/quizzes">Quizzes</a></span>');
				echo('<span><a href="credits.php?' . $urlparams . '">Credits</a></span>');
				echo('<span><a href="handlingQuizes.php?' . $urlparams . '">Galderak kudeatu</a></span>');
				echo('<span><a href="showQuestionsWithImages.php?' . $urlparams . '">DB galderak ikusi</a></span>');
	    ?>
		</nav>

		<section class='main' id='s1' style="text-align: left;">

			<?php

				if (isset($_GET["eposta"])) {

					$email = trim($_GET["eposta"]);

					//Datu basearekin konexioa sortu
                  	include 'connect.php';

                  //datuak zuzenak direla ikusi
              		$welcome_query = "SELECT * FROM users WHERE eposta= '" . $email . "'";
					$welcome_result = $link->query($welcome_query);
					$nrows = mysqli_num_rows($welcome_result);

					if ($nrows == 1) {
						$user = $welcome_result->fetch_assoc();
                        $nick = $user['nick'];
            
                        echo "<h3> Ongi Etorri! </h3> <br/>";
						echo "Kaixo $nick! Ongi etorri gure Quiz: crazy questions orrira! <br/> <br/>";
						echo "<p> Orain aukera duzu gure datubasera galderak igotzeko eta hauek ikusteko. </p>";
					} else {
						echo "<h3> Erabiltzailea ez da existitzen </h3>";
						echo "<p> Ez dugu zure erabiltzailea aurkitu. Saioa berriz hasteko sakatu <a href='logIn.php'>hemen</a>. Ez baduzu erabiltzailerik, sortu ezazu bat <a href='signUp.php'>hemen</a>.";
					}
					mysqli_close($link);
				} else {
					echo "<h3> Saiorik hasi gabe </h3>";
					echo "<p> Ez zaude logeatuta. Saioa hasteko sakatu <a href='logIn.php'>hemen</a>. Ez baduzu erabiltzailerik, sortu ezazu bat <a href='signUp.php'>hemen</a>.";
				}
			?>
		</section>

		<footer class='main' id='f1'>
			<p><a href="http://en.wikipedia.org/wiki/Quiz" target="_blank">What is a Quiz?</a></p>
			<a href='https://github.com'>Link GITHUB</a>
		</footer>

		</div>


		<script type="text/javascript">

		    $(document).ready(function(){
		        $("#erregistroa").submit(function(){
		            //balidatu eposta
								if($('#pasahitza').val() !== $('#pasahitza2').val()){
									alert("Pasahitzak ez dira berdinak!");
									return false;
								}
		            return true;
		        });

		        //erabiltzailea irudi bat aukeratzen duenean
		        $("#irudia").change(function(e){
		          	//irudia jadanik existitzen bada (aurretik bat aukeratu badu)
		          	if($("#reg_irudi").length){
		            	$("#reg_irudi").remove(); //ezabatu irudia
		             	$("#irudia_kendu_btn").remove(); //ezabatu irudia kentzeko botoia
		          	}

		            // irudiaren etiketa eta atributuak definitzen dira
		            var img = $('<img></img>', {
		                            id: 'reg_irudi',
		                            name: 'reg_irudi',
		                            height: '150px',
		                            maxwidth: '200px'
		                        });
		      		$("#erregistroa").append(img);

		            // Igo diren fitxategien lista files aldagaian
		            var files = e.target.files;
		   			    // fitxategiak irakurtzea ahalbidetzen du
		   			    var fr = new FileReader();
		    		    fr.onload = function () {
		    			     // fr.result-ek igo den fitxaegiaren edukia itzultzen du
		     		       $("#reg_irudi").attr("src", fr.result);
		    		    }
		    		fr.readAsDataURL(files[0]);

    				//sortu botoi bat irudia kentzeko aukera edukitzeko
			        var nwbtn = $('<input/>', {
			                        type: 'button',
			                        value: 'Kendu irudia',
			                        id: 'irudia_kendu_btn',
			                        click: kenduIrudia
			                      });
			        $('#reg_irudi').after(nwbtn); //sartu botoia formularioan

			      	function kenduIrudia() {
			        	$("#reg_irudi").remove(); //kendu irudia
			          	$("#irudia").val(""); //garbitu fitxategi hautatzailearen balioa
			          	$("#irudia_kendu_btn").remove(); //kendu sakatu berri den botoia :)
			        }

		      });

		    //reset botoiari click egitean, irudi bat hautatu egin bada, ezabatu
				$("#garbitu").click(function(){
					//irudiren bat aukeraratu bada, ezabatu
					if($("#reg_irudi").length){
						$("#reg_irudi").remove(); //kendu irudia
						$("#irudia").val(""); //garbitu fitxategi hautatzailearen balioa
						$("#irudia_kendu_btn").remove(); //kendu botoia :)
					}
				});

			});

		</script>

	</body>

</html>
