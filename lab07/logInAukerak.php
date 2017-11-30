<?php
  session_start();
  if (isset($_SESSION['eposta'])) { // sesioa hasita badu eta berriz logeatzen saiatzen bada, saioa ixten dugu (por list@)
    header("Location: logOut.php");
    exit();
  }
  if (isset($_GET['eposta'])) { // sesioa ez badu hasita eta URLa nahita aldatzen badu, URLa aldatzen dugu
    header("Location: logIn.php");
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
        echo('<span><a href="signUp.php">Erregistratu</a></span>');
    ?>
	</nav>
  <section class="main" id="s1">
    <div>

    <?php
		//Erabiltzailea logeatzen saiatu bada
		$logeatuta = FALSE;
		$postaFormatuEgokia = TRUE;
		$passFormatuEgokia = TRUE;

		if(isset($_POST["eposta"])){
      //Formularioko datuak eskuratu
      $eposta = trim($_POST["eposta"]);
      $pass = trim($_POST["pass"]);

      //Formularioaren datuak balidatu
      if(preg_match('/^[a-zA-Z]+[0-9]{3}@(ikasle\.)?ehu\.(es|eus)$/' , $eposta)!=1){
          $postaFormatuEgokia = FALSE;
      }
      if(strlen($pass)==0){
          $passFormatuEgokia = FALSE;
      }

      //Datu basearekin konexioa sortu
      include 'connect.php';

      //datuak zuzenak direla ikusi
      $login_query = "SELECT * FROM users WHERE eposta= '" . $_POST["eposta"] .  "'";
			$login_result = $link->query($login_query);
			$nrows = mysqli_num_rows($login_result);
			if($nrows==1){
				//echo 'Kaixo, '. $_POST["eposta"] . '!!!<br><br>';
				$new_user = $login_result->fetch_assoc();

        //pasahitza berifikatu
        if(!password_verify($_POST["pass"], $new_user['pasahitza'])){
          echo '<font color="red"> Eposta edo pasahitza okerrak </font><br><br>';
        }
        else{
          $logeatuta = TRUE;
          $email = $new_user[eposta];
          $image = $new_user[irudia];
          /*Counter kontagailua eguneratu*/
          $xml = simplexml_load_file('xml/counter.xml');
          if ($xml) {
            $xml->counter = $xml->counter + 1;
            $xml->asXML('xml/counter.xml');
          } else {
            echo "<p> Ezin izan da XML fitxategia ireki online erabiltzaile kopurua gehitzeko.</p>";
          }

          // SESIOEN TRATAMENDUA
          ini_set('session.cookie_lifetime',60);
          $_SESSION['mota'] = 1; // 1: ikaslea
          if(preg_match('/^web000@ehu\.es$/' , $eposta)==1) {
            $_SESSION['mota'] = 2; // 2: irakaslea
          }
          $_SESSION['SID'] = session_id();
          $_SESSION['eposta'] = $eposta;
          // SESIOEN TRATAMENDUA AMAITUA

          echo "<script>location.href='welcome.php?eposta=$eposta&image=$image';</script>";
          die();
        }
			}
      else {
          echo '<font color="red"> Eposta edo pasahitza okerrak </font><br><br>';
      }
      mysqli_close($link);

		}
		if(!isset($_POST["eposta"]) || $logeatuta===FALSE) {

            //dagoeneko logeatzen saiatu bada, ez aurkeztu hurrengo mezua, bestela bai
            if(!isset($_POST["eposta"])) echo "Mesedez, sar itzazu zure datuak saioa hasteko!<br><br>";
    ?>
            <form action="logIn.php" method="post" id="logInF" name="logInF" style="text-align:left;">
              <?php
                  if($postaFormatuEgokia==FALSE){
                    echo '<font color="red"> Epostaren formatua desegokia da </font> <br>';
                  }
              ?>
              Eposta: <input name="eposta" id="eposta" type="email" size="40" required
                              pattern="[a-zA-Z]+[0-9]{3}@(ikasle\.)?ehu\.(es|eus)"
                              title="placeholder="asalanueva123@ikasle.ehu.es"><br/><br/>

              <?php
                  if($passFormatuEgokia==FALSE){
                    echo '<font color="red"> Pasahitza hutsa sartu duzu! </font> <br>';
                  }
              ?>
              Pasahitza: <input name="pass" id="pass" type="password" pattern=".{1,}" required><br/>
              <input type="submit" value="Saioa hasi">
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



</body>
</html>
