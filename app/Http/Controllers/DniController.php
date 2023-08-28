<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Storage;
use App\Http\Services\MinorsDeceased;
use App\Http\Services\DniQuery;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class DniController extends Controller {

    public function getDni(Request $request)
    {
        sleep(2);

        try {
            $request->validate([
                'dni' => 'required|size:8',
            ]);

            $dni = $request->dni;
            $data = DniQuery::searchDni($dni);

            return response()->json([
                'data' => $data
            ]);


        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        }
    }

    public function getMinorsDeceased(Request $request)
    {
        sleep(2);

        try {
            $request->validate([
                'dniMinorsDeceased' => 'required|size:8',
                'captcha' => 'required',
                'cookie' => 'required',
            ]);

            $dniMinorsDeceased = $request->dniMinorsDeceased;
            $cookie = $request->cookie;
            $captcha = $request->captcha;

            $data = MinorsDeceased::search($dniMinorsDeceased, $captcha, $cookie);

            return response()->json([
                'data' => $data
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        }
    }

    public function getCookiesCaptcha()
    {

        $client = new Client([
            'verify' => false
        ]);

        $urlCaptcha = 'https://serviciosbiometricos.reniec.gob.pe/appConsultaHuellas/captcha';
        $routeCaptcha = storage_path('app/public/captcha.jpg');

        try {

            $response = $client->get($urlCaptcha, ['sink' => $routeCaptcha]);

            $cookie_parts = explode("; ", $response->getHeader('Set-Cookie')[0]);
            $jsessionid = array_reduce($cookie_parts, function ($carry, $part) {
                return $carry ? : (strpos($part, "JSESSIONID=") === 0 ? substr($part, strlen("JSESSIONID=")) : null);
            });

            return $jsessionid ? : 'default_value_if_jsessionid_is_null';

        } catch (GuzzleException $e) {

            Log::error("Error al obtener el JSESSIONID", ['error' => $e->getMessage()]);
            return ["error" => "Error al obtener el JSESSIONID"];
        }
    }

}
