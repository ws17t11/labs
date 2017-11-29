<?php
  require('segurtasuna.php');
  if ($_SESSION["mota"] != 1)
    header("Location: layout.php");
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
  	<title>Add Question (HTML 5)</title>
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
      <div id="numberUsers">
          <!-- Hemen agertuko da online dauden erabiltzaile kopurua -->
      </div>
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
          $email = trim($_GET["eposta"]);
          $image = trim($_GET["image"]);
          $urlparams = 'eposta=' . $email .'&image=' . $image;
          echo('<span><a href="layout.php?' . $urlparams . '">Home</a></span>');
          echo('<span><a href="/quizzes">Quizzes</a></span>');
          echo('<span><a href="credits.php?' . $urlparams . '">Credits</a></span>');
          if ($_SESSION["mota"] == 2) {
            echo('<span><a href="reviewingQuizes.php?' . $urlparams . '">Galderak errebisatu</a></span>');
          } else {
            echo('<span><a href="handlingQuizes.php?' . $urlparams . '">Galderak kudeatu</a></span>');
          }
	    ?>
      <!--<span><a href="layout.html">Log out</a></span> -->
  	</nav>
    <section class="half1" id="s1">
      <div>
        <form id="galderenF" name="galderenF" style="text-align:left;" enctype="multipart/form-data">

            <input type=button id="addBtn" value="Galdera sartu"><br>
            Galderaren enuntziatua (*): <br/>
            <textarea name="galdera" id="galdera" rows="2" cols="40"></textarea><br/><br/>
            Erantzun zuzena (*): <input name="zuzena" id="zuzena" type="text"><br/>
            Erantzun okerra 1 (*): <input name="okerra1" id="okerra1" type="text"><br/>
            Erantzun okerra 2 (*): <input name="okerra2" id="okerra2" type="text"><br/>
            Erantzun okerra 3 (*): <input name="okerra3" id="okerra3" type="text"><br/>
            Galderaren zailtasuna (*): <select name="zailtasuna" id="zailtasuna" >
                                          <option value="1">1</option>
                                          <option value="2">2</option>
                                          <option value="3">3</option>
                                          <option value="4">4</option>
                                          <option value="5">5</option>
                                        </select><br/>
            Galderaren gai-arloa (*): <input name="gaia" id="gaia" type="text"><br/><br/>
            Galderarekin zerikusia duen irudia: <input name="irudia" id="irudia" type="file" accept="image/*" ><br/>
            <input type="reset" id="garbitu" value="Garbitu">
        </form>
        <div id="addQuestionResponse">
          <!-- Hemen agertuko da galdera sartu ondorengo erantzuna -->
        </div>
      </div>

    </section>

    <section class="half2" id="s2" style="text-align:left;">
     <div>
       <input type="button" id="showBtn" value="Galderak ikusi" style="text-align:left;">
       <input type="button" id="showByIdBtn" value="Galderak ID bidez ikusi" style="text-align:left;"><br><br>
       <div id="showQuestionsResponse">
        <!--Hemen agertuko dira XML-ko galderak, AJAX bidez jarriko direnak erabiltzailea botoia sakatzean -->
       </div>
       <div id="searchQuestionByIdResponse"  style="display: none;">
          <form id='galderaById' name='galderaById' style='text-align:left;' enctype='multipart/form-data'>
                  Galderaren ID: <input name='galderarenId' id='galderarenId' type='number' min='1' value='1'/>
                  <input type='button' id='searchByIdBtn' value='Galdera bilatu'/><br>
          </form> 
          <div id='showQuestionByIdResponse'> 
          </div>
        <!--Hemen agertuko dira ID bidez bilatutako galderak, AJAX bidez jarriko direnak erabiltzailea botoia sakatzean -->
       </div>
       <br/> <br/>
       <div id="numberQuestions">
          <!-- Hemen agertuko da datu baseko galderen kopurua erabiltzailearen galderen kopuruarekiko -->
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
    $(document).ready(function(){

        /**************************
        *** Lehenengo Hautazkoa *** LAB5
        ***************************/

        xhro_n_quest = new XMLHttpRequest();
        var url_string = window.location.href;
        var url = new URL(url_string);
        var eposta = url.searchParams.get("eposta");

        //AJAX kontroladorea sortu galdera kopurua ikusteko
        function eguneratuGalderaKop() {
          xhro_n_quest.open("GET", "numberQuestions.php?eposta=" + eposta, true);
          xhro_n_quest.send("");
        }

        eguneratuGalderaKop();
        /*Galdera kopurua 20 segunduro eguneratzen da*/
        var run = setInterval(function(){eguneratuGalderaKop();}, 20000);
        xhro_n_quest.onreadystatechange = function(){
          if(xhro_n_quest.readyState==4 && xhro_n_quest.status==200){
            document.getElementById("numberQuestions").innerHTML = xhro_n_quest.responseText;
          }
        }

        /*************************
        *** Bigarren Hautazkoa *** LAB5
        **************************/

        xhro_n_user = new XMLHttpRequest();
        //AJAX kontroladorea sortu galdera kopurua ikusteko
        function eguneratuUserKop() {
          xhro_n_user.open("GET", "numberUsers.php", true);
          xhro_n_user.send("");
        }

        eguneratuUserKop();
        /*Galdera kopurua 20 segunduro eguneratzen da*/
        var run2 = setInterval(function(){eguneratuUserKop();}, 20000);
        xhro_n_user.onreadystatechange = function(){
          if(xhro_n_user.readyState==4 && xhro_n_user.status==200){
            document.getElementById("numberUsers").innerHTML = xhro_n_user.responseText;
          }
        }


        /*********************
        *** Derrigorrezkoa ***
        **********************/

       //AJAX kontroladorea sortu galderak sortzeko
       xhro_add = new XMLHttpRequest();
       xhro_add.onreadystatechange = function(){
          if(xhro_add.readyState==4 && xhro_add.status==200){
            document.getElementById("addQuestionResponse").innerHTML=xhro_add.responseText;

            //xmlQuestions Id-a taula bati dagokio, showQuestionsAJAX.php fitxategia sortuko duena
            //galerak erakusteko botoia sakatzean. Beraz, dagoeneko galderak erakusteko
            //select-a baldin badago dokumentuan, automatikoki eguneratu. Hurrengo
            //baldintzarekin, taula-a dokumentuan dagoen ikusiko dugu
            if($("#xmlQuestions").length && $("#xmlQuestions").is(":visible")){
              xhro_show.open("GET", "showQuestionsAJAX.php", true);
              xhro_show.send("");
              $('#showQuestionsResponse').effect('shake');
            }
          }
        }

       //AJAX kontroladorea sortu galderak ikusteko
        xhro_show = new XMLHttpRequest();
        xhro_show.onreadystatechange = function(){
           if(xhro_show.readyState==4 && xhro_show.status==200){
             document.getElementById("showQuestionsResponse").innerHTML=xhro_show.responseText;
           }
         }


       /******************
       *** Hautazkoa 1 *** LAB6
       *******************/

       // Galderak id bidez bilatzeko formularioa ikuspegi ezarri
       $("#showByIdBtn").click(function(){
           $("#showQuestionsResponse").hide();
           $("#searchQuestionByIdResponse").show();
           $("#showQuestionByIdResponse").hide();
       });

       //AJAX kontroladorea sortu galderak eskatzeko
       xhro_show_id = new XMLHttpRequest();
       xhro_show_id.onreadystatechange = function(){
          if(xhro_show_id.readyState==4 && xhro_show_id.status==200){
            document.getElementById("showQuestionByIdResponse").innerHTML=xhro_show_id.responseText.trim();
            $("#showQuestionByIdResponse").show();
          }
       }

       //Galdera ikusteko ID bidez botoia sakatzean, AJAX eskaera egin
       $("#searchByIdBtn").click(function(){
           if ($.isNumeric($('#galderarenId').val())) {
              xhro_show_id.open("GET", "getQuestionClient.php?id="+ $('#galderarenId').val(), true);
              xhro_show_id.send("");
           } else {
              document.getElementById("showQuestionByIdResponse").innerHTML='<br/> <em> ID zenbaki bat izan behar da.</em>';
              $("#showQuestionByIdResponse").show();
           }
       });

       //Galdera gehitzeko botoia sakatzean, formularioa balidatu eta AJAX eskaera egin
       $('#addBtn').click(function(){
           //balidatu galderaren luzera egokia dela
           if( $("#galdera").val().trim().length < 10 ){
              alert("Galderaren enuntziatuak gutxienez 10 karaktere izan behar ditu!");
              return false;
           }
           //balidatu erantzunak ez daudela hutsik
           if ($("#zuzena").val().trim().length < 1  ||
               $("#okerra1").val().trim().length < 1 ||
               $("#okerra2").val().trim().length < 1 ||
               $("#okerra3").val().trim().length < 1 ){
                 alert("Erantzun zuzena bat eta 3 oker sartu behar dira");
                 return false;
           }
           //
           if( $("#gaia").val().trim().length < 1 ){
              alert("Galderaren gaia sartu behar da");
              return false;
           }

           xhro_add.open("POST", "addQuestionAJAX.php", true);
           //xhro.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

           //Bidali datuak formData objektua erabiliz!
           var formElement = document.getElementById("galderenF");
           //lortu formularioaren parametro guztiak
           formData = new FormData(formElement);
           //gehitu epostaren parametroa automatikoki
           formData.append("eposta", <?php echo '"' . $_GET["eposta"] . '"'?>);
             // Display the key/value pairs
             /*for (var pair of formData.entries()) {
                alert(pair[0]+ ', ' + pair[1]);
            }*/
           xhro_add.send(formData);
           //xhro.send("");
       });


       //Galderak ikusteko botoia sakatzean, AJAX eskaera egin
       $('#showBtn').click(function(){
           $("#showQuestionsResponse").show();
           $("#searchQuestionByIdResponse").hide();
           $("#showQuestionByIdResponse").hide();
           xhro_show.open("GET", "showQuestionsAJAX.php", true);
           xhro_show.send("");
       });


        //erabiltzaileak irudi bat aukeratzen duenean
        $("#irudia").change(function(e){
          //irudia jadanik existitzen bada (aurretik bat aukeratu badu)
            if($("#gal_irudi").length){
              $("#gal_irudi").remove(); //ezabatu irudia
              $("#irudia_kendu_btn").remove(); //ezabatu irudia kentzeko botoia
            }

            // irudiaren etiketa eta atributuak definitzen dira
            var img = $('<img></img>', {
                            id: 'gal_irudi',
                            name: 'gal_irudi',
                            width: '128px'
                        });
            $("#galderenF").append(img); //irudia gehitu formularioan

            // Igo diren fitxategien lista files aldagaian
            var files = e.target.files;
            // fitxategiak irakurtzea ahalbidetzen du
            var fr = new FileReader();
            fr.onload = function () {
                // fr.result-ek igo den fitxaegiaren edukia itzultzen du
                $("#gal_irudi").attr("src", fr.result);
            }
            fr.readAsDataURL(files[0]);

            //sortu botoi bat irudia kentzeko aukera edukitzeko
            var nwbtn = $('<input/>', {
                            type: 'button',
                            value: 'Kendu irudia',
                            id: 'irudia_kendu_btn',
                            click: kenduIrudia
                          });
            $('#gal_irudi').after(nwbtn); //sartu botoia formularioan

            function kenduIrudia() {
                $("#gal_irudi").remove(); //kendu irudia
                $("#irudia").val(""); //garbitu fitxategi hautatzailearen balioa
                $("#irudia_kendu_btn").remove(); //kendu sakatu berri den botoia :)
            }
        });

        //reset botoiari click egitean, irudi bat hautatu egin bada, ezabatu
    		$("#garbitu").click(function(){
    			//irudiren bat aukeratu bada, ezabatu
    			if($("#gal_irudi").length){
    				$("#gal_irudi").remove(); //kendu irudia
    				$("#irudia").val(""); //garbitu fitxategi hautatzailearen balioa
    				$("#irudia_kendu_btn").remove(); //kendu sakatu berri den botoia :)
    			}
    		});

  });
</script>
</body>
</html>
