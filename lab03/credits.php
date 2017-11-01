<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
	<title>Credits</title>
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
				if (isset($_GET["eposta"])) {
			  		echo '<span class="right"> <a href="layout.php">LogOut</a> </span>';
			  	} else {
			  		echo '<span class="right"> <a href="login.php">LogIn</a> </span>';
			  	}
			?>
  	<h2>Quiz: crazy questions</h2>
      </header>
  	<nav class='main' id='n1' role='navigation'>
      <?php
        if (isset($_GET["eposta"])) {
          $email = trim($_GET["eposta"]);

          echo('<span><a href="layout.php?eposta=' . $email .'">Home</a></span>');
          echo('<span><a href="/quizzes">Quizzes</a></span>');
          echo('<span><a href="credits.php?eposta=' . $email . '">Credits</a></span>');

          echo('<span><a href="addQuestion.php?eposta=' . $email . '">Add question</a></span>');
          echo('<span><a href="addQuestionHTML5.php?eposta=' . $email . '">Add question (HTML 5)</a></span>');
          echo('<span><a href="showQuestions.php?eposta=' . $email . '">Galderak ikusi (irudirik gabe)</a></span>');
          echo('<span><a href="showQuestionsWithImages.php?eposta=' . $email . '">Galderak ikusi (irudiekin)</a></span>');
        } else {
          echo('<span><a href="layout.php">Home</a></span>');
          echo('<span><a href="/quizzes">Quizzes</a></span>');
          echo('<span><a href="credits.php">Credits</a></span>');
          echo('<span><a href="signUp.php">Erregistratu</a></span>');
        }
      ?>

      <!--<span><a href="layout.html">Log out</a></span> -->
  	</nav>
      <section class="main" id="s1">
  	<div>
  		<p> Informatika fakultateko ikasleak gara, Jon Vadillo eta Ander Salaberria . Laugarren kurtsoa hasi dugu jada konputazioko 	espezialitatean, eta Web Sistemako irakasgaian web orri bat sortu behar dugunez, hemen gabiltza quizak egiten.</p>
  		<br/> <br/>
  		<p>Galdera intelektual batzuekin eguneroko gai filosofikoei erantzuteko aukera ematen dizuegu. Goza itzazue gure quizak! </p> <br/>
  	<table style="margin-left:35%;">
	  <tr>
	    <td><img src="img/andersalaberria.png" alt="Ander Salaberria" class="credit_img"/></td>
	    <td><img src="img/jonvadillo.jpeg" alt="Jon Vadillo" class="credit_img"/></td>
    </tr>
	  <tr>
	    <td>Ander</td>
	    <td>Jon</td>
    </tr>
	</table>
  	</div>
      </section>
  	<footer class='main' id='f1'>
  		<p><a href="http://en.wikipedia.org/wiki/Quiz" target="_blank">What is a Quiz?</a></p>
  		<a href='https://github.com'>Link GITHUB</a>
  	</footer>
  </div>
</body>
</html>
