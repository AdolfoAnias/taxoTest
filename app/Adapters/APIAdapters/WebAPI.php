<?php

namespace App\Adapters\APIAdapters;

use GuzzleHttp\Client;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class WebAPI {

    private $client;

    public function __construct($client) {
        $this->client = $client;
    }
   
    public function getUsers() {
        $response = $this->client->get("users")->getBody();
        $data = json_decode($response);
        return $data;
    }
}
