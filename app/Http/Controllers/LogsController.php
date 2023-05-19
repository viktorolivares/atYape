<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Github;

class LogsController extends Controller
{
    public function github() {

        sleep(1);

        $data = Github::getLanguages();

        return response()->json([
            'data' => $data
        ]);

    }
}
