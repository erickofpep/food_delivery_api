<?php

//Check if incoming request method is POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {

	echo json_encode([
        'code' => 101,
        'status' => 'error',
        'message' =>'Invalid Request Method. Must be a POST request'
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

        //Get request body parameters
        $request_body = file_get_contents('php://input');
        if( !$request_body) {
            echo json_encode([ 'code'=> 101, 'status'=> 'error', 'message'=>'No request body specified'], JSON_PRETTY_PRINT);
        }
        else {

            $decoded_request_body =  json_decode($request_body,true);

            $restaurant_name=filter_var($decoded_request_body['restaurant_name'],FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
    
            $restaurant_address=filter_var($decoded_request_body['restaurant_address'],FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
    
            $restaurant_city=filter_var($decoded_request_body['restaurant_city'],FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
    
            $restaurant_country=filter_var($decoded_request_body['restaurant_country'],FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
    
            $restaurant_phonenumber=filter_var($decoded_request_body['restaurant_phonenumber'],FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
    
            $restaurant_email=filter_var($decoded_request_body['restaurant_email'],FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
    
            $further_info=filter_var($decoded_request_body['further_info'],FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);


            if( !array_key_exists('restaurant_name', $decoded_request_body) ){
                echo json_encode([
                    "code" => 101,
                    "status" => "error",
                    "message" => "restaurant_name is missing."
                ], JSON_PRETTY_PRINT);
            }
            elseif( empty($restaurant_name) || $restaurant_name === ''){
                echo json_encode([
                    "code" => 101,
                    "status" => "error",
                    "message" => "restaurant_name is empty."
                ], JSON_PRETTY_PRINT);
            }
            elseif( !array_key_exists('restaurant_address', $decoded_request_body) ){
                echo json_encode([
                    "code" => 101,
                    "status" => "error",
                    "message" => "restaurant_address is missing."
                ], JSON_PRETTY_PRINT);
            }
            elseif( empty($restaurant_address) || $restaurant_address === ''){
                echo json_encode([
                    "code" => 101,
                    "status" => "error",
                    "message" => "restaurant_address is empty."
                ], JSON_PRETTY_PRINT);
            }
            elseif( !array_key_exists('restaurant_city', $decoded_request_body) ){
                echo json_encode([
                    "code" => 101,
                    "status" => "error",
                    "message" => "restaurant_city is missing."
                ], JSON_PRETTY_PRINT);
            }
            elseif( empty($restaurant_city) || $restaurant_city === ''){
                echo json_encode([
                    "code" => 101,
                    "status" => "error",
                    "message" => "restaurant_city is empty."
                ], JSON_PRETTY_PRINT);
            }
            elseif( !array_key_exists('restaurant_country', $decoded_request_body) ){
                echo json_encode([
                    "code" => 101,
                    "status" => "error",
                    "message" => "restaurant_country is missing."
                ], JSON_PRETTY_PRINT);
            }
            elseif( empty($restaurant_country) || $restaurant_country === ''){
                echo json_encode([
                    "code" => 101,
                    "status" => "error",
                    "message" => "restaurant_country is empty."
                ], JSON_PRETTY_PRINT);
            }        
            elseif( !array_key_exists('restaurant_phonenumber', $decoded_request_body) ){
                echo json_encode([
                    "code" => 101,
                    "status" => "error",
                    "message" => "restaurant_address is missing."
                ], JSON_PRETTY_PRINT);
            }        
            elseif( empty($restaurant_phonenumber) || $restaurant_phonenumber === '' ){
                echo json_encode([
                    "code" => 101,
                    "status" => "error",
                    "message" => "restaurant_phonenumber is empty."
                ], JSON_PRETTY_PRINT);
            }        
            elseif( strlen($restaurant_phonenumber) > 30 ){
                echo json_encode([
                    "code" => 101,
                    "status" => "error",
                    "message" => "restaurant_phonenumber is too long a Phone number."
                ], JSON_PRETTY_PRINT);
            }
            elseif( !is_numeric($restaurant_phonenumber) ){
                echo json_encode([
                    "code" => 101,
                    "status" => "error",
                    "message" => "restaurant_phonenumber should be numbers."
                ], JSON_PRETTY_PRINT);
            }
            elseif( !array_key_exists('restaurant_email', $decoded_request_body) ){
                echo json_encode([
                    "code" => 101,
                    "status" => "error",
                    "message" => "restaurant_email is missing."
                ], JSON_PRETTY_PRINT);
            }
            elseif( empty($restaurant_email) || $restaurant_email === '' ){
                echo json_encode([
                    "code" => 101,
                    "status" => "error",
                    "message" => "restaurant_email is empty."
                ], JSON_PRETTY_PRINT);
            }
            elseif( !filter_var($restaurant_email, FILTER_VALIDATE_EMAIL) ){
                echo json_encode([
                    "code" => 101,
                    "status" => "error",
                    "message" => "Invalid restaurant_email is format."
                ], JSON_PRETTY_PRINT);
            } 
            elseif( !array_key_exists('further_info', $decoded_request_body) ){
                echo json_encode([
                    "code" => 101,
                    "status" => "error",
                    "message" => "further_info is missing."
                ], JSON_PRETTY_PRINT);
            }
            else{
    
                include_once('config/database_connection.php');
    
                //Ensure incoming Restaurant details does not exist
                $checkForExistence = mysqli_query($conn, "SELECT restaurant_name, restaurant_address, restaurant_city, restaurant_country, restaurant_phonenumber FROM restaurants WHERE restaurant_name ='$restaurant_name' AND restaurant_address='$restaurant_address' AND restaurant_city='$restaurant_city' AND restaurant_country='$restaurant_country' AND restaurant_phonenumber='$restaurant_phonenumber' ");
    
                if( mysqli_num_rows($checkForExistence) > 0 ){
                    echo json_encode([
                        "code" => 101,
                        "status" => "error",
                        "message" => "Restaurant already exist"
                    ], JSON_PRETTY_PRINT);
                }
                else{
    
          $add_restaurant_data = mysqli_query( $conn, "INSERT INTO restaurants (restaurant_name,restaurant_address, restaurant_city, restaurant_country, restaurant_phonenumber, restaurant_email, further_info)VALUES ('$restaurant_name','$restaurant_address','$restaurant_city', '$restaurant_country', '$restaurant_phonenumber', '$restaurant_email', '$further_info' )" );       
          if(!$add_restaurant_data ) {
    
        //Log Restaurant data entry failure
        $log  = "Log Date/Time ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
        "Restaurant data entry failed :  ************  mysqli_error($conn) ".PHP_EOL.
        "----------------------------------------------------------------------".PHP_EOL;
        file_put_contents('logs/log_'.date("d-M-Y").'.txt', $log, FILE_APPEND);
    
            exit();
    
         }
         else{
    
          echo json_encode([
            "code" => 200,
            "status" => "success",
            "message" => "Restaurant data entered"        
            ], JSON_PRETTY_PRINT);
    
         }                    
    
               }
    
                
            }    
    
        }

        }

}