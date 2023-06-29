# food_delivery_api
API for an online food delivery platform


Documentation

PHP Version: 8.1
MySQL:  10.4.28-MariaDB
Web Server: Apache/2.4.56
XAMPP setup file contains all the above: xampp-windows-x64-8.1.17-0-VS16-installer.exe
Windows/Linux/Unix versions can be found here: https://www.apachefriends.org/download.html

Github repository:
https://github.com/erickofpep/food_delivery_api.git

Database Settings:
Database name: food_delivery_api
Database username: apiUser@2023
Database password: codeChallenge@2023

Once the database is created, this file ("food_delivery_api.sql") could be imported into the database to have tables and data ready to test the various endpoints.


1. Browse Restaurants:
Endpoint: food_delivery_api/browse_restaurants
It is also live here: https://heartforhumandev.com/food_delivery_api/browse_restaurants

Request Method: POST

Request Headers:
authorization_code = foodDeliveryAPI@user (NB: This must be base64 encoded)

Expected Response:
    [
	{
	  "rest_id": "1",
	  "restaurant_name": "Carrot Corner Restaurant",
	  "restaurant_address": "Otswe street, Osu",
	  "restaurant_city": "Accra",
	  "restaurant_country": "Ghana",
	  "restaurant_phonenumber": "0245000102",
	  "restaurant_email": "carrotrestaurant@gmail.com",
	  "further_info": ""
	}
    ]          


Expected Error Response:

{
 "code": 101,
 "status": "error",
 "message": "Invalid Request Method. Must be POST Request"
}

{
"code": 101,
"status": "error",
"error": "authorization_code header is missing"
}

{
"code": 101,
"status": "error",
"error": "Incorrect authorization_code. It must be base64 encoded"
}


2. View menu items:
Endpoint: food_delivery_api/browse_menus
It is also live here: https://heartforhumandev.com/food_delivery_api/browse_menus

Request Method: GET

Request Headers:
authorization_code = foodDeliveryAPI@user (NB: This must be base64 encoded)

Expected Response:
    [
	{
	  "menu_id": "8",
	  "restaurant_id": "1",
	  "menu_item": "Banku and Okro stew with Fish",
	  "menu_description": "Banku and Okro stew with Fish",
	  "menu_price": "60.00",
	  "restaurant_name": "Carrot Corner Restaurant",
	  "rest_id": "1"
	}
    ] 

3. Place Orders:
Endpoint: food_delivery_api/place_order
This is also live here: https://heartforhumandev.com/food_delivery_api/place_order

Request Headers:
authorization_code = foodDeliveryAPI@user (NB: This must be base64 encoded)

Request Method: POST

Expected Request Body:
{
  "fullname":"xxxxxxxxxxx",
  "contact_number":"xxxxxxxxxxx",
  "email_address":"xxxxxxxxxxx",
  "location_address":"xxxxxxxxxxx",
  "city":"xxxxxxxxxxx",
  "country":"xxxxxxxxxxx",
  "menu_id":"xxxxxxxxxxx",
  "delivery_amount":"xxxxxxxxxxx",
  "further_message_about_your_order":""
}

4. Display Orders:
Endpoint: food_delivery_api/show_orders
This is also live here: https://heartforhumandev.com/food_delivery_api/show_orders

Request Headers:
authorization_code = foodDeliveryAPI@user (NB: This must be base64 encoded)

Request Method: POST

Expected Response:
  [
     {
        "fullname": "Kelvin Boako",
        "contact_number": "0206100233",
        "email_address": "kelvinbk@yahoo.com",
        "location_address": "Kaokudi street, Nima",
        "city": "Nima, Accra",
        "country": "Ghana",
        "menu_id": "3",
        "menu_item": "Plain Rice and Palava Sauce",
        "menu_description": "Plain Rice and Palava Sauce",
        "menu_price": "60.00",
        "delivery_amount": "15.00",
        "total_amount": "75.00",
        "order_date": "2023-06-22 21:27:24"
       }
   ]

5. Add a Restaurant:

Endpoint:
food_delivery_api/add_restaurant
This is also live here: https://heartforhumandev.com/food_delivery_api/add_restaurant

Request Headers:
authorization_code = foodDeliveryAPI@user (NB: This must be base64 encoded)

Request Method: POST

Request Body:
{
  "restaurant_name":"xxxxxxxxxxx",
  "restaurant_address":"xxxxxxxxxxx",
  "restaurant_city":"xxxxxxxxxxx",
  "restaurant_country":"xxxxxxxxxxx",
  "restaurant_phonenumber":"xxxxxxxxxxx",
  "restaurant_email":"xxxxxxxxxxx",
  "further_info":"xxxxxxxxxxx"
}

6. Add a Menu:

Endpoint:
food_delivery_api/add_menu

Request Headers:
authorization_code = foodDeliveryAPI@user (NB: This must be base64 encoded)

Request Method: POST

Request Body:
{
  "menu_item":"xxxxxxxxxxx",
  "restaurant_id":"xxxxxxxxxxx",
  "menu_description":"xxxxxxxxxxx",
  "menu_price":"xxxxxxxxxxx"
}


7. Search for a Restaurant:

Endpoint: 
food_delivery_api/search_restaurant
This is also live here: https://heartforhumandev.com/food_delivery_api/search_restaurant

Request Headers:
authorization_code = foodDeliveryAPI@user 
(NB: This must be base64 encoded)

Request Method: GET

Request Body:
{
  "search_term":"xxxxxxxxxxx"
}

Expected Response:

      [
          {
            "rest_id": "2",
            "restaurant_name": "Erickof Restaurant",
            "restaurant_address": "Campus breakfast street, Taifa",
            "restaurant_city": "Accra",
            "restaurant_country": "Ghana",
            "restaurant_phonenumber": "0266100001"
           },
         {
          "menu_id": "2",
          "restaurant_id": "2",
          "menu_item": "Fried Rice and Fish",
          "menu_price": "55.00",
          "menu_description": "Fried Rice and Fish"
         }
      ]


