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
			  		echo '<span class="right"> <a href="layout.html">LogOut</a> </span>';
			  	} else {
			  		echo '<span class="right"> <a href="login.php">LogIn</a> </span>';
			  	}
			?>
			  <span class="right" style="display:none;"><a href="/logout">LogOut</a> </span>
			<h2>Quiz: crazy questions</h2>
		</header>

		<nav class='main' id='n1' role='navigation'>
		<?php
			if (isset($_GET["eposta"])) {
				$email = trim($_GET["eposta"]);

				echo('<span><a href="layout.html?eposta=$email">Home</a></span>');
				echo('<span><a href="/quizzes">Quizzes</a></span>');
				echo('<span><a href="credits.html?eposta=$email">Credits</a></span>');
			
				echo('<span><a href="addQuestion.html?eposta=$email">Add question</a></span>');
				echo('<span><a href="addQuestionHTML5.html?eposta=$email">Add question (HTML 5)</a></span>');
				echo('<span><a href="showQuestions.php?eposta=$email">Galderak ikusi (irudirik gabe)</a></span>');
				echo('<span><a href="showQuestionsWithImages.php?eposta=$email">Galderak ikusi (irudiekin)</a></span>');
			} else {
				echo('<span><a href="layout.html">Home</a></span>');
				echo('<span><a href="/quizzes">Quizzes</a></span>');
				echo('<span><a href="credits.html">Credits</a></span>');
				echo('<span><a href="signUp.php">Erregistratu</a></span>');
			}
		?>
		</nav>

		<section class='main' id='s1' style="text-align: left;">
			
			<?php
			
				if (isset($_GET["eposta"])) {
					
					$email = trim($_GET["eposta"]);
					
					//Datu basearekin konexioa sortu
            		$local = 1;
		            if ($local==1) $link = mysqli_connect("localhost", "root", "", "quiz");
		            else $link = mysqli_connect("localhost", "id3302669_ws17t11", "", "id3302669_quiz"); //pasahitza ezkutu da
		            //erroreren bat egon bada, mezu bat igorri
		            if (mysqli_connect_errno()) { 
						echo("Errorea datu basearekin konexioa sortzean. Mesedez, saiatu berriz.");
						exit();
		            }

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
