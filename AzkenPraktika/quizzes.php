<?php
  require("segurtasun_askea.php");
  if (isset($_SESSION["mota"]) && ($_SESSION["mota"] == 2 || $_SESSION["mota"] == 1)) {
     echo "<script>location.href='layout.php';</script>";
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
	<nav class='main' id='n1' role='navigation' style="height:660px">
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
    <section class="main" id="s1" style="text-align: left; height:660px">
      <div id="jolastuBainoLehen">
        Nire emaitzak gordetzea nahi dut, TOP 10 jokalarien artean ager naitekelarik. <br/>
        Anonimo bezala jolas nahi badut, <input type="button" value="hemen" id="anonBtn" /> klikatu behar dut. <br/>
        <div id="izengoitiaJartzen">
          <input type="text" id="izengoitia" />
          <input type="button" value="Onartu" id="saveNickBtn" />
        </div>
        <div id="izengoitiaErrore">
        </div>
      </div>

    	<div id="jolasten" hidden>
      	Atal honetan, bi modu desberdinetan jolastu ahal izango duzu!
        <br><br>
        <strong> One Play </strong>: ausazko galdera bat aurkeztuko zaizu. Asmatuko al duzu? Sakatu botoia nahi duzun alditan, eta unero
                  galdera desberdin bat aurkeztuko zaizu! 
        <br><br>
        <strong> Play by subject </strong>: hautagai dagoen gai bat aukeratu, eta gai horri buruzko 3 galdera (gehienez) azalduko zaizkizu!
        <br><br>

        <?php
              /***************************
               * Lortu datu baseko gaiak *
               ***************************/

              //Datu basearekin konexioa sortu
              include 'connect.php';

              //lortu ausazko galdera bat
              $sql = "SELECT DISTINCT gaia FROM questions";

              $gaiak_result = $link->query($sql);
              if(! $gaiak_result){
                  echo "Errorea datu basea atzitzean gaiak lortzeko";
              }
              else{
                  if (mysqli_num_rows($gaiak_result) != 0) {
                      echo '<input type="button" id="onePlayBtn" value="One play" style="text-align:left;">';
                      echo '&emsp;&emsp;';
                      echo 'Gaiak: <select id="gaiak">';
                      while($row = $gaiak_result->fetch_assoc()){
                          echo '<option value="'. $row['gaia'] .'">' . $row['gaia'] . '</option>';
                      }
                      echo '</select>';
                      echo '<input type="button" id="subjectBtn" value="Play by subject" style="text-align:left;">';
                  } else {
                      echo '<strong> Ez dago galderarik datubasean. </strong>';  
                  }
              }
        ?>

        <br><br>

        <div id="questionsDiv">
          <!-- Hemen agertuko d(ir)a galdera(k), AJAX bidez jarriko direnak-->
        </div>

        <input type="button" id="checkOnePlayBtn" name="checkOnePlayBtn" value="Zuzendu" style="display: none;">
        <input type="button" id="checkSubjectBtn" name="checkSubjectBtn" value="Zuzendu" style="display: none;">

        <div id="resultsDiv" hidden>
          <!-- Hemen agertuko dira emaitzak, AJAX bidez jarriko direnak-->
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

            //dagoeneko erabiltzailea galdera guztiak erantzun baditu, edo galdera sortzean
            //errorerik egonez gero, <input name="erantzuna"...> ez da agertuko, eta beraz,
            //erantzunak bidaltzeko botoia ezkutuko dugu.
            if(! $("input[name='erantzuna']").length){
                $("#checkOnePlayBtn").hide();
            }
          }
       }


       $("#onePlayBtn").click(function(){
          xhro_oneplay.open("GET", "onePlayAJAX.php", true);
          xhro_oneplay.send("");
          $("#resultsDiv").hide();

          $("#checkSubjectBtn").hide();
          $("#checkOnePlayBtn").show();
          document.getElementById("questionsDiv").innerHTML = "Kargatzen...";
          document.getElementById("resultsDiv").innerHTML = "";
       });


       //AJAX kontroladorea sortu galderak zuzentzeko
       xhro_check_oneplay = new XMLHttpRequest();
       xhro_check_oneplay.onreadystatechange = function(){
          if(xhro_check_oneplay.readyState==4 && xhro_check_oneplay.status==200){
              document.getElementById("resultsDiv").innerHTML=xhro_check_oneplay.responseText.trim();
              $("#checkOnePlayBtn").hide();
              $("#resultsDiv").show();
          }
       }

       $("#checkOnePlayBtn").click(function(){
          if (!$("input[name='erantzuna']:checked").val()) {
             alert('Ez dago erantzunik aukeratuta');
          }
          else {
            var chosen = $("input[name='erantzuna']:checked").val();
            xhro_check_oneplay.open("GET", "checkOnePlayAJAX.php?erantzuna=" + chosen + "&nick=" + supernick, true);
            xhro_check_oneplay.send("");
          }
       });


       /****************************
       *** Play by Subject modua ***
       *****************************/

       //AJAX kontroladorea sortu galderak eskatzeko
       xhro_subject = new XMLHttpRequest();
       xhro_subject.onreadystatechange = function(){
          if(xhro_subject.readyState==4 && xhro_subject.status==200){
            document.getElementById("questionsDiv").innerHTML=xhro_subject.responseText.trim();
          }
       }

       $("#subjectBtn").click(function(){
          //lortu erabiltzaile hautatutako gaia
          var gaia = $("#gaiak").val();
          var nick = supernick;

          xhro_subject.open("GET", "playBySubjectAJAX.php?gaia=" + gaia + "&nick=" + nick, true);
          xhro_subject.send("");
          $("#resultsDiv").hide();

          $("#checkSubjectBtn").show();
          $("#checkOnePlayBtn").hide();
          document.getElementById("questionsDiv").innerHTML = "Kargatzen...";
          document.getElementById("resultsDiv").innerHTML = "";
       });


       //AJAX kontroladorea sortu galderak zuzentzeko
       xhro_check_subject = new XMLHttpRequest();
       xhro_check_subject.onreadystatechange = function(){
          if(xhro_check_subject.readyState==4 && xhro_check_subject.status==200){
            document.getElementById("resultsDiv").innerHTML=xhro_check_subject.responseText.trim();
            $("#checkSubjectBtn").hide();
            $("#resultsDiv").show();
          }
       }

       //Galdera ikusteko ID bidez botoia sakatzean, AJAX eskaera egin
       $("#checkSubjectBtn").click(function(){
              //lehendabiziko galderaren erantzuna lortu
             if($("input[name='erantzuna1']").length){
               if (!$("input[name='erantzuna1']:checked").val()) {
                  alert('Aukeratu erantzun bat 1 galderarako');
                  return false;
               }
               else{
                   var chosen1 = $("input[name='erantzuna1']:checked").val();
                   var parametroak = "erantzuna1=" + chosen1;
               }
             }
            //bigarren galdera baldin badago, erantzuna lortu
            if($("input[name='erantzuna2']").length){
              if (!$("input[name='erantzuna2']:checked").val()) {
                   alert('Aukeratu erantzun bat 2. galderarako');
                   return false;
              }
              else{
                  var chosen2 = $("input[name='erantzuna2']:checked").val();
                  var parametroak = parametroak +  "&erantzuna2=" + chosen2;
              }
            }
            //hirugarren galdera baldin badago, erantzuna lortu
            if($("input[name='erantzuna3']").length){
              if (!$("input[name='erantzuna3']:checked").val()) {
                  alert('Aukeratu erantzun bat 3. galderarako');
                  return false;
              }
              else{
                  var chosen3 = $("input[name='erantzuna3']:checked").val();
                  var parametroak = parametroak +  "&erantzuna3=" + chosen3;
              }
            }

            var parametroak = parametroak + "&nick=" + supernick;

            xhro_check_subject.open("GET", "checkPlayBySubjectAJAX.php?" + parametroak, true);
            xhro_check_subject.send("");
       });


      /******************************
       *** Nick/Anonimoa ezartzen ***
       ******************************/

      var supernick = "anonimoa";

      //AJAX kontroladorea sortu nick-a gordetzeko/erabiltzeko
      xhro_nick = new XMLHttpRequest();
      xhro_nick.onreadystatechange = function(){
        if(xhro_nick.readyState==4 && xhro_nick.status==200){
          var responseAJAX = xhro_nick.responseText.trim(); 
          var nickArray = responseAJAX.split(",");
          if (responseAJAX.match("^0")) {
            document.getElementById("jolastuBainoLehen").innerHTML = "Ongi etorri, <strong>" + nickArray[1] + "</strong>!";
            supernick = nickArray[1];
            $("#jolasten").show();
          } else if (responseAJAX.match("^1")) {
            document.getElementById("jolastuBainoLehen").innerHTML = "Ongi etorri berriro, <strong>" + nickArray[1] + "</strong>!";
            supernick = nickArray[1];
            $("#jolasten").show();
          } else if (responseAJAX.match("^2")) {
            document.getElementById("jolastuBainoLehen").innerHTML = "Kaixo <strong>anonimo</strong>!";
            $("#jolasten").show();
          } else {
            document.getElementById("izengoitiaErrore").innerHTML = xhro_nick.responseText.trim();
          }
        }
      }
      
      $("#anonBtn").click(function(){ 
        xhro_nick.open("GET", "nickAJAX.php?nick=anonimoa" , true);
        xhro_nick.send("");         
      });


      $('#saveNickBtn').click(function(){
        
        var nick = $("#izengoitia").val().trim();

        if (nick == "anonimoa") {
          document.getElementById("izengoitiaErrore").innerHTML = "<font color='red'> Ezin duzu 'anonimoa' goitizena erabili zure nick bezala. </font>";
          exit();
        }

        if (nick.length <= 5) {
          document.getElementById("izengoitiaErrore").innerHTML = "<font color='red'> Zure izengoitiak ezin ditu 6 baino karaktere gutxiago izan. </font>";
          exit();
        }

        xhro_nick.open("GET", "nickAJAX.php?nick=" + $("#izengoitia").val().trim(), true);
        xhro_nick.send("");         
      });

    });

</script>

</body>
</html>
