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
        $decoded_request_body =  json_decode($request_body,true);

        $menu_item=filter_var($decoded_request_body['menu_item'],FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);

        $menu_description=filter_var($decoded_request_body['menu_description'],FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);

        if( !array_key_exists('menu_item', $decoded_request_body) ){
            echo json_encode([
                "code" => 101,
                "status" => "error",
                "message" => "menu_item is missing."
            ], JSON_PRETTY_PRINT);
        }
        elseif( empty($menu_item) || $menu_item === ''){
            echo json_encode([
                "code" => 101,
                "status" => "error",
                "message" => "menu_item is empty."
            ], JSON_PRETTY_PRINT);
        }
        elseif( !array_key_exists('restaurant_id', $decoded_request_body) ){
            echo json_encode([
                "code" => 101,
                "status" => "error",
                "message" => "restaurant_id is missing."
            ], JSON_PRETTY_PRINT);
        }
        elseif( !is_numeric($decoded_request_body['restaurant_id']) ){
            echo json_encode([
                "code" => 101,
                "status" => "error",
                "message" => "restaurant_id must be a number."
            ], JSON_PRETTY_PRINT);
        }
        elseif( !array_key_exists('menu_description', $decoded_request_body) ){
            echo json_encode([
                "code" => 101,
                "status" => "error",
                "message" => "menu_description is missing."
            ], JSON_PRETTY_PRINT);
        }
        elseif( empty($menu_description) || $menu_description === ''){
            echo json_encode([
                "code" => 101,
                "status" => "error",
                "message" => "menu_description is empty."
            ], JSON_PRETTY_PRINT);
        }
        elseif( !array_key_exists('menu_price', $decoded_request_body) ){
            echo json_encode([
                "code" => 101,
                "status" => "error",
                "message" => "menu_price is missing."
            ], JSON_PRETTY_PRINT);
        }
        elseif( !is_numeric($decoded_request_body['menu_price']) ){
            echo json_encode([
                "code" => 101,
                "status" => "error",
                "message" => "menu_price must be number (decimal)."
            ], JSON_PRETTY_PRINT);
        } 
        else{

            include_once('config/database_connection.php');

            //Ensure incoming Menu details does not exist
            $checkForExistence = mysqli_query($conn, "SELECT restaurant_id, menu_item, menu_description, menu_price FROM menus WHERE restaurant_id ='".$decoded_request_body['restaurant_id']."' AND menu_item='$menu_item' AND menu_description='$menu_description' AND menu_price='".$decoded_request_body['menu_price']."' ");

            if( mysqli_num_rows($checkForExistence) > 0 ){
                echo json_encode([
                    "code" => 101,
                    "status" => "error",
                    "message" => "Menu already exist"
                ], JSON_PRETTY_PRINT);
            }
            else{

    $add_menu_data = mysqli_query( $conn, "INSERT INTO menus (restaurant_id, menu_item, menu_description, menu_price)VALUES ('".$decoded_request_body['restaurant_id']."', '$menu_item', '$menu_description', '".$decoded_request_body['menu_price']."' )" );       
    if(!$add_menu_data ) {

    //Log Menu data entry failure
    $log  = "Log Date/Time ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
    "Menu data entry failed :  ************  mysqli_error($conn) ".PHP_EOL.
    "----------------------------------------------------------------------".PHP_EOL;
    file_put_contents('logs/log_'.date("d-M-Y").'.txt', $log, FILE_APPEND);

        exit();

     }
	 else{

      echo json_encode([
        "code" => 200,
        "status" => "success",
        "message" => "Menu data entered"        
        ], JSON_PRETTY_PRINT);

     }

    }

    }


    }

}





