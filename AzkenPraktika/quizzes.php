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
	<nav class='main' id='n1' role='navigation' style="height:600px">
    <?php
      if (isset($_SESSION["eposta"])) {
        echo('<span><a href="layout.php">Home</a></span>');
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
    <section class="main" id="s1" style="text-align: left; height:600px">
    	<div>
    	Atal honetan jolastu ahal izango duzu, bi modu desberdinetan!<br><br>
      One Play: ausazko galdera bat aurkeztuko zaizu. Asmatuko al duzu? Sakatu botoia nahi duzun alditan, eta unero
                galdera desberdin bat aurkeztuko zaizu! <br><br>

      Play by subject: hautagai dagoen gai bat aukeratu, eta gai horri buruzko 3 galdera (gehienez) azalduko zaizkizu!

      <br><br>

      <input type="button" id="onePlayBtn" value="One play" style="text-align:left;">
      <input type="button" id="subjectBtn" value="Play by subject" style="text-align:left;"><br><br>


      <div id="questionsDiv">
        <!-- Hemen agertuko da galdera sartu ondorengo erantzuna -->
      </div>

      <input type="button" id="checkOnePlayBtn" name="checkOnePlayBtn" value="Bidali" style="display: none;">
      <input type="button" id="checkSubjectsBtn" name="checkSubjectsBtn" value="Bidali" style="display: none;">

      <div id="resultsDiv">
        <!-- Hemen agertuko da galdera sartu ondorengo erantzuna -->
      </div>



    	</div>
    </section>
	<footer class='main' id='f1'>
		<p><a href="http://en.wikipedia.org/wiki/Quiz" target="_blank">What is a Quiz?</a></p>
		<a href='https://github.com'>Link GITHUB</a>
	</footer>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

       /*********************
       *** One Play modua ***
       **********************/

       //AJAX kontroladorea sortu galderak eskatzeko
       xhro_oneplay = new XMLHttpRequest();
       xhro_oneplay.onreadystatechange = function(){
          if(xhro_oneplay.readyState==4 && xhro_oneplay.status==200){
            document.getElementById("questionsDiv").innerHTML=xhro_oneplay.responseText.trim();
          }
       }

       //Galdera ikusteko ID bidez botoia sakatzean, AJAX eskaera egin
       $("#onePlayBtn").click(function(){
          xhro_oneplay.open("GET", "onePlayAJAX.php", true);
          xhro_oneplay.send("");

          $("#checkSubjectsBtn").hide();
          $("#checkOnePlayBtn").show();
       });


       //AJAX kontroladorea sortu galderak eskatzeko
       xhro_check_oneplay = new XMLHttpRequest();
       xhro_check_oneplay.onreadystatechange = function(){
          if(xhro_check_oneplay.readyState==4 && xhro_check_oneplay.status==200){
            document.getElementById("resultsDiv").innerHTML=xhro_check_oneplay.responseText.trim();
          }
       }

       //Galdera ikusteko ID bidez botoia sakatzean, AJAX eskaera egin
       $("#checkOnePlayBtn").click(function(){
          if (!$("input[name='erantzuna']:checked").val()) {
             alert('Ez dago erantzunik aukeratuta');
          }
          else {
            var chosen = $("input[name='erantzuna']:checked").val();
            xhro_check_oneplay.open("GET", "checkOnePlayAJAX.php?erantzuna=" + chosen, true);
            xhro_check_oneplay.send("");
          }
       });

     });
</script>

</body>
</html>
