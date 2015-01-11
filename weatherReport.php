<?php

  include('credentials/weatherCred.php');

  function weatherReport($zipCode) {
    // example
    // http://api.wunderground.com/api/02165672ed1da47a/geolookup/conditions/forecast/q/94107.json

    global $apiKey;

    $url = "http://api.wunderground.com/api/" . 
      $apiKey . 
      "/geolookup" .
      "/conditions" .
      "/forecast" . 
      "/q" . 
      "/" . 
      $zipCode . 
      ".json";

    // echo $url;

    $json_string = file_get_contents($url);

    $parsed_json = json_decode($json_string);
    $location = $parsed_json->{'location'}->{'city'};
    $temp_f = $parsed_json->{'current_observation'}->{'temp_f'};
    $forecast_array = $parsed_json->{'forecast'}->{'simpleforecast'}->{'forecastday'};
    $high_f = 
      "High of: " . 
      $forecast_array[0]->{'high'}->{'fahrenheit'}
    ;
    
    // this should return something like:
    // Today plan for rain, a high of 75 and a low of 55 — Tomorrow expect cloudy weather, with a high of 76 and a low of 61 — Wednesday expect rain, with a high of 73 and a low of 59 — Thursday …..
    $forecast = 
      "Current temp: " . 
      $temp_f . 
      "; Today Expect: " . 
      $forecast_array[0]->{'conditions'} . 
      ", High of " . 
      $forecast_array[0]->{'high'}->{'fahrenheit'} . 
      " Low of " . 
      $forecast_array[0]->{'low'}->{'fahrenheit'} . 
      "; Tomorrow : " . 
      $forecast_array[1]->{'conditions'} . 
      ", High of " . 
      $forecast_array[1]->{'high'}->{'fahrenheit'} . 
      " Low of " . 
      $forecast_array[1]->{'low'}->{'fahrenheit'} . 
      "; " . 
      $forecast_array[2]->{'date'}->{'weekday'} . 
      ": " . 
      $forecast_array[2]->{'conditions'} . 
      ", High of " . 
      $forecast_array[2]->{'high'}->{'fahrenheit'} . 
      " Low of " . 
      $forecast_array[2]->{'low'}->{'fahrenheit'}
    ;


    $weatherReport = array(
      'high_f' => $high_f, 
      'forecast' => $forecast, 
    );

    // print_r($forecast_array);

    // $weatherReport = $parsed_json;

    return $weatherReport;

  }

?>