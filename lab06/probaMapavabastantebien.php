<!DOCTYPE html>
<html>
  <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
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


    <div id="map">
    <!-- Hemen mapa agertuko da -->
    </div>

    <script>
      var map;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          zoom: 6,
          //center: new google.maps.LatLng(43.8,-12.3),
          mapTypeId: 'terrain'
        });

        // Create a <script> tag and set the USGS URL as the source.
        var script = document.createElement('script');
        // This example uses a local copy of the GeoJSON stored at
        // http://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/2.5_week.geojsonp
        script.src = 'https://developers.google.com/maps/documentation/javascript/examples/json/earthquake_GeoJSONP.js';
        document.getElementsByTagName('head')[0].appendChild(script);
      }


      $.getJSON("http://ip-api.com/json/?callback=?", function(data) {
          /*var table_body = "";
          $.each(data, function(k, v) {
              table_body += "<tr><td>" + k + "</td><td><b>" + v + "</b></td></tr>";
          });
          $("#GeoResults").html(table_body);*/
          //taularen goiburukoak
          var table_body = "";
          table_body += "<tr><td>" + "Latitudea" + "</td><td><b>" + data.lat + "</b></td></tr>";
          table_body += "<tr><td>" + "Longitudea" + "</td><td><b>" + data.lon + "</b></td></tr>";
          //alert(data.lat);
          $("#GeoResults").html(table_body);

          /*map = new google.maps.Map(document.getElementById('map'), {
            zoom: 6,
            center: new google.maps.LatLng(data.lat,data.lon),
            mapTypeId: 'terrain'
          });

          // Create a <script> tag and set the USGS URL as the source.
          var script = document.createElement('script');
          // This example uses a local copy of the GeoJSON stored at
          // http://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/2.5_week.geojsonp
          script.src = 'https://developers.google.com/maps/documentation/javascript/examples/json/earthquake_GeoJSONP.js';
          document.getElementsByTagName('head')[0].appendChild(script);*/
      });

      // Loop through the results array and place a marker for each
      // set of coordinates.
      /*window.eqfeed_callback = function(results) {
        for (var i = 0; i < results.features.length; i++) {
          var coords = results.features[i].geometry.coordinates;
          var latLng = new google.maps.LatLng(coords[1],coords[0]);
          var marker = new google.maps.Marker({
            position: latLng,
            map: map
          });
        }
      }*/
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCS69MALD7kTtTnyj4_rb-ApVm7anSym8c&callback=initMap">
  </script>
  </body>
</html>
