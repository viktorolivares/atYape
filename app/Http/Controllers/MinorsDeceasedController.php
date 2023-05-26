<?php

namespace App\Http\Controllers;

use App\Http\Services\MinorsDeceased;
use Illuminate\Http\Request;
use GuzzleHttp\Client;


class MinorsDeceasedController extends Controller
{
    public function getMinorsDeceased(Request $request)
    {
        sleep(2);

        $dni = $request->dni;
        $cookie = $request->cookie;
        $captcha = $request->captcha;

        $data = MinorsDeceased::search($dni, $captcha, $cookie);

        return response()->json([
            'data' => $data
        ]);
    }


    public function getCookiesCaptcha()
    {
        $client = new Client();
        $urlCaptcha = 'https://serviciosbiometricos.reniec.gob.pe/appConsultaHuellas/captcha';
        $routeCaptcha = public_path('captcha.jpg');
        $defaultSessionId = 'default_value_if_jsessionid_is_null';

        try {

            $response = $client->get($urlCaptcha, ['sink' => $routeCaptcha]);

            if ($response->hasHeader('Set-Cookie')) {
                $cookieParts = explode("; ", $response->getHeader('Set-Cookie')[0]);
                $jsessionid = array_reduce($cookieParts, function ($carry, $part) {
                    if ($carry !== null) {
                        return $carry;
                    }

                    if (strpos($part, "JSESSIONID=") === 0) {
                        return substr($part, strlen("JSESSIONID="));
                    }

                    return null;
                });

                return $jsessionid ?: $defaultSessionId;
            }

            return $defaultSessionId;

        } catch (GuzzleException $e) {

            Log::error("Error al obtener el JSESSIONID", ['error' => $e->getMessage()]);
            return ["error" => "Error al obtener el JSESSIONID"];
        }
    }
}
