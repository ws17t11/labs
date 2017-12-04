<?php
  session_start();

  if(isset($_POST['erantzuna'])){


    $eposta = $_SESSION['epostachangepass'];
    $erantzuna = $_POST['erantzuna'];
    $newpass1 = $_POST['newpass1'];
    $newpass2 = $_POST['newpass2'];

    //Formularioaren datuak balidatu
    if(preg_match('/^[a-zA-Z]+[0-9]{3}@(ikasle\.)?ehu\.(es|eus)$/' , $eposta)!=1){
        echo 'ERROREA: Eposta desegokia';
        exit();
    }

    if(strlen($newpass1) < 6){
      echo "ERROREA! Idatzitako pasahitzak 6 karaktere edo  gehiago izan behar ditu<br>";
      //echo "Mesedez, saiatu berriz hurrengo esteka erabiliz: <a href=" . '"signUp.php"' . ">Erregistroa</a>";
      exit();
    }

    if(strcmp($newpass1,$newpass2) != 0){
      echo "ERROREA! Idatzitako pasahitzak berdinak izan behar dira<br>";
      //echo "Mesedez, saiatu berriz hurrengo esteka erabiliz: <a href=" . '"signUp.php"' . ">Erregistroa</a>";
      exit();
    }



    //Datu basearekin konexioa sortu
    include 'connect.php';

    //erantzuna zuzena ez bada
    if(!password_verify($erantzuna, $_SESSION['segurtasunErantzuna'])){
        echo '<font color="red"> Segurtasun galderari gaizki erantzun diozu </font><br><br>';
        exit();
    }

    //ALDATU PASAHITZA!!!!
    $pasahitza_zifratuta = password_hash($newpass1, PASSWORD_DEFAULT);
    $login_query = "UPDATE users SET pasahitza='$pasahitza_zifratuta' WHERE eposta='$eposta'";
    if($link->query($login_query)){
        unset($_SESSION['epostachangepass']);
        unset($_SESSION['segurtasunErantzuna']);
        echo "<script>location.href='logIn.php';</script>";
    }
    else{
      echo "Errorea datu basea atzitzean. Mesedez, saiatu berriz";
    }

  }
  else{
      if (isset($_SESSION['eposta'])) { // sesioa hasita badu eta pasahitzaz ez bada go, saioa ixten dugu (por list@)
        echo "<script>location.href='logOut.php';</script>";
        exit();
      }
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
        echo('<span><a href="quizzes.php">Quizzes</a></span>');
        echo('<span><a href="credits.php">Credits</a></span>');
        echo('<span><a href="signUp.php">Erregistratu</a></span>');
    ?>
	</nav>
  <section class="main" id="s1">
    <div style="text-align:left;">
            <h2 style="text-align:left">Pasahitza aldatu</h2><br/>


            <form action="pasahitzaAldatu.php" method="post" id="passchangeform" name="passchangeform" style="text-align:left;">
              <h3>Mesedez, sartu lehendabizi zure eposta, galderaren enuntziatua ikusteko</h3><br>
              Eposta: <input name="eposta" id="eposta" type="email" size="40" required
                              pattern="[a-zA-Z]+[0-9]{3}@(ikasle\.)?ehu\.(es|eus)"
                              title="Eposta" placeholder="asalanueva123@ikasle.ehu.es"><br/>

              <input type="button" value="Bidali" onclick="getSecurityQuestion();"><br><br>

              <hr><br>
              Segurtasun galdera:
              <div id="enundiv" style="text-align:left; display:inline;">
                <!-- Hemen galderaren enuntziatua jarriko da-->
              </div><br><br>
              <hr><br>

              Galderaren erantzuna:  <input name="erantzuna" id="erantzuna" type="text" pattern=".{1,}" required><br/><br/>
              Pasahitza berria:      <input name="newpass1" id="newpass1" type="password" pattern=".{6,}" required onChange="balidatuPasahitza();"><br/><br/>
              Pasahitza berria errepikatu: <input name="newpass2" id="newpass2" type="password" pattern=".{6,}" required><br/>
              <input type="submit" id="submitBtn" value="Pasahitza aldatu" disabled>
            </form>

            <div id="password_AJAX_response">
    				</div>
    </div>

    </section>
	<footer class='main' id='f1'>
		<p><a href="http://en.wikipedia.org/wiki/Quiz" target="_blank">What is a Quiz?</a></p>
		<a href='https://github.com'>Link GITHUB</a>
	</footer>
</div>


<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
    xhro = new XMLHttpRequest();

    //AJAX kontroladorea sortu galdera kopurua ikusteko
    function getSecurityQuestion() {
      xhro.open("GET", "getSecurityQuestion.php?eposta=" + $('#eposta').val(), true);
      xhro.send("");
    }


    /*************************
    *** Pasahitza balidatu ***
    **************************/

    xhro_pass_valid = new XMLHttpRequest();

    function balidatuPasahitza() {
      if ($('#newpass1').val().length != 0) {
            xhro_pass_valid.open("GET", "balidatuPasahitzaAJAX.php?pass=" + $('#newpass1').val(), true);
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
          document.getElementById("submitBtn").disabled=true;
        }
        else {
          document.getElementById("password_AJAX_response").innerHTML = '<font color="green">Pasahitz hau onartua dago.</font>';
          document.getElementById("submitBtn").disabled=false;
        }
      }
    }


    xhro.onreadystatechange = function(){
      if(xhro.readyState==4 && xhro.status==200){
        if(! xhro.responseText.startsWith("ERROREA")){
            $('#submitBtn').prop('disabled', false);
            document.getElementById("enundiv").innerHTML = xhro.responseText;
        }
        else{
            document.getElementById("enundiv").innerHTML = '<font style="color:red;">' +  xhro.responseText + '</font>';
            $('#submitBtn').prop('disabled', true);
        }
      }
    }
</script>

</body>
</html>
