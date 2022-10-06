<?php

namespace App\Helpers;

use App\Adapters\APIAdapters\WebAPI;
use Carbon\Carbon;

class WebAPIHelper 
{
    private $api;

    function __construct(WebAPI $api) {
        $this->api = $api;
    }

    public function getMails() {
        return $this->api->getMails();
    }
}
