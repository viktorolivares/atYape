<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\IpConsult;
use App\Http\Services\Ip2Location;

 class IpController extends Controller
{
    public function ipConsult(Request $request)

    {
        sleep(2);

        $ip = $request->ip;

        $data = Ipconsult::search($ip);
        $test = Ip2Location::search($ip);

        return response()->json([
            'data' => $data,
            'ip' => $ip,
            'test' => $test
        ]);
    }
}
