<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function index()
    {
        $sessionValues = session()->all();

        return response()->json(['data' => $sessionValues]);
    }
}
