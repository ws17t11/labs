<?php
//geocode, it will return false if unable to geocode address

    // google map geocode api url
    $url = "http://ip-api.com/json/?callback";

    // get the json response
    $resp_json = file_get_contents($url);

		//$resp_json2 = iconv('UTF-8', 'UTF-8//IGNORE', $resp_json);

    // decode the json
    $resp = json_decode($resp_json, true);

		if(json_last_error()){
			echo "ERROR";
		}
		else{
			echo $resp['lat'] . "," . $resp['lon'];
		}

?>
