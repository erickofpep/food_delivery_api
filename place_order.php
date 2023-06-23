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
    
    if( !$request_body ){
        echo json_encode([
            'code' => 101,
            'status' => 'error',
            'message' =>'No request body specified'
        ], JSON_PRETTY_PRINT);
    } 
    else{

        $decoded_request_body =  json_decode($request_body,true);
    
        $fullname=filter_var($decoded_request_body['fullname'],FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
    
        $contact_number=filter_var($decoded_request_body['contact_number'],FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);

        $email_address=filter_var($decoded_request_body['email_address'],FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
    
        $location_address=filter_var($decoded_request_body['location_address'],FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);

        $city=filter_var($decoded_request_body['city'],FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);
        
        $country=filter_var($decoded_request_body['country'],FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);

        $menu_id=filter_var($decoded_request_body['menu_id'],FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);

        $delivery_amount=filter_var($decoded_request_body['delivery_amount'],FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);

        $further_message_about_your_order=filter_var($decoded_request_body['further_message_about_your_order'],FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);        

        include_once('config/database_connection.php');       

        if( !array_key_exists('fullname', $decoded_request_body) ){
            echo json_encode([
                "code" => 101,
                "status" => "error",
                "message" => "fullname is missing."
            ], JSON_PRETTY_PRINT);
        }
        elseif( empty($fullname) || $fullname === ''){
            echo json_encode([
                "code" => 101,
                "status" => "error",
                "message" => "fullname is empty."
            ], JSON_PRETTY_PRINT);
        }
        elseif( !array_key_exists('contact_number', $decoded_request_body) ){
            echo json_encode([
                "code" => 101,
                "status" => "error",
                "message" => "contact_number is missing."
            ], JSON_PRETTY_PRINT);
        }
        elseif( !is_numeric($contact_number) ){
            echo json_encode([
                "code" => 101,
                "status" => "error",
                "message" => "contact_number must be numbers."
            ], JSON_PRETTY_PRINT);
        }
        elseif( empty($contact_number) || $contact_number === ''){
            echo json_encode([
                "code" => 101,
                "status" => "error",
                "message" => "contact_number is empty."
            ], JSON_PRETTY_PRINT);
        }
        elseif( !array_key_exists('email_address', $decoded_request_body) ){
            echo json_encode([
                "code" => 101,
                "status" => "error",
                "message" => "email_address is missing."
            ], JSON_PRETTY_PRINT);
        }
        elseif( empty($email_address) || $email_address === ''){
            echo json_encode([
                "code" => 101,
                "status" => "error",
                "message" => "email_address is empty."
            ], JSON_PRETTY_PRINT);
        }
        elseif( !filter_var($email_address, FILTER_VALIDATE_EMAIL) ){
            echo json_encode([
                "code" => 101,
                "status" => "error",
                "message" => "Invalid email_address is format."
            ], JSON_PRETTY_PRINT);
        } 
        elseif( !array_key_exists('location_address', $decoded_request_body) ){
            echo json_encode([
                "code" => 101,
                "status" => "error",
                "message" => "location_address is missing."
            ], JSON_PRETTY_PRINT);
        }
        elseif( empty($location_address) || $location_address === ''){
            echo json_encode([
                "code" => 101,
                "status" => "error",
                "message" => "location_address is empty."
            ], JSON_PRETTY_PRINT);
        }
        elseif( !array_key_exists('city', $decoded_request_body) ){
            echo json_encode([
                "code" => 101,
                "status" => "error",
                "message" => "city is missing."
            ], JSON_PRETTY_PRINT);
        }
        elseif( empty($city) || $city === ''){
            echo json_encode([
                "code" => 101,
                "status" => "error",
                "message" => "city is empty."
            ], JSON_PRETTY_PRINT);
        }
        elseif( !array_key_exists('country', $decoded_request_body) ){
            echo json_encode([
                "code" => 101,
                "status" => "error",
                "message" => "country is missing."
            ], JSON_PRETTY_PRINT);
        }
        elseif( empty($country) || $country === ''){
            echo json_encode([
                "code" => 101,
                "status" => "error",
                "message" => "country is empty."
            ], JSON_PRETTY_PRINT);
        }
        elseif( !array_key_exists('menu_id', $decoded_request_body) ){
            echo json_encode([
                "code" => 101,
                "status" => "error",
                "message" => "menu_id is missing."
            ], JSON_PRETTY_PRINT);
        }
        elseif( empty($menu_id) || $menu_id === ''){
            echo json_encode([
                "code" => 101,
                "status" => "error",
                "message" => "menu_id is empty."
            ], JSON_PRETTY_PRINT);
        }
        elseif( !is_numeric($menu_id) ){

            echo json_encode([
                "code" => 101,
                "status" => "error",
                "message" => "menu_id must be number(integer)."
            ], JSON_PRETTY_PRINT);

        }
        elseif( !array_key_exists('delivery_amount', $decoded_request_body) ){
            echo json_encode([
                "code" => 101,
                "status" => "error",
                "message" => "delivery_amount is missing."
            ], JSON_PRETTY_PRINT);
        }
        elseif( empty($delivery_amount) || $delivery_amount === ''){
            echo json_encode([
                "code" => 101,
                "status" => "error",
                "message" => "delivery_amount is empty."
            ], JSON_PRETTY_PRINT);
        }
        elseif( !is_numeric($decoded_request_body['delivery_amount']) ){
            echo json_encode([
                "code" => 101,
                "status" => "error",
                "message" => "delivery_amount must be number (decimal)."
            ], JSON_PRETTY_PRINT);
        }
        else{

            //Get Menu item price based on the menu_id
            $fetch_menu_item_price = mysqli_query($conn, "SELECT menu_id, menu_price FROM menus WHERE menu_id = $menu_id ");
            
            if(mysqli_num_rows($fetch_menu_item_price) == 0){

                echo json_encode([
                    "code" => 101,
                    "status" => "error",
                    "message" => "menu_id does not have a corresponding menu item."
                ], JSON_PRETTY_PRINT);
    
            }
            else{

                while( $row =mysqli_fetch_assoc($fetch_menu_item_price) ){
                    $menu_price = $row['menu_price'];
                }

                $menu_item_price = $menu_price;
            
                $total_amount = $menu_item_price + $delivery_amount;            

                $add_order_data = mysqli_query( $conn, "INSERT INTO orders (fullname, contact_number, email_address, location_address, city, country, menu_id, menu_price, delivery_amount, total_amount, order_message)VALUES ('$fullname', '$contact_number', '$email_address', '$location_address', '$city', '$country', '$menu_id', '$menu_price', '$delivery_amount', '$total_amount', '$further_message_about_your_order' )" );

                if(!$add_order_data ) {
      
                //Log Restaurant data entry failure
                $log  = "Log Date/Time ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
                    "Order data entry failed :  ************  mysqli_error($conn) ".PHP_EOL.
                    "----------------------------------------------------------------------".PHP_EOL;
                    file_put_contents('logs/log_'.date("d-M-Y").'.txt', $log, FILE_APPEND);
                
                    exit();
                
                }
                else{
                
                      echo json_encode([
                        "code" => 200,
                        "status" => "success",
                        "message" => "Order placed successfully"        
                        ], JSON_PRETTY_PRINT);
                
                }
                
            }

        }
    
    }        

    }


}