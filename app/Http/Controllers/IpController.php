<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IpController extends Controller
{
    public function ipConsult($ip)

    {
        sleep(3);

        $data = Ipconsult::search($ip);
        $test = Ip2Location::search($ip);

        return response()->json([
            'data' => $data,
            'ip' => $ip,
            'test' => $test,
        ]);
    }
}
