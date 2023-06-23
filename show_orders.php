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

    //Get Orders
    $order_data = mysqli_query($conn, "SELECT orders.fullname, orders.contact_number, orders.email_address, orders.location_address, orders.city, orders.country, orders.menu_id, menus.menu_item, menus.menu_description, menus.menu_price, orders.delivery_amount, orders.total_amount, orders.order_message, orders.order_date, menus.menu_id FROM orders, menus WHERE orders.menu_id = menus.menu_id ");

    //Should error occur while fetching Menu data, Log error info
    if( !$order_data ){

        $log  = "Log Date/Time ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
            "Error in Fetching Orders:  ************ ".mysqli_error($conn)." ".PHP_EOL.
            "--------------------------------------------------------------".PHP_EOL;
            file_put_contents('logs/log_'.date("d-M-Y").'.txt', $log, FILE_APPEND);
        
        }
        else{

            if(mysqli_num_rows($order_data) > 0){

            $order_array = [];

            while( $row =mysqli_fetch_assoc($order_data) )
            {
                $order_array[]= $row;
            }

            echo json_encode($order_array, JSON_PRETTY_PRINT);

            //close the db connection
            mysqli_close($conn);


            }
        
        }

    }


}