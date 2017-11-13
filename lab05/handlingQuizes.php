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
          echo '<a href="layout.php">LogOut</a>';
          echo '</div>';
        } else {
          echo '<span class="right"> <a href="logIn.php">LogIn</a> </span>';
          echo '<h2>Quiz: crazy questions</h2>';
        }
      ?>
    </header>
  	<nav class='main' id='n1' role='navigation'>
      <?php
	      if (isset($_GET["eposta"]) && isset($_GET["image"])) {
	        $email = trim($_GET["eposta"]);
				  $image = trim($_GET["image"]);
					$urlparams = 'eposta=' . $email .'&image=' . $image;

	        echo('<span><a href="layout.php?' . $urlparams . '">Home</a></span>');
	        echo('<span><a href="/quizzes">Quizzes</a></span>');
	        echo('<span><a href="credits.php?' . $urlparams . '">Credits</a></span>');
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
       <input type="button" id="showBtn" value="Galderak ikusi" style="text-align:left;"><br><br>
       <div id="showQuestionsResponse">
        <!--Hemen agertuko dira XML-ko galderak, AJAX bidez jarriko direnak erabiltzailea botoia sakatzean-->
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
       //AJAX kontroladorea sortu galderak sortzeko
       xhro_add = new XMLHttpRequest();
       xhro_add.onreadystatechange = function(){
          if(xhro_add.readyState==4 && xhro_add.status==200){
            document.getElementById("addQuestionResponse").innerHTML=xhro_add.responseText;
            //Id hau select bati dagokio, showQuestionsAJAX.php fitxategia sortuko duena
            //galerak erakusteko botoia sakatzean. Beraz, dagoeneko galderak erakusteko
            //select-a baldin badago dokumentuan, automatikoki eguneratu. Hurrengo
            //baldintzarekin, select-a dokumentuan dagoen ikusiko dugu
            if($("#xmlQuestions").length){
              xhro_show.open("GET", "showQuestionsAJAX.php", true);
              xhro_show.send("");
              $('#showQuestionsResponse').effect('shake');
              /*$('#showQuestionsResponse').animate({
                  'margin-left': '-=5px',
                  'margin-right': '+=5px'
              });*/
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

       //Galdera gehitzeko botoia sakatzean, formularioa balidatu eta AJAX eskaera egin
       $('#addBtn').click(function(){
           //balidatu galderaren luzera egokia dela
           if( $("#galdera").val().length < 10 ){
              alert("Galderaren enuntziatuak gutxienez 10 karaktere izan behar ditu!");
              return false;
           }
           //balidatu erantzunak ez daudela hutsik
           if ($("#zuzena").val().length < 1  ||
               $("#okerra1").val().length < 1 ||
               $("#okerra2").val().length < 1 ||
               $("#okerra3").val().length < 1 ){
                 alert("Erantzun zuzena bat eta 3 oker sartu behar dira");
                 return false;
           }
           //
           if( $("#gaia").val().length < 1 ){
              alert("Galderaren gaia sartu behar da");
              return false;
           }

           xhro_add.open("POST", "addQuestionAJAX.php", true);
           //xhro.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
           /*var POSTparams = <?php echo '"eposta=' . $_GET["eposta"].'"'?>;
           POSTparams = POSTparams + "&galdera=" + $('#galdera').val();
           POSTparams = POSTparams + "&zuzena=" + $('#zuzena').val();
           POSTparams = POSTparams + "&okerra1=" + $('#okerra1').val();
           POSTparams = POSTparams + "&okerra2=" + $('#okerra2').val();
           POSTparams = POSTparams + "&okerra3=" + $('#okerra3').val();
           POSTparams = POSTparams + "&zailtasuna=" + $('#zailtasuna').val();
           POSTparams = POSTparams + "&gaia=" + $('#gaia').val();
           xhro.send(POSTparams);*/

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
