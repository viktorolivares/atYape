<?php

namespace App\Http\Controllers;

use App\Http\Services\DomainValidation;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    public function index(Request $request) {

        $domain = $request->domain;
        $result = DomainValidation::search($domain);
        $credits = DomainValidation::credits();

        return response()->json([
            'data' => $result,
            'credits' => $credits
        ]);

    }
}
