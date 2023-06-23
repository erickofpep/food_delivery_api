<?php

//Check if incoming request method is GET
if ($_SERVER['REQUEST_METHOD'] != 'GET') {
	
	$status = array(
                'code' => 101,
                'status' => 'error',
                'message' =>'Invalid Request. Must be a GET request'
            );
	echo json_encode($status);
	exit();
	
}
else{

    $headers = getallheaders();    

    if (!array_key_exists('authorization_code', $headers)) {

        echo json_encode([
            "code" => 101,
            "status" => "error",
            "error" => "authorization_code header is missing"
        ]);
        exit;
    }
    elseif ( $headers['authorization_code'] !== base64_encode('foodDeliveryAPI@user') ) {

        echo json_encode([
            "code" => 101,
            "status" => "error",
            "error" => "Incorrect authorization_code. It must be base64 encoded"
        ]);
        exit;
    }
    else{

    //Get request body parameters
    $request_body = file_get_contents('php://input'); 
    $decoded_request_body =  json_decode($request_body,true);
    
    if( !array_key_exists('search_term', $decoded_request_body) ){
        echo json_encode([
            "code" => 101,
            "status" => "error",
            "message" => "search_term is missing."
        ]);
    }
    elseif( empty($decoded_request_body['search_term']) || $decoded_request_body['search_term'] === ''){
                echo json_encode([
                    "code" => 101,
                    "status" => "error",
                    "message" => "search_term is empty."
                ]);
    }
    else{

            echo json_encode([
                "code" => 200,
                "status" => "success",
                'message' =>'search term is '.$decoded_request_body['search_term']
            ]);

    }


    }

}