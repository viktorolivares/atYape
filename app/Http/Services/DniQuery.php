<?php

namespace App\Http\Services;

use Peru\Jne\DniFactory;

class DniQuery
{
    public static function searchDni($dni)
    {

        $factory = new DniFactory();
        $cs = $factory->create();
        $person = $cs->get($dni);

        if (!$person) {
            return ([
                'dni' => $dni,
                'error' => 404
            ]);
        }

        return $person;
    }
}
