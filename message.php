<?php

  function message($destination, $message, $my_device, $my_access_token) {

    //the important part, curl
    $ch = curl_init();

    $url = "https://api.spark.io/v1/devices/" . $my_device . "/" . $destination;
    // echo $url;

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,"access_token=" . $my_access_token . "&params=" . $message);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $content = curl_exec ($ch);
    curl_close ($ch);

    return $content;
  }

?>