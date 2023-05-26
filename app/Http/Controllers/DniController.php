<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DniController extends Controller
{

    public function getDni(Request $request)
    {
        sleep(1);

        $dni = $request->dni;

        $data = DniQuery::searchDni($dni);

        return response()->json([
            'dni' => $dni,
            'data' => $data
        ]);
    }
}
