<?php

namespace App\Http\Services;



class MinorsDeceased
{

    public static function search($dni, $captcha, $cookie)
    {
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
