<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
      <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
  	<title>Add Question</title>
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

	        echo('<span><a href="addQuestion.php?' . $urlparams . '">Add question</a></span>');
	        echo('<span><a href="addQuestionHTML5.php?' . $urlparams . '">Add question (HTML 5)</a></span>');
	        echo('<span><a href="showQuestions.php?' . $urlparams . '">Galderak ikusi (irudirik gabe)</a></span>');
	        echo('<span><a href="showQuestionsWithImages.php?' . $urlparams . '">Galderak ikusi (irudiekin)</a></span>');
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
        <form action="addQuestionWithImages.php" method="post" id="galderenF" name="galderenF" style="text-align:left;" enctype="multipart/form-data">

          <?php
            //logeatuta baldin badago, eposta automatikoki sartu
            if (isset($_GET["eposta"])) {
             echo 'Eposta (*): <input name="eposta" id="eposta" type="text" size="40" value="' . $_GET["eposta"] . '"><br/><br/>';
            }
            else{
             echo 'Eposta (*): <input name="eposta" id="eposta" type="text" size="40" placeholder="Adib: izena123@ikasle.ehu.es"><br/><br/>';
            }
           ?>
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
            <input type="submit" value="Bidali"> <input type="reset" id="garbitu" value="Garbitu">
        </form>
      </div>
    </section>
  	<footer class='main' id='f1'>
  		<p><a href="http://en.wikipedia.org/wiki/Quiz" target="_blank">What is a Quiz?</a></p>
  		<a href='https://github.com'>Link GITHUB</a>
  	</footer>
  </div>

<script type="text/javascript">

    $(document).ready(function(){
        $("#galderenF").submit(function(){
            return true;
            //balidatu eposta
            var emailRegex = /^[a-zA-Z]+[0-9]{3}@ikasle\.ehu\.(es|eus)$/;
            if(! emailRegex.test($("#eposta").val()) ) {
              alert("Epostak ez du EHU-ko formatua! Adib: izena123@ikasle.ehu.es");
              return false;
            }
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

            return true;
        });

        //erabiltzailea irudi bat aukeratzen duenean
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
                            height: '150px',
                            maxwidth: '200px'
                        });
      		  $("#galderenF").append(img);

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
