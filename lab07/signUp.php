<?php
	session_start();
	if (isset($_SESSION['eposta'])) { // sesioa hasita badu eta erregistratzen saiatzen bada, saioa ixten dugu (por list@)
		header("Location: logOut.php");
		exit();
	}
	if (isset($_GET['eposta'])) { // sesioa ez badu hasita eta URLa nahita aldatzen badu, URLa aldatzen dugu
		header("Location: signUp.php");
		exit();
}
?>

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
			  <span class="right"> <a href="logIn.php">LogIn</a> </span>
			  <span class="right" style="display:none;"><a href="/logout">LogOut</a> </span>
			<h2>Quiz: crazy questions</h2>
		</header>

		<nav class='main' id='n1' role='navigation'>
			<?php
				echo('<span><a href="layout.php">Home</a></span>');
				echo('<span><a href="/quizzes">Quizzes</a></span>');
				echo('<span><a href="credits.php">Credits</a></span>');
	    	?>
		</nav>

		<section class='main' id='s1' style="text-align: left;">

			<div>
				<h3> Signing Up - Erregistroa</h3> <br/>

				<?php
					$error = 0; //if 0 --> no error, else if 1 --> error
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
								//echo "Mesedez, saiatu berriz hurrengo esteka erabiliz: <a href=" . '"signUp.php"' . ">Erregistroa</a>";
								exit();
					    }
					    //if(preg_match('/^[A-Z][a-z]*( +[a-zA-Z]+){1,}$/', $izena)!=1){
							if(preg_match('/^[A-Z][a-z]+(\s[A-Z][a-z]+|\s[a-zA-Z]+|\s[A-Za-z]+([-\'][A-Za-z]+)*)+$/', $izena)!=1){
								echo "ERROREA! Izen-deituren formatu okerra<br>";
								//echo "Mesedez, saiatu berriz hurrengo esteka erabiliz: <a href=" . '"signUp.php"' . ">Erregistroa</a>";
								exit();
					    }
					    if(preg_match('/^[A-Za-z0-9]+$/', $nick)!=1){
								echo "ERROREA! Ezizenean ezin dira hutsunerik edota karaktere berezirik agertu<br>";
								//echo "Mesedez, saiatu berriz hurrengo esteka erabiliz: <a href=" . '"signUp.php"' . ">Erregistroa</a>";
								exit();
					    }
					    if(strlen($pass) < 6){
								echo "ERROREA! Idatzitako pasahitzak 6 karaktere edo  gehiago izan behar ditu<br>";
								//echo "Mesedez, saiatu berriz hurrengo esteka erabiliz: <a href=" . '"signUp.php"' . ">Erregistroa</a>";
								exit();
					    }
					    if(strcmp($pass,$pass2) != 0){
								echo "ERROREA! Idatzitako pasahitzak berdinak izan behar dira<br>";
								//echo "Mesedez, saiatu berriz hurrengo esteka erabiliz: <a href=" . '"signUp.php"' . ">Erregistroa</a>";
								exit();
					    }


					    //Datu basearekin konexioa sortu
						include 'connect.php';

						//Ziurtatu datu basean ez daudela datu errepikaturik
						$eposta_query = "SELECT * FROM users WHERE eposta= '" . $eposta . "'";
						$eposta_result = $link->query($eposta_query);
						$nrows = mysqli_num_rows($eposta_result);
						$posta_repe = 0;
						if($nrows!=0){
								//echo "Eposta helbidea hori jadanik erabiltzaile bati esleituta dago. Mesedez, saiatu beste batekin.";
								$error = 1;
								$posta_repe = 1;
								//exit();
						}

						$nick_query = "SELECT * FROM users WHERE nick= '" . $nick . "'";
						$nick_result = $link->query($nick_query);
						$nrows = mysqli_num_rows($nick_result);
						$nick_repe = 0;
						if($nrows!=0){
								//echo "Nick hori jadanik erabiltzaile bati esleituta dago. Mesedez, saiatu beste batekin.";
								$error = 1;
								$nick_repe = 1;
								//exit();
						}

						//Ziurtatu irudia kargatu dela
					    if(isset($_FILES['irudia']['tmp_name']) && $_FILES['irudia']['tmp_name']!=""){

					        $path = $_FILES['irudia']['tmp_name'];
					        $name = $_FILES['irudia']['name'];
					        $size = $_FILES['irudia']['size'];
					        $type = $_FILES['irudia']['type'];

					        //$content = addslashes(file_get_contents($_FILES['irudia']['tmp_name']));

									$directory = "img/users/";
									$targetPath = time().$name;
									$completePath = $directory.$targetPath;
									if(!move_uploaded_file($_FILES['irudia']['tmp_name'], $completePath)){
										 $error = 1;
										 echo '<font color="red">Errorea irudia kargatzean. Mesedez, saiatu berriz</font><br>';
									}

					    } else {
								  //default image
									$targetPath = "default.png";
					    }

						//sartu balioak users taulan, errorerik ez badaude
						if($error==0){
								$pasahitza_zifratuta = password_hash($pass, PASSWORD_DEFAULT);
						    $sql = "INSERT INTO users (eposta, izena, nick, pasahitza, irudia)
						    				VALUES ('$eposta', '$izena', '$nick', '$pasahitza_zifratuta', '$targetPath')";

								//saiakera kopurua adierazten duen taulan sartu ere
								$sql2 = "INSERT INTO saiakerak (eposta, aukerak) VALUES ('$eposta', 3)";

						    if ($link->query($sql) === TRUE && $link->query($sql2) === TRUE) {

										/*Counter kontagailua eguneratu*/
										$xml = simplexml_load_file('xml/counter.xml');
										if ($xml) {
											$xml->counter = $xml->counter + 1;
											$xml->asXML('xml/counter.xml');
										} else {
											echo "<p> Ezin izan da XML fitxategia ireki online erabiltzaile kopurua gehitzeko.</p>";
										}
										echo "<script>location.href='welcome.php?eposta=$eposta&image=$targetPath';</script>";
										die();

						    }
								else {
										$error = 1;
						        echo '<font color="red">Errorea datuak sartzean, mesedez, saiatu berriz</font><br/>';
						    }
						}

					    //itxi konexioa
					    mysqli_close($link);

					}
					if($error==1 || !isset($_POST["eposta"])) {
				?>

				<p> Jarri itzazu zure ondorengo datuak. Izartxoa (*) duten datuak bete egin behar dira. </p> <br/>

				<form id="erregistroa" action="signUp.php" method="post" style="text-align:left;" enctype="multipart/form-data">

					<?php
						 if(isset($posta_repe) && $posta_repe==1){
							 echo '<font color="red"> Eposta helbide hori hartuta dago </font> <br>';
						 }
					?>
					Eposta (*) : <input name="eposta" id="eposta" type="email" class="text" size="40" required
                    pattern="[a-zA-Z]+[0-9]{3}@ikasle\.ehu\.(es|eus)"
                    placeholder="jdoe123@ikasle.ehu.es" onChange="balidatuEposta();"> <br/><br/>
    				Izen-deiturak (*) : <input name="deitura" id="deitura" type="text" class="text" size="40" required
    				placeholder="John Doe"  pattern="/^[A-Z][a-z]+(\s[A-Z][a-z]+|\s[a-zA-Z]+|\s[A-Za-z]+([-\'][A-Za-z]+)*)+$/"> <br/><br/>


					<?php
						if(isset($nick_repe) && $nick_repe==1 ){
							echo '<font color="red"> Nick hori hartuta dago </font> <br>';
						}
					?>
	            	Nick (*) : <input name="nick" id="nick" type="text" class="text" size="20" placeholder="Johnny"
	            				required pattern="[A-Za-z0-9]+"> <br/> <br/>
	            	Pasahitza (6 karaktere gutzienez *) : <input name="pasahitza" id="pasahitza" type="password" class="text" pattern=".{6,}" onChange="balidatuPasahitza();"> <br/><br/>
	            	Pasahitza errepikatu (*) : <input name="pasahitza2" id="pasahitza2" type="password" class="text" pattern=".{6,}"> <br/> <br/>
	            	Zure argazkia : <input name="irudia" id="irudia" type="file" accept="image/*"> <br/> <br/>
	            	<input type="submit" id="bidaliBtn" value="Bidali" disabled> <input type="reset" id="garbituBtn" value="Garbitu">
				</form>

				<div id="eposta_AJAX_response">
				</div>

				<div id="password_AJAX_response">
				</div>

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

			/************************
			*** Lehenengo Ariketa ***
			*************************/
			xhro_email_valid = new XMLHttpRequest();

			//AJAX kontroladorea sortu galdera kopurua ikusteko
			function balidatuEposta() {
				xhro_email_valid.open("GET", "balidatuEpostaAJAX.php?eposta=" + $('#eposta').val(), true);
				xhro_email_valid.send("");
			}

			xhro_email_valid.onreadystatechange = function(){
				if(xhro_email_valid.readyState==4 && xhro_email_valid.status==200){
					//document.getElementById("eposta_AJAX_response").innerHTML = xhro_email_valid.responseText;
					//alert(xhro_email_valid.responseText);
					if(xhro_email_valid.responseText.trim()=="BAI"){
							document.getElementById("eposta_AJAX_response").innerHTML = '<font color="green">Ikaslea WS ikasgaian matrikulatuta dago</font>';
							document.getElementById("bidaliBtn").disabled=false;
					}
					else{
							document.getElementById("eposta_AJAX_response").innerHTML = '<font color="red">Ikaslea ez dago WS ikasgaian matrikulatuta</font>';
							document.getElementById("bidaliBtn").disabled=true;
					}
				}
			}

			/***********************
			*** Bigarren Ariketa ***
			************************/

			xhro_pass_valid = new XMLHttpRequest();

			function balidatuPasahitza() {
				if ($('#pasahitza').val().length != 0) {
			        xhro_pass_valid.open("GET", "balidatuPasahitzaAJAX.php?pass=" + $('#pasahitza').val(), true);
				    xhro_pass_valid.send("");
			    } else {
			        document.getElementById("password_AJAX_response").innerHTML = '';
					document.getElementById("bidaliBtn").disabled=true;
			    }
			}

			xhro_pass_valid.onreadystatechange = function(){
				if(xhro_pass_valid.readyState==4 && xhro_pass_valid.status==200){
					//alert(xhro_pass_valid.responseText.trim());
					if(xhro_pass_valid.responseText.trim()=="BALIOGABEA"){
						document.getElementById("password_AJAX_response").innerHTML = '<font color="red">Pasahitz hau ez dago onartua.</font>';
						document.getElementById("bidaliBtn").disabled=true;
					}
					else {
						document.getElementById("password_AJAX_response").innerHTML = '<font color="green">Pasahitz hau onartua dago.</font>';
						document.getElementById("bidaliBtn").disabled=false;
					}
				}
			}

		    $(document).ready(function(){

		        $("#erregistroa").submit(function(){
		            //balidatu eposta
					//return true;
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
				$("#garbituBtn").click(function(){
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
