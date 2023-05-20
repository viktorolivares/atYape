<?php

namespace App\Http\Services;



class Deceased
{

    public static function search($dni, $captcha, $cookie)
    {

        if (!$captcha || !$dni) {

            return [
                "success" => false,
                "msg" => "Debe ingresar el captcha y el DNI."
            ];
        }

        if (strlen($dni) !== 8) {
            return [
                "success" => false,
                "message" => "DNI debe contener 8 dígitos."
            ];
        }


        if (!$cookie) {

            return [
                "success" => false,
                "msg" => 'Actualizar la página'
            ];
        }


        $url = 'https://serviciosbiometricos.reniec.gob.pe/appConsultaHuellas/consultar';

        $payload = array(
            'numeroDni' => $dni,
            'codigoCaptcha' => $captcha,
        );
        $headers = array(
            'Content-Type: application/json;charset=UTF-8',
            'Cookie: JSESSIONID=' . $cookie
        );
        $options = array(
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
        );

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        return $result;

    }
}