<?php
//Check if incoming request method is POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    echo json_encode([
        "code" => 101,
        "status" => "error",
        "error" => "Invalid Request. Must be a POST request"
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
    $menu_data = mysqli_query($conn, "SELECT menus.menu_id, menus.restaurant_id, menus.menu_item, menus.menu_description, menus.menu_price, restaurants.restaurant_name, restaurants.rest_id FROM menus, restaurants WHERE menus.restaurant_id = restaurants.rest_id ");

    //Should error occur while fetching Menu data, Log error info
    if( !$menu_data ){

        $log  = "Log Date/Time ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
            "Error in Fetching Menus:  ************ ".mysqli_error($conn)." ".PHP_EOL.
            "--------------------------------------------------------------".PHP_EOL;
            file_put_contents('logs/log_'.date("d-M-Y").'.txt', $log, FILE_APPEND);
        
        }
        else{

            if(mysqli_num_rows($menu_data) > 0){
                
            $menu_array = [];

            while( $row =mysqli_fetch_assoc($menu_data) )
            {
                $menu_array[]= $row;
            }
            
            

            // $response = [];
            // $response[] =  $restaurant_array;
            // echo json_encode($response);

            echo json_encode($menu_array, JSON_PRETTY_PRINT);

            //close the db connection
            mysqli_close($conn);

            }

        }

    }



}