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
    ?>
    </header>
	<nav class='main' id='n1' role='navigation'>
    <?php
        echo('<span><a href="layout.php">Home</a></span>');
				echo('<span><a href="credits.php">Credits</a></span>');
        if ($_SESSION["mota"] == 2) {
          echo('<span><a href="reviewingQuizes.php">Galderak errebisatu</a></span>');
        } else {
          echo('<span><a href="handlingQuizes.php">Galderak kudeatu</a></span>');
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
          <div id="bilatuGaldera" style="margin-left: 30%; margin-top: -11%;">
            <input type="text" id="param"/>
            <input type="button" id="showSomeBtn" value="Erakutsi galderak" />
          </div>
        </form>

        <br/><br/>
        <div id="galderenLista">

        </div>


    	</div>
    </section>

    <section class="half2" id="s2" style="text-align: left;">
      <div id="galderaAldatzen" hidden>
        <h3> Galdera eguneratzen </h3>
        <br/>
        <form action="" method="POST">
          Aldatzen ari garen galderaren IDa: <input type="text" id="gal_ID" value="" size="7" readonly="readonly"/> <br/>
          <input type="text" id="gal_erab" value="" size="35" readonly="readonly"/> erabiltzaileak igo du galdera. <br/> <br/>
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
          <input type="button" name="saveBtn" value="Gorde" onclick="galderaEguneratu();"/>
        </form>
      </div>
      <div id="mezuaGalderaAldatzen">

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
      document.getElementById("galderenLista").innerHTML="Klikatu galdera azaltzen den taularen lerroa hura editatzeko:" +xhro_show_all.responseText;
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
      document.getElementById("galderenLista").innerHTML="Klikatu galdera azaltzen den taularen lerroa hura editatzeko:" + xhro_show_some.responseText;
    }
  }

  //Galderak ikusteko botoia sakatzean, AJAX eskaera egin
  $('#showSomeBtn').click(function(){
    xhro_show_some.open("GET", "showSomeQuestionsAJAX.php?mota=" + $("input:radio[name='ezaugarria']:checked").val() + "&param=" + $('#param').val() , true);
    xhro_show_some.send("");
  });


  // Galdera bat aldatu nahi denean exekutatuko da
  function aldatuGaldera(id) {

    for (i = 0; i < $('#galTaula tr').length; i++) {
      if (parseInt($('#galTaula').find("tr:eq(" + i + ") td:eq(0)").text()) == id) {
        $('#gal_ID').val($('#galTaula').find("tr:eq(" + i + ") td:eq(0)").text());
        $('#gal_erab').val($('#galTaula').find("tr:eq(" + i + ") td:eq(1)").text());
        $('#gal_enun').val($('#galTaula').find("tr:eq(" + i + ") td:eq(2)").text());
        $('#gal_ema').val($('#galTaula').find("tr:eq(" + i + ") td:eq(3)").text());
        var okerrak = $('#galTaula').find("tr:eq(" + i + ") td:eq(4)").html().split('<br>');
        $('#gal_oker1').val(okerrak[0]);
        $('#gal_oker2').val(okerrak[1]);
        $('#gal_oker3').val(okerrak[2]);
        $('#gal_zail').val($('#galTaula').find("tr:eq(" + i + ") td:eq(5)").text());
        $('#gal_gaia').val($('#galTaula').find("tr:eq(" + i + ") td:eq(6)").text());
        $('#galderaAldatzen').show();
        $('#mezuaGalderaAldatzen').html("");
      }
    }

  }


  function deuseztatu() {
     $('#galderaAldatzen').hide();
  }

  //AJAX kontroladorea sortu galdera eguneratzeko
  xhro_save_ques = new XMLHttpRequest();
  xhro_save_ques.onreadystatechange = function(){
    if (xhro_save_ques.readyState==4 && xhro_save_ques.status==200) {
      $('#galderaAldatzen').hide();
      document.getElementById("mezuaGalderaAldatzen").innerHTML=xhro_save_ques.responseText;
    }
  }

  //Galderak ikusteko botoia sakatzean, AJAX eskaera egin
  function galderaEguneratu() {

    //balidatu galderaren luzera egokia dela
    if($("#gal_enun").val().trim().length < 10 ){
      alert("Galderaren enuntziatuak gutxienez 10 karaktere izan behar ditu!");
      return false;
    }
    //balidatu erantzunak ez daudela hutsik
    if ($("#gal_ema").val().trim().length < 1  ||
       $("#gal_oker1").val().trim().length < 1 ||
       $("#gal_oker2").val().trim().length < 1 ||
       $("#gal_oker3").val().trim().length < 1 ){
         alert("Erantzun zuzena bat eta 3 oker sartu behar dira");
         return false;
    }
    //
    if( $("#gal_gaia").val().trim().length < 1 ){
      alert("Galderaren gaia sartu behar da");
      return false;
    }

    var params = "id=" + $("#gal_ID").val() + "&galdera=" + $("#gal_enun").val() + "&ema=" + $("#gal_ema").val() + "&oker1=" + $("#gal_oker1").val() + "&oker2=" + $("#gal_oker2").val() + "&oker3=" + $("#gal_oker3").val() + "&zail=" + $("#gal_zail").val()  + "&gaia=" + $("#gal_gaia").val();
    xhro_save_ques.open("POST", "saveQuestionAJAX.php", true);
    xhro_save_ques.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhro_save_ques.send(params);
  }

</script>


</body>
</html>
