<?php

  include('message.php');
  include('credentials/sparkCred.php');
  include('credentials/weatherCred.php');

  // zip code for weather
  $zip_code = "94117";

  // example
  // http://api.wunderground.com/api/02165672ed1da47a/geolookup/conditions/forecast/q/94107.json

  $json_string = file_get_contents(
    "http://api.wunderground.com/api/" . 
    $api_key . 
    "/geolookup" .
    "/conditions" .
    "/forecast" . 
    "/q" . 
    "/" . 
    $zip_code . 
    ".json"
  );

  // print_r($json_string);

  $parsed_json = json_decode($json_string);
  $location = $parsed_json->{'location'}->{'city'};
  $temp_f = $parsed_json->{'current_observation'}->{'temp_f'};
  $forecast_array = $parsed_json->{'forecast'}->{'simpleforecast'}->{'forecastday'};
  $high_f = $forecast_array[0]->{'high'}->{'fahrenheit'};
  
  // print_r($forecast_array);

  // destination for the spark core
  $destination = "topMessage";

  $message = urlencode( "High of: " . $high_f );

  echo $message;

  message($destination, $message, $heath_boom, $my_access_token);

?>