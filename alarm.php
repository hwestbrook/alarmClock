<?php

  include('message.php');
  include('credentials/sparkCred.php');

  $destination = "alarmTime";

  $message = urlencode("07:30:00 AM");

  echo $message;

  message($destination, $message, $heath_boom, $my_access_token);

?>