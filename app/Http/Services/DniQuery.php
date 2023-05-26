<?php

namespace App\Http\Services;

use Peru\Jne\DniFactory;

class DniQuery
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
}
