<!DOCTYPE html>
<html>

  <head>

  <link rel='stylesheet' type='text/css' href='stylesPWS/style.css' />
  <link rel='stylesheet'
       type='text/css'
       media='only screen and (min-width: 530px) and (min-device-width: 481px)'
       href='stylesPWS/wide.css' />
  <link rel='stylesheet'
       type='text/css'
       media='only screen and (max-width: 480px)'
       href='stylesPWS/smartphone.css' />

    <!-- iturria="https://developers.google.com/maps/documentation/javascript/geolocation?hl=es"-->

    <!-- JQuery liburutegia kargatu -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Kargatu Google Maps-eko API-a, gure kredentzialekin -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCS69MALD7kTtTnyj4_rb-ApVm7anSym8c"></script>

    <title>Geolocation</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">


    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>

    <table id="GeoResults">
    <!-- Hemen mapa agertuko da -->
    </table>

    <input type="button" onclick="initMap();" value="Nire posizioa"/>
    <div id="loader"></div>

    <div id="map">
    <!-- Hemen mapa agertuko da -->
    </div>

    <script>
      // Note: This example requires that you consent to location sharing when
      // prompted by your browser. If you see the error "The Geolocation service
      // failed.", it means you probably did not give permission for the browser to
      // locate you.
      function initMap() {
        document.getElementById("loader").style.display = "none";
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 43.307203, lng: -2.010842},
          zoom: 8
        });
        var infoWindow = new google.maps.InfoWindow({map: map});

        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };

            infoWindow.setPosition(pos);
            infoWindow.setContent('Location found.');
            map.setCenter(pos);

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
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
      }
    </script>


  </body>
</html>
