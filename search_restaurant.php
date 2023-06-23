<?php
//Check if incoming request method is POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	echo json_encode([
        'code' => 101,
        'status' => 'error',
        'message' =>'Invalid Request. Must be a POST request'
    ], JSON_PRETTY_PRINT);
	exit();
	
}
else{

    $headers = getallheaders();    

    if (!array_key_exists('authorization_code', $headers)) {

        echo json_encode([
            'code' => 101,
            'status' => 'error',
            'message' =>'authorization_code header is missing'
        ], JSON_PRETTY_PRINT);
        
        exit;
    }
    elseif ( $headers['authorization_code'] !== base64_encode('foodDeliveryAPI@user') ) {

        echo json_encode([
            'code' => 101,
            'status' => 'error',
            'message' =>'Incorrect authorization_code. It must be base64 encoded'
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

        $search_term=filter_var($decoded_request_body['search_term'],FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH);

        if( !array_key_exists('search_term', $decoded_request_body) ){
            echo json_encode([
                'code' => 101,
                'status' => 'error',
                'message' =>'search_term is missing.'
            ], JSON_PRETTY_PRINT);
        } 
        elseif( empty($search_term) || $search_term === ''){
            echo json_encode([
                'code' => 101,
                'status' => 'error',
                'message' =>'search_term is empty.'
            ], JSON_PRETTY_PRINT);
        }       
        else{
    
            include_once('config/database_connection.php');

            //Check if search_term matches any Restaurant name
        
            $checkForExistence = mysqli_query($conn, "SELECT rest_id, restaurant_name, restaurant_address, restaurant_city, restaurant_country, restaurant_phonenumber, restaurant_phonenumber FROM restaurants WHERE restaurant_name LIKE '%$search_term%' OR rest_id LIKE '%$search_term%'");
            
            if( mysqli_num_rows($checkForExistence) > 0) {                

                $restaurant_array = [];

                while( $row =mysqli_fetch_assoc($checkForExistence) )
                {
                    $restaurant_array[]= $row;
                    
                    $rest_id=$row['rest_id'];

                    $Get_Menus = mysqli_query($conn, "SELECT menu_id, restaurant_id, menu_item, menu_price, menu_description FROM menus WHERE restaurant_id ='$rest_id' ");

                    $menu_array = [];
                    while( $row_menu =mysqli_fetch_assoc($Get_Menus) )
                    {
                        $menu_array[]= $row_menu;
                    }

                }                

                echo json_encode( array_merge($restaurant_array, $menu_array) , JSON_PRETTY_PRINT);

                //close the db connection
                mysqli_close($conn);


            // echo json_encode([ "code"=> 101, "status"=> "success", "message"=> "Found"], JSON_PRETTY_PRINT);
            }
            else {

                echo json_encode([ "code"=> 101, "status"=> "error", "message"=> "No Result found"], JSON_PRETTY_PRINT);

            }
    
        }
    
    
        }
    

    }

}