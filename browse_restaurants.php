<?php

//Check if incoming request method is POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    echo json_encode([
        'code' => 101,
        'status' => 'error',
        'message' =>'Invalid Request Method. Must be POST Request'
    ], JSON_PRETTY_PRINT);
	exit();
	
}
else{

    $headers = getallheaders();    

    if (!array_key_exists('authorization_code', $headers)) {

        echo json_encode([
            "code" => 101,
            "status" => "error",
            "error" => "authorization_code header is missing"
        ], JSON_PRETTY_PRINT);
        exit;
    }
    elseif ( $headers['authorization_code'] !== base64_encode('foodDeliveryAPI@user') ) {

        echo json_encode([
            "code" => 101,
            "status" => "error",
            "error" => "Incorrect authorization_code. It must be base64 encoded"
        ], JSON_PRETTY_PRINT);
        exit;
    }
    else{

    include_once('config/database_connection.php');

    //Get Restaurant details  
    $restaurant_data = mysqli_query($conn, "SELECT rest_id, restaurant_name, restaurant_address, restaurant_city, restaurant_country, restaurant_phonenumber, restaurant_email, further_info FROM restaurants ");
    
    //Should error occur while fetching Restaurants data, Log error info
    if( !$restaurant_data ){

    $log  = "Log Date/Time ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
        "Error in Fetching Restaurants:  ************ ".mysqli_error($conn)." ".PHP_EOL.
        "--------------------------------------------------------------".PHP_EOL;
        file_put_contents('logs/log_'.date("d-M-Y").'.txt', $log, FILE_APPEND);
    
    }
    else{ 
   

    if(mysqli_num_rows($restaurant_data) > 0){
        
    $restaurant_array = [];

    while($row =mysqli_fetch_assoc($restaurant_data))
    {
        $restaurant_array[] = $row;
        
    }

    echo json_encode($restaurant_array, JSON_PRETTY_PRINT);

    //close the db connection
    mysqli_close($conn);


    } 
    
  } 

}

}