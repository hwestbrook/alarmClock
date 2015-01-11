<?php

  include('message.php');
  include('clockSettings.php');
  include('weatherReport.php');

  // destination for the spark core
  $primaryWeatherDestination = "topMessage";
  $secondaryWeatherDestination = "weatherFor";

  // default zip code for weather
  $zip_code = "94117";

  // get the variables sent over
  if (!is_null($_GET['coreID'])) {
    
    $coreID = $_GET['coreID'];

    // grab the clock settings for the right clock
    $clockSettings = clockSettings($coreID);
    
    // get the access token out
    $accessToken = $clockSettings['accessToken'];

    // set our zip code to db provided zip code
    $zipCode = $clockSettings['zipCode'];
    // echo $zipCode;

    // get our weather report
    $weatherReport = weatherReport($zipCode);
    print_r($weatherReport);

    // $message = $message = urlencode( "High of: " . $high_f );
    $primaryWeatherMessage = urlencode($weatherReport['high_f']);
    $secondaryWeatherMessage = urlencode($weatherReport['forecast']);
    // echo $primaryWeatherMessage;

    // send our new high temp to spark core
    $response1 = json_decode(message($primaryWeatherDestination, $primaryWeatherMessage, $coreID, $accessToken));

    // send our new weather forecast to spark core
    $response2 = json_decode(message($secondaryWeatherDestination, $secondaryWeatherMessage, $coreID, $accessToken));

    // lets make sure we are actually connecting and updating the core
    if ($response1->connected == 1 and $response1->return_value == 1 and $response2->connected == 1 and $response2->return_value == 1) {
      // return our time zone
      echo $primaryWeatherMessage;
      echo " ";
      echo $secondaryWeatherMessage;
    }
    else {
      echo "error with posting to clock";
      print_r($response);
    }

  }


  // example
  // http://api.wunderground.com/api/02165672ed1da47a/geolookup/conditions/forecast/q/94107.json

  // $json_string = file_get_contents(
  //   "http://api.wunderground.com/api/" . 
  //   $api_key . 
  //   "/geolookup" .
  //   "/conditions" .
  //   "/forecast" . 
  //   "/q" . 
  //   "/" . 
  //   $zip_code . 
  //   ".json"
  // );

  // print_r($json_string);

  // $parsed_json = json_decode($json_string);
  // $location = $parsed_json->{'location'}->{'city'};
  // $temp_f = $parsed_json->{'current_observation'}->{'temp_f'};
  // $forecast_array = $parsed_json->{'forecast'}->{'simpleforecast'}->{'forecastday'};
  // $high_f = $forecast_array[0]->{'high'}->{'fahrenheit'};
  
  // print_r($forecast_array);

  

  // $message = urlencode( "High of: " . $high_f );

  // echo $message;

  // message($destination, $message, $heath_boom, $my_access_token);

?>