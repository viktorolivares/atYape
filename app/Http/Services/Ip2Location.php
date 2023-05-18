<?php

namespace App\Http\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class Ip2Location
{
    public static function search($ip)
    {
        $key = 'CB549C1421A8D8C20A332FDB17B661D2';

        $response = Http::get('https://api.ip2location.io/', [
                        'ip'      => $ip,
                        'key'     => $key,
                        'format' => 'json',
                    ]);


        $response = json_decode($response->getBody()->getContents(), true);

        return $response;
    }
}
