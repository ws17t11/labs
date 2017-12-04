<?php
  require("segurtasun_askea.php");
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
  </head>
  <body>
  <div id='page-wrap'>
	<header class='main' id='h1'>
    <?php
      if (isset($_SESSION["eposta"])) {
        echo '<h2>Quiz: crazy questions</h2><br/>';
        echo 'Kaixo, ' . $_SESSION["eposta"] . '<br/>';
        //kargatu irudia
        echo '<div id="logo">';
        if (isset($_SESSION["image"])) {
          echo '<img height="50" width="50" src="img/users/' . $_SESSION["image"] . '"><br>';
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
      if (isset($_SESSION["eposta"])) {
        echo('<span><a href="layout.php">Home</a></span>');
        echo('<span><a href="quizzes.php">Quizzes</a></span>');
				echo('<span><a href="credits.php">Credits</a></span>');
        if ($_SESSION["mota"] == 2) {
          echo('<span><a href="reviewingQuizes.php">Galderak errebisatu</a></span>');
        } else {
          echo('<span><a href="handlingQuizes.php">Galderak kudeatu</a></span>');
        }
      } else {
        echo('<span><a href="layout.php">Home</a></span>');
        echo('<span><a href="quizzes.php">Quizzes</a></span>');
        echo('<span><a href="credits.php">Credits</a></span>');
        echo('<span><a href="signUp.php">Erregistratu</a></span>');
      }
    ?>
		<!--<span><a href="layout.html">Log out</a></span> -->
	</nav>
    <section class="main" id="s1">
    	<div>
    	Galderak erantzutea gustuko duzu? Hala bada, orrialde hau zuretzat pentsatuta dago!<br>
      Bazenekien erabiltzaile erregistratuak galderak sortzeko aukera dutela?<br>
      Ikaslea baldin bazara, ez itxaron gehiago eta <a href="signUp.php">erregistratu</a>!
    	</div>
    </section>
	<footer class='main' id='f1'>
		<p><a href="http://en.wikipedia.org/wiki/Quiz" target="_blank">What is a Quiz?</a></p>
		<a href='https://github.com'>Link GITHUB</a>
	</footer>
</div>
</body>
</html>
