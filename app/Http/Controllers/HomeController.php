<?php

namespace App\Http\Controllers;

use App\Services\Flyhub;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    // Search Function
    public function search()
    {
        $client = new Client();
        $request_param = array(
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
        $request_data = json_encode($request_param);
        $res = $client->request(
                    'POST',
                    url('use_your_api_url'),
                    [
                        'headers' => [
                            'Content-Type'     => 'application/json',
                            'Authorization' => 'Bearer token id'

                        ],
                        'body'   => $request_data
                    ]
                );
        return $res->getBody()->getContents();
    }

    // authenticate Function
    public function authenticate()
    {
        $client = new Client();
        $request_param = array(
            "username" => 'username',
            "password" => 'password'
        );
        $request_data = json_encode($request_param);
        $res = $client->request(
                    'POST',
                    url('use_your_api_url'),
                    [
                        'headers' => [
                            'Content-Type'     => 'application/json'

                        ],
                        'body'   => $request_data
                    ]
                );
        return $res->getBody()->getContents();
    }
}
