<?php

namespace App\Http\Services;

use Peru\Jne\DniFactory;
use Peru\Sunat\RucFactory;

class PeruQuery
{
    public static function searchDni($dni)
    {
        if (strlen($dni) !== 8) {
            return [
                'success' => false,
                'message' => 'DNI debe contener 8 dígitos.'
            ];
        }

        $factory = new DniFactory();

        $cs = $factory->create();

        $person = $cs->get($dni);

        if (!$person) {
            return (['error' => 404]);
        }


        return $person;
    }


    public static function searchRuc($ruc)
    {

        if (strlen($ruc) !== 11) {
            return [
                'success' => false,
                'message' => 'RUC debe contener 11 dígitos.'
            ];
        }

        $factory = new RucFactory();

        $cs = $factory->create();

        $company = $cs->get($ruc);

        if (!$company) {
            return (['error' => 404]);
        }

        return $company;
    }
}
