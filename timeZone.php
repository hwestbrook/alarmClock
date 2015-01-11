<?php

  include('message.php');
  include('clockSettings.php');

  // time zone destination
  $destination = "timeZone";

  // get the variables sent over
  if (!is_null($_GET['coreID'])) {
    
    $coreID = $_GET['coreID'];

    // grab the clock settings for the right clock
    $clockSettings = clockSettings($coreID);
    
    // get the access token out
    $accessToken = $clockSettings['accessToken'];

    // set our message to spark core to time zone
    $message = $clockSettings['timeZone'];

    // send our new time zone to the spark core
    $response = json_decode(message($destination, $message, $coreID, $accessToken));

    // lets make sure we are actually connecting and updating the core
    if ($response->connected == 1 and $response->return_value == 1) {
      // return our time zone
      echo $message;
    }
    else {
      echo "error with posting to clock";
      print_r($response);
    }

  }
  else if (!is_null($_POST['coreID']) and !is_null($_POST['timeZone'])) {
    $coreID = $_POST['coreID'];
    $field = $destination;
    $timeZoneSet = $_POST['timeZone'];

    // update time zone for this clock and get the new settings
    $clockSettings = clockSettingsUpdate($coreID, $field, $timeZoneSet);
    
    // get the access token out
    $accessToken = $clockSettings['accessToken'];

    // set our message to spark core to time zone
    $message = $clockSettings['timeZone'];

    // send our new time zone to the spark core
    $response = json_decode(message($destination, $message, $coreID, $accessToken));

    // lets make sure we are actually connecting and updating the core
    if ($response->connected == 1 and $response->return_value == 1) {
      // return our time zone
      echo $message;
    }
    else {
      echo "error with posting to clock";
      print_r($response);
    }

  }
  else {
    echo "do better next time!";
  }

?>