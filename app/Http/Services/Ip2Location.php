<?php

namespace App\Http\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class Ip2Location
{
    public static function search($ip)
    {
        $key = 'cb549c1421a8d8c20a332fdb17b661d2';

        $response = Http::get('https://api.ip2location.io/', [
                        'ip'      => $ip,
                        'key'     => $key,
                        'format' => 'json',
                    ]);


        $response->body();

        return $response;
    }
}
