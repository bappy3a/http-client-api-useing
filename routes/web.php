<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::any('/air/search', 'HomeController@search')->name('get.search');
Route::any('/get/Authenticate', 'HomeController@authenticate')->name('get.authenticate');

Route::get("/token", function(){
  
		$data = array(
			"AdultQuantity" => 1,
			"ChildQuantity" => 0,
			"InfantQuantity" => 0,
			"EndUserIp" => "192.168.1.1",
			"JourneyType" => "1",
			"Segments" => array(
					array(
					"Origin" => "DEL",
					"Destination" => "DXB",
					"CabinClass" => "1",
					"DepartureDateTime" => "2020-12-04"
				)
			)
		);                                                                
		$data_string = json_encode($data);  

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => "http://api.sandbox.flyhub.com/api/v1/AirSearch",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => $data_string,
		  CURLOPT_HTTPHEADER => array(
		    "authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1bmlxdWVfbmFtZSI6InN1bm5vYmFwcHlAZ21haWwuY29tIiwiaHR0cDovL3NjaGVtYXMubWljcm9zb2Z0LmNvbS93cy8yMDA4LzA2L2lkZW50aXR5L2NsYWltcy91c2VyZGF0YSI6IjIxNHwyMzF8IiwibmJmIjoxNjA0MjIwMDk1LCJleHAiOjE2MDQ4MjQ4OTUsImlhdCI6MTYwNDIyMDA5NSwiaXNzIjoiaHR0cDovLzE4LjE0MS4xMzcuMTczOjUwMDUiLCJhdWQiOiJhcGkuc2FuZGJveC5mbHlodWIuY29tIn0.TwuGYRvFNWs-GYNpRwMP8i3rOlZkEYQ7UC7E0SCsWEo",
		    "cache-control: no-cache",
		    "content-type: application/json",
		    "postman-token: 6647a567-2de2-37da-4325-e03755233b0c",
		  ),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
		  return $response;
		}

});
