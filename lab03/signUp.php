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
			  <span class="right"><a href="/login">LogIn</a> </span>
			  <span class="right" style="display:none;"><a href="/logout">LogOut</a> </span>
			<h2>Quiz: crazy questions</h2>
		</header>
		
		<nav class='main' id='n1' role='navigation'>
			<span><a href='layout.html'>Home</a></span>
			<span><a href='/quizzes'>Quizzes</a></span>
			<span><a href='credits.html'>Credits</a></span>
			<span><a href='addQuestion.html'>Add question</a></span>
			<span><a href='addQuestionHTML5.html'>Add question (HTML 5)</a></span>
			<span><a href='showQuestions.php'>Galderak ikusi (irudirik gabe)</a></span>
			<span><a href='showQuestionsWithImages.php'>Galderak ikusi (irudiekin)</a></span>
		</nav>
		
		<section class='main' id='s1' style="text-align: left;">

			<div>
				<h3> Signing Up - Erregistroa</h3> <br/>

				<?php
					if (isset($_POST["eposta"])) {
						//Formularioko datuak eskuratu
					    $eposta = trim($_POST["eposta"]); 
					    $izena = trim($_POST["deitura"]);
					    $nick = trim($_POST["nick"]);
					    $pass = trim($_POST["pasahitza"]);
					    $pass2 = trim($_POST["pasahitza2"]);
					   
					    //Formularioaren datuak balidatu
					    if(preg_match('/^[a-zA-Z]+[0-9]{3}@ikasle\.ehu\.(es|eus)$/' , $eposta)!=1){
							echo "ERROREA! Epostak ez du formatu egokia!<br>" ;
							echo "Mesedez, saiatu berriz hurrengo estela erabiliz: <a href=" . '"signUp.php"' . ">Erregistroa</a>";
							exit();
					    }
					    if(preg_match('/^[A-Z][a-z]*( +[A-Z][a-z]*){1,}$/', $izena)!=1){
							echo "ERROREA! Izen-deiturek gutxienez 2 hitz izan behar dituzte, lehenengo letra larria izanik eta ondorengoak xeheak<br>";
							echo "Mesedez, saiatu berriz hurrengo estela erabiliz: <a href=" . '"signUp.php"' . ">Erregistroa</a>";
							exit();
					    }
					    if(preg_match('/^[A-Za-z0-9]+$/', $nick)!=1){
							echo "ERROREA! Ezizenean ezin dira hutsunerik edota karaktere berezirik agertu<br>";
							echo "Mesedez, saiatu berriz hurrengo estela erabiliz: <a href=" . '"signUp.php"' . ">Erregistroa</a>";
							exit();
					    }
					    if(strlen($pass) < 6){
							echo "ERROREA! Idatzitako pasahitzak 6 karaktere edo  gehiago izan behar ditu<br>";
							echo "Mesedez, saiatu berriz hurrengo estela erabiliz: <a href=" . '"signUp.php"' . ">Erregistroa</a>";
							exit();
					    }
					    if(strcmp($pass,$pass2) != 0){
							echo "ERROREA! Idatzitako pasahitzak berdinak izan behar dira<br>";
							echo "Mesedez, saiatu berriz hurrengo estela erabiliz: <a href=" . '"signUp.php"' . ">Erregistroa</a>";
							exit();
					    }

					    //Datu basearekin konexioa sortu
						$local = 1;
						if($local==1) $link = mysqli_connect("localhost", "root", "", "quiz");
						else $link = mysqli_connect("localhost", "id3302669_ws17t11", "", "id3302669_quiz"); //pasahitza ezkutu da
						//erroreren bat egon bada, mezu bat igorri
						if(mysqli_connect_errno()){ //edo if(!link){
							echo ("Errorea datu basearekin konexioa sortzean: " . mysqli_connect_error());
							exit();
						}

						//Ziurtatu irudia kargatu dela
					    if(isset($_FILES['irudia']['tmp_name']) && $_FILES['irudia']['tmp_name']!=""){

					        $path = $_FILES['irudia']['tmp_name'];
					        $name = $_FILES['irudia']['name'];
					        $size = $_FILES['irudia']['size'];
					        $type = $_FILES['irudia']['type'];

					        $content = addslashes(file_get_contents($_FILES['irudia']['tmp_name']));

					    } else {
							echo "Ez da irudirik kargatu, baina ez da ezer gertatzen :) <br/>";
							$content = "";
					    }

						//sartu balioak users taulan
					    $sql = "INSERT INTO users (eposta, izena, nick, pasahitza, irudia)
					    VALUES ('$eposta', '$izena', '$nick', '$pass', '$content')";

					    if ($link->query($sql) === TRUE) {
					        echo "Datuak datu basean gorde egin dira! <br/> <br/>";
					        echo "Itzuli hasiera orrira <a href='layout.html'> hemen sakatuz! </a> <br/>";
					    } else {
					        echo 'Errorea datuak sartzean, mesedez, saiatu berriz <a href="signUp.php">esteka honen bidez</a> <br/>';
					    }

					    //itxi konexioa
					    mysqli_close($link);

					} else {
				?>

				<p> Jarri itzazu zure ondorengo datuak. Izartxoa (*) duten datuak bete egin behar dira. </p> <br/>

				<form id="erregistroa" action="signUp.php" method="post">
					Eposta (*) : <input name="eposta" id="eposta" type="email" class="text" size="40" required
	                            pattern="[a-zA-Z]+[0-9]{3}@ikasle\.ehu\.(es|eus)"
	                            placeholder="jdoe123@ikasle.ehu.es"> <br/>
	            	Izen-deiturak (*) : <input name="deitura" id="deitura" type="text" class="text" size="40" required
	            				placeholder="John Doe"  pattern="[A-Z][a-z]*( +[A-Z][a-z]*){1,}"> <br/>
	            	Nick (*) : <input name="nick" id="nick" type="text" class="text" size="20" placeholder="Johnny" 
	            				required pattern="[A-Za-z0-9]+"> <br/> <br/>
	            	Pasahitza (*) : <input name="pasahitza" id="pasahitza" type="password" class="text" pattern=".{6,}"> <br/> 
	            	Pasahitza errepikatu (*) : <input name="pasahitza2" id="pasahitza2" type="password" class="text" pattern=".{6,}"> <br/> <br/> 
	            	Zure argazkia : <input name="irudia" id="irudia" type="file" accept="image/*"> <br/> <br/>
	            	<div id="ezaugarriak">
	            		Adibideko formatua izan behar du.<br/>
	            		Gutxienez 2 hitz (izena gehi lehenengo abizena) letra larriz hasita. <br/>
	            		Hitz bakarra. <br/>
	            		<br/>
	            		Gutxienez 6 karaktere. <br/>
	            	</div>
	            	<input type="submit" id="bidali" value="Bidali"> <input type="reset" id="garbitu" value="Garbitu">
				</form>

				<?php
					}
				?>

			</div>
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