<?php
  require('segurtasuna.php');
  if ($_SESSION["mota"] != 2)
    header("Location: layout.php");
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
      if (isset($_GET["eposta"])) {
        
        $email = trim($_GET["eposta"]);
        $image = trim($_GET["image"]);
        $urlparams = 'eposta=' . $email .'&image=' . $image;

        echo('<span><a href="layout.php?' . $urlparams . '">Home</a></span>');
				echo('<span><a href="credits.php?' . $urlparams . '">Credits</a></span>');
        if ($_SESSION["mota"] == 2) {
          echo('<span><a href="reviewingQuizes.php?' . $urlparams . '">Galderak errebisatu</a></span>');
        } else {
          echo('<span><a href="handlingQuizes.php?' . $urlparams . '">Galderak kudeatu</a></span>');
        }
      } else {
        echo('<span><a href="layout.php">Home</a></span>');
        echo('<span><a href="/quizzes">Quizzes</a></span>');
        echo('<span><a href="credits.php">Credits</a></span>');
        echo('<span><a href="signUp.php">Erregistratu</a></span>');
      }
    ?>
	</nav>
    <section class="half1" id="s1" style="text-align: left;">
    	<div>
        <h3> Galderak errebisatzen </h3> <br/>
        <input type="button" id="showAllBtn" value="Erakutsi Galdera Guztiak" /> edo bilatu galderak ondorengo ezaugarrien bidez: <br/> <br/>

        <form action="" method="GET"> 
          <input type="radio" name="ezaugarria" value=0 checked="checked" /> ID <br/>
          <input type="radio" name="ezaugarria" value=1 /> Zailtasuna <br/>
          <input type="radio" name="ezaugarria" value=2 /> Gaia <br/> <br/>
          <input type="text" id="param"/> <input type="button" id="showSomeBtn" value="Erakutsi galderak" /> 
        </form>

        <div id="galderenLista">

        </div>


    	</div>
    </section>

    <section class="half2" id="s2" style="text-align: left;">
      <div id="galderaAldatzen" hidden>
        <h3> Galdera eguneratzen </h3> <br/>
        <form action="" method="POST">
          Aldatzen ari garen galderaren IDa: <input type="text" id="gal_ID" value="" readonly="readonly"/> <br/>
          <input type="text" id="gal_erab" value="" readonly="readonly"/> erabiltzaileak igo du galdera. <br/> <br/>
          Enuntziatua: <br/> <textarea name="galdera" id="gal_enun" rows="2" cols="40"> </textarea> <br/> <br/>
          Emaitza zuzena: <input type="text" id="gal_ema" value="" /> <br/>
          Emaitza okerra 1: <input type="text" id="gal_oker1" value="" /> <br/>
          Emaitza okerra 2: <input type="text" id="gal_oker2" value="" /> <br/>
          Emaitza okerra 3: <input type="text" id="gal_oker3" value="" /> <br/>
          Zailtasuna: <select name="zail" id="gal_zail" > <br/>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select> <br/>
          Gaia: <input id="gal_gaia" value="" /> <br/> <br/>
          <input type="button" name="cancelBtn" value="Deuseztatu" onclick="deuseztatu();"/>
          <input type="button" name="saveBtn" value="Gorde" />
        </form>
      </div>

      <div id="erroreaGalderaAldatzen" hidden>

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
  
  //AJAX kontroladorea sortu galdera guztiak ikusteko
  xhro_show_all = new XMLHttpRequest();
  xhro_show_all.onreadystatechange = function(){
    if (xhro_show_all.readyState==4 && xhro_show_all.status==200) {
      document.getElementById("galderenLista").innerHTML=xhro_show_all.responseText;
    }
  }

  //Galderak ikusteko botoia sakatzean, AJAX eskaera egin
  $('#showAllBtn').click(function(){
    xhro_show_all.open("GET", "showAllQuestionsAJAX.php", true);
    xhro_show_all.send("");
  });

  //AJAX kontroladorea sortu galderak ikusteko
  xhro_show_some = new XMLHttpRequest();
  xhro_show_some.onreadystatechange = function(){
    if (xhro_show_some.readyState==4 && xhro_show_some.status==200) {
      document.getElementById("galderenLista").innerHTML=xhro_show_some.responseText;
    }
  }

  //Galderak ikusteko botoia sakatzean, AJAX eskaera egin
  $('#showSomeBtn').click(function(){
    xhro_show_some.open("GET", "showSomeQuestionsAJAX.php?mota=" + $("input:radio[name='ezaugarria']:checked").val() + "&param=" + $('#param').val() , true);
    xhro_show_some.send("");
  });


  //AJAX kontroladorea sortu galderak ikusteko
  xhro_load_ques = new XMLHttpRequest();
  xhro_load_ques.onreadystatechange = function(){
    if (xhro_load_ques.readyState==4 && xhro_load_ques.status==200) {
      if (xhro_load_ques.responseText.length != 0) {
        var val_array = xhro_load_ques.responseText.split(',');
        $('#gal_ID').val(val_array[0]);
        $('#gal_erab').val(val_array[1]);
        $('#gal_enun').val(val_array[2]);
        $('#gal_ema').val(val_array[3]);
        $('#gal_oker1').val(val_array[4]);
        $('#gal_oker2').val(val_array[5]);
        $('#gal_oker3').val(val_array[6]);
        $('#gal_zail').val(val_array[7]);
        $('#gal_gaia').val(val_array[8]);
        $('#galderaAldatzen').show();
        $('#erroreaGalderaAldatzen').hide();
      } else {
        document.getElementById("erroreaGalderaAldatzen").innerHTML='<p>Errorea galdera eskuratzean, saiatu berriz mesedez.</p>';
        $('#galderaAldatzen').hide();
        $('#erroreaGalderaAldatzen').show();
      }
    }
  }

  // Galdera bat aldatu nahi denean exekutatuko da
  function aldatuGaldera(id) {
    xhro_load_ques.open("GET", "loadQuestionAJAX.php?id=" + id, true);
    xhro_load_ques.send("");
  }

  function deuseztatu() {
     $('#galderaAldatzen').hide();
  }

</script>


</body>
</html>