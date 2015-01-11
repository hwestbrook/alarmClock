<?php

  include('credentials/sparkCred.php');
  include('credentials/dbCred.php');

  function clockSettings($coreID) {
    global $databaseURL, $dbUserName, $dbPassword, $database;

    $mysqli = new mysqli($databaseURL, $dbUserName, $dbPassword, $database);
    if ($mysqli->connect_errno) {
      echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }

    $selectClockSettings = "SELECT * FROM `clockSettings` WHERE `coreID` = '$coreID'";

    $result = $mysqli->query($selectClockSettings);

    $clockSettings = mysqli_fetch_assoc($result);

    return $clockSettings;
  }

  // this function takes in a core id, a field you want to update and a value for that field
  // it then returns the updated results
  function clockSettingsUpdate($coreID, $field, $value) {
    global $databaseURL, $dbUserName, $dbPassword, $database;

    // connect to the database
    $mysqli = new mysqli($databaseURL, $dbUserName, $dbPassword, $database);
    if ($mysqli->connect_errno) {
      echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }

    // prepare out statement to update time zone, then bind and update
    $stmt = $mysqli->prepare("UPDATE `clockSettings` SET `$field` = ? WHERE `coreID` = ?");
    $stmt->bind_param('ss', $value, $coreID);
    $stmt->execute(); 
    $stmt->close();

    // query the other parameters
    $selectClockSettings = "SELECT * FROM `clockSettings` WHERE `coreID` = '$coreID'";

    // parse the result
    $result = $mysqli->query($selectClockSettings);

    $clockSettings = mysqli_fetch_assoc($result);
    
    return $clockSettings;
  }

?>