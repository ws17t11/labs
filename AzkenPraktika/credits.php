<?php
  require("segurtasun_askea.php");
?>

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
  	<nav class='large' id='n1' role='navigation'>
      <?php
      if (isset($_SESSION["eposta"])) {
        echo('<span><a href="layout.php">Home</a></span>');
				echo('<span><a href="credits.php">Credits</a></span>');
				if ($_SESSION["mota"] == 2) { // irakaslea
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
    <section class="large" id="s1">
  	<div>
  		<p> Informatika fakultateko ikasleak gara, Jon Vadillo eta Ander Salaberria . Laugarren kurtsoa hasi dugu jada konputazioko 	espezialitatean, eta Web Sistemako irakasgaian web orri bat sortu behar dugunez, hemen gabiltza quizak egiten.</p>
  		<br/> <br/>
  		<p>Galdera intelektual batzuekin eguneroko gai filosofikoei erantzuteko aukera ematen dizuegu. Goza itzazue gure quizak! </p> <br/>
    	<table class="credits">
    	  <tr>
    	    <td><img src="img/andersalaberria.png" alt="Ander Salaberria" class="credit_img"/></td>
    	    <td><img src="img/jonvadillo.jpeg" alt="Jon Vadillo" class="credit_img"/></td>
        </tr>
    	  <tr>
    	    <td>Ander</td>
    	    <td>Jon</td>
        </tr>
  	  </table>

      <input type="button" onclick="initMap();document.getElementById('loader').style.display = 'block';" value="Nire posizioa ikusi"/>
      <input type="button" onclick="zerbiGeolocation();document.getElementById('loader').style.display = 'block';" value="Zerbitzariaren posizioa ikusi"/>

      <div id="loader" class="loader" style="display:none"></div>

      <table id="GeoResults" class="mytable">
      <!-- Hemen mapa agertuko da -->
      </table>

      <div id="loader"></div>

    	</div>

      <div id="map">
      <!-- Hemen mapa agertuko da -->
      </div>


      <br class="clear" />

      <!--
      <div class="box">
      	<a class="button" href="#popup1">Let me Pop up</a>
      </div>

      <div id="popup1" class="overlay">
      	<div class="popup">
      		<h2>Here i am</h2>
      		<a class="close" href="#">&times;</a>
      		<div class="content">

      			Thank to pop me out of that button, but now i'm done so you can close this window.
      		</div>
      	</div>
      </div>
      -->

    </section>

  	<footer class='main' id='f1'>
  		<p><a href="http://en.wikipedia.org/wiki/Quiz" target="_blank">What is a Quiz?</a></p>
  		<a href='https://github.com'>Link GITHUB</a>
  	</footer>
  </div>


      <!-- iturriak
        1) https://developers.google.com/maps/documentation/javascript/geolocation?hl=es
        2) https://www.avidalia.com/blog/como-solucionar-el-google-maps-api-error-missingkeymaperror
      -->

      <!-- JQuery liburutegia kargatu -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <!-- Kargatu Google Maps-eko API-a, gure kredentzialekin -->
      <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCS69MALD7kTtTnyj4_rb-ApVm7anSym8c"></script>

      <script>

        /************************
        *** ZERBI GEOLOCATION ***
        *************************/

        //AJAX kontroladorea sortu zerbitzariaren koordenatuak lortzeko
        xhro_geo = new XMLHttpRequest();

        function zerbiGeolocation() {
          xhro_geo.open("GET", "geolocation.php", true);
          xhro_geo.send("");
        }

        xhro_geo.onreadystatechange = function(){
          //loading gurpila kendu
          document.getElementById('loader').style.display = 'none';
          if(xhro_geo.readyState==4 && xhro_geo.status==200){

            //Zerbitzariaren koordenatuak lortzean errorerik egonez gero
            if(xhro_geo.responseText.trim().startsWith("ERROR")){
                //document.getElementById("eposta_AJAX_response").innerHTML = '<font color="red">Ikaslea WS ikasgaian matrikulatuta dago</font>';
                //document.getElementById("bidaliBtn").disabled=false;
                alert("Errorea zerbitzariko lokazioa lortzen");
                handleLocationError(true, infoWindow, map.getCenter());
            }
            else{
                /*Zerbitzaria "<latitudea>,<longitudea> bidaliko digu. Hortaz,
                 *bi datu horiek lortuko ditugu eta float motara pasako ditugu*/
                var lati_longi = xhro_geo.responseText.trim().split(',');
                var latitudea = parseFloat(lati_longi[0]);
                var longitudea = parseFloat(lati_longi[1]);

                //Mapa hasieratu, zentroa zerbitzariaren koordenatuetan duelarik
                var map = new google.maps.Map(document.getElementById('map'), {
                  center: {lat:latitudea, lng: longitudea},
                  zoom: 6
                });

                //kokatu informazio mezu bat mapan
                var infoWindow = new google.maps.InfoWindow({map: map});
                var pos = {
                  lat: latitudea,
                  lng: longitudea
                };
                infoWindow.setPosition(pos);
                infoWindow.setContent('Zerbitzariaren lokazioa');
                map.setCenter(pos);

                //Informazio taulan koordenatuak ezarri
                var table_body = "";
                table_body += "<tr><td>" + "Latitudea" + "</td><td><b>" + latitudea + "</b></td></tr>";
                table_body += "<tr><td>" + "Longitudea" + "</td><td><b>" + longitudea + "</b></td></tr>";
                $("#GeoResults").html(table_body);

            }
          }
        }

        /*************************
        *** BEZERO GEOLOCATION ***
        **************************/

        // Note: This example requires that you consent to location sharing when
        // prompted by your browser. If you see the error "The Geolocation service
        // failed.", it means you probably did not give permission for the browser to
        // locate you.
        function initMap() {

          //Mapa hasieratu
          var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 43.307203, lng: -2.010842},
            zoom: 1
          });
          var infoWindow = new google.maps.InfoWindow({map: map});

          // Try HTML5 geolocation.
          if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
              //Loading gurpila kendu
              document.getElementById("loader").style.display = "none";
              var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
              };

              infoWindow.setPosition(pos);
              infoWindow.setContent('Zure lokazioa');
              map.setCenter(pos);
              map.setZoom(12);

              var table_body = "";
              table_body += "<tr><td>" + "Latitudea" + "</td><td><b>" + position.coords.latitude + "</b></td></tr>";
              table_body += "<tr><td>" + "Longitudea" + "</td><td><b>" + position.coords.longitude + "</b></td></tr>";
              $("#GeoResults").html(table_body);

            }, function() {
              handleLocationError(true, infoWindow, map.getCenter());
            });


          } else {
            // Browser doesn't support Geolocation
            handleLocationError(false, infoWindow, map.getCenter());
          }
        }

        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
          alert("Errorea geolokalizazioarekin. Mesedez, ziurtatu nabigatzaileko lokalizazioa aktibatuta duzula.");
          //Loading gurpila kendu
          document.getElementById("loader").style.display = "none";
          infoWindow.setPosition(pos);
          infoWindow.setContent(browserHasGeolocation ?
                                'Error: The Geolocation service failed.' :
                                'Error: Your browser doesn\'t support geolocation.');
        }

      </script>


</body>
</html>
