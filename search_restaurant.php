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
    
            
    
        }
    
    
        }
    

    }

}