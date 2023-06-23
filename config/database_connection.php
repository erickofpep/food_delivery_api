<?php
$servername = 'localhost';
$username = 'apiUser@2023';
$password = 'codeChallenge@2023!';
$dbname = 'food_delivery_api';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // die(": " . $conn->connect_error);
    // echo "Connection failed: ".$conn->connect_error;

    //Log connection error
    $log  = "Log Date/Time ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
    "Database Connection status:  ************ $conn->connect_error ".PHP_EOL.
    "----------------------------------------------------------------------".PHP_EOL;
    file_put_contents('logs/log_'.date("d-M-Y").'.txt', $log, FILE_APPEND);

} else {

    //Log connection status
    $log  = "Log Date/Time ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
    "Database Connection status:  ************ Connected successfully ".PHP_EOL.
    "----------------------------------------------------------------------".PHP_EOL;
    file_put_contents('logs/log_'.date("d-M-Y").'.txt', $log, FILE_APPEND);

    // echo "Connected successfully";

}